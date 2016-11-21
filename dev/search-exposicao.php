<?php 
define( 'WP_USE_THEMES', false ); 
get_header();

$areas = get_field_object("field_57dc5e9a84f9d");
?>
<div id="wrapper" class="container">
	
	<article id="galeria-sobre">
		<section>
			<img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.svg" alt="Galeria em Rede">
			<p>
				Para incentivar produções culturais locais e conectá-las à comunidade, o Galeria em Rede vai promover exposições com trabalhos de professores, alunos e convidados nas áreas de arte, design, moda, ilustração e fotografia.
			</p>
			<p>
				Além de selecionar e organizar o acervo das unidades, o projeto prevê a realização de exposições itinerantes pela rede do Senac São Paulo.
			</p>
			
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
			<input type="hidden" name="post_type" value="exposicao">
      		<input id="campo-pesquisa" type="search" name="s" placeholder="Pesquisar...">
      		<button type="submit">Pesquisar</button>
		</form>
	</aside>

	<main id="exposicoes">
	<?php if (have_posts() ) : while (have_posts() ) : the_post(); 
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

	<?php endwhile; else : ?>
		<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
	<?php endif; ?>
	</main>
</div>

<?php get_footer(); ?>