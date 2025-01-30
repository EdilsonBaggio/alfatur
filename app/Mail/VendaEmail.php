<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VendaEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $venda;
    public $tours;

    public function __construct($venda, $tours)
    {
        $this->venda = $venda;
        $this->tours = $tours;
    }

    public function build()
    {
        return $this->subject('Detalhes da Venda')
            ->view('email.venda')
            ->with([
                'venda' => $this->venda,
                'tours' => $this->tours,
            ]);
    }
}
