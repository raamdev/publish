<?php

/**
 * Customize the output of pings in the comments section (used by comments.php)
 */
function publish_theme_pings($comment, $args, $depth)
	{
		$GLOBALS['comment'] = $comment; ?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">

		<div id="comment-<?php comment_ID(); ?>">

			<div class="commentbody">
				<?php printf(__('<cite class="fn">%s</cite>'), get_comment_author_link()) ?> <span> <?php printf(__('%1$s '), get_comment_date("Y-m-d"), get_comment_time("H:i:s")) ?> <?php edit_comment_link(__('(Edit)'), '  ', '') ?></span>
			</div>

		</div>
	<?php
	}

if(!function_exists('get_ncl_location')) :
	/**
	 * Returns location information supplied by Nomad Current Location plugin
	 */
		function get_ncl_location($prefix = "")
			{

				$location = get_post_meta(get_the_ID(), 'ncl_current_location', TRUE);

				if(trim($location) != "")
					{
						return $location_html = $prefix.'<span class="mapThis" place="'.$location.'" zoom="2">'.$location.'</span>';
					}
				else
					{
						return $location_html = '';
					}
			}
endif;

if(!function_exists('raamdev_post_meta')) :
	/**
	 * Returns post meta
	 */
		function raamdev_post_meta()
			{

				// Get location information using Nomad Current Location plugin
				$location_html = get_ncl_location($prefix = " from ");

				/* translators: used between list items, there is a space after the comma */
				$category_list = get_the_category_list(__(', ', 'publish'));

				/* translators: used between list items, there is a space after the comma */
				$tag_list = get_the_tag_list('', __(', ', 'publish'));

				if(!publish_categorized_blog())
					{
						// This blog only has 1 category so we just need to worry about tags in the meta text
						if('' != $tag_list)
							{
								$meta_text = __('<span class="meta-data">This entry was tagged %2$s.</span<', 'publish');
							}
						else
							{
								$meta_text = __('', 'publish');
							}
					}
				else
					{
						// But this blog has loads of categories so we should probably display them here
						if('' != $tag_list)
							{
								$meta_text = __('<div class="meta-data"><span class="meta-data-created">Created by <span class="author vcard"><a class="url fn n" href="/about/" title="About '.get_the_author().'" rel="author">'.get_the_author().'</a></span>.</span> <span class="meta-data-published">Published on <a href="%5$s" title="%6$s" rel="bookmark"><time class="entry-date" datetime="%7$s" pubdate>%8$s</time></a>%9$s.</span> <span class="meta-data-filed">Filed in %1$s and tagged %2$s.</span></div>', 'publish');
							}
						else
							{
								$meta_text = __('<div class="meta-data"><span class="meta-data-created">Created by <span class="author vcard"><a class="url fn n" href="/about/" title="About '.get_the_author().'" rel="author">'.get_the_author().'</a></span>.</span> <span class="meta-data-published">Published on <a href="%5$s" title="%6$s" rel="bookmark"><time class="entry-date" datetime="%7$s" pubdate>%8$s</time></a>%9$s.</span> <span class="meta-data-filed">Filed in %1$s.</span></div>', 'publish');
							}
					} // end check for categories on this blog

				// Add Authorship information to improve SEO
				$author_info = '<span style="display: none;"><a href="https://plus.google.com/103678870073436346171?rel=author">Google+</a></span></span>';
				$meta_text   = $author_info.$meta_text;

				printf(
					$meta_text,
					$category_list,
					$tag_list,
					get_permalink(),
					the_title_attribute('echo=0'),
					esc_url(get_permalink()),
					esc_attr(get_the_time()),
					esc_attr(get_the_date('c')),
					esc_html(get_the_date()),
					$location_html
				);
			}
endif;


