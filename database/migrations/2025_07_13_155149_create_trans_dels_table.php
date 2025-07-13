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
        Schema::create('trans_dels', function (Blueprint $table) {
            $table->id();
            $table->text('pro_emp_code');
            $table->text('pro_start_id')->nullable();
            $table->text('pro_to_id')->nullable();
            $table->tinyInteger('status_trans')->default(0)->comment('0 = watting delevery - 1 = on delevery - 2 = another delevery - 3 = cancelled - 4 = done - 5 = request delevery');
            $table->text('pro_del_code')->nullable(); // name of delevery /
            $table->dateTime('start_time', precision: 0)->nullable();
            $table->dateTime('arrive_time', precision: 0)->nullable();
            $table->tinyInteger('type_tran')->nullable()->comment('0 = transefer - 1 = order');
            $table->tinyInteger('urgent')->nullable()->comment('0 = unurgent - 1 = urgent');
            $table->text('pro_empreturn')->nullable(); // name of empreturn /
            $table->text('pro_no_receit')->nullable();
            $table->text('pro_val_receit')->nullable();
            $table->text('pro_note')->nullable();
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
        Schema::dropIfExists('trans_dels');
    }
};
