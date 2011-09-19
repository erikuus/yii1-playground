/*
 * Common jQuery scripts 
 */

jQuery(document).ready(function(){

	// external links
	$(function() {
		$('a[rel*=external]').click( function() {
				window.open(this.href);
				return false;
		});
	});	
	
	// show and hide
	$('.tpanel .toggle').click(function() {
			$(this).next().toggle();
			return false;
	}).next().hide();
	
	// checkbox dynamics
    $('.cpanel :checkbox:not(:checked)').siblings('.cpanelContent').hide();
    $('.cpanel :checkbox').click(function(){
        $('.cpanelContent', $(this).parents('div:first')).css('display', this.checked ? 'block':'none');
    });
    
	// select dynamics
    $('.spanel select option[value="-1"]:not(:selected)').parents('select').siblings('.spanelContent').hide();
    $('.spanel select').change(function(){
        $('.spanelContent', $(this).parents('div:first')).css('display', $(this).val()=='-1' ? 'inline':'none');
    });
    
    // radio dynamics
    $('.rpanel :radio:not(:checked)').siblings('.rpanelContent').hide();
    $('.rpanel :radio').click(function(){
        $('.rpanelContent', $(this).parents('div:first')).css('display', this.checked ? 'inline':'none');
        $('.rpanel :radio:not(:checked)').siblings('.rpanelContent').hide();
    });
    
    // help dialog
	$(".openhelp").click(function () { 
		var targetUrl = $(this).attr("href");
		$("#help-dialog").dialog({
			open : function(){
				$("#help-dialog").text("");
				$("#help-dialog").load(targetUrl);
			}
       });
       $("#help-dialog").dialog("open");
       return false;
	});    
    
    // clear form
	$(".clearform").click(function () {
		$(this).parents('form:first').find('.cpanelContent').css('display','none');
		$(this).parents('form:first').find('.rpanelContent').css('display','none');
		$(this).parents('form:first').find(':input').each(function() {
			switch(this.type) {
				case 'password':
				case 'select-multiple':
				case 'select-one':
				case 'text':
				case 'textarea':
				case 'hidden':
					$(this).val('');
				break;
				case 'radio':
					$(this).filter('[value=0]').attr('checked', true);
				break;	
				case 'checkbox':
					this.checked = false;
			}
		});		
	});
});