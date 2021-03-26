DC Aviation
===========

Yawik Module used by DC Aviation on https://career.dc-aviation.com/

Requirements
------------

* php 7.4
* mongodb

Installation
------------

you can download and use this skin by:

```sh
$ git clone https://github.com/cbleek/DC-Aviation.git
$ cd DC-Aviation
$ composer install
```

The module comes with a sandbox. You can start the sandbox by:

```sh
$ composer serve
```

after that, you should be able to open http://localhost:8000

To activate the module, create a file in you `test/sandbox/config/autoload` directory

```
<?php
return ['Aviation'];
```
