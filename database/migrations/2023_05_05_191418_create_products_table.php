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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_code')->nullable();
            $table->string('name_ar')->nullable();
            $table->string('name_en')->nullable();
            $table->decimal('sell_price_pub', 8, 2)->nullable()->comment('prod_only');
            $table->decimal('sell_price1', 8, 2)->nullable()->comment('prod_only');
            $table->decimal('sell_price2', 8, 2)->nullable()->comment('prod_only');
            $table->decimal('sell_price3', 8, 2)->nullable()->comment('prod_only');
            $table->unsignedBigInteger('unite_id')->nullable();
            $table->foreign('unite_id')
                    ->references('id')->on('unites')->onDelete('cascade')->comment('unite_id');
            $table->unsignedBigInteger('unite_id2')->nullable();
            $table->foreign('unite_id2')
                    ->references('id')->on('unites')->onDelete('cascade')->comment('unite_id2');
            $table->decimal('unite_id2_factor', 8, 0)->nullable();
            $table->decimal('unite_id2_price', 8, 2)->nullable();
            $table->unsignedBigInteger('unite_id3')->nullable();
            $table->foreign('unite_id3')
                    ->references('id')->on('unites')->onDelete('cascade')->comment('unite_id3');
            $table->decimal('unite_id3_factor', 8, 0)->nullable();
            $table->decimal('unite_id3_price', 8, 2)->nullable();
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
        Schema::dropIfExists('employees');
    }
};

