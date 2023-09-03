<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('earnings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // ID of the site manager (you)
            $table->unsignedBigInteger('from'); // ID of the user who initiated the earning
            $table->decimal('amount', 10, 2); // Earning amount
            $table->decimal('total_amount', 10, 2); // Total accumulated earnings
            $table->string('description')->nullable(); // Earning description (optional)
            $table->string('type')->nullable(); // Earning type (optional)
            $table->timestamps();

            // Define foreign keys
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('from')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('earnings');
    }
};
