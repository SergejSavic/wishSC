<?php

namespace App\Services\Business\Router;

/**
 * Class RouterService
 * @package App\Services\Business\Router
 */
class RouterService
{
    /**
     * @param string $route
     * @param array $params
     * @return string
     */
    public static function getRedirectUrl(string $route, array $params): string
    {
        $url = config('app.env') === 'local' ? config('app.url') . "/sendcloud/$route" : route("sendcloud.$route");

        return $url . '?' . http_build_query($params);
    }
}
