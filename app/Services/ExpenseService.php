<?php

namespace App\Services;

use App\Models\Expense;
use App\Repositories\ExpenseRepository;

class ExpenseService
{
    public function __construct(
        protected ExpenseRepository $expenseRepository
    ) {}

    public function list()
    {
        return $this->expenseRepository->all();
    }

    public function create(array $data): Expense
    {
        return $this->expenseRepository->create($data);
    }

    public function update(Expense $expense, array $data): Expense
    {
        return $this->expenseRepository->update($expense, $data);
    }

    public function delete(Expense $expense): void
    {
        $this->expenseRepository->delete($expense);
    }
}
