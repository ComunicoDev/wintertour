/**
 * @author Tommaso Ricci
 * @version 1.0.0
 */

(function ($) {
	$.fn.autoGiocatore = function() {
		if(typeof(jQuery.fn.typeWatch) == 'function') {
			this.each(function() {
				var inp = this;
				
				if($(inp).attr('name')) {
					var sel = $('input[type=text][data-autocompname=' + $(inp).attr('name') + '].searchbox.autogiocatore').get(0);
					var sub = $('input[type=submit][data-autocompname=' + $(inp).attr('name') + '].autogiocatore').get(0);
					
					if(sel && $(inp).data('completionBound') !== true) {
						
						$(sub).prop('disabled', true);
						
						$(inp).closest('form').submit(function(event) {
							$(event.target).find('input[type=hidden][name=wt_nonce]').remove();
						});
						
						$(sel).typeWatch({
							wait: 300,
							highlight: true,
							captureLength: 0,
							
							callback: function() {
								var length = ($(sel).val()) ? $(sel).val().length : 0;
								
								if(length > 2) {
									$(sub).prop('disabled', true);
									
									var data = {
										action: 'wintertour_autogiocatore',
										partial: $(sel).val(),
										wt_nonce: $(sel).closest('form').find('input[name=wt_nonce]').val()
									};
									
									$.ajax({
										type : 'POST',
										url: ajaxurl,
										data: data,
										async: false,
										success: function(response) {
											if(response != 0) {
												var obj = jQuery.parseJSON(response);
												var y = inp;
												
												while(y.length > 0) {
													y.remove(y.length - 1);
												}
												
												if(obj != null && obj.length > 0) {
													for(var i = 0; i < obj.length; i++) {
														var x = obj[i];
														var option = document.createElement('option');
														
														option.value = x.ID;
														option.text = x.cognome + ' ' + x.nome;
														
														y.add(option);
													}
													
													$(sub).prop('disabled', false);
												} else if(obj != null && obj.length <= 0) {
													var option = document.createElement('option');
													option.value = '';
													option.text = '--Nessun risultato--';
													option.disabled = true;
													y.add(option);
													y.selectedIndex = 0;
													
													$(sub).prop('disabled', true);
												}
											} else {
												var option = document.createElement('option');
												option.value = '';
												option.text = '--Nessun risultato--';
												option.disabled = true;
												y.add(option);
												y.selectedIndex = 0;
												
												$(sub).prop('disabled', true);
											}
										},
										complete: function() {
											$(sel).prop('disabled', false);
											$(sel).focus();
										}
									});
								} else if(length > 0) {
									var y = inp;
									
									while(y.length > 0) {
										y.remove(y.length - 1);
									}
									
									var option = document.createElement('option');
									option.value = '';
									option.text = '--Digitare almeno 3 caratteri--';
									option.disabled = true;
									y.add(option);
									y.selectedIndex = 0;
									
									$(sub).prop('disabled', true);
								} else {
									var y = inp;
									
									while(y.length > 0) {
										y.remove(y.length - 1);
									}
									
									var option = document.createElement('option');
									option.value = '';
									option.text = '--Cerca un giocatore--';
									option.disabled = true;
									y.add(option);
									y.selectedIndex = 0;
									
									$(sub).prop('disabled', true);
								}
							}
						});
						
						$(inp).data('subBut', sub);
						$(inp).data('selectIn', sel);
						$(inp).data('completionBound', true);
					}
				}
			});
		}
	};
}(jQuery));
