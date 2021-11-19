<?php //to test errors, run file in the browser with &debug=true
require('settings_default.php');
$set = $settings;
$setup = false;
if(file_exists('settings.php')){
	include('settings.php');
	foreach($settings as $key => $val){
		$set[$key] = $val;
	}
	$setup = true;
}
if(file_exists('../all_settings.php')){
	include('../all_settings.php');
	if(isset($all_settings['ScribbleByte'])){
		foreach($all_settings['ScribbleByte'] as $key => $val){
			$set[$key] = $val;
		}
		$setup = true;
	}
}
$settings = $set;

require('inc/class.font.php');

$debug = isset($_GET['debug']) && $_GET['debug'] == 'true' ? true : false;
$font = isset($_POST['font']) ? $_POST['font'] : 'Zalgo';// $settings['default_font'];
$text = isset($_POST['text']) ? $_POST['text'] : $settings['default_text'];

$make_font = new Font($font, $text, $debug);
$ret = $make_font->create_text();

if(!$debug)
{
	echo json_encode($ret);
}
