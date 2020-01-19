<?php

namespace App\Service;

use App\Repository\CompanyRepository;

class CompanyService
{
    private $companyRepository;
    private $company;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;

        $this->company = $this->companyRepository->find(1);
    }

    public function getCompany() {
        return $this->company;
    }
}