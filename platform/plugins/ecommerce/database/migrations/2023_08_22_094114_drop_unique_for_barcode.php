<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration
{
    public function up(): void
    {
        Schema::table('ec_products', function (Blueprint $table) {
            $table->dropUnique('ec_products_barcode_unique');
        });

        Schema::table('ec_products', function (Blueprint $table) {
            $table->string('barcode', 50)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('ec_products', function (Blueprint $table) {
            $table->string('barcode', 50)->unique()->nullable()->change();
        });
    }
};
