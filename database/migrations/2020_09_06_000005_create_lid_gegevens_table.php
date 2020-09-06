<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLidGegevensTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'lid_gegevens';

    /**
     * Run the migrations.
     * @table lid_gegevens
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('lid_id');
            $table->string('straatnaam', 191)->nullable()->default(null);
            $table->string('postcode', 191)->nullable()->default(null);
            $table->string('stad', 191)->nullable()->default(null);
            $table->string('land', 191)->nullable()->default(null);
            $table->string('telefoonnummer', 191)->nullable()->default(null);
            $table->date('geboortedatum')->nullable()->default(null);
            $table->string('geboorteplaats', 191)->nullable()->default(null);

            $table->index(["lid_id"], 'lid_id');
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->tableName);
     }
}
