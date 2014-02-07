<?php
namespace php\Modele;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Photo extends Eloquent {
	protected $table = 'Photo';
	protected $primaryKey = 'idPhoto';
	public $timestamps=false;
        
        public function album() {
            return $this->belongsTo('Album','idAlbum');
        }
        
        public function user() {
            return $this->belongsTo('Utilisateur');
        }

}