<?php
function point_font($taille, $angle, $font, $texte, $larg_photo, $haut_photo)
{
	$a = array();
	$rem = imagettfbbox($taille, $angle, $font, $texte);
	
	$larg_font = $rem[2]-$rem[0];
	$haut_font = $rem[7]-$rem[1];
	
	$centre_x_photo = $larg_photo / 2;
	$centre_y_photo = $haut_photo / 2;
	
	$a[0] = $centre_x_photo - $larg_font / 2;
	$a[1] = $centre_y_photo - $haut_font / 2;
	
	return $a;
}

function calcul_font_size($hauteur, $largeur)
{
	$val_min = min($hauteur,$largeur);
	return $val_min/8;
}

function convertColor($color)
{
	#convert hexadecimal to RGB
	if(!is_array($color) && preg_match("/^[#]([0-9a-fA-F]{6})$/",$color))
	{

		$hex_R = substr($color,1,2);
		$hex_G = substr($color,3,2);
		$hex_B = substr($color,5,2);
		$RGB = hexdec($hex_R).",".hexdec($hex_G).",".hexdec($hex_B);

		return $RGB;
	}

	#convert RGB to hexadecimal
	else
	{
		$hex_RGB = '#';
		if(!is_array($color))
			{$color = explode(",",$color);}

		foreach($color as $value){
			$hex_value = dechex($value);
			if(strlen($hex_value)<2)
				{$hex_value="0".$hex_value;}
			$hex_RGB.=$hex_value;
		}

		return $hex_RGB;
	}

}

function fake_img($options){

	//Conversion de la couleur du fond Hexa vers RGB
	$rgb = explode(",",convertColor($options['backcolor']));
	//Création de l'image
	$image = imagecreate($options['largeur'],$options['hauteur']);
	imagecolorallocate($image, $rgb[0],$rgb[1],$rgb[2]);

	//Coordonées du texte pour qu'il soit centré
	$coord = point_font($options['font-size'], 0, $options['font'], $options['text'], $options['largeur'], $options['hauteur']);

	//Dessin du texte
	$rgb = explode(",",convertColor($options['fontcolor']));
	$couleur_text = imagecolorallocate($image, $rgb[0],$rgb[1],$rgb[2]);
	imagettftext($image, $options['font-size'], 0, $coord[0], $coord[1], $couleur_text, $options['font'], $options['text']);

	return $image;
}


/*Vérification des options*/
$options = array(
	'largeur' => 150,
	'hauteur' => 150,
	'backcolor' => '#cccccc',
	'fontcolor' => '#909090',
	'text' => 'Hello World',
	'font' => 'C:\Windows\Fonts\Arial.ttf',
	'font-size' => '25'
	);

if (isset($_GET["largeur"])) {
	$options['largeur'] = $_GET["largeur"];

	if($options['largeur'] < 1)
		$options['largeur'] = 150;
}

if (isset($_GET["hauteur"])) {
	$options['hauteur'] = $_GET["hauteur"];

	if($options['hauteur'] < 1)
		$options['hauteur'] = 150;
}

if (isset($_GET["backcolor"])) {
	$options['backcolor'] = strtolower('#'.$_GET["backcolor"]);

	if (!preg_match( "#^\#(?:(?:[a-f\d]{3}){2})$#" , $options['backcolor']))
	{
		$options['backcolor'] = '#cccccc';
	}
}

if (isset($_GET["fontcolor"])) {
	$options['fontcolor'] = strtolower('#'.$_GET["fontcolor"]);

	if (!preg_match( "#^\#(?:(?:[a-f\d]{3}){2})$#" , $options['fontcolor']))
	{
		$options['fontcolor'] = '#909090';
	}
}

if (isset($_GET["text"])) {
	$options['text'] = $_GET["text"];
}
else
{
	$options['text'] = $options['largeur'] . ' x ' . $options['hauteur'];
}

if (isset($_GET["font"])) {
	$options['font'] = 'C:\\Windows\\Fonts\\'.$_GET["font"].'.ttf';
}

if (isset($_GET["font-size"])) {
	$options['font-size'] = $_GET["font-size"];
}
else
{
	$options['font-size'] = calcul_font_size($options['hauteur'], $options['largeur']);
}

header ("Content-type: image/png");
imagepng(fake_img($options));
?>