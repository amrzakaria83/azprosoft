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
        Schema::create('emp_imports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emp_code')->unique();
            $table->string('name_ar')->nullable();
            $table->string('name_en')->nullable();
            $table->string('phone')->nullable();
            $table->string('emailaz')->nullable();
            $table->tinyInteger('role_id')->nullable();
            $table->tinyInteger('is_active')->default(1)->comment("0 = not active, 1 = active, 2 = suspended , 3 = terminated");
            $table->string('type')->default(0)->comment("0 = admin, 1 = no dash 3 = subadmin, 4 = superadmin ");
            $table->string('password')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emp_imports');
    }
};
