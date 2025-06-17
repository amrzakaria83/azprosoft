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
        Schema::create('bill_sale_headers', function (Blueprint $table) {
            $table->id();
            
            $table->decimal('total_price', 8, 2)->nullable()->comment('all receipt or prod');
            $table->decimal('total_tax', 8, 2)->nullable()->comment('all receipt or prod');
            $table->decimal('total_extra_discount', 8, 2)->nullable()->comment('all receipt or prod');
            $table->tinyInteger('sale_type_prosoft')->default(0)->comment("0 = cash - 1 = delayed - 2 = delivery");
            $table->unsignedBigInteger('cust_id')->nullable();
            $table->foreign('cust_id')
                ->references('id')->on('azcustomers')->onDelete('cascade')->comment('cust_id');
            $table->string('cust_code')->nullable()->comment('code prosoft');
            $table->tinyInteger('status')->default(0)->comment('0 = oredred - 1 = done - 3 = cancelled - 4 = paied ');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_sale_headers');
    }
};
