<script type="text/javascript">
var dummy=1;
var dummyinternational=1;
var tabindexval=8;

function getXMLHttp()
{
	var xmlHttp

	try
	{
		//Firefox, Opera 8.0+, Safari
		xmlHttp = new XMLHttpRequest();
	}
	catch(e)
	{
		//Internet Explorer
		try
		{
			xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch(e)
		{
			try
			{
				xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e)
			{
				alert("Your browser does not support AJAX!")
				return false;
			}
		}
	}
	return xmlHttp;
}
function display_size(shipping_type,rowno,totalblocks)
{
	
	var item_width = document.getElementById("Item_width_"+rowno);
	var item_length = document.getElementById("Item_length_"+rowno);
	var item_height = document.getElementById("Item_height_"+rowno);
	var service_page = trim($("#servicepagename").val());
	if(shipping_type==0)
	{
		$("#selShippingTypes_"+rowno).html("Select any Item Type");
		return false;
	}else{
		$("#selShippingTypes_"+rowno).html("");
	}
	var pickup = trim($("#pickup").val());
	if((pickup =="PICK UP SUBURB/POSTCODE") ||(pickup ==""))
	{	
		$("#pickupError").html('<?php echo SELECT_PICKUP_ITEM; ?>');
		$("#pickup").focus();
		errorflag = true;
		return false
	}
	if(pickup != '')
	{
		if(validateStr(pickup) == false)
		{
			$("#pickupError").html('<?php echo COMMON_SECURITY_ANSWER_ALPHANUMERIC; ?>');
			errorflag = true;
			return false
		}
		else
		{
			$("#pickupError").html('');
		}
	}
	var deliver = trim($("#deliver").val());
	
	if($('#size_display_block_international').css('display') == 'none')
	{	
		if((deliver == "DELIVERY SUBURB/POSTCODE") ||(deliver ==""))
		{
			$("#deliverError").html('<?php echo SELECT_DELIVER_ITEM; ?>');
			$("#deliver").focus();
			errorflag = true;
			return false
		}
		else
		{
			$("#deliverError").html('');
		}
	}else{
		var inter_box = $.trim($("#inter_country").val());
		if(inter_box == 'SELECT COUNTRY')
		{	
			$("#interError").html('<?php echo SELECT_INTERNATIONAL_COUNTRY; ?>');
			return false;
		}
		else
		{
			$("#interError").html('');
		}
		deliver = inter_box;
		service_page = 'international';
	}
	
	if(pickup != '' && deliver != '')
	{
		//unsetAusValues();
		//alert("onchange");
		$.ajax({
		url: '<?php echo "related/ajax_getquote_validation.php"; ?>',
		type: 'POST',
		data: {service_item_type:service_page,row_num:rowno,item_type:shipping_type,item_change:true},
		success: function(response) { 
			var resArr = response.split("$");
			var j;
			
			if(resArr.length!=0)
			{
				for(j = 0;j<(resArr.length-1);j++)
				{
					var resError = resArr[j].split("=>");
					
					
					if(trim(resError[1])=="active")
					{			
						$(resError[0]).val('');
						$(resError[0]).attr('readonly', false);
						$("#Items_qty_"+rowno).html("");
						$("#Items_weight_"+rowno).html("");
						$("#Items_length_"+rowno).html("");
						$("#Items_width_"+rowno).html("");
						$("#Items_height_"+rowno).html("");
						display_total_value();
					}else{
						//alert("title:"+resError[0]+"err"+resError[1]);
						$(resError[0]).val(0);
						$(resError[0]).attr('readonly', true);
					}
					
				}
			}
			
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status+"---"+thrownError);
			//alert("your error code smita"+response);
		}
		});
	}
	/*
	if(shipping_type==0)
	{	
	}
	else if(shipping_type==1)
	{
		item_width.value="0";
		item_length.value="0";
		item_height.value="0";

		item_width.readOnly=true;
		item_length.readOnly=true;
		item_height.readOnly=true;
	}else
	{
		
		item_width.readOnly=false;
		item_length.readOnly=false;
		item_height.readOnly=false;
	}
	*/
}

var sum=0;
var lastRowDeleted= new Array();

/*function DelSizeDataRow(Rowno) {
var tblSizeTypeData, tblSizeTypeDataBody;
tblSizeTypeData = document.getElementById("size_display_block_1");

tblSizeTypeDataBody = tblSizeTypeData.tBodies[0];
var tbl = document.getElementById('size_display_block_1');
var lastRow = tbl.rows.length;
for (var i=1;i<lastRow;i++)
{
var Rowid = tblSizeTypeDataBody.rows[i].id;

if (Rowid == Rowno )
{
document.getElementById("size_display_block_1").deleteRow(i);
break;
}
}
display_total_value();
}*/
function DelSizeDataRow_old(Rowno){
	var tblSizeTypeData, tblSizeTypeDataBody;
	tblSizeTypeData = document.getElementById("size_display_block_1");

	tblSizeTypeDataBody = tblSizeTypeData.tBodies[0];
	var tbl = document.getElementById('size_display_block_1');
	var lastRow = tbl.rows.length;
	var no_rows = 1;
	//lastRow = document.getElementById('last_inserted_cell').value
	for (var i=1;i<lastRow;i++)
	{
		var Rowid = tblSizeTypeDataBody.rows[i].id;
		no_rows = i;
		if (Rowid == Rowno )
		{
			document.getElementById("size_display_block_1").deleteRow(i);
			no_rows = no_rows-1;
			break;
		}
	}

	display_total_value();
}
function DelSizeinterDataRow(Rowno) {

	var tblSizeTypeData, tblSizeTypeDataBody;
	tblSizeTypeData = document.getElementById("size_display_block_international");

	tblSizeTypeDataBody = tblSizeTypeData.tBodies[0];
	var tbl = document.getElementById('size_display_block_international');
	var lastRow = tbl.rows.length;
	for (var i=1;i<lastRow;i++)
	{
		var Rowid = tblSizeTypeDataBody.rows[i].id;

		if (Rowid == Rowno )
		{
			document.getElementById("size_display_block_international").deleteRow(i);
			break;
		}
	}

	//	display_total_value();
	International_total_value();
}


