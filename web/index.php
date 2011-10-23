<?php
require realpath(dirname(__FILE__) . '/../') . '/apps/bootstrap.php';

$map = ClassMapperLoader::register();
print_r($map);

$v = new Config();
