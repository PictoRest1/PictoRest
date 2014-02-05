<?php
namespace php\Modele;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Abonne extends Eloquent {
	protected $table = 'Abonne';
	protected $primaryKey = 'idAbonne';
	public $timestamps=false;


}