function DuplicateSizeDataRow(id)
{
	
	if($("#size_display_block_international").css('display')=="none")
	{
		var tblShippingTypeData, tblShippingTypeDataBody;
		tblShippingTypeData = document.getElementById("size_display_block_1");
		tblShippingTypeDataBody = tblShippingTypeData.tBodies[0];
		var totShippingTypeDataRows = tblShippingTypeData.rows.length;
		var newRowNo = totShippingTypeDataRows + 1;
		document.getElementById("last_inserted_cell_australia").value= newRowNo+1;
		
		for(var i=1;i<=dummy;i++)
		{
			if(document.getElementById("selShippingType_"+i) != undefined)
			{
				if(document.getElementById("selShippingType_"+i).value==0)
				{
					$("#selShippingTypes_"+i).html("Select package Type");
					document.getElementById("selShippingType_"+i).focus();
					return false;
				}
				shipping_type = document.getElementById("selShippingType_"+i).value
			}
			if(document.getElementById('Item_qty_'+i)!=undefined)
			{
				if((document.getElementById('Item_qty_'+(i)).value) =="")
				{	
					
					alert("Enter all fields first then generate a new row");
					document.getElementById('Item_qty_'+(i)).focus();
					return false;
				}
				if((document.getElementById('Item_qty_'+(i)).value) =="")
				{
					alert("Enter all fields first then generate a new row");
					document.getElementById('Item_qty_'+(i)).focus();
					return false;
				}
			}
			
			if(document.getElementById('Item_weight_'+i)!=undefined)
			{
				if((document.getElementById('Item_weight_'+(i)).value) =="")
				{
					alert("Enter all fields first then generate a new row");
					document.getElementById('Item_weight_'+(i)).focus();
					return false;
				}
				
				if($("#Item_weight_"+i).val() == "")
				{
					alert("Enter all fields first then generate a new row");
					document.getElementById('Item_weight_'+(i)).focus();
					return false;
				}
			}
			if(document.getElementById('Item_length_'+i)!=undefined)
			{
				if((document.getElementById('Item_length_'+(i)).value) =="")
				{
					alert("Enter all fields first then generate a new row");
					document.getElementById('Item_length_'+(i)).focus();
					return false;
				}
				if($("#Item_length_"+i).val() == "")
				{
					alert("Enter all fields first then generate a new row");
					document.getElementById('Item_length_'+(i)).focus();
					return false;
				}
			}
			if(document.getElementById('Item_width_'+i)!=undefined)
			{
				if( (document.getElementById('Item_width_'+(i)).value) =="")
				{
					alert("Enter all fields first then generate a new row");
					document.getElementById('Item_width_'+(i)).focus();
					return false;
				}
				if($("#Item_width_"+i).val() == "")
				{
					alert("Enter all fields first then generate a new row");
					document.getElementById('Item_width_'+(i)).focus();
					return false;
				}
			}
			if(document.getElementById('Item_height_'+i)!=undefined)
			{
				if( (document.getElementById('Item_height_'+i).value) =="")
				{
					alert("Enter all fields first then generate a new row");
					document.getElementById('Item_height_'+(i)).focus();
					return false;
				}
				
			}
			
			
			
		}

	}
	dummy=dummy+1;

	if(jQuery("#flage").val()==2){
		document.getElementById('last_inserted_cell_international').value = parseInt(dummy);
	}else{
		document.getElementById('last_inserted_cell_australia').value = parseInt(dummy);
	}
	
	var tblShippingTypeData, tblShippingTypeDataBody;
	tblShippingTypeData = document.getElementById("size_display_block_1");
	tblShippingTypeDataBody = tblShippingTypeData.tBodies[0];
	var totShippingTypeDataRows = tblShippingTypeData.rows.length;
	var newRowNo = totShippingTypeDataRows + 1;
	if(newRowNo > dummy)
	{
		dummy=newRowNo;
	}
	var newShippingTypeDataRow = tblShippingTypeDataBody.insertRow(newRowNo-1);
	var size_td ="<td>&nbsp;</td>";
	var size_select = getItemDuplicateDrp(dummy,id);
	tabindexval=tabindexval+1;
	var size_cm ='<span id="cm" class="smallbluefont">&nbsp;cm&nbsp;</span>';
	var size_kg='<span id="kg" class="smallbluefont">&nbsp;kg&nbsp;&nbsp;</span>';
	if($('#Item_qty_'+id).is('[readonly=readonly]') == true)
	{
		var item_read_qty = 'readonly=readonly';
	}
	
	var size_qty='<input name="Item_qty[]"  tabindex="'+tabindexval+'"  type="text" '+item_read_qty+' id ="Item_qty_'+dummy+'" class="get_input"  onblur= "display_total_value();" onchange="round_up(this.id,this.value,0);"  value="'+(document.getElementById('Item_qty_'+(id)).value)+'" style="margin-right:auto; margin-left:auto;"/><span class="smallbluefont">&nbsp;pcs</span><br /><span class="requiredInformation" id ="Items_qty_'+dummy+'"></span>';

	tabindexval=tabindexval+1;
	if($('#Item_weight_'+id).is('[readonly=readonly]') == true)
	{
		var item_read_weight = 'readonly=readonly';
	}
	var size_weight='<input name="Item_weight[]" tabindex="'+tabindexval+'" type="text" '+item_read_weight+' id ="Item_weight_'+dummy+'" class="get_input" onblur= "display_total_value();"  onchange="round_up(this.id,this.value,1);"  value="'+(document.getElementById('Item_weight_'+(id)).value)+'"/>'+size_kg+'<br /><span class="requiredInformation" id ="Items_weight_'+dummy+'"></span>';
	
	
	tabindexval=tabindexval+1;
	if($('#Item_length_'+id).is('[readonly=readonly]') == true)
	{
		var item_read_length = 'readonly=readonly';
	}
	var size_length='<input name="Item_length[]" type="text" '+item_read_length+' tabindex="'+tabindexval+'"  id ="Item_length_'+dummy+'"  class="get_input"  onblur= "display_total_value();" onchange="round_up(this.id,this.value,1);"  value="'+(document.getElementById('Item_length_'+(id)).value)+'"/>'+size_cm+'<br/><span class="requiredInformation" id ="Items_length_'+dummy+'"></span>';
	
	tabindexval=tabindexval+1;
	if($('#Item_width_'+id).is('[readonly=readonly]') == true)
	{
		var item_read_width = 'readonly=readonly';
	}
	var size_width='<input name="Item_width[]" type="text" '+item_read_width+' tabindex="'+tabindexval+'"  id ="Item_width_'+dummy+'" class="get_input"  onblur= "display_total_value();" onchange="round_up(this.id,this.value,1);"   value="'+(document.getElementById('Item_width_'+(id)).value)+'"/>'+size_cm+'<br /><span class="requiredInformation" id ="Items_width_'+dummy+'"></span>';

	tabindexval=tabindexval+1;
	if($('#Item_height_'+id).is('[readonly=readonly]') == true)
	{
		var item_read_height = 'readonly=readonly';
	}
	var size_height = '<input name="Item_height[]" tabindex="'+tabindexval+'" '+item_read_height+'  type="text" id ="Item_height_'+dummy+'" class="get_input" onblur= "display_total_value();"   onchange="round_up(this.id,this.value,1);" value="'+(document.getElementById('Item_height_'+(id)).value)+'"/>'+size_cm+'<br /><span class="requiredInformation" id ="Items_height_'+dummy+'"></span>';

	var strDelShippingType = '<input type="button" value="REMOVE" tabindex="14" name="deleteSizeData[]" class="btn"  onclick="DelSizeDataRow('+dummy+');"	/>';
	var strDuplicate = '<input type="button" tabindex="15" name="btn_copy[]" id='+dummy+' class = "btn btn-primary" value= "DUPLICATE" onclick="DuplicateSizeDataRow(this.id);"	/>';
	var CellData = [size_select,size_td,size_qty,size_td,size_weight,size_length,size_width,size_height,size_td,strDuplicate,strDelShippingType];
	for (var i = 0; i < CellData.length; i++) {
		newCell = newShippingTypeDataRow.insertCell(i);
		newCell.innerHTML = CellData[i];
		newShippingTypeDataRow.id =dummy;
	}
	//display_size(document.getElementById('selShippingType_'+dummy).value,dummy);
	display_total_value();

}

function addShippingvalidation_old()
{
	
	if(document.getElementById('size_display_block_international').style.display=="none")
	{
		var tblShippingTypeData, tblShippingTypeDataBody;
		tblShippingTypeData = document.getElementById("size_display_block_1");
		tblShippingTypeDataBody = tblShippingTypeData.tBodies[0];
		var totShippingTypeDataRows = tblShippingTypeData.rows.length;
		var newRowNo = totShippingTypeDataRows + 1;
		document.getElementById("last_inserted_cell_australia").value= newRowNo+1;
		
		for(var i=1;i<=dummy;i++)
		{
			if(document.getElementById("selShippingType_"+i) != undefined)
			{
				if(document.getElementById("selShippingType_"+i).value==0)
				{
					$("#selShippingTypes_"+i).html("Select package Type");
					document.getElementById("selShippingType_"+i).focus();
					return false;
				}
				shipping_type = document.getElementById("selShippingType_"+i).value
			}
			if(document.getElementById('Item_qty_'+i)!=undefined)
			{
				if((document.getElementById('Item_qty_'+(i)).value) =="")
				{	
					alert("Enter all fields first then generate a new row");
					document.getElementById('Item_qty_'+(i)).focus();
					return false;
				}
				
			}
			
			if(document.getElementById('Item_weight_'+i)!=undefined)
			{
				if( (document.getElementById('Item_weight_'+(i)).value) =="")
				{
					alert("Enter all fields first then generate a new row");
					document.getElementById('Item_weight_'+(i)).focus();
					return false;
				}
				if((trim(document.getElementById("selShippingType_"+i).value) == '1') && (document.getElementById('Item_weight_'+(i)).value == ""))
				{
					
					alert("Enter all fields first then generate a new row");
					document.getElementById('Item_weight_'+(i)).focus();
					return false;
				}
			}
			if(document.getElementById('Item_length_'+i)!=undefined)
			{
				if((document.getElementById('Item_length_'+(i)).value) =="")
				{
					alert("Enter all fields first then generate a new row");
					document.getElementById('Item_length_'+(i)).focus();
					return false;
				}
				if(trim(document.getElementById("selShippingType_"+i).value) != 1 && (document.getElementById('Item_length_'+(i)).value ==""))
				{
					alert("Enter all fields first then generate a new row");
					document.getElementById('Item_length_'+(i)).focus();
					return false;
				}
			}
			if(document.getElementById('Item_width_'+i)!=undefined)
			{
				if( (document.getElementById('Item_width_'+(i)).value) =="")
				{
					alert("Enter all fields first then generate a new row");
					document.getElementById('Item_width_'+(i)).focus();
					return false;
				}
				if(trim(document.getElementById("selShippingType_"+i).value) != 1 && trim(document.getElementById('Item_width_'+(i)).value ==""))
				{
					alert("Enter all fields first then generate a new row");
					document.getElementById('Item_width_'+(i)).focus();
					return false;
				}

			}
			if(document.getElementById('Item_height_'+i)!=undefined)
			{
				if( (document.getElementById('Item_height_'+i).value) =="")
				{
					alert("Enter all fields first then generate a new row");
					document.getElementById('Item_height_'+(i)).focus();
					return false;
				}
				if(trim(document.getElementById("selShippingType_"+i).value) != 1 && (document.getElementById('Item_height_'+(i)).value ==""))
				{
					alert("Enter all fields first then generate a new row");
					document.getElementById('Item_height_'+(i)).focus();
					return false;
				}
			}
			
			
			
		}

		addShippingTypeDataRows();
	}
	if(document.getElementById('size_display_block_international').style.display=="block")
	{
		var tblShippingTypeData, tblShippingTypeDataBody;
		tblShippingTypeData = document.getElementById("size_display_block_international");
		tblShippingTypeDataBody = tblShippingTypeData.tBodies[0];
		var totShippingTypeDataRows = tblShippingTypeData.rows.length;
		var newRowNo = totShippingTypeDataRows + 1;
		document.getElementById("last_inserted_cell_international").value= newRowNo+1;
		//alert("for inter"+newRowNo)
		for(var i=1;i<=dummy;i++)
		{
				
			if(document.getElementById('inter_ShippingType_'+i)!=undefined)
			{
				if( (document.getElementById('inter_ShippingType_'+(i)).value) ==0)
				{
					alert("Enter all fields first then generate a new row");
					document.getElementById('inter_ShippingType_'+(i)).focus();
					return false;
				}

			}
			
			if(document.getElementById('qty_item_'+i)!=undefined)
			{
				if( (document.getElementById('qty_item_'+(i)).value) =="")
				{
					alert("Enter all fields first then generate a new row");
					document.getElementById('qty_item_'+(i)).focus();
					return false;
				}else{
					$("#Items_qty_"+i).html("");
					
				}
			}
			if(document.getElementById('weight_item_'+i)!=undefined)
			{
				if( (document.getElementById('weight_item_'+(i)).value) =="")
				{
					alert("Enter all fields first then generate a new row");
					document.getElementById('weight_item_'+(i)).focus();
					return false;
				}else{
					$("#weight_items_"+i).html("");
				}
			}
			if(document.getElementById('length_item_'+i)!=undefined)
			{
				if( (document.getElementById('length_item_'+(i)).value) =="")
				{
					alert("Enter all fields first then generate a new row");
					document.getElementById('length_item_'+(i)).focus();
					return false;
				}else{
					$("#length_items_"+i).html("");
				}
			}
			if(document.getElementById('width_item_'+i)!=undefined)
			{
				if( (document.getElementById('width_item_'+(i)).value) =="")
				{
					alert("Enter all fields first then generate a new row");
					document.getElementById('width_item_'+(i)).focus();
					return false;
				}else{
					$("#width_items_"+i).html("");
				}

			}
			if(document.getElementById('height_item_'+i)!=undefined)
			{
				if( (document.getElementById('height_item_'+i).value) =="")
				{
					alert("Enter all fields first then generate a new row");
					document.getElementById('height_item_'+(i)).focus();
					return false;
				}else{
					$("#height_items_"+i).html("");
				}
			}
			
			
			
		}
		
		addShippingInterTypeDataRows();
	}

}



