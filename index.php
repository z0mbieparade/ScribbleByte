<?php
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
  <title><?php echo $settings['title']; ?></title>
	<?php
	  $card = $settings['ScribbleByte_site_path'] . "css/card_img.png";
	  $url = $settings['ScribbleByte_site_path'];
	?>
  <meta property="og:title" content="<?php echo $settings['title']; ?>">
  <meta property="og:description" content="Type in different ASCII fonts.">
  <meta property="og:image" content="<?php echo $card; ?>">
  <meta property="og:url" content="<?php echo $url; ?>">
  <meta property="og:type" content="website">

  <meta name="twitter:title" content="<?php echo $settings['title']; ?>">
  <meta name="twitter:description" content="Type in different ASCII fonts.">
  <meta name="twitter:image" content="<?php echo $card; ?>">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:creator" content="@rotterz">

	<link rel="apple-touch-icon" sizes="180x180" href="css/favicon_io/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="css/favicon_io/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="css/favicon_io/favicon-16x16.png">
	<link rel="manifest" href="css/favicon_io/site.webmanifest">

	<?php
	$cache = 0;
	if(getenv('APP_SITE_LIVE') != "true"){
	  $cache = rand(0,9999);
	}
	?>
	<link href="<?php echo $settings['ScribbleByte_site_path'] . 'css/base.css?v=' . $cache; ?>" rel="stylesheet">
	<link href="<?php echo $settings['ScribbleByte_site_path'] . 'css/style.css?v=' . $cache; ?>" rel="stylesheet">

  <body>
    <script>
			<?php if(!$setup){ ?>
				console.log('You have not created your settings.php file, please copy settings_default.php to settings.php and update it with correct settings.');
			<?php }?>
      let site_url = "<?php echo $settings['ScribbleByte_site_path']; ?>";
    </script>

		<div id="top">
			<div id="info">
				<p>Just a little app for creating custom ASCII text by <a href="https://z0m.bi" target="_blank">z0m.bi</a></p>

				<p>You can adjust specific letter x,y coordinates by clicking the <span class="fg09">▲ ▼ ◀ ▶</span> you see when hovering over a letter.</p>

			</div>
			<textarea id="for_typing"><?php echo $settings['default_text']; ?></textarea>
		</div>


		<div id="settings">

			<span class="instruct">Font settings:</span>
			<div id="inputs">
				<label for="font">Font:</label>
				<select id="font">
					<?php
						$fonts = scandir('fonts');
						foreach($fonts as $font)
						{
							if(!preg_match('/\.(txt)$/', $font)) continue;
							$arr = explode('.', $font);

							echo '<pre>' . $settings['default_font'] . ' ' . $arr[0] . '</pre>';

							if($arr[0] === $settings['default_font'])
							{
								echo '<option value="' . $arr[0] . '" selected="selected">' . $arr[0] . '</option>';
							}
							else
							{
								echo '<option value="' . $arr[0] . '">' . $arr[0] . '</option>';
							}
						}
					?>
				</select>

				<label for="letter_spacing">Letter Spacing: <input id="letter_spacing" type="number" style="width:3rem" /></label>
				<label for="line_height">Line Height: <input id="line_height" type="number" style="width:3rem" /></label>
				<label for="space_width">Space Width: <input id="space_width" type="number" style="width:3rem" /></label>
				<label for="not_found">Char Not Found: <input id="not_found" value="" style="width:5rem" /></label>
				<label for="font_size">Font Size: <input id="font_size" type="number" min="0" style="width:3rem" />rem</label>

				<label for="muck_amount">Muck Amount: <input id="muck_amount" type="number" style="width:3rem" /></label>
				<label for="muck_chars">Muck Chars: <input id="muck_chars" value="" style="width:5rem" /></label>
				<label for="zalgo_above">Zalgo Above: <input id="zalgo_above" type="checkbox" /></label>
				<label for="zalgo_lative_above">Zalgo Latin Above: <input id="zalgo_lative_above" type="checkbox" /></label>
				<label for="zalgo_over">Zalgo Over: <input id="zalgo_over" type="checkbox" /></label>
				<label for="zalgo_below">Zalgo Below: <input id="zalgo_below" type="checkbox" /></label>

			</div>

			<span class="instruct" id="instruct_letters">Adjust specific letter placement:</span>
			<div id="edit_ascii">
			</div>

			<div class="letter" id="letter_template" style="display:none">
				<div class="letter_hover">
					<div class="letter_settings">
						<span class="char"></span>
					</div>
					<div class="adjust_letter">
						<div class="move_up">▲</div>
						<div class="move_left">◀</div>
						<div class="move_right">▶</div>
						<div class="move_down">▼</div>
					</div>
				</div>

				<pre class="letter_ascii"></pre>
			</div>
		</div>

		<textarea id="copy_ascii"></textarea>
		<div id="rem_size" style="width:fit-content;height:fit-content;font-size:1rem;padding:0;margin:0;">█</div>
	  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="<?php echo $settings['ScribbleByte_site_path'] . 'script.js?v=' . $cache; ?>"></script>
    <?php if(isset($settings['include_footer']) && $settings['include_footer'] !== ''){
      include($settings['include_footer']);
    } ?>
  </body>
</html>
