<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('halaqah_sessions', function (Blueprint $table) {
            // Documentation photos (JSON array of paths)
            if (!Schema::hasColumn('halaqah_sessions', 'documentation')) {
                $table->json('documentation')->nullable()->after('mode');
            }

            // Mentor Presence
            if (!Schema::hasColumn('halaqah_sessions', 'mentor_presence')) {
                $table->enum('mentor_presence', ['present', 'permit', 'sick', 'absent'])->default('present')->after('documentation');
            }

            // Program & Feedback
            if (!Schema::hasColumn('halaqah_sessions', 'is_program_special')) {
                $table->boolean('is_program_special')->default(false);
            }
            if (!Schema::hasColumn('halaqah_sessions', 'program_description')) {
                $table->text('program_description')->nullable();
            }
            if (!Schema::hasColumn('halaqah_sessions', 'is_theme_suitable')) {
                $table->boolean('is_theme_suitable')->default(true);
            }
            if (!Schema::hasColumn('halaqah_sessions', 'is_material_suitable')) {
                $table->boolean('is_material_suitable')->default(true);
            }

            // Amal Yaumian Stats (Counts of members performing the activity)
            // Using a simple key-value store or separate columns? Columns are easier for quick reporting.
            // Check usage: Form will save counts here.

            $activities = [
                'activity_shalat_berjamaah',
                'activity_shalat_dhuha',
                'activity_qiyamul_lail',
                'activity_tilawah',
                'activity_dzikir',
                'activity_olahraga'
            ];

            foreach ($activities as $col) {
                if (!Schema::hasColumn('halaqah_sessions', $col)) {
                    $table->integer($col)->default(0);
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('halaqah_sessions', function (Blueprint $table) {
            $table->dropColumn([
                'documentation',
                'mentor_presence',
                'is_program_special',
                'program_description',
                'is_theme_suitable',
                'is_material_suitable',
                'activity_shalat_berjamaah',
                'activity_shalat_dhuha',
                'activity_qiyamul_lail',
                'activity_tilawah',
                'activity_dzikir',
                'activity_olahraga',
            ]);
        });
    }
};
