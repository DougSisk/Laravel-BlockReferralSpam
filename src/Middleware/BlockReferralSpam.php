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
        $spammerList = config('app.referral_spam_list_location', base_path('vendor/piwik/referrer-spam-blacklist/spammers.txt'));

        if (file_exists($spammerList)) {
            $blockedHosts = file($spammerList, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            foreach ($blockedHosts as $i => $host) {
                $blockedHosts[$i] = trim(utf8_encode($host));
            }

            $referer = utf8_encode($request->headers->get('referer'));
            preg_match('/^(?:https?:\/\/)?(?:[^@\n]+@)?(?:www\.)?([^:\/\n]+)/', $referer, $matches);
            $fullDomain = $matches[1];

            // Get root domain
            $domainParts = explode('.', $fullDomain);
            $rootDomain = $domainParts[count($domainParts) - 2] . '.' . $domainParts[count($domainParts) - 1];

            if (in_array($fullDomain, $blockedHosts) || in_array($rootDomain, $blockedHosts)) {
                return response('Spam referral.', 401);
            }
        }

        return $next($request);
    }
}
