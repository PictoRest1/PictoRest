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
function ClickAjoutAlbum(){
    jQuery(".new_album h2").html("<div id='ajoutalbumform' ><input id='nomNewAlbum' type='text' placeholder='Titre' name='libelle'></input><button class='bouton_general b_ajout_album'  onclick='AjoutAlbum()' >ok</button></div>");
    jQuery(".new_album").attr('onclick',''); 
}

function AjoutAlbum(){
   // jQuery(".new_album h2").html(jQuery("#nomNewAlbum").val());
   // jQuery(".new_album").addClass("album");
   // jQuery(".new_album").attr("onclick","affichagePhoto()");
   // jQuery(".new_album").removeClass("new_album");
    
    
   // jQuery(".profile ul").append(' <li class="new_album case" onclick="ClickAjoutAlbum();"><h2>Ajouter un album</h2><img class="images" src="images/Ajout_album.svg" /></li>');
    jQuery.post("/PictoRest/ajoutalbum",{ libelle:jQuery("#nomNewAlbum").val()});   
}

function AjoutPhoto(idAlbum){
    
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
function fermerImgGrand(){
    jQuery(".img_grand").remove();
}
function affichagePhoto(id,alb){
    if(!jQuery(alb).hasClass("case_sele")){
        jQuery.getJSON("/PictoRest/rest/albums/"+id+"/photos").done(function( data ) {

              for(i=0;i<data.length;i++){
                  jQuery(".thumbs_index").append(
                       "<li class='photo_petit ' onclick='ouvrireImgGrand(this);' ><h3>"+data[i].libelle+"</h3><img class='images' src='"+data[i].url+"'/><div class='selected'></div></li>"  
                 );      
             }
           calculWidthParallax(data.length);
        });
    
    }
    
}
function ouvrireImgGrand(photo){
    var src=jQuery(photo).children("img").attr("src");
    jQuery(photo).after('<div class="img_grand" onclick="fermerImgGrand()" ><img src="'+src+'" /></div>');
    
}
function calculWidthParallax(nbli){
    width=0;
    for(i=0;i<nbli;i++){
            width+=170;
    }
     jQuery(".thumbs_index").css("width",width+"px"); 
   
    
}
