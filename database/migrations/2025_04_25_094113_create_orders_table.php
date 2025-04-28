<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Restaurant;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Restaurant::class);
            $table->string('status')->default(config('constant.status.order.new'));
            $table->enum('type', ['Pickup', 'Delivery']);
            $table->decimal('total_price', 10, 2)->nullable();
            $table->string('payment_status')->nullable();
            $table->integer('points')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropSoftDeletes('orders');
    }
};
