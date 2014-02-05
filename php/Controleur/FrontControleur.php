<?php
namespace php\Controleur;
\Slim\Slim::registerAutoloader();

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Capsule\Manager as DB;
use php\Modele\Abonne as Abonne;
use php\Modele\Utilisateur as Utilisateur;
use php\Modele\Album as Album;
use php\Modele\Photo as Photo;
//require 'Rest_api.php';

class FrontControleur{
	
	public $app;
	
	public function __construct(){
		$this->SLIM = new \Slim\Slim();
	}
	
	/**
	 * Définit les routes et lance le dispatch
	 */
	public function dispatch(){
		$app = $this->SLIM;
		
                $app->get( '/', function() {
                        echo 'Bienvenue sur PictoRest'; }
                );
                $app->group("/rest", function() use ($app) {
                    $app->get('/users/auth', function() use ($app) {
                        try {
                            $identifiant = $app->request->get('userid');
                            $user = Utilisateur::where('pseudo', '=', $identifiant)->toJson();
                            echo $user;
                        } catch(PDOException $e) {
                            echo '{"error":{"text":'. $e->getMessage() .'}}';
                        }
                    });
                    $app->get( '/users/:id', function($id) use ($app) {
                        try {
                            $user = Utilisateur::find($id)->toJson();
                            echo $user;
                        } catch(PDOException $e) {
                            echo '{"error":{"text":'. $e->getMessage() .'}}';
                        }
                    });

                    $app->get( '/users/:id/feeds', function($id) use ($app) {
                        try {
                            $users = Abonne::where('idUtil', '=', $id)->get();
                            foreach ($users as $user) {
                                echo $user->toJson();
                            }
                        } catch(PDOException $e) {
                            echo '{"error":{"text":'. $e->getMessage() .'}}';
                        }
                    });

                    $app->get( '/users/:id/albums', function($id) use ($app) {
                        try {
                            $albums = Album::where('idUtil', '=', $id)->get();
                            foreach ($albums as $album) {
                                echo $album->toJson();
                            }
                        } catch(PDOException $e) {
                            echo '{"error":{"text":'. $e->getMessage() .'}}';
                        }
                    });

                    $app->get( '/albums', function() use ($app) {
                        try {
                            $albums = Album::all();
                            foreach ($albums as $album) {
                                echo $album->toJson();
                            }
                        } catch(PDOException $e) {
                            echo '{"error":{"text":'. $e->getMessage() .'}}';
                        }
                    });

                    $app->get('/albums', function() use ($app) {
                        try {
                            $term = $app->request->get('filter');
                            $albums = Album::where("libelle like %".$term."%");
                            foreach ($albums as $album) {
                                echo $album->toJson();
                            }
                        } catch(PDOException $e) {
                            echo '{"error":{"text":'. $e->getMessage() .'}}';
                        }
                    });

                    $app->get('/albums/:id', function($id) use ($app) {
                        try {
                            $album = Album::find($id)->toJson();
                            echo $album;
                        } catch(PDOException $e) {
                            echo '{"error":{"text":'. $e->getMessage() .'}}';
                        }
                    });

                    $app->get('/albums/:id/photos', function($id) use ($app) {
                        try {
                            $photos = Photo::where('idAlbum', '=', $id)->get();
                            foreach ($photos as $photo) {
                                echo $photo->toJson();
                            }
                        } catch(PDOException $e) {
                            echo '{"error":{"text":'. $e->getMessage() .'}}';
                        }
                    });

                    $app->post('/users/:id/feeds', function($id) use ($app) {
                            $abonne = new Abonne();
                            $idalbum = $app->request->post('filter');
                            $abonne->idUtil=$id;$abonne->idAlbum=$idalbum;
                            $abonne->save();
                    });
                });

                $app->response->setStatus(200) ;
                $app->response->headers->set('Content-type','application/json') ; 
		
		$app->run();
	}
}