if(!function_exists('raamdev_post_authorship')) :
	/**
	 * Returns post meta
	 */
		function raamdev_post_authorship()
			{
				if(!in_category('journal') || is_raamdev_journal_viewable()) {

					// Get location information using Nomad Current Location plugin
					$location_html = get_ncl_location($prefix = "");

					$meta_text = __('<div class="entry-meta authorship">-- <br/>
					<span class="author vcard"><a class="url fn n" href="/about/" title="About '.get_the_author().'" rel="author">'.get_the_author().'</a></span>
					<span class="meta-data-published"><time class="entry-date" datetime="%1$s" pubdate>%2$s</time></span>
					%3$s
					</div>', 'publish');

					// Add Authorship information to improve SEO
					$author_info = '<span style="display: none;"><a href="https://plus.google.com/103678870073436346171?rel=author">Google+</a></span></span>';
					$meta_text   = $author_info.$meta_text;

					printf(
						$meta_text,
						esc_attr(get_the_date('c')),
						esc_html(get_the_date()),
						$location_html
					);
				}
			}
endif;

if(!function_exists('raamdev_post_header_meta')) :
	/**
	 * Returns post header metadata
	 */
		function raamdev_post_header_meta()
			{
				?>
				<!-- START POST HEADER METADATA -->

				<div>
					<div class="entry-meta">
						
						<?php $audio = get_post_meta(get_the_ID(), 'audio_reading_url', TRUE); ?>
						<?php if(trim($audio) != "")
							{ ?>

								<?php if('journal' == get_post_type())
								{ ?>
									<?php $release_after = 365 * 86400; // days * seconds per day
									$post_age            = date('U') - get_post_time('U');
									if($post_age > $release_after || current_user_can("access_s2member_level1"))
										{
											?>

											<div id="audio-player"><a class="wpaudio" href="<?php echo $audio; ?>">Spoken Essay: Listen to Raam Dev reading this essay</a></div>

										<?php }
									else
										{ // else they don't have permission to view this ?>

											<div id="audio-player"><img class="wpaudio-play" src="http://raamdev.com/wordpress/wp-content/plugins/wpaudio-mp3-player/wpaudio-play.png" style="margin: 0px 5px 0px 0px; width: 14px; height: 13px; background-color: rgb(204, 204, 204); vertical-align: baseline; border: 0px; padding: 0px; background-position: initial initial; background-repeat: initial initial; "><a href="http://raamdev.com/wordpress/wp-login.php" style="border-bottom: 1px solid #eee !important;">Login</a> to listen to Raam Dev reading this entry</div>

										<?php } // ends permissions check ?>
								<?php }
							else
								{ // else it's not a journal entry, so just give access ?>
									<div id="audio-player"><a class="wpaudio" href="<?php echo $audio; ?>">Listen to Raam Dev reading this entry</a></div>
								<?php } // ends check if journal ?>
							<?php } // ends check if audio file URL exists ?>

					</div>
				</div>

				<!-- END POST HEADER METADATA -->

			<?php
			}
endif;

if(!function_exists('rd_sharing_buttons')) :
	/**
	 * Displays sharing buttons
	 */
		function rd_sharing_buttons()
			{

				// the_title_attribute() returns title with "Aside: " prepended.
				// This removes that so social shares only include the title.
				$dirty_title = the_title_attribute('echo=0');
				$clean_title = str_replace('Aside: ', '', $dirty_title);

				// Used for including tags in Flattr link
				$posttags    = get_the_tags();
				$flattr_tags = '';
				if($posttags)
					{
						foreach($posttags as $tag)
							{
								$flattr_tags .= $tag->name.',';
							}
					}
				?>
				<!-- START SHARING BUTTONS -->
				<div class="rd-sharing-buttons">

					<div class="rd-sharing-message">Sharing amplifies our potential to change the world. Thank you for sharing.</div>
						<div id="share-twitter">
							<a target="_new" href="https://twitter.com/share?text=<?php echo $clean_title; ?>%20via%20@RaamDev&url=<?php the_permalink(); ?>" title="Share '<?php echo $clean_title; ?>' on Twitter" onclick="share_button_popup(this.href); return false;"><img src="<?php echo get_stylesheet_directory_uri(); ?>/inc/images/twitter.png" /></a>
						</div>
						<div id="share-facebook">
							<a target="_new" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" title="Share '<?php echo $clean_title; ?>' on Facebook" onclick="share_button_popup(this.href); return false;"><img src="<?php echo get_stylesheet_directory_uri(); ?>/inc/images/facebook_share_btn.gif" /></a></div>
						<div id="share-googleplus">
							<a target="_new" href="https://plusone.google.com/_/+1/confirm?hl=en&url=<?php the_permalink(); ?>" title="Share '<?php echo $clean_title; ?>' on Google+" onclick="share_button_popup(this.href); return false;"><img src="<?php echo get_stylesheet_directory_uri(); ?>/inc/images/googleplus.png" /></a>
						</div>
						<?php // Uses WP-Email plugin; see http://wordpress.org/extend/plugins/wp-email/ ?>
						<?php if(function_exists('wp_email')) : ?>
							<div id="share-button">
								<a href="#email-widget" id="share-email-widget" class="email-button"><span>Share via Email</span></a>
							</div>
						<?php endif; ?>
						<div id="share-button">
							<span id="subscribe-button" class="subscribe-button">Subscribe</span>
						</div>
						<div id="share-button" class="right-button">
							<span id="share-tip" class="share-tip">Leave a Tip</span>
						</div>
					<div style="clear: both;"></div>
					<div id="subscribe-widget">
						<!-- BEGIN SUBSCRIBE FORM WIDGET CODE -->
						<?php raamdev_subscribe_form_widget(); ?>
						<!-- END SUBSCRIBE FORM WIDGET CODE -->
					</div>

					<!-- Start Share via Email Code -->
					<div id="email-widget" class="email-widget">
						<iframe class="emailiframe" src="<?php the_permalink(); ?>/emailpopup/" title="Email" scrolling="no" width="100%" height="875" style="border-width: 0px;"></iframe>
					</div>
					<!-- End Share via Email Code -->

					<!-- START TIP BOX -->
					<div id="share-tip-info">
						<form name="custom-amount" method="get" action="<?php echo home_url('/tip/', 'https'); ?>">
							<input type="hidden" name="page_title" value="<?php echo $clean_title; ?>">
							Tip Raam $<input class="tip-amount" type="text" maxlength="10" name="amount" value="0.25"> for '<em><?php echo $clean_title; ?></em>'
							&nbsp;<input type="submit" value="Give &rarr;">
						</form>
						<br />
						<div class="alt-tip-methods">
							<small>
								Prefer <span id="tip-bitcoin" class="alt-tip-method">Bitcoins</span>, <span id="tip-flattr" class="alt-tip-method">Flattr</span>, or <span id="tip-gittip" class="alt-tip-method">Gittip</span>?
							</small>
						</div>
						<div style="clear:both;"></div>
						<!-- Start Gittip Code -->
						<div id="gittip-widget" class="gittip-widget">
							<iframe style="border: 0; margin: 0; padding: 0;"
							        src="https://www.gittip.com/RaamDev/widget.html"
							        width="48pt" height="22pt"></iframe>
							<br />
							<br />
							<small><span class="alt-tips-desc">Gittip is a way to give small weekly cash gifts to people you love. <a href="https://www.gittip.com/about/" target="_new">Learn more.</a></small>
						</div>
						<!-- End Gittip Code -->
						<!-- Start Flattr Code -->
						<div id="flattr-widget" class="flattr-widget">
							<a class="FlattrButton" href="<?php the_permalink(); ?>" title="<?php echo $clean_title; ?>" tags="<?php echo $flattr_tags; ?>" category="text">
								<?php echo $clean_title; ?>
							</a>
							<br />
							<br />
							<small><span class="alt-tips-desc">Flattr is a social micropayment service. <a href="http://www.flattr.com" target="_new">Learn more.</a></small>
						</div>
						<!-- End Flattr Code -->
						<!-- Start Bitcoin Code -->
						<?php if(class_exists('Bitcointips')) : ?>
							<div id="bitcointips-widget" class="bitcointips-widget">
								<!-- Uses the Bitcoin Tips WordPress Plugin -->
								<!-- See https://github.com/raamdev/bitcoin-tips -->
								<div class="qrcode"><?php echo do_shortcode('[bitcointips output="qrcode"]'); ?></div>
								<div class="contents">
									<p class="bitcointips-address"><?php echo do_shortcode('[bitcointips output="address"]'); ?></p>
								</div>
								<small><span class="alt-tips-desc">Bitcoin is a decentralized digital currency. <a href="http://www.weusecoins.com" target="_new">Learn more.</a></a></small>
							</div>
						<?php endif; ?>
						<!-- End Bitcoin Code -->
					</div>
					<!-- END TIP BOX -->
					<div style="clear: both;"></div>
				</div>

				<!-- END SHARING BUTTONS -->

			<?php
			}
endif;

if(!function_exists('rd_sharing_buttons_text')) :
	/**
	 * Displays sharing buttons in a text version
	 */
		function rd_sharing_buttons_text()
			{

				// the_title_attribute() returns title with "Aside: " prepended.
				// This removes that so social shares only include the title.
				$dirty_title = the_title_attribute('echo=0');
				$clean_title = str_replace('Aside: ', '', $dirty_title);

				// Used for including tags in Flattr link
				$posttags    = get_the_tags();
				$flattr_tags = '';
				if($posttags)
					{
						foreach($posttags as $tag)
							{
								$flattr_tags .= $tag->name.',';
							}
					}
				?>
				<!-- START SHARING BUTTONS -->
				<?php // Email This function uses WP-Email plugin; see http://wordpress.org/extend/plugins/wp-email/ ?>
				<div class="rd-sharing-buttons">
					<div class="rd-sharing-message" style="font-size: 100%;">Sharing amplifies our potential to change the world.</div>
					<div class="rd-sharing-message">Did you enjoy this? Please <?php if(function_exists('wp_email')) : ?><a href="#email-widget" onClick="_gaq.push(['_trackEvent', 'Sharing Buttons Text', 'Email', 'Email it to a friend']);" id="share-email-widget"><span>email it</span></a> to a friend or <?php endif; ?> share it via <a target="_new" href="https://twitter.com/share?text=<?php echo $clean_title; ?>%20via%20@RaamDev&url=<?php the_permalink(); ?>" title="Share '<?php echo $clean_title; ?>' on Twitter" onclick="share_button_popup(this.href); _gaq.push(['_trackEvent', 'Sharing Buttons Text', 'Twitter', 'Share via Twitter']); return false;">Twitter</a>, <a target="_new" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" title="Share '<?php echo $clean_title; ?>' on Facebook" onclick="share_button_popup(this.href); _gaq.push(['_trackEvent', 'Sharing Buttons Text', 'Facebook', 'Share via Facebook']); return false;">Facebook</a>, or <a target="_new" href="https://plusone.google.com/_/+1/confirm?hl=en&url=<?php the_permalink(); ?>" title="Share '<?php echo $clean_title; ?>' on Google+" onclick="share_button_popup(this.href); _gaq.push(['_trackEvent', 'Sharing Buttons Text', 'Google+', 'Share via Google+']); return false;">Google+</a>.
						<br>
						You can also <a href="#share-tip" id="share-tip" onClick="_gaq.push(['_trackEvent', 'Sharing Buttons Text', 'Tip', 'Buy me a banana']);">buy me a banana</a> or <a href="#subscribe-button" id="subscribe-button" class="subscribe-button" onClick="_gaq.push(['_trackEvent', 'Sharing Buttons Text', 'Subscribe', 'Subscribe to future work']);">subscribe</a> to receive my future work.
					</div>
					<br>
					<div class="rd-sharing-message">Thank you for sharing. :)</div>
					<div style="clear: both;"></div>
					<div id="subscribe-widget">
						<!-- BEGIN SUBSCRIBE FORM WIDGET CODE -->
						<?php raamdev_subscribe_form_widget(); ?>
						<!-- END SUBSCRIBE FORM WIDGET CODE -->
					</div>

					<!-- Start Share via Email Code -->
					<div id="email-widget" class="email-widget">
						<iframe class="emailiframe" src="<?php the_permalink(); ?>/emailpopup/" title="Email" scrolling="no" width="100%" height="875" style="border-width: 0px;"></iframe>
					</div>
					<!-- End Share via Email Code -->

					<!-- START TIP BOX -->
					<div id="share-tip-info">
						<form name="custom-amount" method="get" action="<?php echo home_url('/tip/', 'https'); ?>">
							<input type="hidden" name="page_title" value="<?php echo $clean_title; ?>">
							Tip Raam $<input class="tip-amount" type="text" maxlength="10" name="amount" value="0.25"> for '<em><?php echo $clean_title; ?></em>'
							&nbsp;<input type="submit" value="Give &rarr;">
						</form>
						<br />
						<div class="alt-tip-methods">
							<small>
								Prefer <span id="tip-bitcoin" class="alt-tip-method" onClick="_gaq.push(['_trackEvent', 'Sharing Buttons Text', 'Tip Bitcoins', 'Tip via Bitcoins']);">Bitcoins</span>, <span id="tip-flattr" class="alt-tip-method" onClick="_gaq.push(['_trackEvent', 'Sharing Buttons Text', 'Tip Flattr', 'Tip via Flattr']);">Flattr</span>, or <span id="tip-gittip" class="alt-tip-method" onClick="_gaq.push(['_trackEvent', 'Sharing Buttons Text', 'Tip Gittip', 'Tip via Gittip']);">Gittip</span>?
							</small>
						</div>
						<div style="clear:both;"></div>
						<!-- Start Gittip Code -->
						<div id="gittip-widget" class="gittip-widget">
							<iframe style="border: 0; margin: 0; padding: 0;"
							        src="https://www.gittip.com/RaamDev/widget.html"
							        width="48pt" height="22pt"></iframe>
							<br />
							<br />
							<small><span class="alt-tips-desc">Gittip is a way to give small weekly cash gifts to people you love. <a href="https://www.gittip.com/about/" target="_new">Learn more.</a></small>
						</div>
						<!-- End Gittip Code -->
						<!-- Start Flattr Code -->
						<div id="flattr-widget" class="flattr-widget">
							<a class="FlattrButton" href="<?php the_permalink(); ?>" title="<?php echo $clean_title; ?>" tags="<?php echo $flattr_tags; ?>" category="text">
								<?php echo $clean_title; ?>
							</a>
							<br />
							<br />
							<small><span class="alt-tips-desc">Flattr is a social micropayment service. <a href="http://www.flattr.com" target="_new">Learn more.</a></small>
						</div>
						<!-- End Flattr Code -->
						<!-- Start Bitcoin Code -->
						<?php if(class_exists('Bitcointips')) : ?>
							<div id="bitcointips-widget" class="bitcointips-widget">
								<!-- Uses the Bitcoin Tips WordPress Plugin -->
								<!-- See https://github.com/raamdev/bitcoin-tips -->
								<div class="qrcode"><?php echo do_shortcode('[bitcointips output="qrcode"]'); ?></div>
								<div class="contents">
									<p class="bitcointips-address"><?php echo do_shortcode('[bitcointips output="address"]'); ?></p>
								</div>
								<small><span class="alt-tips-desc">Bitcoin is a decentralized digital currency. <a href="http://www.weusecoins.com" target="_new">Learn more.</a></a></small>
							</div>
						<?php endif; ?>
						<!-- End Bitcoin Code -->
					</div>
					<!-- END TIP BOX -->
					<div style="clear: both;"></div>
				</div>

				<!-- END SHARING BUTTONS -->

			<?php
			}
