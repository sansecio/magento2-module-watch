<?php

namespace Sansec\Watch\Observer;

use Magento\Csp\Model\Collector\DynamicCollector;
use Magento\Csp\Model\Policy\FetchPolicyFactory;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Sansec\Watch\Model\Config;
use Sansec\Watch\Model\PolicyFetcher;

class CspPolicyObserver implements ObserverInterface
{
    private DynamicCollector $dynamicCollector;
    private FetchPolicyFactory $fetchPolicyFactory;
    private Config $config;

    public function __construct(
        DynamicCollector $dynamicCollector,
        FetchPolicyFactory $fetchPolicyFactory,
        Config $config
    ) {
        $this->dynamicCollector = $dynamicCollector;
        $this->fetchPolicyFactory = $fetchPolicyFactory;
        $this->config = $config;
    }

    public function execute(Observer $observer): void
    {
        foreach ($this->config->getPolicy() as $policy) {
            $this->dynamicCollector->add($this->fetchPolicyFactory->create([
                'id' => $policy['directive'],
                'noneAllowed' => false,
                'hostSources' => [$policy['host']]
            ]));
        }
    }
}
