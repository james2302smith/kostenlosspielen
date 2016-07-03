<?php get_header(); ?>
<?php get_sidebar(); ?>
	<div class="col1">
		<?php 
		global $wp_query, $wpdb;
		$counter=0;
		$keyword = trim(strtolower(get_query_var('s')));

		$category_key=array("mahjong","mahjongg","majon","mahjongg","mahjong spiele","mahjongg spiele",
		"solitär","solitär spiele","solitaire",
		"bubble","bubbles","bubble spiele","bubbles spiele",
		"mario", "mario spiele","marios",
		"3 gewinnt", "3gewinnt", "3 gewinnt spiele","drei gewinnt","3 gewint",'jewels','jewel','bejeweled',
		"action","geschicklichkeit","geschick","karten","kartenspiele","mädchen","denken","rennen","rennspiele","sport",
		"schach", "schach spiele","karten spiele","zuma","poker",
		"tetris", "tetris spiele","golf",
		"wimmelbilder", "wimmelbild","wimmelspiele","wimmelbild spiele","wimmel",
		"unblock","unblock me", "blöcke löschen","ritter", "knight","farm", "bauernhof", "bauernhof spiele", "2 Spiele", "2 Spieler",
		"fussball", "fußball","parken","parkspiele","puzzle","auto parken",
		"ballerspiele", "schießen", "schießspiele","schiessen","rollenspiele","rpg",
		"kochspiele", "kochen");
?>

			<div class="box">
			    <div id="leftcontent" class="grid_12">
				  <div style="clear:both;">			    	
			      <div class="category_list">      
					<div class="search_list">
				<?php
				if(in_array($keyword,$category_key)){
					$cat_ID=getCategoryID($keyword);
					//echo $cat_ID;
					$query='SELECT DISTINCT ID, post_title, post_name, f3.meta_value as image
					FROM kostenlosspielen_posts
					JOIN kostenlosspielen_term_relationships ON 
					( kostenlosspielen_posts.ID = kostenlosspielen_term_relationships.object_id ) 
					JOIN kostenlosspielen_term_taxonomy 
					ON ( kostenlosspielen_term_relationships.term_taxonomy_id = kostenlosspielen_term_taxonomy.term_taxonomy_id ) 
					JOIN kostenlosspielen_terms ON ( kostenlosspielen_terms.term_id = kostenlosspielen_term_taxonomy.term_id ) 
					JOIN kostenlosspielen_postmeta f3 ON ( f3.post_id = kostenlosspielen_posts.ID ) 
					WHERE kostenlosspielen_terms.term_id =  \''.$cat_ID.'\'
					AND kostenlosspielen_term_taxonomy.taxonomy =  \'category\'
					AND kostenlosspielen_posts.post_status =  \'publish\'
					AND kostenlosspielen_posts.post_type =  \'post\'
					AND f3.meta_key =  \'image\'
					ORDER BY post_date DESC'; 
					//echo $query;
					$pageposts = $wpdb->get_results($query, ARRAY_A);
					foreach ($pageposts as $post){
					if($counter % 7==0){
						?><div style="clear:both;height:10px;"></div>
					<?php }	?>

					<div class="search_item">
							<div style="border:1px solid #000;"><a title="<?php echo $post['post_title']; ?>" href="<?php echo SITE_ROOT_URL.'/'.$post['post_name']; ?>.html"><img src="<?php echo $post['image'];?>" width="74" height="55" alt="<?php echo $post['post_title'];?>" /></a></div>
							<div><a title="<?php echo $post['post_title'];?>" href="<?php echo SITE_ROOT_URL.'/'.$post['post_name']; ?>.html"><?php echo $post['post_title'];?></a></div>
					</div>

					<?php 
					$counter++;					
					}
				
				}elseif($keyword=='suche nach spielen...'||$keyword==''){
					$args=array( 'orderby' => 'name', 'order' => 'ASC' );
					$categories=get_categories($args);
					echo '<div><img src="'.SITE_ROOT_URL.'/wp-content/uploads/lazy.png" width="32" height="32" alt="Spielname auszufüllen" title="Spielname auszufüllen" /> Sei kein fauler Sack !! Du musst entweder den Namen eines Spiels eingeben.</div>
					<div style="margin-top:10px;">Oder kannst du Spiele von folgenden Kategorien auswählen:</div>';
					foreach($categories as $category) {
						echo '<div class="search_category">
						<div class="search_category_text"><a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __( "Alle Spiele in %s" ), $category->name ) . '" ' . '><img src="'.SITE_ROOT_URL.'/wp-content/themes/twentyten/styles/default/'.$category->slug.'.png" width="40" title="'.$category->name.'" alt="'.$category->name.'" /></a></div>
						<div class="search_category_img"><a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __( "Alle Spiele in %s" ), $category->name ) . '" ' . '>' . $category->name.'</a></div>
						</div>';
					} 
				}else{
				$the_query = new WP_Query( 'showposts=140&post_type=post&post_status=publish&s='.$keyword );
				if($the_query->have_posts()){
					
					while ( $the_query->have_posts() ) : $the_query->the_post();
					if($counter % 7==0){
						?><div style="clear:both;height:10px;"></div>
					<?php }	?>

					<div class="search_item">
							<div style="border:1px solid #000;"><a title="<?php the_title(); ?>" href="<?php the_permalink() ?>" rel="bookmark"><img src="<?php echo get_post_meta($post->ID, "image", $single = true); ?>" width="74" height="55" alt="<?php the_title(); ?>" /></a></div>
							<div><a title="<?php the_title(); ?>" href="<?php the_permalink() ?>" rel="bookmark"><?php echo the_title(); ?></a></div>
					</div>

					<?php 
					$counter++;
					endwhile;	
				}else{
					?>
					<div style="margin: 20px 0 10px;color: #333;font-size: 13px;"><img src="<?php echo SITE_ROOT_URL ?>/wp-content/uploads/crying.png" width="32" height="32"alt="Keine Spiele gefunden" title="Keine Spiele gefunden">Tut uns leid, keine Spiele gefunden.</div>
					
				<div>
					<form method="get" id="searchform" action="<?php echo SITE_ROOT_URL ?>/">
						<div id="search">
							<div class="search_text">
								<input type="text" value="Suche nach Spielen..." onclick="this.value='';" name="s" id="s" />
							</div>
							<input class="btn_image" value="Suche" type=submit />
						</div><!--/search -->
					</form>
				</div>
					<div class="suggest">Suchtipps:</div>
						<ul>
						<li>- Gib mindestens 2 Zeichen ein.</li>
						<li>- Achte darauf, dass alle Wörter richtig geschrieben sind.<li>
						<li>- Suche nach anderen ähnlichen Wörtern.<li>
						<li>- Verwende allgemeine Suchwörter.<li>
						<li>- Verwende weniger Suchwörter.<li>
						</ul>
					<?php 
					}
					
				}
				
				?>

			    <div style="clear:both;height:10px;"></div>

			  	  </div>
			  	  </div><!-- /end of category_list -->
			      <div style="clear:both;height:0px;"></div>
			    </div><!-- /leftcontent --> 
			</div><!--/box-->


	</div><!--/col1-->



<?php get_footer(); ?>	

