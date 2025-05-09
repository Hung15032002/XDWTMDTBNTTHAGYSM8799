<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Webklex\IMAP\Facades\Client;
use Illuminate\Support\Facades\Log;
use App\Models\Transaction;
use Carbon\Carbon;

class IMAPController extends Controller
{
    public function checkEmails()
    {
        try {
            // Kết nối đến Gmail IMAP
            $client = Client::account('default');
            $client->connect();

            // Mở thư mục INBOX
            $folder = $client->getFolder('INBOX');

            // Lấy tất cả email chưa đọc
            $messages = $folder->messages()->unseen()->get();

            foreach ($messages as $message) {
                $subject = $message->getSubject();    // Tiêu đề email
                $from = $message->getFrom()[0]->mail ?? '';          // Người gửi
                $body = $message->getTextBody();      // Nội dung email

                // Kiểm tra email có phải của Sacombank không
                if ($this->isSacombankEmail($from, $subject, $body)) {
                    // Nếu có liên quan, xử lý thông tin email
                    $this->handleSacombankEmail($message);
                }
            }

            return response()->json([
                'status' => 'Checked emails',
                'unseen_count' => $messages->count()
            ]);
        } catch (\Exception $e) {
            Log::error('IMAP check error: ' . $e->getMessage());

            return response()->json([
                'error' => 'Failed to check emails',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Kiểm tra email có phải từ Sacombank không
    private function isSacombankEmail($from, $subject, $body)
    {
        $sacombankEmails = ['info@sacombank.com.vn', 'ask@sacombank.com', 'support@sacombank.com.vn'];

        foreach ($sacombankEmails as $email) {
            if (strpos($from, $email) !== false) {
                return true;
            }
        }

        if (stripos($subject, 'Sacombank') !== false || stripos($body, 'Sacombank') !== false) {
            return true;
        }

        return false;
    }

    // Xử lý thông tin email Sacombank
    private function handleSacombankEmail($message)
    {
        $body = $message->getTextBody();
        $this->extractTransactionDetails($body);
    }

    // Trích xuất thông tin giao dịch từ nội dung email
    private function extractTransactionDetails($body)
    {
        preg_match('/Tài khoản\s*\/\s*Account\s*(\d+)/', $body, $accountMatch);
        preg_match('/Ngày\s*\/\s*Date\s*([\d\/:\s]+)/', $body, $dateMatch);
        preg_match('/Giao dịch\s*-\s*([-\d.,]+)/', $body, $amountMatch);
        preg_match('/Số dư khả dụng\s*\/\s*Số dư khả dụng\s*([\d.,]+)\s*VNĐ/', $body, $balanceMatch);
        preg_match('/Nội dung\s*\/\s*Mô tả\s*(.+)/', $body, $descMatch);

        if ($accountMatch && $dateMatch && $amountMatch && $balanceMatch && $descMatch) {
            // Lưu thông tin giao dịch vào cơ sở dữ liệu
            Transaction::create([
                'account_number' => $accountMatch[1],
                'transaction_date' => Carbon::createFromFormat('d/m/Y H:i', trim($dateMatch[1])),
                'amount' => (float) str_replace(['.', ','], ['', '.'], $amountMatch[1]),
                'balance' => (float) str_replace(['.', ','], ['', '.'], $balanceMatch[1]),
                'description' => trim($descMatch[1]),
            ]);

            Log::info("Giao dịch đã được lưu thành công.");
        } else {
            Log::warning("Không thể trích xuất đầy đủ thông tin giao dịch từ email.");
        }
    }

    // Trả về danh sách giao dịch cho view
    public function getTransactions()
    {
        $transactions = Transaction::all();

        return view('admin.transactions.list', compact('transactions'));
    }


    public function testConnection()
    {
        try {
            // Kết nối đến Gmail IMAP
            $client = Client::account('default');
            $client->connect();

            // Kiểm tra kết nối với folder INBOX
            $folder = $client->getFolder('INBOX');

            // Lấy tất cả email chưa đọc
            $messages = $folder->messages()->unseen()->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Kết nối thành công!',
                'unseen_count' => $messages->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không thể kết nối đến Gmail IMAP: ' . $e->getMessage()
            ], 500);
        }
    }
}