function addShippingTypeDataRows()
{
	
	dummy=dummy+1;
	var tblShippingTypeData, tblShippingTypeDataBody;
	tblShippingTypeData = document.getElementById("size_display_block_1");
	tblShippingTypeDataBody = tblShippingTypeData.tBodies[0];
	var totShippingTypeDataRows = tblShippingTypeData.rows.length;

	var newRowNo = totShippingTypeDataRows + 1;
	if(newRowNo > dummy)
	{

		dummy=newRowNo;
	}
	
	var newShippingTypeDataRow = tblShippingTypeDataBody.insertRow(newRowNo-1);
	var size_td ="<td>&nbsp;</td>";
	var size_select = getItemTypeDrp(dummy);
	tabindexval=tabindexval+1;
	var size_cm ='<span id="cm" class="smallbluefont">&nbsp;cm&nbsp;</span>';
	var size_kg='<span id="kg" class="smallbluefont">&nbsp;kg&nbsp;&nbsp;</span>';
	
	var size_qty='<input name="Item_qty[]"  tabindex="'+tabindexval+'" type="text" id ="Item_qty_'+dummy+'" class="get_input"  onblur= "display_total_value();" onchange="round_up(this.id,this.value,0);" style="margin-right:auto; margin-left:auto;"/><span class="smallbluefont">&nbsp;pcs</span><br /><span class="requiredInformation" id ="Items_qty_'+dummy+'"></span>';

	tabindexval=tabindexval+1;
	var size_weight='<input name="Item_weight[]" tabindex="'+tabindexval+'"  type="text" id ="Item_weight_'+dummy+'" class="get_input" onblur= "display_total_value();"  onchange="round_up(this.id,this.value,1);" />'+size_kg+'<br /><span class="requiredInformation" id ="Items_weight_'+dummy+'"></span>';
	

	tabindexval=tabindexval+1;
	var size_length = '<input name="Item_length[]" tabindex="'+tabindexval+'" type="text"  id ="Item_length_'+dummy+'"  class="get_input"  onblur= "display_total_value();" onchange="round_up(this.id,this.value,1);" />'+size_cm+'<br /><span class="requiredInformation" id ="Items_length_'+dummy+'"></span>';

	tabindexval=tabindexval+1;
	var size_width = '<input name="Item_width[]" tabindex="'+tabindexval+'" type="text"  id ="Item_width_'+dummy+'" class="get_input"  onblur= "display_total_value();" onchange="round_up(this.id,this.value,1);"  />'+size_cm+'<br /><span class="requiredInformation" id ="Items_width_'+dummy+'"></span>';

	tabindexval=tabindexval+1;
	var size_height = '<input name="Item_height[]" tabindex="'+tabindexval+'"  type="text" id ="Item_height_'+dummy+'" class="get_input" onblur= "display_total_value();"   onchange="round_up(this.id,this.value,1);"/>'+size_cm+'<br /><span class="requiredInformation" id ="Items_height_'+dummy+'"></span>';

	var strDelShippingType = '<input type="button" value="REMOVE" name="deleteSizeData[]" class="btn"  onclick="DelSizeDataRow('+dummy+');"	/>';
	var strDuplicate = '<input type="button" name="btn_copy[]" id='+dummy+' class = "btn btn-primary" value= "DUPLICATE" onclick="DuplicateSizeDataRow(this.id);"	/>';
	//var CellData = [size_select,size_td,size_qty,size_td,size_weight,size_kg,size_length,size_cm,size_width,size_cm,size_height,size_cm,size_td,strDuplicate,strDelShippingType];
	//Added by shailesh jamanapara on date 15-3-13
	var CellData = [size_select,size_td,size_qty,size_td,size_weight,size_length,size_width,size_height,size_td,strDuplicate,strDelShippingType];
	for (var i = 0; i < CellData.length; i++) {
		newCell = newShippingTypeDataRow.insertCell(i);
		newCell.innerHTML = CellData[i];
		newShippingTypeDataRow.id =dummy;
	}
}

function international_toggle_index(selectedcountry,url)
{
	
	if (selectedcountry !='')
	{
		url=url+"?selectedid="+selectedcountry;
	}
	
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari

		xmlhttp=new XMLHttpRequest();
		xmlhttp.open("GET",url,false);
		xmlhttp.send(null);
	}else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		xmlhttp.open("GET",url,false);
		// Do not send null for ActiveX
		xmlhttp.send();
	}
	
	document.getElementById('international_country_display').style.display="block";
	document.getElementById('international_country_display').innerHTML=xmlhttp.responseText;
	document.getElementById('display_delivery').style.display="none";
	document.getElementById("aus_cls").setAttribute("class", "aus_inactive");
	document.getElementById("inter_cls").setAttribute("class", "international_active");
	if (selectedcountry =='')
	{
		document.getElementById('inter_country').options[0].selected= true;
	}

	document.getElementById('ausitemtable').style.display="none";
	document.getElementById('interitemtable').style.display="table";
	document.getElementById('delivery_location_type').style.display="none";
	document.getElementById('flage').value="2";
	$.ajax({
	  url: '<?php echo DIR_HTTP_RELATED."ajax_inter_service.php"; ?>',
	  type: 'post',
	  success: function(data, status) {  
		if(data != 0)
		{
			$("#InterPersonalEff").modal('show');
		}else{
					
			$("#InterService").modal('show');
			australia_toggle_index();
			
		}
		
	  },
	  error: function(xhr, desc, err) {
		console.log(xhr);
		console.log("Details: " + desc + "\nError:" + err);
	  }
	}); // end ajax call
}


function inter_item(internationalitem_val)
{

	document.getElementById('doc_wght').style.display="none";
	document.getElementById('nondoc_wght').style.display="block";
	document.getElementById('lbl_size').style.display="block";
	document.getElementById('inter_h').style.display="block";
	document.getElementById('inter_x').style.display="block";
	document.getElementById('inter_l').style.display="block";
	document.getElementById('inter_y').style.display="block";
	document.getElementById('inter_w').style.display="block";
	document.getElementById('dim_img').style.display="block";
	document.getElementById('qty_img').style.display="block";
	document.getElementById('inter_lblqty').style.display="block";
	document.getElementById('inter_qty').style.display="block";

	if(internationalitem_val==1)
	{
		document.getElementById('doc_wght').style.display="block";
		document.getElementById('nondoc_wght').style.display="none";
		document.getElementById('lbl_size').style.display="none";
		document.getElementById('inter_h').style.display="none";
		document.getElementById('inter_x').style.display="none";
		document.getElementById('inter_l').style.display="none";
		document.getElementById('inter_y').style.display="none";
		document.getElementById('inter_w').style.display="none";
		document.getElementById('dim_img').style.display="none";
		document.getElementById('qty_img').style.display="none";
		document.getElementById('inter_lblqty').style.display="none";
		document.getElementById('inter_qty').style.display="none";


	}



}


function australia_toggle(){
	
	document.getElementById("aus_cls").setAttribute("class", "aus_active"); /* tick which when selected for australia */
	document.getElementById("inter_cls").setAttribute("class", "international");/* tick which when selected for international*/
	document.getElementById('display_delivery').style.display="inline";
	document.getElementById('international_country_display').style.display="none";
	document.getElementById('size_display_block_1').style.display="block";
	if($('#size_display_block_international') != undefined)
	{
		document.getElementById('size_display_block_international').style.display="none";
	}
	document.getElementById('ausResult').style.display="table";
	//$("#servicePageItem_1").css("display","none");
	document.getElementById('interResult').style.display="none";
	document.getElementById('delivery_location_type').style.display="block";
	document.getElementById('flage').value="1";
	document.getElementById('display_delivery').style.display="inline";

}
function australia_toggle_index(){

	
	document.getElementById("aus_cls").setAttribute("class", "aus_active"); /* tick which when selected for australia */
	document.getElementById("inter_cls").setAttribute("class", "international");/* tick which when selected for international*/
	document.getElementById('display_delivery').style.display="block";
	document.getElementById('international_country_display').style.display="none";
	document.getElementById('ausitemtable').style.display="table";
	document.getElementById('interitemtable').style.display="none";
	document.getElementById('delivery_location_type').style.display="block";
	document.getElementById('flage').value="1";
	

}
//parag
function postinter(international_country_val)
{
	
	var pickupval = $('#pickup').val();
	if(pickupval == "PICK UP SUBURB/POSTCODE")
	{
		$("#pickupError").html("Enter post code or suburb and confirm your choice");
		$("#pickupError").focus();
		return false;
	}else{
		$("#pickupError").html("");
	}
	var deliverval = international_country_val;
	
}


