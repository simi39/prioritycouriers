<script>
$(document).ready(function() {
$('#newsletter')
.bootstrapValidator({
	fields: {
		newsletter:{
			selector: '#newsletter_id',
			container: "#newsletterError",
			validators: {
				notEmpty: {
						message: '<?php echo ERROR_EMAIL_ID_IS_REQUIRED; ?>'
					},
				emailAddress: {
					message: '<?php echo EMAIL_ID_NOT_PROPER; ?>'
				}
			}
		},
	}
})
.on('success.form.bv', function(e) {
	e.preventDefault();
	$.ajax({
	  url: "<?php echo DIR_HTTP_RELATED."ajax_newsletter.php"; ?>",
	  dataType: "json",
	  method: "post",
	  data: {
		email: $('#newsletter_id').val()
	},
	success: function( data ) {
		
		if(data == 1)
		{
			$("#newsletter_subscription").modal('show');
			return false;
		}
	}
	});
})
$('#newscls').click(function(e){ 
	$("#newsletter_subscription").modal('hide');
	$("#newsletter").data("bootstrapValidator").resetForm(true);
	return false;
})
});

</script>