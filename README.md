# newsapi


<div align="center">

<img align="center" src="https://i.imgur.com/BF5u3Ol.png" />

<p>🗞 PHP API wrapper for NewsAPI.org</p>



[![travis-build](https://img.shields.io/travis/GFargo/newsapi.svg?style=flat&logo=travis)](https://travis-ci.org/GFargo/newsapi)


</div>

## Getting Started

Getting started is easy. Here's how you do it. You can check the example.php file as well. Obviously, you'll have to download the wrapper to your current setup. Several ways to do that.



### Installation

Easily add it to your project via Composer.

```php
composer require gfargo/newsapi
```



### Dependencies

The NewsAPI PHP wrapper utilizes the [Requests](https://github.com/rmccue/requests) library from Ryan McCue.  Official website/docs can be found [here](http://requests.ryanmccue.info/)   .



### Configuration

Once included in your project, setup should be very straightforward.  Only requirement is a valid API key provided by [NewsAPI.org](NewsAPI.org/account/).

```php
 $api = new \NewsAPI\API ( 'personal_api_key' );
 ```



## Usage

All requests to the API are done using the `query` method.   



## Response

Each request to the API made will return a `Request_Response` object.  You can read more on this class and its properties [here](http://requests.ryanmccue.info/api/class-Requests_Response.html).

## Change log

Changes to the "Sendy-PHP-API" for Sendy.

> [Automated release notes can be found here →](https://github.com/gfargo/newsapi/releases)

