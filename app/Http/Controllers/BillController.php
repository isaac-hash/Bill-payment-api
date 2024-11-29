<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:airtime,electricity,data',
            'amount' => 'required|numeric|min:1',
            'meta' => 'nullable|array',
        ]);

        DB::transaction(function () use ($validated) {
            $wallet = auth()->user()->wallet;

            // Deduct wallet balance with locking
            $wallet->adjustBalance(-$validated['amount']);

            // Log the bill
            $bill = Bill::create([
                'user_id' => auth()->id(),
                'type' => $validated['type'],
                'amount' => $validated['amount'],
                'reference' => uniqid('bill_'),
                'meta' => $validated['meta'] ?? null,
                'status' => 'success',
            ]);

            // Log the transaction
            Transaction::create([
                'user_id' => auth()->id(),
                'wallet_id' => $wallet->id,
                'type' => 'debit',
                'amount' => $validated['amount'],
                'description' => "Bill payment: {$validated['type']}",
            ]);
        });

        return response()->json(['message' => 'Bill payment successful!'], 201);
    }
}

