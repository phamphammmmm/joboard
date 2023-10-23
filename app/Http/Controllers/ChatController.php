<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ChatController extends Controller
{
    public function index()
    {
        return view('chat');
    }

    public function sendMessage(Request $request)
    {
        $userMessage = $request->input('message');

        // Gửi yêu cầu API đến OpenAI
        $client = new Client();
        $response = $client->post('https://api.openai.com/v1/engines/davinci/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'prompt' => $userMessage,
                'max_tokens' => 150,
            ],
        ]);

        $responseBody = json_decode($response->getBody(), true);
        $aiResponse = $responseBody['choices'][0]['text'];

        return response()->json(['message' => $aiResponse]);
    }
}