<!--=== Footer ===-->
<div class="footer">
	<div class="container">
		<div class="row-fluid">
			<div class="span4">
                <!-- About -->
		        <div class="headline"><h3>About</h3></div>	
				<p class="margin-bottom-25 justy">Priority Couriers are Australia based courier company with headquarters in Sydney. <a class="read-more" href="#">Read more</a></p>
                <!-- Monthly Newsletter -->
		        <div class="headline"><h3>Monthly Newsletter</h3></div>	
				<p>Subscribe to our newsletter and stay up to date with the latest news and deals!</p>
				<form id="newsletter" autocomplete="off" method="post">
					<div class="input-append form-group control-group">
                    <input type="text" name="newsletter_id" placeholder="Email Address" id="newsletter_id" class="form-control input-medium" />
                   	<input type="submit" class="btn-u" id="subscribe" name="subscribe" value="Subscribe"> 
                    	<span class="help-block alert-error" id="newsletterError"></span>                     
					</div>
                   
				</form>								
			</div><!--/span4-->	
			<?php
			// Below code comment by smita for local connection 10/3/2022
				//include("blog/wp-config.php");
				//Query 5 recent published post in descending order
				//$args = array( 'numberposts' => '3', 'order' => 'DESC','post_status' => 'publish' );
				//$recent_posts = wp_get_recent_posts( $args );
				//Now lets do something with these posts
				
			?>
				
			<!--Comment by smita for local connection 10/3/2022<div class="span4">
                <div class="posts">
                    <div class="headline"><h3>Recent Blog Entries</h3></div>
                    <?php
					/* 
						foreach( $recent_posts as $recent )
						{
							$html = $recent["post_content"];

							$doc = new DOMDocument();
							@$doc->loadHTML($html);

							$tags = $doc->getElementsByTagName('img');
							$i=0;
							$firstimgsrc = '';
							foreach ($tags as $tag) {
									if($firstimgsrc != $imgsrc)
									{
										$imgsrc = $tag->getAttribute('src');
										$firstimgsrc = $imgsrc;
									}
									
									$i++;
							}
							if(empty($imgsrc))
							{
								$imgsrc = DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES."sliders/elastislide/6.jpg";							
							}
							*/
					?>
					<dl class="dl-horizontal">
                        <dt><a href="#"><img src="<?php //echo $imgsrc; ?>" alt="" /></a></dt>
                        <dd>
                            <p><a href="<?php //echo get_permalink($recent["ID"]); ?>"><?php// echo $recent["post_title"]; ?></a></br>
							
							</p> 
							
                        </dd>
                    </dl>
					<?php
						//}
					?>
                    
                </div>
			</div>--><!--/span4-->
			
			<div class="span4">
	            <!-- Monthly Newsletter -->
		        <div class="headline"><h3>Contact Us</h3></div>	
                <address>
                <!--<?php echo DEFAULT_PL_ADDRESS_1; ?><br />
                <?php echo DEFAULT_PL_ADDRESS_2; ?><br />
                <?php echo DEFAULT_PL_CITY; ?><br />
                Phone: <?php echo DEFAULT_PHONE; ?><br />-->
                Email: <a href="mailto:<?php echo DEFAULT_INFO_EMAIL; ?>" class=""><?php echo DEFAULT_INFO_EMAIL; ?></a>
                </address>

                <!-- Stay Connected -->
		        <div class="headline"><h3>Stay Connected</h3></div>	
                <ul class="social-icons">
                  <!--  <li><a href="#" data-original-title="Feed" class="social_rss"></a></li>
                    <li><a href="#" data-original-title="Facebook" class="social_facebook"></a></li>
                    <li><a href="#" data-original-title="Twitter" class="social_twitter"></a></li> -->
                    <li><a href="https://plus.google.com/101192730485013023140/about" target="_blank" data-original-title="Goole Plus" class="social_googleplus"></a></li>
                  <!--  <li><a href="#" data-original-title="Pinterest" class="social_pintrest"></a></li>
                    <li><a href="#" data-original-title="Linkedin" class="social_linkedin"></a></li>
                    <li><a href="#" data-original-title="Vimeo" class="social_vimeo"></a></li> -->
                </ul>
			</div><!--/span4-->
		</div><!--/row-fluid-->	
	</div><!--/container-->	
</div><!--/footer-->	
<!--=== End Footer ===-->
<!--=== Copyright ===-->
<div class="copyright">
	<div class="container">
		<div class="row-fluid">
			<div class="span7">						
	            <p><?php echo NAVIGATION_READ; ?>. ALL Rights Reserved. <a href="<?php echo show_page_link(FILE_CMS .'?page=privacy-policy');?>" title="Learn more about our Privacy Policy"><?php echo NAVIGATION_PRIVACY_POLICY;?></a> | <a href="<?php echo show_page_link(FILE_CMS .'?page=terms-conditions');?>" title="Our Terms of Service"><?php echo NAVIGATION_TERMS;?></a></p>
			</div>
			<div class="span5">	
				<a href="index.html"><img id="logo-footer" src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>Logo/Priority_Couriers-Logo_footer.png" class="pull-right" alt="" /></a>
			</div>
		</div><!--/row-fluid-->
	</div><!--/container-->	
</div><!--/copyright-->	
<!--=== End Copyright ===-->
<!-- Start of tracking modal -->
<div class="modal hide fade small_rates" id="mapeff"  data-keyboard="false" data-backdrop="static">
	<div class="modal-header">
    	<div class="row-fluid">
    	<div class="span6">
			<div class="headline margin-0">
			<h3>Status:&nbsp;<span id="status" class="my_yellow"></span></h3>
            </div>
       	</div>
        <div class="span6">
        	<div class="headline margin-0" id="sign" style="display:none;">
			<h3>Signed by:&nbsp;<span id="remark" class="my_green"></span></h3>
            </div>
       	</div>
        </div>
	</div>
	<div class="modal-body">
		<div id="map1">
		</div>
		<table class="table" id="tblDesktop">
			
		</table>
		<table class="table" id="tblMobile">
			
		</table>
        
	</div> 
	
	<div class="modal-footer">
    <a href="#" class="btn-u btn-u-primary" data-dismiss="modal" id="closeTracking">Close</a>
    </div>
</div>
<!-- End of tracking modal -->
<!-- NewsLetter subscribtion modal -->
<div class="modal hide fade small_rates" id="newsletter_subscription" data-backdrop="static" data-keyboard="false">
	<div class="modal-header">
	<h3><?php echo NEWSLETTER_SUBSCRIPTION_MESSAGE_HEAD; ?></h3>
	</div>
	<div class="modal-body" >
	<?php echo NEWSLETTER_SUCCESS_AVAIL_MESSAG; ?>
	</div>
	<div class="modal-footer">
    	<span class="white-space"><a href="#more_light" id="newscls" class="btn-u">Close</a></span>
  	</div>
</div>
<!--/End NewsLetter subscribtion modal -->