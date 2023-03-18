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
        Schema::table(
            'payment_methods',
            function (Blueprint $table) {
                $table->string('module', 50)->default('ecommerce');
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
        Schema::table(
            'payment_methods',
            function (Blueprint $table) {
                $table->dropColumn('module');
            }
        );
    }
};
