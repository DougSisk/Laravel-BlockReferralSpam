<?php

namespace DougSisk\BlockReferralSpam\Middleware;

use Closure;

class BlockReferralSpam
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $spammerList = base_path('vendor/piwik/referrer-spam-blacklist/spammers.txt');

        if (file_exists($spammerList)) {
            $blockedHosts = file($spammerList, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $referer = parse_url($request->headers->get('referer'), PHP_URL_HOST);

            // Remove WWWW
            $referer = preg_replace('/(www\.)/i', '', $referer);

            if (in_array($referer, $blockedHosts)) {
                return response('Spam referral.', 401);
            }
        }

        return $next($request);
    }
}
