<?php
namespace php\Modele;
use Illuminate\Database\Capsule\Manager as DB;

class ConnectionFactory{
	public static function getConnection(){
            $caps = new DB;
            $caps->addConnection( array(
                'driver' => 'mysql',
                'host' => 'localhost',
                'database' => 'database',
                'username' => 'root',
                'password' => '',
                'charset' => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix' => '',
            ));
            $caps->setAsGlobal();
            $caps->bootEloquent();
	}
}