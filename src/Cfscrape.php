<?php

declare(strict_types=1);

namespace Cfscrape;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\SetCookie;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Cfscrape
{
    protected $userAgents = [
        "Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.86 Safari/537.36",
        "Mozilla/5.0 (Windows NT 6.2; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.86 Safari/537.36",
        "Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.86 Safari/537.36",
        "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.86 Safari/537.36",
        "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.86 Safari/537.36",
        "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.86 Safari/537.36",
        "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.86 Safari/537.36",
        "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.86 Safari/537.36",
        "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.86 Safari/537.36",
        "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.86 Safari/537.36",
        "Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.78 Safari/537.36",
        "Mozilla/5.0 (Windows NT 6.2; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.78 Safari/537.36",
        "Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.78 Safari/537.36",
        "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.78 Safari/537.36",
        "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.78 Safari/537.36",
        "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.78 Safari/537.36",
        "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.78 Safari/537.36",
        "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.78 Safari/537.36",
        "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.78 Safari/537.36",
        "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.78 Safari/537.36",
        "Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.79 Safari/537.36",
        "Mozilla/5.0 (Windows NT 6.2; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.79 Safari/537.36",
        "Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.79 Safari/537.36",
        "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.79 Safari/537.36",
        "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.79 Safari/537.36",
        "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.79 Safari/537.36",
        "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.79 Safari/537.36",
        "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.79 Safari/537.36",
        "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.79 Safari/537.36",
        "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.79 Safari/537.36",
    ];

    protected $headers;

    /**
     * @var \GuzzleHttp\Cookie\CookieJar
     */
    protected $cookies;

    protected $delay;

    public function __construct()
    {
        $this->headers = $this->getDefaultHeaders();
    }

    /**
     * @return \GuzzleHttp\Cookie\CookieJar
     */
    public function getCookies(): \GuzzleHttp\Cookie\CookieJar
    {
        return $this->cookies;
    }

