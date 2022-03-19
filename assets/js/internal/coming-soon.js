<!--	***		Bootstrap validator	***		-->
$(document).ready(function() {
    $('#contact-form').bootstrapValidator({
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            
			clientemail: {
				selector: '#clientemail',
				container: '#clientemail_message',
					validators: {
						notEmpty: {
                            message: 'The email field can not be empty'
                        },
						emailAddress: {
                        	message: 'The value is not a valid email address'
                    	}
					}
            },
        }
    });
	
});

<!--	***		Background Images	***		-->
$.backstretch([
  "assets/img/bg/1.png",
  "assets/img/bg/3.png",
  "assets/img/bg/2.png"
  ], {
	fade: 1000,
	duration: 7000
});

<!--	***		Counter	***		-->
$(function () {
	var austDay = new Date();
	austDay = new Date(austDay.getFullYear() + 1, 1 - 1, 26);
	$('#defaultCountdown').countdown({until: austDay});
	$('#year').text(austDay.getFullYear());
});



jQuery(document).ready(function() {
	App.init();
});

