<?php
namespace pictorest\Modele;

class Utilisateur extends Eloquent {
	protected $table = 'Utilisateur';
	protected $primaryKey = 'idutil';
	public $timestamps=false;
        
        public function albums() {
            return $this->hasMany('Album');
        }

}