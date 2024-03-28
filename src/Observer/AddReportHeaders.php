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

    private function getReportPolicy(): string
    {
        $directivePolicies = [];
        foreach ($this->config->getDirectives() as $directive) {
            $directivePolicies[] = sprintf(
                "%s '%s';",
                $directive['name'],
                implode("' '", explode(',', $directive['allowed_sources'] ?? []))
            );
        }
        return implode(' ', $directivePolicies);
    }

    public function execute(Observer $observer)
    {
        if (!$this->config->shouldReport()) {
            return;
        }
        $response = $observer->getEvent()->getData('response');
        $response->setHeader(
            "Reporting-Endpoints",
            sprintf('csp-endpoint="%s"', $this->config->getEndpoint()),
            true
        );
        $response->setHeader(
            "Content-Security-Policy-Report-Only",
            sprintf("%s report-to csp-endpoint", $this->getReportPolicy()),
            true
        );
    }
}
