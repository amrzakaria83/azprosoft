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
        Schema::create('bill_sale_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emp_id');
            $table->foreign('emp_id')
                ->references('id')->on('employees')->onDelete('cascade')->comment('emp_add');
            $table->unsignedBigInteger('bill_sale_header_id')->nullable();
            $table->foreign('bill_sale_header_id')
                ->references('id')->on('bill_sale_headers')->onDelete('cascade')->comment('bill_sale_header_id');
            $table->unsignedBigInteger('prod_id')->nullable();
            $table->foreign('prod_id')
                ->references('id')->on('products')->onDelete('cascade')->comment('prod_id');
            $table->string('product_code')->nullable()->comment('code prosoft');
            $table->unsignedBigInteger('unite_id')->nullable()->comment('prod_only');
            $table->foreign('unite_id')
                ->references('id')->on('unites')->onDelete('cascade')->comment('unite_id');
            $table->decimal('quantity', 8, 2)->nullable()->comment('prod_only');
            $table->decimal('factor_unit', 8, 0)->nullable();
            $table->FLOAT('amount', 8, 2)->nullable()->comment('prod_only');
            $table->decimal('sellprice_actuel_item', 8, 2)->nullable()->comment('actuel price sale');
            $table->decimal('unite_tax', 8, 2)->nullable()->comment('all receipt or prod');
            $table->decimal('extra_discount', 8, 2)->nullable()->comment('all receipt or prod');
            $table->decimal('totalitem_price', 8, 2)->nullable()->comment('all receipt or prod');
            $table->decimal('totalitem_tax', 8, 2)->nullable()->comment('all receipt or prod');
            $table->text('note')->nullable();
            $table->tinyInteger('status_temporary')->default(0)->comment('0 = temporary - 1 = permanent - 2 = cancel');
            $table->tinyInteger('status')->default(0)->comment("0 = active - 1 = not active "); 
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_sale_details');
    }
};
