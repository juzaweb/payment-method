<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(
            'payment_method_payment_histories',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->morphs('module');
                $table->string('payment_id', 150);
                $table->string('payment_method', 50);
                $table->string('status', 50)->default('success');
                $table->json('data')->nullable();
                $table->float('amount');
                $table->timestamps();

                $table->foreignId('user_id')
                    ->constrained('users')
                    ->onDelete('cascade');
                $table->index(['module_type']);
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_method_payment_histories');
    }
};
