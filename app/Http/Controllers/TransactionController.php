<?php

namespace App\Http\Controllers;

use App\Actions\Transaction\ListTransactionsAction;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request, ListTransactionsAction $listTransactionsAction)
    {
        $data = $listTransactionsAction->execute($request->all());

        return TransactionResource::collection($data);
    }
}
