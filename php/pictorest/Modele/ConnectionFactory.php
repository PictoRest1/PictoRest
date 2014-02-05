<?php
namespace Modele;
use Illuminate\Database\Capsule\Manager as DB;

class ConnectionFactory{
	public static function getConnection(){
		$conf_file = 'database.ini';
		$config = parse_ini_file($conf_file);

		if(!$config) throw new Exception("App::getConnection : could not load config file");

		$capsule = new DB();
		$capsule->addConnection($config);
		$capsule->setAsGlobal();
		$capsule->bootEloquent();
	}
}