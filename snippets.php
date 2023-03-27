<?php
//Traducir con gettext
add_filter( 'gettext', 'af_filter_gettext', 10, 3 );
function af_filter_gettext( $translated, $original, $domain ) {
    if ( $translated == "Sign up now" ) {
        $translated = "Comprar";
    }
    return $translated;
}


/* redirección a https - codigo a implementar en htacces fuera de las etiquetas begin y end wordpress*/

RewriteEngine On
RewriteCond %{HTTPS} !=on
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301,NE]
Header always set Content-Security-Policy "upgrade-insecure-requests;"

/* fin de redireccinonamiento*/

/* elimiinar enlaces imagenes base de datos*/
DELETE FROM wp_postmeta
WHERE post_id IN
(
SELECT id
FROM wp_posts
WHERE post_type = ‘attachment’
AND  <AQUI ESPECIFICAR EL PATRON A BUSCAR>
);

DELETE FROM wp_posts WHERE post_type = ‘attachment’ AND   <AQUI ESPECIFICAR EL PATRON A BUSCAR>

/* fin*/
    
    
    
// Poner landing para usuarios no logados o actividad para usuarios logados.
if( is_user_logged_in() ) {
  $page = get_page_by_path( 'activity'); 
  update_option( 'page_on_front', $page->ID );
  update_option( 'show_on_front', 'page' );
  }
  else {
  $page = get_page_by_path( 'pagina-inicio' );
  update_option( 'page_on_front', $page->ID );
  update_option( 'show_on_front', 'page' );
  }


// Ajustes del menú en Wordpress. Por ejemplo el depth:
// Ejemplo para el tema composer.
   wp_nav_menu(array(
        'menu'            => $menu,
        'container'       => false,                     // remove nav container
        'container_class' => 'menu clearfix',           // class of container (should you choose to use it)
        'menu_class'      => 'menu clearfix',           // adding custom nav class
        'theme_location'  => 'main-nav',                // where it's located in the theme
        'before'          => '',                        // before the menu
        'after'           => '<span class="pix-dropdown-arrow"></span>', // after the menu
        'link_before'     => '',                        // before each link
        'link_after'      => '',                        // after each link
        'depth'           => 5,                         // limit the depth of the nav
        'fallback_cb'     => '',                        // fallback function
        'walker'          => new Composer_Menu_Extend_Walker()
    ));
  

/* AÑADIR OPCIONES A LA PANTALLA AJUSTES PARA QUE EL CLIENTE PUEDA MODIFICARLAS FACILMENTE (SE INSERTAN EN PLANTILLA MEDIANTE SHORTCODE)  */


add_action('admin_init', 'my_general_section');
function my_general_section() {
	add_settings_section(
		'my_settings_section', // Section ID
		'Horarios', // Section Title
		'my_section_options_callback', // Callback
		'general' //What Page?  This makes the section show up on the General Settings Page
	);

	add_settings_field( // Option 1
		'horario_entre_semana', // Option ID
		'Horario semanal', // Label
		'my_textbox_callback', // !important - This is where the args go!
		'general', // Page it will be displayed (General Settings)
		'my_settings_section', // Name of our section
		array(
			'horario_entre_semana'
		)
	);

	add_settings_field( // Option 1
		'horario_fin_de_semana', // Option ID
		'Horario fin de semana', // Label
		'my_textbox_callback', // !important - This is where the args go!
		'general', // Page it will be displayed (General Settings)
		'my_settings_section', // Name of our section
		array(
			'horario_fin_de_semana'
		)
	);

	register_setting('general','horario_entre_semana', 'esc_attr');
	register_setting('general','horario_fin_de_semana', 'esc_attr');
}

function my_section_options_callback() { // Section Callback
	echo '<p>Datos de la oferta destacada en la Home y Empresa</p>';
}
function my_textbox_callback($args) {  // Textbox Callback
	$option = get_option($args[0]);
	echo '<input style="width:230px;" type="text" id="'. $args[0] .'" name="'. $args[0] .'" value="'.$option.'" />';
}

add_shortcode('horario_entre_semana', 'mostrar_horario_entre_semana');
add_shortcode('horario_fin_de_semana', 'mostrar_horario_fin_de_semana');

function mostrar_horario_entre_semana(){
	$horario=get_option( 'horario_entre_semana' );
	echo $horario;
}

function horario_fin_de_semana(){
	$horario=get_option( 'horario_fin_de_semana' );
	echo $horario;
}
    
/* FIN AÑADIR OPCIONES A LA PANTALLA AJUSTES  */
