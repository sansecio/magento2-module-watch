<?php

namespace Sansec\Watch\Observer;

use Magento\Csp\Model\Collector\DynamicCollector;
use Magento\Csp\Model\Policy\FetchPolicyFactory;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Sansec\Watch\Model\PolicyFetcher;

class CspPolicyObserver implements ObserverInterface
{
    private DynamicCollector $dynamicCollector;
    private PolicyFetcher $policyFetcher;
    private FetchPolicyFactory $fetchPolicyFactory;

    public function __construct(
        DynamicCollector $dynamicCollector,
        PolicyFetcher $policyFetcher,
        FetchPolicyFactory $fetchPolicyFactory
    ) {
        $this->dynamicCollector = $dynamicCollector;
        $this->policyFetcher = $policyFetcher;
        $this->fetchPolicyFactory = $fetchPolicyFactory;
    }

    public function execute(Observer $observer): void
    {
        foreach ($this->policyFetcher->fetchPolicies() as $directive => $hosts) {
            $this->dynamicCollector->add($this->fetchPolicyFactory->create([
                'id' => $directive,
                'noneAllowed' => false,
                'hostSources' => $hosts
            ]));
        }
    }
}
