<?php 

// CARREGA OS ESTILOS
add_action('wp_enqueue_scripts', 'loadStyles' );
function loadStyles(){
	wp_register_style('font-awesome',  get_template_directory_uri().'/assets/css/font-awesome.css');
	wp_enqueue_style( 'font-awesome' );

	wp_register_style('lightbox',  get_template_directory_uri().'/assets/css/lightbox.min.css');
	wp_enqueue_style( 'lightbox' );
	
	wp_register_style('estilo',  get_template_directory_uri().'/assets/css/estilo.css');
	wp_enqueue_style( 'estilo' );
	
}

// CARREGA OS SCRIPTS
add_action('wp_enqueue_scripts', 'loadScripts' );
function loadScripts(){
	
	wp_enqueue_script( 'lightBox', get_template_directory_uri().'/assets/js/lightbox.js', array('jquery'), '', true );
	
	//scripts do tema
	wp_enqueue_script( 'myScript', get_template_directory_uri().'/assets/js/script.js', array('jquery'), '', true );
	
	// disponibiliza a variavel ajax_url para acesso via javaScript
	wp_localize_script('myScript', 'ajax_object', array(
		'ajax_url' => admin_url('admin-ajax.php'),
		'template_directory_uri' => get_template_directory_uri())
	);
}

// Custom Post-type para Exposição
function register_expo() {

	$labels = array(
		'name'                  => _x( 'Exposições', 'Post Type General Name', 'divi-child' ),
		'singular_name'         => _x( 'Exposição', 'Post Type Singular Name', 'divi-child' ),
		'menu_name'             => __( 'Exposições', 'divi-child' ),
		'name_admin_bar'        => __( 'Exposição', 'divi-child' ),
		'archives'              => __( 'Arquivos de Exposições', 'divi-child' ),
		'parent_item_colon'     => __( 'Exposição Pai:', 'divi-child' ),
		'all_items'             => __( 'Todas as exposições', 'divi-child' ),
		'add_new_item'          => __( 'Adicionar nova exposição', 'divi-child' ),
		'add_new'               => __( 'Adicionar', 'divi-child' ),
		'new_item'              => __( 'Nova exposição', 'divi-child' ),
		'edit_item'             => __( 'Editar', 'divi-child' ),
		'update_item'           => __( 'Atualizar', 'divi-child' ),
		'view_item'             => __( 'Ver', 'divi-child' ),
		'search_items'          => __( 'Porcurar', 'divi-child' ),
		'not_found'             => __( 'Não encontrado', 'divi-child' ),
		'not_found_in_trash'    => __( 'Não encontrado no lixo', 'divi-child' ),
		'featured_image'        => __( 'Imagem Principal', 'divi-child' ),
		'set_featured_image'    => __( 'Definir imagem principal', 'divi-child' ),
		'remove_featured_image' => __( 'Remover imagem principal', 'divi-child' ),
		'use_featured_image'    => __( 'Utilizar como imagem principal', 'divi-child' ),
		'insert_into_item'      => __( 'Inserir na exposição', 'divi-child' ),
		'uploaded_to_this_item' => __( 'Adicionado a esta exposição', 'divi-child' ),
		'items_list'            => __( 'Lista de exposições', 'divi-child' ),
		'items_list_navigation' => __( 'Lista de navegação de exposições', 'divi-child' ),
		'filter_items_list'     => __( 'Filtrar lista de exposições', 'divi-child' ),
	);
	$args = array(
		'label'                 => __( 'Exposição', 'divi-child' ),
		'description'           => __( 'Post Type Description', 'divi-child' ),
		'labels'                => $labels,
		'supports'              => array( 'title'),
		'taxonomies'            => array(),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'menu_icon'				=> 'dashicons-format-gallery'
	);
	register_post_type( 'exposicao', $args );

}
add_action( 'init', 'register_expo', 0 );
// FIM ** Custom Post-type para Exposição

// Registro de Menus
function registerMenus() {
  register_nav_menu('main-menu', 'Menu Principal');
}
add_action( 'init', 'registerMenus');


// AJAX FUNCTIONS

// fazendo a consulta das subarea com base na area passada
add_action('wp_ajax_consulta_consultar_subarea', 'consultaSubarea');
add_action('wp_ajax_nopriv_consultar_subarea', 'consultaSubarea');

function consultaSubarea(){
	$area = $_REQUEST['area'];
	$subarea = 'subarea-' . $area;
	//var_dump($subarea);
	
	$subareaField = acf_get_field($subarea);
	//var_dump(json_encode($subareaField["choices"]));
	
	echo json_encode($subareaField["choices"]);
	
	wp_die();
}


//funcao que consulta o banco e devolve array com as exposicoes
function consultaExposicao($args){
	$query = new WP_Query($args);
	if($query->have_posts()){
		$exposicoes = array();
		
		while($query->have_posts()){
			$query->the_post();
			$img = get_field('imagem-principal-expo');
			//var_dump(get_the_title());
			
			$expo = array(
				'permalink'	=> get_the_permalink(),
				'imgSrc'	=> $img["sizes"]["medium_large"],
				'imgAlt'	=> $img["alt"],
				'title'		=> get_the_title()
			);
			
			array_push($exposicoes, $expo);
		}
	}
	
	return $exposicoes;
}

// consulta as exposicoes com base na AREA passada
add_action('wp_ajax_consulta_consultar_por_area', 'consultarPorArea');
add_action('wp_ajax_nopriv_consultar_por_area', 'consultarPorArea');

function consultarPorArea(){
	$area = $_REQUEST['area'];
	$args = array(
		'post_type' 	 => 'exposicao',
		'order'			 => 'DESC',
		'meta_key'		 => 'area',
		'meta_value'	 => $area,
		'posts_per_page' => -1
	);
	
	echo json_encode(consultaExposicao($args));
	wp_die();
}


// consulta as exposicoes com base na SUBAREA passada
add_action('wp_ajax_consulta_consultar_por_subarea', 'consultarPorSubarea');
add_action('wp_ajax_nopriv_consultar_por_subarea', 'consultarPorSubarea');

function consultarPorSubarea(){
	$subareaKey = $_REQUEST['subareaKey'];
	$subareaValue = $_REQUEST['subareaValue'];
	
	$args = array(
		'post_type' 	 => 'exposicao',
		'order'			 => 'DESC',
		'meta_key'		 => $subareaKey,
		'meta_value'	 => $subareaValue,
		'posts_per_page' => -1
	);
	
	echo json_encode(consultaExposicao($args));
	wp_die();
}