<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('work_locations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emp_id')->nullable();
            $table->foreign('emp_id')
                    ->references('id')->on('employees')->onDelete('cascade')->comment('emp_add');
            $table->text('name_en')->nullable();
            $table->text('name_ar')->nullable();
            $table->text('note')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->tinyInteger('status')->default(0)->comment("0 = active - 1 = notactive");
            $table->softDeletes();
            $table->timestamps();
        });
        DB::table('work_locations')->insert([
            [
                'id' => 1,
                'emp_id' => NULL,
                'name_en' => 'amr zakaria ph',
                'name_ar' => 'ص عمرو زكريا',
                'status' => 0,
                'note' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-06-04 09:25:42',
                'updated_at' => '2024-06-04 09:25:42'
            ],
            [
                'id' => 2,
                'emp_id' => NULL,
                'name_en' => 'amr zakaria gaballah ph',
                'name_ar' => 'ص عمرو زكريا جاب الله',
                'status' => 0,
                'note' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-06-04 09:25:42',
                'updated_at' => '2024-06-04 09:25:42'
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_locations');
    }
};
