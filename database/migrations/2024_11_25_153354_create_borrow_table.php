<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('borrow', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('book_id')->nullable()->unsigned();
            $table->bigInteger('cd_id')->nullable()->unsigned();
            $table->bigInteger('fyp_id')->nullable()->unsigned();
            $table->bigInteger('journal_id')->nullable()->unsigned();
            $table->bigInteger('newspaper_id')->nullable()->unsigned();
            $table->bigInteger('days_left');
            $table->timestamps();

            $table->index(["user_id"], 'user_id_idx');
            $table->index(["book_id"], 'book_id_idx');
            $table->index(["cd_id"], 'cd_id_idx');
            $table->index(["fyp_id"], 'fyp_id_idx');
            $table->index(["journal_id"], 'journal_id_idx');
            $table->index(["newspaper_id"], 'newspaper_id_idx');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('no action')
                ->onUpdate('no action');
            $table->foreign('book_id')
                ->references('id')->on('books')
                ->onDelete('no action')
                ->onUpdate('no action');
            $table->foreign('cd_id')
                ->references('id')->on('cds')
                ->onDelete('no action')
                ->onUpdate('no action');
            $table->foreign('fyp_id')
                ->references('id')->on('fyps')
                ->onDelete('no action')
                ->onUpdate('no action');
            $table->foreign('journal_id')
                ->references('id')->on('journals')
                ->onDelete('no action')
                ->onUpdate('no action');
            $table->foreign('newspaper_id')
                ->references('id')->on('newspapers')
                ->onDelete('no action')
                ->onUpdate('no action');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrow');
    }
};
