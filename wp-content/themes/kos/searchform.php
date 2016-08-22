<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
	<div class="inner"><!-- add class .open to show Search Dropdown -->
	    <input type="search" class="search-field form-control" placeholder="<?php echo esc_attr_x( 'Suche…', 'placeholder' ) ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>" />
	    <button class="search-submit"><i class="fa fa-search"></i></button>
	    <ul class="dropdown-menu search-dropdown">
	    	<li><a href="#" title="">Lorem ipsum dolor <strong>sit</strong> amet </a></li>
	    	<li><a href="#" title="">Lorem <strong>ipsum</strong> dolor sit amet </a></li>
	    	<li><a href="#" title="">Lorem ipsum dolor sit amet </a></li>
	    	<li><a href="#" title=""><strong>Lorem</strong> ipsum dolor sit amet </a></li>
	    </ul>
	</div>
</form>