function aust_item(australian_items,item_row)
{



	if(australian_items==1)
	{
		document.getElementById("Qty_1").value="";
		document.getElementById('size_display_block_1').style.display="none";
	}

	document.getElementById("Qty_1").value="";

}




function getObject(name) {
	var ns4 = (document.layers) ? true : false;
	var w3c = (document.getElementById) ? true : false;
	var ie4 = (document.all) ? true : false;

	if (ns4) return eval('document.' + name);
	if (w3c) return document.getElementById(name);
	if (ie4) return eval('document.all.' + name);
	return false;
}

/*
functions taken from old version
*/

function isAlien(a) {
	return isObject(a) && typeof a.constructor != 'function';
}

function isArray(a) {
	return isObject(a) && a.constructor == Array;
}

function isBoolean(a) {
	return typeof a == 'boolean';
}

function isEmpty(o) {
	var i, v;
	if (isObject(o)) {
		for (i in o) {
			v = o[i];
			if (isUndefined(v) && isFunction(v)) {
				return false;
			}
		}
	}
	return true;
}

function isFunction(a) {
	return typeof a == 'function';
}

function isNull(a) {
	return a === null;
}

function isNumber(a) {
	return typeof a == 'number' && isFinite(a);
}

function isInt(a) {
	if(a == parseInt(a)){
		return true;
	}else{
		return false;
	}
}

function isNumeric(a) {
	if(a == parseFloat(a)){
		return true;
	}else{
		return false;
	}
}

function isObject(a) {
	return (a && typeof a == 'object') || isFunction(a);
}

function isString(a) {
	return typeof a == 'string';
}

function twodp(v){
	return Math.round(v*100)/100;
}

function threedp(v){
	return Math.round(v*1000)/1000;
}

function isUndefined(a) {
	return typeof a == 'undefined';
}

function hidetoggle (e) {
	document.getElementById(e).style.display = (document.getElementById(e).style.display == 'none') ? 'block' : 'none';
	return false;
}

function hide (e) {
	document.getElementById(e).style.display = 'none';
	return false;
}

function show (e,d) {
	if(isUndefined(d)){
		d = "block";
	}
	document.getElementById(e).style.display = d;
	return false;
}

function validateText(obj,list,valid){
	var Invalid = false;
	var Text = obj.value;
	var Len = Text.length;
	var i;
	var LetterPos;
	if(Len > 0){
		for(i=0;i<Len;i++){
			LetterPos = list.indexOf(Text.charAt(i),0);
			if ((valid == false) && (LetterPos >= 0))
			Invalid = true;
			if ((valid == true) && (LetterPos == -1))
			Invalid = true;
		}
	}
	return Invalid;
}

function checkEmpty(obj){
	if(isNumber(obj.length)){
		return (obj.length > 0);
	}else{
		return (obj.value.length > 0);
	}
}

function checkEmail(obj){
	var address = obj.value;
	var valid = true;
	if(address.length > 0){
		if((address == "") || (address.indexOf('@') == -1) || (address.indexOf('.') == -1)){
			valid = false;
		}else if(validateText(obj,"abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@._-",true)){
			valid = false;
		}
	}
	return valid;
}

function checkConfirmation(v1, v2) {
	if (v1 == v2)
	return true;
	return false;
}

function changeContent (e,to) {
	if(document.all){
		document.getElementById(e).innerText=to;
	} else{
		document.getElementById(e).textContent=to;
	}
}

function validateNumeric(obj){
	var Invalid = false;
	var ValidLetters ="1234567890.";
	var Text = obj.value;
	var Len = Text.length;
	var Idval = obj.id;
	var i;
	var LetterPos;
	if(Len > 0){
		for(i=0;i<Len;i++){
			LetterPos = ValidLetters.indexOf(Text.charAt(i),0);
			if (LetterPos == -1)
			Invalid = true;
		}
		if (Invalid){
			alert("Enter numeric values only (0-9)");
			obj.focus();
			/*document.getElementById(Idval).focus();*/
			obj.select();
			return false;
		}
	}
	return;
}
function roundNumber(number,decimals) {

	var newString;// The new rounded number
	decimals = Number(decimals);
	if (decimals < 1) {
		newString = (Math.round(number)).toString();
	} else {
		var numString = number.toString();
		if (numString.lastIndexOf(".") == -1) {// If there is no decimal point
			numString += ".";// give it one at the end
		}
		var cutoff = numString.lastIndexOf(".") + decimals;// The point at which to truncate the number
		var d1 = Number(numString.substring(cutoff,cutoff+1));// The value of the last decimal place that we'll end up with
		var d2 = Number(numString.substring(cutoff+1,cutoff+2));// The next decimal, after the last one we want
		if (d2 >= 5) {// Do we need to round up at all? If not, the string will just be truncated
			if (d1 == 9 && cutoff > 0) {// If the last digit is 9, find a new cutoff point
				while (cutoff > 0 && (d1 == 9 || isNaN(d1))) {
					if (d1 != ".") {
						cutoff -= 1;
						d1 = Number(numString.substring(cutoff,cutoff+1));
					} else {
						cutoff -= 1;
					}
				}
			}
			d1 += 1;
		}
		if (d1 == 10) {
			numString = numString.substring(0, numString.lastIndexOf("."));
			var roundedNum = Number(numString) + 1;
			newString = roundedNum.toString() + '.';
		} else {
			newString = numString.substring(0,cutoff) + d1.toString();
		}
	}
	if (newString.lastIndexOf(".") == -1) {// Do this again, to the new string
		newString += ".";
	}
	var decs = (newString.substring(newString.lastIndexOf(".")+1)).length;
	for(var i=0;i<decimals-decs;i++) newString += "0";
	var newNumber = Number(newString);// make it a number if you like
	//document.roundform.roundedfield.value = newString; // Output the result to the form field (change for your purposes)
	return newNumber;
}
function isNumber(numstr, errString) {

	numdecs = 0;
	for (i = 0; i < numstr.length; i++) {
		mychar = numstr.charAt(i);
		if ((mychar >= "0" && mychar <= "9") || mychar == "." ) {
			if (mychar ==  ".")
			numdecs++;
		} else {
			return errString;
		}
	}

	if (numdecs > 1) {
		return errString;
	}
	return '';
}

function DecimalValCheck(data)
{
	var sFullNumber = data.value;

	var ValidChars = "0123456789";
	var Validn = "0123456789";
	var IsDotPres=false;
	var Char;
	Char = sFullNumber.charAt(0);
	if (Validn.indexOf(Char) == -1)
	{
		/* alert("Please enter proper value.");
		data.select();*/
		return false;
	}
	else
	{
		for (i = 0; i < sFullNumber.length; i++)
		{
			Char = sFullNumber.charAt(i);
			if(Char == '.' )
			{
				if( IsDotPres == false)
				IsDotPres = true;
				else
				{
					/*alert("Please remove extra '.' or spaces.");
					data.select();*/
					return false;
				}
			}

			if (ValidChars.indexOf(Char) == -1 || ValidChars.indexOf(Char) == '.')
			{
				/* alert("Please check once again you entered proper value are not.");
				data.select();*/
				return false;
			}
		}
	}
	return true;
}//end Decimal value check.



/*
End of the functions taken from
*/
var req = null;

function loadXMLDoc(url) {


	// Internet Explorer
	/*try { req = new ActiveXObject("Msxml2.XMLHTTP"); }
	catch(e) {
	try { req = new ActiveXObject("Microsoft.XMLHTTP"); }
	catch(oc) { req = null; }
	}*/
	if (window.XMLHttpRequest) {
		req = new window.XMLHttpRequest;
	}
	else {
		try {
			req = new ActiveXObject("MSXML2.XMLHTTP.3.0");
		}
		catch(ex) {
			req = null;
		}
	}


	// Mozailla/Safari
	if (req == null && typeof XMLHttpRequest != "undefined") {
		req = new XMLHttpRequest();
	}

	if (req != null) {
		req.onreadystatechange = processChange;
		req.open("GET", url, true);
		req.send(null);
	}
}

function processChange(evt) {

	if (req.readyState == 4) {
		if (req.status == 200) {
			var data = req.responseText;
			var service = data.substring(0,3);
			if(service == "pic"){
				service = "pickup";
			} else {
				service = "deliver";
			}
			data = data.substring(3,data.length);
			if (data.substring(0,3) == "<ul") {
				getObject(service+"Result").innerHTML = data;
				getObject(service+"Result").style.display = "block";
			} else {
				getObject(service+"Result").style.display = "none";
			}
		}
	}
}

function updateSelect(obj,v){
	getObject(obj).value=v;
	getObject(obj+"Result").style.display = "none";
}



/*function booking_type(booking_name,total_amt)
{
document.getElementById("booking_type_hidden").value=booking_name;
//document.getElementById("bookingid").value=document.getElementById("bookingid").value;
document.getElementById("total_amt").value=total_amt;
document.sameday_rates.submit();
}*/
function booking_type(booking_name,total_amt)
{	
	
	if(booking_name=='overnight' || booking_name=='economy'){
		var carrier = 'AAE'
	}else{
		var carrier = 'DIRCOUR'
	} 
	
	var start_date = $("#start_date").val();
	var pickupid = $("#pickup").val();
	var time_hr=$("#time_hr").val();
	var time_sec=$("#time_sec").val();
	var hr_formate=$("#hr_formate").val();
	
	var xmlHttp = getXMLHttp();

		xmlHttp.onreadystatechange = function()
		{	
			if(xmlHttp.readyState == 4)
			{
				var msg=xmlHttp.responseText;
				
				if(xmlHttp.responseText!=1)
				{	
					
					$("#timeMsgBox").modal("show");
					$("#errtime").html("Current time of "+pickupid+" is "+msg+".\nSelect the time after the current time.");
					return 0;	
				}else{
					document.getElementById("booking_type_hidden").value=booking_name;
					document.getElementById("carrier").value=carrier;
					document.getElementById("total_amt").value=total_amt;
					document.sameday_rates.submit();
					
				}

			}
		}
		xmlHttp.open("POST", "sameday-rates.php?action=compair_time", true);
		xmlHttp.send(null);
	
}

