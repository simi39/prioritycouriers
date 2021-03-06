<?php
defined('ABSPATH') or die("Cheating........Uh!!");
/**
 * File contains the functions necessary for Social Sharing functionality
 */

/**
 * Render sharing interface html.
 */
function the_champ_prepare_sharing_html($postUrl, $sharingType = 'horizontal', $displayCount, $totalShares){
	global $theChampSharingOptions, $post;
	$postUrl = (isset($theChampSharingOptions['use_shortlink']) && function_exists('wp_get_shortlink')) ? wp_get_shortlink() : $postUrl;
	if(!isset($theChampSharingOptions['horizontal_sharing_size'])){
		$theChampSharingOptions['horizontal_sharing_size'] = 30;
	}
	if(!isset($theChampSharingOptions['horizontal_sharing_shape'])){
		$theChampSharingOptions['horizontal_sharing_shape'] = 'round';
	}
	if(!isset($theChampSharingOptions['vertical_sharing_size'])){
		$theChampSharingOptions['vertical_sharing_size'] = 35;
	}
	if(!isset($theChampSharingOptions['vertical_sharing_shape'])){
		$theChampSharingOptions['vertical_sharing_shape'] = 'square';
	}
	$output = apply_filters('the_champ_sharing_interface_filter', '', $postUrl, $sharingType, $theChampSharingOptions, $post, $displayCount, $totalShares);
	if($output != ''){
		return $output;
	}
	$html = '';
	$sharingMeta = '';
	if(!is_front_page() || (is_front_page() && 'page' == get_option('show_on_front'))){
		$sharingMeta = get_post_meta($post->ID, '_the_champ_meta', true);
	}
	if(isset($theChampSharingOptions[$sharingType.'_re_providers'])){
		$html = '<ul '. ($sharingType == 'horizontal' && isset($theChampSharingOptions['hor_sharing_alignment']) && $theChampSharingOptions['hor_sharing_alignment'] == "center" ? "style='list-style: none;position: relative;left: 50%;'" : "") .' class="the_champ_sharing_ul">';
		$style = 'style="width:' . $theChampSharingOptions[$sharingType . '_sharing_size'] . 'px;height:' . $theChampSharingOptions[$sharingType . '_sharing_size'] . 'px;';
		$counterContainerInitHtml = '<span class="the_champ_share_count';
		$counterContainerEndHtml = '</span>';
		$innerStyle = 'display:block;';
		$liClass = 'theChampSharingRound';
		if($theChampSharingOptions[$sharingType . '_sharing_shape'] == 'round'){
			$style .= 'border-radius:999px;';
			$innerStyle .= 'border-radius:999px;';
		}
		if($sharingType == 'vertical' && $theChampSharingOptions[$sharingType . '_sharing_shape'] == 'square'){
			$style .= 'margin:0;';
			$counterContainerInitHtml = '<ss class="the_champ_square_count';
			$counterContainerEndHtml = '</ss>';
			$liClass = '';
		}
		$style .= '"';
		$liItems = '';
		foreach($theChampSharingOptions[$sharingType.'_re_providers'] as $provider){
			$liItems .= '<li class="' . ($liClass != '' ? $liClass : 'theChamp' . ucfirst(str_replace(' ', '', $provider)) .'Background theChamp' . ucfirst(str_replace(' ', '', $provider)) .'SquareBackground') . '">';
			if($displayCount){
				$startingCount = isset($sharingMeta[$provider . '_' . $sharingType . '_count']) && $sharingMeta[$provider . '_' . $sharingType . '_count'] != '' ? true : false;
				$liItems .= $counterContainerInitHtml . ' the_champ_'.$provider.'_count" '. ($startingCount ? 'ss_st_count="'. $sharingMeta[$provider . '_' . $sharingType . '_count'] .'"' : '') .' >&nbsp;' . $counterContainerEndHtml;
			}
			if($provider == 'print'){
				$liItems .= '<i ' .$style. ' alt="Print" Title="Print" class="theChampSharing theChamp'. ucfirst($provider) .'Background" onclick=\'window.print()\'><ss style="display:block" class="theChampSharingSvg theChamp'. ucfirst($provider) .'Svg"></ss></i>';
			}elseif($provider == 'email'){
				$liItems .= '<i ' .$style. ' alt="Email" Title="Email" class="theChampSharing theChamp'. ucfirst($provider) .'Background" onclick="window.location.href = \'mailto:?subject=\' + decodeURIComponent(\''. urlencode($post->post_title) .'\') + \'&body=\' + decodeURIComponent(\''.$postUrl.'\')"><ss style="display:block" class="theChampSharingSvg theChamp'. ucfirst($provider) .'Svg"></ss></i>';
			}else{
				if($provider == 'facebook'){
					$sharingUrl = 'https://www.facebook.com/sharer/sharer.php?u=' . $postUrl;
				}elseif($provider == 'twitter'){
					$sharingUrl = 'http://twitter.com/intent/tweet?'. (isset($theChampSharingOptions['twitter_username']) && $theChampSharingOptions['twitter_username'] != '' ? 'via=' . $theChampSharingOptions['twitter_username'] . '&' : '') . 'text='.urlencode($post->post_title).'&url=' . $postUrl;
				}elseif($provider == 'linkedin'){
					$sharingUrl = 'http://www.linkedin.com/shareArticle?mini=true&url=' . $postUrl . '&title=' . urlencode($post->post_title);
				}elseif($provider == 'google'){
					$sharingUrl = 'https://plus.google.com/share?url=' . $postUrl;
				}elseif($provider == 'yahoo'){
					$sharingUrl = 'http://bookmarks.yahoo.com/toolbar/SaveBM/?u=' . $postUrl . '&t=' . urlencode($post->post_title);
				}elseif($provider == 'reddit'){
					$sharingUrl = 'http://reddit.com/submit?url='.$postUrl.'&title=' . urlencode($post->post_title);
				}elseif($provider == 'digg'){
					$sharingUrl = 'http://digg.com/submit?url='.$postUrl.'&title=' . urlencode($post->post_title);
				}elseif($provider == 'delicious'){
					$sharingUrl = 'http://del.icio.us/post?url='.$postUrl.'&title=' . urlencode($post->post_title);
				}elseif($provider == 'stumbleupon'){
					$sharingUrl = 'http://www.stumbleupon.com/submit?url='.$postUrl.'&title=' . urlencode($post->post_title);
				}elseif($provider == 'float it'){
					$sharingUrl = 'http://www.designfloat.com/submit.php?url='.$postUrl.'&title=' . urlencode($post->post_title);
				}elseif($provider == 'tumblr'){
					$sharingUrl = 'http://www.tumblr.com/share?v=3&u='.urlencode($postUrl).'&t=' . urlencode($post->post_title) . '&s=';
				}elseif($provider == 'vkontakte'){
					$sharingUrl = 'http://vkontakte.ru/share.php?&url='.urlencode($postUrl);
				}elseif($provider == 'xing'){											
					$sharingUrl = 'https://www.xing-share.com/social_plugins/share?url='. urlencode($postUrl) .'&wtmc=XING&sc_p=xing-share';
				}elseif($provider == 'whatsapp'){											
					$sharingUrl = 'whatsapp://send?text=' . urlencode($post->post_title . ' ' . $postUrl);
				}elseif($provider == 'yummly'){											
					$sharingUrl = 'http://www.yummly.com/urb/verify?url=' . urlencode($postUrl) . '&title=' . urlencode($post->post_title);
				}elseif($provider == 'buffer'){											
					$sharingUrl = 'https://buffer.com/add?url=' . urlencode($postUrl) . '&title=' . urlencode($post->post_title);
				}elseif($provider == 'pinterest'){
					$sharingUrl = "javascript:void((function(){var e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','//assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)})());";
				}
				$liItems .= '<i ' .$style. ' alt="'.($provider == 'google' ? 'Google Plus' : ucfirst($provider)).'" Title="'.($provider == 'google' ? 'Google Plus' : ucfirst($provider)).'" class="theChampSharing theChamp'. ucfirst( str_replace(' ', '', $provider) ) .'Background" ';
				if($provider == 'pinterest'){
					$liItems .= 'onclick="'.$sharingUrl.'"><ss style="display:block" class="theChampSharingSvg theChamp'. ucfirst($provider) .'Svg"></ss></i>';
				}elseif($provider == 'whatsapp'){
					$liItems .= '><a href="'.$sharingUrl.'"><ss style="display:block" class="theChampSharingSvg theChamp'. ucfirst($provider) .'Svg"></ss></a></i>';
				}else{
					$liItems .= 'onclick=\' theChampPopup("'.$sharingUrl.'")\'><ss style="'. $innerStyle .'" class="theChampSharingSvg theChamp'. ucfirst( str_replace(' ', '', $provider) ) .'Svg"></ss></i>';
				}
			}
			$liItems .= '</li>';
		}
		if(isset($theChampSharingOptions[$sharingType . '_more'])){
			$liItems .= '<li class="' . ($liClass != '' ? $liClass : 'theChampMoreBackground') . '">';
			if($displayCount){
				$liItems .= $counterContainerInitHtml . '">&nbsp;' . $counterContainerEndHtml;
			}
			$liItems .= '<i ' .$style. ' title="More" alt="More" class="theChampSharing theChampMoreBackground" onclick="theChampMoreSharingPopup(this, \''.$postUrl.'\', \''.urlencode($post->post_title).'\')" ><ss style="display:block" class="theChampSharingSvg theChampMoreSvg"></ss></i></li>';
		}
		
		$totalSharesHtml = '';
		if($totalShares){
			$totalSharesHtml = '<li class="' . $liClass . '">';
			if($displayCount){
				$totalSharesHtml .= $counterContainerInitHtml . '">&nbsp;' . $counterContainerEndHtml;
			}
			if($sharingType == 'horizontal'){
				$addStyle = ';margin-left:9px !important;';
			}else{
				$addStyle = ';margin-bottom:9px !important;';
			}
			$addStyle .= '"';
			$style = str_replace(';"', $addStyle, $style);
			$totalSharesHtml .= '<i ' . $style . ' title="Total Shares" alt="Total Shares" class="theChampSharing theChampTCBackground"></i></li>';
		}

		if($sharingType == 'vertical'){
			$html .= $totalSharesHtml . $liItems;
		}else{
			$html .= $liItems . $totalSharesHtml;
		}

		$html .= '</ul><div style="clear:both"></div>';
	}
	return $html;
}

