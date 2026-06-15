<?php
// app/Http/Controllers/AIAgentController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\AIAgentService;

class AIAgentController extends Controller {
    private AIAgentService $aiService;

    public function __construct(AIAgentService $aiService) {
        $this->aiService = $aiService;
    }

    public function chat(Request $request) {
        $request->validate([
            'message' => 'required|string|max:1000',
            'history' => 'array',
            'session_id' => 'required|string',
        ]);

        $messages = [];

        // Add conversation history
        foreach ($request->history ?? [] as $msg) {
            if (isset($msg['role']) && isset($msg['content'])) {
                $messages[] = ['role' => $msg['role'], 'content' => $msg['content']];
            }
        }

        // Add new user message
        $messages[] = ['role' => 'user', 'content' => $request->message];

        $response = $this->aiService->chat(
            $messages,
            Auth::id(),
            $request->session_id
        );

        // Clean AI response (remove MOOD_DATA line from display)
        if (isset($response['message'])) {
            $response['message'] = preg_replace('/\nMOOD_DATA:[^\n]*/', '', $response['message']);
            $response['display_message'] = $this->formatMessage($response['message']);
        }

        return response()->json($response);
    }

    public function greeting() {
        $greeting = $this->aiService->getGreeting();
        return response()->json($greeting);
    }

    private function formatMessage(string $message): string {
        // Convert **bold** to <strong>
        $message = preg_replace('/\*\*([^*]+)\*\*/', '<strong>$1</strong>', $message);
        // Convert *italic*
        $message = preg_replace('/\*([^*]+)\*/', '<em>$1</em>', $message);
        // Convert numbered lists
        $message = preg_replace('/^\d+\. /m', '• ', $message);
        // Convert newlines
        $message = nl2br($message);
        return $message;
    }
}
