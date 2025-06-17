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
        Schema::create('sale_types', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar')->unique();
            $table->string('name_en')->unique();
            $table->text('note')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0 = active - 1 = notactive');
            $table->softDeletes();
            $table->timestamps();
        });
        DB::table('sale_types')->insert([
            [
                'id' => 1,
                'name_ar' => 'كاش',
                'name_en' =>'cash',
            ],
            [
                'id' => 2,
                'name_ar' => 'أجل',
                'name_en' =>'Delayed',
            ],
            [
                'id' => 3,
                'name_ar' => 'توصيل',
                'name_en' =>'Delivery',
            ],
            [
                'id' => 4,
                'name_ar' => 'فيزا',
                'name_en' =>'Visa',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_types');
    }
};
