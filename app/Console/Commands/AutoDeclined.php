<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Carbon\Carbon;

use Illuminate\Console\Command;

class AutoDeclined extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Auto:Declined';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       
        self::autoDeclined();
         \Log::info("Cron is working fine!");
    }


    private function autoDeclined()
    {
        $booking=Booking::where('is_call','completed')->get();
      
    }
}
