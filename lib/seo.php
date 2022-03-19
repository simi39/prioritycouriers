<?php
function callback($pagecontent) {

  // find all the href thatr are part of the <a> tag
  // this findme is for eway payment page to be displayed in footer
  $findme = "https://www.eway.com.au/developer/payment-code/verified-seal.ashx?img=12&size=7&pid=b546656a-bf0a-46c6-8fd6-65243c66096c";
  $pagecontent = preg_replace_callback("/(<a\s+[^>]*href=['\"]{1})([^'\">]+)([^>]*>)/", 'transform_uri', $pagecontent);
 if(stristr($pagecontent,$findme)=== FALSE) {
	$pagecontent = preg_replace_callback("/(<img\s+[^>]*src=['\"]{1})([^'\">]+)([^>]*>)/", 'setImagePath', $pagecontent);
	$pagecontent = preg_replace_callback("/(<img\s+[^>]*src=['\"]{1})([^'\">]+)([^>]*>)/", 'setImagePath', $pagecontent);
  }
  $pagecontent = preg_replace_callback("/{{(.*?)}}/", 'convert_currency', $pagecontent);
  return $pagecontent;
}
function convert_currency($param) {
	$displayprice = $param[1];
	return currency_format($displayprice);
}
function setImagePath($param){
	global $languages_id, $seourlreads;
	// the url in the hrref should be passed here for reformatting
	// get the complete match and break it into pieces
	// need to allow for a partical href that uses relative addressing
	
	$uriparts = parse_url($param[2]);
	$imgSrcPath = $uriparts['path'];
	
	
	$imgsrcPathArr = explode("/",$imgSrcPath);
	if(strtolower($imgsrcPathArr[0]) == 'images'){
		$imgSrcPath = SITE_URL."/".$imgSrcPath;
	}
	$imgSrcPath = $param[1].$imgSrcPath.$param[3];
	
	//exit();
	return $imgSrcPath;
}

function encode_str($str) {
	  // replace all these special chanracter
	  $str = str_replace( '"', '%22', $str );
	  $str = str_replace( '#', '-', $str );
	  $str = str_replace( '?', '%3F', $str );
	   $str = str_replace( '/', '%2B', $str );
	  $str = str_replace( '&', '%26', $str );
	  $str = str_replace( ' ', '-', $str );	  
	  return $str;
}

function decode_str($str) {
	$str = str_replace( '%22', '"', $str );
	$str = str_replace( '-', ' ', $str );
	$str = str_replace( '%3F', '?', $str );
	$str = str_replace( '+', '/', $str );
	$str = str_replace( '%26', '&', $str );
	$str = str_replace( '-', ' ', $str );
	return $str;
}