endif;

if(!function_exists('is_raamdev_journal_viewable')) :
	/**
	 * Returns true if post is more than 1 year old, otherwise returns false
	 */
		function is_raamdev_journal_viewable()
			{
				$release_after = 365 * 86400; // days * seconds per day
				$post_age      = date('U') - get_post_time('U');
				if($post_age > $release_after || current_user_can("access_s2member_level1"))
					{
						return TRUE;
					}
				else
					{
						return FALSE;
					}
			}
endif;

if(!function_exists('the_raamdev_journal_released_message')) :
	/**
	 * Returns message about journal release
	 */
		function the_raamdev_journal_released_message()
			{
				// only show this message if the user is not logged in or doesn't have access
				if(!is_user_logged_in() || !current_user_can("access_s2member_level1")) :
						?>
						<div style="font-size: 80%; border: 1px solid #eee; padding: 20px; margin-bottom: 20px; line-height: 1.4em; background: #eee;">This is an entry from my <a href="http://raamdev.com/about/journal/">personal Journal</a> and it was published over one year ago. It was initially only available to paying subscribers. However, as per my <a href="http://raamdev.com/income-ethics-series/#public_domain">Income Ethics</a>, "all non-free creative work will be made public domain within one year". So, after spending one year behind a paywall, this content is now free. Ah, sweet freedom!</div>

					<?php
				endif;
			}
