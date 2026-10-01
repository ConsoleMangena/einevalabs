<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('contact_submissions', function (Blueprint $table) {
            // Nullable: the column was added after the form was live, so existing
            // rows have no department and the field must stay optional.
            $table->string('department')->nullable()->after('email');
        });
    }

    public function down()
    {
        Schema::table('contact_submissions', function (Blueprint $table) {
            $table->dropColumn('department');
        });
    }
};
