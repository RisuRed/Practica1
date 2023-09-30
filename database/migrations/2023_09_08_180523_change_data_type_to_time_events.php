<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Schema::table('eventos', function (Blueprint $table) {
        //     // Agregar los nuevos campos de tipo date
        //     $table->date('new_register_start_date')->nullable();
        //     $table->date('new_register_end_date')->nullable();
        // });

        // // Copiar los valores de los campos antiguos a los nuevos campos (si es necesario)

        // DB::table('eventos')->update([
        //     'new_register_start_date' => DB::raw('STR_TO_DATE(register_start_date, "%Y-%m-%d")'),
        //     'new_register_end_date' => DB::raw('STR_TO_DATE(register_end_date, "%Y-%m-%d")'),
        // ]);

        // Schema::table('eventos', function (Blueprint $table) {
        //     // Eliminar los campos antiguos de tipo string
        //     $table->dropColumn(['register_start_date', 'register_end_date']);

        //     // Renombrar los nuevos campos a los nombres originales
        //     $table->renameColumn('new_register_start_date', 'register_start_date');
        //     $table->renameColumn('new_register_end_date', 'register_end_date');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('eventos', function (Blueprint $table) {
        });
    }
};
