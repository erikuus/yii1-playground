<?php
/**
 * To apply classic skin, assign skin attribute:
 * $this->widget('XJuiAutocomplete', array('skin'=>'notDefault'));
 */
return array(
	'default'=>array(
		'options'=>array(
			'delay'=>300,
			'minLength'=>2,
			'open'=>'js: function( event, ui ) {
				$( this ).autocomplete( "widget" )
					.find( "ui-menu-item-alternate" )
					.removeClass( "ui-menu-item-alternate" )
					.end()
					.find( "li.ui-menu-item:odd a" )
					.addClass( "ui-menu-item-alternate" );
			}',
		),
		'htmlOptions'=>array(
			'style'=>'background: #ffffe0;'
		),
	),
);