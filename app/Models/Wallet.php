<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'balance'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Safely adjust wallet balance using database locks.
     */
    public function adjustBalance($amount)
    {
        DB::transaction(function () use ($amount) {
            // Lock the wallet row for updates
            $wallet = Wallet::where('id', $this->id)->lockForUpdate()->first();

            if ($wallet->balance + $amount < 0) {
                throw new \Exception('Insufficient balance.');
            }

            $wallet->balance += $amount;
            $wallet->save();
        });
    }
}
