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

if (isset($_POST['text']) || $debug)
{
  $font = $settings['default_font'];

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
    );

    $force_set = array(
      //'line_height' => 2,
      //'line_width' => null,
      //'letter_spacing' => -2,
      //'space_width' => 3,
      //'much_chars' => null,
      //'much_amount' => null,
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

    if($use_set['letters'] !== 1 && ($use_set['line_height'] < $calc_set['line_height'] ||
      $use_set['letter_spacing'] < 0))
    {
      $string = file_get_contents("combos.json");
      $combos = json_decode($string, true);
    }

    $ascii_letter_arr = array();
    $letter_current_line = array();

    $ascii_arr = array();
    $next_line = array();
    $current_line = false;

    $max_line_height = $use_set['line_height'] > $calc_set['line_height'] ? $use_set['line_height'] : $calc_set['line_height'];

    //split text at linebreaks
    $text_lines = preg_split('/(\r\n|\n|\r)/', $text);
    foreach($text_lines as $txt)
    {
      $text_arr = str_split($txt);

      if($current_line !== false)
      {
        if($max_line_height > $use_set['line_height'])
        {
          $next_line = array_splice($current_line,  $use_set['line_height'] - $max_line_height);
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

      //loop thru letters in line
      foreach ($text_arr as $letter)
      {
        $ascii_current_letter = array(
          array(
            'char' => $letter,
            'used_char' => $letter,
            'letter_width' => 0,
            'letter_spacing' => $use_set['letter_spacing'],
            'line_height' => $use_set['line_height'],
          ),
        );

        if(isset($letter_arr[$letter]))
        {
          $letter_width = $letter_arr[$letter][0];
          $ascii_current_letter[0]['letter_width'] = $letter_width;

          for($l = 0; $l < $max_line_height; $l++)
          {
            if(isset($letter_arr[$letter][$l + 1]))
            {
              $line_add = $letter_arr[$letter][$l + 1];

              if(mb_strlen($line_add) < $letter_width)
              {
                $line_add .= str_repeat(' ', $letter_width - mb_strlen($line_add));
              }
            }
            else
            {
              $line_add = str_repeat(' ', $letter_width);
            }

            $ascii_current_letter[] = $line_add;

            //letters don't have negative space, or this is the first letter in the line
            if($use_set['letter_spacing'] > -1 || mb_strlen($current_line[$l]) === 0)
            {
              $space = '';
              if($use_set['letter_spacing'] > -1) $space = str_repeat(' ', $use_set['letter_spacing']);

              $current_line[$l] .= muck($line_add . $space, $use_set['muck_amount'], $use_set['muck_chars']);
            }
            else //letter_spacing < 0
            {
              $current_line[$l] .= str_repeat(' ', mb_strlen($line_add) + $use_set['letter_spacing']);
              $current_line_arr = mb_str_split($current_line[$l]);
              $line_add_arr = mb_str_split($line_add);

              for($ll = 0; $ll < count($line_add_arr); $ll++)
              {
                $la = count($line_add_arr) - 1 - $ll;
                $cl = count($current_line_arr) - 1 + $use_set['letter_spacing'] - $ll;

                if(!isset($line_add_arr[$la])) break;
                if($cl > -1 && $line_add_arr[$la] !== ' ')
                {
                  if($debug &&
                    $current_line_arr[$cl] !== ' ' &&
                    $current_line_arr[$cl] !== $line_add_arr[$la] &&
                    !isset($combos[$current_line_arr[$cl]][$line_add_arr[$la]]))
                  {
                    echo 'Combo not found for "' . $current_line_arr[$cl] . '" + "' . $line_add_arr[$la] . '"<br />';
                  }

                  if($current_line_arr[$cl] !== ' ' && isset($combos[$current_line_arr[$cl]][$line_add_arr[$la]]))
                  {
                    $current_line_arr[$cl] = $combos[$current_line_arr[$cl]][$line_add_arr[$la]];
                  }
                  else
                  {
                    $current_line_arr[$cl] = $line_add_arr[$la];
                  }
                }
              }

              $current_line[$l] = implode('', muck($current_line_arr, $use_set['muck_amount'], $use_set['muck_chars']));
            }

            if(mb_strlen($current_line[$l]) > $calc_set['max_line_width'])
            {
              $calc_set['max_line_width'] = mb_strlen($current_line[$l]);
            }
          }

          $letter_current_line[] = $ascii_current_letter;
        }
        else if($letter === ' ')
        {
          $space = ' ';
          if($use_set['space_width'] > 0)
          {
            $space = str_repeat(' ', $use_set['space_width']);
          }

          for($l = 0; $l < $max_line_height; $l++)
          {
            $current_line[$l] .= $space;
            $ascii_current_letter[] = $space;

            if(mb_strlen($current_line[$l]) > $calc_set['max_line_width'])
            {
              $calc_set['max_line_width'] = mb_strlen($current_line[$l]);
            }
          }

          $letter_current_line[] = $ascii_current_letter;
        }
        else if($use_set['not_found'] !== '')
        {
          $space = ' ';
          $nf_char = $use_set['not_found'] === 'char' ? $letter : $use_set['not_found'];
          $nf_line = floor($use_set['line_height'] / 2);

          if($use_set['space_width'] > 0)
          {
            $space = str_repeat(' ', $use_set['space_width']);
            $nf_char = str_repeat(' ', floor(($use_set['space_width'] - 1) / 2)) . $nf_char . str_repeat(' ', floor(($use_set['space_width'] - 1) / 2));
          }

          $ascii_current_letter[0]['used_char'] = $nf_char;

          for($l = 0; $l < $max_line_height; $l++)
          {
            $current_line[$l] .= ($l == $nf_line ? $nf_char : $space);
            $ascii_current_letter[] = ($l == $nf_line ? $nf_char : $space);

            if(mb_strlen($current_line[$l]) > $calc_set['max_line_width'])
            {
              $calc_set['max_line_width'] = mb_strlen($current_line[$l]);
            }
          }

          if($debug)
          {
            echo 'Letter not found, used not_found: ' . $letter . ' -> "' . $nf_char . '"' . $nf_line . '<br />';
          }

          $letter_current_line[] = $ascii_current_letter;
        }
        else
        {
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
                  if($debug && $next_line_arr[$l] !== ' ' && !isset($combos[$next_line_arr[$l]][$current_line_arr[$l]]))
                  {
                    echo 'Combo not found for "' . $next_line_arr[$l] . '" + "' . $current_line_arr[$l] . '"<br />';
                  }

                  if($next_line_arr[$l] !== ' ' && isset($combos[$next_line_arr[$l]][$current_line_arr[$l]]))
                  {
                    $current_line_arr[$l] = $combos[$next_line_arr[$l]][$current_line_arr[$l]];
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

    if($debug)
    {
      //print("<pre>".$text."</pre>");
      //print("<pre>".print_r($text_lines,true)."</pre>");
      //print("<pre>font:".print_r($font_set,true)."</pre>");
      //print("<pre>calc:".print_r($calc_set,true)."</pre>");
      //print("<pre>use:".print_r($use_set,true)."</pre>");
      print("<pre>ascii_arr:".print_r($ascii_arr,true)."</pre>");

      foreach($ascii_arr as $line)
      {
        foreach($line as $letter_line)
        {
          echo '<pre style="margin:-1px 0 -2px">' . $letter_line . '</pre>';
        }
      }
    }
    else
    {
      echo json_encode(array(
        'settings' => $use_set,
        'ascii' => $use_set['letters'] === 1 ? $ascii_letter_arr : $ascii_arr,
      ));
    }
  }
}
else
{
    echo json_encode(array('error' => 'No text typed.'));
}
