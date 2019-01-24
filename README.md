<div align="center">
<img align="center" title="NewsAPI" width="365" src="https://i.imgur.com/hU3gENb.png" />
<p>🗞 PHP wrapper for <a target="_blank" href="https://newsapi.org">NewsAPI.org<a></p>

[![travis-build](https://img.shields.io/travis/GFargo/newsapi.svg?style=flat&logo=travis)](https://travis-ci.org/GFargo/newsapi)
[![codecov](https://codecov.io/gh/GFargo/newsapi/branch/master/graph/badge.svg)](https://codecov.io/gh/GFargo/newsapi)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/6f4ab131730644e5bb64abef86c75c08)](https://www.codacy.com/app/GFargo/newsapi?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=GFargo/newsapi&amp;utm_campaign=Badge_Grade)

</div>

## Getting Started

Implementing the NewsAPI within your PHP application has never been smoother.  The principle behind its design is simplicity without forfeiting power or flexibility.

### Installation

Add it to your project via Composer.

```php
composer require gfargo/newsapi
```

### Dependencies

This wrapper utilizes the [Requests](https://github.com/rmccue/requests) library from Ryan McCue.  
> Official website & documentation can be found [here](http://requests.ryanmccue.info/).

### Configuration

Once included in your project, setup should be very straightforward.  Only requirement is a valid API key provided by [NewsAPI.org](NewsAPI.org/account/).

## Usage

### Step 1. Set Access Token 

```php
\NewsAPI\Client::setAccessToken('276537c6a3824cdd9eae393c024ff732');
```

### Step 2. Setup Query

Making requests to the API is done via `query` method, which accepts three parameters.  Below are a few examples.

**`Query` parameters:**

* `(string) $endpoint` Target endpoint. Options are `top`, `everything`, and `sources`.
* `(array) $query_params` Query parameters passed to NewsAPI.org
* `(array) $request_options` Options passed to Requests library to control CURL.

**Examples:** 

```php
// All articles featuring the keyword 'Open Source'
$request = NewsAPI\Client::query( 'everything', [ 'q' => 'Open Source' ] );
```

```php
// Top headlines for articles featuring the keyword 'Technology'
$request = NewsAPI\Client::query( 'top', [ 'q' => 'Technology' ] );
```

```php
// Top articles from 'Business' category
$request = NewsAPI\Client::query( 'top', [ 'category' => 'business' ] );
```

### Step 3. Handling Responses

Each query returns a `Request_Response` object,  more on this [here](http://requests.ryanmccue.info/api/class-Requests_Response.html).  

In short the `Requests` library makes dealing with the API responses much easier.

```php
$request = NewsAPI\Client::query( 'top', [ 'category' => 'business' ] );

$request->status_code             // int(200)
$request->headers['content-type'] // string(31) "application/json; charset=utf-8"
$request->url                     // string(54) "https://newsapi.org/v2/top-headlines?category=business"
$request->body                    // string(14385) "{...}"
```

## Change log

> [Automated release notes can be found here →](https://github.com/gfargo/newsapi/releases)
