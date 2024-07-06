<?php

namespace App\Http\Controllers;

use App\Services\AccountService;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    protected $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function index()
    {
        return view('account');
    }

    public function getAccounts()
    {
        $accounts = $this->accountService->getAllAccounts();
        return response()->json($accounts);
    }

    public function tasksUnderPrice()
    {
        $tasks = $this->accountService->getTasksUnderPrice(100);
        return response()->json($tasks);
    }

    public function viewTasksUnderPrice()
    {
        return view('tasksUnderPrice');
    }
}
