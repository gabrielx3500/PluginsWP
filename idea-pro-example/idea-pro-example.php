<?php
/**
*Plugin Name: Idea Pro Example Plugin
*Description: This is just an example plugin
**/

function ideapro_example_function(){

  $content = "This is a very simple plugin";
  $content .="<div>This is a div</div>";
  $content .= "<p>This is a block of paragraph text.</p>";
  //print $information;
  return $content;
}
add_shortcode('example','ideapro_example_function');//Con este codigo 
                                                    //agregarmos el shortcode 
                                                   //a cualquier parte de un post
                                                 


function ideapro_admin_menu_option(){ //este codigo crea un elemento nuevo en el Menu lateral de WordPress

	add_menu_page('Header & Footer Scripts','Site Scripts','manage_options','ideapro_admin_menu','ideapro_scripts_page','',200);
}
add_action('admin_menu','ideapro_admin_menu_option');

function ideapro_scripts_page()//Esto es lo que aparece en la pagina en blanco de WordPress
{                             //Un Formulario es creado y llamadao con esta funcion

  if(array_key_exists('submit_scripts_update', $_POST))
  {
    update_option('ideapro_header_scripts',$_POST['']);
    update_option('ideapro_footer_scripts',$_POST['']);

    ?>
  <div id = "setting-error-settings-updated" class="updated_settings_error notice is-dismissible"><strong></strong>Settings have been saved.</div>
<?php
  }

  $header_scripts = get_option('ideapro_header_scripts','none');
  $footer_scripts = get_option('ideapro_footer_scripts','none');


?>

<div class="wrap"><!--Este es el formulario que aparece en la pagina en blanco de WordPress-->
  <h2>Update Scripts</h2>
  <form method = "post" action ="">
  <label for="header_scripts">Header Scripts</label>
  <textarea name ="header_scripts" class="large-text"><?php print $header_scripts; ?></textarea>
  <label for="footer_scripts">Footer Scripts</label>
  <textarea name ="footer_scripts" class="large-text"><?php print $footer_scripts; ?></textarea>
  <input type = "submit" name = "submit_scripts_update" class ="button button-primary" value = "UPDATE SCRIPTS">
</form>
</div>	

<?php

}

function ideapro_display_header_scripts(){

	$header_scripts = get_option('ideapro_header_scripts','none');
	print $header_scripts;

}

add_action('wp_head','ideapro_display_header_scripts');

function ideapro_display_footer_scripts(){

	$footer_scripts = get_option('ideapro_footer_scripts','none');
	print $footer_scripts;

}

add_action('wp_footer','ideapro_display_footer_scripts');


//Codigo para crear un Formulario de Contacto
//Podemos ubicarlo en cualquier pagina o post que nostros queramos
/* Parte 3 del tutorial*/
function ideapro_form ()
{
  /* content variable*/
  $content = '';
  $content .= '<form method="post" action = "http://localhost/practica/thank-you/">';

  $content .= '<input type = "text" name = "full_name" placeholder = "Your Full Name"/>';
  $content .= '<br/>';

  $content .= '<input type = "text" name = "email_address" placeholder = "Your Full Email Address"/>';
  $content .= '<br/>';

  $content .= '<input type = "text" name = "phone_number" placeholder = "Your Full Number"/>';
  $content .= '<br/>';

  $content .= '<textarea name = "comments" placeholder = "Give us your comments"></textarea>';
  $content .= '<br/>';

  $content .= '<input type = "submit" name = "ideapro_submit_form" value = "SUBMIT YOUR INFORMATION"/>';
  $content .= '<br/>';

  $content .= '</form>';
  return $content;

}
//Short_code
add_shortcode('ideapro_contact_form','ideapro_form');


function set_html_content_type()
 {
 	return 'text/html';
 }
//Funcion para el envio de los datos del formulario

function ideapro_form_capture()
 {
 	 global $post, $wpdb;

 	if (array_key_exists('ideapro_submit_form',$_POST))
 	 {
 	 	$to = "support@ideapro.com";
 	 	$subject = "Idea Pro Example Site Form Submission";
 	 	$body = '';

 	 	$body .= 'Name: '.$_POST['full_name'].'<br/>';
 	 	$body .= 'Email: '.$_POST['email_address'].'<br/>';
 	 	$body .= 'Phone: '.$_POST['phone_number'].'<br/>';
 	 	$body .= 'Comments: '.$_POST['comments'].'<br/>';

        add_filter('wp_mail_content_type','set_html_content_type');
 	 	//wp_email($to,$subject,$body); Activamos esta funcion solo si estamos en un sitio en Internet
        remove_filter('wp_mail_content_type','set_html_content_type');

        /* Inserta la informacion en los comentarios*/
        /*
        $time = current_time('mysql');

        $data = array(
        'comment_post_ID' => $post->ID,
        'comment_content' => $body,
        'comment_author_IP' => $_SERVER['REMOTE_ADDR'],
        'comment_date' => $time,
        'comment_approved' => 1,
        );

wp_insert_comment($data); */

/* Agrega los comentarios en la tabla wp_form_submissions*/

         $inserData = $wpdb->get_results(" INSERT INTO ".$wpdb->prefix."form_submissions (data) VALUES ('".$body."')");
 	 }	

 }
 add_action('wp_head','ideapro_form_capture');


?>


<!--Este codigo funciona perfectamente si esta en un servidor en Internet-->