function transform_uri($param) {
	  global $languages_id, $seourlreads;
  	  $exclusion_file_ext = array('html', 'htm');
  	  $exclusion_schema = array('javascript', 'mailto');

	  // the url in the hrref should be passed here for reformatting
	  // get the complete match and break it into pieces
	  // need to allow for a partical href that uses relative addressing
	  $uriparts = parse_url($param[2]);
	  
	  $scheme = isset( $uriparts['scheme'] ) ? $uriparts['scheme'] : '';
	  $scheme = strtolower($scheme);
	  // no reformat on SSL addresses
	  if ( $scheme == 'https' ) return $param[0];
	  if ( $scheme != '' && !in_array($scheme, $exclusion_schema)) $scheme .= '://';
	  
	  
	  $site_host=$_SERVER['HTTP_HOST'];
	  //$site_host=SITE_URL;
	  $host = isset( $uriparts['host'] ) ? $uriparts['host'] : ''; 
	  
	  $path = isset( $uriparts['path'] ) ? $uriparts['path'] : '';
	  $query = isset( $uriparts['query'] ) ? $uriparts['query'] : '';
	  $fragment = isset( $uriparts['fragment'] ) ? '#' . $uriparts['fragment'] : '';
	  
	  // get the page name and page path
	  $path_parts = pathinfo( $path );
	  $page_name = $path_parts['basename'];
	  $page_path = $path_parts['dirname'];
	  
	  $pageNameWithQuery = '';
	  $pageNameWithQuery .= $page_name;
	  if(isset($query) && $query != '') {
	  	$pageNameWithQuery .= "?".$query;
	  }
	  
	  $fileextension = strtolower(getimageextension($page_name));
	  
	  if(in_array($fileextension, $exclusion_file_ext)) {
	  	return $param[1] . $scheme . $host . $page_path . $pageNameWithQuery . $fragment . $param[3];
	  }
	  
	  // allow for the pathinfo returning a '.' if there is no dirname
	  if ( substr( $page_path, 0, 1 ) == '.' ) $page_path = '';
	  
	 
	  // the page path may need a trailing /
	  if ( $page_path != '' && substr( $page_path, -1 ) != '/' ) $page_path .= '/';
	  
	  $arr_seo_disable_dir = array('images', 'designer', 'admin');
	  $arr_page_path = explode("/", $page_path);
	  if(!in_array($arr_page_path[1], $arr_seo_disable_dir) && $host==$site_host) {
	  		$page_path = "/";
	  }
	  /*if ( substr( $page_path, 0, 7 ) != '/images' ) {
	  	if ( substr( $page_path, 0, 9 ) != '/designer' )
	  		if ( substr( $page_path, 0, 5 ) != 'admin' )
	  			if($host==$site_host) 
				$page_path = "/";
	  }*/
	  
	  
	  if (in_array($scheme, $exclusion_schema)) $page_path = ':';
	  $pageNameWithQuery = get_seo_link($pageNameWithQuery);
	  
	  return $param[1] . $scheme . $host . $page_path . $pageNameWithQuery . $fragment . $param[3];
}

