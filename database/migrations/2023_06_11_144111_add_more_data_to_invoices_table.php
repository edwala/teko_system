<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->boolean('is_paid')->default(false);
            $table->timestamp('paid_at')->nullable();
            $table->boolean('is_sent')->default(false);
            $table->timestamp('sent_at')->nullable();
            $table->boolean('is_reminded')->default(false);
            $table->timestamp('reminded_at')->nullable();
            $table->boolean('is_overdue')->default(false);
            $table->timestamp('overdue_at')->nullable();
            $table->boolean('is_cancelled')->default(false);
            $table->timestamp('cancelled_at')->nullable();
            $table->boolean('is_archived')->default(false);
            $table->timestamp('archived_at')->nullable();
            $table->boolean('is_printed')->default(false);
            $table->timestamp('printed_at')->nullable();

            $table->timestamp('datum_vystaveni')->nullable();
            $table->timestamp('datum_zdanitelneho_plneni')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->removeColumn('is_paid');
            $table->removeColumn('paid_at');
            $table->removeColumn('is_sent');
            $table->removeColumn('sent_at');
            $table->removeColumn('is_reminded');
            $table->removeColumn('reminded_at');
            $table->removeColumn('is_overdue');
            $table->removeColumn('overdue_at');
            $table->removeColumn('is_cancelled');
            $table->removeColumn('cancelled_at');
            $table->removeColumn('is_archived');
            $table->removeColumn('archived_at');
            $table->removeColumn('is_printed');
            $table->removeColumn('printed_at');

            $table->removeColumn('datum_vystaveni');
            $table->removeColumn('datum_zdanitelneho_plneni');

        });
    }
};
