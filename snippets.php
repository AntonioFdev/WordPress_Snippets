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
  
    
