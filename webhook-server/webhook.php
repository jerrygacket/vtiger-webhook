<?php
//вход в vtiger согласно документации к API
include 'vtiger_login.php';

if (php_sapi_name() == "cli") {
	//~ echo 'cli'.PHP_EOL;
	$action = @$argv[1];
	$form_id = @$argv[2];
	$FormData['lastname'] = @$argv[3];
	$FormData['email'] = @$argv[4];
	$FormData['phone'] = @$argv[5];
	$FormData['description'] = @$argv[6];
}
else {
	//~ echo 'html'.'<br>'.PHP_EOL;
	$action = @$_REQUEST['form'];
	$form_id = @$_REQUEST['savedFormHashKey'];
	//даные из формита. 
  //поля в @$_REQUEST как name в инпутах в форме.
  //поля в $FormData как в vtiger
  $FormData['lastname'] = @$_REQUEST['name'];
	$FormData['email'] = @$_REQUEST['email'];
	$FormData['phone'] = @$_REQUEST['phone'];
	$FormData['description'] = @$_REQUEST['message'];
}

$domain = parse_url(@$_REQUEST['site_url'], PHP_URL_HOST);

//определяем ответственного за обращение.
//если никто не ответственный, то обращение назначавется на весь отдел
$username = '';
$groupname = 'Отдел продаж';
switch ($domain) {
	case 'site1.ru':
		$username = 'ИвановИИ';
		break;
	case 'site2.ru':
		$username = 'ПетровПП';
		break;
	case 'site3.ru':
		$username = 'СидоровСС';
		break;
}

switch ($action) {
    case 'lead':
        //создать лид
		    $FormData['leadstatus'] = "Новый";
        include 'addLead.php';
        break;
    case 'kontakt':
        //добавить контакт;
        break;
    case 'kontragent':
        //добавить контрагента;
        break;
    case 'sdelka':
        echo "добавить сделку";
        break;
}
