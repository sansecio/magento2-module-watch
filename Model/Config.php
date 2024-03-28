<?php

namespace Sansec\Cspmon\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

class Config
{
    private const CONFIG_PATH_ENDPOINT    = 'cspmon/settings/endpoint';
    private const CONFIG_PATH_SAMPLE_RATE = 'cspmon/settings/sample_rate';
    private const CONFIG_PATH_DIRECTIVES  = 'cspmon/directives';

    private ?bool $shouldReport;
    private ScopeConfigInterface $scopeConfig;

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
        $this->shouldReport = $this->getEndpoint() !== null && $this->isSample();
    }

    private function isSample(): bool
    {
        $sampleRate = (int) $this->scopeConfig->getValue(self::CONFIG_PATH_SAMPLE_RATE);
        return rand(1, 100) <= $sampleRate;
    }

    public function shouldReport(): bool
    {
        return $this->shouldReport;
    }

    public function getEndpoint(): ?string
    {
        return $this->scopeConfig->getValue(self::CONFIG_PATH_ENDPOINT);
    }

    public function getDirectives(): array
    {
        return $this->scopeConfig->getValue(self::CONFIG_PATH_DIRECTIVES);
    }
}
