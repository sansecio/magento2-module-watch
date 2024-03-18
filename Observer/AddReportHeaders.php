<?php

namespace Sansec\Cspmon\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Sansec\Cspmon\Model\Config;

class AddReportHeaders implements ObserverInterface
{
    private Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function execute(Observer $observer)
    {
        $response = $observer->getEvent()->getData('response');
        if (!$this->config->shouldReport()) {
            return;
        }

        $response->setHeader(
            'Reporting-Endpoints',
            sprintf('csp-endpoint=\'%s\'', $this->config->getCspEndpoint()),
            true
        );

        $response->setHeader(
            'Content-Security-Policy-Report-Only',
            'script-src \'none\'; connect-src \'none\'; report-to csp-endpoint',
            true
        );
    }
}