/**
 * Render counter interface html.
 */
function the_champ_prepare_counter_html($postUrl, $sharingType = 'horizontal', $shortUrl){
	global $theChampCounterOptions, $post;
	$shortUrl = (isset($theChampCounterOptions['use_shortlink']) && function_exists('wp_get_shortlink')) ? wp_get_shortlink() : $shortUrl;
	$output = apply_filters('the_champ_counter_interface_filter', '', $postUrl, $shortUrl, $sharingType, $theChampCounterOptions, $post);
	if($output != ''){
		return $output;
	}
	$html = '<div id="fb-root"></div>';
	if(isset($theChampCounterOptions[$sharingType.'_providers']) && is_array($theChampCounterOptions[$sharingType.'_providers'])){
		$html = '<ul '. ($sharingType == 'horizontal' && isset($theChampCounterOptions['hor_counter_alignment']) && $theChampCounterOptions['hor_counter_alignment'] == "center" ? "style='list-style: none;position: relative;left: 50%;'" : "") .' class="the_champ_sharing_ul">';
		$language = isset($theChampCounterOptions['language']) && $theChampCounterOptions['language'] != '' ? $theChampCounterOptions['language'] : '';
		foreach($theChampCounterOptions[$sharingType.'_providers'] as $provider){
			if($provider == 'facebook_like'){
				$html .= '<li class="the_champ_facebook_like"><div class="fb-like" data-href="'. $postUrl .'" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div></li>';
			}elseif($provider == 'facebook_recommend'){
				$html .= '<li class="the_champ_facebook_recommend"><div class="fb-like" data-href="'. $postUrl .'" data-layout="button_count" data-action="recommend" data-show-faces="false" data-share="false"></div></li>';
			}elseif($provider == 'twitter_tweet'){
				$html .= '<li class="the_champ_twitter_tweet" heateor-ss-data-href="'. $postUrl .'"><a href="https://twitter.com/share" class="twitter-share-button" data-url="'. $shortUrl .'" data-counturl="'. $postUrl .'" data-text="'. html_entity_decode($post->post_title, ENT_COMPAT, 'UTF-8') .'" data-via="'. (isset($theChampCounterOptions['twitter_username']) && $theChampCounterOptions['twitter_username'] != '' ? $theChampCounterOptions['twitter_username'] : '') .'" data-lang="'. $language .'" >Tweet</a><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?"http":"https";if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document, "script", "twitter-wjs");</script></li>';
			}elseif($provider == 'linkedin_share'){
				$html .= '<li class="the_champ_linkedin_share"><script src="//platform.linkedin.com/in.js" type="text/javascript">lang: '. $language .'</script><script type="IN/Share" data-url="' . $postUrl . '" data-counter="right"></script></li>';
			}elseif($provider == 'google_plusone'){
				$html .= '<li class="the_champ_google_plusone"><script type="text/javascript" src="https://apis.google.com/js/platform.js">{lang: "'. $language .'"}</script><div class="g-plusone" data-size="medium" data-href="'. $postUrl .'" data-callback="heateorSsmiGpCallback"></div></li>';
			}elseif($provider == 'pinterest_pin_it'){
				$html .= '<li class="the_champ_pinterest_pin"><a data-pin-lang="'. $language .'" href="//www.pinterest.com/pin/create/button/?url='. $postUrl .'" data-pin-do="buttonPin" data-pin-config="beside"><img src="//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_gray_20.png" /></a><script type="text/javascript" async src="//assets.pinterest.com/js/pinit.js"></script></li>';
			}elseif($provider == 'googleplus_share'){
				$html .= '<li class="the_champ_gp_share"><script type="text/javascript" src="https://apis.google.com/js/platform.js">{lang: "'. $language .'"}</script><div class="g-plus" data-action="share" data-annotation="bubble" data-href="'. $postUrl .'"></div></li>';
			}elseif($provider == 'reddit'){
				$html .= '<li class="the_champ_reddit"><script type="text/javascript" src="http://www.reddit.com/static/button/button1.js"></script></li>';
			}elseif($provider == 'yummly'){
				$html .= '<li class="the_champ_yummly"><a href="//yummly.com" class="YUMMLY-YUM-BUTTON">Yum</a><script src="https://www.yummly.com/js/widget.js?general"></script></li>';
			}elseif($provider == 'buffer'){
				$html .= '<li class="the_champ_buffer"><a href="http://bufferapp.com/add" class="buffer-add-button" data-text="' . html_entity_decode($post->post_title, ENT_COMPAT, 'UTF-8') . '" data-url="' . $postUrl . '" data-count="horizontal" data-via="'. (isset($theChampCounterOptions['buffer_username']) && $theChampCounterOptions['buffer_username'] != '' ? $theChampCounterOptions['buffer_username'] : '') .'" ></a><script type="text/javascript" src="https://d389zggrogs7qo.cloudfront.net/js/button.js"></script></li>';
			}elseif($provider == 'xing'){
				$html .= '<li class="the_champ_xing"><div data-type="XING/Share" data-counter="right" data-url="'. $postUrl .'" data-lang="'. $language .'"></div><script>(function (d, s) {var x = d.createElement(s), s = d.getElementsByTagName(s)[0]; x.src = "https://www.xing-share.com/js/external/share.js"; s.parentNode.insertBefore(x, s); })(document, "script");</script></li>';
			}elseif($provider == 'stumbleupon_badge'){
				$html .= '<li class="the_champ_stumble"><su:badge layout="1" location="'. $postUrl .'"></su:badge><script type="text/javascript">(function() {var li = document.createElement(\'script\'); li.type = \'text/javascript\'; li.async = true;li.src = (\'https:\' == document.location.protocol ? \'https:\' : \'http:\') + \'//platform.stumbleupon.com/1/widgets.js\';var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(li, s);})();</script></li>';
			}
		}
		$html .= '</ul><div style="clear:both"></div>';
	}
	return $html;
}