endif;

if(!function_exists('the_raamdev_journal_not_released_message')) :
	/**
	 * Returns message about journal not released yet
	 */
		function the_raamdev_journal_not_released_message()
			{
				// Used to make the journal entry greyed out when it's unvailable
				$post_id = get_the_ID();
				?>

				<style type="text/css">
					#post- <?php echo $post_id;?>
					{
						opacity : 0.5;
					}
				</style>
				<div id="journal-notice">
					<blockquote>
						<p>This journal entry has not been released into the public domain and is currently only available through a subscription to the <a href="http://raamdev.com/about/journal/">Journal</a> or a <a href="/about/journal/#one_time_donation">one-time donation</a>.</p>
						<?php if(is_user_logged_in())
							{ ?>
								<p>Since you're already logged in, you can <a href="/account/modification/">upgrade now</a> to receive access to this entry.</p>
							<?php }
						else
							{ ?>
								<p>If you have an active subscription to the Journal, please <a href="https://raamdev.com/wordpress/wp-login.php">login</a> to access this entry (you may need to <a href="https://raamdev.com/wordpress/wp-login.php?action=lostpassword">reset your password</a> first).</p>
							<?php } ?>
					</blockquote>
				</div>
			<?php
			}
endif;

if(!function_exists('the_raamdev_journal_not_released_comments_message')) :
	/**
	 * Returns message about journal not released yet
	 */
		function the_raamdev_journal_not_released_comments_message()
			{
				?>
				<div id="journal-notice-comments">
					<p><strong>Comments are hidden.</strong></p>
				</div>
			<?php
			}
endif;

if(!function_exists('rd_get_recent_posts')) :
	/**
	 * Returns recent posts for given category and excludes given post formats
	 */
		function rd_get_recent_posts($number_posts = '10', $category = '', $exclude_formats = array())
			{

				// Make sure category exists
				if(!get_cat_ID($category))
					{
						return FALSE;
					}

				// Build array of format exclution queries
				if(!empty($exclude_formats)) :
						$i         = 0;
						$tax_query = array();

						foreach($exclude_formats as $format)
							{

								$tax_query[$i] = array(
									'taxonomy' => 'post_format',
									'field'    => 'slug',
									'terms'    => 'post-format-'.$format,
									'operator' => 'NOT IN'
								);

								$i++;
							}
				endif;

				?>
				<ul>
					<?php
					$args = array('numberposts' => $number_posts, 'category' => get_cat_ID($category), 'post_status' => 'publish', 'tax_query' => $tax_query);
					$recent_posts = wp_get_recent_posts($args);
					foreach($recent_posts as $recent)
						{
							echo '<li><a href="'.get_permalink($recent["ID"]).'" title="Look '.esc_attr($recent["post_title"]).'" >'.$recent["post_title"].'</a> </li> ';
						}
					?>
				</ul>
			<?php
			}
endif;

