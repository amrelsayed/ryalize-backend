<?php

namespace App\Http\Controllers;

use App\Actions\Transaction\ListTransactionsAction;
use App\Http\Resources\TransactionResource;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/transactions/",
     *     summary="List transactions",
     *     tags={"Transaction"},
     *     security={{"sanctumAuth": {}}},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         description="User id",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="amount_from",
     *         in="path",
     *         description="Transaction amount from value",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="amount_to",
     *         in="path",
     *         description="Transaction amount to value",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="date_from",
     *         in="path",
     *         description="Transaction date from value",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="date_to",
     *         in="path",
     *         description="Transaction date to value",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Transactions data"),
     *     @OA\Response(response="500", description="Errors")
     * )
     */
    public function index(Request $request, ListTransactionsAction $listTransactionsAction)
    {
        $data = $listTransactionsAction->execute($request->all());

        return TransactionResource::collection($data);
    }
}
