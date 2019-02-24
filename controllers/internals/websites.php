<?php

namespace controllers\internals;

use \models\websites as Modelwebsites;

class websites extends \InternalController
{

	public function __construct(\PDO $pdo)
	{
		$this->model_websites = new Modelwebsites($pdo);
	}

	public function add_website($url)
	{
		return $this->model_websites->add_website($url);
	}

	public function delete_website($id)
	{
		return $this->model_websites->delete_website($id);
	}

	public function my_liste()
	{
		return $this->model_websites->get_all_websites();
	}

	public function get_data_by_url($url)
	{
		return $this->model_websites->get_data_by_url($url);
	}

	public function get_log_with_website($uid)
	{
		return $this->model_websites->get_log_with_website($uid);
	}
}