function generalbooking()
{
	document.sameday_rates.submit();
}

function overnight_booking_type(booking_name,total_amt)
{	
	var start_date = $("#start_date").val();
	var pickupid = $("#pickup").val();
	var time_hr=$("#time_hr").val();
	var time_sec=$("#time_sec").val();
	var hr_formate=$("#hr_formate").val();
	var xmlHttp = getXMLHttp();

		xmlHttp.onreadystatechange = function()
		{	
			if(xmlHttp.readyState == 4)
			{
				var msg=xmlHttp.responseText;
				if(xmlHttp.responseText!=1)
				{	
					$("#timeMsgBox").modal("show");
					$("#errtime").html("Current time of "+pickupid+" is "+msg+".\nSelect the time after the current time.");	
					return 0;	
				}else{
					
					document.getElementById("booking_type_hidden").value=booking_name;
					document.getElementById("total_amt").value=total_amt;
					document.overnight_rates.submit();
					
				}

			}
		}
		xmlHttp.open("POST", "overnight-rates.php?action=compair_time", true);
		xmlHttp.send(null);
}

function international_booking_type(booking_name,total_amt)
{	
	   
	var start_date = $("#start_date").val();
	var pickupid = $("#pickup").val();
	var time_hr=$("#time_hr").val();
	var time_sec=$("#time_sec").val();
	var hr_formate=$("#hr_formate").val();
	   var xmlHttp = getXMLHttp();

		xmlHttp.onreadystatechange = function()
		{	
			if(xmlHttp.readyState == 4)
			{	
				var msg=xmlHttp.responseText;
				if(xmlHttp.responseText!=1)
				{	
					$("#timeMsgBox").modal("show");
					$("#errtime").html("Current time of "+pickupid+" is "+msg+".\nSelect the time after the current time.");	
					return 0;	
				}else{
					document.getElementById("booking_type_hidden").value=booking_name;
					document.getElementById("total_amt").value=total_amt;
					document.frminternational.submit();
					
				}

			}
		}
		xmlHttp.open("POST", "international-get-quote.php?action=compair_time", true);
		xmlHttp.send(null);

	
}
function getItemTypeDrp(id)
{
	if(document.getElementById('size_display_block_international').style.display=="none")
	{
		tabindexval=tabindexval+1;
		var total = document.getElementById('selShippingType_1').options.length;
		var opts = document.getElementById('selShippingType_1').options;
		var select = '<select onchange="return display_size(this.value,'+id+')" class="get_select" tabindex="'+tabindexval+'" id="selShippingType_'+id+'" name="selShippingType[]">';

		for(var i=0; i<total; i++)
		select += '<option value="'+opts[i].value+'">'+opts[i].text+'</option>';

		select += '</select><br /><span class="requiredInformation" id="selShippingTypes_'+id+'"></span>';
	}
	if(document.getElementById('size_display_block_international').style.display=="block")
	{
		tabindexval=tabindexval+1;
		var total = document.getElementById('inter_ShippingType_1').options.length;
		var opts = document.getElementById('inter_ShippingType_1').options;
		var select = '<select class="get_select" tabindex="'+tabindexval+'" id="inter_ShippingType_'+id+'" name="inter_ShippingType[]">';

		for(var i=0; i<total; i++)
		select += '<option value="'+opts[i].value+'">'+opts[i].text+'</option>';

		select += '</select>';
	}
	if(jQuery("#flage").val()==2){
		document.getElementById('last_inserted_cell_international').value = id;
	}else{
		document.getElementById('last_inserted_cell_australia').value = id;
	}

	return select;
}
function getItemWeightDrp(id)
{
	tabindexval=tabindexval+1;
	var total = document.getElementById('weight_item_1').options.length;
	var opts = document.getElementById('weight_item_1').options;
	var select = '<select class="get_select_weight_quote" onchange="return ItemWeightDropquote(this.value,'+id+')" tabindex="'+tabindexval+'" id="weight_item_'+id+'" name="weight_item[]">';

	for(var i=0; i<total; i++)
	select += '<option value="'+opts[i].value+'">'+opts[i].text+'</option>';

	select += '</select>';

	return select;
}

function getItemDuplicateDrp(dummy,id)
{

	if(document.getElementById('size_display_block_international').style.display =="none")
	{
		var total = document.getElementById('selShippingType_1').options.length;
		var opts = document.getElementById('selShippingType_1').options;
		var previd=(document.getElementById('selShippingType_'+(id)).value);
		tabindexval=tabindexval+1;

		var select = '<div id="servicePageItem_'+dummy+'" style="height:20px"><select onchange="return display_size(this.value,'+dummy+')" class="get_select" tabindex="'+tabindexval+'" id="selShippingType_'+dummy+'" name="selShippingType[]">';

		for(var i=0; i<total; i++)
		{
			var newval=opts[i].value;
			if(previd==newval)
			{
				select += '<option value="'+opts[i].value+'" selected>'+opts[i].text+'</option>';
			}
			else{
				select += '<option value="'+opts[i].value+'">'+opts[i].text+'</option>';
			}
		}
		select += '</select></div><br /><span class="requiredInformation" id="selShippingTypes_'+dummy+'"></span>';
	}
	if(document.getElementById('size_display_block_international').style.display=="block")
	{
		var total = document.getElementById('inter_ShippingType_1').options.length;
		var opts = document.getElementById('inter_ShippingType_1').options;
		var previd=(document.getElementById('inter_ShippingType_'+(id)).value);
		tabindexval=tabindexval+1;
		var select = '<select  class="get_select" tabindex="'+tabindexval+'" id="inter_ShippingType_'+dummy+'" name="inter_ShippingType[]">';

		for(var i=0; i<total; i++)
		{
			var newval=opts[i].value;
			if(previd==newval)
			{
				select += '<option value="'+opts[i].value+'" selected>'+opts[i].text+'</option>';
			}
			else{
				select += '<option value="'+opts[i].value+'">'+opts[i].text+'</option>';
			}
		}
		select += '</select>';
	}

	return select;

}
function getItemWeightDuplicateDrp(dummy,id)
{	
	var total = document.getElementById('weight_item_1').options.length;
	var opts = document.getElementById('weight_item_1').options;
	var previd=(document.getElementById('weight_item_'+(id)).value);
	tabindexval=tabindexval+1;
	var select = '<select onchange="return ItemWeightDropquote(this.value,'+dummy+')" class="get_select_weight_quote" tabindex="'+tabindexval+'" id="weight_item_'+dummy+'" name="weight_item[]">';

	for(var i=0; i<total; i++)
	{
		var newval=opts[i].value;
		if(previd==newval)
		{
			select += '<option value="'+opts[i].value+'" selected>'+opts[i].text+'</option>';
		}
		else{
			select += '<option value="'+opts[i].value+'">'+opts[i].text+'</option>';
		}
	}
	select += '</select>';

	return select;
}
function display_total_value()
{
	var tblShippingTypeData, tblShippingTypeDataBody;
	tblShippingTypeData = document.getElementById("size_display_block_1");
	var totalCount=$("#size_display_block_1 > div").length;
	//console.log("display block:"+totalCount);
	/*if(tblShippingTypeData.tBodies.length)         // use this if you are using id to check
	{
	     // it exists
	     tblShippingTypeDataBody = tblShippingTypeData.tBodies[0];
	}
	*/
	//var totShippingTypeDataRows = tblShippingTypeData.rows.length;
	var totShippingTypeDataRows = totalCount-1;
	var newRowNo = totShippingTypeDataRows;
	if(newRowNo>dummy)
	{
		dummy=newRowNo;
	}
	var sum=0;
	var total_weight=0;
	var volumetric_weight=0;
	var total_volumetric_weight=0;
	var h1,l1,w1,Qty,Weight;
	for(var i=0;i<=dummy;i++)
	{

		if(document.getElementById("Item_height_"+i) != undefined)
		{
			if((document.getElementById("Item_height_"+i).value)=="")
			{
				h1=0;
			}
			else
			{
				h1=document.getElementById("Item_height_"+i).value;
			}
		}
		else
		{
			continue;
		}
		if(document.getElementById("Item_length_"+i) != undefined)
		{
			if((document.getElementById("Item_length_"+i).value)=="")
			{
				//document.getElementById("Item_length_"+i).value="0";
				l1=0;
			}
			else
			{
				l1=document.getElementById("Item_length_"+i).value;
			}
		}
		else
		{
			continue;
		}
		if(document.getElementById("Item_width_"+i) != undefined)
		{
			if((document.getElementById("Item_width_"+i).value)=="")
			{
				//document.getElementById("Item_width_"+i).value="0";
				w1=0;
			}
			else
			{
				w1=document.getElementById("Item_width_"+i).value;
			}
		}
		else
		{
			continue;
		}
		if(document.getElementById('Item_qty_'+i) != undefined)
		{
			if(document.getElementById('Item_qty_'+i).value=="")
			{
				Qty ="0";
			}
			else
			{
				Qty=document.getElementById('Item_qty_'+i).value;
			}
		}
		else
		{
			continue;
		}
		if(document.getElementById('Item_weight_'+i) != undefined)
		{
			if(document.getElementById('Item_weight_'+i).value=="")
			{
				//document.getElementById('Item_weight_'+i).value="0";
				Weight="0";
			}
			else
			{
				Weight=document.getElementById('Item_weight_'+i).value;
			}
		}
		else
		{
			continue;
		}
		var divisior = <?php echo services_volumetric_charges; ?>;
		volumetric_weight =(h1*l1*w1)/divisior;
		total_volumetric_weight=roundup(total_volumetric_weight,1)+(roundup(volumetric_weight,1)*eval(Qty));
		sum=sum+eval(Qty);
		total_weight=total_weight+ (eval(Weight)*eval(Qty));
		sum =roundup(sum,0);

		document.getElementById("total_qty").innerHTML=eval(sum);
		total_weight=roundup(total_weight,1);
		document.getElementById("total_weight").innerHTML=total_weight;
		total_volumetric_weight=roundup(total_volumetric_weight,1);
		document.getElementById("total_volumetric_weight").innerHTML=roundup(total_volumetric_weight,0);

	}

	return true;

}
function round_up (name,val, precision) {
	/*
	if(trim(document.getElementById("selShippingType_1").val)!=4 &&
	trim(document.getElementById("selShippingType_1").val)!=5
	){
		precision = 0;
	}
	*/
	power = Math.pow (10, precision);
	poweredVal = Math.ceil (val * power);
	result =(isNaN(val))?(0):(poweredVal / power);
	document.getElementById(name).value=result;
	//setConsignmentsValue();
	return result;
}
function roundup(val,precision)
{
	power = Math.pow (10, precision);
	poweredVal = Math.ceil (val * power);
	result = poweredVal / power;
	return result;

}

