<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateInvoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:create';

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
        $lastInvoice = \App\Models\Invoice::max('number');

        $invoice = new \App\Models\Invoice();
        
        $accounts = \App\Models\Account::all();

        $fullname = $this->anticipate('Account', $accounts->map(function ($account) {
            return "{$account->id} {$account->name} {$account->name2} {$account->email}";
        }));

        $id = \Illuminate\Support\Str::before($fullname, " ");

        $account = \App\Models\Account::find((int) $id);

        if (! $account) {
            $this->info("Account {$id} not found");

            return Command::FAILURE;
        }

        $invoice->account_id = $id;

        $invoice->sent_at = $this->ask('Date', \Carbon\Carbon::now());
        $invoice->due_at = $this->ask('Due at', \Carbon\Carbon::create($invoice->sent_at)->add('days', 31));

        $invoice->code = $this->anticipate('Code', ['AUD', 'DEV', 'CLA']);

        $nextInvoiceNumber = "0010";

        if ($lastInvoice) {
            $nextInvoiceNumber = str_pad((int) $lastInvoice + 1, 4, '0', STR_PAD_LEFT);
        }

        $invoice->number = $this->ask('Number', $nextInvoiceNumber);

        $invoice->save();

        $this->info("Invoice created");
        $this->info("id : {$invoice->id}");
        $this->newLine(4);
        $this->info("==========================");
        $this->info("{$invoice->code}{$invoice->number}");
        $this->info("{$account->id} {$account->name}");
        $this->info("{$account->name2}");
        $this->info("{$account->email}");
        $this->info("==========================");
        $this->newLine(4);

        return Command::SUCCESS;
    }
}
