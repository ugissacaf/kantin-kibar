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
        Schema::table('order_items', function (Blueprint $table) {
            $table->foreignId('order_id')->constrained()->cascadeOnDelete()->after('id');
            $table->foreignId('menu_id')->constrained()->cascadeOnDelete()->after('order_id');
            $table->integer('quantity')->after('menu_id');
            $table->decimal('price', 10, 2)->after('quantity');
            $table->decimal('subtotal', 10, 2)->after('price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropForeign(['menu_id']);
            $table->dropColumn(['order_id', 'menu_id', 'quantity', 'price', 'subtotal']);
        });
    }
};