function display_size_index(shipping_type,rowno,totalblocks)
{
	
	var service_page = trim($("#servicepagename").val());
	if(shipping_type==0)
	{
		$("#itemError").html("Select any Item Type");
		return false;
	}else{
		$("#itemError").html("");
	}
	var pickup = trim($("#pickup").val());
	if((pickup =="PICK UP SUBURB/POSTCODE") ||(pickup ==""))
	{	
		$("#pickupError").html('<?php echo SELECT_PICKUP_ITEM; ?>');
		$("#pickup").focus();
		errorflag = true;
		return false
	}
	if(pickup != '')
	{
		if(validateStr(pickup) == false)
		{
			$("#pickupError").html('<?php echo COMMON_SECURITY_ANSWER_ALPHANUMERIC; ?>');
			errorflag = true;
			return false
		}
		else
		{
			$("#pickupError").html('');
		}
	}
	var deliver = trim($("#deliver").val())
	if($('#display_delivery').css('display') == 'block')
	{	
		if((deliver == "DELIVERY SUBURB/POSTCODE") ||(deliver ==""))
		{
			$("#deliverError").html('<?php echo SELECT_DELIVER_ITEM; ?>');
			$("#deliver").focus();
			errorflag = true;
			return false
		}
		else
		{
			$("#deliverError").html('');
		}
	}else{
		var inter_box = $.trim($("#inter_country").val());
		if(inter_box == 'SELECT COUNTRY')
		{	
			$("#interError").html('<?php echo SELECT_INTERNATIONAL_COUNTRY; ?>');
			return false;
		}
		else
		{
			$("#interError").html('');
		}
		deliver = inter_box;
		service_page = 'international';
	}
	if(pickup != '' && deliver != '')
	{
		$.ajax({
		url: '<?php echo DIR_HTTP_RELATED."ajax_index_validation.php"; ?>',
		type: 'POST',
		data: {service_item_type:service_page,item_type:shipping_type,item_change:true},
		success: function(response) { //alert(response);
			
			var resArr = response.split("$");
			var j;
			if(resArr.length!=0)
			{
				for(j = 0;j<(resArr.length-1);j++)
				{
					var resError = resArr[j].split("=>");
					//alert(resError[1]);
					
					if(trim(resError[1])=="active")
					{			
						$(resError[0]).val('');
						$(resError[0]).attr('readonly', false);
						$("#weightError").html("");
						$("#lengthError").html("");
						$("#widthError").html("");
						$("#heightError").html("");
						
					}else{
						$(resError[0]).val(0);
						$(resError[0]).attr('readonly', true);
					}
					
				}
			}
			
		},
		error: function () {
			alert("your error code");
		}
		});
	}
	/*
	else if(shipping_type==1)
	{
		document.getElementById("Item_width").value="0";
		document.getElementById("Item_length").value="0";
		document.getElementById("Item_height").value="0";


		document.getElementById("Item_width").readOnly=true
		document.getElementById("Item_length").readOnly=true
		document.getElementById("Item_height").readOnly=true
	}
	else
	{
		document.getElementById("Item_width").value="";
		document.getElementById("Item_length").value="";
		document.getElementById("Item_height").value="";
		document.getElementById("Item_width").readOnly=false;
		document.getElementById("Item_length").readOnly=false;
		document.getElementById("Item_height").readOnly=false;
	}
	*/
}



