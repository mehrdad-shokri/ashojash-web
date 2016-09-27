<?php namespace App\Http;
class ApiFlash {

	public function create($title, $message, $level, $key = 'api_flash_message')
	{
		session()->flash($key, compact('title', 'message', 'level'));
	}

	public function info($title, $message)
	{
		$this->create($title, $message, 'info');
	}

	public function success($title, $message)
	{
		$this->create($title, $message, 'success');
	}

	public function warning($title, $message)
	{
		$this->create($title, $message, 'warning');
	}

	public function error($title, $message)
	{
		$this->create($title, $message, 'danger');
	}

	public function overlay($title, $message, $level = 'success')
	{
		$this->create($title, $message, $level, 'api_flash_message_overlay');
	}

}