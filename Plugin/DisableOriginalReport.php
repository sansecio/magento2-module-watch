<?php

namespace Sansec\Watch\Plugin;

use Magento\Csp\Observer\Render;
use Magento\Framework\Event\Observer;
use Sansec\Watch\Model\Config;

class DisableOriginalReport
{
    private Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function aroundExecute(Render $subject, callable $proceed, Observer $observer): void
    {
        if ($this->config->shouldReport()) {
            return;
        }
        $proceed($observer);
    }
}
