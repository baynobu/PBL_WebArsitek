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
        Schema::table('proyek', function (Blueprint $table) {
            $table->timestamp('open_at')->nullable()->after('arsitek_terpilih_id');
            $table->timestamp('open_until')->nullable()->after('open_at');
            $table->unsignedInteger('open_duration_days')->nullable()->after('open_until');
            $table->unsignedTinyInteger('progress_percent')->default(0)->after('open_duration_days');
            $table->text('progress_note')->nullable()->after('progress_percent');
            $table->timestamp('progress_updated_at')->nullable()->after('progress_note');
            $table->boolean('is_featured')->default(false)->after('progress_updated_at');
            $table->boolean('is_hidden')->default(false)->after('is_featured');
            $table->foreignId('moderated_by')->nullable()->constrained('users')->nullOnDelete()->after('is_hidden');
            $table->timestamp('moderated_at')->nullable()->after('moderated_by');
            $table->text('moderation_note')->nullable()->after('moderated_at');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proyek', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropConstrainedForeignId('moderated_by');
            $table->dropColumn([
                'open_at',
                'open_until',
                'open_duration_days',
                'progress_percent',
                'progress_note',
                'progress_updated_at',
                'is_featured',
                'is_hidden',
                'moderated_at',
                'moderation_note',
            ]);
        });
    }
};
