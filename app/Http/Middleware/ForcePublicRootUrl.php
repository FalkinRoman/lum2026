<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

/**
 * Keep absolute URLs on the public browser origin (host:8080), even though
 * nginx inside Docker listens on :80 and may expose SERVER_PORT=80.
 */
class ForcePublicRootUrl
{
    public function handle(Request $request, Closure $next): Response
    {
        $scheme = (string) (config('app.scheme') ?: $request->getScheme() ?: 'http');
        $configHost = trim((string) config('app.host'));
        $configPort = trim((string) config('app.port'));

        $headerHost = $request->headers->get('Host');

        // Browser sent Host with explicit port — trust it.
        if (is_string($headerHost) && str_contains($headerHost, ':')) {
            URL::forceRootUrl($scheme.'://'.$headerHost);

            return $next($request);
        }

        $host = $configHost !== '' ? $configHost : $request->getHost();

        if ($host === '') {
            return $next($request);
        }

        $root = in_array($configPort, ['', '80', '443'], true)
            ? sprintf('%s://%s', $scheme, $host)
            : sprintf('%s://%s:%s', $scheme, $host, $configPort);

        URL::forceRootUrl($root);

        return $next($request);
    }
}
