<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Google\Client as GoogleClient;
use Google\Service\Gmail;
use App\Models\Transaction;

class GmailController extends Controller
{
    public function redirectToGoogle()
    {
        $client = new GoogleClient();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(route('gmail.callback'));
        $client->addScope(Gmail::GMAIL_READONLY);
        $client->setAccessType('offline');
        $client->setPrompt('consent');

        return redirect()->away($client->createAuthUrl());
    }

    public function handleGoogleCallback(Request $request)
    {
        $client = new GoogleClient();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(route('gmail.callback'));

        if ($request->has('code')) {
            $token = $client->fetchAccessTokenWithAuthCode($request->get('code'));

            if (!isset($token['error'])) {
                // Lưu refresh_token nếu có
                if (!isset($token['refresh_token']) && session()->has('google_token.refresh_token')) {
                    $token['refresh_token'] = session('google_token.refresh_token');
                }

                session(['google_token' => $token]);
                return redirect()->route('gmail.list');
            } else {
                Log::error('Google auth error: ' . $token['error_description']);
                return redirect()->route('gmail.auth')->with('error', 'Google authentication failed.');
            }
        }

        return redirect()->route('gmail.auth')->with('error', 'No authorization code found.');
    }

    public function listEmails()
    {
        $token = session('google_token');
        if (!$token) {
            return redirect()->route('gmail.auth');
        }

        $userEmail = 'luongdienmat@gmail.com';
        $sender = 'info@sacombank.com.vn';
        $url = "https://www.googleapis.com/gmail/v1/users/{$userEmail}/messages?q=from:{$sender}&maxResults=30";

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token['access_token'],
            ])->get($url);

            // Nếu token hết hạn, làm mới
            if ($response->status() === 401 && isset($token['refresh_token'])) {
                $client = new GoogleClient();
                $client->setClientId(config('services.google.client_id'));
                $client->setClientSecret(config('services.google.client_secret'));
                $client->refreshToken($token['refresh_token']);
                $newToken = $client->getAccessToken();
                $newToken['refresh_token'] = $token['refresh_token'];
                session(['google_token' => $newToken]);

                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $newToken['access_token'],
                ])->get($url);
            }

            $response->throw();
            $data = $response->json();
            $transactions = [];

            if (isset($data['messages'])) {
                foreach ($data['messages'] as $message) {
                    $messageId = $message['id'];
                    $messageUrl = "https://www.googleapis.com/gmail/v1/users/{$userEmail}/messages/{$messageId}?format=full";

                    $messageResponse = Http::withHeaders([
                        'Authorization' => 'Bearer ' . session('google_token')['access_token'],
                    ])->get($messageUrl);

                    $messageResponse->throw();
                    $messageData = $messageResponse->json();

                    if (isset($messageData['payload'])) {
                        $bodyText = $this->getEmailBodyText($messageData['payload']);
                        $transactionInfo = $this->extractTransactionInfo($bodyText);
                        if ($transactionInfo) {
                            // Thêm vào mảng hiển thị
                            $transactions[] = $transactionInfo;

                            // Lưu vào database
                            $this->saveTransaction($transactionInfo);
                        }
                    }
                }
            }

            return view('admin.transactions.list', compact('transactions'));
        } catch (\Exception $e) {
            Log::error('Gmail API error: ' . $e->getMessage());
            return view('admin.transactions.list', ['transactions' => [], 'error' => 'Error fetching emails.']);
        }
    }

    public function viewEmail($id)
    {
        $token = session('google_token');
        if (!$token) {
            return redirect()->route('gmail.auth');
        }

        $userEmail = 'luongdienmat@gmail.com';

        try {
            $url = "https://www.googleapis.com/gmail/v1/users/{$userEmail}/messages/{$id}?format=full";
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token['access_token'],
            ])->get($url);

            $response->throw();
            $data = $response->json();
            $body = $this->getEmailBodyText($data['payload']);

            return view('admin.transactions.email_detail', compact('body'));
        } catch (\Exception $e) {
            Log::error('Error fetching email detail: ' . $e->getMessage());
            return redirect()->route('gmail.list')->with('error', 'Unable to fetch email.');
        }
    }

    private function getEmailBodyText($payload)
    {
        if (isset($payload['parts']) && is_array($payload['parts'])) {
            foreach ($payload['parts'] as $part) {
                if (isset($part['mimeType'], $part['body']['data'])) {
                    $decoded = base64_decode(strtr($part['body']['data'], '-_', '+/'));

                    if ($part['mimeType'] === 'text/html') {
                        return strip_tags($decoded);
                    }

                    if ($part['mimeType'] === 'text/plain') {
                        return $decoded;
                    }
                }

                if (isset($part['parts'])) {
                    $text = $this->getEmailBodyText($part);
                    if ($text) return $text;
                }
            }
        }

        if (isset($payload['body']['data'])) {
            return base64_decode(strtr($payload['body']['data'], '-_', '+/'));
        }

        return '';
    }

    private function extractTransactionInfo($bodyText)
    {
        $bodyText = strip_tags($bodyText);

        // Loại bỏ các phần cảm ơn, liên hệ, bản quyền...
        $bodyText = html_entity_decode($bodyText); // Giải mã HTML như &acirc; → â

        $patterns = [
            '/Trân trọng\s*(cảm ơn)?\s*[\/\.\:\-]*.*/iu',
            '/Thank you[\s\S]*/iu',
            '/Liên hệ.*?/iu',
            '/ask@sacombank\.com\.vn/iu',
            '/ask@.*/iu',
            '/www\.sacombank\.com\.vn/iu',
            '/©.*/iu',
            '/Ngân Hàng TMCP.*/iu',
            '/Sacombank.*/iu',
            '/Tất cả các quyền được bảo hộ.*/iu',
            '/:?\s*1800\s*5858\s*88.*?/iu',
            '/\|\s*\|.*/iu',
            '/Tín\./iu',
        ];

        foreach ($patterns as $pattern) {
            $bodyText = preg_replace($pattern, '', $bodyText);
        }

        $bodyText = preg_replace('/\s+/', ' ', $bodyText);
        $bodyText = trim($bodyText);

        $info = [];

        if (preg_match('/Tài khoản\s*\/\s*Account\s*([0-9]+)/ui', $bodyText, $m)) {
            $info['account'] = trim($m[1]);
        }

        if (preg_match('/Ngày\s*\/\s*Date\s*([0-9:\/\s]+)/ui', $bodyText, $m)) {
            $info['date'] = trim($m[1]);
        }

        if (preg_match('/Phát sinh\s*\/\s*Transaction\s*([\-+]?\s*[0-9.,]+\s*VND)/ui', $bodyText, $m)) {
            $info['transaction'] = trim(str_replace(['-', '+'], '', $m[1]));
            $info['type'] = strpos($m[1], '-') !== false ? 'out' : 'in';
        }

        if (preg_match('/Số dư khả dụng\s*\/\s*Available balance\s*([0-9.,]+\s*VND)/ui', $bodyText, $m)) {
            $info['balance'] = trim($m[1]);
        }

        if (preg_match('/Nội dung\s*\/\s*Description\s*(.+)$/ui', $bodyText, $m)) {
            $info['description'] = trim($m[1]);
        }

        return empty($info) ? null : $info;
    }

    private function saveTransaction(array $info)
    {
        // Kiểm tra và chuẩn hóa dữ liệu trước khi lưu
        if (empty($info['account']) || empty($info['date']) || empty($info['transaction'])) {
            return false;
        }

        // Chuyển định dạng ngày string sang datetime
        $transactionDate = \DateTime::createFromFormat('d/m/Y H:i:s', trim($info['date']));
        if (!$transactionDate) {
            // Thử định dạng khác hoặc lấy ngày hiện tại nếu không parse được
            $transactionDate = now();
        }

        // Lưu hoặc cập nhật giao dịch
        Transaction::updateOrCreate(
            [
                'account_number' => $info['account'],
                'transaction_date' => $transactionDate->format('Y-m-d H:i:s'),
                'amount' => $info['transaction'],
                'description' => $info['description'] ?? '',
            ],
            [
                'balance' => $info['balance'] ?? '',
            ]
        );

        return true;
    }
}
