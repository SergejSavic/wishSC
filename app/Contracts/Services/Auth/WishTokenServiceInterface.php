<?php

namespace App\Contracts\Services\Auth;

interface WishTokenServiceInterface
{
    /**
     * Get valid access token
     *
     * @return string
     */
    public function getAccessToken(): string;
}