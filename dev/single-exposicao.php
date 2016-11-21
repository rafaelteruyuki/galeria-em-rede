<?php get_header(); ?>

<?php
if(have_posts()) : 
	while(have_posts()) : the_post(); 
	
	//var_dump($post);

	$img = get_field('imagem-principal-expo');
	
?>

<link rel="stylesheet" href="<?php echo get_template_directory_uri().'/assets/css/single-exposicao.css'?>">

<article id="main-img">
	<h2><?php the_title(); ?></h2>
	<img src="<?php echo $img['url'] ?>" alt="<?php echo $img['alt'] ?>">
</article>

<article id="galeria" class="container">
	<h3>Galeria de Imagens</h3>
	<section>
		<?php
			$galeria = get_field('imagens_expo'); 
		 	
			foreach($galeria as $img) : ?>
		<figure>
			<a href="<?php echo $img['url'] ?>" data-lightbox="<?php echo $post->post_name; ?>" data-title="<?php echo $img['caption'] ?>">
				<img src="<?php echo $img['sizes']['thumbnail'] ?>" alt="<?php echo $img['alt'] ?>">
			</a>
		</figure>
		<?php endforeach; ?>
	</section>
</article>

<div id="wrapper" class="container">
	<article id="info-geral">
		<section id="info-basica">
			<h3>Informações Básicas</h3>
			<ul>
				<li><strong>Tamanho: </strong> <?php echo get_field('tamanho_expo'); ?></li>
				<dd></dd>

				<li><strong>Validade da Exposição: </strong><?php echo get_field('validade_expo'); ?></li>

				<li><strong>Localização da Exposição: </strong><?php echo get_field('localizacao_expo'); ?></li>
			</ul>
		</section>

		<section id="objetivo">
			<h3>Objetivos da Exposição</h3>
			<?php echo get_field('objetivos_expo'); ?>
		</section>

		<section id="memorial">
			<h3>Memorial Descritivo</h3>
			<?php echo get_field('memorial_expo'); ?>
		</section>
	</article>

	<article id="infra-estrutura">
		<section id="infra">
			<h3>Infraestrutura Necessária</h3>
			<ul><?php 
				$infaItens = get_field('infraestrutura_expo');
				foreach($infaItens as $item):?>
				<li><?php echo $item['infra_item_expo'] ?></li>
				<?php endforeach; ?>
			</ul>
		</section>

		<section id="montagem">
			<h3>Orientações para Montagem e Desmontagem</h3>
			<?php echo get_field('montagem_expo'); ?>
		</section>

		<section id="transporte">
			<h3>Orientações para Transporte</h3>
			<?php echo get_field('transporte_expo'); ?>
		</section>
	</article>

	<article id="comunicacao">
		<section id="orientacoes">
			<h3>Orientações da Comunicação</h3>
			<?php echo get_field('comunicacao_expo'); ?>
		</section>

		<section id="impressao">
			<h3>Orientações para Impressão dos Materiais</h3>
			<?php echo get_field('impressao_expo'); ?>
		</section>

		<section id="imprensa">
			<h3>Materiais para Assessoria de Imprensa</h3>
			<ul>
				<?php 
				$itensAI = get_field('imprensa_expo');
				foreach($itensAI as $item) : ?>
				<li>
					<img src="<?php echo $item['material_ai_expo']['icon'] ?>">
					<a href="<?php echo $item['material_ai_expo']['url'] ?>" target="_blank" download>
						<?php echo $item['material_ai_expo']['filename'] ?>
					</a>
				</li>
				<?php endforeach; ?>
			</ul>
		</section>
	</article>
</div>


<?php endwhile; endif; ?>


<?php get_footer(); ?>