<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BankInfo;

class StripeAccountCheck extends Command
{

    

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lawyers:account';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Lawyers account activated or not';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $records = BankInfo::where(['payouts_enabled' => 'inactive'])->get();

        try {
            if($records) {
                $stripe = new \Stripe\StripeClient(
                    config('services.stripe.secret')
                );

                foreach($records as $record){
                    $account = $stripe->accounts->retrieve($record->account_id);

                    if(@$account && $account->payouts_enabled) {
                        $record->payouts_enabled = 'active';              
                    } else {
                        $record->payouts_enabled = 'inactive'; 
                    }
                    
                    $record->save();

                    //$this->flash('success', 'Account added successfully');
                }
            }

        } catch (\Exception $e) {
            //$this->flash('error', $e->getMessage());
        }

        return 1;

    }
}