if(!function_exists('raamdev_pageslide_subscribe_form')) :
	/**
	 * Returns pageslide subscribe form
	 */
		function raamdev_pageslide_subscribe_form()
			{

				?>
				<!-- BEGIN PAGESLIDE SUBSCRIBE FORM CODE -->

				<div id="signup" style="display:none">
					<div class="wrapper">
						<div class="cell">
							<section>
								<p><strong>Subscribe</strong> to receive new thoughts and essays as they're published.</p>
								<form action="http://raamdev.us1.list-manage.com/subscribe/post?u=5daf0f6609de2506882857a28&id=dc1b1538af" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" target="_blank">
									<?php if(is_single() && !in_category('journal')) : ?>
										<?php $reflections = "";
										$technology        = "";
										$writing           = ""; ?>
										<?php if(in_category('20'))
											{
												$reflections = "checked";
											} ?>
										<?php if(in_category('5'))
											{
												$technology = "checked";
											} ?>
										<?php if(in_category('859'))
											{
												$writing = "checked";
											} ?>
									<?php else : ?>
										<?php $reflections = "checked";
										$technology        = "checked";
										$writing           = "checked"; ?>
									<?php endif; ?>

									<div style="display:none;"><input type="hidden" name="MERGE3" value="<?php echo 'http://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]; ?>" id="MERGE3"></div>
									<input type="text" placeholder="First Name..." id="mce-FNAME" name="FNAME">
									<input type="text" placeholder="Email Address..." id="mce-EMAIL" name="EMAIL">
									<input type="submit" value="Subscribe »" tabindex="503">

									<div class="mc-field-group">
										<label for="mce-group[1129]">When new essays are published, email me:</label>
										<select name="group[1129]" class="REQ_CSS" id="mce-group[1129]" tabindex="502">
											<option value="1" selected="selected">immediately</option>
											<option value="2">a weekly digest</option>
											<option value="4">a monthly digest</option>
										</select>
										<br />
										<label for="mce-group[1873]">When new thoughts are published, email me: </label>
										<select name="group[1873]" class="REQ_CSS" id="mce-group[1873]" tabindex="508">
											<option value="8">immediately</option>
											<option value="16">a weekly digest</option>
											<option value="32" selected="selected">a monthly digest</option>
										</select>
										<div class="subscribe-home-essay-topics">
											Essay topics:&nbsp;&nbsp;
											<input type="checkbox" id="group_64" name="group[1989][64]" value="1" <?php echo $reflections; ?>>&nbsp;<label style="font-style: italic;">Personal Reflections</label>&nbsp;&nbsp;
											<input type="checkbox" id="group_128" name="group[1989][128]" value="1" <?php echo $technology; ?>>&nbsp;<label style="font-style: italic;">Technology</label>&nbsp;&nbsp;
											<input type="checkbox" id="group_256" name="group[1989][256]" value="1" <?php echo $writing; ?>>&nbsp;<label style="font-style: italic;">Writing</label><br>
										</div>
									</div>

								</form>
								<hr>
								<small>
									RSS Feeds:&nbsp;
									<a href="http://feeds.feedburner.com/RaamDevAllTopics">All Topics</a> ·
									<a href="http://feeds.feedburner.com/RaamDevsWeblog">Personal Reflections</a> ·
									<a href="http://feeds.feedburner.com/RaamDevWriting">Writing & Publishing</a> ·
									<a href="http://feeds.feedburner.com/RaamDevTechnology">Technology</a>
								</small>
								<br /><br />
								<a href="javascript:$.pageslide.close()">« Back</a>
							</section>
						</div>
					</div>
				</div>


				<script src="<?php echo get_template_directory_uri(); ?>/inc/jquery-pageslide/lib/jquery-1.7.1.min.js"></script>
				<script src="<?php echo get_template_directory_uri(); ?>/inc/jquery-pageslide/jquery.pageslide.min.js"></script>
				<script>
					/* Slide to the left, and make it model (you'll have to call $.pageslide.close() to close) */
					$(".signup").pageslide({ direction: "left", modal: true });
				</script>

				<!-- END PAGESLIDE SUBSCRIBE FORM CODE -->

			<?php
			}
endif;

if(!function_exists('raamdev_subscribe_form_widget')) :
	/**
	 * Returns subscribe form widget
	 */
		function raamdev_subscribe_form_widget()
			{

				$post_categories = wp_get_post_categories(get_the_ID());
				$cats            = array();

				foreach($post_categories as $c)
					{
						$cat    = get_category($c);
						$cats[] = array('name' => $cat->name, 'slug' => $cat->slug);
					}
				$cats[0]['name'] != "Personal Reflections" ? $extra_subscribe_text = " essays" : $extra_subscribe_text = "";

				?>
				<div class="subscribe-form-widget">
					<section>
						<p class="subscribe-message"><strong>Subscribe</strong> to receive new <em><?php echo $cats[0]['name']; ?></em><?php echo $extra_subscribe_text; ?></p>
						<form action="http://raamdev.us1.list-manage.com/subscribe/post?u=5daf0f6609de2506882857a28&id=dc1b1538af" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" target="_blank">
							<?php if(is_single() && !in_category('journal')) : ?>
								<?php $reflections = "";
								$technology        = "";
								$writing           = ""; ?>
								<?php if(in_category('20'))
									{
										$reflections = "checked";
									} ?>
								<?php if(in_category('5'))
									{
										$technology = "checked";
									} ?>
								<?php if(in_category('859'))
									{
										$writing = "checked";
									} ?>
							<?php else : ?>
								<?php $reflections = "checked";
								$technology        = "checked";
								$writing           = "checked"; ?>
							<?php endif; ?>
							<div style="display:none;"><input type="hidden" name="MERGE3" value="<?php echo 'http://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]; ?>" id="MERGE3"></div>
							<input type="text" placeholder="First Name..." id="mce-FNAME" name="FNAME" tabindex="503">
							<input type="text" placeholder="Email Address..." id="mce-EMAIL" name="EMAIL" tabindex="504">
							<input type="submit" value="Subscribe »" tabindex="505">
							<div class="mc-field-group" id="subscribe-form-widget-subscription-options" style="display: none;">
								<label for="mce-group[1129]">When new essays are published, email me: </label>
								<select name="group[1129]" class="REQ_CSS" id="mce-group[1129]" tabindex="507">
									<option value="1" selected="selected">immediately</option>
									<option value="2">a weekly digest</option>
									<option value="4">a monthly digest</option>
								</select>
								<br />
								<label for="mce-group[1873]">When new thoughts are published, email me: </label>
								<select name="group[1873]" class="REQ_CSS" id="mce-group[1873]" tabindex="508">
									<option value="8">immediately</option>
									<option value="16">a weekly digest</option>
									<option value="32" selected="selected">a monthly digest</option>
								</select>
								<div class="subscribe-home-essay-topics">
									<p>Send me thoughts and essays on the following topics:</p>
									<div class="groups">
										<p><input tabindex="509" type="checkbox" id="group_64" name="group[1989][64]" value="1" <?php echo $reflections; ?>>&nbsp;<label for="group_64" style="font-style: italic;">Personal Reflections</label></p>
										<p><input tabindex="510" type="checkbox" id="group_128" name="group[1989][128]" value="1" <?php echo $technology; ?>>&nbsp;<label for="group_128" style="font-style: italic;">Technology</label></p>
										<p><input tabindex="511" type="checkbox" id="group_256" name="group[1989][256]" value="1" <?php echo $writing; ?>>&nbsp;<label for="group_256" style="font-style: italic;">Writing & Publishing</label></p>
									</div>
								</div>
							</div>
						</form>
						<div class="never-sell-your-email">
							<p>I promise to never sell or give away your email address. You can unsubscribe at any time.</p>
						</div>
						<div class="subscription-options-button"><span id="subscription-options-button" tabindex="506" onClick="_gaq.push(['_trackEvent', 'Sharing Buttons Text', 'Subscribe Options', 'View Subscription Options']);">Subscription Options</span></div>
						<div class="rss-feeds" id="rss-feeds">
							RSS Feeds:&nbsp;
							<a href="http://feeds.feedburner.com/RaamDevAllTopics">All Topics</a> ·
							<a href="http://feeds.feedburner.com/RaamDevsWeblog">Personal Reflections</a> ·
							<a href="http://feeds.feedburner.com/RaamDevWriting">Writing & Publishing</a> ·
							<a href="http://feeds.feedburner.com/RaamDevTechnology">Technology</a>
						</div>
					</section>
				</div>

			<?php
			}
