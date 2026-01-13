<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('image')
                  ->nullable()
                  ->after('price'); // krn di tabel cuma ada: id, category_id, name, description, price, timestamps
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // pakai hasColumn supaya aman kalau kolomnya belum ada
            if (Schema::hasColumn('products', 'image')) {
                $table->dropColumn('image');
            }
        });
    }
};
