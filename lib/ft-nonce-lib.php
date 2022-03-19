<?php
/*
 * Name: FT-NONCE-LIB
 * Created By: Full Throttle Development, LLC (http://fullthrottledevelopment.com)
 * Created On: July 2009
 * Last Modified On: August 12, 2009
 * Last Modified By: Glenn Ansley (glenn@fullthrottledevelopment.com)
 * Version: 0.2
 */

/* 
Copyright 2009 Full Throttle Development, LLC

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
DUlwyKYsq#A%WPu^Q7Z8hNB#9KRJi*x&GDylgiU$Z38Sn2nzC@$F*l@RvdSjHlsXlm4ellEaS!@ZgMZ%9xqQuF4$oPSfUVQHk%iP
*/
		
define( 'FT_NONCE_UNIQUE_KEY' , 'bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3' );
define( 'FT_NONCE_EXPIRY' , 300 ); // 300 makes link or form good for 5 minutes from time of generation
define( 'FT_NONCE_DURATION' , 1 );
define( 'FT_NONCE_KEY' , 'hash' );

// This method creates a key / value pair for a url string
function ft_nonce_create_query_string( $action = '' , $user = '' ){
	require_once(DIR_WS_MODEL . "NonceMaster.php");
	require_once(DIR_WS_MODEL . "NonceData.php");
	require_once("bcrypt.php");
	
	$NonceMasterObj = new NonceMaster();
	$NonceMasterObj = $NonceMasterObj->Create();
	$NonceData = new NonceData();
	
	// Commented by Smita 11 Dec 2020 $nonce = (ft_nonce_create( $action , $user ));
	$nonce = hash('sha512', makeRandomString());
	/*
	Commented by Smita 11 Dec 2020
	$bcrypt = new bcrypt(12);
	$hasurl = $bcrypt->genHash($nonce);*/
	$data = $action." ".$user;
	$cnonce = hash('sha512', makeRandomString());
	$hash = hash('sha512', $nonce . $cnonce . $data);
	$hasurl = $hash;
	
	//Get used nonces
	$NonceFieldArr   = array("*");
	$NonceSeaArr = array();
	$NonceSeaArr[] = array('Search_On'=>'url', 'Search_Value'=>$hasurl, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'','Postfix'=>'');
	$DataNonce  = $NonceMasterObj->getNonce($NonceFieldArr, $NonceSeaArr);
	$DataNonce 	= $DataNonce[0];
	$used_nonces = $DataNonce['nonce'];
	/*echo "<pre>";
	print_r($DataNonce);
	echo "</pre>";
	exit();*/
	$generated = time();
	$expires = (int) $generated + FT_NONCE_EXPIRY;
	$NonceData->nonce = $nonce;
	$NonceData->url   = $hasurl;
	$NonceData->stamp = $expires;
	$NonceData->action = $action;
	$NonceData->used = 0;
	$NonceData->user_id = $user;
	
	if(empty($used_nonces))
	{
		$NonceMasterObj->addNonce($NonceData);
	}
	/* Commented by Smita 11 Dec 2020 $hasurl = substr($hasurl,7,60);
	
	return FT_NONCE_KEY."=".$hasurl;*/

	return 'hash'."=".$hasurl;
}

// This method creates an nonce for a form field
function ft_nonce_create_form_input( $action = '' , $user='' ){
	echo "<input type='hidden' name='".FT_NONCE_KEY."' value='".ft_nonce_create( $action . $user )."' />";
}

// This method creates an nonce. It should be called by one of the previous two functions.
function ft_nonce_create( $action = '' , $user='' ){
	return substr( ft_nonce_generate_hash( $action . $user ), -12, 10);
}

// This method validates an nonce
/*
function ft_nonce_is_valid( $nonce , $action = '' , $user='' ){
	if ( substr(ft_nonce_generate_hash( $action . $user ), -12, 10) == $nonce ){
		return true;
	}
	return false;
}
*/
// This method generates the nonce timestamp
function ft_nonce_generate_hash( $action='' , $user='' ){
	$i = ceil( time() / ( FT_NONCE_DURATION / 2 ) );
	$iv = mcrypt_create_iv(16, MCRYPT_DEV_URANDOM);
	return md5( $iv . $i . $action . $user . $action );
}

function ft_create_nonce_one_time($action,$user){
	$time = time();
	$nonce = ft_nonce_create_query_string($action , $user);
	//.base64_encode($time).'-'.($user)."-".(microtime()) 
	return $nonce;
}

function ft_verify_onetime_nonce($hasurl, $_nonce, $time='' , $action = '' , $user=''){
	require_once(DIR_WS_MODEL . "NonceMaster.php");
	require_once(DIR_WS_MODEL . "NonceData.php");
	$NonceMasterObj = new NonceMaster();
	$NonceMasterObj = $NonceMasterObj->Create();
	$NonceData = new NonceData();
	
	//Extract timestamp and nonce part of $_nonce
    $nonce = $_nonce; // Original nonce .
	
	$generated = $time; //Time when generated
	
    $nonce_life = FT_NONCE_EXPIRY; //We want these nonces to have a short lifespan
    $expires = (int) $generated + $nonce_life;
    $time = time(); //Current time
	
	//remove expiry nonce
	$fieldname = 'stamp <';
	$NonceMasterObj->deleteNonce($time,$fieldname);
	
	
	//Verify the nonce part and check that it has not expired !ft_nonce_is_valid( $nonce , $action, $user ) ||
    if($time > $expires)
	{
		return false;
	}
    //  
	 
	//Get used nonces
	$NonceFieldArr   = array("*");
	$NonceSeaArr = array();
	$NonceSeaArr[] = array('Search_On'=>'url', 'Search_Value'=>$hasurl, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'','Postfix'=>'');
	$NonceSeaArr[] = array('Search_On'=>'used', 'Search_Value'=>1, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'','Postfix'=>'');
	$DataNonce  = $NonceMasterObj->getNonce($NonceFieldArr, $NonceSeaArr);
	$DataNonce 	= $DataNonce[0];
	$used_nonces = $DataNonce['nonce'];
	
	
	//Nonce already used.
    if(isset($used_nonces)){
		return false;
	}
	
	
	$NonceData->stamp = $expires;
	$NonceData->used = 1;
	$NonceData->url = $hasurl;
	$Rs = $NonceMasterObj->editNonce($NonceData);
	return true;
}

if ( FT_NONCE_UNIQUE_KEY == '' ){ die( 'You must enter a unique key on line 2 of ft_nonce_lib.php to use this library.'); }
?>