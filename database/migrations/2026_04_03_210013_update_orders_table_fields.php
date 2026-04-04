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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('shipping_name')->after('user_id');
            $table->string('shipping_phone')->after('shipping_name');
            $table->text('shipping_address')->after('shipping_phone');
            $table->decimal('admin_fee', 15, 2)->default(2500)->after('shipping_cost');
            $table->integer('unique_code')->after('admin_fee');
            $table->string('payment_method')->after('grand_total');
            $table->string('payment_proof')->nullable()->after('payment_method');
            $table->text('notes')->nullable()->after('payment_proof');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
