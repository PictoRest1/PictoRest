<?php
namespace Modele;

class Album extends Eloquent {
	protected $table = 'Album';
	protected $primaryKey = 'idAlbum';
	public $timestamps=false;
        
        public function photos() {
            return $this->hasMany('Photo');
        }

}