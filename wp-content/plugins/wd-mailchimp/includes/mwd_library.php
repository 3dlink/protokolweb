<?php

class MWD_Library {
	////////////////////////////////////////////////////////////////////////////////////////
	// Events                                                                             //
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	// Constants                                                                          //
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	// Variables                                                                          //
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	// Constructor & Destructor                                                           //
	////////////////////////////////////////////////////////////////////////////////////////
	public function __construct() {
	}

	////////////////////////////////////////////////////////////////////////////////////////
	// Public Methods                                                                     //
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	// Getters & Setters                                                                  //
	////////////////////////////////////////////////////////////////////////////////////////
	public static function get($key, $default_value = '') {
		if (isset($_GET[$key])) {
			$value = $_GET[$key];
		}
		elseif (isset($_POST[$key])) {
			$value = $_POST[$key];
		}
		else {
			$value = '';
		}
		if (!$value) {
			$value = $default_value;
		}
		return esc_html($value);
	}

	public static function message_id($message_id) {
		if ($message_id) {
			switch($message_id) {
				case 1: {
					$message = 'Item Succesfully Saved.';
					$type = 'updated';
					break;
				}
				case 2: {
					$message = 'Error. Please install plugin again.';
					$type = 'error';
					break;
				}
				case 3: {
					$message = 'Item Succesfully Deleted.';
					$type = 'updated';
					break;
				}
				case 4: {
					$message = "You can't delete default theme";
					$type = 'error';
					break;
				}
				case 5: {
					$message = 'Items Succesfully Deleted.';
					$type = 'updated';
					break;
				}
				case 6: {
					$message = 'You must select at least one item.';
					$type = 'error';
					break;
				}
				case 7: {
					$message = 'The item is successfully set as default.';
					$type = 'updated';
					break;
				}
				case 8: {
					$message = 'Options Succesfully Saved.';
					$type = 'updated';
					break;
				}
			
				case 9: {
					$message = 'User Succesfully Unsubcribed.';
					$type = 'updated';
					break;
				}
				case 10: {
					$message = "We've run into an error. The security check didn't pass. Please try again.";
					$type = 'error';
					break;
				}
				case 11: {
					$message = "MailChimp API Cache successfully cleared.";
					$type = 'updated';
					break;
				}
				case 12: {
					$message = "It looks like you need to re-validate your MailChimp API key before you can continue.";
					$type = 'error';
					break;
				}
				case 13: {
					$message = "It looks like you are not subscribed. Please clear cache and come back.";
					$type = 'error';
					break;
				}
			}
			return '<div style="width:99%"><div class="' . $type . '"><p><strong>' . $message . '</strong></p></div></div>';
		}	
	}

	public static function message($message, $type, $form_id = 0) {
		return '<div class="mwd-form-message'. $form_id .' mwd-'. $type .'"><div >' . $message . '</div></div>';
	}

	public static function search($search_by, $search_value, $form_id) {
		?>
		<div class="mwd-search-panel">
			<script>
				function mwd_search() {
					document.getElementById("page_number").value = "1";
					document.getElementById("search_or_not").value = "search";
					document.getElementById("<?php echo $form_id; ?>").submit();
				}
				function mwd_reset() {
					if (document.getElementById("search_value")) {
						document.getElementById("search_value").value = "";
					}
					if (document.getElementById("search_select_value")) {
						document.getElementById("search_select_value").value = 0;
					}
					document.getElementById("<?php echo $form_id; ?>").submit();
				}
			</script>
			<div class="mwd-search">
				<span><?php echo $search_by; ?>:</span>
				<span class="mwd-arrow mwd-arrow-left">
					<input type="text" id="search_value" name="search_value" value="<?php echo esc_html($search_value); ?>"/>
				</span>
				<span class="mwd-icon search-icon" onclick="mwd_search(); return false;"></span>
				<span class="mwd-icon reset-icon" onclick="mwd_reset(); return false;"></span>
			</div>
		</div>
		<?php
	}