function DuplicateSizeDataRowInternational(id)
{
	if(document.getElementById('size_display_block_international').style.display=="block")
	{
		var tblShippingTypeData, tblShippingTypeDataBody;
		tblShippingTypeData = document.getElementById("size_display_block_international");
		tblShippingTypeDataBody = tblShippingTypeData.tBodies[0];
		var totShippingTypeDataRows = tblShippingTypeData.rows.length;
		var newRowNo = totShippingTypeDataRows + 1;
		document.getElementById("last_inserted_cell_international").value= newRowNo+1;
		dummyinternational=dummyinternational+1;
		for(var i=1;i<=dummyinternational;i++)
		{
				
			if(document.getElementById('inter_ShippingType_'+i)!=undefined)
			{
				if( (document.getElementById('inter_ShippingType_'+(i)).value) ==0)
				{
					alert("Enter all fields first then generate a new row");
					document.getElementById('inter_ShippingType_'+(i)).focus();
					return false;
				}

			}
			
			if(document.getElementById('qty_item_'+i)!=undefined)
			{
				if((document.getElementById('qty_item_'+(i)).value =="") || (document.getElementById('qty_item_'+(i)).value ==""))
				{
					alert("Enter all fields first then generate a new row");
					document.getElementById('qty_item_'+(i)).focus();
					return false;
				}else{
					$("#Items_qty_"+i).html("");
				}
			}
			if(document.getElementById('weight_item_'+i)!=undefined)
			{
				if((document.getElementById('weight_item_'+(i)).value =="") || (document.getElementById('weight_item_'+(i)).value ==""))
				{
					alert("Enter all fields first then generate a new row");
					document.getElementById('weight_item_'+(i)).focus();
					return false;
				}else{
					$("#weight_items_"+i).html("");
				}
			}
			if(document.getElementById('length_item_'+i)!=undefined)
			{
				
				if((document.getElementById('length_item_'+(i)).value =="")  || (document.getElementById('length_item_'+(i)).value =="") )
				{
					alert("Enter all fields first then generate a new row");
					document.getElementById('length_item_'+(i)).focus();
					return false;
				}else{
					$("#length_items_"+i).html("");
				}
			}
			if(document.getElementById('width_item_'+i)!=undefined)
			{
				if( (document.getElementById('width_item_'+(i)).value == "") || (document.getElementById('width_item_'+(i)).value ==""))
				{
					alert("Enter all fields first then generate a new row");
					document.getElementById('width_item_'+(i)).focus();
					return false;
				}else{
					$("#width_items_"+i).html("");
					
				}

			}
			if(document.getElementById('height_item_'+i)!=undefined)
			{
				if( (document.getElementById('height_item_'+i).value =="")  || (document.getElementById('height_item_'+(i)).value ==""))
				{
					alert("Enter all fields first then generate a new row");
					document.getElementById('height_item_'+(i)).focus();
					return false;
				}else{
					$("#height_items_"+i).html("");
				}
			}
			
			
			
		}
		
		
	}
	
	var tblShippingTypeData, tblShippingTypeDataBody;
	if(jQuery("#flage").val()==2){
		document.getElementById('last_inserted_cell_international').value = parseInt(dummyinternational);
	}else{
		document.getElementById('last_inserted_cell_australia').value = parseInt(dummyinternational);
	}

	tblShippingTypeData = document.getElementById("size_display_block_international");
	tblShippingTypeDataBody = tblShippingTypeData.tBodies[0];
	var totShippingTypeDataRows = tblShippingTypeData.rows.length;
	var newRowNo = totShippingTypeDataRows + 1;
	if(newRowNo > dummyinternational)
	{
		dummyinternational=newRowNo;
	}
	var newShippingTypeDataRow = tblShippingTypeDataBody.insertRow(newRowNo-1);
	var size_td ="<td>&nbsp;</td>";
	//var size_select = getItemDuplicateDrp(dummyinternational,id);
	var size_select="";
	tabindexval=tabindexval+1;
	var size_cm ='<span id="cm" class="smallbluefont">&nbsp;cm&nbsp;</span>';
	var size_kg='<span id="kg" class="smallbluefont">&nbsp;kg&nbsp;&nbsp;</span>';
	if($('#qty_item_'+id).is('[readonly=readonly]') == true)
	{
		var qty_item_read = 'readonly=readonly';
	}
	var size_qty='<input name="qty_item[]" '+qty_item_read+'  tabindex="'+tabindexval+'"  type="text" id ="qty_item_'+dummyinternational+'" class="get_input"  onblur= "International_total_value();"  value="'+(document.getElementById('qty_item_'+(id)).value)+'"/><span class="smallbluefont">&nbsp;pcs</span><br /><span class="requiredInformation" id ="qty_items_'+dummyinternational+'"></span>';

	tabindexval=tabindexval+1;
	//var size_weight = getItemWeightDuplicateDrp(dummyinternational,id);
	if($('#weight_item_'+id).is('[readonly=readonly]') == true)
	{
		var weight_item_read = 'readonly=readonly';
	}
	var size_weight = '<input name="weight_item[]" '+weight_item_read+' type="text" tabindex="'+tabindexval+'"  id ="weight_item_'+dummyinternational+'"  class="get_input" onblur= "International_total_value();"    value="'+(document.getElementById('weight_item_'+(id)).value)+'"/>'+size_kg+'<br /><span class="requiredInformation" id ="weight_items_'+dummyinternational+'"></span>';
	
	tabindexval=tabindexval+1;
	if($('#length_item_'+id).is('[readonly=readonly]') == true)
	{
		var length_item_read = 'readonly=readonly';
	}
	var size_length = '<input name="length_item[]" '+length_item_read+' type="text" tabindex="'+tabindexval+'"  id ="length_item_'+dummyinternational+'"  class="get_input"  onblur= "International_total_value();"   value="'+(document.getElementById('length_item_'+(id)).value)+'"/>'+size_cm+'<br /><span class="requiredInformation" id ="length_items_'+dummyinternational+'"></span>';

	tabindexval=tabindexval+1;
	if($('#width_item_'+id).is('[readonly=readonly]') == true)
	{
		var width_item_read = 'readonly=readonly';
	}
	var size_width = '<input name="width_item[]" '+width_item_read+' type="text" tabindex="'+tabindexval+'"  id ="width_item_'+dummyinternational+'" class="get_input"  onblur= "International_total_value();"   value="'+(document.getElementById('width_item_'+(id)).value)+'"/>'+size_cm+'<br /><span class="requiredInformation" id ="width_items_'+dummyinternational+'"></span>';

	tabindexval=tabindexval+1;
	if($('#height_item_'+id).is('[readonly=readonly]') == true)
	{
		var height_item_read = 'readonly=readonly';
	}
	var size_height = '<input name="height_item[]" '+height_item_read+' tabindex="'+tabindexval+'"  type="text" id ="height_item_'+dummyinternational+'" class="get_input" onblur= "International_total_value();"    value="'+(document.getElementById('height_item_'+(id)).value)+'"/>'+size_cm+'<br /><span class="requiredInformation" id ="height_item_'+dummyinternational+'"></span>';

	var strDelShippingType = '<input type="button" value="REMOVE" tabindex="14" name="deleteSizeData[]" class="btn"  onclick="DelSizeinterDataRow('+dummyinternational+');"	/>';
	var strDuplicate = '<input type="button" tabindex="15" name="copy_btn[]" id='+dummyinternational+' class = "btn btn primary" value= "DUPLICATE" onclick="DuplicateSizeDataRowInternational(this.id);"	/>';
	var CellData = [size_select,size_td,size_qty,size_td,size_weight,size_length,size_width,size_height,size_td,strDuplicate,strDelShippingType];
	for (var i = 0; i < CellData.length; i++) {
		newCell = newShippingTypeDataRow.insertCell(i);
		newCell.innerHTML = CellData[i];
		newShippingTypeDataRow.id =dummyinternational;
	}
	ItemWeightDropquote(document.getElementById('weight_item_'+dummyinternational).value,dummyinternational);
	International_total_value();

}
function addShippingInterTypeDataRows()
{
	dummyinternational=dummyinternational+1;
	if(document.getElementById('size_display_block_international').style.display=="block")
	{
		var tblShippingTypeData, tblShippingTypeDataBody;
		tblShippingTypeData = document.getElementById("size_display_block_international");
		tblShippingTypeDataBody = tblShippingTypeData.tBodies[0];
		var totShippingTypeDataRows = tblShippingTypeData.rows.length;
		var newRowNo = totShippingTypeDataRows + 1;
		document.getElementById("last_inserted_cell_international").value= newRowNo+1;
		
		for(var i=1;i<=dummyinternational;i++)
		{
				
			if(document.getElementById('inter_ShippingType_'+i)!=undefined)
			{
				if( (document.getElementById('inter_ShippingType_'+(i)).value) ==0)
				{
					alert("Enter all fields first then generate a new row");
					document.getElementById('inter_ShippingType_'+(i)).focus();
					return false;
				}else{
					$("#allrows").html("");
				}

			}
			
			if(document.getElementById('qty_item_'+i)!=undefined)
			{
				if((document.getElementById('qty_item_'+(i)).value =="") || (document.getElementById('qty_item_'+(i)).value ==0))
				{
					alert("Enter all fields first then generate a new row");
					document.getElementById('qty_item_'+(i)).focus();
					return false;
				}else{
					$("#Items_qty_"+i).html("");
				}
			}
			if(document.getElementById('weight_item_'+i)!=undefined)
			{
				if((document.getElementById('weight_item_'+(i)).value =="") || (document.getElementById('weight_item_'+(i)).value ==0))
				{
					alert("Enter all fields first then generate a new row");
					document.getElementById('weight_item_'+(i)).focus();
					return false;
				}else{
					$("#weight_items_"+i).html("");
				}
			}
			if(document.getElementById('length_item_'+(i))!=undefined)
			{
				
				if((document.getElementById('length_item_'+(i)).value =="")  || (document.getElementById('length_item_'+(i)).value ==0) )
				{
					alert("Enter all fields first then generate a new row");
					document.getElementById('length_item_'+(i)).focus();
					return false;
				}else{
					$("#length_items_"+(i)).html("");
				}
			}
			if(document.getElementById('width_item_'+i)!=undefined)
			{
				if( (document.getElementById('width_item_'+(i)).value == "") || (document.getElementById('width_item_'+(i)).value ==0))
				{
					alert("Enter all fields first then generate a new row");
					document.getElementById('width_item_'+(i)).focus();
					return false;
				}else{
					$("#width_items_"+i).html("");
				}

			}
			if(document.getElementById('height_item_'+i)!=undefined)
			{
				if( (document.getElementById('height_item_'+i).value =="")  || (document.getElementById('height_item_'+(i)).value ==0))
				{
					alert("Enter all fields first then generate a new row");
					document.getElementById('height_item_'+(i)).focus();
					return false;
				}else{
					$("#height_items_"+i).html("");
				}
			}
			
			
			
		}
		
		
	}
	
	
	var tblShippingTypeData, tblShippingTypeDataBody;
	tblShippingTypeData = document.getElementById("size_display_block_international");	 document.getElementById("last_inserted_cell_international").value = dummyinternational
	tblShippingTypeDataBody = tblShippingTypeData.tBodies[0];
	var totShippingTypeDataRows = tblShippingTypeData.rows.length;
	var newRowNo = totShippingTypeDataRows + 1;
	if(newRowNo > dummyinternational)
	{

		dummyinternational=newRowNo;
	}
	var newShippingTypeDataRow = tblShippingTypeDataBody.insertRow(newRowNo-1);
	var size_td ="<td>&nbsp;</td>";
	//var size_select = getItemTypeDrp(dummyinternational);
	var size_select="<td>&nbsp;</td>";
	tabindexval=tabindexval+1;
	var size_qty='<input name="qty_item[]" value="1" tabindex="'+tabindexval+'" type="text" id ="qty_item_'+dummyinternational+'" class="get_input"  onblur= "International_total_value();"  /><span class="smallbluefont">&nbsp;pcs</span><br /><span class="requiredInformation" id ="qty_items_'+dummyinternational+'"></span>';

	tabindexval=tabindexval+1;
	var size_cm ='<span id="cm" class="smallbluefont">&nbsp;cm&nbsp;</span>';
	var size_kg='<span id="kg" class="smallbluefont">&nbsp;kg&nbsp;&nbsp;</span>';

	var size_weight = '<input name="weight_item[]" tabindex="'+tabindexval+'" type="text"  id ="weight_item_'+dummyinternational+'"  class="get_input"  onblur= "International_total_value();" />'+size_kg+'<br /><span class="requiredInformation" id ="weight_items_'+dummyinternational+'"></span>';


	tabindexval=tabindexval+1;
	var size_length = '<input name="length_item[]" tabindex="'+tabindexval+'" type="text"  id ="length_item_'+dummyinternational+'"  class="get_input"  onblur= "International_total_value();"  />'+size_cm+'<br /><span class="requiredInformation" id ="length_items_'+dummyinternational+'"></span>';

	tabindexval=tabindexval+1;
	var size_width = '<input name="width_item[]" tabindex="'+tabindexval+'" type="text"  id ="width_item_'+dummyinternational+'" class="get_input"  onblur= "International_total_value();"   />'+size_cm+'<br /><span class="requiredInformation" id ="width_items_'+dummyinternational+'"></span>';

	tabindexval=tabindexval+1;
	var size_height = '<input name="height_item[]" tabindex="'+tabindexval+'"  type="text" id ="height_item_'+dummyinternational+'" class="get_input" onblur= "International_total_value();"   />'+size_cm+'<br /><span class="requiredInformation" id ="height_items_'+dummyinternational+'"></span>';

	var strDelShippingType = '<input type="button" value="REMOVE" name="deleteSizeData[]" class="btn"  onclick="DelSizeinterDataRow('+dummyinternational+');"	/>';
	var strDuplicate = '<input type="button" name="btn_copy[]" id='+dummyinternational+' class = "btn btn-primary" value= "DUPLICATE" onclick="DuplicateSizeDataRowInternational(this.id);"	/>';
	var CellData = [size_select,size_td,size_qty,size_td,size_weight,size_length,size_width,size_height,size_td,strDuplicate,strDelShippingType];
	for (var i = 0; i < CellData.length; i++) {
		newCell = newShippingTypeDataRow.insertCell(i);
		newShippingTypeDataRow.id=dummyinternational;
		newCell.innerHTML = CellData[i];
	}
}

