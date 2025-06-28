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
        Schema::create('vacation_causes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emp_id')->nullable();
            $table->foreign('emp_id')
                    ->references('id')->on('employees')->onDelete('cascade')->comment('emp_add');
            $table->text('name_en')->nullable();
            $table->text('name_ar')->nullable();
            $table->text('note')->nullable();
            $table->tinyInteger('status')->default(0)->comment("0 = active - 1 = notactive");
            $table->softDeletes();
            $table->timestamps();
        });
        DB::table('vacation_causes')->insert([
            [
                'id' => 1,
                'emp_id' => 1,
                'name_en' => 'General',
                'name_ar' => 'عادية',
                'status' => 0,
                'note' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-06-04 09:25:42',
                'updated_at' => '2024-06-04 09:25:42'
            ],
            [
                'id' => 2,
                'emp_id' => 1,
                'name_en' => 'Sick Leave',
                'name_ar' => 'اجازة مرضى',
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
        Schema::dropIfExists('vacation_causes');
    }
};
