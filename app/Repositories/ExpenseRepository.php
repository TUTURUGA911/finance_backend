<?php

namespace App\Repositories;

use App\Models\Expense;
use Illuminate\Database\Eloquent\Collection;

class ExpenseRepository
{
    public function all(): Collection
    {
        return Expense::orderBy('date', 'desc')->get();
    }

    public function create(array $data): Expense
    {
        return Expense::create($data);
    }

    public function update(Expense $expense, array $data): Expense
    {
        $expense->update($data);
        return $expense;
    }

    public function delete(Expense $expense): void
    {
        $expense->delete();
    }

    public function totalAmount(): float
    {
        return (float) Expense::sum('amount');
    }
}
