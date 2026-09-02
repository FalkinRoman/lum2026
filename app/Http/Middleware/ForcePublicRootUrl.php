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
        $configHost = strtolower(trim((string) config('app.host')));
        $configPort = trim((string) config('app.port'));

        $host = $configHost !== '' ? $configHost : strtolower($request->getHost());

        if ($host === '') {
            return $next($request);
        }

        // Never trust arbitrary Host / X-Forwarded-Host — only configured public host.
        $headerHost = strtolower((string) $request->headers->get('Host', ''));
        $headerName = str_contains($headerHost, ':')
            ? strstr($headerHost, ':', true)
            : $headerHost;

        if ($configHost !== '' && $headerName !== '' && $headerName !== $configHost) {
            $host = $configHost;
        }

        $root = in_array($configPort, ['', '80', '443'], true)
            ? sprintf('%s://%s', $scheme, $host)
            : sprintf('%s://%s:%s', $scheme, $host, $configPort);

        URL::forceRootUrl($root);

        return $next($request);
    }
}
