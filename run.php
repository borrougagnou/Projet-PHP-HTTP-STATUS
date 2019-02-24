<?php

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
		if ($tmpurl != $row['url'])
			$tmpurl = $row['url'];
	}
}
catch (Exception $e)
{
	echo "Erreur: Impossible de se connecter à la BDD";
	die();
}
