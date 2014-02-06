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
                jQuery(".container").css("padding","60px 0px 0px 0px");
	});
        
	jQuery(".case").click(function(){
			
			jQuery(".case").each(function(){
				jQuery(this).removeClass("case_sele");
			});
			jQuery(this).addClass("case_sele");
			jQuery(".int_album").show("fast");
			jQuery(".container").css("padding","60px 0px 230px 0px");
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
    idUtil=jQuery.session.get('idUtil');
    jQuery.ajax({
  	  type: 'POST', // Le type de ma requete
	  url: '/'+idUtil+'/ajoutalbum', // L'url vers laquelle la requete sera envoyee
	  data: {
		libelle:jQuery("#nom"+i).html(), // Les donnees que l'on souhaite envoyer au serveur au format JSON
	  }, 
	  success: function(data, textStatus, jqXHR) {
		alert("ok");
	  },
	  error: function(jqXHR, textStatus, errorThrown) {
		alert("erreur");
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