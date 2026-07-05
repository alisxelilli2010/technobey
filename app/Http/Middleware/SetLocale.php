<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public const SUPPORTED = ['az', 'en', 'ru'];
    public const DEFAULT = 'az';

    public function handle(Request $request, Closure $next)
    {
        $locale = $request->cookie('tb_lang') ?: self::DEFAULT;
        if (!in_array($locale, self::SUPPORTED, true)) {
            $locale = self::DEFAULT;
        }
        App::setLocale($locale);
        return $next($request);
    }
}
