<div align="center">

<img align="center" width="365" src="https://i.imgur.com/hU3gENb.png" />

<p>🗞 PHP API wrapper for NewsAPI.org</p>



[![travis-build](https://img.shields.io/travis/GFargo/newsapi.svg?style=flat&logo=travis)](https://travis-ci.org/GFargo/newsapi)
[![codecov](https://codecov.io/gh/GFargo/newsapi/branch/master/graph/badge.svg)](https://codecov.io/gh/GFargo/newsapi)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/6f4ab131730644e5bb64abef86c75c08)](https://www.codacy.com/app/GFargo/newsapi?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=GFargo/newsapi&amp;utm_campaign=Badge_Grade)

</div>

## Getting Started

Getting started is easy. Here's how you do it. You can check the example.php file as well. Obviously, you'll have to download the wrapper to your current setup. Several ways to do that.



### Installation

Easily add it to your project via Composer.

```php
composer require gfargo/newsapi
```



### Dependencies

This wrapper utilizes the [Requests](https://github.com/rmccue/requests) library from Ryan McCue.  Official website/docs can be found [here](http://requests.ryanmccue.info/)   .



### Configuration

Once included in your project, setup should be very straightforward.  Only requirement is a valid API key provided by [NewsAPI.org](NewsAPI.org/account/).

```php
 $api = new \NewsAPI\API ( 'personal_api_key' );
 ```



## Usage

#### Step 1. Set API Access Token 

```php
\NewsAPI\Client::setAccessToken('276537c6a3824cdd9eae393c024ff732');
```

#### Step 2. Query API

All requests to the API are made via the `query` method.   

```php
$response = \NewsAPI\Client::query( 
    'everything', 
    [
        'q'        => 'Protest',
        'language' => 'en',
        'to' => '2019-01-10',
        'pageSize' => 5
    ]
);
```

#### Step 3. Response

## Response

Each request to the API made will return a `Request_Response` object.  You can read more on this class and its properties [here](http://requests.ryanmccue.info/api/class-Requests_Response.html).

## Change log

Changes to the "Sendy-PHP-API" for Sendy.

> [Automated release notes can be found here →](https://github.com/gfargo/newsapi/releases)

