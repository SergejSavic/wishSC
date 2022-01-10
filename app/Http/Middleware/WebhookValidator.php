<?php

namespace App\Http\Middleware;

use App\Exceptions\UnauthorizedException;
use Closure;
use Illuminate\Http\Request;
use SendCloud\Infrastructure\Interfaces\Required\Configuration;

/**
 * Class WebhookValidator
 * @package App\Http\Middleware
 */
class WebhookValidator
{
    private Configuration $configService;

    /**
     * SendCloudContextValidator constructor.
     *
     * @param Configuration $configService
     */
    public function __construct(Configuration $configService)
    {
        $this->configService = $configService;
    }

    /**
     * Handles an incoming request
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     * @throws UnauthorizedException
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $this->verify($request);

        return $next($request);
    }

    /**
     * Verifies merchant id
     *
     * @param Request $request
     *
     * @throws UnauthorizedException
     */
    private function verify(Request $request): void
    {
        $hash = $this->compute_hash(config('services.wish.client_secret'), $request->get('data'));
        $isEqualToSecret = $this->hash_is_valid(config('services.wish.client_secret'), $request->get('data'), $hash);

        if (!$isEqualToSecret || !$request->header('Wish-Merchant-Id')) {
            throw new UnauthorizedException('Context missing in url', 400);
        }

        $this->configService->setContext($request->header('Wish-Merchant-Id'));
    }

    /**
     * @param $secret
     * @param $payload
     * @return string
     */
    private function compute_hash($secret, $payload): string
    {
        $hexHash = hash_hmac('sha256', $payload, utf8_encode($secret));
        return base64_encode(hex2bin($hexHash));
    }

    /**
     * @param $secret
     * @param $payload
     * @param $verify
     * @return bool
     */
    private function hash_is_valid($secret, $payload, $verify): bool
    {
        $computed_hash = $this->compute_hash($secret, $payload);
        return hash_equals($verify, $computed_hash);
    }
}
