<?php

namespace App\Http\Controllers;

use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        // \DB::enableQueryLog();
        $query = Transaction::query();

        // filter query
        if ($request->has("user_id")) {
            $query->where('user_id', $request->id);
        }

        if ($request->has("amount_from")) {
            $query->where("transaction_amount", '>=', $request->amount_from);
        }

        if ($request->has("amount_to")) {
            $query->where("transaction_amount", '<=', $request->amount_to);
        }

        if ($request->has("date_from")) {
            $query->where("transaction_date", '>=', $request->date_from);
        }

        if ($request->has("date_to")) {
            $query->where("transaction_date", '<=', $request->date_to);
        }

        if ($request->has("location_id")) {
            $query->whereHas("location", function ($query) use ($request) {
                $query->where("id", $request->location_id);
            });
        }

        // load relations
        $query->with(['user', 'location']);

        // dd(\DB::getQueryLog());
        return TransactionResource::collection($query->paginate($request->per_page ?? 15));
    }
}
