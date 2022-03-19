<!-- ****	For Google map	****	-->

<script src="http://maps.google.com/maps/api/js?sensor=true"></script>

<script type="text/javascript">
$(document).ready(function(){
	$('#geocoding_form').submit(function(e){ 
		showMap(e,trim($('#referenceId').val()));
	});
	
});
function showMap(e,referenceId){
	e = (typeof e === "undefined") ? "" : e;	
	if(e){
		e.preventDefault();
	}
	alert("tracking");
	//referenceId = '466000008563';
	$('#mapeff').modal("show");
	$.ajax({ 
	  type: 'POST',
	  cache: false,
	  url: 'related/<?php echo FILE_TRACKING; ?>',
	  data: {'referenceId':referenceId},
	  dataType: 'json',
	  success: function(data){  
	   
	   //alert(data);
	   var path = [];
	   var b = [];
	   var test = "";
	   var nomarks = [];
	   if(data != null){
	   $.each(data.points, function(index, response) {
			var latLngArr = response.latLng;
			path.push( response.latLng );
			test = latLngArr.toString().split(",");
			latlngb = new google.maps.LatLng(test[0],test[1]);
			b.push(latlngb);
			nomarks.push(response.locName);
			var titleLoc = 'none';
			if(response.locName)
			{
				var titleLoc = response.locName;
			}
			
			if(index == 1){
				map = new GMaps({
					div: '#map1',
					//zoom: 4,
					lat: test[0],
					lng: test[1],
					resize: function(){
						var center = map.getCenter();
						map.setCenter(center.lat(), center.lng());
					}
					//mapTypeId: google.maps.MapTypeId.HYBRID,
				});
				
			}
			 var center = map.getCenter();
		   //alert(response.status);
			map.addMarker({
				lat: test[0],
				lng: test[1],
				title: ""+titleLoc+"",
				icon:"http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld="+index+"|FF0000|000000",
				infoWindow: {
				  content: ""+titleLoc+""
				}
			});
			
	   });
	   
		
		  
		  var strstatus = [];
		  var strremark = [];
		  var strdatetime = [];
		  var strloc ="";
		  var strloconce = "";
		  var strInfo = "";
		  var strMobileInfo = "";
		  var tabId = "";
		  strInfo += "<thead><tr class='info'><th>Location</th><th>Date</th><th>Time</th><th>Event Id</th></tr></thead><tbody>";
		  strMobileInfo += "<thead><tr class='info'><th>Location</th><th>Date/Time</th><th>Event Id</th></tr></thead><tbody>";
		  var k = 1;
		  var srno ;
		 $.each(data.info, function(index, response) {
			
			var allinfo = response.toString().split(",");
			
			
			if(strloconce != allinfo[4])
			{
				var loc = allinfo[4];
				
				if(k < (nomarks.length+1))
				{
					srno = k+".";
					
				}
				
				if(allinfo[5] != "")
				{
					strloc = loc+","+allinfo[5];
					
				}else{
					strloc = loc;
					srno = "";
				}
				
				tabId = "id="+index+" class="+"d"+index+"";
				
			k++;	
				
			}else{
				strloc = " ";
				srno = "";
			}
			
			strdatetime = allinfo[1].split(" ");
			 strInfo += "<tr "+tabId+"><td>"+srno+" "+strloc+"</td><td>"+strdatetime[0]+"</td><td>"+strdatetime[1]+" "+strdatetime[2]+"</td><td>"+allinfo[0]+"</td></tr>";
			strMobileInfo += "<tr "+tabId+"><td>"+strloc+"</td><td>"+strdatetime[0]+" "+strdatetime[1]+" "+strdatetime[2]+"</td><td>"+allinfo[0]+"</td></tr>";
			//<td>"+strdatetime[0]+"</td><td>"+strdatetime[1]+" "+strdatetime[2]+"</td>
			strstatus.push(allinfo[2]);
			strremark.push(allinfo[3]);
			
			strloconce = allinfo[4];
			
		 });
		 strInfo +="</tbody>";
		 strMobileInfo += "</tbody>";
		 $("#tblDesktop").html(strInfo);
		 $("#tblMobile").html(strMobileInfo);
		 $("#status").html(strstatus[strstatus.length - 1]);
		 $('#sign').css("display","none");
		 if(strstatus[strstatus.length - 1] == 'Delivered')
		 { 
			$('#sign').css("display","block"); 
			$("#status").removeClass("my_yellow");
			$("#status").addClass("my_red");
		 }
		 $("#remark").html(strremark[strremark.length - 1]);
		 if(strstatus[strstatus.length - 1] != 'Delivered')
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
			 //map.getCenter();
			 map.fitLatLngBounds(b);
			 map.fitZoom();
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
   $('.search-btn').addClass('icon-search');
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
						regexp: {
							regexp: /^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=\S+$).{,20}$/, //lowercase, upercase, space
							message: 'Tracking number consists of <strong>a-Z</strong> and <strong>0-9</strong> only.'
						}
					}
            }
        }
    });
	
});
</script>