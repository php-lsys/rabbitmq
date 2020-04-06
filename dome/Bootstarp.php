<?php
$loader=include_once __DIR__."/../vendor/autoload.php";
LSYS\Config\File::dirs(array(
	__DIR__."/config",
));	
$loader->setPsr4('', array(__DIR__ . '/proto'));
return $loader;

