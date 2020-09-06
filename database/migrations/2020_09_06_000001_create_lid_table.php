<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLidTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'lid';

    /**
     * Run the migrations.
     * @table lid
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('lid_id');
            $table->tinyInteger('admin');
            $table->string('email', 191);
            $table->string('password', 191)->nullable()->default(null);
            $table->string('type_lid', 191)->nullable()->default(null);
            $table->string('roepnaam', 191)->nullable()->default(null);
            $table->string('voornamen', 191)->nullable()->default(null);
            $table->string('achternaam', 191)->nullable()->default(null);
            $table->integer('lichting')->nullable()->default(null);
            $table->string('profiel_foto', 191)->nullable()->default(null);

            $table->unique(["email"], 'email');
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
