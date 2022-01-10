<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use SendCloud\Infrastructure\Interfaces\Required\Configuration;

/**
 * Class IndexController
 *
 * @package App\Http
 */
class IndexController
{
    /**
     * @var Configuration $configurationService
     */
    private Configuration $configurationService;

    /**
     * IndexController constructor.
     * @param Configuration $configurationService
     */
    public function __construct(Configuration $configurationService)
    {
        $this->configurationService = $configurationService;
    }

    /**
     * Redirects user to Sendcloud home page
     *
     * @return RedirectResponse
     */
    public function index(): RedirectResponse
    {
        return redirect($this->configurationService->getSendCloudPanelUrl());
    }
}
