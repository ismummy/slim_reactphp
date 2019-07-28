<?php

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$config['db']['host']   = 'localhost';
$config['db']['username']   = 'user';
$config['db']['password']   = 'password';
$config['db']['database'] = 'exampleapp';
$config['db']['driver'] = 'mysql';
$config['db']['charset'] = 'utf8';
$config['db']['collation'] = 'utf8_unicode_ci';
$config['db']['prefix'] = '';

$config['logger']['path'] = dirname(__DIR__) . '/logs/app.log';
$config['logger']['name'] = 'logger_name';