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
        Schema::table('albums', function (Blueprint $table) {
            $table->unsignedBigInteger('album_type_id')->after('id')->nullable();

            $table->foreign('album_type_id')->references('id')->on('album_types')
                //quando viene aggiornata una tabella indipendente o principale aggiorna anche a cascata quella indipendente;
                ->onUpdate('cascade')
                // il metodo onDelete() consente di cancellare tutti gli album collegati allo stesso tipo di album(categoria)
                //perciò è neccessario che album_type_id-> Nullable() e questo fa si che se la categoria vien cancellata,
                //automaticamente gli album collegati a questa categoria.

                //ne caso in cui si vuole cancellare i posts degli user, il caso è diverso perché users hanno una relazione
                // one-to-one con userDetails e 1-to-many con albums in questo caso si usa il metodo ->cascadeOnDelete()
                // nella migration 'user_details senza ->nullable() 
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('albums', function (Blueprint $table) {
            $table->dropForeign('albums_album_type_id_foreign');
            $table->dropColumn('album_type_id');
        });
    }
};
