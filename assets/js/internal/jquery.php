<script type="text/javascript" charset="utf-8">
	
	var oTable;
	var asInitVals = new Array();
	
	$(document).ready(function() {
		
	
	
			oTable = $('#maintable').dataTable( { 
					"iDisplayLength":"<?php echo $page_rows; ?>"
					/*"sPaginationType": "full_numbers",
					"sDom": 'frtilp<"clear">',
					"bStateSave": true,
					"bProcessing": true,
					"bServerSide": true,
					"sAjaxSource": "get_data.php",
					

			<?php if(!empty($columnSetting)) { ?>
					"aoColumns": [
					<?php echo $columnSetting;  ?>
									],
			<?php } ?>
					"oFeatures": {
						"bPaginate": false,
						"bFilter" : false
					},
					"oLanguage": {
						"sProcessing": "Processing...",
						"sLengthMenu": "Show _MENU_",
						"sZeroRecords": "<?php echo RECORDS_NOT_FOUND;?>",
						"sInfo": "Showing _START_ to _END_ of _TOTAL_ entries",
						"sInfoEmpty": "0 Found",
						"sInfoFiltered": "(filtered from _MAX_ total entries)",
						"sInfoPostFix": "",
						"sSearch": "Search By Keyword:"
					}*/
			} );
		
		$("tfoot input").keyup( function () {
			/* Filter on the column (the index) of this element */
			oTable.fnFilter( this.value, $("tfoot input").index(this) );
		} );
		
		
		
		/*
		 * Support functions to provide a little bit of 'user friendlyness' to the textboxes in 
		 * the footer
		 */
		$("tfoot input").each( function (i) {
			asInitVals[i] = this.value;
		} );
		
		$("tfoot input").focus( function () {
			if ( this.className == "search_init" )
			{
				this.className = "";
				this.value = "";
			}
		} );
		
		$("tfoot input").blur( function (i) {
			if ( this.value == "" )
			{
				this.className = "search_init";
				this.value = asInitVals[$("tfoot input").index(this)];
			}
		} );
	
	/**
	 *  Code for Sort Order Update
	 */	
	
		var NewSortValues = new Array();
		var OldValuesData =  new Array();
		
		$("tbody input").focus(function(){
			
			if(this.id == 'txtsort') {
				sortId = getElementId(this.name);
				if( !OldValuesData[sortId] ||  OldValuesData[sortId] == '') {
					OldValuesData[sortId] = this.name + '=' + this.value;
				}
			}
		});
		
		$("tbody input").blur(function() {
			if(this.id == 'txtsort') {
				sortId = getElementId(this.name);
				sValue = this.name + "=" + this.value;
				if( OldValuesData[sortId] != sValue) {
					NewSortValues[sortId] = sValue;
				} else {
					NewSortValues[sortId] = '';
				}
			}
		});
		
	/**
	 * Ajax Based Status Change
	 */
		$("#status").live("click", function(event){
			var ObjActive = $(this);
			var statid = this.id;
			var anchorHREF = this.href;
			var statName = this.name;
			event.preventDefault();
			//return false;
			$.ajax({
				   type: "POST",
				   url: anchorHREF,
				   data: '',	/*"cid=" + cid + "&cstat="+cstat*/
				   success: function(msg){
				   	var str = '';
				   	var newstat = 0;
				   	if (msg == 1) {
				   		str = '<?php echo ADMIN_COMMON_STATUS_ACTIVE; ?>';
				   		newstat = 0;
				   	} else if (msg == 0) {
				   		str = '<?php echo ADMIN_COMMON_STATUS_INACTIVE; ?>';
				   		newstat = 1;
				   	} else {
				   		alert(msg);
				   	}
				   	
				   	var achorDataArray = anchorHREF.split('?');
				   	if( achorDataArray.length > 1) {
				   		var QrStrArr = achorDataArray[1].split('&');
				   		var cnQrStr = QrStrArr.length;
				   		var newQueryString = new Array();
				   		for(i=0; i < cnQrStr; i++) {
				   			QrSingleData = QrStrArr[i].split('=');
				   			if ( QrSingleData[0] == 'changestatus') {
				   				QrSingleData[1] = newstat;
				   			}
				   			newQueryString[i] = QrSingleData[0] + '=' + QrSingleData[1];
				   		}
				   		NewQuery = newQueryString.join('&');
				   		achorDataArray[1] = NewQuery;
				   		achorString = achorDataArray.join("?");
				   	} else {
				   		achorString = anchorHREF;
				   	}
				   	
				   	ancharText =  '<a id="' + statid + '" href="' + achorString + '" >' + str + '</a>';
				   	ObjActive.parent().html(ancharText);
				   }
			 	});
			return false;
		});

	/**
	 *  Ajax Based Delete Data
	 */	
		$("#rowDelete").live("click", function(){
			result=confirm("<?php echo ADMIN_MESSEGE_CONFIRM_DELETE;?>");
			if (result) {
				var ObjActive = $(this);
				var anchorHREF = this.href;
				$.ajax({
					   type: "POST",
					   url: anchorHREF,
					   data: '',	
					   success: function(msg){
					   	var str = '';
					   	var newstat = 0;
					   	if (msg == "success") {
					   		ObjActive.parents("#maintable tbody tr").remove().empty().appendTo("#maintable");
					   	} else {
					   		alert(msg);
					   	}
					   }
				 	});
			}
			return false;
		});
		
	} );
	
	function getElementId(elementName) {
		var ElementNameArray = elementName.split("_");
		var sortid = ElementNameArray[1];
		return sortid;
	}
</script>
