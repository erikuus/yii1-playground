/**
 * jQuery script for adding new content from template field
 *
 * NOTE!
 * This script depends on jquery.format.js
 *
 * IMPORTANT!
 * Do not change anything except specific commands!
 */
jQuery(document).ready(function(){
	hideEmptyHeaders();
	$(".add").click(function(){
		var template = jQuery.format(jQuery.trim($(this).siblings(".template").val()));
		var place = $(this).parents(".templateFrame:first").children(".templateTarget");
		var i = place.find(".rowIndex").length>0 ? place.find(".rowIndex").max()+1 : 0;
		$(template(i)).appendTo(place);
		place.siblings('.templateHead').show()
		// start specific commands

		// end specific commands
	});

	$(".remove").live("click", function() {
		$(this).parents(".templateContent:first").remove();
		hideEmptyHeaders();
	});
});

function hideEmptyHeaders(){
	$('.templateTarget').filter(function(){return $.trim($(this).text())===''}).siblings('.templateHead').hide();
}