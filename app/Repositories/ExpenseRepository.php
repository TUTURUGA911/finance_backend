<?php

namespace App\Repositories;

use App\Models\Expense;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class ExpenseRepository
{
    public function all(): Collection
    {
        return Expense::where('user_id', Auth::id())
            ->orderBy('date', 'desc')
            ->get();
    }

    public function find(int $id): Expense
    {
        return Expense::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
    }

    public function create(array $data): Expense
    {
        return Expense::create($data);
    }

    public function update(int $id, array $data): Expense
    {
        $Expense = $this->find($id);
        $Expense->update($data);
        return $Expense;
    }

    public function delete(int $id): void
    {
        $Expense = $this->find($id);
        $Expense->delete();
    }

    public function totalAmount(): float
    {
        return (float) Expense::where('user_id', Auth::id())->sum('amount');
    }
}
