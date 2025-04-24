<?php

namespace App\Lib;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\ConnectionException;

class ApiHandler
{
    protected $apiUrl;
    protected $apiKey;

    public function __construct()
    {
        // Get API URL and API Key from .env
        $this->apiUrl = env('API_ENDPOINT_URL');
        $this->apiKey = env('API_KEY');
    }

    /**
     * Make an HTTP request to an external API using Laravel's HTTP client
     * 
     * @param string $endpoint The API endpoint (relative to base URL)
     * @param array $data Data to send in the request (body)
     * @param string $method HTTP method (GET, POST, PUT, DELETE)
     * @return array|string Response from the API or error details
     */
    public function callAPI($endpoint, $data = [], $method = 'POST')
    {
        $url = $this->apiUrl . $endpoint;

        // Set HTTP headers
        $headers = [
            'Content-Type' => 'application/json',
            'ApiKey' => $this->apiKey,
        ];

        // Make the request based on the HTTP method
        try {
            switch (strtoupper($method)) {
                case 'POST':
                    $response = Http::withHeaders($headers)->withoutVerifying()->post($url, $data);
                    break;

                case 'PUT':
                    $response = Http::withHeaders($headers)->withoutVerifying()->put($url, $data);
                    break;

                case 'DELETE':
                    $response = Http::withHeaders($headers)->withoutVerifying()->delete($url);
                    break;

                case 'GET':
                default:
                    $response = Http::withHeaders($headers)->withoutVerifying()->get($url, $data);
                    break;
            }

            // Check if the request was successful
            if ($response->successful()) {
                return $response->json();
            }

            // If the request failed, return the status and message
            return [
                'errorCode' => $response->status(),
                'errorMessage' => $response->body(),
            ];
        } catch (ConnectionException $e) {
            // Handle connection errors (like could not resolve host)
            return [
                'errorCode' => 0, // You can set this to a specific code if needed
                'errorMessage' => 'Could not connect to the API. Please check your network connection.',
            ];
        } catch (RequestException $e) {
            // Handle other HTTP exceptions
            return [
                'errorCode' => 0, // You can set this to a specific code if needed
                'errorMessage' => 'Something went wrong, try again after some time.',
            ];
        } catch (\Exception $e) {
            // Handle any other exceptions that may occur
            return [
                'errorCode' => 0, // You can set this to a specific code if needed
                'errorMessage' => 'An unexpected error occurred: ' . $e->getMessage(),
            ];
        }
    }
}
