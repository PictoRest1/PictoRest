var barre_haut_clique_liste=false;
var engrenage="blanc";
jQuery(document).ready(function() {	
	jQuery(document).click(function(event){
		if(barre_haut_clique_liste==false){
	    var target = event.target.id;
           if (target!="bouton_gestion" && target!="engrenage"){
				jQuery("#barre_haut_liste_engrenage").hide(); 
				jQuery('#engrenage').css("backgroundPosition","0px 22px");	
				jQuery('#bouton_gestion').css("backgroundColor","transparent");
				engrenage="blanc";		
		   }
		}
		barre_haut_clique_liste=false;   
	});
	jQuery("#barre_haut_liste_engrenage").click(function(event){
		barre_haut_clique_liste=true;
	});
	
	// diaporama
	if(jQuery(".diaporama1") && typeof(jQuery(".diaporama1").jDiaporama)!="undefined" ){
		jQuery(".diaporama1").jDiaporama({
			animationSpeed: "slow",
			delay:5
		});
	}
	//hover des cadres
//	jQuery("#cadre_entreprise").hover(function(){cadre_hover(1,"#cadre_entreprise")},function(){cadre_hover(0,"#cadre_entreprise")});
//	jQuery("#cadre_institutionnel").hover(function(){cadre_hover(1,"#cadre_institutionnel")},function(){cadre_hover(0,"#cadre_institutionnel")});
//	jQuery("#cadre_voyageur").hover(function(){cadre_hover(1,"#cadre_voyageur")},function(){cadre_hover(0,"#cadre_voyageur")});
//	jQuery("#cadre_club").hover(function(){cadre_hover(1,"#cadre_club")},function(){cadre_hover(0,"#cadre_club")});
//	jQuery("#cadre_annoncer").hover(function(){cadre_hover(1,"#cadre_annoncer")},function(){cadre_hover(0,"#cadre_annoncer")});	
	if( jQuery( '.parallax-layer' ) && typeof(jQuery( '.parallax-layer' ).parallax)!="undefined" ){
		jQuery( '.parallax-layer' ).parallax({
			
			mouseport: jQuery("#port"),
			yparallax: false
		});
	}
	
});

	
	
function barre_haut_animation_engrenage(){
	
	jQuery("#barre_haut_liste_engrenage").toggle(0);
	if (engrenage=="blanc"){
		jQuery('#engrenage').css("backgroundPosition","0px 0px");	
		jQuery('#bouton_gestion').css("backgroundColor","white");
		engrenage="noir";
	}else{
		jQuery('#engrenage').css("backgroundPosition","0px 22px");	
		jQuery('#bouton_gestion').css("backgroundColor","transparent");
		engrenage="blanc";
	}
}
	
function accueil_animation_connexion(id_click){
	if(id_click==1){
		jQuery(".connexion").hide();
		jQuery(".inscription").show();
		jQuery("#s_inscrire").hide();
		jQuery("#se_connecter").show();
	}else if(id_click==2){
		jQuery(".connexion").show();			
		jQuery(".inscription").hide();
		jQuery("#s_inscrire").show();
		jQuery("#se_connecter").hide();
	}
}

	
	 
var tab_elem_cadre=["#cadre_entreprise","#cadre_institutionnel","#cadre_club","#cadre_voyageur","#cadre_annoncer"];	 
function cadre_hover(is_hover,elem){
	if(is_hover==1){
		for(var i=0;i<5;i++){
			if(elem!=tab_elem_cadre[i]){
				jQuery(tab_elem_cadre[i]).addClass("cadre_hover");
			}
		}
	}else{
		for(var i=0;i<5;i++){
			jQuery(tab_elem_cadre[i]).removeClass("cadre_hover");
		}
	}
}

