<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePassiefLidmaatschapTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'passief_lidmaatschap';

    /**
     * Run the migrations.
     * @table passief_lidmaatschap
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('lidID');
            $table->date('begin_datum');
            $table->date('eind_datum');

            $table->index(["lidID"], 'lidID');
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
