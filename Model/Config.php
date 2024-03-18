<?php

namespace Sansec\Cspmon\Model;

use Magento\Framework\App\RequestInterface;

class Config
{
    private ?bool $shouldReport;

    public function __construct(RequestInterface $request)
    {
        $this->shouldReport = strpos($request->getModuleName(), 'checkout') !== false &&
            true; // TODO: rand(1, 100) === 1 from config
    }

    public function shouldReport(): bool
    {
        return $this->shouldReport;
    }

    public function getReportUri(): ?string
    {
        // TODO: pull this from config
        return 'https://csp.rubic.nl/report/511679bd-6fe2-4ca7-9b13-cde0d40cbcbd';
    }
}
