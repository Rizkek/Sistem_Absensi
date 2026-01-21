<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ClearSessions extends Command
{
    protected $signature = 'session:clear';
    protected $description = 'Clear all user sessions for fresh login';

    public function handle()
    {
        try {
            DB::table('sessions')->truncate();
            $this->info('✅ All sessions cleared successfully!');
            return 0;
        } catch (\Exception $e) {
            $this->error('❌ Error clearing sessions: ' . $e->getMessage());
            return 1;
        }
    }
}
