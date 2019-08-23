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
            $table->string('straatnaam')->nullable()->default(null);
            $table->string('postcode')->nullable()->default(null);
            $table->string('stad')->nullable()->default(null);
            $table->string('land')->nullable()->default(null);
            $table->string('telefoonnummer')->nullable()->default(null);
            $table->date('geboortedatum')->nullable()->default(null);
            $table->string('geboorteplaats')->nullable()->default(null);

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
