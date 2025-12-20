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
        Schema::table('donasis', function (Blueprint $table) {
            // Tambah kolom bank jika belum ada
            if (!Schema::hasColumn('donasis', 'bank')) {
                $table->string('bank')->nullable()->after('payment_type');
            }
            
            // Tambah kolom no_hp jika belum ada (sebagai backup untuk telepon)
            if (!Schema::hasColumn('donasis', 'no_hp')) {
                $table->string('no_hp')->nullable()->after('telepon');
            }
            
            // Tambah kolom nominal jika belum ada (sebagai backup untuk jumlah)
            if (!Schema::hasColumn('donasis', 'nominal')) {
                $table->decimal('nominal', 15, 2)->nullable()->after('jumlah');
            }
            
            // Tambah kolom keterangan_pesan jika belum ada (sebagai backup untuk pesan)
            if (!Schema::hasColumn('donasis', 'keterangan_pesan')) {
                $table->text('keterangan_pesan')->nullable()->after('pesan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donasis', function (Blueprint $table) {
            if (Schema::hasColumn('donasis', 'bank')) {
                $table->dropColumn('bank');
            }
            
            if (Schema::hasColumn('donasis', 'no_hp')) {
                $table->dropColumn('no_hp');
            }
            
            if (Schema::hasColumn('donasis', 'nominal')) {
                $table->dropColumn('nominal');
            }
            
            if (Schema::hasColumn('donasis', 'keterangan_pesan')) {
                $table->dropColumn('keterangan_pesan');
            }
        });
    }
};

