<?php

namespace App\Services;

use App\Facades\Sqids;
use App\Models\Expense;
use App\Repositories\ExpenseRepository;
use Illuminate\Support\Facades\Auth;

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
        $data['user_id'] = Auth::id();
        return $this->expenseRepository->create($data);
    }

    public function update(string $encodedId, array $data): Expense
    {
        $id = Sqids::decode($encodedId);
        return $this->expenseRepository->update($id, $data);
    }

    public function findById(int $id): Expense
    {
        return $this->expenseRepository->find($id);
    }

    public function deleteById(int $id): void
    {
        $this->expenseRepository->delete($id);
    }

    public function delete(string $encodedId): void
    {
        $id = Sqids::decode($encodedId);
        $this->expenseRepository->delete($id);
    }
}
