<?php

namespace App\Console\Commands;

use App\Helpers\Money;
use Illuminate\Console\Command;

class ShowInvoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:show {invoiceId}';

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

        $account = $invoice->account;
        
        $this->info("id : {$invoice->id}");
        $this->newLine(4);
        $this->info("==========================");
        $this->info("Facture n°{$invoice->code}{$invoice->number}");
        $this->info("Sent : {$invoice->sent_at}");
        $this->info("Due : {$invoice->due_at}");
        $this->info("{$account->id} {$account->name}");
        $this->info("{$account->name2}");
        $this->info("{$account->email}");
        $this->info("==========================");
        $this->newLine(4);

        $this->table([
            'id',
            'description',
            'quantity',
            'unit price',
            'discount',
            'total',
        ], $invoice->lines->map(function ($line) {
            return [
                $line->id,
                $line->description,
                $line->quantity,
                Money::price($line->unit_price),
                Money::price($line->discount),
                Money::price($line->total()),
            ];
        })->toArray());

        return Command::SUCCESS;
    }
}
