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

$debug = isset($_GET['debug']) && $_GET['debug'] == 'true' ? true : false;

function muck($str, $amount, $chars)
{
  if(!isset($amount) || $amount === null || $amount === 0 || !isset($chars) || $chars === null || $chars === 0)
  {
    return $str;
  }

  $return_arr = false;

  if(is_array($str))
  {
    $str_arr = $str;
    $return_arr = true;
  }
  else
  {
    $str_arr = mb_str_split($str);
  }

  $char_arr = mb_str_split($chars);

  foreach($str_arr as $l => $letter)
  {
    if($letter === ' ' && rand(1, 50) < $amount)
    {
      $str_arr[$l] = $char_arr[array_rand($char_arr)];
    }
  }

  if($return_arr)
  {
    return $str_arr;
  }
  else
  {
    return implode('', $str_arr);
  }
}

function get_darker_char($char1=' ', $char2=' ')
{
	//char1
	$img1 = imagecreatetruecolor(12, 20);
	$bg1 = imagecolorallocate($img1, 255, 255, 255);
	$textcolor1 = imagecolorallocate($img1, 0, 0, 0);
	imagefilledrectangle($img1, 0, 0, 20, 20, $bg1);
	imagettftext($img1, 15, 0, 0, 15, $textcolor1, 'css/Menlo-Regular.ttf', $char1);

	$x1 = imagesx($img1);
	$y1 = imagesy($img1);
	$tmp_img1 = ImageCreateTrueColor(1,1);
	ImageCopyResampled($tmp_img1,$img1,0,0,0,0,1,1,$x1,$y1);
	$rgb1 = ImageColorAt($tmp_img1,0,0);
	$r1   = ($rgb1 >> 16) & 0xFF;

	//char2
	$img2 = imagecreatetruecolor(12, 20);
	$bg2 = imagecolorallocate($img2, 255, 255, 255);
	$textcolor2 = imagecolorallocate($img2, 0, 0, 0);
	imagefilledrectangle($img2, 0, 0, 20, 20, $bg2);
	imagettftext($img2, 15, 0, 0, 15, $textcolor2, 'css/Menlo-Regular.ttf', $char2);

	$x2 = imagesx($img2);
	$y2 = imagesy($img2);
	$tmp_img2 = ImageCreateTrueColor(1,1);
	ImageCopyResampled($tmp_img2,$img2,0,0,0,0,1,1,$x2,$y2);
	$rgb2 = ImageColorAt($tmp_img2,0,0);
	$r2   = ($rgb2 >> 16) & 0xFF;


	if($r1 < $r2) return $char1;
	if($r1 > $r2) return $char2;
	return $char1;
}