function ItemWeightDrop(weight,rowno,totalblocks)
{
	if(weight<"0.5")
	{
		$("#intWeightError").html("Select Item weight more then 0.0");
		return false;
	}else
	{
		document.getElementById("width_item").readOnly=false;
		document.getElementById("length_item").readOnly=false;
		document.getElementById("height_item").readOnly=false;
	}

}

function ItemWeightDropquote(weight,rowno,totalblocks)
{
	if(weight<"0.5")
	{
		alert("Select Item weight more then 0.0");
		return false;
	}
	
	else
	{
		document.getElementById("width_item_"+rowno).readOnly=false;
		document.getElementById("length_item_"+rowno).readOnly=false;
		document.getElementById("height_item_"+rowno).readOnly=false;
	}
	International_total_value();
}
function International_total_value()
{
	var tblShippingTypeData, tblShippingTypeDataBody;
	tblShippingTypeData = document.getElementById("size_display_block_international");
	tblShippingTypeDataBody = tblShippingTypeData.tBodies[0];
	var totShippingTypeDataRows = tblShippingTypeData.rows.length;
	var newRowNo = totShippingTypeDataRows;
	
	if(newRowNo>dummyinternational)
	{
		dummyinternational=newRowNo;
	}
	var inter_sum=0;
	var inter_total_weight=0;
	var inter_volumetric_weight=0;
	var inter_total_volumetric_weight=0;
	var Ih1,Il1,Iw1,IQty,IWeight;
	for(var i=0;i<=dummyinternational;i++)
	{

		if(document.getElementById("height_item_"+i) != undefined)
		{
			if((document.getElementById("height_item_"+i).value)=="")
			{
				Ih1=0;
			}
			else
			{
				Ih1=document.getElementById("height_item_"+i).value;
			}
		}
		else
		{
			continue;
		}
		
		if(document.getElementById("length_item_"+i) != undefined)
		{
			if((document.getElementById("length_item_"+i).value)=="")
			{
				//document.getElementById("Item_length_"+i).value="0";
				Il1=0;
			}
			else
			{
				Il1=document.getElementById("length_item_"+i).value;
			}
		}
		else
		{
			continue;
		}
		if(document.getElementById("width_item_"+i) != undefined)
		{
			if((document.getElementById("width_item_"+i).value)=="")
			{
				//document.getElementById("Item_width_"+i).value="0";
				Iw1=0;
			}
			else
			{
				Iw1=document.getElementById("width_item_"+i).value;
			}
		}
		else
		{
			continue;
		}
		if(document.getElementById('qty_item_'+i) != undefined)
		{
			if(document.getElementById('qty_item_'+i).value=="")
			{
				IQty ="0";
			}
			else
			{
				IQty=document.getElementById('qty_item_'+i).value;
			}
		}
		else
		{
			continue;
		}
		if(document.getElementById('weight_item_'+i) != undefined)
		{
			if(document.getElementById('weight_item_'+i).value=="0.0")
			{
				//document.getElementById('Item_weight_'+i).value="0";
				IWeight="0";
			}
			else
			{
				IWeight=document.getElementById('weight_item_'+i).value;
			}
		}
		else
		{
			continue;
		}
	
		var inter_divisior = <?php echo services_volumetric_charges; ?>;
		inter_volumetric_weight =(Ih1*Il1*Iw1)/inter_divisior;
		inter_total_volumetric_weight=roundup(inter_total_volumetric_weight,1)+(roundup(inter_volumetric_weight,1)*eval(IQty));
		inter_sum=inter_sum+eval(IQty);
		inter_total_weight=inter_total_weight+ (eval(IWeight)*eval(IQty));
		inter_sum =roundup(inter_sum,0);

		document.getElementById("inter_total_qty").innerHTML=eval(inter_sum);
		total_weight=roundup(inter_total_weight,1);
		document.getElementById("inter_total_weight").innerHTML=inter_total_weight;
		inter_total_volumetric_weight=roundup(inter_total_volumetric_weight,1);
		document.getElementById("inter_total_volumetric_weight").innerHTML=roundup(inter_total_volumetric_weight,0);


	}

	return true;

}


$(document).ready(function(){
	$("#change_international_timeready").click(function(){

		if(document.getElementById("time_hr").value=="hh")
		{
			alert("Select hour from time ready field");
			document.getElementById("time_hr").focus();
			return false;
		}
		else
		{
			hh=document.getElementById("time_hr").value;
		}
		if(document.getElementById("time_sec").value=="mm")
		{
			alert("Select min from time ready field");
			document.getElementById("time_sec").focus();
			return false;
		}
		else
		{
			mm=document.getElementById("time_sec").value;
		}

		var xmlHttp = getXMLHttp();

		xmlHttp.onreadystatechange = function()
		{
			if(xmlHttp.readyState == 4)
			{
				if(xmlHttp.responseText==1)
				{
					$("#book_now_transit").css("display","block");
					$("#aveliable_service").css("display","block");
					$("#not_aveliable_service").css("display","none");
				}
				else
				{
					$("#book_now_transit").css("display","none");
					$("#aveliable_service").css("display","none");
					$("#not_aveliable_service").css("display","block");
				}

			}
		}
		var time_hr=$("#time_hr").val();
		var time_sec=$("#time_sec").val();
		var hr_formate=$("#hr_formate").val();
		var start_date=$("#start_date").val();
		xmlHttp.open("POST", "international_get_quote.php?action=get_cutofftime&time_hr="+time_hr+"&time_sec="+time_sec+"&hr_formate="+hr_formate+"&start_date="+start_date, true);
		xmlHttp.send(null);

	});

});
function check_time()
{	
	var pickupid=$("#pickup").val();
	var start_date = $("#start_date").val();
	
	var time_hr=$("#time_hr").val();
	var time_sec=$("#time_sec").val();
	var hr_formate=$("#hr_formate").val();
	
	if(time_hr == 'hh')
	{
		$("#hhError").html("Enter hour value");
		$("#time_hr").focus();
		return false;
	}else{
		$("#hhError").html("");
	}
	
	if(time_sec == 'mm')
	{
		$("#mmError").html("Enter minute value");
		$("#time_sec").focus();
		return false;
	}else{
		$("#mmError").html("");
	}
	
	if($("#size_display_block_international").css("display")=="none"){
		if(document.getElementById("drc").value=="Please Select"){
			
			$("#drcError").html("Select Delivery Type");
			document.getElementById("drc").focus();
			return false;
		}else{
			$("#drcError").html("");
		}
	}
	var xmlhttp;
	xmlhttp=ajaxRequest();
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			var msg=xmlhttp.responseText;				
			
			if(msg==1)
			{  
				document.getElementById("temp").value = 1;
			}
			else
			{	
				msg = msg.split("&");
				
				if(msg.length > 1)
				{
					var i;
					for(i=0;i<=(msg.length-1);i++)
					{
						alert(msg[0]);
						return false;
					}
				}else
				{
					$('#confirmBox').modal('show');
					$('#errtime').html("Current time of "+pickupid+" is "+msg+".\nSelect the time after the current time.");
					return false;
				}
			}
		}
	}
	xmlhttp.open("GET","index.php?action=compair_time&pickupid="+pickupid+"&start_date="+start_date+"&time_hr="+time_hr+"&time_sec="+time_sec+"&hr_formate="+hr_formate,false);
	xmlhttp.send()
}
function ajaxRequest(){
var activexmodes=["Msxml2.XMLHTTP", "Microsoft.XMLHTTP"] //activeX versions to check for in IE
if (window.ActiveXObject){ //Test for support for ActiveXObject in IE first (as XMLHttpRequest in IE7 is broken)
	for (var i=0; i<activexmodes.length; i++){
		try{
			return new ActiveXObject(activexmodes[i])
		}
		catch(e){

			//suppress error
		}
	}
}
else if (window.XMLHttpRequest) // if Mozilla, Safari etc
return new XMLHttpRequest()
else
return false;
}
/*This function added by shailesh jamanapara*/
function setConsignmentsValue(){
	
	if(jQuery("#flage").val()==2){
		//alert("Here");
		var tbl = document.getElementById('size_display_block_international');
		var teble_lenght = tbl.rows.length;
		jQuery("#last_inserted_cell_international").val(teble_lenght)
	}else{
		
		var tbl = document.getElementById('size_display_block_1');
		var teble_lenght = tbl.rows.length;
		jQuery("#last_inserted_cell_australia").val(teble_lenght)
	}
	jQuery("#btn_submit").click(function(){
		var shippingType = document.getElementById('inter_ShippingType_1').value;
		if(shippingType ==4){
			
			teble_lenght = teble_lenght -1;

			if(jQuery("#inter_total_weight").html()!=""){
				jQuery("#international_total_weight").val(trim(jQuery("#inter_total_weight").html()))
			}
			if(jQuery("#inter_total_volumetric_weight").html()!=""){
				jQuery("#international_total_volumetric_weight").val(trim(jQuery("#inter_total_volumetric_weight").html()))
			}
			if(teble_lenght!=""){
				
				jQuery("#international_no_rows").val(trim(teble_lenght))
			}
			if(jQuery("#inter_total_qty").html()!=""){

				jQuery("#international_total_qty").val(trim(jQuery("#inter_total_qty").html()))
			}
		}

	});
}
function validationCallBack_old(errorflag)
{
	//alert("valid call back func:"+errorflag);
	check_time();
	
	if(errorflag == false && $("#temp").val() == 1){
		$("#btn_submit").val("Next");
		document.get_quote.submit();	
	}
}

</script>
