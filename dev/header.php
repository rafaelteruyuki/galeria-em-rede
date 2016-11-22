<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width">
	<title>
		<?php
			if(is_single()){
				echo get_bloginfo('name') . ' | ' . get_the_title();
			}else{
				bloginfo('name');
			}?>
	</title>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header>
	<section class="container">

		<a href="<?php bloginfo('url')?>">
			<img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.svg">
		</a>


		<button id="menu-abre"><i class="fa fa-bars" aria-hidden="true"></i></button>

		<nav class="main-menu">
			<button id="menu-fecha"><i class="fa fa-times" aria-hidden="true"></i></button>
			<?php wp_nav_menu( array( 'theme_location' => 'main-menu' ) ); ?>
		</nav>
		<a href="http://www.sp.senac.br/jsp/default.jsp?newsID=0" target="_blank">
			<img src="<?php echo get_template_directory_uri(); ?>/assets/img/senac.svg">
		</a>
	</section>
</header>
