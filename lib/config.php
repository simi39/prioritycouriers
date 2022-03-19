<?php

	/*if ($_SERVER['HTTP_X_FORWARDED_HOST'] == "mrprinterman.dev.radixweb.net")
		$Url = $_SERVER['HTTP_X_FORWARDED_HOST'];
	else
		$Url = $_SERVER['HTTP_HOST'];*/
	
	define("CONNECTION_TYPE","mysqli");
	//define("DATABASE_USERNAME","onli62"); /tz
	define("DATABASE_USERNAME","pcourier");
	define("DATABASE_PASSWORD","2ZAtka3q1Y7YzY53");
	//define("DATABASE_NAME","onlinecouriers"); /tz
	define("DATABASE_NAME","pcouriers");
	//define("DATABASE_NAME","radixweb_onlinecouriers");
	//define("DATABASE_HOST","207.57.89.99"); /tz
	define("DATABASE_HOST","localhost");
	
	//define("DATABASE_PORT","5432");
	define("DATABASE_PORT","");
	define("SITE_TEMPLATE","default");
	//define("SITE_URL_WITHOUT_PROTOCOL",$Url);
	$con=mysqli_connect(DATABASE_HOST,DATABASE_USERNAME,DATABASE_PASSWORD,DATABASE_NAME);
	/*if (mysqli_ping($con)) {
    printf ("Our connection is ok!\n");
	} else {
	    printf ("Error: %s\n", mysqli_error($con));
	}*/
	//mysqli_close($con);
	
?>
