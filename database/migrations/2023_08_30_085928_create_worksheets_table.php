<?php

use Doctrine\DBAL\Types\Types;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    // public function __construct()
    // {
    //     DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', Types::STRING);
    // }
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('worksheets', function (Blueprint $table) {
            $table->id();
            $table->enum('priority', ['Normál', 'Sürgős', 'Leálláskor'])->default('Normál');
            // $table->string('priority')->default('Normál');

            $table->text('description');
            $table->date('due_date')->nullable();
            $table->date('finish_date')->nullable();

            $table->foreignId('device_id')->constrained()->onUpdate('no action')->onDelete('no action');

            $table->unsignedBigInteger('creator_id');
            $table->foreign('creator_id')->references('id')->on('users')->onUpdate('no action')->onDelete('no action');

            $table->unsignedBigInteger('repairer_id')->nullable();
            $table->foreign('repairer_id')->references('id')->on('users')->onUpdate('no action')->onDelete('no action');

            $table->text('attachments');

            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('worksheets');
    }
};
