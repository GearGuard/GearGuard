<?php declare(strict_types=1);

use GearGurd\Framework\Http\Request;
use GearGurd\Framework\Http\Response;
use GearGurd\Framework\Http\Kernel;

require_once dirname(__DIR__). '/vendor/autoload.php';

//Request Received
$request = \GearGurd\Framework\Http\Request::createFromGlobals();
//print_r($request);

// process request



// send response (string of content)
//$content = '<h1>Hello World</h1>';
//$response = new \GearGurd\Framework\Http\Response(content: $content, status:200, header:[]);
$kernel = new \GearGurd\Framework\Http\Kernel();

$response = $kernel->handle($request);
$response->send();



