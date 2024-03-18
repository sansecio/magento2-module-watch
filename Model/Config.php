<?php

namespace Sansec\Cspmon\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\RequestInterface;

class Config
{
    private const CONFIG_PATH_ENDPOINT    = 'cspmon/settings/endpoint';
    private const CONFIG_PATH_SAMPLE_RATE = 'cspmon/settings/sample_rate';

    private ?bool $shouldReport;
    private ScopeConfigInterface $scopeConfig;
    private RequestInterface $request;

    public function __construct(RequestInterface $request, ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
        $this->request = $request;

        $this->shouldReport = $this->isCheckout() && $this->isSample();
    }

    private function isSample(): bool
    {
        $sampleRate = (int) $this->scopeConfig->getValue(self::CONFIG_PATH_SAMPLE_RATE);
        return rand(1, 100) <= $sampleRate;
    }

    private function isCheckout(): bool
    {
        return strpos($this->request->getModuleName() ?? '', 'checkout') !== false;
    }

    public function shouldReport(): bool
    {
        return $this->shouldReport;
    }

    public function getCspEndpoint(): string
    {
        return $this->scopeConfig->getValue(self::CONFIG_PATH_ENDPOINT);
    }
}
