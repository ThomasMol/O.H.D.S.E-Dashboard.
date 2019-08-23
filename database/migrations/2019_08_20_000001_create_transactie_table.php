<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactieTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'transactie';

    /**
     * Run the migrations.
     * @table transactie
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('transactie_id');
            $table->integer('lid_id')->nullable()->default(null);
            $table->date('datum');
            $table->string('tegen_rekening')->nullable()->default(null);
            $table->string('code');
            $table->string('af_bij', 64);
            $table->decimal('bedrag', 16, 2);
            $table->string('mutatie_soort');
            $table->text('mededelingen');

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
