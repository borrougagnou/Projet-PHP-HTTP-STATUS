<?php
namespace controllers\publics;

use controllers\internals\websites as Internalwebsites;

class Ping extends \Controller
{
	public function __construct(\PDO $pdo)
	{
		parent::__construct($pdo);
		$this->internal_websites = new Internalwebsites($pdo);
	}

	public function is_positive_integer($str)
	{
		return (is_numeric($str) && $str >= 0 && $str == round($str));
	}

	public function check_uid($uid)
	{
		$uid = $uid ?? false;

		if (!$this->is_positive_integer($uid))
		{
			$msg = "Id:{$uid} n'est pas un nombre valide";
			return $this->render('ping/echec', ['message' => $msg]);
			return false;
		}
		return true;
	}

	public function send_mail($error_code, $server)
	{
		$headers  = 'MIME-Version: 1.0' . '\r\n';
		$headers .= 'Content-type:text/html;charset=UTF-8' . '\r\n';

		$to       = 'trucbidule@grr.la';
		$subject  = 'erreur avec le serveur';

		$body     = 'Une erreur est survenue avec le serveur ';
		$body    .= '"' . $server . '". ';
		$body    .= 'code erreur:' . $error_code . '.';

		mail($to, $subject, $body, $headers);
	}


// PARTIE HTML

	public function home()
	{
		$result = $this->internal_websites->my_liste();
		$nb_websites = count($result);

		// ENVOYEZ EMAIL
//		$this->send_mail(404, "serveuràlacon");
		return $this->render("ping/home", ['result' => $result, 'nbsites' => $nb_websites]);
	}

	public function addhtml()
	{
		$url = $_POST['url'] ?? false;

		if ($url)
		{
			if (!filter_var($url, FILTER_VALIDATE_URL))
			{
				$url = 'error';
				return $this->render('ping/add', ['url' => $url]);
			}

			$result = $this->internal_websites->get_data_by_url($url);
			if (!empty($result))
			{
				$url = 'exist';
				return $this->render('ping/add', ['url' => $url]);
			}

			$this->internal_websites->add_website($url);
		}
		return $this->render("ping/add", ['url' => $url]);
	}

	public function statushtml(string $uid)
	{
		if (!$this->check_uid($uid))
			return false;

		$query = $this->internal_websites->get_log_with_website($uid);

		if (!isset($myJson))
			$elem = new \stdClass();
		$elem->id = intval($uid);
		$elem->url = $query[0]['url'];
		$elem->code = intval($query[0]['status']);
		$elem->at = $query[0]['time'];

		return $this->render('ping/status', ['elem' => $elem]);
	}

	public function historyhtml(string $uid)
	{
		if (!$this->check_uid($uid))
			return false;

		$query = $this->internal_websites->get_log_with_website($uid);
		return $this->render('ping/history', ['uid' => $uid, 'query' => $query]);
	}

// PARTIE API

	public function api()
	{
		if (!isset($myJson))
			$myJson = new \stdClass();

		$myJson->version = 1;
		$myJson->list = \Router::url('Ping', 'liste');

		return $this->render('ping/api', ['myJson' => $myJson]);
	}

	public function liste()
	{
		$result = $this->internal_websites->my_liste();
		$nb_websites = count($result);

		if (!isset($myJson))
			$myJson = new \stdClass();

		$myJson->version = 1;

		for ($i = 0; $i < $nb_websites; $i++)
		{
			if (!isset($myJson->websites[$i]))
				$myJson->websites[$i] = new \stdClass();

			$myid = intval($result[$i]['id']);

			$myJson->websites[$i]->id = $myid;
			$myJson->websites[$i]->url = $result[$i]['url'];
			$myJson->websites[$i]->delete = \Router::url('Ping', 'mydelete', ['uid' => $myid]);
			$myJson->websites[$i]->status = \Router::url('Ping', 'mystatus', ['uid' => $myid]);
			$myJson->websites[$i]->history = \Router::url('Ping', 'myhistory', ['uid' => $myid]);
		}

		return $this->render('ping/api', ['myJson' => $myJson]);
	}

