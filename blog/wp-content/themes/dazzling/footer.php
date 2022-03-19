<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package dazzling
 */
?>
	</div><!-- #content -->

<div id="footer-area">
	<!--=== Footer ===-->
    <div class="footer">
        <div class="container">
            <div class="row-fluid">
                <div class="span4">
                    <!-- About -->
                    <div class="headline"><h3>About</h3></div>	
                    <p class="margin-bottom-25 justy">Priority Logistics are Australia based courier company with headquarters in Sydney. <a class="read-more" href="#">Read more</a></p>
                    <!-- Monthly Newsletter -->
                    <div class="headline"><h3>Monthly Newsletter</h3></div>	
                    <p>Subscribe to our newsletter and stay up to date with the latest news and deals!</p>
                    <form class="form-inline" />
                        <div class="input-append">
                            <input type="text" placeholder="Email Address" class="input-medium" />
                            <button class="btn-u">Subscribe</button>
                        </div>
                    </form>								
                </div><!--/span4-->	
                
                <div class="span4">
                    <div class="posts">
                        <div class="headline"><h3>Recent Blog Entries</h3></div>
						<?php 
						$args = array( 'numberposts' => '3', 'order' => 'DESC','post_status' => 'publish' );
						$recent_posts = wp_get_recent_posts( $args );
						//Now lets do something with these posts
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
					?>
                        <dl class="dl-horizontal">
                        <dt><a href="#"><img src="<?php echo $imgsrc; ?>" alt="" /></a></dt>
                        <dd>
                            <p><a href="<?php echo get_permalink($recent["ID"]); ?>"><?php echo $recent["post_title"]; ?></a></br>
							
							</p> 
							
                        </dd>
                    </dl>
						<?php
						}
					?>
                    </div>
                </div><!--/span4-->
    
                <div class="span4">
                    <!-- Monthly Newsletter -->
                    <div class="headline"><h3>Contact Us</h3></div>	
                    <address>
                    <?php echo DEFAULT_PL_ADDRESS_1; ?><br />
                    <?php echo DEFAULT_PL_ADDRESS_2; ?><br />
                    <?php echo DEFAULT_PL_CITY; ?><br />
                    Phone: <?php echo DEFAULT_PHONE; ?><br />
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
                <div class="span8">						
                    <p><?php echo NAVIGATION_READ; ?>. ALL Rights Reserved. <a href="<?php echo show_page_link(FILE_CMS .'?page=privacy-policy');?>" title="Learn more about our Privacy Policy"><?php echo NAVIGATION_PRIVACY_POLICY;?></a> | <a href="<?php echo show_page_link(FILE_CMS .'?page=terms-conditions');?>" title="Our Terms of Service"><?php echo NAVIGATION_TERMS;?></a></p>
                </div>
                <div class="span4">	
                    <a href="index.html"><img id="logo-footer" src="<?php echo DIR_HTTP_SITE_CURRENT_TEMPLATE_IMAGES; ?>Logo/Priority_Couriers-Logo_footer.png" class="pull-right" alt="Priority Couriers - Logo" /></a>
                </div>
            </div><!--/row-fluid-->
        </div><!--/container-->	
    </div><!--/copyright-->	
	<!--=== End Copyright ===-->

</div><!--	/End Footer Area	-->
</div><!-- #page -->

<div class="modal fade" id="mapeff" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
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
        <button type="button" class="btn btn-default" data-dismiss="modal" id="closeTrackingbtn" onclick="javascript:closebtn();">Close</button>
       
      </div>
    </div>
  </div>
</div>
<?php wp_footer(); ?>

</body>
</html>
