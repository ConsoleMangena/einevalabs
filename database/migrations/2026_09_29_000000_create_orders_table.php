<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Human-facing identifier. ULID so it sorts chronologically and is
            // safe to expose in URLs and to the payment gateway.
            $table->ulid('ulid')->unique();

            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // Copy of the basket at the moment of purchase. Snapshotted rather
            // than read back from `products` so later price edits or deletions
            // cannot rewrite the history of a paid order.
            $table->json('items');
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone', 32)->nullable();

            $table->char('currency', 3)->default('USD');
            $table->decimal('total', 12, 2);

            /*
             * pending  - created, redirected to the gateway, no answer yet
             * paid     - the gateway confirmed settlement
             * failed   - the customer abandoned or the gateway rejected it
             * refunded - reversed after settlement
             */
            $table->string('status', 20)->default('pending');
            $table->string('reference_number')->nullable()->unique();
            $table->string('redirect_url', 2048)->nullable();
            $table->json('gateway_response')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->string('failure_reason')->nullable();

            $table->timestamps();

            // Admin lists are ordered by newest first and filtered by status.
            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
