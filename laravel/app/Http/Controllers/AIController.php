<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AIController extends Controller
{
public function improve(Request $request)
{
    $text = $request->text;

    $response = Http::withHeaders([
        'Content-Type' => 'application/json',
    ])->post(
        'https://generativelanguage.googleapis.com/v1/models/gemini-2.5-flash:generateContent?key=' . env('GEMINI_API_KEY'),
        [
            "contents" => [
                [
                    "parts" => [
                        [
                            "text" => "
You are a professional writing assistant.

TASK:
Rewrite the text below with:
- correct grammar
- improved clarity
- natural tone
- same meaning

IMPORTANT RULES:
- Return ONLY the improved text
- Do NOT add explanations
- Do NOT add introductions
- Do NOT add phrases like:
  'Here is the revised text'
  'Here’s the improved version'
  'I have corrected this'
- Output must be directly usable in a text editor

TEXT:
$text
"
                        ]
                    ]
                ]
            ]
        ]
    );

    $json = $response->json();

    // SAFE extraction
    $improved =
        $json['candidates'][0]['content']['parts'][0]['text']
        ?? $json['candidates'][0]['output']
        ?? null;

    if (!$improved) {
        return response()->json([
            'success' => false,
            'message' => 'Gemini returned empty response',
            'debug' => $json
        ]);
    }

    return response()->json([
        'success' => true,
        'text' => trim($improved)
    ]);
}
}
