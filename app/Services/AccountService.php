<?php

namespace App\Services;

use App\Repositories\AccountRepository;

class AccountService
{
    protected $accountRepository;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function getAllAccounts()
    {
        return $this->accountRepository->getAll();
    }

    public function getTasksUnderPrice($price)
    {
        return $this->accountRepository->getTasksUnderPrice($price);
    }
}
