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
	jQuery(".photo,.photo_petit").click(function(){
               // jQuery(".img_grand").remove();
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
    jQuery(".new_album h2").html("<form id='ajoutalbumform' method=post action='/PictoRest/ajoutalbum' target='_blank'><input id='nomNewAlbum' type='text' placeholder='Titre' name='libelle'></input><button class='bouton_general b_ajout_album' type='submit' onclick='AjoutAlbum()' >ok</button></form>");
    jQuery(".new_album").attr('onclick',''); 
}

function AjoutAlbum(){
    jQuery(".new_album h2").html(jQuery("#nomNewAlbum").val());
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
    jQuery(".img_grand").remove()
}
function affichagePhoto(id){
    console.log("asq");
    jQuery.getJSON("/PictoRest/rest/albums/"+id+"/photos").done(function( data ) {
        
      $.each( data.items, function( i, item ) {
      
        console.log(i);
         // $( "<img>" ).attr( "src", item.media.m ).appendTo( "#images" );
       
      });
      
       //   for(i=0;i<data.length;i++){
               
       //  console.log(data.libelle);
       //       jQuery(".thumbs_index").append(
       //            "<li class='photo_petit '><h3>"+data[i]+"</h3><img class='images' src='' /><div class='selected'></div></li>"  
       //       );      
       //   }
        //$.each(datass, function(i, field){
            
        
               // console.log(data[i]);
            
        //});
      // for(photo in data ){
       //  console.log(data[photo].idPhoto);
         
       // }
        //jQuery.each(data.photos,function(i,photo){
          //  jQuery(".thumbs_index").append(
         //       "<li class='photo_petit '><h3>"+photo.libelle+"/h3><img class='images' src='' /><div class='selected'></div></li>"  
        //    );      
        //});     
      
    });
}

