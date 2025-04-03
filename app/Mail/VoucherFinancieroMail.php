<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VoucherFinancieroMail extends Mailable
{
    use Queueable, SerializesModels;

    public $venda;
    public $viaje;
    public $tours;
    public $pagamentos;

    public function __construct($venda, $viaje, $tours, $pagamentos)
    {
        $this->venda = $venda;
        $this->viaje = $viaje;
        $this->tours = $tours;
        $this->pagamentos = $pagamentos;
    }

    public function build()
    {
        return $this->view('email.venda')
                    ->with([
                        'venda' => $this->venda,
                        'viaje' => $this->viaje,
                        'tours' => $this->tours,
                        'pagamentos' => $this->pagamentos,
                    ]);
    }
}
