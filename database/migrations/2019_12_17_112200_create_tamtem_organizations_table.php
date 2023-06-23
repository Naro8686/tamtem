<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTamtemOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tamtem_organizations', function (Blueprint $table) {

            $table->increments('id');
            $table->string('okved')->index()->comment('ОКВЭД');
            $table->unsignedInteger('agent_id')->nullable();
            $table->timestamp('agent_attached_at')->nullable();
            $table->string('name');
            $table->string('inn', 12)->nullable();
            $table->string('site', 64)->nullable();
            $table->string('phone', 255)->nullable();
            $table->string('address_legal')->nullable()->comment('Юр. адрес');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tamtem_organizations');
    }
}
