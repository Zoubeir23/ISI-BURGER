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
            $table->string('order_number')->nullable()->unique()->after('id');
        });

        // Rétroactivement numéroter les commandes existantes
        $year = date('Y');
        $orders = \DB::table('orders')->orderBy('id')->get();
        foreach ($orders as $i => $order) {
            \DB::table('orders')->where('id', $order->id)->update([
                'order_number' => 'ISI-BURGER-' . $year . '-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('order_number');
        });
    }
};
