<?php

namespace Sansec\Watch\Model;

use Magento\Config\Model\ResourceModel\Config\Data\CollectionFactory as ConfigCollectionFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\Config\CacheInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Serialize\Serializer\Json;

class Config
{
    private const string CONFIG_PATH_WATCH_POLICY  = 'sansec/watch/policy';
    private const string CONFIG_PATH_WATCH_API_URL = 'sansec/watch/api_url';

    private Json $jsonSerializer;
    private WriterInterface $writer;
    private ConfigCollectionFactory $configCollectionFactory;
    private ScopeConfigInterface $config;
    private CacheInterface $cache;

    public function __construct(
        WriterInterface $writer,
        ConfigCollectionFactory $configCollectionFactory,
        ScopeConfigInterface $config,
        Json $jsonSerializer
    ) {
        $this->writer = $writer;
        $this->jsonSerializer = $jsonSerializer;
        $this->configCollectionFactory = $configCollectionFactory;
        $this->config = $config;
    }

    public function getPolicy(): array
    {
        $config = $this->configCollectionFactory->create()
            ->addFieldToFilter('path', ['eq' => self::CONFIG_PATH_WATCH_POLICY]);

        if ($config->count() === 0) {
            return [];
        }

        return $this->jsonSerializer->unserialize($config->getFirstItem()->getData('value'));
    }

    public function setPolicy(array $policy): void
    {
        $this->writer->save(self::CONFIG_PATH_WATCH_POLICY, $this->jsonSerializer->serialize($policy));
    }

    public function getApiUrl(): string
    {
        if ($url = $this->config->getValue(self::CONFIG_PATH_WATCH_API_URL)) {
            return $url;
        }

        $reportUri = $this->config->getValue('csp/mode/storefront/report_uri');
        if (strlen($reportUri) === 0) {
            throw new LocalizedException(__('Storefront report URI is not configured.'));
        }

        return rtrim($reportUri, '/') . '/api/magento';
    }
}
