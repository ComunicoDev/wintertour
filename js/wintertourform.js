/*jslint white: true*/
/*jslint browser: true*/
/*jslint devel: true */
/*global jQuery*/
(function ($) {
	"use strict";
	$(function () {
		// WinterTour Form
		$('form.wintertour_register').submit(function () {
			var valid = true;
			
			$(this).find('input[required=required], select[required=required], textarea[required=required]').each(function() {
				var pattern, regex, value;
				
				value = $(this).val();
				valid = valid && value; // if value is empty or null we set "valid" to false
				
				if(valid && pattern) {
					pattern = $(this).attr('pattern');
					
					// Make sure the pattern starts with '^'
					if(pattern[0] !== '^') {
						pattern = '^' + pattern;
					}
					// Make sure the pattern ends with '$'
					if(pattern[pattern.length - 1] !== '$') {
						pattern = pattern + '$';
					}
					
					// Create the regexp
					regex = new RegExp(pattern);
					
					valid = valid && regex.test(value); // We use the regexp to test the value is correct and change "valid" to false
				}
			});
			
			if(!valid) {
				window.alert('Controllare di avere inserito tutti i dati correttamente');
				event.preventDefault();
			}
		});
	});
}(jQuery));
