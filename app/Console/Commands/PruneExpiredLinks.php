<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Link;

class PruneExpiredLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'links:prune-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete links that have expired (expires_at <= now)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expired = Link::whereNotNull('expires_at')->where('expires_at', '<=', now());

        $count = $expired->count();

        if ($count === 0) {
            $this->info('No expired links to prune.');
            return 0;
        }

        // Deleting links will cascade to redirects (DB FK with onDelete cascade).
        $expired->delete();

        $this->info("Pruned {$count} expired link(s).");

        return 0;
    }
}
