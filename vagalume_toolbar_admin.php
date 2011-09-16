<?php
/**
 * @package Vagalume Toolbar
 */
$ar				= "";
$theme			= "";
$url			= "";
$cust_logo		= "";

if(file_exists(PATH_FILE_SET) && is_file(PATH_FILE_SET)){
	$content_file = json_decode(file_get_contents(PATH_FILE_SET), true);
	$art	= $content_file["toolbar"]["artist"];
	$theme	= $content_file["theme"];
	$url	= $content_file["toolbar"]["artistUrl"];
	$cust_logo	= $content_file["toolbar"]["customLogo"];	
}

$submit_form = $_POST["Submit"];
if( $submit_form){
	$art		= strip_tags($_POST["art"]);
	$theme		= strip_tags($_POST["theme"]);
	$url		= strip_tags($_POST["url_art"]);
	$cust_logo	= strip_tags($_POST["cust_logo"]);
	
	if( strlen($art) && strlen($url) ){		
		$data_file	= '{"theme":"'.$theme.'","toolbar":{"artist":"'.$art.'","artistUrl":"'.$url.'"'.( $cust_logo!=""? ',"customLogo":"'.$cust_logo.'"' : '' ).'}}';
		file_put_contents(PATH_FILE_SET, $data_file);
	}
 }
?>
<div class="wrap">  
	<div style="width:100%;height:70px;clear:both;border-bottom:1px solid #DFDFDF;">
		<img src="<?php echo PATH_FILE_PLUGIN?>vagalume_toolbar.gif" style="float:left;margin:10px;" />
		<?php   echo '<h2 style="line-height:60px;">Opções para Vagalume Toolbar</h2>'; ?>  
	</div>
	<form id="set_artist_bar" name="set_artist_bar" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">  
		<fieldset>
			<input type="hidden" id="url_art" name="url_art" value="<?php echo htmlspecialchars($url)?>">  
			<input type="hidden" id="art" name="art" value="<?php echo htmlspecialchars($art)?>">  
			<h4>Defina o artista para mostrar suas informações na Toolbar.</h4>
			<p>* Artista: <span id="selected-artist"><?php echo htmlspecialchars($art)?></span>
			<span class="submit"><input type="button" id="open-search" name="opne-search" value="Trocar/Definir artista" /></span>
			</p> 
			<p id="box-search" style="display:none;">
			<input id="artist" type="text" name="artist" value=""/><span class="submit"><input type="button" id="search-artist" name="search-artist" value="Buscar/validar artista no Vagalume" /></span><br /><span style="padding:5px 0px;" id="search-result-cointainer"></span>
			</p>
			<p>
			Escolha o tema:
			<select name="theme">
				<option value="dark" <?php echo ( $theme=="dark"? 'selected="selected"' : "" )?>>Escuro</option>
				<option value="light" <?php echo ( $theme=="light"? 'selected="selected"' : "" )?>>Claro</option>
			</select>
			</p>
			<p>Endereço do logotipo do seu site (150x40):<br /><input type="text" size="54" name="cust_logo" value="<?php echo htmlspecialchars($cust_logo)?>"/></p>
			<p class="submit">  
			<input id="submit-form-artist" type="submit" name="Submit" value="<?php _e('Carregar opções', 'sitelayer' ) ?>" /> * campos obrigatórios 
			</p>
		</fieldset>		
	</form>  
</div>
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript"><!--
	  // You may specify partial version numbers, such as "1" or "1.3",
	  //  with the same result. Doing so will automatically load the 
	  //  latest version matching that partial revision pattern 
	  //  (e.g. 1.3 would load 1.3.2 today and 1 would load 1.6.2).
	  google.load("jquery", "1.6.2");
	 
	  google.setOnLoadCallback(function() {
		// Place init code here instead of $(document).ready()
		$(document).delegate('#open-search','click',function(){
			$("#search-result-cointainer").html("");
			$("#box-search").show();
		});
		$(document).delegate('#search-artist','click',function(){
			var art = $("#artist").val();
			if( art==""){
				$("#search-result-cointainer").html('<b style="color:#C44823;">Você precisa digitar um nome de artista para poder buscar!</b>');
				$("#url_art").val("");
				return false ;
			}
			var content_search = "";
			$("#search-result-cointainer").html("");		
			$.getJSON("http://www.vagalume.com.br/api/search.php?art="+encodeURIComponent(art)+"&callback=?", function(data){
				
				if(typeof(data.art)!= "undefined"){
					content_search = '<i style="color:#738C5C;">Artista encontrado: ' + data.art.name + '. Para usá-lo na Toolbar basta clicar em "Carregar opções".</i>';
					$("#art").val(data.art.name);
					$("#artist").val(data.art.name);
					$("#url_art").val(data.art.url);						
				}
				else{
					content_search = '<b style="color:#C44823;">Nenhum artista encontrado!</b>';				
					$("#selected-artist").val("");		
				}
				$("#search-result-cointainer").html(content_search);
			});		
		});
		
		$('#set_artist_bar').submit(function(){
			var art = $("#art").val();
			var url = $("#url_art").val();
			if( art=="" || url==""){
				$("#search-result-cointainer").html('<b style="color:#C44823;">Você precisa definir/validar um artista!</b>');				
				return false ;
			}
		});
		
	  });
//--></script>