endif;

if(!function_exists('rd_new_nav_menu_items')) :
	/**
	 * Filter wp_nav_menu() to add additional custom links
	if single
		delete all nav items
		add homelink + an essay by (float right)
		if logged in
			add logout/myaccount link (float left)
	if !single
		add 
	 */
		function rd_new_nav_menu_items($items, $args)
			{
				if(is_single() && $args->theme_location != 'footer') { // keep the nav bar simple on single pages
					echo '<style type="text/css">.site-header .site-navigation {border-bottom: none;}</style>';
					if ('aside' === get_post_format()) { $type = 'A Thought'; }
					if (!get_post_format()) { $type = 'An Essay'; }

					//$homelink = '<li class="home-nav-single">' . $type . ' by <a href="'.home_url('/').'" rel="home">'.get_bloginfo('name').'</a></li>	';
					$homelink = '<li class="nav-date-single">' . get_the_date('Y-m-d') . '</li>';
					$homelink .= '<li class="home-nav-date-separator"><span>⋅</span></li>';
					$homelink .= '<li class="home-nav-single"><a href="'.home_url('/').'" rel="home">'.get_bloginfo('name').'</a></li>';
					$items    = $homelink;
				}
				else {
					$homelink = '<li class="home-nav"><a href="'.home_url('/').'" rel="home">'.get_bloginfo('name').'</a></li><li class="home-nav-separator"><span>»</span></li>';
					$items    = $homelink . $items;
				}
				
				if(!is_user_logged_in() && !is_single() || !is_user_logged_in()  && is_single() && $args->theme_location == 'footer')
					{
						$subscribe_link = '<li class="menu-item subscribe-menu-item"><a href="#signup" class="signup">Subscribe</a></li>';
						$items          = $items . $subscribe_link;
					}
				if(is_user_logged_in()  && !is_single() || is_user_logged_in()  && is_single() && $args->theme_location == 'footer')
					{
						$my_account_link = '<li class="menu-item my-account-menu-item"><a href="/account/">My Account</a></li>';
						$items           = $my_account_link.$items;
						$logout_link     = '<li class="menu-item logout-menu-item"><a href="'.wp_logout_url().'">Logout</a></li>';
						$items           = $logout_link.$items;
					}

				return $items;
			}

		add_filter('wp_nav_menu_items', 'rd_new_nav_menu_items', 10, 2);
endif;

if(!function_exists('rd_rss_filter_post_formats')) :
	/**
	 * Filter post formats from RSS feed
	 */
		add_action('pre_get_posts', 'rd_rss_filter_post_formats');
		function rd_rss_filter_post_formats(&$wp_query)
			{
				if($wp_query->is_feed())
					{
						if(isset($wp_query->query_vars['rss-post-format-aside']))
							{ // Only return Asides
								$post_format_tax_query = array(
									'taxonomy' => 'post_format',
									'field'    => 'slug',
									'terms'    => 'post-format-aside',
									'operator' => 'IN'
								);
								$tax_query             = $wp_query->get('tax_query');
								if(is_array($tax_query))
									{
										$tax_query = $tax_query + $post_format_tax_query;
									}
								else
									{
										$tax_query = array($post_format_tax_query);
									}
								$wp_query->set('tax_query', $tax_query);
							}
						else if(isset($wp_query->query_vars['rss-post-format-image']))
							{ // Only return Images

								$post_format_tax_query = array(
									'taxonomy' => 'post_format',
									'field'    => 'slug',
									'terms'    => 'post-format-image',
									'operator' => 'IN'
								);
								$tax_query             = $wp_query->get('tax_query');
								if(is_array($tax_query))
									{
										$tax_query = $tax_query + $post_format_tax_query;
									}
								else
									{
										$tax_query = array($post_format_tax_query);
									}
								$wp_query->set('tax_query', $tax_query);
							}
						else if(isset($wp_query->query_vars['rss-post-format-standard']))
							{ //

								$post_format_tax_query = array(
									'taxonomy' => 'post_format',
									'field'    => 'slug',
									'terms'    => array('post-format-aside', 'post-format-image'),
									'operator' => 'NOT IN'
								);
								$tax_query             = $wp_query->get('tax_query');
								if(is_array($tax_query))
									{
										$tax_query = $tax_query + $post_format_tax_query;
									}
								else
									{
										$tax_query = array($post_format_tax_query);
									}
								$wp_query->set('tax_query', $tax_query);
							} // if( isset($wp_query->query_vars['rss-post-format-aside'])
					} // if ( $wp_query->is_feed() )
			} // function rd_rss_filter_post_formats()
endif;

if(!function_exists('rd_rss_filter_journal')) :
	/**
	 * Filter journal entries from RSS feeds, except when using secret URL
	 */
		add_action('pre_get_posts', 'rd_rss_filter_journal');
		function rd_rss_filter_journal(&$wp_query)
			{
				if($wp_query->is_feed() && !isset($wp_query->query_vars['rss-journal-kjadj831fsdj']))
					{
						$wp_query->set('category__not_in', '921');
					}
				else if($wp_query->is_feed() && isset($wp_query->query_vars['rss-journal-kjadj831fsdj']))
					{
						$wp_query->set('category__in', '921');
					}
			}
endif;

if(!function_exists('rd_add_query_vars')) :
	/**
	 * Query vars used for filtering RSS feeds
	 */
		function rd_add_query_vars($aVars)
			{
				$aVars[] = "rss-post-format-aside";
				$aVars[] = "rss-post-format-image";
				$aVars[] = "rss-post-format-standard";
				$aVars[] = "rss-journal-kjadj831fsdj";
				return $aVars;
			}

		add_filter('query_vars', 'rd_add_query_vars');
endif;

if(!function_exists('rd_rss_change_title')) :
	/**
	 * Changes the RSS feed title to rename specific post formats
	 */
		function rd_rss_change_title()
			{
				$title = get_wp_title_rss();
				if(strpos($title, "Aside"))
					{
						$new_title = str_replace("Aside", "Thoughts", $title);
						echo $new_title;
					}
				else
					{
						echo get_wp_title_rss();
					}
			}
endif;
add_filter('wp_title_rss', 'rd_rss_change_title', 1);

