laravel-4-geoip
===============

[![Build Status](https://api.travis-ci.org/D3Catalyst/laravel-4-geoip.svg)](https://travis-ci.org/D3Catalyst/laravel-4-geoip) [![Latest Stable Version](https://poser.pugx.org/d3catalyst/l4-geoip/v/stable.svg)](https://packagist.org/packages/d3catalyst/l4-geoip) [![Total Downloads](https://poser.pugx.org/d3catalyst/l4-geoip/downloads.svg)](https://packagist.org/packages/d3catalyst/l4-geoip) [![Latest Unstable Version](https://poser.pugx.org/d3catalyst/l4-geoip/v/unstable.svg)](https://packagist.org/packages/d3catalyst/l4-geoip) [![License](https://poser.pugx.org/d3catalyst/l4-geoip/license.svg)](https://packagist.org/packages/d3catalyst/l4-geoip) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/D3Catalyst/laravel-4-geoip/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/D3Catalyst/laravel-4-geoip/?branch=master)

Laravel 4 Library for calling http://ip-api.com/ API.

In contrary to all other packages wherein it requires that you have the geoip database in your filesystem, this library calls a free service
So you dont really have to worry about downloading and maintaining geoip data from Maxmind in your own server.

Just install the package, add the config and it is ready to use!


Requirements
============

* PHP >= 5.3.7
* cURL Extension

Installation
============

    Add in composer.json
    "d3catalyst/l4-geoip": "dev-master"

Add the service provider and facade in your config/app.php

Service Provider

    D3Catalyst\GeoIP\Laravel4\ServiceProviders\GeoIPServiceProvider

Facade

    'GeoIP'            => 'D3Catalyst\GeoIP\Laravel4\Facades\GeoIP',

Usage
=====

Set IP of the visitor (Optional)

    GeoIP::setIp("127.0.0.1");  // Optional set ip, when not set this take automatical from REMOTE_HOST

Get country of the visitor

    GeoIP::getCountry();  // returns "United States"
    
Get country code of the visitor

    GeoIP::getCountryCode();  // returns "US"

Get region of the visitor

    GeoIP::getRegion();  // returns "New York"

Get region code of the visitor

    GeoIP::getRegionCode();  // returns "NY"

Get city of the visitor

    GeoIP::getCity();  // returns "Buffalo"

Get zip code of the visitor

    GeoIP::getZipCode();  // returns "14221"
    
Get latitude of the visitor

    GeoIP::getLatitude();  // returns "42.9864"

Get longitude of the visitor

    GeoIP::getLongitude();  // returns "-78.7279"

Get timezone of the visitor

    GeoIP::getTimezone();  // returns "America/Mexico_City"

Get ISP of the visitor

    GeoIP::getIsp();  // returns "Internet Service provider"

Get ALL geo information of visitor

    GeoIP::getAll();  // returns array with all information
