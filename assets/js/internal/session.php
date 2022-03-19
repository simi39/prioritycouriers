<script>
function session_checking()
{	
   var data = '<?php echo Expiry(); ?>';
	
	if(data == 1)
	{		
		console.log("session is cleared from javascript");
		$('#sessionConfirm').modal('show');
		$('#sessionConfirm').on('shown', function () {
			$('#paymentCancel').modal('hide');
			$('#addressBox').modal('hide');
			$("#duplicateAddressBox").modal('hide');
			$('#errorBox').modal('hide');
			$("#AusService").modal('hide');
			$("#dataResetLossEff").modal("hide");
			$("#dataLossEff").modal("hide");
			$("#InterPersonalEff").modal('hide');
			$("#InterService").modal('hide');
			$("#DomesticEff").modal('hide');
			$('#InterService').modal('hide');
			$("#InterPersonalEff").modal('hide');
			$("#timeMsgBox").modal("hide");
			$("#AddressError").modal("hide");
			$('#confirmBox').modal('hide');
			$('#mapeff').modal("hide");
		});
		
		$("#session_cls").click(function(e){ 
			var url = "login.php?action=logout";
			$(location).attr('href',url);
			e.preventDefault();
		});
		
	}
   
}
<?php if(!IS_ADMIN){ ?>
$(document).ready(function () {
	
	//return false;
	var setSession = '<?php echo sessionTimings(); ?>';
	
	if(setSession != '')
	{
		
		var validateSession = setInterval(session_checking,'<?php echo sessionTimings(); ?>');
	}
});
<?php } ?>
</script>