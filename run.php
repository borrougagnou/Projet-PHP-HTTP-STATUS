<?php

function send_mail($error_code, $server)
{
	$headers= 'MIME-Version: 1.0' . '\r\n';
	$headers .= 'Content-type:text/html;charset=UTF-8' . '\r\n';

	$to = 'trucbidule@grr.la';
	$subject= 'erreur avec le serveur';

	$body = 'Une erreur est survenue avec le serveur ';
	$body.= '"' . $server . '". ';
	$body.= 'code erreur:' . $error_code . '.';

	mail($to, $subject, $body, $headers);
}

try
{
	$dbhost = 'localhost';
	$dbname = 'garnier_rougagnou';
	$dbuser = 'root';
	$dbpass = 'bernardbernard';
	$connexion = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);

	$tmpurl = "";
	foreach($connexion->query("SELECT websites.url, status, time FROM websites LEFT JOIN logs ON websites.url = logs.url ORDER BY logs.url DESC, logs.time DESC;") as $row)
	{
		send_mail('404', $row['url']);
		if ($tmpurl != $row['url'])
			$tmpurl = $row['url'];
	}
}
catch (Exception $e)
{
	echo "Erreur: Impossible de se connecter à la BDD";
	die();
}
