<?php

namespace App\Http\Middleware;

use App\Exceptions\UnauthorizedException;
use Closure;
use Illuminate\Http\Request;
use SendCloud\Infrastructure\Interfaces\Required\Configuration;

/**
 * Class SupportValidator
 * @package App\Http\Middleware
 */
class SupportValidator
{
    /**
     * @var Configuration
     */
    private Configuration $configService;

    /**
     * SupportValidator constructor.
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
     * @return mixed
     * @throws UnauthorizedException
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $context = $request->get('context');

        if (empty($context)) {
            throw new UnauthorizedException('Forbidden.', 403);
        }

        $this->configService->setContext($context);

        return $next($request);
    }
}
