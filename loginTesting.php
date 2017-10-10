<?php
// loginTesting.php

require __DIR__.'/vendor/autoload.php';

$client = new \GuzzleHttp\Client([
	'base_url'=> 'http://localhost:8000',
	'defaults'=>[
		'exceptions'=>false,
	]
]);

$username = 'badu';
$password = 'password';
$data = array(
	'username'=>$username,
	'password'=>$password
);
$response = $client->post('/user/login',[
		'body' => json_encode($data)
	]);

echo $response;
echo "\n\n";

?>