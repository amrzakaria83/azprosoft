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
        Schema::create('pur_prop_excludes', function (Blueprint $table) {
            $table->id();
            $table->text('pro_emp_code')->nullable();
            $table->string('name_ar')->nullable();
            $table->string('name_en')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('type')->default(0)->comment('0 = Boolean , 1 = number value , 2 = percentage % , 3 = text');
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
        Schema::dropIfExists('pur_prop_excludes');
    }
};
