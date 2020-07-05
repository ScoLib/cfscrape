# Cloudflare Scrape

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Total Downloads][ico-downloads]][link-downloads]

A simple PHP module to bypass Cloudflare's anti-bot page (also known as "I'm Under Attack Mode", or IUAM)

Thanks [https://github.com/Anorov/cloudflare-scrape](https://github.com/Anorov/cloudflare-scrape)


## 依赖

php >= 7.2

v8js扩展 https://github.com/phpv8/v8js


## 安装

``` bash
$ composer require cfscrape/cfscrape
```

## 使用

### 获取响应

``` php
$scraper = \Cfscrape\Cfscrape::createScraper();
// 延时
$scraper->setDelay(10);
// 自定义UA
$scraper->setUserAgent('custom-ua');
// \Psr\Http\Message\ResponseInterface
$response = $scraper->get('http://somesite.com');
```
### 获取Cookie

```php
// cookies is array
// [
//     'cf_clearance' => 'c8f913c707b818b47aa328d81cab57c349b1eee5-1426733163-3600',
//     '__cfduid' => 'dd8ec03dfdbcb8c2ea63e920f1335c1001426733158'
// ]
[$cookies, $userAgent] = \Cfscrape\Cfscrape::getTokens('http://somesite.com');

// cookies is string
// cf_clearance=c8f913c707b818b47aa328d81cab57c349b1eee5-1426733163-3600; __cfduid=dd8ec03dfdbcb8c2ea63e920f1335c1001426733158
[$cookies, $userAgent] = \Cfscrape\Cfscrape::getCookieString('http://somesite.com');
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/cfscrape/cfscrape.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/cfscrape/cfscrape/master.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/cfscrape/cfscrape.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/cfscrape/cfscrape
[link-travis]: https://travis-ci.com/cfscrape/cfscrape
[link-downloads]: https://packagist.org/packages/cfscrape/cfscrape
