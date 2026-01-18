<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['postal', 'tax']);
            $table->integer('shipping_fee')->default(20000)->after('subtotal');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('postal')->nullable();
            $table->decimal('tax', 10, 2)->default(0);
            $table->dropColumn('shipping_fee');
        });
    }
};
