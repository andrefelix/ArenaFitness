<?php

$docRoot = $_SERVER['DOCUMENT_ROOT'];

$uri = $_SERVER['REQUEST_URI'];
$dirs = explode('/', $uri);
$appPath = '/' . $dirs['1'] . '/';

set_include_path($docRoot.$appPath);

?>