if(!function_exists('rd_journal_365_filter_where')) :
	/**
	 * Create a filtering function for showing journal entries older than 365 days
	 */
		function rd_journal_365_filter_where($where = '')
			{
				// posts older than 365 days
				$where .= " AND post_date < '".date('Y-m-d', strtotime('-365 days'))."'";
				return $where;
			}
endif;

if(!function_exists('rd_get_public_journals')) :
	/**
	 * List public journals (older than 365 days)
	 */
		function rd_get_public_journals($number_posts = '10')
			{
				add_filter('posts_where', 'rd_journal_365_filter_where');
				?>
				<ul>
					<?php
					$args = array('posts_per_page' => $number_posts, 'category_name' => 'Personal Reflections', 'post_status' => 'publish');
					//$recent_posts = wp_get_recent_posts( $args );
					$recent_posts = new WP_Query($args);
					if($recent_posts->have_posts()) :
							while($recent_posts->have_posts()) : $recent_posts->the_post();
								echo '<li><a href="'.get_permalink().'" title="Look '.get_the_title().'" >'.get_the_title().'</a> </li> ';
							endwhile;
					else :
							echo wpautop('Sorry, no posts were found');
					endif;
					?>
				</ul>
				<?php
				wp_reset_postdata();
				remove_filter('posts_where', 'rd_journal_365_filter_where');
			}
endif;

/**
 * Redirect the registration form to a specific page after submission
 */
function __my_registration_redirect()
	{
		return home_url('/please-confirm-subscription');
	}

add_filter('registration_redirect', '__my_registration_redirect');

if(!function_exists('rd_my_login_css')) :
	/**
	 * Add custom styles for login form (brings entire form up to accommodate for custom header logo)
	 */
		function rd_my_login_css()
			{
				echo '<style type="text/css">#login { padding: 15px 0 0; margin: auto; } .login h1 a { padding-bottom: 0px; }</style>';
			}

		add_action('login_head', 'rd_my_login_css');
endif;

if(!function_exists('rd_sc_static_html')) :
	/**
	 * Shortcode for including Static HTML Files in posts
	 */
		function rd_sc_static_html($atts)
			{

				// Extract Shortcode Parameters/Attributes
				extract(shortcode_atts(array(
				                            'subdir' => NULL,
				                            'file'   => NULL
				                       ), $atts));

				// Set file path
				$path_base = ABSPATH."wp-content/static-files/";
				$path_file = ($subdir == NULL) ? $path_base.$file : $path_base.$subdir."/".$file;

				// Load file or, if absent. throw error
				if(file_exists($path_file))
					{
						$file_content = file_get_contents($path_file);
						return $file_content;
					}
				else
					{
						trigger_error("'$path_file' file not found", E_USER_WARNING);
						return "FILE NOT FOUND: ".$path_file."
SUBDIR = ".$subdir."
FILE = ".$file."

";
					}
			}

		add_shortcode('static_html', 'rd_sc_static_html');
endif;

if(!function_exists('rd_custom_mime_media_types')) :
	/**
	 * Allow Custom MIME Types to be uploaded via WordPress Media Library
	 */
		function rd_custom_mime_media_types($mimes)
			{
				$mimes = array_merge($mimes, array(
				                                  'epub|mobi' => 'application/octet-stream'
				                             ));
				return $mimes;
			}

		add_filter('upload_mimes', 'rd_custom_mime_media_types');
endif;

/**
 * Remove specific Post Format's from the post title
 */
function rd_suppress_post_format_title($title, $id)
	{
		$clean_title = str_replace('Aside: ', '', $title);
		return $clean_title;
	}

add_filter('the_title', 'rd_suppress_post_format_title', 10, 2);

/**
 * Return the full permalink instead of the shortlink
 */
function rd_custom_shortlink_filter()
	{
		$permalink = get_permalink();
		return $permalink;
	}

add_filter('get_shortlink', 'rd_custom_shortlink_filter');

/**
 * Fix comment count so that it doesn't include pings/trackbacks
 */
add_filter('get_comments_number', 'comment_count', 0);
function comment_count($count)
	{
		if(!is_admin())
			{
				global $id;

				$comments_by_type = & separate_comments(get_comments('status=approve&post_id='.$id));

				return count($comments_by_type['comment']);
			}
		else
			{

				return $count;
			}
	}

/**
 * Add TinyMCE Editor to Comments form
 * Thanks to http://www.revood.com/blog/adding-visual-editor-to-wordpress-comments-box-part-2/
 */
//add_filter('comment_form_defaults', 'custom_comment_form_defaults');
function custom_comment_form_defaults($args)
	{
		if(is_user_logged_in())
			{
				$mce_plugins = 'inlinepopups, fullscreen, wordpress, wplink, wpdialogs';
			}
		else
			{
				$mce_plugins = 'fullscreen, wordpress';
			}
		ob_start();
		wp_editor('', 'comment', array(
		                              'media_buttons' => FALSE,
		                              'teeny'         => TRUE,
		                              'editor_class'  => 'myclass',
		                              'editor_css'    => '<style type="text/css">body { background: white !important; }</style>',
		                              'textarea_rows' => '7',
		                              'tinymce'       => array('plugins'                           => $mce_plugins,
		                                                       'theme_advanced_buttons1'           => 'bold, italic, underline, strikethrough, forecolor, separator, bullist, numlist, separator, link, unlink',
		                                                       'theme_advanced_buttons2'           => '',
		                                                       'theme_advanced_statusbar_location' => 'none')
		                         ));
		$args['comment_field'] = ob_get_clean();
		return $args;
	}


add_filter( 'comment_form_defaults', 'remove_textarea' );
add_action( 'comment_form_top', 'add_textarea' );

function remove_textarea($defaults)
	{
		$defaults['comment_field'] = '';
		return $defaults;
	}

function add_textarea()
	{
		echo '<div id="main-reply-title"><h3>Your thoughts? Please leave a reply:</h3></div>';
		echo '<p class="comment-form-comment" id="comment-form-field"><textarea id="comment" name="comment" cols="60" rows="6" placeholder="Type your thoughts here" aria-required="true"></textarea></p>';
	}



