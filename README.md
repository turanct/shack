Turanct/Shack
=============================

A [Stack](http://stackphp.com) middleware that will add a unique identifier (`sha`) to the application. It will set a custom header (`X-Shack-Sha`) containing the sha.

```sh
$ curl -I http://shack.dev
HTTP/1.1 200 OK
Date: Sat, 06 Dec 2014 17:29:49 GMT
Server: Apache/2.2.22 (Ubuntu)
X-Powered-By: PHP/5.3.10-1ubuntu3.15
Cache-Control: no-cache
X-Shack-Sha: 7c2796aa85d735874ec95c7b4e18a2e0f15d1456
Vary: Accept-Encoding
Content-Type: text/html; charset=UTF-8
```


Example
-----------------------------

``` php
<?php

$app = new Silex\Application();

$app->get('/', function() use ($app) {
    return 'Hello World';
});

$stack = new Stack\Builder();
$stack->push('Turanct\Shack', new Turanct\Shack\Git());
$app = $stack->resolve($app);
```


Usage
-----------------------------

Just pass in the right Sha type as argument to the `Turanct\Shack` constructor (Git, RevisionFile, String), and Shack will take care of the rest.

Options:
- `Turanct\Shack\Git` will run a git command on your server, to retreive the current HEAD's sha
- `Turanct\Shack\RevisionFile` will use the contents of a given file as sha. This is particulary handy when using Capistrano, as there's a Capistrano task to create these files. You can just pass the revision file path as a constructor parameter.
- `Turanct\Shack\String` takes any string and uses that as the sha. This might be handy to use when you want to set the sha yourself, e.g. using `ENV` variables.

If you want to disable the html sha stamp on your html pages, just pass `false` to the `Turanct\Shack` constructor.


Inspiration
-----------------------------

Ported from the ruby rack middleware by Piet [pjaspers/shack](https://github.com/pjaspers/shack)
