<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AddLineToInvoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'line:add {invoiceId}';

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
        $invoice = \App\Models\Invoice::find($this->argument('invoiceId'));

        if (! $invoice) {
            $this->line("Invoice {$this->argument('invoiceId')} not found");
            
            return Command::FAILURE;
        }

        $this->newLine(4);
        $this->info("==========================");
        $this->info("{$invoice->code}{$invoice->number}");
        $this->info("{$invoice->account->id} {$invoice->account->name}");
        $this->info("{$invoice->account->name2}");
        $this->info("{$invoice->account->email}");
        $this->info("==========================");
        $this->newLine(4);

        $line = new \App\Models\Line();

        $line->invoice_id = $this->argument('invoiceId');

        $description = '';

        while($description === '' OR str_contains($description, '\\')) {
            $description = str_replace('\\', "\n", $description);
            $description .= $this->ask('Description');
        }

        $line->description = $description;
        $this->line($line->description);
        
        $line->quantity = $this->ask('Quantity', 1);
        $line->unit_price = $this->ask('Unit price', 450);
        $line->discount = $this->ask('Discount');

        $line->save();

        $this->info("Line added");

        return Command::SUCCESS;
    }
}
