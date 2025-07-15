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
        Schema::create('pur_prod_prop_excludes', function (Blueprint $table) {
            $table->id();
            $table->text('pro_prod_id')->nullable();
            $table->unsignedBigInteger('prop_exclude_id')->nullable();
            $table->foreign('prop_exclude_id')
                ->references('id')->on('pur_prop_excludes')->onDelete('cascade')->comment('prop_exclude_id');
            $table->string('value')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0 = active - 1 = notactive');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pur_prod_prop_excludes');
    }
};
