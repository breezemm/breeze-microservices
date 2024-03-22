<?php

use Illuminate\Http\JsonResponse;

if (! function_exists('json_response')) {
    function json_response($status, $message, $data = null): JsonResponse
    {
        return response()->json([
            'meta' => [
                'status' => $status,
                'msg' => $message,
            ],
            'data' => $data,
        ]);
    }
}

if (! function_exists('createKafkaPayload')) {

    function createKafkaPayload(
        string $topic,
        mixed $pattern,
        array $data,
    ): array {
        return [
            'id' => Str::uuid(),
            'topic' => $topic,
            'pattern' => $pattern,
            'data' => $data,
        ];

    }
}
