<?php
/*
Template Name: Partner Seiten
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
<title><?php kos_title(); ?></title>
<?php kos_meta(); ?>
<link rel="stylesheet" type="text/css"  href="<?php echo SITE_ROOT_URL ?>/wp-content/themes/twentyten/style.css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php echo SITE_ROOT_URL ?>/feed/" />
<link rel="pingback" href="<?php echo SITE_ROOT_URL ?>/xmlrpc.php" />
<script type="text/javascript" src="<?php echo SITE_ROOT_URL ?>/wp-content/themes/twentyten/includes/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="<?php echo SITE_ROOT_URL ?>/wp-content/themes/twentyten/includes/js/main.js"></script>
<?php wp_head(); ?>
<script type="text/javascript" src="https://apis.google.com/js/plusone.js">
      {lang:'de', parsetags:'explicit'}
</script>

<!--[if IE]>
<script defer type="text/javascript" src="<?php echo SITE_ROOT_URL ?>/wp-content/themes/twentyten/images/pngfix.js"></script>
<![endif]-->

<link href="https://plus.google.com/110415531968788281581" rel="publisher" />

</head>

<body <?php body_class(); ?>>
<div id="wrapper" class="hfeed">

	<?php 
	/*if ( current_user_can( 'manage_options' ) ) {
     A user with admin privileges 
		dynamic_sidebar( 'first-footer-widget-area' );	
	}*/
	
	?>
	
	<div id="topheader">
		<div class="logo">
			<a href="<?php echo SITE_ROOT_URL ?>/" title="Kostenlos Spielen"><img src="<?php echo SITE_ROOT_URL ?>/wp-content/themes/twentyten/images/kostenlos-spielen.png" alt="Kostenlos spielen" title="Kostenlos Spielen" height="72" width="360" /></a>
		</div>
		<div id="topright">
				<div class="favor">
					<ul>
						<li class="favorite"><a href="javascript:bookmarksite('Kostenlos Spielen', '<?php echo SITE_ROOT_URL ?>/')" rel="nofollow">Bookmark diese Seite</a></li>
						<li class="rss"><a href="<?php echo SITE_ROOT_URL ?>/feed/" rel="nofollow">RSS Abonnieren</a></li>
					</ul>
				</div>
				<div>
					<form method="get" id="searchform" action="<?php echo SITE_ROOT_URL ?>/">
						<div id="search">
							<div class="search_text">
								<input type="text" value="<?php if(trim(wp_specialchars($s,1))!='') echo trim(wp_specialchars($s,1));else echo 'Suche nach Spielen...';?>" onclick="this.value='';" name="s" id="s" />
							</div>
							<input class="btn_image" value="Suche" type=submit />
						</div><!--/search -->
					</form>
				</div>
		</div><!--/rss-->
		
	</div><!--/header -->
						


   <div style="clear:both;"></div>
   <div class="breadcrumbs">
      
      <?php if ( function_exists('yoast_breadcrumb') ) {
  $breadcrumbs = yoast_breadcrumb('<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb">','</span>',false);
  echo $breadcrumbs;
	} ?>      

      
    </div>
	

	<div id="columns"><!-- START MAIN CONTENT COLUMNS -->


<div id="content" class="fullspan">
  <div class="container_16 clearfix">
    <?php get_sidebar(); ?>
    <div id="leftcontent" class="grid_12">
      <div id="post_title">
          <h1>Partner & Empfehlenswerte Seiten</h1>
      </div>        

    </div><!-- /leftcontent --> 
  </div><!-- /container_16 -->
</div><!-- /content -->
<?php get_footer(); ?>