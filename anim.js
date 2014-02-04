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
});