	public static function search_select($search_by, $search_select_value, $playlists, $form_id, $elem) {
		?>
		<div class="mwd-search-panel">
			<script>
				function mwd_search_select() {
					document.getElementById("page_number").value = "1";
					document.getElementById("search_or_not").value = "search";
					document.getElementById("<?php echo $form_id; ?>").submit();
				}
			</script>
			<div class="mwd-search">
				<span><?php echo $search_by; ?>:</span>
				<span class="mwd-arrow mwd-arrow-left">
					<select id="search_select_value_<?php echo $elem; ?>" name="search_select_value_<?php echo $elem; ?>" onchange="mwd_search_select();">
						<?php 
						foreach ($playlists as $id => $playlist) { ?>
							<option value="<?php echo $id; ?>" <?php echo (($search_select_value == $id) ? 'selected="selected"' : ''); ?>><?php echo $playlist; ?></option>
						<?php } ?>
					</select>
				</span>
			</div>
		</div>
		<?php
	}

	public static function html_page_nav($count_items, $page_number, $form_id, $items_per_page = 20) {
		$limit = 20;
		if ($count_items) {
			if ($count_items % $limit) {
				$items_county = ($count_items - $count_items % $limit) / $limit + 1;
			}
			else {
				$items_county = ($count_items - $count_items % $limit) / $limit;
			}
		}
		else {
			$items_county = 1;
		}
		?>
		<script type="text/javascript">
			var items_county = <?php echo $items_county; ?>;
			function mwd_page(x, y) {       
				switch (y) {
					case 1:
						if (x >= items_county) {
							document.getElementById('page_number').value = items_county;
						}
						else {
							document.getElementById('page_number').value = x + 1;
						}
					break;
					case 2:
						document.getElementById('page_number').value = items_county;
					break;
					case -1:
						if (x == 1) {
							document.getElementById('page_number').value = 1;
						}
						else {
							document.getElementById('page_number').value = x - 1;
						}
					break;
					case -2:
						document.getElementById('page_number').value = 1;
					break;
					default:
						document.getElementById('page_number').value = 1;
				}
				document.getElementById('<?php echo $form_id; ?>').submit();
			}
			
			function check_enter_key(e) {
				var key_code = (e.keyCode ? e.keyCode : e.which);
				if (key_code == 13) {
					if (jQuery('#current_page').val() >= items_county) {
						document.getElementById('page_number').value = items_county;
					}
					else {
						document.getElementById('page_number').value = jQuery('#current_page').val();
					}
					document.getElementById('<?php echo $form_id; ?>').submit();
				}
				return true;
			}
		</script>
		<div class="tablenav-pages">
			<span class="displaying-num">
			<?php
				if ($count_items != 0) {
					echo $count_items; ?> item<?php echo (($count_items == 1) ? '' : 's');
				}
			?>
			</span>
			<?php
			if ($count_items > $items_per_page) {
				$first_page = "first-page";
				$prev_page = "prev-page";
				$next_page = "next-page";
				$last_page = "last-page";
				if ($page_number == 1) {
					$first_page = "first-page disabled";
					$prev_page = "prev-page disabled";
					$next_page = "next-page";
					$last_page = "last-page";
				}
				if ($page_number >= $items_county) {
					$first_page = "first-page ";
					$prev_page = "prev-page";
					$next_page = "next-page disabled";
					$last_page = "last-page disabled";
				}
				?>
				<span class="pagination-links">
					<a class="<?php echo $first_page; ?>" title="Go to the first page" href="javascript:mwd_page(<?php echo $page_number; ?>,-2);">«</a>
					<a class="<?php echo $prev_page; ?>" title="Go to the previous page" href="javascript:mwd_page(<?php echo $page_number; ?>,-1);">‹</a>
					<span class="paging-input">
						<span class="total-pages">
							<input class="current_page" id="current_page" name="current_page" value="<?php echo $page_number; ?>" onkeypress="return check_enter_key(event)" title="Go to the page" type="text" size="1" />
						</span> of 
						<span class="total-pages">
							<?php echo $items_county; ?>
						</span>
					</span>
					<a class="<?php echo $next_page ?>" title="Go to the next page" href="javascript:mwd_page(<?php echo $page_number; ?>,1);">›</a>
					<a class="<?php echo $last_page ?>" title="Go to the last page" href="javascript:mwd_page(<?php echo $page_number; ?>,2);">»</a>
				</span>
				<?php
			}
			?>
		</div>
		<input type="hidden" id="page_number" name="page_number" value="<?php echo ((isset($_POST['page_number'])) ? (int) $_POST['page_number'] : 1); ?>" />
		<input type="hidden" id="search_or_not" name="search_or_not" value="<?php echo ((isset($_POST['search_or_not'])) ? esc_html($_POST['search_or_not']) : ''); ?>"/>
		<?php
	}


