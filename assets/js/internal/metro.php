 <script>
var d = $("#defaultDate").val();
var defaultDateset = d;

<!--=== 	Navigate to addresses	===-->
function ChooseOrder(booking_name,courier_id,total_amt)
{

	$("#booking_type_hidden").val(booking_name);
	$("#courier_id_hidden").val(courier_id);
	$("#total_amt").val(total_amt);
	$('#metro').submit();

}
function ChooseLogin(id){
	$("#loginMsgBox").modal('show');
}

var  thisDate = new Date(d);
//alert("before getting hour date:"+thisDate);
var  thisHour = getCurrentTime(thisDate);
/*alert(thisDate +"---"+ thisHour);
const start = moment("2018-12-08 09:00");
const remainder = 15 - (start.minute() % 15);
const dateTime = moment(start)
  .add(remainder, "minutes")
  .format("DD.MM.YYYY, h:mm:ss a");
console.log(dateTime);
*/
//console.log(d+"thisDate:"+thisDate+"thisHour:"+thisHour);
$(function () {
	var d = moment($("#defaultDate").val(),"dddd D MMMM YYYY H:mm:ss A");
	var currentTime = moment(d).format('h:mm A');;
	//alert("currenttime:"+currentTime);
	//var startTime = moment($("#ready_time").val(), "h:mm A");
	var today = moment(d).format('MM/DD/YYYY');
	var selectedDt = $("#collection_date").val();
	if(selectedDt === today) {
		$('#ready_time').timepicker({
            'timeFormat': 'h:i A',
			'defaultTime': thisHour,
            'minTime': thisHour,
    		'maxTime': '5:00 PM'
    	});
	}else{
		$('#ready_time').timepicker({
            'timeFormat': 'h:i A',
			'defaultTime': '7:00 AM',
            'minTime': '7:00 AM',
    		'maxTime': '5:00 PM'
    	});
	}


});

$("#collection_date").change(function() {
	var d = moment($("#defaultDate").val(),"dddd D MMMM YYYY H:mm:ss A");
	var today = moment(d).format('MM/DD/YYYY');

	$("#collection_time_block").show();
	$("#ready_time").focus();
	var booking_name = $("#booking_type_hidden").val();

    //$("#collection_time_from").val('');

    if(this.value === today) {
    	var  thisDate = new Date(d);
		var  thisHour = getCurrentTime(thisDate);
       // var  thisHour = getCurrentTime(new Date());
	   //alert("thisvalue:"+this.value+"today:"+today+"this hour:"+thisHour);
        var time = thisHour;
		var hours = Number(time.match(/^(\d+)/)[1]);
		var minutes = Number(time.match(/:(\d+)/)[1]);
		var AMPM = time.match(/\s(.*)$/)[1];
		if(AMPM == "PM" && hours<12) hours = hours+12;
		if(AMPM == "AM" && hours==12) hours = hours-12;
		var sHours = hours.toString();
		var sMinutes = minutes.toString();
		if(hours<10) sHours = "0" + sHours;
		if(minutes<10) sMinutes = "0" + sMinutes;
		var formateHours = sHours + ":" + sMinutes;

        //thisHour = '11:55 AM';

        var stt = new Date(thisDate);
		stt = stt.getTime();


		var endt = new Date(today+" 2:00 PM");
		endt = endt.getTime();

		//console.log("this hour:"+stt+"end date"+endt+"date:"+today);

        if(stt > endt)
        {
        	//alert("greater than 5:00 pm");
        	$('#ready_time').val(thisHour);
        	$('#ready_time').timepicker('option', 'minTime', thisHour);
        	//console.log("this hour smita:"+thisHour+"test");
        }else{
        	//alert("less than 5:00 pm");
        	$('#ready_time').val(thisHour);
        	$('#ready_time').timepicker('option', 'defaultTime', thisHour);
        	$('#ready_time').timepicker('option', 'minTime', thisHour);
        }

        $('#ready_time').timepicker('option', 'maxTime', '5:00 PM');


    }
    else {
    	//console.log("inside else part");

    	$('#ready_time').val('7:00 AM');
    	//$('#collection_time_from').timepicker('option', 'value', 7);
        $('#ready_time').timepicker('option', 'minTime', '7:00 AM');
        $('#ready_time').timepicker('option', 'maxTime', '5:00 PM');
    }
    console.log("this value"+ this.value + "today:"+today+"collection time:"+$('#ready_time').val());
	//alert("start date:"+$('#start_date').val()+"this value"+ this.value);
	$.ajax({
		type: "POST",
		url: '<?php echo DIR_HTTP_RELATED."metro_available_services.php"; ?>',
		data: "selectedDate=" +this.value+"&defaultDate="+$('#defaultDate').val()+"&collectionTime="+$('#ready_time').val()+"&serviceName="+booking_name,
		success: function(data) {
		   $("#Service").html(data);
		}
	});
	/* Below code is booking summary changes for date collection time ready */
	$('#li_collection_dt').show();
	var d = moment($("#collection_date").val(), "MM/DD/YYYY");
	var displayDt = moment(d).format('Do MMMM YYYY');
	$("#span_collection_dt").text(displayDt);


	//$('#li_collection_dt.collection_dt').text(this.value);
	//console.log("this value:"+$("#span_collection_dt").text());
});