function get_seo_link($pageNameWithQuery) {
	
	//exit();
	if(SEO_ENABLE == false) {
		return $pageNameWithQuery;
	}
	// Find out what chacter to use if a space needs replacing
	if ( ! defined('CRE_SEO_SPACE_REPLACEMENT') ) {
    	$space_replacement = '-';  // this is done for backward compatiablility, not really the best choice
  	} else {
    	$space_replacement = CRE_SEO_SPACE_REPLACEMENT;
  	}
  	

  	$pageDetails = explode("?",$pageNameWithQuery);
  	
  	$page_name = $pageDetails[0];
  	$query = $pageDetails[1];
  
  // based on the page name, decide if reformating is required
  	switch( $page_name ) {
  		case FILE_INDEX:
  		case FILE_CMS:
	    case FILE_FAQ:
	    case FILE_LATEST_NEWS:
	    case FILE_CONTACT:	
	    case FILE_FORGOT_PASSWORD:
	    case FILE_SIGNUP:
		case FILE_PRIVACY_POLICY:
	    case FILE_TERMS_AND_CONDITONS:
	    //case FILE_FORMS_LINKS:
	    case FILE_SITEMAP:
	    case FILE_TESTIMONIAL:
		//case FILE_GET_QUOTE:
	    case FILE_BOOKING_CANCEL_USER:
	    case FILE_BOOKING_RECORDS:
	    case FILE_SCHEDULED_BOOKING:
	    case FILE_FEEDBACK:	    		
        case FILE_ADDRESS_BOOK_LISTING:	    		
        case FILE_PROFILE:	    		
        case FILE_CHANGE_PASSWORD:	    		
        case FILE_PAYMENT:	    		
        case FILE_BOOKING:	    		
       
        
	   
	    
			// change the page name and reset the path to empty
      		//$page_name = substr( $page_name, 0, strlen($page_name) - 4 ) . '.php';
      		$page_name = substr( $page_name, 0, strlen($page_name) - 4 ) ;
      		//echo "pagename:".$page_name;

      		$path = '';
      		// process the query string
      		if ( $query != '' ) {
        		// repalce the &amp; with & for backward compatiablility
		        $query = str_replace('&amp;', '&', $query);
		        $query_parts = explode( '&', $query );
        		//reset the query and path strings
        		$query = '';
      
		        // prcoess each piece found
		        // Here is the odd part, normally a simple loop thru the parts found would do
		        // however, because the rewrite rules require the parts to be processed in a certain order
		        // The order of processing is set for backward comatiablility
      
        		// find all the pieces to process
        		$query_array = array();
        		foreach ( $query_parts as $q ) {
          			list( $key, $val ) = explode( '=', $q );
          			if ( ! empty( $key ) && ! empty( $val ) ) $query_array[$key] = $val;
        		}
        		

         		if ( array_key_exists( 'templatecat', $query_array ) ) {
          			$val = $query_array['templatecat'];
	          		if ( ! isset( $seourlreads['templatecat'][$val] ) ) {
						$sql_query3 = mysql_query("select TC.category_id, TCD.category_name from site_template_category as TC  Left Join site_template_category_description AS TCD ON TCD.category_id = TC.category_id where TC.category_id = '" . $val . "'");
						$style_name = mysql_fetch_array( $sql_query3 );
	            		$pname = str_replace( ' ', $space_replacement , encode_str($style_name['category_name']) );
	            		$seourlreads['category_id'][$val] = $pname;
	          		} else {
	            		$pname = $seourlreads['category_id'][$val];
	          		}
	          		$path .= 's' . (int)$val . '/' . $pname . '/';
	          		unset( $query_array['templatecat'] );
        		}	
        
        		if ( array_key_exists( 'cid', $query_array ) ) {
          			$val = $query_array['cid'];
          			if ( ! isset( $seourlreads['cid'][$val] ) ) {
						$sql2 = "select PCD.cat_title as catname from product_category_description as PCD where PCD.category_id = '" . $val . "'";
						$sql_query2 = mysql_query($sql2);
						$cat_name = mysql_fetch_array( $sql_query2 );
			            $pname = str_replace( " ", $space_replacement , encode_str($cat_name['catname']) );
			            $seourlreads['cid'][$val] = $pname;
					} else {
			        	$pname = $seourlreads['cid'][$val];
					}
          			$path .=  'c' . (int)$val . '/' . $pname . '/';
          			unset( $query_array['cid'] );
        		}
        		
        		if ( array_key_exists( 'pid', $query_array ) ) {
          			$val = $query_array['pid'];
          			if ( ! isset( $seourlreads['pid'][$val] ) ) {
						$sql_query2 = mysql_query("select p.products_id, pd.products_title as productname from products as p Left Join products_description as pd on pd.products_id = p.products_id  where p.products_id = '" . $val . "'");
						$prod_name = mysql_fetch_array( $sql_query2 );
			            $pname = str_replace( " ", $space_replacement , encode_str($prod_name['productname']) );
			            $seourlreads['pid'][$val] = $pname;
					} else {
			        	$pname = $seourlreads['pid'][$val];
					}
          			$path .=  'p' . (int)$val . '/' . $pname . '/';
          			unset( $query_array['pid'] );
        		}
        
        		if(array_key_exists( 'page', $query_array )) {
		        	$path = '';
		        	//$page_name = encode_str($query_array['page']) .".php";
		        	$page_name = encode_str($query_array['page']);
					//echo "page name:".$query_array['page'];
					unset($query_array['page']);
        		}
       			$page_name = $path.$page_name;
        
        		// any remain query keys goes back into the query string
       			foreach ( $query_array as $key => $val ) {
          			$query .= '&amp;' . $key . '='.$val;
        		}
        		
        		// remove leading &amp; if needed
        		if ( $query != '' ) {
          			if ( substr( $query, 0, 5) == '&amp;' ) $query = substr( $query, 5 );
          			$query = '?' . $query;
        		}
			}
			
			$page_name = $page_name.$query;
			break;
		default:
			$page_name = $pageNameWithQuery;
  	}
	
	//$page_name = str_replace( "_", $space_replacement , $page_name );
	//echo "page name:".$page_name;
	return $page_name;
}

// the seourlreads array provides a limited form of caching to prevent
// addittional queries from being done that have already been done
$seourlreads = array();

if(IS_ADMIN == false) {
	ob_start("callback");
}
?>