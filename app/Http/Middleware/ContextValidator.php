<?php

namespace App\Http\Middleware;

use App\Exceptions\UnauthorizedException;
use Closure;
use Illuminate\Http\Request;
use SendCloud\Infrastructure\Interfaces\Required\Configuration;

/**
 * Class SendCloudContextValidator
 *
 * @package App\Http\Middleware
 */
class ContextValidator
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
     * Verifies guid
     *
     * @param Request $request
     *
     * @throws UnauthorizedException
     */
    private function verify(Request $request): void
    {
        if (!$request->has('context')) {
            throw new UnauthorizedException('Context missing in url', 400);
        }

        $this->configService->setContext($request->get('context'));
        $guid = $request->get('guid');

        if ($guid !== $this->configService->getGuid()) {
            throw new UnauthorizedException('Context not authorized!', 401);
        }
    }
}