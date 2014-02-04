<?php
$app = new \Slim\Slim ;

$app->get( '/rest/users', function() use ($app) {
	$c = new Rest_api($app) ;
	$c->get() ; }
);

$app->get( '/rest/users/:id/feeds', function($id) use ($app) {
	$c = new Rest_api($app) ;
	$c->get($id) ;}
);

$app->get( '/rest/users/:id/albums', function($id) use ($app) {
	$c = new Rest_api($app) ;
	$c->get() ;}
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