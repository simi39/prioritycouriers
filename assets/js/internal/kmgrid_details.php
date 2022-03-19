<script language="javascript" type="text/javascript">
jQuery(document).ready(function(){ 

	jQuery(".change_all_data").click(function(){ console.log("clicked"+jQuery(this).attr("id"));
		//alert("hi it is clicked");
		jQuery("#current_active_id").val(jQuery(this).attr("id"))//store the id of the ajax request
		$("#fetchdeliveryid").val($("#delivery").val());
		$("#fetchpickupid").val($("#pickup").val());

	});
		
		$("#ajax_index_listOfOptions div").on("click",function(){
		//alert($(this).attr("id"));
		console.log("clicked:"+$(this).attr("id"));
		var current_id = trim(jQuery("#current_active_id").val());
		var origional_postcode_id = trim("fetch"+current_id+"id"); // i.e: fetchpickupid,fetchdeliverid
		var origional_postcode_text = trim(current_id+"id"); //i.e. fetchid,deliverid
		var selected_id = jQuery(this).attr("id");
		
		var postcodedatawithid = selected_id.split(":");//find the postcode id for pickup
		var maximum_index_of_array = postcodedatawithid.length;
		var zone = trim(current_id+"zone");
		//alert(postcodedatawithid[1])
		jQuery("#"+origional_postcode_id).val(postcodedatawithid[1]);
		var origional_pickup_postcode_id_text =  postcodedatawithid[0] ;//find the text of the pickup id zone
		//console.log("currentid:"+current_id);
		jQuery("#"+current_id).val(origional_pickup_postcode_id_text);
		

	});
});	
</script>