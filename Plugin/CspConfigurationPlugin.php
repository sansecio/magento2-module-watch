<?php

namespace Sansec\Cmon\Plugin;

use Magento\Csp\Api\Data\ModeConfiguredInterface;
use Magento\Csp\Api\ModeConfigManagerInterface;
use Magento\Csp\Model\Mode\Data\ModeConfigured;
use Sansec\Cmon\Model\Config;

class CspConfigurationPlugin
{
    public function __construct(private readonly Config $config) {}

    // It would be more preferable to use a plugin on ModeConfiguredInterface,
    // but that class is instantiated using new instead of the object manager.
    public function afterGetConfigured(ModeConfigManagerInterface $subject, ModeConfiguredInterface $result): ModeConfiguredInterface
    {
        if (!$this->config->shouldReportToSansec()) {
            return $result;
        }

        return new ModeConfigured(
            true, // report only
            $this->config->getSansecReportUri()
        );
    }
}
