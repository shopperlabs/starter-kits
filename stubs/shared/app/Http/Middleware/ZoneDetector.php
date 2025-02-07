<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Actions\CountriesWithZone;
use App\Actions\ZoneSessionManager;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

class ZoneDetector
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! ZoneSessionManager::checkSession()) {
            $countries = (new CountriesWithZone)->handle();

            $currencyZone = $countries->firstWhere('currencyCode', shopper_currency());

            if ($currencyZone) {
                ZoneSessionManager::setSession($currencyZone);
            } else {
                $this->setDefaultZone($countries);
            }
        }

        return $next($request);
    }

    private function setDefaultZone(Collection $countries): void
    {
        $defaultZone = $countries->firstWhere('zoneCode', config('starterkit.default_zone'));

        if (! ZoneSessionManager::checkSession() && $defaultZone) {
            ZoneSessionManager::setSession($defaultZone);
        }
    }
}
