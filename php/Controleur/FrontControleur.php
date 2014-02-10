<?php
namespace php\Controleur;

session_start();
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
                $this->twig->addGlobal("session", $_SESSION);
	}
	
	/**
	 * Définit les routes et lance le dispatch
	 */
	public function dispatch(){
		$app = $this->SLIM;
		$loader=  $this->loader;
                $twig=  $this->twig;
                        
                $app->get( '/', function() {
                    $photos=Photo::all()->take(10);
                    $albums=Album::all()->take(10);
                    $abonnes=Abonne::all();
                     $tmpl = $this->twig->loadTemplate('Home.html.twig');
                     echo $tmpl->render(array("albums"=>$albums,"photos"=>$photos,"abonnes"=>$abonnes));                     
                 });
                 
                 $app->get( '/profile', function() {
                    $id = $_SESSION['idUtil']; 
                    $albums = Album::where('idUtil', '=', $id)->get();
                    $lastalbum=Album::where('idUtil', '=', $id)->orderBy('idAlbum', 'desc')->first();
                    $tmpl = $this->twig->loadTemplate('Profile.html.twig');
                    $tmpl->display(array("albums"=>$albums,"lastalbum"=>$lastalbum));
                 });
                 
                $app->get( '/user/:id', function($id) {
                    try {
                        $user = Utilisateur::find($id)->first()->toJson();
                        echo $user;
                    } catch(PDOException $e) {
                        echo '{"error":{"text":'. $e->getMessage() .'}}';
                    } catch (ModelNotFoundException $e) {
                        echo '{"error":{"text":'. $e->getMessage() .'}}';
                    }
                });
                
                $app->get( '/album/:id', function($id) {
                    try {
                        $album = Album::find($id)->first();
                        if(!empty($album)){
                            echo $album->toJson();
                        }
                    } catch(PDOException $e) {
                        echo '{"error":{"text":'. $e->getMessage() .'}}';
                    } catch (ModelNotFoundException $e) {
                        echo '{"error":{"text":'. $e->getMessage() .'}}';
                    }
                });
                
                $app->get( '/photo/:id', function($id) {
                    try {
                        $photo = Photo::find($id)->first()->toJson();
                        echo $photo;
                    } catch(PDOException $e) {
                        echo '{"error":{"text":'. $e->getMessage() .'}}';
                    } catch (ModelNotFoundException $e) {
                        echo '{"error":{"text":'. $e->getMessage() .'}}';
                    }
                });
                
                $app->post( '/ajoutalbum', function() use ($app) {
                    try {
                        $album = new Album();
                        $id = $_SESSION['idUtil'];
                        $libelle = $app->request->post('libelle');
                        $album->libelle=$libelle;$album->idUtil=$id;$album->date=date("Y-m-d");
                        $album->save();
                       
                    } catch(PDOException $e) {
                        echo '{"error":{"text":'. $e->getMessage() .'}}';
                    }
                });
                
                $app->post( '/ajoutphoto', function() use ($app) {
                    try {
                        $imagename = $_FILES["photo"]["name"];            
                        $unique_id = md5(uniqid(rand(), true));
                        $filetype = strrchr($imagename, '.');
                        $new_upload = 'upload' . $unique_id . $filetype;
                        move_uploaded_file($_FILES["photo"]["tmp_name"], "images/".$new_upload);
                     
                     
                        $photo = new Photo();
                        $libelle = $_POST["nom_photo"];
                        $description = $_POST["description_photo"];
                        $id = $_POST["idAlbum"];
                        $photo->libelle=$libelle;$photo->description=$description;$photo->date=date("Y-m-d");$photo->idAlbum=$id;
                        $photo->url="images/".$new_upload;
                        $photo->save();
                        
                       
                    } catch(PDOException $e) {
                        echo '{"error":{"text":'. $e->getMessage() .'}}';
                    }
                });
                
                $app->post( '/ajoutuser', function() use ($app) {
                    try {
                        $user = new Utilisateur();
                        $pseudo = $app->request->post('pseudo');
                        $mail = $app->request->post('mail');
                        $mdp = sha1($app->request->post('mdp'));
                        $mdp2 = sha1($app->request->post('mdp2'));
                        $user2 = Utilisateur::where('idUtil', '=', $pseudo)->first();
                        if (empty($user2) && ($mdp == $mdp2)) {
                            $user->pseudo=$pseudo;$user->email=$mail;$user->mdp=$mdp;
                            $user->save();
                            echo "Utilisateur ajouté !";
                            $app->redirect ('/PictoRest/');
                        } else {
                            echo "Erreur dans l'inscription";
                        }
                    } catch(PDOException $e) {
                        echo '{"error":{"text":'. $e->getMessage() .'}}';
                    }
                });
                
                $app->post( '/ajoutabonnement', function() use ($app) {
                    try {
                        $abonne = new Abonne();
                        $idal = $app->request->post('idAlbum');
                        $iduser = $_SESSION['idUtil'];
                        $abonne2 = Abonne::where('idUtil', '=', $iduser)->where('idAlbum', '=', $idal)->first();
                        if (empty($abonne2)) {
                            $abonne->idUtil=$iduser;$abonne->idAlbum=$idal;
                            $abonne->save();
                            echo "Abonnement ajouté !";
                        } else {
                            echo "Vous êtes déjà abonné";
                        }
                    } catch(PDOException $e) {
                        echo '{"error":{"text":'. $e->getMessage() .'}}';
                    }
                });
                
                $app->post( '/deleteabonnement', function() use ($app) {
                    try {
                        $ida = $app->request->post('idAlbum');
                        $idu = $_SESSION['idUtil'];
                        $abonne = Abonne::where('idAlbum', '=', $ida)->where('idUtil', '=', $idu)->first();
                        $abonne->delete();
                        echo "Abonnement supprimé !";
                    } catch(PDOException $e) {
                        echo '{"error":{"text":'. $e->getMessage() .'}}';
                    } catch (ModelNotFoundException $e) {
                        echo '{"error":{"text":'. $e->getMessage() .'}}';
                    }
                });
                
                $app->post( '/deletephoto', function() use ($app) {
                    try {
                        $id = $app->request->post('idPhoto');
                        $photo = Photo::find($id)->first();
                        $photo->delete();
                        echo "Photo supprimée !";
                        $app->redirect ('/PictoRest/profile');
                    } catch(PDOException $e) {
                        echo '{"error":{"text":'. $e->getMessage() .'}}';
                    } catch (ModelNotFoundException $e) {
                        echo '{"error":{"text":'. $e->getMessage() .'}}';
                    }
                });
                
                $app->post( '/deletealbum', function() use ($app) {
                    try {
                        $id = $app->request->post('idAlbum');
                        $album = Album::find($id);
                        $photos = Photo::where('idAlbum', '=', $id)->get();
                        foreach ($photos as $photo) {
                            $photo->delete();
                        }
                        $album->delete();
                        
                       
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
                        $albums = Album::where('idUtil', '=', $id)->get();
                        foreach ($albums as $album) {
                            $idAl = $album->id;
                            $photos = Photo::where('idAlbum', '=', $idAl)->get();
                            foreach ($photos as $photo) {
                                $photo->delete();
                            }
                            $album->delete();
                        }
                        $user->delete();
                        echo "Utilisateur supprimé !";
                        $app->redirect ('/PictoRest/');
                    } catch(PDOException $e) {
                        echo '{"error":{"text":'. $e->getMessage() .'}}';
                    } catch (ModelNotFoundException $e) {
                        echo '{"error":{"text":'. $e->getMessage() .'}}';
                    }
                });
                
                $app->post( '/connexion', function() use ($app) {
                    try {
                        $pseudo = $app->request->post('pseudo');
                        $mdp = sha1($app->request->post('mdp'));
                        $user = Utilisateur::where('pseudo', '=', $pseudo)->where('mdp', '=', $mdp)->first();
                        if (isset($user) && !empty($user)) {
                            $_SESSION['user'] = $user;
                            $_SESSION['idUtil'] = $user->idUtil;
                            echo "Connexion réussie !";
                            $app->redirect ('/PictoRest/profile');
                        } else {
                            echo "Erreur dans la connexion";
                        }
                    } catch(PDOException $e) {
                        echo '{"error":{"text":'. $e->getMessage() .'}}';
                    } catch (ModelNotFoundException $e) {
                        echo '{"error":{"text":'. $e->getMessage() .'}}';
                    }
                });
                
                $app->get("/deco", function() use ($app) {
                    try {
                        session_destroy();
                        $app->redirect ('/PictoRest/');
                    } catch(PDOException $e) {
                        echo '{"error":{"text":'. $e->getMessage() .'}}';
                    }
                });
                
                $app->group("/rest", function() use ($app) {
                    $app->get('/users/auth', function() use ($app) {
                        try {
                            $identifiant = $app->request->get('userid');
                            $user = Utilisateur::where('pseudo', '=', $identifiant)->first()->toJson();
                            $app->redirect ('/PictoRest/profile');
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

                    $app->get('/albumss', function() use ($app) {
                        try {
                            $term = $app->request->get('query');
                           
                            $albums = Album::where("libelle","like","%".$term."%")->get()->toJson();
                           
                                                        
                           echo ($albums);
                            
                        } catch(PDOException $e) {
                            echo '{"error":{"text":'. $e->getMessage() .'}}';
                        }
                    });

                    $app->get('/albums/:id', function($id) {
                        try {
                            $album = Album::find($id)->first()->toJson();
                            echo $album;
                        } catch(PDOException $e) {
                            echo '{"error":{"text":'. $e->getMessage() .'}}';
                        }
                    });

                    $app->get('/albums/:id/photos', function($id) {
                        try {
                      
                            $photos = Photo::where('idAlbum', '=', $id)->get()->toJson();
                         
                            echo $photos;
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
  