	public static function mwd_redirect($url) {
		$url = html_entity_decode(wp_nonce_url($url, 'nonce_mwd', 'nonce_mwd')); ?>
		<script>
			window.location = "<?php echo $url; ?>";
		</script>
		<?php
		exit();
	}
	
	public static function mwd_get_google_fonts() {
		$google_fonts = array( 'Open Sans' => 'Open Sans', 'Oswald' => 'Oswald', 'Droid Sans' => 'Droid Sans', 'Lato' => 'Lato', 'Open Sans Condensed' => 'Open Sans Condensed', 'PT Sans' => 'PT Sans', 'Ubuntu' => 'Ubuntu', 'PT Sans Narrow' => 'PT Sans Narrow', 'Yanone Kaffeesatz' => 'Yanone Kaffeesatz', 'Roboto Condensed' => 'Roboto Condensed', 'Source Sans Pro' => 'Source Sans Pro', 'Nunito' => 'Nunito', 'Francois One' => 'Francois One', 'Roboto' => 'Roboto', 'Raleway' => 'Raleway', 'Arimo' => 'Arimo', 'Cuprum' => 'Cuprum', 'Play' => 'Play', 'Dosis' => 'Dosis', 'Abel' => 'Abel', 'Droid Serif' => 'Droid Serif', 'Arvo' => 'Arvo', 'Lora' => 'Lora', 'Rokkitt' => 'Rokkitt', 'PT Serif' => 'PT Serif', 'Bitter' => 'Bitter', 'Merriweather' => 'Merriweather', 'Vollkorn' => 'Vollkorn', 'Cantata One' => 'Cantata One', 'Kreon' => 'Kreon', 'Josefin Slab' => 'Josefin Slab', 'Playfair Display' => 'Playfair Display', 'Bree Serif' => 'Bree Serif', 'Crimson Text' => 'Crimson Text', 'Old Standard TT' => 'Old Standard TT', 'Sanchez' => 'Sanchez', 'Crete Round' => 'Crete Round', 'Cardo' => 'Cardo', 'Noticia Text' => 'Noticia Text', 'Judson' => 'Judson', 'Lobster' => 'Lobster', 'Unkempt' => 'Unkempt', 'Changa One' => 'Changa One', 'Special Elite' => 'Special Elite', 'Chewy' => 'Chewy', 'Comfortaa' => 'Comfortaa', 'Boogaloo' => 'Boogaloo', 'Fredoka One' => 'Fredoka One', 'Luckiest Guy' => 'Luckiest Guy', 'Cherry Cream Soda' => 'Cherry Cream Soda', 'Lobster Two' => 'Lobster Two', 'Righteous' => 'Righteous', 'Squada One' => 'Squada One', 'Black Ops One' => 'Black Ops One', 'Happy Monkey' => 'Happy Monkey', 'Passion One' => 'Passion One', 'Nova Square' => 'Nova Square', 'Metamorphous' => 'Metamorphous', 'Poiret One' => 'Poiret One', 'Bevan' => 'Bevan', 'Shadows Into Light' => 'Shadows Into Light', 'The Girl Next Door' => 'The Girl Next Door', 'Coming Soon' => 'Coming Soon', 'Dancing Script' => 'Dancing Script', 'Pacifico' => 'Pacifico', 'Crafty Girls' => 'Crafty Girls', 'Calligraffitti' => 'Calligraffitti', 'Rock Salt' => 'Rock Salt', 'Amatic SC' => 'Amatic SC', 'Leckerli One' => 'Leckerli One', 'Tangerine' => 'Tangerine', 'Reenie Beanie' => 'Reenie Beanie', 'Satisfy' => 'Satisfy', 'Gloria Hallelujah' => 'Gloria Hallelujah', 'Permanent Marker' => 'Permanent Marker', 'Covered By Your Grace' => 'Covered By Your Grace', 'Walter Turncoat' => 'Walter Turncoat', 'Patrick Hand' => 'Patrick Hand', 'Schoolbell' => 'Schoolbell', 'Indie Flower' => 'Indie Flower' );
		return $google_fonts;
	}

	
	////////////////////////////////////////////////////////////////////////////////////////
	// Private Methods                                                                    //
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	// Listeners                                                                          //
	////////////////////////////////////////////////////////////////////////////////////////
}