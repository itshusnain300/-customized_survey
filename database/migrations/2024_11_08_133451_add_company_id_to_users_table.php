<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompanyIdToUsersTable extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add the company_id column with a foreign key constraint
            $table->foreignId('company_id')->nullable()->constrained('companies')->onDelete('set null');
            // Ensure only one user per company
            $table->unique('company_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the company_id column and the foreign key constraint
            $table->dropForeign(['company_id']);
            $table->dropColumn('company_id');
        });
    }
}
