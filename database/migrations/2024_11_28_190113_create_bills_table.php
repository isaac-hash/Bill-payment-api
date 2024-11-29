<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->enum('type', ['airtime', 'electricity', 'data'])->index();
            $table->decimal('amount', 10, 2);
            $table->string('reference')->unique(); // Unique identifier for the bill (e.g., transaction ref)
            $table->json('meta')->nullable(); // Optional metadata (e.g., phone number, meter number)
            $table->string('status')->default('pending'); // e.g., pending, success, failed
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bills');
    }
}
