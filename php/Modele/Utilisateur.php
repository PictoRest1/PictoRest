<?php
namespace php\Modele;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Utilisateur extends Eloquent {
	protected $table = 'Utilisateur';
	protected $primaryKey = 'idUtil';
	public $timestamps=false;
        
        public function albums() {
            return $this->hasMany('Album');
        }

}