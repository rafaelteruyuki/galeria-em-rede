<?php
define( 'WP_USE_THEMES', false );
get_header();

$areas = get_field_object("field_57dc5e9a84f9d");
?>
<div id="wrapper" class="container">

	<article id="galeria-sobre">
		<section>
			<h2>Exposições</h2>
		</section>
	</article>

	<aside>
		<h2>buscar exposição</h2>
		<label for="area">área</label>
		<select id="area" name="area">
			<option value="" selected>Todas as áreas</option>
			<?php foreach($areas['choices'] as $value=>$label): ?>
				<option value="<?php echo $value ?>"><?php echo $label ?></option>
			<?php endforeach; ?>
		</select>
		<label for="area">subárea</label>
		<select id="subarea" name="subarea">
			<option value="" selected>Todas as subáreas</option>
		</select>

		<form method="GET" action="<?php bloginfo('url') ?>" role="search">
      		<input id="campo-pesquisa" type="search" name="s" placeholder="Pesquisar...">
      		<button type="submit">Pesquisar</button>
		</form>
	</aside>

	<main id="exposicoes">
	<?php

	$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

	$args = array(
				'post_type' 		=> 'exposicao',
				'posts_per_page' 	=> -1,
				'paged'				=> $paged
			);

	$query = new WP_Query($args);

	if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();

		$imagem = get_field('imagem-principal-expo');
	?>

		<figure>
			<a href="<?php the_permalink(); ?>">
				<div class="imagem">
					<img src="<?php echo $imagem["sizes"]["medium_large"] ?>" alt="<?php echo $imagem["alt"] ?>">
				</div>
				<figcaption><?php the_title(); ?></figcaption>
			</a>
		</figure>

	<?php endwhile; ?>

	<?php
	wp_reset_postdata();
	else : ?>
		<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
	<?php endif;  ?>
	</main>
</div>

<?php get_footer(); ?>
