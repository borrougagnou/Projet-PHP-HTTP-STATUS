<?php

namespace models;

class websites extends \Model
{
	public function get_data_by_admin($apikey)
	{
		return $this->get_one("admins", ["apikey" => $apikey]);
	}

	public function add_website($url)
	{
		return $this->insert("websites", ['url' => $url]);
	}

	public function delete_website($id)
	{
		return $this->delete("websites", ['id' => $id]);
	}

	public function get_all_websites()
	{
		return $this->get("websites");
	}

	public function get_data_by_url($url)
	{
		return $this->get_one("websites", ["url" => $url]);
	}

	public function get_log_with_website($uid)
	{
		$querytest  = 'SELECT websites.id, websites.url, logs.status, logs.time FROM websites ';
		$querytest .= 'LEFT JOIN logs ON websites.url = logs.url ';
		$querytest .= 'WHERE websites.id = ' . $uid . ' ORDER BY logs.id DESC;';
		return $this->run_query($querytest);
	}
}
