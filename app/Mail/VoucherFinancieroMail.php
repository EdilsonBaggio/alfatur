<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VoucherFinancieroMail extends Mailable
{
    use Queueable, SerializesModels;

    public $venda;
    public $viaje;
    public $tours;
    public $pagamentos;
    public $pdf;

    public function __construct($venda, $viaje, $tours, $pagamentos, $pdf)
    {
        $this->venda = $venda;
        $this->viaje = $viaje;
        $this->tours = $tours;
        $this->pagamentos = $pagamentos;
        $this->pdf = $pdf;
    }

    public function build()
    {
        return $this->view('email.venda')
                    ->subject('Voucher Financiero - Turismo Chile')
                    ->with([
                        'venda' => $this->venda,
                        'viaje' => $this->viaje,
                        'tours' => $this->tours,
                        'pagamentos' => $this->pagamentos,
                    ])
                    ->attachData($this->pdf, "voucher-financiero-{$this->venda->id}.pdf", [
                        'mime' => 'application/pdf',
                    ]);
    }
}
