<?php

namespace Sansec\Cmon\Model;

class Config
{
    public function shouldReportToSansec(): bool
    {
        return true; // dev

        // TODO: pull this from config
        return rand(1, 100) === 1;
    }

    public function getSansecReportUri(): ?string
    {
        // TODO: pull this from config
        return 'http://localhost:3000/report/511679bd-6fe2-4ca7-9b13-cde0d40cbcbd';
    }
}
