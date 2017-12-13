<?php
require 'vendor/autoload.php';

use Fabiang\Xmpp\Options;
use Fabiang\Xmpp\Client;
use Fabiang\Xmpp\Protocol\Roster;
use Fabiang\Xmpp\Protocol\Presence;
use Fabiang\Xmpp\Protocol\Message;

$address = 'tcp://jabber.server.com:5222';
$username = 'user';
$password = 'password';

$options = new Options($address);
$options->setUsername($username)
    ->setPassword($password)
    ->setTo('localhost'); //сюда пишется домен, где пользователи. То, что после собаки в логине.

//нужно для ссл подключения
$options->setContextOptions(['ssl' => ['verify_peer' => false,'verify_peer_name' => false]]);

$client = new Client($options);

// send a message to another user
foreach ($recipients as $recipient) {
	$message = new Message;
	$message->setMessage($jabbermessage)
		->setTo($recipient);
	$client->send($message);
}

$client->disconnect();
