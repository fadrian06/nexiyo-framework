# Nexiyo
Nexiyo is my experiment at building a small framework so I could learn more about the individual components. Now it's in a usable state, I thought I'd release it, as a tool for others to learn or even use in small sites.

## Features
### Current
 - Full MVC functionality using as few packages as possible
 - Supports Dotenv for environment credentials
 - Built on Flight (router/microframework) - http://flightphp.com/learn/
 - Uses illuminate/database for connections - https://laravel.com/docs/5.1/database#configuration
 - Eloquent models - http://laravel.com/docs/5.1/eloquent
 - Twig templating engine - http://twig.sensiolabs.org/doc/1.x/

### To do (hopefully)
 - Improve error handling in core
 - Migrate Twig to 3.0
 - Provide defaults for dotenv when unset
 - Add DB migration capabilities

## Installing
### Requirements
 - PHP 7 or above (8.x series highly recommended)
 - Either Apache with **mod_rewrite** or Nginx
 - MySQL or MariaDB (other databases theoretically supported however I haven't dealt with them)

### Install
For full install details, see the parent project **lxqueen/nexiyo**.

## Usage
For full usage details, see the parent project **lxqueen/nexiyo**.

## License (MIT License)
**Copyright 2017 Alexis Queen.**

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

 - The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