if (isset($_POST['text']) || $debug)
{
  $font = 'Big';//$settings['default_font'];

  if($debug && isset($_GET['text'])){
    $text = $_GET['text'];
  } else if($debug && !isset($_GET['text'])) {
    $text = $settings['default_text'];
  //  $text = 'ABC';
  } else {
    $text = $_POST['text'];
  }

  if(isset($_POST['font'])) $font = $_POST['font'];

  if(!file_exists('fonts/' . $font . '.txt'))
  {
    echo json_encode(array('error' => 'No font found for ' . $font . ' found.'));
  }
  else
  {
    $chars = '';
    $char_arr = array();

    $font_set = array(
      'line_height' => null,
      'letter_spacing' => null,
      'space_width' => null,
      'case_insensitive' => null,
      'muck_chars' => '',
      'muck_amount' => null,
      'char_pre' => '', //need this one if the font includes any of the characters in the character string. see Calvin S.
      'not_found' => '', //what to use when a character isn't found, 'char' will use the actual character.
			'font_size' => null, //default 1rem
			'single_char' => null, //if 1, then font is only a single char
			'rand_char' => null,
		);

    $calc_set = array(
      'line_height' => 0,
      //'line_width' => 0,
      'max_line_width' => 0,
      'letter_spacing' => 1,
      'space_width' => 0,
      'case_insensitive' => 0,
      'muck_amount' => 0,
    );

    $use_set = array(
      'line_height' => isset($_POST['line_height']) ? (int)$_POST['line_height'] : null,
      'line_width' => isset($_POST['line_width']) ? (int)$_POST['line_width'] : null,
      'max_line_width' => null,
      'letter_spacing' => isset($_POST['letter_spacing']) ? (int)$_POST['letter_spacing'] : null,
      'case_insensitive' => isset($_POST['case_insensitive']) ? (int)$_POST['case_insensitive'] : null,
      'space_width' => isset($_POST['space_width']) ? (int)$_POST['space_width'] : null,
      'muck_chars' => isset($_POST['muck_chars']) ? $_POST['muck_chars'] : null,
      'muck_amount' => isset($_POST['muck_amount']) ? (int)$_POST['muck_amount'] : null,
      'char_pre' => '',
      'not_found' => isset($_POST['not_found']) ? $_POST['not_found'] : null,
      'letters' => isset($_POST['letters']) ? (int)$_POST['letters'] : null,
			'letter_settings' => isset($_POST['letter_settings']) ? $_POST['letter_settings'] : null,
			'font_size' => isset($_POST['font_size']) ? $_POST['font_size'] : null,
			'single_char' => null,
			'rand_char' => null,
		);

    $force_set = array(
      //'line_height' => 2,
      //'line_width' => null,
      //'letter_spacing' => -2,
      //'space_width' => 3,
      //'much_chars' => null,
      //'much_amount' => null,
			'letter_settings' => array(
				0 => array( //line
					3 => array( //letter
						'x' => 3,
						'y' => 0
					),
				),
			)
    );

    $letter_arr = array();
    $current_letter = false;
    $calc_line_height = 0;
    $combos = array();

    $file = file('fonts/' . $font . '.txt');
    foreach($file as $line_num => $line)
    {
      $new_char_line = preg_replace('/^'.$font_set['char_pre'].'/', '', trim($line));
      $match_new_char = preg_match('/^'.$font_set['char_pre'].'/', trim($line));

      if($line_num === 0) //font characters
      {
        $chars = trim($line);
        $char_arr = str_split($chars);
      }
      if($line_num === 1) //font settings
      {
        $key_vals = explode(' ', trim($line));
        foreach ($key_vals as $key_val) {
          $key_val_arr = explode(':', $key_val);

          if($font_set[$key_val_arr[0]] !== '')
          {
            $font_set[$key_val_arr[0]] = (int)$key_val_arr[1];
          }
          else
          {
            $font_set[$key_val_arr[0]] = $key_val_arr[1];
          }
        }
      }
			//this font has a custom space character
      else if(trim($line) === '(space)' && in_array(' ', $char_arr))
      {
        if($calc_line_height > $calc_set['line_height'])
        {
          if($debug && isset($font_set['line_height']) && $calc_line_height > $font_set['line_height'])
          {
            echo 'Warning: line_height of (space) =' . $calc_line_height . ' which is > than font line_height.<br />';
          }

          $calc_set['line_height'] = $calc_line_height;
        }
        $calc_line_height = 0;

        $current_letter = ' ';
        $letter_arr[$current_letter] = array(0);
      }
			//if the current line is a new character A
			//and that character is in the list of characters this font uses...
      else if($match_new_char && in_array($new_char_line, $char_arr))
      {
        if($calc_line_height > $calc_set['line_height'])
        {
          if($debug && isset($font_set['line_height']) && $calc_line_height > $font_set['line_height'])
          {
            echo 'Warning: line_height of ' . $new_char_line . '=' . $calc_line_height . ' which is > than font line_height.<br />';
          }

          $calc_set['line_height'] = $calc_line_height;
        }
        $calc_line_height = 0;

        $current_letter = $new_char_line;
        $letter_arr[$current_letter] = array(0);
      }
			//these are ascii characters to add to the current character
      else if($current_letter !== false)
      {
        $l = preg_replace('/[\n\r]+/', '', $line);
        if(mb_strlen($l) > $letter_arr[$current_letter][0])
        {
          $letter_arr[$current_letter][0] = mb_strlen($l);
        }

        if(mb_strlen($l) > $calc_set['space_width'])
        {
          $calc_set['space_width'] = mb_strlen($l);
        }

        $calc_line_height++;

        array_push($letter_arr[$current_letter], $l);
      }
    }

    //make settings, some like line_width aren't calced until the next bit if they're not set manually.
    foreach($use_set as $key => $val)
    {
      if($use_set[$key] === null)
      {
        if($debug && isset($force_set[$key]) && $force_set[$key] !== null)
        {
          $use_set[$key] = $force_set[$key];
        }
        else if(isset($font_set[$key]) && $font_set[$key] !== null)
        {
          $use_set[$key] = $font_set[$key];
        }
        else if(isset($calc_set[$key]) && $calc_set[$key] !== 0)
        {
          $use_set[$key] = $calc_set[$key];
        }
        else
        {
          if($debug)
          {
            echo 'Warning: ' . $key . ' not found in font file or calculated.<br />';
          }
        }
      }
    }

    if($use_set['case_insensitive'] === 1)
    {
      $text = strtoupper($text);

      foreach($letter_arr as $letter => $arr)
      {
        $letter_arr[strtoupper($letter)] = $arr;
      }
    }

		if($use_set['single_char'] === null)
		{
	    if($use_set['letters'] !== 1 && ($use_set['line_height'] < $calc_set['line_height'] ||
	      $use_set['letter_spacing'] < 0 || $use_set['letter_settings'] !== null))
	    {
	      $string = file_get_contents("combos.json");
	      $combos = json_decode($string, true);
	    }
		}

		if($debug)
		{
			print("<pre>use_set:".print_r($use_set,true)."</pre>");
		}

    $ascii_letter_arr = array();
    $letter_current_line = array();

    $ascii_arr = array();
    $next_line = array();
    $current_line = false;
		$move_current_line_down = 0;

    $max_line_height = $use_set['line_height'] > $calc_set['line_height'] ? $use_set['line_height'] : $calc_set['line_height'];

    //split text at linebreaks
    $text_lines = preg_split('/(\r\n|\n|\r)/', $text);
    foreach($text_lines as $line_i => $txt)
    {
      $text_arr = str_split($txt);

      if($current_line !== false)
      {
				if($debug) echo 'use_set[line_height]:' . $use_set['line_height']  . ' count($current_line):' . count($current_line) . ' move_current_line_down:'.$move_current_line_down.'<br />';

				if(count($current_line) > $use_set['line_height'] + $move_current_line_down)
				{
					$next_line = array_splice($current_line,  $use_set['line_height'] - count($current_line) + $move_current_line_down);
				}

        array_push($ascii_arr, $current_line);
        array_push($ascii_letter_arr, $letter_current_line);

        if(count($next_line) > 0)
        {
          $current_line = $next_line;
        }

        $letter_current_line = array();
      }

      for($l = 0; $l < $max_line_height; $l++)
      {
        $current_line[$l] = '';
      }

			//this is for if we want letters to move up, y < 0
			$move_current_line_down = 0;

      //loop thru letters in line
      foreach ($text_arr as $letter_i => $letter)
      {
        $letter_set = array(
          array(
            'char' => $letter,
            'used_char' => $letter,
            'letter_width' => 0,

            'line_height' => $use_set['line_height'],
            'letter_spacing' => $use_set['letter_spacing'],

						'x' => isset($use_set['letter_settings'][$line_i][$letter_i]['x']) ? $use_set['letter_settings'][$line_i][$letter_i]['x'] : 0,
						'y' => isset($use_set['letter_settings'][$line_i][$letter_i]['y']) ? $use_set['letter_settings'][$line_i][$letter_i]['y'] : 0,
          ),
        );

				//move letter right/left
				$letter_set[0]['letter_spacing'] = $letter_set[0]['letter_spacing'] + $letter_set[0]['x'];

        if(isset($letter_arr[$letter]))
        {
					if($debug) echo $letter . '<br />';

					if($use_set['single_char'] !== null)
					{
						$letter_width = 1;
					}
					else
					{
						$letter_width = $letter_arr[$letter][0];
					}

					if($use_set['rand_char'])
					{
						//$letter_ascii = $letter_arr[$letter][1][rand(0, strlen($letter_arr[$letter][1])-1)];
						$letters_from = array_slice($letter_arr[$letter], 1);
						$letters_from = mb_str_split($letters_from[0]);
						$letter_ascii = array(
							$letters_from[array_rand($letters_from)]
						);
					}
					else
					{
						$letter_ascii = array_slice($letter_arr[$letter], 1);
					}

					$letter_set[0]['letter_width'] = $letter_width;

					if($debug) echo 'move_current_line_down:' . $move_current_line_down . '<br />';

					//shift other letters down
					if($move_current_line_down > 0)
					{
						for($i = 0; $i < $move_current_line_down; $i++)
						{
							array_unshift($letter_ascii, '');
						}
					}

					//move letter down
					if($letter_set[0]['y'] > 0)
					{
						if($debug) echo 'y > 0, move down:' . $letter_set[0]['y'] . '<br />';

						for($i = 0; $i < $letter_set[0]['y']; $i++)
						{
							array_unshift($letter_ascii, '');
						}
					}
					else if($letter_set[0]['y'] < 0) //move letter up
					{
						if($debug) echo 'y < 0, move up:' . $letter_set[0]['y'] . '<br />';

						$add_to_top = 0;
						for($i = 0; $i < abs($letter_set[0]['y']); $i++)
						{
							//if there's empty space at the top of the letter, remove it
							if(trim($letter_ascii[$i]) === '')
							{
								array_shift($letter_ascii);
							}
							else //this is gonna be weird, we will have to move it into previous lines
							{
								$add_to_top++;
							}
						}

						if($add_to_top > $move_current_line_down)
						{
							if($debug) echo 'add_to_top > move_current_line_down:' . $add_to_top . '<br />';

							$move_current_line_down = $add_to_top;

							$str_len = mb_strlen($current_line[0]);
							for($i = 0; $i < $add_to_top; $i++)
							{
								array_unshift($current_line, str_repeat(' ', $str_len));
							}
						}
					}

					$letter_set[0]['move_current_line_down'] = $move_current_line_down;

					//update max line height if letter is taller
					if(count($letter_ascii) > $max_line_height)
					{
						if($debug) echo 'current letter taller than max line height:' . count($letter_ascii) . '<br />';

						$str_len = mb_strlen($current_line[0]);
						for($i = count($current_line); $i < count($letter_ascii); $i++)
						{
							$current_line[$i] = str_repeat(' ', $str_len);
						}

						$max_line_height = count($letter_ascii);
					}

					$current_line_width = mb_strlen($current_line[0]);
          for($l = 0; $l < $max_line_height; $l++)
          {
            if(isset($letter_ascii[$l]))
            {
              $line_add = $letter_ascii[$l];

              if(mb_strlen($line_add) < $letter_width)
              {
                $line_add .= str_repeat(' ', $letter_width - mb_strlen($line_add));
              }
            }
            else
            {
              $line_add = str_repeat(' ', $letter_width);
            }

            $letter_set[] = $line_add;
						$space_before = mb_strlen($current_line[$l]) < $current_line_width ? str_repeat(' ', $current_line_width - mb_strlen($current_line[$l])) : '';

            //letters don't have negative space, or this is the first letter in the line
            if($letter_set[0]['letter_spacing'] > -1 || mb_strlen($current_line[$l]) === 0)
            {
              $space = '';
              if($letter_set[0]['letter_spacing'] > -1) $space = str_repeat(' ', $letter_set[0]['letter_spacing']);

              $current_line[$l] .= muck($space_before . $line_add . $space, $use_set['muck_amount'], $use_set['muck_chars']);
            }
            else //letter_spacing < 0
            {
              $current_line[$l] .= str_repeat(' ', mb_strlen($line_add) + $letter_set[0]['letter_spacing']);
              $current_line_arr = mb_str_split($current_line[$l]);
              $line_add_arr = mb_str_split($line_add);

              for($ll = 0; $ll < count($line_add_arr); $ll++)
              {
                $la = count($line_add_arr) - 1 - $ll;
                $cl = count($current_line_arr) - 1 + $letter_set[0]['letter_spacing'] - $ll;

                if(!isset($line_add_arr[$la])) break;
                if($cl > -1 && $line_add_arr[$la] !== ' ')
                {
                  if($current_line_arr[$cl] !== ' ' && isset($combos[$current_line_arr[$cl]][$line_add_arr[$la]]))
                  {
                    $current_line_arr[$cl] = $combos[$current_line_arr[$cl]][$line_add_arr[$la]];
                  }
									else if($current_line_arr[$cl] === $line_add_arr[$la])
									{
										//do nothing, the char doesn't need to be replaced
									}
                  else
                  {
										$darker = get_darker_char($current_line_arr[$cl], $line_add_arr[$la]);
										if($debug)
	                  {
	                    echo '1 Combo not found for "' . $current_line_arr[$cl] . '" + "' . $line_add_arr[$la] . '" using darker "' . $darker . '"<br />';
	                  }

                    $current_line_arr[$cl] = $darker;
                  }
                }
              }

              $current_line[$l] = $space_before . implode('', muck($current_line_arr, $use_set['muck_amount'], $use_set['muck_chars']));
            }

            if(mb_strlen($current_line[$l]) > $calc_set['max_line_width'])
            {
              $calc_set['max_line_width'] = mb_strlen($current_line[$l]);
            }
          }

					if($debug)
					{
						print("<pre>letter_set:".print_r($letter_set,true)."</pre>");
					}

          $letter_current_line[] = $letter_set;
        }
        else if($letter === ' ' && !isset($letter_arr[' ']))
        {
          $space = ' ';
          if($use_set['space_width'] + $letter_set[0]['x'] > 0)
          {
            $space = str_repeat(' ', $use_set['space_width'] + $letter_set[0]['x']);
          }

          for($l = 0; $l < $max_line_height; $l++)
          {
            $current_line[$l] .= $space;
            $letter_set[] = $space;

            if(mb_strlen($current_line[$l]) > $calc_set['max_line_width'])
            {
              $calc_set['max_line_width'] = mb_strlen($current_line[$l]);
            }
          }

          $letter_current_line[] = $letter_set;
        }
        else if($use_set['not_found'] !== '')
        {
					$letter_set[0]['not_found'] = true;

          $space = ' ';
          $nf_char = $use_set['not_found'] === 'char' ? $letter : $use_set['not_found'];
          $nf_line = floor($use_set['line_height'] / 2);

          if($use_set['space_width'] > 0)
          {
            $space = str_repeat(' ', $use_set['space_width']);
            $nf_char = str_repeat(' ', floor(($use_set['space_width'] - 1) / 2)) . $nf_char . str_repeat(' ', floor(($use_set['space_width'] - 1) / 2));
          }

          $letter_set[0]['used_char'] = $nf_char;

          for($l = 0; $l < $max_line_height; $l++)
          {
            $current_line[$l] .= ($l == $nf_line ? $nf_char : $space);
            $letter_set[] = ($l == $nf_line ? $nf_char : $space);

            if(mb_strlen($current_line[$l]) > $calc_set['max_line_width'])
            {
              $calc_set['max_line_width'] = mb_strlen($current_line[$l]);
            }
          }

          if($debug)
          {
            echo 'Letter not found, used not_found: ' . $letter . ' -> "' . $nf_char . '"' . $nf_line . '<br />';
          }

          $letter_current_line[] = $letter_set;
        }
        else
        {
					$letter_set[0]['not_found'] = true;

          if($debug)
          {
            echo 'Letter not found: ' . $letter . '<br />';
          }
        }
      }

      if($debug)
      {
        print("<pre>next_line:".print_r($next_line,true)."</pre>");
        print("<pre>current_line:".print_r($current_line,true)."</pre>");
      }

      foreach($next_line as $n => $nl)
      {
        if(isset($current_line[$n]))
        {
          $next_line_arr = mb_str_split($nl);
          $current_line_arr = mb_str_split($current_line[$n]);

          $line_len = count($next_line_arr) > count($current_line_arr) ? count($next_line_arr) : count($current_line_arr);

          for($l = 0; $l < $line_len; $l++)
          {
            if(isset($current_line_arr[$l]))
            {
              if(isset($next_line_arr[$l]))
              {
                if($current_line_arr[$l] === ' ')
                {
                  $current_line_arr[$l] = $next_line_arr[$l];
                }
                else
                {


                  if($next_line_arr[$l] !== ' ' && isset($combos[$next_line_arr[$l]][$current_line_arr[$l]]))
                  {
                    $current_line_arr[$l] = $combos[$next_line_arr[$l]][$current_line_arr[$l]];
                  }
									else if($next_line_arr[$l] === $current_line_arr[$l])
									{
										//do nothing, the char doesn't need to be replaced
									}
                  else
                  {
										$darker = get_darker_char($next_line_arr[$l], $current_line_arr[$l]);
										if($debug)
	                  {
	                    echo '2 Combo not found for "' . $next_line_arr[$l] . '" + "' . $current_line_arr[$l] . '" using darker "' . $darker . '"<br />';
	                  }

                    $current_line_arr[$l] = $darker;
                  }
                }
              }
            }
            else if(isset($next_line_arr[$l]))
            {
              $current_line_arr[$l] = $next_line_arr[$l];
            }
          }

          $current_line[$n] = implode('', $current_line_arr);
        }
      }


			//we need to move items into previous line
			if($move_current_line_down > 0 && count($ascii_arr) > 0)
			{
				$prev_line = end($ascii_arr);
				$prev_line_key = key($ascii_arr);
				$prev_letter_line_key = count($prev_line) - $move_current_line_down;

				$add_to_prev_line = array_splice($current_line, 0, $move_current_line_down);

				if($debug)
				{
					print("<pre>move_current_line_down:$move_current_line_down add_to_prev_line:".print_r($add_to_prev_line,true)."</pre>");
				}

				foreach($add_to_prev_line as $p => $pl)
	      {
	        if(isset($ascii_arr[$prev_line_key][$prev_letter_line_key]))
	        {
	          $prev_line_arr = mb_str_split($ascii_arr[$prev_line_key][$prev_letter_line_key]);
	          $add_prev_line_arr = mb_str_split($pl);

	          $line_len = count($prev_line_arr) > count($add_prev_line_arr) ? count($prev_line_arr) : count($add_prev_line_arr);

	          for($l = 0; $l < $line_len; $l++)
	          {
	            if(isset($prev_line_arr[$l]))
	            {
	              if(isset($add_prev_line_arr[$l]))
	              {
	                if($prev_line_arr[$l] === ' ')
	                {
	                  $prev_line_arr[$l] = $add_prev_line_arr[$l];
	                }
	                else
	                {
	                  if($prev_line_arr[$l] !== ' ' && isset($combos[$prev_line_arr[$l]][$add_prev_line_arr[$l]]))
	                  {
	                    $prev_line_arr[$l] = $combos[$prev_line_arr[$l]][$add_prev_line_arr[$l]];
	                  }
										else if($prev_line_arr[$l] === $add_prev_line_arr[$l])
										{
											//do nothing, the char doesn't need to be replaced
										}
										else
										{
											$darker = get_darker_char($prev_line_arr[$l], $add_prev_line_arr[$l]);
											if($debug)
											{
												echo '3 Combo not found for "' . $prev_line_arr[$l] . '" + "' . $add_prev_line_arr[$l] . '" using darker "' . $darker . '"<br />';
											}

											$prev_line_arr[$l] = $darker;
										}
	                }
	              }
	            }
	            else if(isset($add_prev_line_arr[$l]))
	            {
	              $prev_line_arr[$l] = $add_prev_line_arr[$l];
	            }
	          }

	          $ascii_arr[$prev_line_key][$prev_letter_line_key] = implode('', $prev_line_arr);
						$prev_letter_line_key++;
	        }
					else
					{
						if($debug) echo 'notset ' . $prev_line_key . ' ' . $prev_letter_line_key;
					}
	      }
			}
    }

		//update line height of letters
		foreach($letter_current_line as $letter)
		{
			$letter['line_height'] = count($current_line);
		}

    array_push($ascii_arr, $current_line);
    array_push($ascii_letter_arr, $letter_current_line);

    if(isset($current_line[0]) && mb_strlen($current_line[0]) > $calc_set['max_line_width'])
    {
      $calc_set['max_line_width'] = mb_strlen($current_line[0]);
    }
    $use_set['max_line_width'] = $calc_set['max_line_width'];
    if($use_set['line_width'] === null || $use_set['line_width'] === 0)
    {
      $use_set['line_width'] = $calc_set['max_line_width'];
    }

		//delete empty space at end of ascii_arr
		$last_line = end($ascii_arr);
		$last_line_key = key($ascii_arr);

		for (end($last_line); ($i=key($last_line))!==null; prev($last_line)){
		  $l = current($last_line);
			if(trim($l) === '')
			{
				unset($ascii_arr[$last_line_key][$i]);
			}
			else
			{
				break;
			}
		}

    if($debug)
    {
			//print("<pre>letter_arr:".print_r($letter_arr,true)."</pre>");
      print("<pre>ascii_arr:".print_r($ascii_arr,true)."</pre>");

      foreach($ascii_arr as $line)
      {
        foreach($line as $letter_line)
        {
					if(trim($letter_line) !== '')
					{
						echo '<pre style="margin:-1px 0 -2px; padding:0; height:15px;">' . $letter_line . '</pre>';
					}
        }
      }
    }
    else
    {
			if($use_set['letters'] === 1)
			{
				echo json_encode(array(
	        'ascii' => $ascii_letter_arr,
	      ));
			}
			else
			{
				echo json_encode(array(
	        'settings' => $use_set,
	        'ascii' => $ascii_arr,
	      ));
			}
    }
  }
}
else
{
    echo json_encode(array('error' => 'No text typed.'));
}
