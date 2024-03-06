<?php

abstract class HttpBox
{
	private $requestMethod;
	private $url;
	private $parameter;

	public function __construct($requestMethod, $url, $parameter)
	{
		$this->requestMethod = $requestMethod;
		$this->url = $url;
		$this->parameter = $parameter;
	}

	public function execute()
	{
		if ($this->requestMethod == "GET") {
			$this->get();
		} else if ($this->requestMethod == "POST") {
			$this->post();
		} else if ($this->requestMethod == "PUT") {
			$this->put();
		} else if ($this->requestMethod == "DELETE") {
			$this->delete();
		}
	}

	public function getParameterValue($parameterName)
	{
		if ($this->parameter != null) {
			return $this->parameter[$parameterName];
		} else {
			return null;
		}
	}

	public abstract function get();

	public abstract function post();

	public abstract function put();

	public abstract function delete();

	protected function render(){}
}