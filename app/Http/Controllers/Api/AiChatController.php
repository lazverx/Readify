<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\LibrarianAiService;
use Illuminate\Http\Request;

class AiChatController extends Controller
{
    protected LibrarianAiService $aiService;

    public function __construct(LibrarianAiService $aiService)
    {
        $this->aiService = $aiService;
    }

    /**
     * Endpoint untuk berinteraksi dengan AI Pustakawan Readify
     */
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'history' => 'nullable|array',
            'history.*.role' => 'nullable|string|in:user,assistant',
            'history.*.content' => 'nullable|string|max:1000',
        ]);

        $userMessage = $request->input('message');
        $history = $request->input('history', []);

        $result = $this->aiService->chat($userMessage, $history);

        return response()->json([
            'status' => 'success',
            'reply' => $result['reply'],
            'books' => $result['books'] ?? [],
        ]);
    }
}
