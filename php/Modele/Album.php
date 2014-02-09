<?php
namespace php\Modele;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Album extends Eloquent {
	protected $table = 'Album';
	protected $primaryKey = 'idAlbum';
	public $timestamps=false;
        
        public function photos() {
            return $this->hasMany('Photo','idAlbum');
        }

}