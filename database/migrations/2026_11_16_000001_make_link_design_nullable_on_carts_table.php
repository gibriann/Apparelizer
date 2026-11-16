<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * link_design boleh kosong, motif custom tidak selalu pakai file
     */
    public function up(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->text('link_design')->nullable()->change();
        });
    }

    public function down(): void
    {
        // kolom NOT NULL tidak bisa diisi null, jadi rapikan dulu
        DB::table('carts')->whereNull('link_design')->update(['link_design' => '']);

        Schema::table('carts', function (Blueprint $table) {
            $table->text('link_design')->nullable(false)->change();
        });
    }
};
