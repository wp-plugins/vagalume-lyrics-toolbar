<?php
/**
 * @package Vagalume Toolbar
 */
/*
Plugin Name: Vagalume Toolbar
Plugin URI: http://www.vagalume.com.br
Description: Vagalume Widget Toolbar
Version: 1.0
Author: Vagalume
Author URI: ttp://www.vagalume.com.br
License: 
*/

/*
Copyright Vagalume Midia Ltda. All rights reserved.

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to
deal in the Software without restriction, including without limitation the
rights to use, copy, modify, merge, publish, distribute, sublicense, and/or
sell copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
IN THE SOFTWARE.
*/
define(FILE_DATA,"data-vagalume-toolbar.json");
define(PATH_FILE_SET,"../wp-content/plugins/vagalume_toolbar/".FILE_DATA);
define(PATH_FILE_GET,"wp-content/plugins/vagalume_toolbar/".FILE_DATA);
define(PATH_FILE_PLUGIN,"../wp-content/plugins/vagalume_toolbar/");


// Carregar tela de opções da barra
function toolbar_admin() {  
    include('vagalume_toolbar_admin.php');  
}
// Chamar no menu do admin link para tela de opções
function toolbar_admin_actions() {  
  add_options_page("Vagalume Toolbar - Opções", "Vagalume Toolbar", 'manage_options', "customizar-barra", "toolbar_admin");
}  

add_action('admin_menu', 'toolbar_admin_actions'); 

// carregar toolbar no template
function toolbar_vagalume_toolbar(){
	if(is_file(PATH_FILE_GET) && file_exists(PATH_FILE_GET)){
		$content_artist_bar = file_get_contents(PATH_FILE_GET);
		?><!-- Vagalume Site Layer www.vagalume.com.br/widgets/toolbar/ --><script type="text/javascript" async defer src="http://www.vagalume.com.br/js/widgets/toolbar.js"><?
		echo $content_artist_bar ;
		?></script><?
	}
 }
 add_action('wp_footer', 'toolbar_vagalume_toolbar');
?>