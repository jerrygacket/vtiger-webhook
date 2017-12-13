<?php
//Код поиска ид пользователей и создания обращения из документации к API vtiger
//https://wiki.vtiger.com/index.php/Webservices_tutorials

if (empty($FormData['lastname'])) {
	echo 'Не указан обязательный параметр: Фамилия или название организации'.PHP_EOL;
	exit;
}

//****************************************************
//Находим ид пользовталея или группы, которая будет ответственная за обращения
if (empty($username)) {
	$query = "select id from Groups where groupname='$groupname';";
}
else {
	$query = "select id from Users where user_name='$username';"; //ищем по логину
}
$queryParam = urlencode($query);
$params = "sessionName=$sessionId&operation=query&query=$queryParam";
$response = $client->request('GET', "webservice.php?$params");
$body = $response->getBody();
$jsonResponse = json_decode($body,true);

if($jsonResponse['success']==false)
    //handle the failure case.
    die('Поиск НЕ удался:'.$jsonResponse['error']['message']);

//Array of vtigerObjects
$retrievedObjects = $jsonResponse['result'];
$AssignedUserId = $retrievedObjects[0]['id'];
//print_r($retrievedObjects);
//****************************************************

//****************************************************
//***Создаем обращение
//encode the object in JSON format to communicate with the server.
$FormData['assigned_user_id'] = $AssignedUserId;	//ответственный
$objectJson = json_encode($FormData);
//name of the module for which the entry has to be created.
$moduleName = 'Leads';
//sessionId is obtained from loginResult.
$params = array("sessionName"=>$sessionId, "operation"=>'create', 
	"element"=>$objectJson, "elementType"=>$moduleName);
//Create must be POST Request.
$response = $client->request('POST', "webservice.php", [
	'form_params' => $params
]);
//decode the json encode response from the server.
$body = $response->getBody();
$jsonResponse = json_decode($body,true);

//operation was successful get the token from the reponse.
if($jsonResponse['success']==false)
	//handle the failure case.
	die('Обращение НЕ создано:'.$jsonResponse['error']['message']);
$savedObject = $jsonResponse['result'];
$id = $savedObject['lead_no'];
echo "Обращение номер $id успешно создано".PHP_EOL;
//print_r($savedObject);
//****************************************************
