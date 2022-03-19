<script type="text/javascript" class="init">

$(document).ready(function() {
    /*$('#example').DataTable( {
        responsive: false,
		dom: 'T<"clear">lfr<"toolbar-DT">tip',
        tableTools: {
			"sSwfPath": "assets/plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
			"sRowSelect": "os",
            "aButtons": [
                "copy",
                "csv",
                "xls",
                {
                    "sExtends": "pdf",
                    "sPdfOrientation": "landscape",
                    "sPdfMessage": "Your custom message would go here."
                },
                "print"
            ]
        },
    } );*/

    $(document).ready( function () {

        $('#example').DataTable( {
            responsive: true,
            pageLength: 25,
            //dom: 'Bfrtip',
            /*buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]*/
            /*buttons: [
                {
                    text: '<?php //echo ADDRESS_ADD; ?>',
                    action: function ( e, dt, node, config ) {
                        window.location.href = "<?php //echo FILE_ADDRESS_BOOK; ?>";
                    },
                },
                {
                    text: 'Back',
                    action: function ( e, dt, node, conf ) {
                        window.history.back();
                    }
                }
            ]*/
        } );
    } );

	$("div.dataTables_wrapper").html('<a href="<?php echo FILE_ADDRESS_BOOK; ?>" class="btn-u"><?php echo ADDRESS_ADD; ?></a>');
} );
function addError(addId, country,type)
{
    var results;
    var action = getUrlVars()["Action"];
	$.ajax({
       type: "GET",
       url: "related/ajax_diff_addresscheck.php",
       dataType: 'json',
	   data: "add_id="+addId+"&country="+country+"&type="+type,
       success: function(msg){
         //
		 if(msg.head)
		 {
            var urlArg;
            if(action!= undefined){
                urlArg = "&Action=edit";
			  window.location.href = msg.head+urlArg;
            }else{
                window.location.href = msg.head;
            }

		 }
		 if(msg.error)
		 {
            //alert(msg.error+"inside add Error function"); return false;
			$('#msgContent').html(msg.error);
			$('#errorBox').modal('show'); //Anything you want
            var results = false;

		 }
       }

     });
    //if(results == false){
        return false;
    //}


}
</script>
