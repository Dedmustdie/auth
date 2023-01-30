<?php

class RoutesUtil
{
    private static array $routes = array();

    public static function route($pattern, $callback): void
    {
        self::$routes['/^' . str_replace('/', '\/', $pattern) . '$/'] = $callback;
    }

    public static function execute()
    {
        foreach (self::$routes as $pattern => $callback)
        {
            if (preg_match($pattern, $_SERVER['REQUEST_URI']))
            {
                return $callback();
            }
        }
        NetUtil::sendError(NOT_FOUND_CODE, "Method not found");
    }
}