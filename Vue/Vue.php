<?php
	namespace Vue;
	use \Exception as Exception;
	
	abstract class Vue{
		
		protected $slim;
		protected $layout = null;
		protected $obj;
		protected $arrayVar = array();
		protected $arrayLink;
		protected $menu = array(
			"accueil" => "Accueil",
			"chercher" => "Chercher",
			"ajouter" => "Ajouter un Album",
			"compte" => "Mon Compte"
		);
		
		public function __construct(){}
		
		public function addVar($var, $val) {
			$this->arrayVar[$var] = $val;
		}
		
		public function setArrayVar($array) {
			$this->arrayVar = $array;
		}
		
		public function render() {
			if(!$this->layout)
				throw new Exception( get_called_class() . " : il faut définir un layout à afficher" );
			$loader = new \Twig_Loader_Filesystem( __dir__ . "/../Template/" );
			$twig = new \Twig_Environment( $loader );
			$tmpl = $twig->loadTemplate( $this->layout );
			// Generations du menu
// 			foreach( $this->menu as $route => $nom)
// 				$this->arrayVar["menu"][$route] = array("nom" => $nom, "lien" => $this->slim->urlFor($route));
// 				var_dump($this->arrayVar);
			return $tmpl->render( $this->arrayVar );
		}
		
		public function display() { echo $this->render(); }
		
		private function generateMenu() {
			foreach($this->menu as $name => $link)
				$this->arrayVar["menu"]["$name"] = $link;
		}
		public function setMenu(array $Menu) {
			foreach($Menu as $key => $val)
				$menu[$key] = $val;
		}	
		public function unsetMenu(array $Menu) {
			foreach($Menu as $val)
				unset($menu[$val]);
		}
	}