	public function myadd()
	{
		$url = $_POST['url'] ?? false;
		if (!isset($myJson))
			$myJson = new \stdClass();

		if ($url)
		{
			$myJson->success = false;
			if (!filter_var($url, FILTER_VALIDATE_URL))
			{
				$msg = "{$url} n'est pas une url valide";
				return $this->render('ping/echec', ['message' => $msg]);
			}

			$result = $this->internal_websites->get_data_by_url($url);
			if (!empty($result))
			{
				
				$msg = "{$url} existe déjà dans la base de donnée";
				return $this->render('ping/echec', ['message' => $msg]);
			}

			$this->internal_websites->add_website($url);
			$query = $this->internal_websites->get_data_by_url($url);

			$myJson->success = true;
			$myJson->id = $query;
			return $this->render('ping/api', ['myJson' => $myJson]);
		}
	}

	public function mydelete(string $uid)
	{
		if (!$this->check_uid($uid))
			return false;

		$this->internal_websites->delete_website($uid);

		if (!isset($myJson))
			$myJson = new \stdClass();

		$myJson->success = true;

		return $this->render('ping/api', ['myJson' => $myJson]);
	}

	public function mystatus(string $uid)
	{
		if (!$this->check_uid($uid))
			return false;

		//$query = retour sql logs + website avec LEFT JOIN,
		$query = $this->internal_websites->get_log_with_website($uid);
		if (!isset($myJson))
			$myJson = new \stdClass();

		$myJson->id = intval($uid);
		$myJson->url = $query[0]['url'];

		if (!isset($myJson->status))
			$myJson->status = new \stdClass();
		$myJson->status->code = intval($query[0]['status']);
		$myJson->status->at = $query[0]['time'];

		return $this->render('ping/api', ['myJson' => $myJson]);
	}

	public function myhistory(string $uid)
	{
		if (!$this->check_uid($uid))
			return false;

		$result = $this->internal_websites->get_log_with_website($uid);

//#################### ICI FONCTION DE TEST ##################//
/*
		$result = array(
			array(
				'id' => '1',
				'name_website' => 'google',
				'url' => 'https://google.com',
				'status' => '200',
				'time' => "2004-01-01 23:59:59",
			),
			array(
				'id' => '2',
				'name_website' => 'google',
				'url' => 'https://google.com',
				'status' => '200',
				'time' => "2005-03-11 23:59:59",
			),
			array(
				'id' => '3',
				'name_website' => 'google',
				'url' => 'https://google.com',
				'status' => '200',
				'time' => "2006-12-06 23:59:59",
			),
			array(
				'id' => '4',
				'name_website' => 'google',
				'url' => 'https://google.com',
				'status' => '200',
				'time' => "2004-01-01 23:59:59",
			),
			array(
				'id' => "5",
				'name_website' => 'yahoo',
				'url' => 'https://yahoo.com',
				'status' => '404',
				'time' => "2012-01-01 23:59:59",
			),
			array(
				'id' => "NULL",
				'name_website' => 'youtube',
				'url' => 'https://www.youtube.com',
				'status' => 'NULL',
				'time' => 'NULL',
			),
			array(
				'id' => "NULL",
				'name_website' => 'truc',
				'url' => 'https://truc.com',
				'status' => 'NULL',
				'time' => 'NULL',
			),
			array(
				'id' => "NULL",
				'name_website' => 'bidule',
				'url' => 'https://bidule.com',
				'status' => 'NULL',
				'time' => 'NULL',
			),
		);
*/
//################################################################//

		$nb_logs = count($result);

		if (!isset($myJson))
			$myJson = new \stdClass();

		$myJson->id = intval($uid);
		$myJson->url = $result['0']['url'];

		for ($i = 0; $i < $nb_logs; $i++)
		{
			if ($result[$i]['id'] == 'NULL')
				return $this->render('ping/api', ['myJson' => $myJson]);

			if (!isset($myJson->status[$i]))
				$myJson->status[$i] = new \stdClass();
			$myJson->status[$i]->code = intval($result[$i]['status']);
			$myJson->status[$i]->at = $result[$i]['time'];
		}

		return $this->render('ping/api', ['myJson' => $myJson]);
	}
}
