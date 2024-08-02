<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('job_id');

            // send for qc
            $table->longText('preview_link')->nullable();
            $table->boolean('self_qc')->nullable();
            $table->longText('dev_comments');

            // submit feedback
            $table->string('time_taken');
            $table->integer('qc_round');
            $table->integer('auditor_id');
            $table->string('qc_status');
            $table->integer('for_rework');
            $table->integer('num_times');
            $table->integer('alignment_aesthetics');
            $table->longText('c_alignment_aesthetics');
            $table->integer('availability_formats');
            $table->longText('c_availability_formats');
            $table->integer('accuracy');
            $table->longText('c_accuracy');
            $table->integer('functionality');
            $table->longText('c_functionality');
            $table->longText('qc_comments');

            // dates
            $table->datetime('start_at')->nullable();
            $table->datetime('end_at')->nullable();
            $table->integer('created_by');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audit_logs');
    }
}
