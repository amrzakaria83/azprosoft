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
        Schema::create('emp_plan_atts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emp_id');
            $table->foreign('emp_id')
                    ->references('id')->on('employees')->onDelete('cascade')->comment('emp_add');
            $table->unsignedBigInteger('emp_plan_att')->nullable();
            $table->foreign('emp_plan_att')
                    ->references('id')->on('employees')->onDelete('cascade')->comment('emp_plan_att');
            $table->time('attendance_in_at')->nullable();
            $table->time('attendance_out_at')->nullable();
            $table->unsignedBigInteger('work_loct_id')->nullable();
            $table->foreign('work_loct_id')
                    ->references('id')->on('work_locations')->onDelete('cascade')->comment('work_loct_id');
            $table->string('hours_work')->nullable();
            $table->json('weekly_dayoff')->nullable();
            $table->text('note')->nullable();
            $table->tinyInteger('coutnt_shift')->default(0)->comment("no. of shift ");
            $table->json('shift_att_in_out')->nullable()->comment("No of shitf and time in and out");
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
        Schema::dropIfExists('emp_plan_atts');
    }
};
