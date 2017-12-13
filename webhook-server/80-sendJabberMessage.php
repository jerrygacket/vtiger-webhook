<?php
require 'vendor/autoload.php';

use Fabiang\Xmpp\Options;
use Fabiang\Xmpp\Client;
use Fabiang\Xmpp\Protocol\Roster;
use Fabiang\Xmpp\Protocol\Presence;
use Fabiang\Xmpp\Protocol\Message;

$address = 'tcp://ast.1dplab.ru:5222';
$username = 'kanboard';
$password = 'st0p9x@@';
//$recipients = array('kryuchkovas@172.0.0.55');

$options = new Options($address);
$options->setUsername($username)
    ->setPassword($password)
    ->setTo('172.0.0.55');

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
