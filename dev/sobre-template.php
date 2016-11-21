<?php
/*
	Template Name: Sobre 
*/


 
define( 'WP_USE_THEMES', false ); 
get_header();


if(have_posts()): while(have_posts()): the_post();
?>
<div id="wrapper" class="container">
	<article id="galeria-sobre">
		<section>
			<img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.svg" alt="Galeria em Rede">
			
			<?php the_content(); ?>

		</section>
	</article>

</div>

<?php endwhile; endif; ?>

<?php get_footer(); ?>