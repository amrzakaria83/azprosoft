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
        Schema::table('bill_sale_headers', function (Blueprint $table) {
            $table->unsignedBigInteger('emp_id');
            $table->foreign('emp_id')
                ->references('id')->on('employees')->onDelete('cascade')->comment('emp_add');
            $table->unsignedBigInteger('emp_code')->unique();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bill_sale_headers', function (Blueprint $table) {
            //
        });
    }
};
