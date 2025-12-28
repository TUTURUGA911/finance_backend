<?php

namespace App\Repositories;

use App\Models\Income;
use Illuminate\Database\Eloquent\Collection;

class IncomeRepository
{
    public function all(): Collection
    {
        return Income::orderBy('date', 'desc')->get();
    }

    public function create(array $data): Income
    {
        return Income::create($data);
    }

    public function update(Income $income, array $data): Income
    {
        $income->update($data);
        return $income;
    }

    public function delete(Income $income): void
    {
        $income->delete();
    }

    public function totalAmount(): float
    {
        return (float) Income::sum('amount');
    }
}
