<?php

namespace Sansec\Cspmon\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

class Config
{
    private const CONFIG_PATH_ENABLED     = 'system/cspmon/enabled';
    private const CONFIG_PATH_ENDPOINT    = 'system/cspmon/endpoint';
    private const CONFIG_PATH_SAMPLE_RATE = 'system/cspmon/sample_rate';
    private const CONFIG_PATH_DIRECTIVES  = 'cspmon/directives';

    private ?bool $shouldReport;
    private ScopeConfigInterface $scopeConfig;

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
        $this->shouldReport =
            $this->isEnabled() &&
            $this->isSample()
            $this->getEndpoint() !== null;
    }

    private function isSample(): bool
    {
        $sampleRate = (int) $this->scopeConfig->getValue(self::CONFIG_PATH_SAMPLE_RATE);
        return rand(1, 100) <= $sampleRate;
    }

    private function isEnabled(): bool
    {
        return (bool) $this->scopeConfig->getValue(self::CONFIG_PATH_ENABLED);
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
