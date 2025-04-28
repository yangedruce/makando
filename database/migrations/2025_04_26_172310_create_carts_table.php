<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\Customer;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignIdFor(User::class);
            $table->json('items')->nullable();
            $table->foreignIdFor(Restaurant::class)->nullable();
            $table->foreignIdFor(Customer::class)->nullable();
            $table->decimal('total_price', 10, 2)->nullable();
            $table->integer('total_items')->default(0);
            $table->string('type')->default('Pickup');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
