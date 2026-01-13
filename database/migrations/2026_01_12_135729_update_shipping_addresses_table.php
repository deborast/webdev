<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shipping_addresses', function (Blueprint $table) {
            $table->string('full_name')->nullable()->after('user_id');
            $table->string('phone', 30)->nullable()->after('full_name');
            $table->renameColumn('address', 'address_line');
            $table->string('province', 100)->nullable()->after('city');
        });
    }

    public function down(): void
    {
        Schema::table('shipping_addresses', function (Blueprint $table) {
            $table->renameColumn('address_line', 'address');
            $table->dropColumn(['full_name', 'phone', 'province']);
        });
    }
};
