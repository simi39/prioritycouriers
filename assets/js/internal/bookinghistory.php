<script type="text/javascript">

function viewbooking(url)
{
	
	window.open(url,'welcome','width=300,height=200,menubar=yes,status=yes,location=yes,toolbar=yes,scrollbars=yes');
   return true;
}

function takeprint(url)
{
	window.open(url,'welcome','width=300,height=200,scrollbars=yes');
   return true;
}

function printdelbutton(bookingid){
	
	var flag=confirm("Are you sure you would like to delete this record?","Yes","No");
	
	if(flag==true)
	{
		document.bookingrecords.bookingid.value=bookingid;
		document.bookingrecords.viewdelid.value="delete";
		document.bookingrecords.submit();
		return true;
	}
	else
	{
		return false;
	}
}

</script>

<script type="text/javascript" class="init">

$(document).ready(function() {
    /*$('#example').DataTable( {
        responsive: true,
		dom: 'T<"clear">lfrtip',
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
		"columnDefs": [ {
    		"targets": 2,
    		"createdCell": function (td, cellData, rowData, row, col) {
      			if ( cellData =="Delivered" ) {
        			$(td).css('color', 'green');
					$(td).css('font-weight', 'bolder')
      			}
    		}
  		} ]
    } );*/
    $('#example').DataTable( {
            responsive: true,
            pageLength: 10,
            //dom: 'Bfrtip',
            /*buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]*/
            order: [
                [1, 'asc'],
            ],
            
        } );
} );

	</script>