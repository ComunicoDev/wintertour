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
	});
})(jQuery);
