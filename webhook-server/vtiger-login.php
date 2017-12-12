<?php
//Код из документации к API vtiger
//https://wiki.vtiger.com/index.php/Webservices_tutorials

require 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

$client = new Client([
    // Base URI is used with relative requests
    'base_uri' => 'http://your.site/vtigercrm/',
    // You can set any number of default request options.
    'timeout'  => 2.0,
]);

//Ключ доступа из настроек пользователя
$userAccessKey = 'XXXXXXXXXXXXXXX';
//username of the user who is to logged in. 
$userName="admin";

//****************************************************
//Get a challenge token from the server. This must be a GET request. 
$response = $client->request('GET', "webservice.php?operation=getchallenge&username=$userName");
$body = $response->getBody();
$jsonResponse=json_decode($body,true);

if($jsonResponse['success']==false) 
    //handle the failure case.
    die('Запрос токена для входа НЕ удался: '.$jsonResponse['error']['message']);

//operation was successful get the token from the reponse.
$challengeToken = $jsonResponse['result']['token'];
//****************************************************

//****************************************************
//Login to server. login request must be POST request.
//create md5 string concatenating user accesskey from my preference page 
//and the challenge token obtained from get challenge result. 
$generatedKey = md5($challengeToken.$userAccessKey);
$response = $client->request('POST', "webservice.php", [
	'form_params' => ['operation'=>'login', 'username'=>$userName, 'accessKey'=>$generatedKey]
]);
$body = $response->getBody();
$jsonResponse = json_decode($body,true);
//operation was successful get the token from the reponse.
if($jsonResponse['success']==false)
    //handle the failure case.
    die('Вход НЕ удался: '.$jsonResponse['error']['message']);
//login successful extract sessionId and userId from LoginResult to it can used for further calls.
$sessionId = $jsonResponse['result']['sessionName']; 
$userId = $jsonResponse['result']['userId'];
//****************************************************
//$output = $sessionId.";".$userId;
//file_put_contents("vtigeradminsession.csv", $output);
?>
