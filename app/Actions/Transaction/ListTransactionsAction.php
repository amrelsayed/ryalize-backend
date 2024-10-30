<?php

namespace App\Actions\Transaction;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ListTransactionsAction
{
    public function execute(array $filters): LengthAwarePaginator
    {
        $query = Transaction::query();

        // filter query
        if (!empty($filters["user_id"])) {
            $query->where('user_id', $filters['user_id']);
        }

        if (!empty($filters["amount_from"])) {
            $query->where("transaction_amount", '>=', $filters['amount_from']);
        }

        if (!empty($filters['amount_to'])) {
            $query->where("transaction_amount", '<=', $filters['amount_to']);
        }

        if (!empty($filters['date_from'])) {
            $query->where("transaction_date", '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->where("transaction_date", '<=', $filters['date_to']);
        }

        if (!empty($filters['location_id'])) {
            $query->whereHas("location", function ($query) use ($filters) {
                $query->where("id", $filters['location_id']);
            });
        }

        // order by latest load relations
        $query->orderBy('id', 'desc')
            ->with(['user', 'location']);

        return $query->paginate($filters['per_page'] ?? 15);
    }
}