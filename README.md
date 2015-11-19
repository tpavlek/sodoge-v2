SoDoge.ca
==========

[SoDoge.ca](http://sodoge.ca) is the best shibe-generator on the internet. Navigation is intentionally obfuscated and
the site is difficult to use in many ways, but it easily allows you to add comic sans of varying colours and sizes
to images.

Installation
-------------

Copy `.env.example` to `.env` and fill in all the details (namely database credentials). Next run `php artisan migrate`,
and point a webserver at `public/`.


Testing
--------

```
phpunit
```
