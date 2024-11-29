<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    public function balance()
    {
        $wallet = auth()->user()->wallet;

        return response()->json(['balance' => $wallet->balance], 200);
    }

    public function fund(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        DB::transaction(function () use ($validated) {
            $wallet = auth()->user()->wallet;
            $wallet->adjustBalance($validated['amount']);
        });

        return response()->json(['message' => 'Wallet funded successfully!'], 200);
    }
}
