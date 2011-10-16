<?php

include_once(realpath(__DIR__) . '/../src/nkreloaded/Loader/DirectoryMapper/DirectoryMapper.php');
include_once(realpath(__DIR__) . '/../src/nkreloaded/Loader/ClassLoader.php');


$directoryMapper = new DirectoryMapper;
nkrLoader::register($directoryMapper->setDirectory('src')->setDirectory('../lib'));
