<?php

namespace App\Repositories;

use App\Models\Income;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class IncomeRepository
{
    public function all(): Collection
    {
        return Income::where('user_id', Auth::id())
            ->orderBy('date', 'desc')
            ->get();
    }

    public function create(array $data): Income
    {
        return Income::create($data);
    }

    public function find(int $id): Income
    {
        return Income::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
    }

    public function update(int $id, array $data): Income
    {
        $income = $this->find($id);
        $income->update($data);
        return $income;
    }

    public function delete(int $id): void
    {
        $income = $this->find($id);
        $income->delete();
    }
}
