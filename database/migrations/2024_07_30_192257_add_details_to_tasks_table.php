<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailsToTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->string('external_quality')->after('is_special_request')->nullable();
            $table->string('internal_quality')->after('is_special_request')->nullable();
            $table->boolean('sla_missed')->after('is_special_request')->nullable();
            $table->string('time_taken')->after('is_special_request')->nullable();
            $table->string('agreed_sla')->after('is_special_request')->nullable();
            $table->datetime('end_at')->nullable()->after('is_special_request')->nullable();
            $table->datetime('start_at')->nullable()->after('is_special_request')->nullable();
            $table->integer('created_by')->after('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('internal_quality');
            $table->dropColumn('external_quality');
            $table->dropColumn('sla_missed');
            $table->dropColumn('time_taken');
            $table->dropColumn('agreed_sla');
            $table->dropColumn('end_at');
            $table->dropColumn('start_at');
            $table->dropColumn('created_by');
        });
    }
}