function rd_comment_form_args() {

	if(!is_user_logged_in()) {
		$comment_notes_before = '<div id="comment-form-fields">';
		$comment_notes_after = '</div>';
	} else {
		$comment_notes_before = '';
		$comment_notes_after = '';
	}
	$user = wp_get_current_user();
	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );

	$args = array(
		'id_form'           => 'commentform',
		'id_submit'         => 'submit',
		'title_reply'       => __( '' ),
		'title_reply_to'    => __( 'Leave a Reply to %s' ),
		'cancel_reply_link' => __( 'Cancel Reply' ),
		'label_submit'      => __( 'Submit Comment' ),

		'must_log_in' => '<p class="must-log-in">' .
		                 sprintf(
			                 __( 'You must be <a href="%s">logged in</a> to post a comment.' ),
			                 wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
		                 ) . '</p>',

		'logged_in_as' => '<p class="logged-in-as">' .
		                  sprintf(
			                  __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ),
			                  admin_url( 'profile.php' ),
			                  $user->display_name,
			                  wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
		                  ) . '</p>',

		'comment_notes_before' => $comment_notes_before,

		'comment_notes_after' => $comment_notes_after,

		'fields' => apply_filters( 'comment_form_default_fields', array(

		                                                               'author' =>
		                                                               '<p class="comment-form-author">' .
		                                                               '<label for="author">' . __( 'Your Name', 'domainreference' ) . '</label><br />' .
		                                                               '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
		                                                               '" size="25"' . $aria_req . ' /></p>',

		                                                               'email' =>
		                                                               '<p class="comment-form-email"><label for="email">' . __( 'Your Email', 'domainreference' ) . ' <small>(always kept private)</small></label><br />' .
		                                                               '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
		                                                               '" size="25"' . $aria_req . ' /></p>',

		                                                               'url' =>
		                                                               '<p class="comment-form-url"><label for="url">' .
		                                                               __( 'Your Website', 'domainreference' ) . ' <small>(optional)</small></label><br />' .
		                                                               '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
		                                                               '" size="25" /></p>'
		                                                          )
		),
	);

	return $args;
}

/**
 * Fix problem with TinyMCE Editor not reloading properly when replying to comments
 * See http://www.revood.com/blog/adding-visual-editor-to-wordpress-comments-box-part-2/
 */
//add_action('wp_enqueue_scripts', '__THEME_PREFIX__scripts');
function __THEME_PREFIX__scripts()
	{
		wp_enqueue_script('jquery');
	}

//add_filter('comment_reply_link', '__THEME_PREFIX__comment_reply_link');
function __THEME_PREFIX__comment_reply_link($link)
	{
		return str_replace('onclick=', 'data-onclick=', $link);
	}

//add_action('wp_head', '__THEME_PREFIX__wp_head');
function __THEME_PREFIX__wp_head()
	{
		?>
		<script type="text/javascript">
			jQuery(function($)
			       {
				       $('.comment-reply-link').click(function(e)
				                                      {
					                                      e.preventDefault();
					                                      var args = $(this).data('onclick');
					                                      args = args.replace(/.*\(|\)/gi, '').replace(/\"|\s+/g, '');
					                                      args = args.split(',');
					                                      tinymce.EditorManager.execCommand('mceRemoveControl', true, 'comment');
					                                      addComment.moveForm.apply(addComment, args);
					                                      tinymce.EditorManager.execCommand('mceAddControl', true, 'comment');
				                                      });
			       });
		</script><?
	}

/*
 * Add support for the footer nav
 */
register_nav_menus(array(
                        'footer' => __('Footer Menu', 'publish'),
                   ));

/*
 * Include JavaScript for Share Buttons
 */
function share_buttons_js()
	{
		wp_enqueue_script(
			'share-buttons_js',
			get_template_directory_uri().'/js/share-buttons.js',
			array('jquery')
		);
	}
add_action('wp_enqueue_scripts', 'share_buttons_js');

/*
 * Show Subscribe to Comments Reloaded options after comment form fields
 */
add_action( 'comment_form_logged_in_after', 'subscribe_reloaded_show' );
add_action( 'comment_form_after_fields', 'subscribe_reloaded_show' );

/*
 * Hide the Twitter handle when adding mentions to posts
 * with Twitter Mentions as Comment Plugin
 */
function tmac_hide_twitter_handle() {
	return TRUE;
}
add_filter('tmac_hide_twitter_handle', 'tmac_hide_twitter_handle');

//add_filter( 'wp_head', 'rd_dynamic_post_title_size');
function rd_dynamic_post_title_size () {
	if (is_single()) :
		$title = get_the_title();
		
		// See http://wordpress.stackexchange.com/questions/11085/truncating-custom-fields#11089
		$title = strip_tags( $title );
    $title = html_entity_decode( $title, ENT_QUOTES, 'utf-8' );
    // \xC2\xA0 is the no-break space
    $title = trim( $title, "\n\r\t .-;–,—\xC2\xA0" );
    $len = strlen( utf8_decode( $title ) );

		if ($len <= 19) {
			$css = '.entry-header h1 { font-size: 4em; }';
		}
		if ($len < 29 && $len > 19) {
			$css = '.entry-header h1 { font-size: 3em; }';
		}
		if ($len == 29) {
			$css = '.entry-header h1 { font-size: 2.9em; }';
		}
		if ($len == 30) {
			$css = '.entry-header h1 { font-size: 2.8em; letter-spacing: -4px;}';
		}
		if ($len == 31) {
			$css = '.entry-header h1 { font-size: 2.7em; }';
		}
		if ($len == 32) {
			$css = '.entry-header h1 { font-size: 2.6em; }';
		}
		if ($len >= 32) {
			$css = '.entry-header h1 { font-size: 2.5em; letter-spacing: -4px;}';
		}
			echo '<style type="text/css">' . $css . '</style>';
	endif;
}

/*
 * Change the comment reply link to use 'Reply to <Author First Name>'
 */
function add_comment_author_to_reply_link($link, $args, $comment){

	$comment = get_comment( $comment );

	// If no comment author is blank, use 'Anonymous'
	if ( empty($comment->comment_author) ) {
		if (!empty($comment->user_id)){
			$user=get_userdata($comment->user_id);
			$author=$user->user_login;
		} else {
			$author = __('Anonymous');
		}
	} else {
		$author = $comment->comment_author;
	}

	// If the user provided more than a first name, use only first name
	if(strpos($author, ' ')){
		$author = substr($author, 0, strpos($author, ' '));
	}

	// Replace Reply Link with "Reply to <Author First Name>"
	$reply_link_text = $args['reply_text'];
	$link = str_replace($reply_link_text, 'Reply to ' . $author, $link);

	return $link;
}
add_filter('comment_reply_link', 'add_comment_author_to_reply_link', 420, 4);
