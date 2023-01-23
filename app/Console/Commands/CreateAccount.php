<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'account:create';

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
        $account = new \App\Models\Account();

        $account->name = $this->ask('Name *');
        $account->name2 = $this->ask('Name 2');
        $account->registration_number = $this->ask('Registration number');
        $account->email = $this->ask('Email');
        $account->phone = $this->ask('Phone');
        $account->address = $this->ask('Address');
        $account->address2 = $this->ask('Address line 2');
        $account->postcode = $this->ask('Postcode');
        $account->city = $this->ask('City');
        $account->country = $this->anticipate('Country', ['France']);

        $account->save();

        $this->info('Account created');
        $this->info("id : {$account->id}");

        return Command::SUCCESS;
    }
}