    /**
     * @param \GuzzleHttp\Cookie\CookieJar $cookies
     * @return Cfscrape
     */
    public function setCookies(\GuzzleHttp\Cookie\CookieJar $cookies): Cfscrape
    {
        $this->cookies = $cookies;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDelay()
    {
        if ($this->delay) {
            return $this->delay;
        }

        return;
    }

    /**
     * @param mixed $delay
     * @return Cfscrape
     */
    public function setDelay(int $delay)
    {
        $this->delay = $delay;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserAgent()
    {
        if ($this->headers) {
            return $this->headers['User-Agent'];
        }

        return;
    }

    /**
     * @param mixed $userAgent
     * @return Cfscrape
     */
    public function setUserAgent($userAgent)
    {
        $this->headers['User-Agent'] = $userAgent;

        return $this;
    }

    /**
     * @param $url
     * @param array $option
     * @return mixed|\Psr\Http\Message\ResponseInterface|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get($url, $option = [])
    {
        $option['allow_redirects'] = true;

        return $this->request('GET', $url, $option);
    }

    /**
     * @param $method
     * @param $url
     * @param array $option
     * @return mixed|\Psr\Http\Message\ResponseInterface|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request($method, $url, $option = [])
    {
        try {
            $option['headers'] = array_merge($this->headers, $option['headers'] ?? []);
            $client   = new Client();
            $response = $client->request($method, $url, $option);
        } catch (RequestException $exception) {
            $response = $exception->getResponse();
            if ($this->isCloudflareCaptchaChallenge($response)) {
                throw new CfscrapeRuntimeException(sprintf(
                    'Cloudflare captcha challenge presented for %s (cfscrape cannot solve captchas)',
                    $url
                ));
            }

            if ($this->isCloudflareIuamChallenge($response)) {
                $response = $this->solveCloudflareChallenge($response, $exception->getRequest(), $option);
            }
        }

        return $response;
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return bool
     */
    protected function isCloudflareCaptchaChallenge(ResponseInterface $response)
    {
        return $response->getStatusCode() == 403
            && strpos($response->getHeaderLine('Server'), 'cloudflare') !== false
            && strpos((string)$response->getBody(), '/cdn-cgi/l/chk_captcha') !== false;
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return bool
     */
    protected function isCloudflareIuamChallenge(ResponseInterface $response)
    {
        return in_array($response->getStatusCode(), [503, 429])
            && strpos($response->getHeaderLine('Server'), 'cloudflare') !== false
            && strpos((string)$response->getBody(), 'jschl_vc') !== false
            && strpos((string)$response->getBody(), 'jschl_answer') !== false;
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param \Psr\Http\Message\RequestInterface $request
     * @param $oriOption
     * @return mixed|\Psr\Http\Message\ResponseInterface|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function solveCloudflareChallenge(
        ResponseInterface $response,
        RequestInterface $request,
        $oriOption
    ) {
        $body = (string)$response->getBody();
        $parseUrl = $request->getUri();
        $domain = $parseUrl->getHost();

        $challengeForm = $this->substr($body, '<form class="challenge-form"', '</form>');

        $action = explode('?', $this->substr($challengeForm, 'action="', '"'));

        $method = $this->substr($challengeForm, 'method="', '"');
        $submitUrl = sprintf(
            '%s://%s%s',
            $parseUrl->getScheme(),
            $domain,
            $action[0]
        );

        $oriMethod = $request->getMethod();

        $option = $oriOption;

        $option['form_params'] = [];
        $option['query'] = [];
        $option['headers'] = [];
        $option['headers']['Referer'] = (string)$request->getUri();

        if (isset($action[1])) {
            parse_str($action[1], $option['query']);
        }

        preg_match_all('/[^-] \<input.*?(?:\/>|\<\/input\>)/', $challengeForm, $matches);

        $k = $method == 'POST' ? 'form_params' : 'query';

        foreach ($matches[0] as $match) {
            preg_match('/name=\"(.*?)\"/', $match, $name);
            if ($name[1] != 'jschl_answer') {
                preg_match('/value=\"(.*?)\"/', $match, $value);
                $option[$k][$name[1]] = $value[1];
            }
        }

        foreach (['jschl_vc', 'pass'] as $item) {
            if (!isset($option[$k][$item])) {
                throw new \InvalidArgumentException(sprintf(
                    '%s is missing from challenge form', $item
                ));
            }
        }

        $answer = $this->solveChallenge($body, $domain);

        $option[$k]['jschl_answer'] = $answer;
        $option['allow_redirects'] = false;

        preg_match('/(?:[^{<>]*},\s*(\d{4,}))/', $body, $match);
        $delay = $this->getDelay() ?: ($match[1] / 1000 ?? 8);
        sleep($delay);

        $redirect = $this->request($method, $submitUrl, $option);
        if ($redirectUrl = $redirect->getHeaderLine('Location')) {
            $redirectLocation = parse_url($redirectUrl);
            if (empty($redirectLocation['host'])) {
                $redirectUrl = sprintf(
                    '%s://%s%s',
                    $parseUrl->getScheme(),
                    $domain,
                    $redirectLocation['path']
                );
                $redirectLocation['query'] && $redirectUrl .= '?' . $redirectLocation['query'];
                $redirectLocation['fragment'] && $redirectUrl .= '#' . $redirectLocation['fragment'];
            }

            return $this->request($method, $redirectUrl, $oriOption);
        } elseif ($setCookie = $redirect->getHeader('Set-Cookie')) {
            $cookieJar = new CookieJar();
            foreach ($setCookie as $item) {
                $cookieJar->setCookie(SetCookie::fromString($item));
            }
            if ($cookieJar->getCookieByName('cf_clearance')) {
                $this->setCookies($cookieJar);

                return $this->request($oriMethod, $submitUrl, ['cookies' => $cookieJar]);
            } else {
                return $this->request($method, $submitUrl, $oriOption);
            }
        } else {
            return $this->request($oriMethod, $submitUrl, $option);
        }
    }

    /**
     * @param string $body
     * @param string $domain
     * @return mixed
     */
    protected function solveChallenge(string $body, string $domain)
    {
        try {

            $challenge = $this->substr($body, 'setTimeout(function(){', 'f.action += location.hash;');
            $challenge = str_replace('setInterval(function(){}, 100),', "", $challenge);

            $kHtml = $this->substr($body, '<div style="display:none;visibility:hidden;">', '<div id="trk_jschal_nojs"');

            if (empty($kHtml)) {
                throw new \RuntimeException('Not found inner html of the variable "k" ');
            }

            $k = $this->substr($body, "; k = '", "';");
            preg_match_all(
                '|<div.*?id="(' . $k . '\d+)"[^>]?>([^<]+)</div>|',
                $kHtml,
                $matches
            );

            $innerHTML = json_encode(array_combine($matches[1], $matches[2]));

            $challenge = <<<EOF
                  var document = {
                    createElement: function () {
                      return { firstChild: { href: "http://$domain/" } }
                    },
                    getElementById: function (id) {
                      var data = $innerHTML;
                      return {"innerHTML": data[id]};
                    }
                  };
                  $challenge;a.value
EOF;
        } catch (\Exception $exception) {
            throw new CfscrapeRuntimeException('Unable to identify Cloudflare IUAM Javascript on website');
        }

        if (!class_exists('V8Js')) {
            throw new CfscrapeRuntimeException('PHP V8JS library not found. See https://github.com/phpv8/v8js');
        }

        return (new \V8Js())->executeString($challenge);
    }

    /**
     * @param string $subject
     * @param string $start
     * @param string $end
     * @return mixed|string
     */
    protected function substr(string $subject, string $start, string $end)
    {
        $r = explode($start, $subject, 2);
        if (isset($r[1])) {
            return explode($end, $r[1])[0];
        }

        return '';
    }

    /**
     * @return \Cfscrape\Cfscrape
     */
    public static function createScraper()
    {
        $scraper = new self();

        return $scraper;
    }

    /**
     * @param string $url
     * @param string|null $userAgent
     * @param int $delay
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function getTokens(string $url, string $userAgent = null, int $delay = 0)
    {
        $scraper = self::createScraper();

        if ($userAgent) {
            $scraper->setUserAgent($userAgent);
        }

        if ($delay) {
            $scraper->setDelay($delay);
        }

        $response = $scraper->get($url);

        $cookies = $scraper->getCookies();

        return [
            [
                '__cfduid'     => $cookies->getCookieByName('__cfduid')->getValue(),
                'cf_clearance' => $cookies->getCookieByName('cf_clearance')->getValue(),
            ],
            $scraper->getUserAgent()
        ];
    }

    /**
     * @param string $url
     * @param string|null $userAgent
     * @param int $delay
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function getCookieString(string $url, string $userAgent = null, int $delay = 0)
    {
        [$tokens, $userAgent] = self::getTokens($url, $userAgent, $delay);
        return [http_build_query($tokens, '', '; '), $userAgent];
    }

    protected function getDefaultHeaders()
    {
        return [
            'Connection'                => 'keep-alive',
            'Upgrade-Insecure-Requests' => '1',
            'User-Agent'                => $this->getDefaultUserAgent(),
            'Accept'                    => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
            'Accept-Language'           => 'en-US,en;q=0.9',
            'Accept-Encoding'           => 'gzip, deflate',
        ];
    }

    protected function getDefaultUserAgent()
    {
        $userAgents = $this->userAgents;
        shuffle($userAgents);

        return $userAgents[0];
    }
}
