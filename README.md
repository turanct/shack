Turanct/Shack
=============================

A [Stack](http://stackphp.com) middleware that will add a unique identifier (`sha`) to the application. It will set a custom header (`X-Shack-Sha`) containing the sha.


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


Inspiration
-----------------------------

Ported from the ruby rack middleware by Piet [pjaspers/shack](https://github.com/pjaspers/shack)
