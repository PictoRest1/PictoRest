$( document ).ready(function() {
    
       $('#recherche').autocomplete({
            source : function(requete, reponse){ // les deux arguments représentent les données nécessaires au plugin
                $.ajax({
                    url : '/PictoRest/rest/albumss', // on appelle le script JSON
                    dataType : 'json', // on spécifie bien que le type de données est en JSON
                    data : {
                        query: $('#recherche').val() // on donne la chaîne de caractère tapée dans le champ de recherche
                        
                    },

                    success : function(donnee){
                       
                       jQuery(".resultat ul li").each(function(){
                          jQuery(this).remove(); 
                       });
                       for(i=0;i<donnee.length;i++){
                         jQuery(".resultat ul").append('<li class="album case" onclick="affichagePhoto('+donnee[i].idAlbum+',this)"><div id="x" onclick="suppAlbum('+donnee[i].idAlbum+',this);" class="supp_plus">X</div><h2>'+donnee[i].libelle+'</h2><img class="images" src="" /><div class="selectionne"></div><div class="selected"><img src="images/loupe.svg" /></div></li>');
                       }
                    }
                });
            }
        });
        
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
                jQuery(".case_sele").removeClass("case_sele");
	});
        
	jQuery(".album,.new_album").click(function(){
			
			jQuery(".case").each(function(){
				jQuery(this).removeClass("case_sele");
			});
			jQuery(this).addClass("case_sele");
                        
                        jQuery(".int_album").show("fast");
                       
			jQuery(".container").css("padding-bottom","230px");
	});
	jQuery(".photo_petit").click(function(){
               // jQuery(".img_grand").remove();
               console.log("ds");
		var src=jQuery(this).children("img").attr("src");
		jQuery(this).after('<div class="img_grand" onclick="fermerImgGrand()" ><img src="'+src+'" /></div>');
		
        
        });
        
	if( jQuery( '.parallax-layer' ) && typeof(jQuery( '.parallax-layer' ).parallax)!="undefined" ){
		jQuery( '.parallax-layer' ).parallax({
			
			mouseport: jQuery("#port"),
			yparallax: false
		});
	}
});
function ClickAjoutAlbum(id){
    
    jQuery(".new_album h2").html("<div id='ajoutalbumform' ><input id='nomNewAlbum' type='text' placeholder='Titre' name='libelle'></input><button class='bouton_general b_ajout_album'  onclick='AjoutAlbum("+id+")' >ok</button></div>");
    jQuery(".new_album").attr('onclick',''); 
}

function AjoutAlbum(id){
    id=id+1;
    jQuery.post("/PictoRest/ajoutalbum",{ libelle:jQuery("#nomNewAlbum").val()});   
    jQuery(".new_album h2").html(jQuery("#nomNewAlbum").val());
    jQuery(".new_album").addClass("album");
    jQuery(".new_album h2").before("<div id='x' onclick='suppAlbum("+id+",this);' class='supp_plus'>X</div>");
    jQuery(".new_album img").after("<div class='selectionne'></div>");
    jQuery(".new_album img").attr("src","");
    jQuery(".new_album").attr("onclick","affichagePhoto("+id+")");
    jQuery(".new_album").removeClass("new_album");
    jQuery(".profile ul").append(' <li class="new_album case" onclick="ClickAjoutAlbum();"><h2>Ajouter un album</h2><img class="images" src="images/Ajout_album.svg" /></li>');
}

function AjoutPhoto(id){
    var form = document.getElementById('foorm');
    var formData = new FormData(form);
    
    
   $.ajax({
            url: "/PictoRest/ajoutphoto",
            type: 'POST',
            dataType: 'html',
            processData: false,
            contentType: false,
            data: formData
        }).done(function() {
           nom= jQuery("#nom_photo").val();
           description=jQuery("#description_photo").val();
          jQuery(".thumbs_index").append(
                       "<li class='photo_petit ' onclick='ouvrireImgGrand(this);' ><h3>"+nom+"</h3><img class='images' src=''/><div class='description_photo'>"+description+"</div><div class='selected'></div></li>"  
                 ); 
  });
}
function fermerImgGrand(){
    jQuery(".img_grand").remove();
    jQuery(".barre_de_nav").css("z-index",1000);
}
function affichagePhoto(id,alb){
    
    if(!jQuery(alb).hasClass("case_sele")){
        jQuery(".int_album form #idAlbum ").attr("value",id);
        jQuery(".int_album form #upload ").attr("onclick","AjoutPhoto("+id+")");
        jQuery(".thumbs_index li").each(function(){
            jQuery(this).remove();
        });
        jQuery.getJSON("/PictoRest/rest/albums/"+id+"/photos").done(function( data ) {

              for(i=0;i<data.length;i++){
                  jQuery(".thumbs_index").append(
                       "<li class='photo_petit ' onclick='ouvrireImgGrand(this);' ><h3>"+data[i].libelle+"</h3><img class='images' src='"+data[i].url+"'/><div class='description_photo'>"+data[i].description+"</div><div class='selected'></div></li>"  
                 );      
             }
          
        });
    
    }
    
}
function ajoutAbonnement(idAlbum){
    jQuery.post("/PictoRest/ajoutabonnement", { idAlbum:idAlbum});
    alert("Album ajouté aux abonnements");
}
function deleteAbonnement(idAlbum){
    jQuery.post("/PictoRest/deleteabonnement", { idAlbum:idAlbum});
    alert("Album supprimé des abonnements");
}
function ouvrireImgGrand(photo){
    var src=jQuery(photo).children("img").attr("src");
    jQuery(photo).after('<div class="img_grand" onclick="fermerImgGrand()" ><img src="'+src+'" /></div>');
    jQuery(".barre_de_nav").css("z-index",0);
}

function suppAlbum(idAlbum,album){
    jQuery.post("/PictoRest/deletealbum",{idAlbum:idAlbum});
    jQuery(album).parent().remove();
    jQuery(".int_album").hide("fast");
    jQuery(".container").css("padding-bottom","0px");
    jQuery(".case_sele").removeClass("case_sele");
}
