<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VoucherConfirmadoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $venda;

    public function __construct($venda)
    {
        $this->venda = $venda;
    }

    public function build()
    {
        return $this->subject('Tu reserva está confirmada - Turismo Chile')
                    ->view('email.voucher-confirmado');
    }
}
