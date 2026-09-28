<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('gadgets') && ! Schema::hasTable('products')) {
            Schema::rename('gadgets', 'products');
        }
    }

    public function down()
    {
        if (Schema::hasTable('products') && ! Schema::hasTable('gadgets')) {
            Schema::rename('products', 'gadgets');
        }
    }
};