/****	Button "Book Now" visibility	**/
function showButton(){
  // alert("cheked the button - worked");
  var x = document.getElementsByClassName("showb");
  //alert("buttton x:"+x[0].style);
  if(x[0] != undefined){
	x[0].style.visibility= 'visible';
  }

}
/****	Hihglight selected service	**/
function riseService(service){

    var a = document.getElementById(service);

	if(service != undefined && service == 'EX')
	{

		a.classList.add("top-price");
		//alert("inside rise service:"+service+"a"+a);
		document.getElementById('ST').classList.remove("top-price");
		document.getElementById('PR').classList.remove("top-price");
    	document.getElementById("addresses_2").childNodes[0].nodeValue="SELECTED";
		document.getElementById("addresses_2").classList.add("no-click");
		document.getElementById("addresses_1").childNodes[0].nodeValue="SELECT SERVICE";
		document.getElementById("addresses_1").classList.remove("no-click");
		document.getElementById("addresses_3").childNodes[0].nodeValue="SELECT SERVICE";
		document.getElementById("addresses_3").classList.remove("no-click");
	}
	if(service != undefined && service == 'ST')
	{
		a.classList.add("top-price");
		document.getElementById('EX').classList.remove("top-price");
		document.getElementById('PR').classList.remove("top-price");
		document.getElementById("addresses_1").childNodes[0].nodeValue="SELECTED";
		document.getElementById("addresses_1").classList.add("no-click");
		document.getElementById("addresses_2").childNodes[0].nodeValue="SELECT SERVICE";
		document.getElementById("addresses_2").classList.remove("no-click");
		document.getElementById("addresses_3").childNodes[0].nodeValue="SELECT SERVICE";
		document.getElementById("addresses_3").classList.remove("no-click");
	}
	if(service != undefined && service == 'PR')
	{
		a.classList.add("top-price");
		document.getElementById('EX').classList.remove("top-price");
		document.getElementById('ST').classList.remove("top-price");
		document.getElementById("addresses_3").childNodes[0].nodeValue="SELECTED";
		document.getElementById("addresses_3").classList.add("no-click");
		document.getElementById("addresses_1").childNodes[0].nodeValue="SELECT SERVICE";
		document.getElementById("addresses_1").classList.remove("no-click");
		document.getElementById("addresses_2").childNodes[0].nodeValue="SELECT SERVICE";
		document.getElementById("addresses_2").classList.remove("no-click");
	}
}
function ChooseCollectionTime(k){
	$("#collection_time_block").show();
}
function ChooseCollectionDate(k,booking_name,courier_id,total_amt,service_cutoff_time){
	$("#collection_date").focus();
	$("#collection_date_block").show();
	//$('#collection_date option:selected').next().attr('selected','selected');
	$("#booking_type_hidden").val(booking_name);
	$("#courier_id_hidden").val(courier_id);
	$("#total_amt").val(total_amt);
	$("#service_cutoff_time").val(service_cutoff_time);
	var collection_time = $("#ready_time").val();
	var collection_dt = $('#collection_date').val();
	var ctt = new Date(collection_dt+" "+collection_time);
	ctt = ctt.getTime();// this is current time for drop down in collection date and collection time


	var ett = new Date(collection_dt+" "+" 2:00 PM"); /// last cutoff time of the service which is highest take that into consideration
	ett = ett.getTime();
	if(ctt > ett){ // if collection time for selected date is greater than cutoff(ett)date
		//alert("if it is greater than cutoff time");
		//$('#collection_date option:selected').next().attr('selected','selected');
		/*
			Below condition to check tommorrow condition or next business date
		*/
		if($("#tmrrwBusinessDt").val() != ""){
			$("#collection_date").val($("#tmrrwBusinessDt").val());
		}else{
			$('#collection_date').val($("#firstBusinessDt").val());
		}
		//$("#collection_date").val($("#collection_date option:eq(2)").val());
		$('#ready_time').val('7:00 AM');
		$('#ready_time').timepicker('option', 'minTime', '7:00 AM');
		$('#ready_time').timepicker('option', 'maxTime', '5:00 PM');
		//alert($('#ready_time').val());


	}else{
		var btnSelected = $("#addresses_"+k).attr("name");

		if(btnSelected !== undefined && btnSelected == 'selectDt'){
			//$('#collection_date option:selected').next().attr('selected','selected');
			/*
			Below condition to check tommorrow condition or next business date
			It will always start at 7:00 Am Starting of the day tommorrow
			*/
			if($("#tmrrwBusinessDt").val() != ""){
				$("#collection_date").val($("#tmrrwBusinessDt").val());
			}else{
				$('#collection_date').val($("#firstBusinessDt").val());
			}
			$('#ready_time').val('7:00 AM');
			$('#ready_time').timepicker('option', 'minTime', '7:00 AM');
			$('#ready_time').timepicker('option', 'maxTime', '5:00 PM');
		}else{
			/*
				Below condition is considered for Current date and time.
				Time will start whateven zone current time is there.
			*/
			$('#ready_time').timepicker('option', 'minTime', collection_time);
			$('#ready_time').timepicker('option', 'maxTime', '5:00 PM');
		}

	}
	console.log("from date collection function"+"this val"+this.value+"dt:"+$('#collection_date').val()+"coll time:"+$('#ready_time').val()+"def date:"+$('#defaultDate').val());
	$.ajax({
			type: "POST",
			url: '<?php echo DIR_HTTP_RELATED."metro_available_services.php"; ?>',
			data: "selectedDate=" + $('#collection_date').val() +"&defaultDate="+$('#defaultDate').val()+"&collectionTime="+$('#ready_time').val()+"&serviceName="+booking_name,
			success: function(data) {
			   $("#Service").html(data);

			}
		});
	/* Below code is booking summary changes for date collection time ready */
	$('#li_collection_dt').show();
	var d = moment($("#collection_date").val(), "MM/DD/YYYY");
	//alert("service name:"+booking_name);
	var displayDt = moment(d).format('Do MMMM YYYY');
	//alert("display date"+displayDt);
	//console.log(booking_name.charAt(0).toUpperCase()+booking_name.slice(1));
	var servicename = booking_name.charAt(0).toUpperCase()+booking_name.slice(1);
	$("#span_service_name").text(servicename);
	$("#span_collection_dt").text(displayDt);
	$('#li_ready_time').show();
	$("#span_time_ready").text($('#ready_time').val());
	//$('span_collection_dt').text($('#collection_date').val());


}
function ChooseService(k,booking_name,courier_id,total_amt,service_cutoff_time)
{
	$("#collection_date_block").show();
	$("#collection_time_block").show();
	$("#ready_time").focus();
	$("#booking_type_hidden").val(booking_name);
	$("#courier_id_hidden").val(courier_id);
	$("#total_amt").val(total_amt);
	$("#service_cutoff_time").val(service_cutoff_time);
	var servicename = booking_name.charAt(0).toUpperCase()+booking_name.slice(1);
	$("#span_service_name").text(servicename);

	var collection_dt = $('#collection_date').val();
	var collection_time = $("#ready_time").val();
	var ctt = new Date(collection_dt+" "+collection_time);
	ctt = ctt.getTime();// this is current time for drop down in collection date and collection time
	var ett = new Date(collection_dt+" "+" 2:00 PM"); /// last cutoff time of the service which is highest take that into consideration
	ett = ett.getTime();
	//alert("ctt"+ctt+"ett"+ett);
	if(ctt > ett){ // if collection time for selected date is greater than cutoff(ett)date
		/*
			Below condition to check tommorrow condition or next business date
		*/
		//alert("inside if condition");
		if($("#tmrrwBusinessDt").val() != ""){
			$("#collection_date").val($("#tmrrwBusinessDt").val());
		}else{
			$('#collection_date').val($("#firstBusinessDt").val());
		}
		$('#ready_time').val('7:00 AM');
		$('#ready_time').timepicker('option', 'minTime', '7:00 AM');
		$('#ready_time').timepicker('option', 'maxTime', '5:00 PM');
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
				$("#collection_date").val($("#tmrrwBusinessDt").val());
			}else{
				$('#collection_date').val($("#firstBusinessDt").val());
			}
			$('#ready_time').val('7:00 AM');
			$('#ready_time').timepicker('option', 'minTime', '7:00 AM');
			$('#ready_time').timepicker('option', 'maxTime', '5:00 PM');
		}else{
			/*
				Below condition is considered for Current date and time.
				Time will start whateven zone current time is there.
			*/
			//alert("inside else part");
			$('#ready_time').timepicker('option', 'minTime', collection_time);
			$('#ready_time').timepicker('option', 'maxTime', '5:00 PM');
		}

	}


}
function ChooseBooking(){

	var collection_time = $("#ready_time").val();
	var collection_dt = $('#collection_date').val();
	var ctt = new Date(collection_dt+" "+collection_time);
	ctt = ctt.getTime();// this is current time for drop down in collection date and collection time


	var ett = new Date(collection_dt+" "+$("#service_cutoff_time").val()); /// last cutoff time of the service which is highest take that into consideration
	ett = ett.getTime();
	//alert("collection dt box:"+collection_dt+" "+collection_time+"service time"+collection_dt+" "+$("#service_cutoff_time").val());
	/*if(ctt > ett){
		alert("Please choose another service to proceed further.");
		return false;
	}

	$('#metro').submit();*/

	if($("#booking_type_hidden").val() == ""){
		$("#selBkMsgBox").modal('show');
		$('#yes').click(function (){
			$("#selBkMsgBox").modal('hide');
		});

	}else if(ctt > ett){
		alert("Please choose another service to proceed further.");
		return false;
	}else{

	    $("#selBkConfirmBox").modal('show');
	    $("#detailMsg").html("You have selected service "+$("#booking_type_hidden").val().charAt(0).toUpperCase()+$("#booking_type_hidden").val().slice(1)+". </br>Your collection date is:"+$('#collection_date').val()+"</br>Your collection time is:"+$("#ready_time").val());
	    $('#msgBkContentYes').click(function (){
			$("#selBkConfirmBox").modal('hide');
			$('#metro').submit();
			return true;
		});
		$('#msgBkContentNo').click(function (){
			$("#selBkConfirmBox").modal('hide');
			return false;
		});

	}

}
//changeTime
$('#ready_time').on('changeTime', function() {
	//alert("on change of time");
    var collection_time = $("#ready_time").val();
	var booking_name = $("#booking_type_hidden").val();
	$("#ready_time").val(this.value);

	console.log("ready time:"+collection_time+$('#collection_date').val()+$('#defaultDate').val()+this.value);
    //alert();
	$.ajax({
		type: "POST",
		url: '<?php echo DIR_HTTP_RELATED."metro_available_services.php"; ?>',
		data: "selectedDate=" + $('#collection_date').val() +"&defaultDate="+$('#defaultDate').val()+"&collectionTime="+this.value+"&serviceName="+booking_name,
		success: function(data) {
		   $("#Service").html(data);
		}
	});
	$('#li_ready_time').show();
	$("#span_time_ready").text($('#ready_time').val());
	var service_name = $('#booking_type_hidden').val();
	switch (service_name) {
		case 'express':
			//alert("Express");
			var service_id = "EX";
			riseService(service_id);
			//console.log("inside express");
			break;
		case 'standard':
			//alert("Standard");
			var service_id = "ST";
			riseService(service_id);
		 	break;
		case 'priority':
			//alert("Priority");
			var service_id = "PR";
			riseService(service_id);
		 	break;
	}
//	if(service_name  == 'express'){
		//alert("Express");
//		var service_id = "EX";
//		riseService(service_id);
//		showButton();
	//}
})
/** Return to Booking if coming from Booking **/
/*$('#BackButton').click(function (){ //alert("no is clicked");
	window.location.href = 'booking.php';
});*/
</script>
