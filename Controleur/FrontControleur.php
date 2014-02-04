<?php
namespace controleur;
require "Rest_api.php";

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

                $app->get( '/rest/users', function() use ($app) {
                        $c = new Rest_api($app) ;
                        $c->processApi(); }
                );

                $app->get( '/rest/users/:id/feeds', function($id) use ($app) {
                        $c = new Rest_api($app) ;
                        $c->get($id) ;}
                );

                $app->get( '/rest/users/:id/albums', function($id) use ($app) {
                        $c = new Rest_api($app) ;
                        $c->get($id) ;}
                );

                $app->get( '/rest/albums', function() use ($app) {
                        $c = new Rest_api($app) ;
                        $c->get() ; }
                );

                $app->get('/rest/albums?filter=<term>', function() use ($app) {
                        $c = new Rest_api($app) ;
                        $c->get($id) ;}
                );

                $app->get('/rest/albums/:id', function($id) use ($app) {
                        $c = new Rest_api($app) ;
                        $c->get($id) ;}
                );

                $app->get('/rest/albums/:id/photos', function($id) use ($app) {
                        $c = new Rest_api($app) ;
                        $c->get($id) ;}
                );

                $app->post('/rest/users/:id/feeds', function($id) use ($app) {
                        $c = new Rest_api($app) ;
                        $c->post($id) ;}
                );

                $app->response->setStatus(200) ;
                $app->response->headers->set('Content-type','application/json') ; 
		
		$app->run();
	}
}