<script>
var d = $("#defaultDate").val();
console.log("default date:"+d);

function ChooseLogin(id){
	$("#loginMsgBox").modal('show');
}
/*$('#addressClsModal').click(function(e){
	$('#AddressError').modal('hide');
	e.preventDefault();
	// window.location.reload(false);
});*/

var  thisDate = new Date(d);
var  thisHour = getCurrentTime(thisDate);
//alert("inside international js"+thisHour);
$(function () {

	var d = moment($("#defaultDate").val(),"dddd D MMMM YYYY H:mm:ss A");
	var today = moment(d).format('MM/DD/YYYY');

	var selectedDt = $("#international_collection_date").val();

	if(selectedDt === today) {
		$('#ready_time').timepicker({
            'timeFormat': 'h:i A',
            'defaultTime': thisHour,
            'minTime': thisHour,
    		'maxTime': '2:00 PM'
    	});
		$('#close_time').timepicker({
            'timeFormat': 'h:i A',
			'defaultTime': thisHour,
			//'minTime': thisHour,
    		'maxTime': '5:00 PM'
    	});
	}else{
		$('#ready_time').timepicker({
            'timeFormat': 'h:i A',
            'defaultTime': '7:00 AM',
            'minTime': '7:00 AM',
    		'maxTime': '2:00 PM'
    	});
		$('#close_time').timepicker({
            'timeFormat': 'h:i A',
			'defaultTime': '7:00 AM',
			//'minTime': '7:00 AM',
    		'maxTime': '5:00 PM'
    	});
	}
	/* Below code is to increase time for close time by 3 hours more than ready time */
	var increasedTime = moment($("#ready_time").val(),"hh:mm A").add(3, 'hours');
	var minLimitTime = moment(increasedTime).format('hh:mm A');
	$('#close_time').timepicker('option', 'minTime', minLimitTime);
	
	if($('#close_time').val() == ''){
		$('#close_time').val('5:00 PM');
	}
});
$('#ready_time').on('changeTime', function() {
	$('#li_ready_time').show();

	/* Below code is to increase time for close time by 3 hours more than ready time */
	var increasedTime = moment(this.value,"hh:mm A").add(3, 'hours');
	var minLimitTime = moment(increasedTime).format('hh:mm A');
	//alert(this.value+"increased time:"+moment(increasedTime).format('hh:mm A'));
	$('#close_time').timepicker('option', 'minTime', minLimitTime);
	$("#close_time").val()
	$("#span_time_ready").text($('#ready_time').val());
	/*
		Below code is to apply when ready time is less than close time
		then automatically it will add three hours more 
	*/
	var startTime = moment($("#ready_time").val(), "h:mm A");
	var endTime = moment($("#close_time").val(), "h:mm A");


	var duration = moment.duration(endTime.diff(startTime));
	var hours = parseInt(duration.asHours());
	var minutes = parseInt(duration.asMinutes())-hours*60;
	if(hours<3){
		//alert("min time limit:"+minLimitTime);
		$("#close_time").val(minLimitTime);
	}

});
$('#close_time').on('changeTime', function() {
	//alert("time has changed"+$("#collection_time_to").val()+"--"+$("#collection_time_from").val());
	var diff = moment($("#close_time").val(), ["h:mm A"]).diff(moment($("#ready_time").val(), ["h:mm A"]));
	//alert("differnce"+moment($("#close_time").val(), ["h:mm A"])+moment($("#ready_time").val(), ["h:mm A"]));
	var d = moment.duration(diff);
	var timeDiff = Math.floor(d.asHours()) + moment.utc(diff).format(":mm");
	//alert("parsefloat:"+parseFloat(timeDiff)+"parseInt"+parseInt(timeDiff));
	/*
		Important Note: Below format conversion will only work with jquery From version 2.11.0 parsing hmm, Hmm, hmmss and Hmmss is supported
	*/
	var To =  moment($("#close_time").val(), ["h:mm A"]).format('HH:mm');
	var From =  moment($("#ready_time").val(), 'hh:mm A').format('HH mm');

	var momentTime = moment(From, 'HH:mm');
	var laterMomentTime = moment(To, 'HH:mm');
	//alert(momentTime.isAfter(laterMomentTime));
	/*
	* Below function will only work with moment.js
	*/
	if(momentTime.isAfter(laterMomentTime)){
		$("#cmpTwoTimers").modal('show');
		$("#close_time").focus();
		return false;
	}
	$('#li_close_time').show();
	$("#span_close_time").text($('#close_time').val());

})
$('#cmpTimerYes').click(function (){
	$("#cmpTwoTimers").modal('hide');
});
function ChooseInternationalBooking(){
	var startTime = moment($("#ready_time").val(), "h:mm A");
	var endTime = moment($("#close_time").val(), "h:mm A");
	var duration = moment.duration(endTime.diff(startTime));
	var hours = parseInt(duration.asHours());
	var minutes = parseInt(duration.asMinutes())-hours*60;
	//alert(hours);
	if(hours<3){
		$("#gapOfTimers").modal('show');
		$('#gapofTimerYes').click(function (){
			$("#gapOfTimers").modal('hide');
		});
		return false;
	}else if($("#booking_type_hidden").val() == ""){
		$("#selInterBkMsgBox").modal('show');
		$('#selInterYes').click(function (){
			$("#selInterBkMsgBox").modal('hide');
		});
	}else{

	    $("#selInterBkConfirmBox").modal('show');
	    $("#detailInterMsg").html("You have selected service "+$("#booking_type_hidden").val().charAt(0).toUpperCase()+$("#booking_type_hidden").val().slice(1)+". </br>Your collection date is:"+$('#international_collection_date').val()+"</br>");
	    $('#msgInterBkContentYes').click(function (){ //alert("yes is clicked");
			$("#selInterBkConfirmBox").modal('hide');
			$('#international').submit();
				return true;
		});
		$('#msgInterBkContentNo').click(function (){ //alert("no is clicked");
			$("#selInterBkConfirmBox").modal('hide');
			return false;
		});
	}

	/*
	else{
		$('#international').submit();
	}
	*/
	/**/
};

