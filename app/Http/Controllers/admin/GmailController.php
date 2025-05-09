<?php

namespace App\Http\Controllers\Admin;

use Google_Client;
use Google_Service_Gmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class GmailController extends Controller
{
    /**
     * Get the Google Client with OAuth authentication.
     *
     * @return Google_Client
     */
    public function getClient()
    {
        try {
            // Create a new Google Client
            $client = new Google_Client();
            $client->setApplicationName('Your Application Name');
            $client->setScopes([Google_Service_Gmail::GMAIL_READONLY]);
            $client->setAuthConfig(storage_path('app/google-client-credentials.json'));
            $client->setAccessType('offline');
            $client->setPrompt('select_account consent');

            // Path to store the access token
            $tokenPath = storage_path('app/oauth2-token.json');

            // Check if the access token exists
            if (file_exists($tokenPath)) {
                $accessToken = json_decode(file_get_contents($tokenPath), true);
                $client->setAccessToken($accessToken);
            }

            // If the access token is expired, refresh it
            if ($client->isAccessTokenExpired()) {
                if ($client->getRefreshToken()) {
                    $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                    file_put_contents($tokenPath, json_encode($client->getAccessToken()));
                } else {
                    // If no refresh token, redirect user to login
                    return redirect()->route('admin.login')->with('error', 'Access token expired, please log in again.');
                }
            }

            return $client;
        } catch (\Exception $e) {
            // Log any errors that occur while setting up the client
            Log::error('Error setting up Google Client: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to authenticate with Google: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Fetch the latest emails from the Gmail account.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchEmails()
    {
        try {
            // Get Google Client
            $client = $this->getClient();

            // Create the Gmail service
            $service = new Google_Service_Gmail($client);

            // Fetch the messages (limit to 10 emails)
            $messages = $service->users_messages->listUsersMessages('me', [
                'maxResults' => 10,
            ]);

            $emailData = [];

            // Loop through each message and fetch detailed data
            foreach ($messages->getMessages() as $message) {
                $msg = $service->users_messages->get('me', $message->getId(), ['format' => 'full']);
                
                // Get the payload and headers from the email
                $payload = $msg->getPayload();
                $headers = $payload->getHeaders();

                // Extract subject, from, and snippet from the email
                $emailDetails = [
                    'id' => $message->getId(),
                    'subject' => $this->getHeaderValue($headers, 'Subject'),
                    'from' => $this->getHeaderValue($headers, 'From'),
                    'snippet' => $msg->getSnippet(),
                ];

                // Add email details to the array
                $emailData[] = $emailDetails;
            }

            // Return the email data as JSON
            return response()->json($emailData);

        } catch (\Google_Service_Exception $e) {
            // Log API exceptions
            Log::error('Google Service Exception: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch emails: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            // Catch all other exceptions
            Log::error('General Exception: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Extract the value of a specific header from the email.
     *
     * @param array $headers
     * @param string $name
     * @return string|null
     */
    private function getHeaderValue($headers, $name)
    {
        foreach ($headers as $header) {
            if ($header->getName() === $name) {
                return $header->getValue();
            }
        }
        return null;
    }
}
