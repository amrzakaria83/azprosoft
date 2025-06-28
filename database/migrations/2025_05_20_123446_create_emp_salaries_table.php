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
        Schema::create('emp_salaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emp_id');
            $table->foreign('emp_id')
                    ->references('id')->on('employees')->onDelete('cascade')->comment('emp_add');
            $table->unsignedBigInteger('emp_salary');
            $table->foreign('emp_salary')
                    ->references('id')->on('employees')->onDelete('cascade')->comment('emp_salary');
            $table->string('value')->nullable();
            $table->text('value_befor')->nullable();
            $table->text('value_after')->nullable();
            $table->text('note')->nullable();
            $table->tinyInteger('type')->default(0)->comment("0 = perhour - 1 = total ");
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
        Schema::dropIfExists('emp_salaries');
    }
};
