<?php 
namespace Editor/Connector;

class CourseInformationConnector implements Connector {

	protected $connectionUrl = '';

	protected $connectionOptions = array();

	public function __construct($url) 
	{
		$connectionUrl = $url;
	}

	public function setOptions($options) 
	{
		if ( sizeof($options) > 0 ) 
		{
			$connectionOptions = $options;
		}

	}

	public function getContent() 
	{
		$context = stream_context_create(
			['http' => [
				'header'=>'Connection: close\r\n'
				]
			]
		);

		$content = file_get_contents($this->connectionUrl, false, $context);

		return $content;
	}
}
