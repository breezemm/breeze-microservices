<?php

use Illuminate\Http\JsonResponse;
use JetBrains\PhpStorm\ArrayShape;

if (!function_exists('json_response')) {
    function json_response($status, $message, $data = null): JsonResponse
    {
        return response()->json([
            'meta' => [
                'status' => $status,
                'msg' => $message
            ],
            'data' => $data
        ]);
    }
}

if (!function_exists('createPayload')) {

    function createPayload(
        string $topic,
        #[ArrayShape(["cmd" => "string"])]
        array  $pattern,
        array  $data,
    ): string
    {
        return json_encode(
            [
                'id' => Str::uuid(),
                'topic' => $topic,
                'pattern' => $pattern,
                'data' => $data,
            ]
        );
    }
}