function the_champ_generate_sharing_bitly_url($url, $postId = 0){
    global $theChampSharingOptions;
    $bitlyUrl = get_post_meta($postId, '_the_champ_ss_bitly_url', true);
    if($bitlyUrl){
    	return $bitlyUrl;
    }else{
	    //generate the URL
	    $bitly = 'http://api.bit.ly/v3/shorten?format=txt&login='. $theChampSharingOptions['bitly_username'] .'&apiKey='. $theChampSharingOptions['bitly_key'] .'&longUrl='.urlencode($url);
		$response = wp_remote_get( $bitly,  array( 'timeout' => 15 ) );
		if( ! is_wp_error( $response ) && isset( $response['response']['code'] ) && 200 === $response['response']['code'] ){
			$shortUrl = trim(wp_remote_retrieve_body( $response ));
			update_post_meta($postId, '_the_champ_ss_bitly_url', $shortUrl);
			return $shortUrl;
		}
	}
	return false;
}

function the_champ_generate_counter_bitly_url($url, $postId = 0){
    global $theChampCounterOptions;
    $bitlyUrl = get_post_meta($postId, '_the_champ_ss_bitly_url', true);
    if($bitlyUrl){
    	return $bitlyUrl;
    }else{
	    //generate the URL
	    $bitly = 'http://api.bit.ly/v3/shorten?format=txt&login='. $theChampCounterOptions['bitly_username'] .'&apiKey='. $theChampCounterOptions['bitly_key'] .'&longUrl='.urlencode($url);
		$response = wp_remote_get( $bitly,  array( 'timeout' => 15 ) );
		if( ! is_wp_error( $response ) && isset( $response['response']['code'] ) && 200 === $response['response']['code'] ){
			$shortUrl = trim(wp_remote_retrieve_body( $response ));
			update_post_meta($postId, '_the_champ_ss_bitly_url', $shortUrl);
			return $shortUrl;
		}
	}
	return false;
}

$theChampVerticalHomeCount = 0;
$theChampVerticalExcerptCount = 0;
$theChampVerticalCounterHomeCount = 0;
$theChampVerticalCounterExcerptCount = 0;
/**
 * Enable sharing interface at selected areas.
 */
