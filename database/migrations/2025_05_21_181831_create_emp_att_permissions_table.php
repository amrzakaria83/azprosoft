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
        Schema::create('emp_att_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emp_id');
            $table->foreign('emp_id')
                    ->references('id')->on('employees')->onDelete('cascade')->comment('emp_add');
            $table->unsignedBigInteger('emp_att_permission')->nullable();
            $table->foreign('emp_att_permission')
                    ->references('id')->on('employees')->onDelete('cascade')->comment('emp_att_permission');
            $table->unsignedBigInteger('man_att_permission')->nullable();
            $table->foreign('man_att_permission')
                    ->references('id')->on('employees')->onDelete('cascade')->comment('man_att_permission');
            $table->timestamp('attendance_out_from')->nullable();
            $table->timestamp('attendance_in_to')->nullable();
            $table->timestamp('attendance_out_from_manger')->nullable();
            $table->timestamp('attendance_in_to_manger')->nullable();
            $table->tinyInteger('type_emp_att_request')->default(0)->comment("0 = Late attendance - 1 = in work day - 2 = Early departure");
            $table->tinyInteger('emp_att_request')->default(0)->comment("0 = without salary - 1 = 50%salary - 2 = fullsalary ");
            $table->tinyInteger('type_emp_att_mang')->default(0)->comment("0 = without salary - 1 = 50%salary - 2 = fullsalary ");
            $table->tinyInteger('statusmangeraprove')->default(0)->comment("0 = waitting - 1 = approved - 2 = rejected - 3 = delayed ");
            $table->tinyInteger('status')->default(0)->comment("0 = active - 1 = not active ");
            $table->text('noterequest')->nullable();
            $table->text('notemanger')->nullable()->comment("manger");
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emp_att_permissions');
    }
};
