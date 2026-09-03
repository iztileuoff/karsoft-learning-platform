<?php

return [
    'api_key'               => env('GEMINI_API_KEY', ''),
    'model'                 => env('GEMINI_MODEL', 'gemini-2.0-flash'),
    'endpoint'              => env('GEMINI_ENDPOINT', 'https://generativelanguage.googleapis.com/v1beta/models'),
    'timeout'               => (int) env('GEMINI_TIMEOUT', 60),
    'context_messages_limit' => (int) env('GEMINI_CONTEXT_LIMIT', 40),
    'system_prompt'         => env('GEMINI_SYSTEM_PROMPT', 'Siz yordamchi AI assistantsiz. Savolga aniq va qisqa javob bering.'),
    'history_months'        => (int) env('GEMINI_HISTORY_MONTHS', 1),
];
