<?php 
namespace Editor/Connector;

interface Connector {

	public function __construct($url);

	public function setOptions($options);

	public function getContent();
}
