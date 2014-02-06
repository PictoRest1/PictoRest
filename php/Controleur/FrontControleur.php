<?php
namespace php\Controleur;
\Slim\Slim::registerAutoloader();

use Illuminate\Database\Eloquent\ModelNotFoundException;
use php\Modele\Abonne as Abonne;
use php\Modele\Utilisateur as Utilisateur;
use php\Modele\Album as Album;
use php\Modele\Photo as Photo;

class FrontControleur{
	
	public $app;
	private $twig;
	public function __construct(){
                $this->loader = new \Twig_Loader_Filesystem('Vue');
                $this->twig = new \Twig_Environment($this->loader, array('debug' => true));
		$this->SLIM = new \Slim\Slim();
	}
	
	/**
	 * Définit les routes et lance le dispatch
	 */
	public function dispatch(){
		$app = $this->SLIM;
		$loader=  $this->loader;
                $twig=  $this->twig;
                        
                $app->get( '/', function() {
                     $tmpl = $this->twig->loadTemplate('Home.html.twig');
                     echo $tmpl->render(array());                     
                 });
                 
                 $app->get( '/profile', function() {
                    $id = /*$_SESSION['idUtil']*/1; 
                    $albums = Album::where('idUtil', '=', $id);
                    
                    $tmpl = $this->twig->loadTemplate('Profile.html.twig');
                    $tmpl->display(array("album"=>$albums));
                 });
                 
                $app->get( '/user/:id', function($id) {
                    try {
                        $user = Utilisateur::find($id)->toJson();
                        echo $user;
                    } catch(PDOException $e) {
                        echo '{"error":{"text":'. $e->getMessage() .'}}';
                    } catch (ModelNotFoundException $e) {
                        echo '{"error":{"text":'. $e->getMessage() .'}}';
                    }
                });
                
                $app->get( '/album/:id', function($id) {
                    try {
                        $album = Album::find($id)->toJson();
                        echo $album;
                    } catch(PDOException $e) {
                        echo '{"error":{"text":'. $e->getMessage() .'}}';
                    } catch (ModelNotFoundException $e) {
                        echo '{"error":{"text":'. $e->getMessage() .'}}';
                    }
                });
                
                $app->get( '/photo/:id', function($id) {
                    try {
                        $photo = Photo::find($id)->toJson();
                        echo $photo;
                    } catch(PDOException $e) {
                        echo '{"error":{"text":'. $e->getMessage() .'}}';
                    } catch (ModelNotFoundException $e) {
                        echo '{"error":{"text":'. $e->getMessage() .'}}';
                    }
                });
                
                $app->get( '/ajoutalbum', function() use ($app) {
                    try {
                        $album = new Album();
                        $id =1 ;//$_SESSION['idUtil'];
                        $libelle = $app->request->post('libelle');
                        $album->libelle=$libelle;$album->idUtil=$id;$album->date=date(Y-m-d);
                        $album->save();
                        echo "Album créé !";
                    } catch(PDOException $e) {
                        echo '{"error":{"text":'. $e->getMessage() .'}}';
                    }
                });
                
                $app->get( '/ajoutphoto', function() use ($app) {
                    try {
                        $photo = new Photo();
                        $libelle = $app->request->post('libelle');
                        $description = $app->request->post('description');
                        $id = $app->request->post('idAlbum');
                        $photo->libelle=$libelle;$photo->description=$description;$photo->date=date(Y-m-d);$photo->idAlbum=$id;
                        $photo->save();
                        echo "Photo ajoutée !";
                    } catch(PDOException $e) {
                        echo '{"error":{"text":'. $e->getMessage() .'}}';
                    }
                });
                
                $app->get( '/ajoutuser', function() use ($app) {
                    try {
                        $user = new Utilisateur();
                        $pseudo = $app->request->post('pseudo');
                        $mail = $app->request->post('mail');
                        $mdp = sha1($app->request->post('mdp'));
                        $user->pseudo=$pseudo;$user->mail=$mail;$user->mdp=$mdp;
                        $user->save();
                        echo "Utilisateur ajouté !";
                    } catch(PDOException $e) {
                        echo '{"error":{"text":'. $e->getMessage() .'}}';
                    }
                });
                
                $app->get( '/deletephoto', function() use ($app) {
                    try {
                        $id = $app->request->post('idPhoto');
                        $photo = Photo::find($id);
                        $photo->delete();
                        echo "Photo supprimée !";
                    } catch(PDOException $e) {
                        echo '{"error":{"text":'. $e->getMessage() .'}}';
                    } catch (ModelNotFoundException $e) {
                        echo '{"error":{"text":'. $e->getMessage() .'}}';
                    }
                });
                
                $app->get( '/deletealbum', function() use ($app) {
                    try {
                        $id = $app->request->post('idAlbum');
                        $album = Album::find($id);
                        $photos = Photo::findAll()->where('idAlbum', '=', $id);
                        foreach ($photos as $photo) {
                            $photo->delete();
                        }
                        $album->delete();
                        echo "Album supprimé !";
                    } catch(PDOException $e) {
                        echo '{"error":{"text":'. $e->getMessage() .'}}';
                    } catch (ModelNotFoundException $e) {
                        echo '{"error":{"text":'. $e->getMessage() .'}}';
                    }
                });
                
                $app->get( '/deleteuser', function() use ($app) {
                    try {
                        $id = $app->request->post('idUtil');
                        $user = Utilisateur::find($id);
                        $albums = Album::findAll()->where('idUtil', '=', $id);
                        foreach ($albums as $album) {
                            $idAl = $album->id;
                            $photos = Photo::findAll()->where('idAlbum', '=', $idAl);
                            foreach ($photos as $photo) {
                                $photo->delete();
                            }
                            $album->delete();
                        }
                        $user->delete();
                        echo "Utilisateur supprimé !";
                    } catch(PDOException $e) {
                        echo '{"error":{"text":'. $e->getMessage() .'}}';
                    } catch (ModelNotFoundException $e) {
                        echo '{"error":{"text":'. $e->getMessage() .'}}';
                    }
                });
                
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

                    $app->get( '/users/:id/feeds', function($id) {
                        try {
                            $users = Abonne::where('idUtil', '=', $id)->get();
                            foreach ($users as $user) {
                                echo $user->toJson();
                            }
                        } catch(PDOException $e) {
                            echo '{"error":{"text":'. $e->getMessage() .'}}';
                        }
                    });

                    $app->get( '/users/:id/albums', function($id) {
                        try {
                            $albums = Album::where('idUtil', '=', $id)->get();
                            foreach ($albums as $album) {
                                echo $album->toJson();
                            }
                        } catch(PDOException $e) {
                            echo '{"error":{"text":'. $e->getMessage() .'}}';
                        }
                    });

                    $app->get( '/albums', function() {
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

                    $app->get('/albums/:id', function($id) {
                        try {
                            $album = Album::find($id)->toJson();
                            echo $album;
                        } catch(PDOException $e) {
                            echo '{"error":{"text":'. $e->getMessage() .'}}';
                        }
                    });

                    $app->get('/albums/:id/photos', function($id) {
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
                        try {
                            $abonne = new Abonne();
                            $idalbum = $app->request->post('filter');
                            $abonne->idUtil=$id;$abonne->idAlbum=$idalbum;
                            $abonne->save();
                        } catch (ModelNotFoundException $e) {
                            echo '{"error":{"text":'. $e->getMessage() .'}}';
                        }
                    });
                });

                $app->response->setStatus(200) ;
                $app->response->headers->set('Content-type','text/html') ; 
		
		$app->run();
	}
}