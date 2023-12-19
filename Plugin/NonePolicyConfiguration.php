<?php

namespace Sansec\Cmon\Plugin;

use Magento\Csp\Api\Data\PolicyInterface;
use Magento\Csp\Model\Collector\Config\FetchPolicyReader;
use Magento\Csp\Model\Policy\FetchPolicy;
use Sansec\Cmon\Model\Config;

class NonePolicyConfiguration
{
    // TODO: exfil via img-src etc
    private const reportedPolicies = ['connect-src', 'script-src'];

    public function __construct(private readonly Config $config) {}

    public function afterRead(FetchPolicyReader $subject, PolicyInterface $result, string $id, $value): PolicyInterface
    {
        if (!$this->config->shouldReportToSansec()) {
            return $result;
        }

        if (!in_array($id, self::reportedPolicies)) {
            return $result;
        }

        /** @var $result FetchPolicy */
        return new FetchPolicy(
            $id,
            true, // only change, nothing is allowed
            $result->getHostSources(),
            $result->getSchemeSources(),
            $result->isSelfAllowed(),
            $result->isInlineAllowed(),
            $result->isEvalAllowed(),
            [],
            [],
            $result->isDynamicAllowed(),
            $result->areEventHandlersAllowed()
        );
    }
}
