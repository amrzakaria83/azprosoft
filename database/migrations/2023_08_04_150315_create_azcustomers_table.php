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
        Schema::create('azcustomers', function (Blueprint $table) {
            $table->id();
            $table->string('cust_code', 191)->unique();
            $table->string('name_ar', 191)->unique();
            $table->string('name_en',191)->nullable();
            $table->decimal('balance', 8, 2)->nullable();
            $table->tinyInteger('sell_price_type')->nullable()->comment('0 = sell_price_pub - 1 =sell_price1 - 2 = sell_price2 - 3 = sell_price3');
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('map_location')->nullable();
            $table->tinyInteger('status')->default(0)->comment("0 = active - 1 = not active ");
            $table->tinyInteger('sale_type_prosoft')->default(0)->comment("0 = cash - 1 = delayed - 2 = delivery");
            $table->string('note')->nullable();
            $table->unsignedBigInteger('sale_type_id')->nullable();
            $table->foreign('sale_type_id')
                    ->references('id')->on('sale_types')->onDelete('cascade')->comment('sale_type_id');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('azcustomers');
    }
};