function the_champ_render_sharing($content){
	global $post;
	// hook to bypass sharing
	$disable = apply_filters('the_champ_bypass_sharing', $post, $content);
	// if $disable value is 1, return content without sharing interface
	if($disable === 1){ return $content; }
	$sharingMeta = get_post_meta($post->ID, '_the_champ_meta', true);
	global $theChampSharingOptions, $theChampCounterOptions;
	
	$sharingBpActivity = false;
	$counterBpActivity = false;
	if(current_filter() == 'bp_activity_entry_meta'){
		if(isset($theChampSharingOptions['bp_activity'])){
			$sharingBpActivity = true;
		}
		if(isset($theChampCounterOptions['bp_activity'])){
			$counterBpActivity = true;
		}
	}
	
	$post_types = get_post_types( array( 'public' => true ), 'names', 'and' );
	$post_types = array_diff( $post_types, array( 'post', 'page' ) );
	
	if(isset($theChampCounterOptions['enable'])){
		//counter interface
		if(isset($theChampCounterOptions['hor_enable']) && !(isset($sharingMeta['counter']) && $sharingMeta['counter'] == 1 && (!is_front_page() || (is_front_page() && 'page' == get_option('show_on_front'))) )){
			$postId = $post -> ID;
			if($counterBpActivity){
				$counterPostUrl = bp_get_activity_thread_permalink();
			}elseif(isset($theChampCounterOptions['horizontal_target_url'])){
				if($theChampCounterOptions['horizontal_target_url'] == 'default'){
					$counterPostUrl = get_permalink($post->ID);
				}elseif($theChampCounterOptions['horizontal_target_url'] == 'home'){
					$counterPostUrl = site_url();
					$postId = 0;
				}elseif($theChampCounterOptions['horizontal_target_url'] == 'custom'){
					$counterPostUrl = isset($theChampCounterOptions['horizontal_target_url_custom']) ? trim($theChampCounterOptions['horizontal_target_url_custom']) : get_permalink($post->ID);
					$postId = 0;
				}
			}else{
				$counterPostUrl = get_permalink($post->ID);
			}
			
			$counterUrl = $counterPostUrl;
			if(isset($theChampCounterOptions['use_shortlinks']) && function_exists('wp_get_shortlink')){
				$counterUrl = wp_get_shortlink();
				// if bit.ly integration enabled, generate bit.ly short url
			}elseif(isset($theChampCounterOptions['bitly_enable']) && isset($theChampCounterOptions['bitly_username']) && isset($theChampCounterOptions['bitly_username']) && $theChampCounterOptions['bitly_username'] != '' && isset($theChampCounterOptions['bitly_key']) && $theChampCounterOptions['bitly_key'] != ''){
				$shortUrl = the_champ_generate_counter_bitly_url($counterPostUrl, $postId);
				if($shortUrl){
					$counterUrl = $shortUrl;
				}
			}
			
			$sharingDiv = the_champ_prepare_counter_html($counterPostUrl, 'horizontal', $counterUrl);
			$sharingContainerStyle = '';
			$sharingTitleStyle = 'style="font-weight:bold"';
			if(isset($theChampCounterOptions['hor_counter_alignment'])){
				if($theChampCounterOptions['hor_counter_alignment'] == 'right'){
					$sharingContainerStyle = 'style="float: right"';
				}elseif($theChampCounterOptions['hor_counter_alignment'] == 'center'){
					$sharingContainerStyle = 'style="float: right;position: relative;left: -50%;text-align: left;"';
					$sharingTitleStyle = 'style="font-weight: bold;list-style: none;position: relative;left: 50%;"';
				}
			}
			$horizontalDiv = "<div style='clear: both'></div><div ". $sharingContainerStyle ." class='the_champ_counter_container the_champ_horizontal_counter'><div ". $sharingTitleStyle .">".ucfirst($theChampCounterOptions['title'])."</div>".$sharingDiv."</div><div style='clear: both'></div>";
			if($counterBpActivity){
				echo $horizontalDiv;
			}
			// show horizontal counter		
			if((isset( $theChampCounterOptions['home']) && is_front_page()) || (isset( $theChampCounterOptions['category']) && is_category()) || (isset( $theChampCounterOptions['archive']) && is_archive()) || ( isset( $theChampCounterOptions['post'] ) && is_single() && isset($post -> post_type) && $post -> post_type == 'post' ) || ( isset( $theChampCounterOptions['page'] ) && is_page() && isset($post -> post_type) && $post -> post_type == 'page' ) || ( isset( $theChampCounterOptions['excerpt'] ) && is_front_page() && current_filter() == 'get_the_excerpt' ) || ( isset( $theChampCounterOptions['bb_reply'] ) && current_filter() == 'bbp_get_reply_content' ) || ( isset( $theChampCounterOptions['bb_forum'] ) && (isset( $theChampCounterOptions['top'] ) && current_filter() == 'bbp_template_before_single_forum' || isset( $theChampCounterOptions['bottom'] ) && current_filter() == 'bbp_template_after_single_forum' )) || ( isset( $theChampCounterOptions['bb_topic'] ) && (isset( $theChampCounterOptions['top'] ) && in_array(current_filter(), array('bbp_template_before_single_topic', 'bbp_template_before_lead_topic')) || isset( $theChampCounterOptions['bottom'] ) && in_array(current_filter(), array('bbp_template_after_single_topic', 'bbp_template_after_lead_topic')) )) || (isset( $theChampCounterOptions['woocom_shop'] ) && current_filter() == 'woocommerce_after_shop_loop_item') || (isset( $theChampCounterOptions['woocom_product'] ) && current_filter() == 'woocommerce_share') || (isset( $theChampCounterOptions['woocom_thankyou'] ) && current_filter() == 'woocommerce_thankyou') ) {	
				if( in_array( current_filter(), array('bbp_template_before_single_topic', 'bbp_template_before_lead_topic', 'bbp_template_before_single_forum', 'bbp_template_after_single_topic', 'bbp_template_after_lead_topic', 'bbp_template_after_single_forum','woocommerce_after_shop_loop_item', 'woocommerce_share', 'woocommerce_thankyou') ) ){
					echo '<div style="clear:both"></div>'.$horizontalDiv.'<div style="clear:both"></div>';
				}else{
					if(isset($theChampCounterOptions['top'] ) && isset($theChampCounterOptions['bottom'])){
						$content = $horizontalDiv.'<br/>'.$content.'<br/>'.$horizontalDiv;
					}else{
						if(isset($theChampCounterOptions['top'])){
							$content = $horizontalDiv.$content;
						}elseif(isset($theChampCounterOptions['bottom'])){
							$content = $content.$horizontalDiv;
						}
					}
				}
			} elseif( count( $post_types ) ) {
				foreach ( $post_types as $post_type ) {
					if( isset( $theChampCounterOptions[$post_type] ) && ( is_single() || is_page() ) && isset($post -> post_type) && $post -> post_type == $post_type ) {
						if(isset($theChampCounterOptions['top'] ) && isset($theChampCounterOptions['bottom'])){
							$content = $horizontalDiv.'<br/>'.$content.'<br/>'.$horizontalDiv;
						}else{
							if(isset($theChampCounterOptions['top'])){
								$content = $horizontalDiv.$content;
							}elseif(isset($theChampCounterOptions['bottom'])){
								$content = $content.$horizontalDiv;
							}
						}
					}
				}
			}
		}
		if(isset($theChampCounterOptions['vertical_enable']) && !(isset($sharingMeta['vertical_counter']) && $sharingMeta['vertical_counter'] == 1 && (!is_front_page() || (is_front_page() && 'page' == get_option('show_on_front'))) )){
			$postId = $post -> ID;
			if(isset($theChampCounterOptions['vertical_target_url'])){
				if($theChampCounterOptions['vertical_target_url'] == 'default'){
					$counterPostUrl = get_permalink($post->ID);
				}elseif($theChampCounterOptions['vertical_target_url'] == 'home'){
					$counterPostUrl = site_url();
					$postId = 0;
				}elseif($theChampCounterOptions['vertical_target_url'] == 'custom'){
					$counterPostUrl = isset($theChampCounterOptions['vertical_target_url_custom']) ? trim($theChampCounterOptions['vertical_target_url_custom']) : get_permalink($post->ID);
					$postId = 0;
				}
			}else{
				$counterPostUrl = get_permalink($post->ID);
			}
			
			$counterUrl = $counterPostUrl;
			if(isset($theChampCounterOptions['use_shortlinks']) && function_exists('wp_get_shortlink')){
				$counterUrl = wp_get_shortlink();
				// if bit.ly integration enabled, generate bit.ly short url
			}elseif(isset($theChampCounterOptions['bitly_enable']) && isset($theChampCounterOptions['bitly_username']) && isset($theChampCounterOptions['bitly_username']) && $theChampCounterOptions['bitly_username'] != '' && isset($theChampCounterOptions['bitly_key']) && $theChampCounterOptions['bitly_key'] != ''){
				$shortUrl = the_champ_generate_counter_bitly_url($counterPostUrl, $postId);
				if($shortUrl){
					$counterUrl = $shortUrl;
				}
			}
			
			$sharingDiv = the_champ_prepare_counter_html($counterPostUrl, 'vertical', $counterUrl);
			$offset = (isset($theChampCounterOptions['alignment']) && $theChampCounterOptions['alignment'] != '' && isset($theChampCounterOptions[$theChampCounterOptions['alignment'].'_offset']) ? $theChampCounterOptions['alignment'].': '. ( $theChampCounterOptions[$theChampCounterOptions['alignment'].'_offset'] == '' ? 0 : $theChampCounterOptions[$theChampCounterOptions['alignment'].'_offset'] ) .'px;' : '').(isset($theChampCounterOptions['top_offset']) ? 'top: '. ( $theChampCounterOptions['top_offset'] == '' ? 0 : $theChampCounterOptions['top_offset'] ) .'px;' : '');
			$verticalDiv = "<div class='the_champ_counter_container the_champ_vertical_counter" . ( isset( $theChampCounterOptions['hide_mobile_likeb'] ) ? ' the_champ_hide_sharing' : '' ) . "' style='". $offset . (isset($theChampCounterOptions['vertical_bg']) && $theChampCounterOptions['vertical_bg'] != '' ? 'background-color: '.$theChampCounterOptions['vertical_bg'] . ';' : '-webkit-box-shadow:none;-moz-box-shadow:none;box-shadow:none;') . "'>".$sharingDiv."</div>";
			// show vertical counter
			if((isset( $theChampCounterOptions['vertical_home']) && is_front_page()) || (isset( $theChampCounterOptions['vertical_category']) && is_category()) || (isset( $theChampCounterOptions['vertical_archive']) && is_archive()) || ( isset( $theChampCounterOptions['vertical_post'] ) && is_single() && isset($post -> post_type) && $post -> post_type == 'post' ) || ( isset( $theChampCounterOptions['vertical_page'] ) && is_page() && isset($post -> post_type) && $post -> post_type == 'page' ) || ( isset( $theChampCounterOptions['vertical_excerpt'] ) && is_front_page() && current_filter() == 'get_the_excerpt' ) || ( isset( $theChampCounterOptions['vertical_bb_forum'] ) && current_filter() == 'bbp_template_before_single_forum') || ( isset( $theChampCounterOptions['vertical_bb_topic'] ) && in_array(current_filter(), array('bbp_template_before_single_topic', 'bbp_template_before_lead_topic'))) ){
				if( in_array( current_filter(), array('bbp_template_before_single_topic', 'bbp_template_before_lead_topic', 'bbp_template_before_single_forum') ) ){
					echo $verticalDiv;
				}else{
					if(is_front_page()){
						global $theChampVerticalCounterHomeCount, $theChampVerticalCounterExcerptCount;
						if(current_filter() == 'the_content'){
							$var = 'theChampVerticalCounterHomeCount';
						}elseif(current_filter() == 'get_the_excerpt'){
							$var = 'theChampVerticalCounterExcerptCount';
						}
						if($$var == 0){
							if(isset($theChampCounterOptions['vertical_target_url']) && $theChampCounterOptions['vertical_target_url'] == 'default'){
								$counterPostUrl = site_url();
								$counterUrl = $counterPostUrl;
								if(isset($theChampCounterOptions['use_shortlinks']) && function_exists('wp_get_shortlink')){
									$counterUrl = wp_get_shortlink();
									// if bit.ly integration enabled, generate bit.ly short url
								}elseif(isset($theChampCounterOptions['bitly_enable']) && isset($theChampCounterOptions['bitly_username']) && isset($theChampCounterOptions['bitly_username']) && $theChampCounterOptions['bitly_username'] != '' && isset($theChampCounterOptions['bitly_key']) && $theChampCounterOptions['bitly_key'] != ''){
									$shortUrl = the_champ_generate_counter_bitly_url($counterPostUrl, 0);
									if($shortUrl){
										$counterUrl = $shortUrl;
									}
								}
								
								$sharingDiv = the_champ_prepare_counter_html($counterPostUrl, 'vertical', $counterUrl);
								$verticalDiv = "<div class='the_champ_counter_container the_champ_vertical_counter" . ( isset( $theChampCounterOptions['hide_mobile_likeb'] ) ? ' the_champ_hide_sharing' : '' ) . "' style='". $offset . (isset($theChampCounterOptions['vertical_bg']) && $theChampCounterOptions['vertical_bg'] != '' ? 'background-color: '.$theChampCounterOptions['vertical_bg'] . ';' : '-webkit-box-shadow:none;-moz-box-shadow:none;box-shadow:none;') . "'>".$sharingDiv."</div>";
							}
							$content = $content.$verticalDiv;
							$$var++;
						}
					}else{
						$content = $content.$verticalDiv;
					}
				}
			} elseif( count( $post_types ) ) {
				foreach ( $post_types as $post_type ) {
					if( isset( $theChampCounterOptions['vertical_' . $post_type] ) && ( is_single() || is_page() ) && isset($post -> post_type) && $post -> post_type == $post_type ) {
						$content = $content . $verticalDiv;
					}
				}
			}
		}
	}

	if(isset($theChampSharingOptions['enable'])){
		// sharing interface
		if(isset($theChampSharingOptions['hor_enable']) && !(isset($sharingMeta['sharing']) && $sharingMeta['sharing'] == 1 && (!is_front_page() || (is_front_page() && 'page' == get_option('show_on_front'))) )){
			$postId = $post -> ID;
			if($sharingBpActivity){
				$postUrl = bp_get_activity_thread_permalink();
				$postId = 0;
			}elseif(isset($theChampSharingOptions['horizontal_target_url'])){
				if($theChampSharingOptions['horizontal_target_url'] == 'default'){
					$postUrl = get_permalink($post->ID);
				}elseif($theChampSharingOptions['horizontal_target_url'] == 'home'){
					$postUrl = site_url();
					$postId = 0;
				}elseif($theChampSharingOptions['horizontal_target_url'] == 'custom'){
					$postUrl = isset($theChampSharingOptions['horizontal_target_url_custom']) ? trim($theChampSharingOptions['horizontal_target_url_custom']) : get_permalink($post->ID);
					$postId = 0;
				}
			}else{
				$postUrl = get_permalink($post->ID);
			}
			
			$sharingUrl = $postUrl;
			if(isset($theChampSharingOptions['use_shortlinks']) && function_exists('wp_get_shortlink')){
				$sharingUrl = wp_get_shortlink();
				// if bit.ly integration enabled, generate bit.ly short url
			}elseif(isset($theChampSharingOptions['bitly_enable']) && isset($theChampSharingOptions['bitly_username']) && $theChampSharingOptions['bitly_username'] != '' && isset($theChampSharingOptions['bitly_key']) && $theChampSharingOptions['bitly_key'] != ''){
				$shortUrl = the_champ_generate_sharing_bitly_url($postUrl, $postId);
				if($shortUrl){
					$sharingUrl = $shortUrl;
				}
			}
			
			$sharingDiv = the_champ_prepare_sharing_html($sharingUrl, 'horizontal', isset($theChampSharingOptions['horizontal_counts']), isset($theChampSharingOptions['horizontal_total_shares']));
			$sharingContainerStyle = '';
			$sharingTitleStyle = 'style="font-weight:bold"';
			if(isset($theChampSharingOptions['hor_sharing_alignment'])){
				if($theChampSharingOptions['hor_sharing_alignment'] == 'right'){
					$sharingContainerStyle = 'style="float: right"';
				}elseif($theChampSharingOptions['hor_sharing_alignment'] == 'center'){
					$sharingContainerStyle = 'style="float: right;position: relative;left: -50%;text-align: left;"';
					$sharingTitleStyle = 'style="font-weight: bold;list-style: none;position: relative;left: 50%;"';
				}
			}
			$horizontalDiv = "<div style='clear: both'></div><div ". $sharingContainerStyle ." class='the_champ_sharing_container the_champ_horizontal_sharing' super-socializer-data-href='".$postUrl."'><div ". $sharingTitleStyle ." >".ucfirst($theChampSharingOptions['title'])."</div>".$sharingDiv."</div><div style='clear: both'></div>";
			if($sharingBpActivity){
				echo $horizontalDiv;
			}
			// show horizontal sharing
			if((isset( $theChampSharingOptions['home']) && is_front_page()) || (isset( $theChampSharingOptions['category']) && is_category()) || (isset( $theChampSharingOptions['archive']) && is_archive()) || ( isset( $theChampSharingOptions['post'] ) && is_single() && isset($post -> post_type) && $post -> post_type == 'post' ) || ( isset( $theChampSharingOptions['page'] ) && is_page() && isset($post -> post_type) && $post -> post_type == 'page' ) || ( isset( $theChampSharingOptions['excerpt'] ) && is_front_page() && current_filter() == 'get_the_excerpt' ) || ( isset( $theChampSharingOptions['bb_reply'] ) && current_filter() == 'bbp_get_reply_content' ) || ( isset( $theChampSharingOptions['bb_forum'] ) && (isset( $theChampSharingOptions['top'] ) && current_filter() == 'bbp_template_before_single_forum' || isset( $theChampSharingOptions['bottom'] ) && current_filter() == 'bbp_template_after_single_forum' )) || ( isset( $theChampSharingOptions['bb_topic'] ) && (isset( $theChampSharingOptions['top'] ) && in_array(current_filter(), array('bbp_template_before_single_topic', 'bbp_template_before_lead_topic')) || isset( $theChampSharingOptions['bottom'] ) && in_array(current_filter(), array('bbp_template_after_single_topic', 'bbp_template_after_lead_topic')) )) || (isset( $theChampSharingOptions['woocom_shop'] ) && current_filter() == 'woocommerce_after_shop_loop_item') || (isset( $theChampSharingOptions['woocom_product'] ) && current_filter() == 'woocommerce_share') || (isset( $theChampSharingOptions['woocom_thankyou'] ) && current_filter() == 'woocommerce_thankyou') ) {
				if( in_array( current_filter(), array('bbp_template_before_single_topic', 'bbp_template_before_lead_topic', 'bbp_template_before_single_forum', 'bbp_template_after_single_topic', 'bbp_template_after_lead_topic', 'bbp_template_after_single_forum', 'woocommerce_after_shop_loop_item', 'woocommerce_share', 'woocommerce_thankyou') ) ){
					echo '<div style="clear:both"></div>'.$horizontalDiv.'<div style="clear:both"></div>';
				}else{
					if(isset($theChampSharingOptions['top'] ) && isset($theChampSharingOptions['bottom'])){
						$content = $horizontalDiv.'<br/>'.$content.'<br/>'.$horizontalDiv;
					}else{
						if(isset($theChampSharingOptions['top'])){
							$content = $horizontalDiv.$content;
						}elseif(isset($theChampSharingOptions['bottom'])){
							$content = $content.$horizontalDiv;
						}
					}
				}
			} elseif( count( $post_types ) ) {
				foreach ( $post_types as $post_type ) {
					if( isset( $theChampSharingOptions[$post_type] ) && ( is_single() || is_page() ) && isset($post -> post_type) && $post -> post_type == $post_type ) {
						if(isset($theChampSharingOptions['top'] ) && isset($theChampSharingOptions['bottom'])){
							$content = $horizontalDiv.'<br/>'.$content.'<br/>'.$horizontalDiv;
						}else{
							if(isset($theChampSharingOptions['top'])){
								$content = $horizontalDiv.$content;
							}elseif(isset($theChampSharingOptions['bottom'])){
								$content = $content.$horizontalDiv;
							}
						}
					}
				}
			}
		}
		if(isset($theChampSharingOptions['vertical_enable']) && !(isset($sharingMeta['vertical_sharing']) && $sharingMeta['vertical_sharing'] == 1 && (!is_front_page() || (is_front_page() && 'page' == get_option('show_on_front'))) )){
			$postId = $post -> ID;
			if(isset($theChampSharingOptions['vertical_target_url'])){
				if($theChampSharingOptions['vertical_target_url'] == 'default'){
					$postUrl = get_permalink($post->ID);
				}elseif($theChampSharingOptions['vertical_target_url'] == 'home'){
					$postUrl = site_url();
					$postId = 0;
				}elseif($theChampSharingOptions['vertical_target_url'] == 'custom'){
					$postUrl = isset($theChampSharingOptions['vertical_target_url_custom']) ? trim($theChampSharingOptions['vertical_target_url_custom']) : get_permalink($post->ID);
					$postId = 0;
				}
			}else{
				$postUrl = get_permalink($post->ID);
			}
			
			$sharingUrl = $postUrl;
			if(isset($theChampSharingOptions['use_shortlinks']) && function_exists('wp_get_shortlink')){
				$sharingUrl = wp_get_shortlink();
				// if bit.ly integration enabled, generate bit.ly short url
			}elseif(isset($theChampSharingOptions['bitly_enable']) && isset($theChampSharingOptions['bitly_username']) && isset($theChampSharingOptions['bitly_username']) && $theChampSharingOptions['bitly_username'] != '' && isset($theChampSharingOptions['bitly_key']) && $theChampSharingOptions['bitly_key'] != ''){
				$shortUrl = the_champ_generate_sharing_bitly_url($postUrl, $postId);
				if($shortUrl){
					$sharingUrl = $shortUrl;
				}
			}
			
			$sharingDiv = the_champ_prepare_sharing_html($sharingUrl, 'vertical', isset($theChampSharingOptions['vertical_counts']), isset($theChampSharingOptions['vertical_total_shares']));
			$offset = (isset($theChampSharingOptions['alignment']) && $theChampSharingOptions['alignment'] != '' && isset($theChampSharingOptions[$theChampSharingOptions['alignment'].'_offset']) && $theChampSharingOptions[$theChampSharingOptions['alignment'].'_offset'] != '' ? $theChampSharingOptions['alignment'].': '.$theChampSharingOptions[$theChampSharingOptions['alignment'].'_offset'].'px;' : '').(isset($theChampSharingOptions['top_offset']) && $theChampSharingOptions['top_offset'] != '' ? 'top: '.$theChampSharingOptions['top_offset'].'px;' : '');
			$verticalDiv = "<div class='the_champ_sharing_container the_champ_vertical_sharing" . ( isset( $theChampSharingOptions['hide_mobile_sharing'] ) ? ' the_champ_hide_sharing' : '' ) . ( isset( $theChampSharingOptions['bottom_mobile_sharing'] ) ? ' the_champ_bottom_sharing' : '' ) . "' style='width:" . ($theChampSharingOptions['vertical_sharing_size'] + 4) . "px;" . $offset . (isset($theChampSharingOptions['vertical_bg']) && $theChampSharingOptions['vertical_bg'] != '' ? 'background-color: '.$theChampSharingOptions['vertical_bg'] : '-webkit-box-shadow:none;-moz-box-shadow:none;box-shadow:none;') . "' super-socializer-data-href='".$postUrl."'>".$sharingDiv."</div>";
			// show vertical sharing
			if((isset( $theChampSharingOptions['vertical_home']) && is_front_page()) || (isset( $theChampSharingOptions['vertical_category']) && is_category()) || (isset( $theChampSharingOptions['vertical_archive']) && is_archive()) || ( isset( $theChampSharingOptions['vertical_post'] ) && is_single() && isset($post -> post_type) && $post -> post_type == 'post' ) || ( isset( $theChampSharingOptions['vertical_page'] ) && is_page() && isset($post -> post_type) && $post -> post_type == 'page' ) || ( isset( $theChampSharingOptions['vertical_excerpt'] ) && is_front_page() && current_filter() == 'get_the_excerpt' ) || ( isset( $theChampSharingOptions['vertical_bb_forum'] ) && current_filter() == 'bbp_template_before_single_forum') || ( isset( $theChampSharingOptions['vertical_bb_topic'] ) && in_array(current_filter(), array('bbp_template_before_single_topic', 'bbp_template_before_lead_topic')))) {
				if( in_array( current_filter(), array('bbp_template_before_single_topic', 'bbp_template_before_lead_topic', 'bbp_template_before_single_forum') ) ){
					echo $verticalDiv;
				}else{
					if(is_front_page()){
						global $theChampVerticalHomeCount, $theChampVerticalExcerptCount;
						if(current_filter() == 'the_content'){
							$var = 'theChampVerticalHomeCount';
						}elseif(current_filter() == 'get_the_excerpt'){
							$var = 'theChampVerticalExcerptCount';
						}
						if($$var == 0){
							if(isset($theChampSharingOptions['vertical_target_url']) && $theChampSharingOptions['vertical_target_url'] == 'default'){
								$postUrl = site_url();
								$sharingUrl = $postUrl;
								if(isset($theChampSharingOptions['use_shortlinks']) && function_exists('wp_get_shortlink')){
									$sharingUrl = wp_get_shortlink();
									// if bit.ly integration enabled, generate bit.ly short url
								}elseif(isset($theChampSharingOptions['bitly_enable']) && isset($theChampSharingOptions['bitly_username']) && isset($theChampSharingOptions['bitly_username']) && $theChampSharingOptions['bitly_username'] != '' && isset($theChampSharingOptions['bitly_key']) && $theChampSharingOptions['bitly_key'] != ''){
									$shortUrl = the_champ_generate_sharing_bitly_url($postUrl, 0);
									if($shortUrl){
										$sharingUrl = $shortUrl;
									}
								}
								
								$sharingDiv = the_champ_prepare_sharing_html($sharingUrl, 'vertical', isset($theChampSharingOptions['vertical_counts']), isset($theChampSharingOptions['vertical_total_shares']));
								$verticalDiv = "<div class='the_champ_sharing_container the_champ_vertical_sharing" . ( isset( $theChampSharingOptions['hide_mobile_sharing'] ) ? ' the_champ_hide_sharing' : '' ) . ( isset( $theChampSharingOptions['bottom_mobile_sharing'] ) ? ' the_champ_bottom_sharing' : '' ) . "' style='width:" . ($theChampSharingOptions['vertical_sharing_size'] + 4) . "px;" . $offset . (isset($theChampSharingOptions['vertical_bg']) && $theChampSharingOptions['vertical_bg'] != '' ? 'background-color: '.$theChampSharingOptions['vertical_bg'] : '-webkit-box-shadow:none;-moz-box-shadow:none;box-shadow:none;') . "' super-socializer-data-href='".$postUrl."'>".$sharingDiv."</div>";
							}
							$content = $content.$verticalDiv;
							$$var++;
						}
					}else{
						$content = $content.$verticalDiv;
					}
				}
			} elseif( count( $post_types ) ) {
				foreach ( $post_types as $post_type ) {
					if( isset( $theChampSharingOptions['vertical_' . $post_type] ) && ( is_single() || is_page() ) && isset($post -> post_type) && $post -> post_type == $post_type ) {
						$content = $content . $verticalDiv;
					}
				}
			}
		}
	}
	return $content;
}
add_filter('the_content', 'the_champ_render_sharing');
add_filter('get_the_excerpt', 'the_champ_render_sharing');
if(isset($theChampSharingOptions['bp_activity']) || isset($theChampCounterOptions['bp_activity'])){
	add_action('bp_activity_entry_meta', 'the_champ_render_sharing', 999);
}
add_filter('bbp_get_reply_content', 'the_champ_render_sharing');
add_filter( 'bbp_template_before_single_forum', 'the_champ_render_sharing' );
add_filter( 'bbp_template_before_single_topic', 'the_champ_render_sharing' );
add_filter( 'bbp_template_before_lead_topic', 'the_champ_render_sharing' );
add_filter( 'bbp_template_after_single_forum', 'the_champ_render_sharing' );
add_filter( 'bbp_template_after_single_topic', 'the_champ_render_sharing' );
add_filter( 'bbp_template_after_lead_topic', 'the_champ_render_sharing' );
// Sharing at WooCommerce pages
if(isset($theChampSharingOptions['woocom_shop']) || isset($theChampCounterOptions['woocom_shop'])){
	add_action('woocommerce_after_shop_loop_item', 'the_champ_render_sharing');
}
if(isset($theChampSharingOptions['woocom_product']) || isset($theChampCounterOptions['woocom_product'])){
	add_action('woocommerce_share', 'the_champ_render_sharing');
}
if(isset($theChampSharingOptions['woocom_thankyou']) || isset($theChampCounterOptions['woocom_thankyou'])){
	add_action('woocommerce_thankyou', 'the_champ_render_sharing');
}

