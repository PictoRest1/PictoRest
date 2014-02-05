<?php
namespace pictorest\Modele;

class Photo extends Eloquent {
	protected $table = 'Photo';
	protected $primaryKey = 'idPhoto';
	public $timestamps=false;
        
        public function album() {
            return $this->belongsTo('Album');
        }
        
        public function user() {
            return $this->belongsTo('Utilisateur');
        }

}