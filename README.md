<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Proje Hakkkında

Projenin işlevleri  

- Uygulama ilk açıldığında cihazı register etme
  - Method: POST
  - Url: {url}/api/app-register
  - Body: [uuid, app_id, os] değerleri gönderilmelidir.
  - Header: [Lang] değeri gönderilmelidir. Bu değer yoksa auto "tr" olarak eklenecektir.
- Uygulama login olma ve api_token alma
  - Method: POST
  - Url: {url}/api/login
  - Body: [email, password, uuid] değerleri gönderilmelidir.
  - Response: [api_token] ile kullanıcının api için gerekli token değeri gönderilir.
- Satın alma
  - Method: POST
  - Url: {url}/api/app/purchase
  - BearerToken: [api_token]
  - Body: [application_id]
  - Notification: Kullanıcıya satın alındı bildirimi gönderilir.
- Satın alma yenileme
  - Method: POST
  - Url: {url}/api/app/renew
  - BearerToken: [api_token]
  - Body: [application_id]
  - Notification: Kullanıcıya yenileme bildirimi gönderilir.
- Satın alma iptali
  - Method: POST
  - Url: {url}/api/app/cancel
  - BearerToken: [api_token]
  - Body: [application_id]
  - Notification: Kullanıcıya iptal bildirimi gönderilir.
- Satın alınmış uygulamalar listesi
    - Method: GET
    - Url: {url}/api/app/check-subscriptions
    - BearerToken: [api_token]
    - Body: [status] isteğe bağlı. "started", "renewed", "canceled" değerlerinden biri olmalı.
    - Response: [data]
