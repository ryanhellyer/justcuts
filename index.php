<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'justcuts' ); ?></a>

<header id="site-header" role="banner">
	<div class="site-branding">
		<?php

		// Only use H1 tag for home page, since all other pages have their own H1 tag.
		if ( is_home() ) {
			echo '<h1>';
		}

		echo '<a id="page-title" href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" rel="home">';
		bloginfo( 'name' );
		echo '</a>';

		// Only use H1 tag for home page, since all other pages have their own H1 tag.
		if ( is_home() ) {
			echo '</h1>';
		}

		?>
		<h2><?php bloginfo( 'description' ); ?></h2>
	</div><!-- .site-branding -->
</header><!-- #site-header -->

<main id="main">

<div id="content-area">
	<div id="site-content" role="main"><?php

// If on search page, then display what we searched for
if ( is_search() ) { ?>
		<h1 class="page-title">
			<?php printf( esc_html__( 'Search Results for: "%s" ...', 'justcuts' ), get_search_query() ); ?>
		</h1><!-- .page-title --><?php
}

// Set heading tags
if ( is_home() || is_search() ) {
	$post_heading_tag = 'h2';
} else {
	$post_heading_tag = 'h1';
}

// Load main loop
if ( have_posts() ) {

	// Start of the Loop
	while ( have_posts() ) {
		the_post();
		?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<header class="entry-header">
				<<?php echo $post_heading_tag; // WPCS: XSS OK. ?> class="entry-title"><?php

					// Don't display links on singular post titles
					if ( is_singular() ) {
						the_title();
					} else {
						?><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'justcuts' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a><?php
					}

					?></<?php echo $post_heading_tag; // WPCS: XSS OK. ?>><!-- .entry-title -->
			</header><!-- .entry-header -->

			<div class="entry-content"><?php

				// Display full content for home page and single post pages
				if ( is_home() || is_singular() ) {
					the_content( esc_html__( 'Continue reading <span class="meta-nav">&rarr;</span>', 'justcuts' ) );
					wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'justcuts' ), 'after' => '</div>' ) );
				} else {

					// Use the built in thumbnail system, otherwise attempt to display the latest attachment
					if ( has_post_thumbnail() ) {
						the_post_thumbnail( 'hellish-simplicity-excerpt-thumb' );
					} elseif ( function_exists( 'get_the_image' ) ) {
						get_the_image( array( 'size' => 'thumbnail' ) );
					}
					the_excerpt();
				}
				?>
			</div><!-- .entry-content -->

		</article><!-- #post-<?php the_ID(); ?> --><?php

		// If comments are open or we have at least one comment, load up the comment template
		if ( comments_open() || '0' != get_comments_number() ) {
			comments_template( '', true );
		}

	}

}
else {
	get_template_part( 'template-parts/no-results' );
}
?>

	</div><!-- #site-content --><?php

	// Show sidebar if not on full width template
	if ( 'full-width.php' != basename( get_page_template() ) ) {
		get_template_part( 'template-parts/sidebar' );
	}

	?>
</div><!-- #content-area -->


</main><!-- #main -->

<footer id="site-footer" role="contentinfo">
	<div class="site-info">
		<?php _e( 'Copyright', 'justcuts' ); ?> &copy; <?php bloginfo( 'name' ); ?> <?php echo date( 'Y' ); ?>. 
		<?php printf( esc_html__( 'WordPress theme by %s.', 'justcuts' ), '<a href="https://geek.hellyer.kiwi/" title="Ryan Hellyer">Ryan Hellyer</a> and <a href="https://github.com/pachacamac">Marc</a>' ); ?>
	</div><!-- .site-info -->
</footer><!-- #site-footer -->

<?php wp_footer(); ?>

</body>
</html>