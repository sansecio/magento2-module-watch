<?php

namespace Sansec\Watch\Console\Command;

use Magento\Framework\Config\CacheInterface;
use Magento\Framework\Exception\LocalizedException;
use Sansec\Watch\Model\ApiClient;
use Sansec\Watch\Model\Config;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SyncCommand extends Command
{
    private ApiClient $client;
    private Config $config;
    private CacheInterface $cache;

    public function __construct(
        ApiClient $client,
        Config $config,
        CacheInterface $cache,
        ?string $name = null
    ) {
        parent::__construct($name);
        $this->client = $client;
        $this->config = $config;
        $this->cache = $cache;
    }

    protected function configure(): void
    {
        $this->setName('sansec:watch:sync')->setDescription('Synchronizes CSP with Sansec Watch');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $policies = $this->client->getPolicy();
            $this->config->setPolicy($policies);
            $this->cache->remove('global::csp_whitelist_config');
        } catch (LocalizedException $e) {
            $output->writeln($e->getMessage());
            return 1;
        }
        return 0;
    }
}
