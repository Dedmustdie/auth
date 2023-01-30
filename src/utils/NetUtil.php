<?php

class NetUtil
{
    public static function sendError($errorCode, $message)
    {
        http_response_code($errorCode);
        die(json_encode(['message' => $message]));
    }

    public static function sendSuccess($successCode, $message)
    {
        http_response_code($successCode);
        echo json_encode(['message' => $message]);
    }
}