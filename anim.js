$( document ).ready(function() {

	jQuery("#connexion").click(function	(){
		jQuery(".connexion").show("fast");
	});
	jQuery("#close_co").click(function (){
		jQuery(".connexion").hide("fast");	
	});
	jQuery("#inscription").click(function	(){
		jQuery(".inscription").show("fast");
	});
	jQuery("#close_ins").click(function (){
		jQuery(".inscription").hide("fast");	
	});
        jQuery("#close_ajt").click(function (){
		jQuery(".int_album").hide("fast");
                
                jQuery(".container").css("padding-bottom","0px");
	});
        
	jQuery(".case").click(function(){
			
			jQuery(".case").each(function(){
				jQuery(this).removeClass("case_sele");
			});
			jQuery(this).addClass("case_sele");
			jQuery(".int_album").show("fast");
			jQuery(".container").css("padding-bottom","230px");
	});
	
	if( jQuery( '.parallax-layer' ) && typeof(jQuery( '.parallax-layer' ).parallax)!="undefined" ){
		jQuery( '.parallax-layer' ).parallax({
			
			mouseport: jQuery("#port"),
			yparallax: false
		});
	}
});
function ClickAjoutAlbum(){
    jQuery(".new_album h2").html("<input id='nomNewAlbum' type='text' placeholder='Titre'></input><a class='bouton_general b_ajout_album' onclick='AjoutAlbum();'>ok</a>");
    jQuery(".new_album").attr('onclick',''); 
}

function AjoutAlbum(){
    jQuery(".new_album h2").html(jQuery("#nomNewAlbum").val());
    id=1;
    alert("dea");
    
    jQuery.ajax({
  	  type: 'POST', // Le type de ma requete
	  url: '/PictoRest/ajoutalbum', // L'url vers laquelle la requete sera envoyee
	  data: {
		libelle:jQuery(".new_album h2").html() // Les donnees que l'on souhaite envoyer au serveur au format JSON
	  }, 
	  success: function(data, textStatus, jqXHR) {
		alert("ok");
	  },
	  error: function(jqXHR, textStatus, errorThrown) {
		alert(jqXHR);
                alert( textStatus);
                alert(textStatus);
	  }
	});	
} 

function AjoutPhoto(idALbum){
    
    jQuery.ajax({
  	  type: 'POST', 
	  url: '/ajoutphoto', 
          data: {
              urlphoto:jQuery(".fedzs").html(),
              
          },
          success: function(data, textStatus, jqXHR) {
		alert("ok");
	  },
	  error: function(jqXHR, textStatus, errorThrown) {
		alert("erreur");
	  }
    });

}