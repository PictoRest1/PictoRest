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
        
});