/****	Button "Book Now" visibility	**/
function showButton(){
  // alert("cheked the button - worked");
  var x = document.getElementsByClassName("showb");
  x[0].style.visibility= 'visible';
}
/****	Hihglight selected service	**/
function riseService(service){
	//alert(service);
    var a = document.getElementById(service);
	//console.log("length:"+a.classList);
	if(service != undefined && service == 'IN')
	{

		a.classList.add("top-price");
		if(document.getElementById('addresses_1') != undefined){
			document.getElementById("addresses_1").childNodes[0].nodeValue="SELECTED";
			document.getElementById("addresses_1").classList.add("no-click");
		}
	}
}

function ChooseInternationalCollectionDate(k,booking_name,courier_id,total_amt){
	$("#international_collection_date").focus();
	$("#international_collection_date_block").show();
	$("#booking_type_hidden").val(booking_name);
	$("#courier_id_hidden").val(courier_id);
	$("#total_amt").val(total_amt);
	/*
	*	Below condition is to keep selected next business date
	*/

	$.ajax({
			type: "POST",
			url: '<?php echo DIR_HTTP_RELATED."international_available_services.php"; ?>',
			data: "selectedDate=" + $('#international_collection_date').val() +"&defaultDate="+$('#defaultDate').val()+"&serviceName="+booking_name,
			success: function(data) {
			   $("#Service").html(data);

			}
	});

	var d = moment($("#defaultDate").val(),"dddd D MMMM YYYY H:mm:ss A");
	var today = moment(d).format('MM/DD/YYYY');
	var collection_date = $('#interstate_collection_date').val();
	var ctt = new Date(d);
	ctt = ctt.getTime();// this is current time for drop down in collection date and collection time
	var ett = new Date(collection_date+" "+"2:00 PM"); /// last cutoff time of the service which is highest take that into consideration
	ett = ett.getTime();
	//alert(ctt+"---"+ett);
	if(ctt > ett){ // if collection time for selected date is greater than cutoff(ett)date
		if($("#tmrrwBusinessDt").val() != ""){
			$("#international_collection_date").val($("#tmrrwBusinessDt").val());
		}else{
			$('#international_collection_date').val($("#firstBusinessDt").val());
		}
		$('#ready_time').val('7:00 AM');
		$('#close_time').val('5:00 PM');
	}else{
		var btnSelected = $("#addresses_"+k).attr("name");
		//alert("btnSelected");
		if(btnSelected !== undefined && btnSelected == 'selectDt'){
			//$('#collection_date option:selected').next().attr('selected','selected');
			/*
			Below condition to check tommorrow condition or next business date
			It will always start at 7:00 Am Starting of the day tommorrow
			*/
			if($("#tmrrwBusinessDt").val() != ""){
				$("#international_collection_date").val($("#tmrrwBusinessDt").val());
			}else{
				$('#international_collection_date').val($("#firstBusinessDt").val());
			}
			alert("inside this else part where to select next day");
			$('#ready_time').val('7:00 AM');
			$('#ready_time').timepicker('option', 'minTime', '7:00 AM');
			$('#ready_time').timepicker('option', 'maxTime', '2:00 PM');
		}else{

			var  thisDate = new Date($("#defaultDate").val());
			var  thisHour = getCurrentTime(thisDate);
			//alert(thisDate+"--"+thisHour+$("#defaultDate").val());
			$('#ready_time').val(thisHour);
			$('#ready_time').timepicker('option', 'minTime', thisHour);

			$('#close_time').val('5:00 PM');
		}
	}

	$('#li_collection_dt').show();
	//alert("called");
	var d = moment($("#international_collection_date").val(), "MM/DD/YYYY");
	var displayDt = moment(d).format('Do MMMM YYYY');
	$("#span_collection_dt").text(displayDt);

	$('#li_ready_time').show();
	$("#span_time_ready").text($('#ready_time').val());

	$('#li_close_time').show();
	$("#span_close_time").text($('#close_time').val());
}

