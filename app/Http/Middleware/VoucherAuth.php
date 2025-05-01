<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class VoucherAuth
{
    public function handle($request, Closure $next)
    {
        $vendaId = $request->route('id');

        if (Session::get("voucher_access.$vendaId") !== true) {
            return redirect()->route('voucher.login')->with('error', 'Acesso negado. Faça login com seu código.');
        }

        return $next($request);
    }
}
