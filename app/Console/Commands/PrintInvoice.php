<?php

namespace App\Console\Commands;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Console\Command;

class PrintInvoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:print {invoiceId}';

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

        $data = [
            'invoice' => $invoice,
        ];

        Pdf::loadView('invoice', $data)->save(
            public_path("printed/facture-benoit-jupille-{$invoice->id}-{$invoice->code}{$invoice->number}.pdf")
        );
        
        return Command::SUCCESS;
    }
}