function ChooseInterService(booking_name,courier_id,total_amt){
	$("#international_collection_date_block").show();
	$("#booking_type_hidden").val(booking_name);
	$("#courier_id_hidden").val(courier_id);
	$("#total_amt").val(total_amt);
	//return false;
}


$("#international_collection_date").change(function() {
	var service_name = $('#booking_type_hidden').val();
	$.ajax({
			type: "POST",
			url: '<?php echo DIR_HTTP_RELATED."international_available_services.php"; ?>',
			data: "selectedDate=" + $('#international_collection_date').val() +"&defaultDate="+$('#defaultDate').val()+"&serviceName="+service_name,
			success: function(data) {
			   $("#Service").html(data);

			}
	});
	var d = moment($("#defaultDate").val(),"dddd D MMMM YYYY H:mm:ss A");
	var today = moment(d).format('MM/DD/YYYY');
	if(this.value === today) {
		var  thisDate = new Date($("#defaultDate").val());
		var  thisHour = getCurrentTime(thisDate);
		//(thisDate+"--"+thisHour+$("#defaultDate").val());
		$('#ready_time').val(thisHour);
        $('#ready_time').timepicker('option', 'minTime', thisHour);

		$('#close_time').val('5:00 PM');
		//alert(this.value+"default date:"+today+"this hour:"+thisHour);
	}else{
		$('#ready_time').val('7:00 AM');
		$('#close_time').val('5:00 PM');
	}

	$('#li_collection_dt').show();
	//alert("called");
	/* Below code is to display in booking summary */

	//var d = new Date($("#international_collection_date").val());
	//2019/06/01
	var d = moment($("#international_collection_date").val(), "MM/DD/YYYY");
	var displayDt = moment(d).format('Do MMMM YYYY');
	//console.log("test:"+test+$("#international_collection_date").val()+"displayDt:"+displayDt);
	$("#span_collection_dt").text(displayDt);
	if(service_name  == 'international'){
		//alert("Premium");
		console.log("inside international");
		var service_id = 'IN';
		riseService(service_id);
	} else {}
});
</script>
