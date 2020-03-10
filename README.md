Aviation
========

Skin DC Aviation

Build status:
[![Build Status](https://travis-ci.org/cbleek/Aviation.svg?branch=master)](https://travis-ci.org/cbleek/Aviation)
[![Latest Stable Version](https://poser.pugx.org/cbleek/aviation/v/stable)](https://packagist.org/packages/yawik/aviation)
[![Total Downloads](https://poser.pugx.org/cbleek/aviation/downloads)](https://packagist.org/packages/yawik/aviation)
[![License](https://poser.pugx.org/cbleek/aviation/license)](https://packagist.org/packages/yawik/demo-skin)

Installation
------------

you can download and use this skin by:

```sh
$ git clone https://github.com/cbleek/Aviation.git MyPath
$ cd MyPath
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
return ['YawikDemoSkin'];
```
