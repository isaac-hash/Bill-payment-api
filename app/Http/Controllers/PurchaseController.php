<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function purchase(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'type' => 'required|string', // Airtime, electricity, etc.
            'details' => 'nullable|array', // Metadata for the purchase
        ]);

        DB::transaction(function () use ($validated) {
            $wallet = auth()->user()->wallet;

            // Safely deduct the amount
            $wallet->adjustBalance(-$validated['amount']);

            // Log the transaction
            Transaction::create([
                'user_id' => auth()->id(),
                'wallet_id' => $wallet->id,
                'type' => 'debit',
                'amount' => $validated['amount'],
                'description' => "Purchase of {$validated['type']}",
            ]);
        });

        return response()->json(['message' => 'Purchase successful!'], 200);
    }
}
