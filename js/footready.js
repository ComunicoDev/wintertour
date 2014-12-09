(function($){
	$(function(){
		$('#wpfooter').remove();
		//JScrollPane
		$('.scrolling').jScrollPane();
		
		
		//DateTimePicker
		$('.date').datetimepicker({
			timepicker: false,
			format:'d/m/Y',
			dayOfWeekStart: 1,
			lang: 'it'
		});
		$('.datetime').datetimepicker({
			format:'d/m/Y - H:i',
			dayOfWeekStart: 1,
			lang: 'it'
		});
		$('.time').datetimepicker({
			datepicker: false,
			format:'H:i',
			lang: 'it'
		});
		
		//Autocompletion
		$('select.searchbox.autocompletion').autoCompletion();
		
		//Showone
		$('select.showone').change(function() {
			var select = $(this);
			var selected = select.find(':selected');
			
			select.find('option').each(function() {
				if($(this).val() !== selected.val()) {
					$("#" + $(this).val()).hide();
				} else {
					$("#" + $(this).val()).show();
				}
			});
		});
		
		// Confirm
		$("input.confirm").each(function() {
			var form = $(this).closest("form").first();
			$(form).closest("form").submit(function() {
				var action = $(form).attr("action") || window.location.href;
				if($(document.activeElement).hasClass("confirm")) {
					$(form).attr("action", action.substring(0, action.indexOf('?') + 1) + action.substring(action.indexOf('page='), action.indexOf('page=') + action.substring(action.indexOf('page=')).indexOf("&")) + '&action=view');
					return window.confirm("L'azione che stai eseguendo non è reversibile.\nSei sicuro di voler continuare?");
				} else {
					$(form).attr("action", action);
				}
			});
		});
	});
})(jQuery);
