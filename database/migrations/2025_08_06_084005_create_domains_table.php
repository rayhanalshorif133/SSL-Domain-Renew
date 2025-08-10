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
        Schema::create('domains', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('content')->nullable(); // Add a new column for the domain's content
            $table->date('expiry_date');
            $table->string('domain_buyer')->nullable(); // Add a new column for the domain buyer
            $table->string('email_status')->default('false');
            $table->string('client_email')->nullable(); // Add a new column for the client's email
            $table->string('status')->default('active'); // Add a new column for the domain's status
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('domains');
    }
};
