<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Autoloader
{

	public function __construct()
	{
		$this->init_autoloader();
	}

	private function init_autoloader()
	{
		spl_autoload_register(function ($classname) {

			if (strpos($classname, 'Abstract') !== false) {
				strtolower($classname);
				require('application/models/Abstracts/' . $classname . '.php');
			}


			if( strpos($classname,'RecordSet') !== false ){
				strtolower($classname);
				require('application/models/Record_sets/'.$classname.'.php');
			}
		});
	}

}
