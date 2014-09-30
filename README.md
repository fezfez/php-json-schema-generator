# PHP JSON Schema Generator 
======================

[![Build Status](https://secure.travis-ci.org/fezfez/php-json-schema-generator.png)](http://travis-ci.org/fezfez/php-json-schema-generator)
[![HHVM Status](http://hhvm.h4cc.de/badge/fezfez/php-json-schema-generator.svg)](http://hhvm.h4cc.de/package/fezfez/php-json-schema-generator)
[![Code Coverage](https://scrutinizer-ci.com/g/fezfez/php-json-schema-generator/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/fezfez/php-json-schema-generator/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/fezfez/php-json-schema-generator/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/fezfez/php-json-schema-generator/?branch=master)
[![Project Status](http://stillmaintained.com/fezfez/php-json-schema-generator.png)](http://stillmaintained.com/fezfez/php-json-schema-generator)

Package: php-json-schema-generator


PHP JSON Schema Generator

## About JSON Schema

JSON has become a mainstay in the vast HTTP toolbox. In order to make JSON more stable and to increase the longevity of the data structure there must be some standards put into place.  These standards will help to define the structure in a way that the industry can rely on.  A uniform way to parse the data and interpret the meaning of the data elements can be found in building a schema that represents it. 

Due to the flexible nature of JSON a solid Schema definition has been slow coming.  At this time there is an internet draft being worked on.  
(http://tools.ietf.org/html/draft-zyp-json-schema-04)

The uses/pros/cons and other discussions related to what a schema can and cannot do for you are beyond the scope of this document.  Seek your creativity for possible scenarios. 

## About This Tool

It is a bit tedious to have to manually write out a JSON Schema every time a new REST point or Data object is created.  Because JSON can be used to represent a variety of data objects it can be helpful to have a dynamic way to map from one object to a JSON Schema. A php array is considered an object here for the sake of ease of communication.  

The goal of the tool is to provide an trivial implement for generating a JSON Schema off a wide range of objects. Some objects provide more options for rich schema generation and some do not. JSON itself is very light on metadata so there is a requirement to infer certain meanings based on the structure of the objects.  

### Parser Objects Supported
* JSON string
  * Defined [RFC 4627](http://tools.ietf.org/html/rfc4627)
  * No validation yet

## Installation 
Simple, assuming you use composer. Add the below lines to your composer.json and run composer update.  


    "require": {
        "solvire/php-json-schema-generator": "dev-master"
    }
    
## Testing
PHPUnit should be included with the composer require-dev configuration. The installation will put an
executable in the vendor/bin directly so it can be run from there. 

Run:

    $ vendor/bin/phpunit

