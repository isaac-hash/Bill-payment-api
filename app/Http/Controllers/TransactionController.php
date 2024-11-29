<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // Get all transactions for the authenticated user
    public function index()
    {
        $transactions = auth()->user()->transactions()->latest()->get();

        return response()->json(['transactions' => $transactions], 200);
    }

    // Get a specific transaction by ID
    public function show($id)
    {
        $transaction = auth()->user()->transactions()->findOrFail($id);

        return response()->json(['transaction' => $transaction], 200);
    }
}
