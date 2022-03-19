<!-- ****	For Google map	****	-->
<?php if(FILE_FILENAME_WITH_EXT != FILE_CONTACT){ ?>
<script src="https://maps.google.com/maps/api/js?sensor=true"></script>
<?php } ?>
<script type="text/javascript">
$(document).ready(function(){
$('#geocoding_form').submit(function(e){ 
	//alert(trim($('#referenceId').val()));
	showMap(e,trim($('#referenceId').val()));
	
});	
	
});
/*
function show()
{
	
	//return false;
	showMap(trim($('#referenceId').val()));
	return false;
} */
function showMap(e,referenceId){ 
	
	e = (typeof e === "undefined") ? "" : e;	
	if(e){
		e.preventDefault();
	}
	
	//referenceId = '466000008563';
	$('#mapeff').modal("show");
	//alert(referenceId);
	$.ajax({ 
	  type: 'POST',
	  cache: false,
	  url: 'related/<?php echo FILE_TRACKING; ?>',
	  data: {'referenceId':referenceId},
	  dataType: 'json',
	  success: function(data){  
	   
	   //alert("total"+data.total_info);
	   var path = [];
	   var b = [];
	   var total_data_info = data.total_info;
	   var test = "";
	   var nomarks = [];
	   if(data != null){ 
	   var prevloc = '';
	   var maploc='';
	   $.each(data.points, function(index, response) {
			//var titleLoc = response.locName;
			if(prevloc != response.locName)
			{				
				
				var titleLoc = response.locName;
			}else{
				var titleLoc = 'none';
				
			}
			//alert("title:"+titleLoc);
			var latLngArr = response.latLng;
			path.push( response.latLng );
			test = latLngArr.toString().split(",");
			latlngb = new google.maps.LatLng(test[0],test[1]);
			b.push(latlngb);
			nomarks.push(response.locName);
			
			
				
			
			if(!test[2])
			{
				test[2] = 1;
			}
			
			if(index == 1){
				map = new GMaps({
					div: '#map1',
					zoom: parseInt(test[2]),
					lat: test[0],
					lng: test[1],
					resize: function(){
						var center = map.getCenter();
						map.setCenter(center.lat(), center.lng());
					}
					
				});
				
			}
			var center = map.getCenter();
		  
			map.addMarker({
				lat: test[0],
				lng: test[1],
				title: ""+titleLoc+"",
				icon:"http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld="+index+"|FF0000|000000",
				infoWindow: {
				  content: ""+titleLoc+""
				}
			});
			 prevloc = titleLoc;
	   });
	   
		
		  
		  var strstatus = [];
		  var strremark = [];
		  var strdatetime = [];
		  var strloc ="";
		  var strloconce = "";
		  var strInfo = "";
		  var commonId = "";
		  var strMobileInfo = "";
		  var tabId = "";
		  strInfo += "<thead><tr class='info'><th>Location</th><th>Date</th><th>Time</th><th>Event Id</th></tr></thead><tbody>";
		  strMobileInfo += "<thead><tr class='info'><th>Location</th><th>Date/Time</th><th>Event Id</th></tr></thead><tbody>";
		  var k = 1;
		  var srno ;
		  var t=1;
		  var s=1;
		  var sum = 1;
		  //srno = k;
		 var reverseIndex = total_data_info;
		 $.each(data.info, function(index, response) {
			
			if(strloconce != response.loc)
			{
				var loc = response.loc;
				strloc = loc;
				if(response.desc=='Booking Arranged'){
					tabId = "id='1' class='d1'";
				}else{
					tabId = "id="+response.id+" class="+"d"+response.id+"";
				}
				
			}else{
				if(response.desc=='Booking Arranged'){
					tabId = "id='1' class='d1'";
				}
				
				
				if(response.desc=='Collection')
				{
					strloc = response.loc;
					tabId = "id="+response.id+" class="+"d"+response.id+"";
				}else{
					//if(total_data_info == index)
					if(response.desc=='Delivered' || response.desc=='Out for Delivery')
					{
						//This is the delivered part
						strloc = response.loc;
						//srno = t+". ";
						tabId = "id="+response.id+" class="+"d"+response.id+"";
						
						t++;
					}else{
						strloc = " ";
						srno = "";
						s = "";
					}
				}
				
				
			}
			//}
			strdatetime = response.time.split(" ");
			
			
			strInfo += "<tr "+tabId+"><td>"+strloc+"</td><td>"+strdatetime[0]+"</td><td>"+strdatetime[1]+"</td><td>"+response.desc+"</td></tr>";
			strMobileInfo += "<tr "+tabId+"><td>"+strloc+"</td><td>"+strdatetime[0]+" "+strdatetime[1]+" "+strdatetime[2]+"</td><td>"+response.desc+"</td></tr>";
			
			strstatus.push(response.st);
			strremark.push(response.rm);
			
			strloconce = response.loc;
			k++;
			s++;
			reverseIndex--;			
		 });
		
		 strInfo +="</tbody>";
		 strMobileInfo += "</tbody>";
		 $("#tblDesktop").html(strInfo);
		 $("#tblMobile").html(strMobileInfo);
		 $("#status").html(strstatus[0]);
		 $('#sign').css("display","none");
		 //if(strstatus[strstatus.length - 1] == 'Delivered')
		 if(strstatus[0] == 'Delivered')
		 { 
			$('#sign').css("display","block"); 
			$("#status").removeClass("my_yellow");
			$("#status").addClass("my_red");
		 }
		 
		 $("#remark").html(strremark[0]);
		 //test[3] is for startrack and ups
		 if(test[3] == 2)
		 {
		 if(strstatus[0] != 'Delivered')
		 {
			 
			var lineSymbol = {
				path: 'M 0,-1 0,1',
				strokeOpacity: 1,
				scale: 4
			  };

			map.drawPolyline({
				path: path,
				strokeColor: '#f89406',
				strokeOpacity: 0,
				geodesic: true,
				icons: [{
				  icon: lineSymbol,
				  offset: '0',
				  repeat: '20px'
				}],
				strokeWeight: 6
			  });
			  
		}else{
			map.drawPolyline({
				path: path,
				strokeColor: '#FF0000',
				strokeOpacity: 0,
				strokeOpacity: 0.6,
				strokeWeight: 6
			  });
		
		}
		    map.getCenter();
			map.fitLatLngBounds(b);
			map.fitZoom();
			
		 }	
		  }
		
	   }
	});	
}
$('#closeTracking').on('click', function () {
  
   $('#map1').html('');
   $('#status').html('');
   $('#sign').css("display","none");
   $('#remark').html('');
   $('#referenceId').val('');
   $('.search-btn').removeClass('icon-remove');
   $('.search-btn').addClass('search-btn t_n_t');
   $('.search-open').css("display","none");
   $('#tblDesktop').html('');
   $('#tblMobile').html('');
  // do something…
});

<!--	***		Bootstrap validator	***		-->
$(document).ready(function() {
    $('#geocoding_form').bootstrapValidator({
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            
            referenceId: {
				selector: '#referenceId',
				container: '#referenceId_message',
					validators: {
						stringLength: {
							max: 22,
                        	message: 'Your tracking number is incorrect.'
                    	},
						regexp: {
							regexp: /^[a-zA-Z0-9]*$/, //lowercase, upercase, space
							message: 'Tracking number consists of <strong>a-Z</strong> and <strong>0-9</strong> only.'
						}
					}
            }
        }
    });
	
});
</script>
