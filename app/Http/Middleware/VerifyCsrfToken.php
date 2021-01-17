<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{

    protected $except = [
        //
    ];


    // public function handle($request, Closure $next)
    // {

    //     if ($this->isReading($request) || $this->tokensMatch($request)) {
    //         return $this->addCookieToResponse($request, $next($request));
    //     }
    //     return redirect("/")->with("alert", "Session Finalizada");
    //     #throw new TokenMismatchException;
    // }

}
