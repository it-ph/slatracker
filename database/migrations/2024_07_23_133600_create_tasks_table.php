<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('site_id');
            $table->string('platform'); // duda or wordpress
            $table->string('client_id'); // auto populate based on user client
            $table->string('developer_id');
            $table->string('request_type_id');
            $table->string('request_volume_id'); // num pages
            $table->string('request_sla_id'); // auto populate based on selected request type and num pages
            $table->longText('salesforce_link');
            $table->boolean('is_special_request');
            $table->longText('comments'); // comments for special request
            $table->longText('addon_comments'); // addon comments
            $table->string('status')->default('not started');
            $table->softDeletes();
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
        Schema::dropIfExists('tasks');
    }
}
