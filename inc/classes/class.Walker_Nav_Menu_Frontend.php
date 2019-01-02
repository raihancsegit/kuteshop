<?php 

class Walker_Nav_Menu_Frontend extends Walker_Nav_Menu{


	public $ourItem;

	public $serial;

	public function __construct(){
		$this->serial = 0;
	}


	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$this->serial = 0;
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = str_repeat( $t, $depth );

		$item = $this->ourItem;

		$menutype = get_post_meta($item->ID, '_submenu_type', true);

		$parentid = intval($item->menu_item_parent);

		$parent_menutype = get_post_meta($parentid, '_submenu_type', true);

		if($parent_menutype == 'column-4' || $parent_menutype == 'column-3' || $parent_menutype == 'categorized'){
			// Default class.
			$classes = array( 'mega-submenu' );
		}else{
			// Default class.
			$classes = array( 'sub-menu' );
		}


		



		/**
		 * Filters the CSS class(es) applied to a menu list element.
		 *
		 * @since 4.8.0
		 *
		 * @param array    $classes The CSS classes that are applied to the menu `<ul>` element.
		 * @param stdClass $args    An object of `wp_nav_menu()` arguments.
		 * @param int      $depth   Depth of menu item. Used for padding.
		 */

		


		$class_names = join( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );

		

		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';


		if($menutype == 'column-4' || $menutype == 'column-3' ){
			$output .= "{$n}{$indent}<div class='mega-menu'><div class='row'><ul>{$n}";
		}elseif($menutype == 'categorized'){
			$output .= "{$n}{$indent}<div class='mega-menu'><div class='row'><ul>{$n}";
		}else{
			$output .= "{$n}{$indent}<ul $class_names>{$n}";
		}

		
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @since 3.0.0
	 *
	 * @see Walker::end_lvl()
	 *
	 * @param string   $output Passed by reference. Used to append additional content.
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function end_lvl( &$output, $depth = 0, $args = array() ) {

		$item = $this->ourItem;

		$menutype = get_post_meta($item->ID, '_submenu_type', true);


		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = str_repeat( $t, $depth );

		if($menutype == 'column-4' || $menutype == 'column-3'){
			$output .= "$indent</ul></div></div>{$n}";
		}elseif($menutype == 'categorized'){
			$output .= "$indent</ul></div></div>{$n}";
		}else{
			$output .= "$indent</ul>{$n}";
		}
		
	}










	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {



		

		$menutype = get_post_meta($item->ID, '_submenu_type', true);


		$this->ourItem = $item;


		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		if( $this->has_children ){
			if($menutype == 'column-4' || $menutype == 'column-3' || $menutype == 'categorized'){
				$classes[] = 'has-mega-menu';
				
			}else{
				$classes[] = 'has-children';
			}
			
		}


		$atts = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
		$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
		$atts['href']   = ! empty( $item->url )        ? $item->url        : '';
		$atts['description']   = ! empty( $item->description )        ? $item->description  : '';
$imageurl = get_post_meta($item->ID, '_submenu_image', true);
		if( !empty($imageurl) ){
			$classes[] = 'menu-item-preview';
		}


		/**
		 * Filters the arguments for a single nav menu item.
		 *
		 * @since 4.4.0
		 *
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param WP_Post  $item  Menu item data object.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		$args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

		/**
		 * Filters the CSS class(es) applied to a menu item's list item element.
		 *
		 * @since 3.0.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array    $classes The CSS classes that are applied to the menu item's `<li>` element.
		 * @param WP_Post  $item    The current menu item.
		 * @param stdClass $args    An object of wp_nav_menu() arguments.
		 * @param int      $depth   Depth of menu item. Used for padding.
		 */
		$parentid = intval($item->menu_item_parent);
		$parent_menutype = get_post_meta($parentid, '_submenu_type', true);

		if( $parent_menutype == 'column-4' ){
			$classes[] = "col-md-3 col-sm-6 col-xs-12";
		}elseif( $parent_menutype == 'column-3' ){
			$classes[] = "col-md-4 col-sm-6 col-xs-12";
		}elseif( $parent_menutype == 'categorized' ){
			$this->serial++;
			if( $this->serial == 1 ){
				$classes[] = "col-md-5";
			}else{
				$classes[] = "col-md-7";
			}
		}

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		/**
		 * Filters the ID applied to a menu item's list item element.
		 *
		 * @since 3.0.1
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param string   $menu_id The ID that is applied to the menu item's `<li>` element.
		 * @param WP_Post  $item    The current menu item.
		 * @param stdClass $args    An object of wp_nav_menu() arguments.
		 * @param int      $depth   Depth of menu item. Used for padding.
		 */
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		if($parent_menutype == 'categorized'){
			$output .= $indent . '<div' . $id . $class_names .'>';
			
		}else{
			$output .= $indent . '<li' . $id . $class_names .'>';
		}

		

		

		/**
		 * Filters the HTML attributes applied to a menu item's anchor element.
		 *
		 * @since 3.6.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array $atts {
		 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
		 *
		 *     @type string $title  Title attribute.
		 *     @type string $target Target attribute.
		 *     @type string $rel    The rel attribute.
		 *     @type string $href   The href attribute.
		 * }
		 * @param WP_Post  $item  The current menu item.
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		/** This filter is documented in wp-includes/post-template.php */
		$title = apply_filters( 'the_title', $item->title, $item->ID );




		/**
		 * Filters a menu item's title.
		 *
		 * @since 4.4.0
		 *
		 * @param string   $title The menu item's title.
		 * @param WP_Post  $item  The current menu item.
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );



		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before . $title . $args->link_after;
		$item_output .= '</a>';

		

		if( !empty($imageurl) ){
			$item_output .= '<div class="preview-image">
								<a href="'.$atts['href'].'"><img src="'.$imageurl.'" alt="" /></a>
							</div>';
		}


		$item_output .= $args->after;

		/**
		 * Filters a menu item's starting output.
		 *
		 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
		 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
		 * no filter for modifying the opening and closing `<li>` for a menu item.
		 *
		 * @since 3.0.0
		 *
		 * @param string   $item_output The menu item's starting HTML output.
		 * @param WP_Post  $item        Menu item data object.
		 * @param int      $depth       Depth of menu item. Used for padding.
		 * @param stdClass $args        An object of wp_nav_menu() arguments.
		 */
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	public function end_el( &$output, $item, $depth = 0, $args = array() ) {

		$parentid = intval($item->menu_item_parent);
		$parent_menutype = get_post_meta($parentid, '_submenu_type', true);


		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}

		if($parent_menutype == 'categorized'){
			$output .= "</div>{$n}";
		}else{
			$output .= "</li>{$n}";
		}
		
	}
}