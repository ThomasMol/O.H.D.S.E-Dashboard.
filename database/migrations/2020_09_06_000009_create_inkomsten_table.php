<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInkomstenTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'inkomsten';

    /**
     * Run the migrations.
     * @table inkomsten
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('inkomsten_id');
            $table->integer('jaargang');
            $table->string('soort');
            $table->double('budget')->default('0.00');
            $table->double('realisatie')->default('0.00');
            $table->double('verschil')->default('0.00');
            $table->tinyInteger('readonly')->default('0');

            $table->index(["jaargang"], 'jaargang');
            $table->softDeletes();
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