/**
 * Get sharing count for providers
 */
function the_champ_sharing_count(){
	if(isset($_GET['urls']) && count($_GET['urls']) > 0){
		$targetUrls = array_unique($_GET['urls']);
		foreach($targetUrls as $k => $v){
			$targetUrls[$k] = esc_attr($v);
		}
	}else{
		the_champ_ajax_response(array('status' => 0, 'message' => __('Invalid request')));
	}
	global $theChampSharingOptions;
	$horizontalSharingNetworks = isset($theChampSharingOptions['providers']) ? $theChampSharingOptions['providers'] : array();
	$verticalSharingNetworks = isset($theChampSharingOptions['vertical_providers']) ? $theChampSharingOptions['vertical_providers'] : array();
	$sharingNetworks = array_unique(array_merge($horizontalSharingNetworks, $verticalSharingNetworks));
	if(count($sharingNetworks) == 0){
		the_champ_ajax_response(array('status' => 0, 'message' => __('Providers not selected')));
	}
	$responseData = array();
	foreach($targetUrls as $targetUrl){
		foreach($sharingNetworks as $provider){
			switch($provider){
				case 'facebook':
					$url = 'http://api.facebook.com/restserver.php?method=links.getStats&urls=' . $targetUrl . '&format=json&callback=';
					break;
				case 'twitter':
					$url = 'http://urls.api.twitter.com/1/urls/count.json?url=' . $targetUrl;
					break;
				case 'linkedin':
					$url = 'http://www.linkedin.com/countserv/count/share?url='. $targetUrl .'&format=json';
					break;
				case 'reddit':
					$url = 'http://www.reddit.com/api/info.json?url='. $targetUrl;
					break;
				case 'delicious':
					$url = 'http://feeds.delicious.com/v2/json/urlinfo/data?url='. $targetUrl;
					break;
				case 'pinterest':
					$url = 'http://api.pinterest.com/v1/urls/count.json?callback=theChamp&url='. $targetUrl;
					break;
				case 'buffer':
					$url = 'https://api.bufferapp.com/1/links/shares.json?url='. $targetUrl;
					break;
				case 'stumbleupon':
					$url = 'http://www.stumbleupon.com/services/1.01/badge.getinfo?url='. $targetUrl;
					break;
				case 'google':
					$url = 'http://share.yandex.ru/gpp.xml?url='. $targetUrl;
					break;
				case 'vkontakte':
					$url = 'https://vk.com/share.php?act=count&url='. $targetUrl;
					break;
				default:
					$url = '';
			}
			if($url == '') { continue; }
			$response = wp_remote_get( $url,  array( 'timeout' => 15 ) );
			if( ! is_wp_error( $response ) && isset( $response['response']['code'] ) && 200 === $response['response']['code'] ){
				$body = wp_remote_retrieve_body( $response );
				if($provider == 'pinterest'){
					$body = str_replace(array('theChamp(', ')'), '', $body);
				}
				if(!in_array($provider, array('google', 'vkontakte'))){
					$body = json_decode($body);
				}
				switch($provider){
					case 'facebook':
						if(!empty($body[0] -> total_count)){
							$responseData[$targetUrl]['facebook'] = $body[0] -> total_count;
						}else{
							$responseData[$targetUrl]['facebook'] = 0;
						}
						break;
					case 'twitter':
						if(!empty($body -> count)){
							$responseData[$targetUrl]['twitter'] = $body -> count;
						}else{
							$responseData[$targetUrl]['twitter'] = 0;
						}
						break;
					case 'linkedin':
						if(!empty($body -> count)){
							$responseData[$targetUrl]['linkedin'] = $body -> count;
						}else{
							$responseData[$targetUrl]['linkedin'] = 0;
						}
						break;
					case 'reddit':
						$responseData[$targetUrl]['reddit'] = 0;
						if(!empty($body -> data -> children)){
							$children = $body -> data -> children;
							if(!empty($children[0] -> data -> score)){
								$responseData[$targetUrl]['reddit'] = $children[0] -> data -> score;
							}
						}
						break;
					case 'delicious':
						if(!empty($body[0] -> total_posts)){
							$responseData[$targetUrl]['delicious'] = $body[0] -> total_posts;
						}else{
							$responseData[$targetUrl]['delicious'] = 0;
						}
						break;
					case 'pinterest':
						if(!empty($body -> count)){
							$responseData[$targetUrl]['pinterest'] = $body -> count;
						}else{
							$responseData[$targetUrl]['pinterest'] = 0;
						}
						break;
					case 'buffer':
						if(!empty($body -> shares)){
							$responseData[$targetUrl]['buffer'] = $body -> shares;
						}else{
							$responseData[$targetUrl]['buffer'] = 0;
						}
						break;
					case 'stumbleupon':
						if(!empty($body -> result) && isset( $body -> result -> views )){
							$responseData[$targetUrl]['stumbleupon'] = $body -> result -> views;
						}else{
							$responseData[$targetUrl]['stumbleupon'] = 0;
						}
						break;
					case 'google':
						if(!empty($body)){
							$responseData[$targetUrl]['google'] = $body;
						}else{
							$responseData[$targetUrl]['google'] = 0;
						}
						break;
					case 'vkontakte':
						if(!empty($body)){
							$responseData[$targetUrl]['vkontakte'] = $body;
						}else{
							$responseData[$targetUrl]['vkontakte'] = 0;
						}
						break;
				}
			}
		}
	}
	the_champ_ajax_response(array('status' => 1, 'message' => $responseData));
}

add_action('wp_ajax_the_champ_sharing_count', 'the_champ_sharing_count');
add_action('wp_ajax_nopriv_the_champ_sharing_count', 'the_champ_sharing_count');