<?php
class Font
{
  private $set = array();

  public $schema = array(
    'line_height' => array(
      'type' => 'int',
      'default' => 1,
      'ui' => true,
      'calc' => true,
      'font' => true,
    ),
    'max_line_height' => array(
      'type' => 'int',
      'default' => 1,
      'ui' => false,
      'calc' => false,
      'font' => false,
    ),
    'line_width' => array(
      'type' => 'int',
      'default' => null,
      'ui' => false,
      'calc' => true,
      'font' => false,
    ),
    'max_line_width' => array(
      'type' => 'int',
      'default' => null,
      'ui' => false,
      'calc' => true,
      'font' => false,
    ),
    'letter_spacing' => array(
      'type' => 'int',
      'default' => 0,
      'ui' => true,
      'calc' => false,
      'font' => true,
    ),
    'case_insensitive' => array(
      'type' => 'int',
      'default' => 0,
      'ui' => false,
      'calc' => false,
      'font' => true,
    ),
    'space_width' => array(
      'type' => 'int',
      'default' => 3,
      'ui' => true,
      'calc' => true,
      'font' => true,
    ),
    'muck_chars' => array(
      'type' => 'string',
      'default' => null,
      'ui' => true,
      'calc' => false,
      'font' => true,
    ),
    'muck_amount' => array(
      'type' => 'int',
      'default' => 0,
      'ui' => true,
      'calc' => false,
      'font' => true,
    ),
    'zalgo_above' => array(
      'type' => 'bool',
      'default' => 0,
      'ui' => true,
      'calc' => false,
      'font' => true,
    ),
    'zalgo_lative_above' => array(
      'type' => 'bool',
      'default' => 0,
      'ui' => true,
      'calc' => false,
      'font' => true,
    ),
    'zalgo_over' => array(
      'type' => 'bool',
      'default' => 0,
      'ui' => true,
      'calc' => false,
      'font' => true,
    ),
    'zalgo_below' => array(
      'type' => 'bool',
      'default' => 0,
      'ui' => true,
      'calc' => false,
      'font' => true,
    ),
    'char_pre' => array(
      'type' => 'string',
      'default' => null,
      'ui' => false,
      'calc' => false,
      'font' => true,
    ),
    'not_found' => array(
      'type' => 'string',
      'ui' => true,
      'default' => null,
      'calc' => false,
      'font' => true,
    ),
    'letters' => array(
      'type' => 'bool',
      'default' => 0,
      'ui' => true,
      'calc' => false,
      'font' => false,
    ),
    'letter_settings' => array(
      'type' => 'arr',
      'default' => array(),
      'ui' => true,
      'calc' => false,
      'font' => false,
    ),
    'font_size' => array(
      'type' => 'int',
      'default' => 1,
      'ui' => true,
      'calc' => false,
      'font' => true,
    ),
    'single_char' => array(
      'type' => 'bool',
      'default' => 0,
      'ui' => true,
      'calc' => false,
      'font' => true,
    ),
    'rand_char' => array(
      'type' => 'int',
      'default' => 0,
      'ui' => false,
      'calc' => false,
      'font' => true,
    ),
  );

  private $letter_arr = array();
  private $combos = array();

  public $font;
  public $text;
  private $debug;
  private $force_set;

  private $zalgo = array(
    'above' => array( //Marks that appear above a letter...
      array('u'=>'\u0300', 'h'=>'768'),
      array('u'=>'\u0301', 'h'=>'769'),
      array('u'=>'\u0302', 'h'=>'770'),
      array('u'=>'\u0303', 'h'=>'771'),
      array('u'=>'\u0304', 'h'=>'772'),
      array('u'=>'\u0305', 'h'=>'773'),
      array('u'=>'\u0306', 'h'=>'774'),
      array('u'=>'\u0307', 'h'=>'775'),
      array('u'=>'\u0308', 'h'=>'776'),
      array('u'=>'\u0309', 'h'=>'777'),
      array('u'=>'\u030A', 'h'=>'778'),
      array('u'=>'\u030B', 'h'=>'779'),
      array('u'=>'\u030C', 'h'=>'780'),
      array('u'=>'\u030D', 'h'=>'781'),
      array('u'=>'\u030E', 'h'=>'782'),
      array('u'=>'\u030F', 'h'=>'783'),
      array('u'=>'\u0310', 'h'=>'784'),
      array('u'=>'\u0311', 'h'=>'785'),
      array('u'=>'\u0312', 'h'=>'786'),
      array('u'=>'\u0313', 'h'=>'787'),
      array('u'=>'\u0314', 'h'=>'788'),
      array('u'=>'\u0315', 'h'=>'789'),
      array('u'=>'\u031A', 'h'=>'794'),
      array('u'=>'\u031B', 'h'=>'795'),
      array('u'=>'\u033D', 'h'=>'829'),
      array('u'=>'\u033E', 'h'=>'830'),
      array('u'=>'\u033F', 'h'=>'831'),
      array('u'=>'\u0340', 'h'=>'832'),
      array('u'=>'\u0341', 'h'=>'833'),
      array('u'=>'\u0342', 'h'=>'834'),
      array('u'=>'\u0343', 'h'=>'835'),
      array('u'=>'\u0344', 'h'=>'836'),
      array('u'=>'\u0346', 'h'=>'838'),
      array('u'=>'\u034A', 'h'=>'842'),
      array('u'=>'\u034B', 'h'=>'843'),
      array('u'=>'\u034C', 'h'=>'844'),
      array('u'=>'\u0350', 'h'=>'848'),
      array('u'=>'\u0351', 'h'=>'849'),
      array('u'=>'\u0352', 'h'=>'850'),
      array('u'=>'\u0357', 'h'=>'855'),
      array('u'=>'\u0358', 'h'=>'856'),
      array('u'=>'\u035B', 'h'=>'859'),
      array('u'=>'\u035D', 'h'=>'861'),
      array('u'=>'\u035E', 'h'=>'862'),
      array('u'=>'\u0360', 'h'=>'864'),
      array('u'=>'\u0361', 'h'=>'865'),
    ),
    'below' => array( //Marks that appear below a letter...
      array('u'=>'\u0316', 'h'=>'790'),
      array('u'=>'\u0317', 'h'=>'791'),
      array('u'=>'\u0318', 'h'=>'792'),
      array('u'=>'\u0319', 'h'=>'793'),
      array('u'=>'\u031C', 'h'=>'796'),
      array('u'=>'\u031D', 'h'=>'797'),
      array('u'=>'\u031E', 'h'=>'798'),
      array('u'=>'\u031F', 'h'=>'799'),
      array('u'=>'\u0320', 'h'=>'800'),
      array('u'=>'\u0321', 'h'=>'801'),
      array('u'=>'\u0322', 'h'=>'802'),
      array('u'=>'\u0323', 'h'=>'803'),
      array('u'=>'\u0324', 'h'=>'804'),
      array('u'=>'\u0325', 'h'=>'805'),
      array('u'=>'\u0326', 'h'=>'806'),
      array('u'=>'\u0327', 'h'=>'807'),
      array('u'=>'\u0328', 'h'=>'808'),
      array('u'=>'\u0329', 'h'=>'809'),
      array('u'=>'\u032A', 'h'=>'810'),
      array('u'=>'\u032B', 'h'=>'811'),
      array('u'=>'\u032C', 'h'=>'812'),
      array('u'=>'\u032D', 'h'=>'813'),
      array('u'=>'\u032E', 'h'=>'814'),
      array('u'=>'\u032F', 'h'=>'815'),
      array('u'=>'\u0330', 'h'=>'816'),
      array('u'=>'\u0331', 'h'=>'817'),
      array('u'=>'\u0332', 'h'=>'818'),
      array('u'=>'\u0333', 'h'=>'819'),
      array('u'=>'\u0339', 'h'=>'825'),
      array('u'=>'\u033A', 'h'=>'826'),
      array('u'=>'\u033B', 'h'=>'827'),
      array('u'=>'\u033C', 'h'=>'828'),
      array('u'=>'\u0345', 'h'=>'837'),
      array('u'=>'\u0347', 'h'=>'839'),
      array('u'=>'\u0348', 'h'=>'840'),
      array('u'=>'\u0349', 'h'=>'841'),
      array('u'=>'\u034D', 'h'=>'845'),
      array('u'=>'\u034E', 'h'=>'846'),
      array('u'=>'\u0353', 'h'=>'851'),
      array('u'=>'\u0354', 'h'=>'852'),
      array('u'=>'\u0355', 'h'=>'853'),
      array('u'=>'\u0356', 'h'=>'854'),
      array('u'=>'\u0359', 'h'=>'857'),
      array('u'=>'\u035A', 'h'=>'858'),
      array('u'=>'\u035C', 'h'=>'860'),
      array('u'=>'\u035F', 'h'=>'863'),
      array('u'=>'\u0362', 'h'=>'866'),
    ),
    'over' => array( //Marks that appear over a letter...
      array('u'=>'\u0334', 'h'=>'820'),
      array('u'=>'\u0335', 'h'=>'821'),
      array('u'=>'\u0336', 'h'=>'822'),
      array('u'=>'\u0337', 'h'=>'823'),
      array('u'=>'\u0338', 'h'=>'824'),
    ),
    'latin_above' => array( //Latin marks that appear above a letter...
      array('u'=>'\u0363', 'h'=>'867'),
      array('u'=>'\u0364', 'h'=>'868'),
      array('u'=>'\u0365', 'h'=>'869'),
      array('u'=>'\u0366', 'h'=>'870'),
      array('u'=>'\u0367', 'h'=>'871'),
      array('u'=>'\u0368', 'h'=>'872'),
      array('u'=>'\u0369', 'h'=>'873'),
      array('u'=>'\u036A', 'h'=>'874'),
      array('u'=>'\u036B', 'h'=>'875'),
      array('u'=>'\u036C', 'h'=>'876'),
      array('u'=>'\u036D', 'h'=>'877'),
      array('u'=>'\u036E', 'h'=>'878'),
      array('u'=>'\u036F', 'h'=>'879'),
    ),
  );

  public function __construct($font='', $text='', $debug=false, $force_set=array())
  {
    $this->font = $font;
    $this->text = $text;
    $this->debug = $debug;
    $this->force_set = $force_set;

    foreach($this->schema as $key => $schema)
    {
      if(!isset($this->set[$key]))
      {
        $this->set[$key] = array(
          'val' => $schema['default']
        );

        if($schema['ui']) $this->set[$key]['ui'] = null;
        if($schema['font']) $this->set[$key]['font'] = null;
        if($schema['calc']) $this->set[$key]['calc'] = null;
      }
    }

    if(file_exists('fonts/' . $font . '.txt'))
    {
      $this->load_font_txt();
      $this->set_set();
    }
    else
    {
      return array('error' => 'No font found for ' . $font . ' found.');
    }
  }

  private function load_font_txt()
  {
    $chars = '';
    $char_arr = array();
    $current_letter = false;
    $calc_line_height = 0;

    $file = file('fonts/' . $this->font . '.txt');
    foreach($file as $line_num => $line)
    {
      $new_char_line = preg_replace('/^'.$this->set['char_pre']['font'].'/', '', trim($line));
      $match_new_char = preg_match('/^'.$this->set['char_pre']['font'].'/', trim($line));

      if($line_num === 0) //font characters
      {
        $chars = trim($line);
        $char_arr = str_split($chars);
      }
      if($line_num === 1) //font settings
      {
        $key_vals = explode(' ', trim($line));
        foreach ($key_vals as $key_val)
        {
          $key_val_arr = explode(':', $key_val);

          if(isset($this->schema[$key_val_arr[0]]) && $this->schema[$key_val_arr[0]]['font'] === true)
          {
            if($this->schema[$key_val_arr[0]]['type'] === 'int' ||
              $this->schema[$key_val_arr[0]]['type'] === 'bool')
            {
              $this->set[$key_val_arr[0]]['font'] = (int)$key_val_arr[1];
            }
            else
            {
              $this->set[$key_val_arr[0]]['font'] = $key_val_arr[1];
            }
          }
          else if($this->debug && !isset($this->schema[$key_val_arr[0]]))
          {
            echo 'Warning, could not set ' . $key_val_arr[0] . ':' . $key_val_arr[1] . ' because it does not exist in the schema.<br />';
          }
          else if($this->debug && !$this->schema[$key_val_arr[0]]['font'])
          {
            echo 'Warning, could not set ' . $key_val_arr[0] . ':' . $key_val_arr[1] . ' the schema does not allow it.<br />';
          }
        }
      }
			//this font has a custom space character
      else if(trim($line) === '(space)' && in_array(' ', $char_arr))
      {
        if($this->set['line_height']['calc'] === null || $calc_line_height > $this->set['line_height']['calc'])
        {
          if($this->debug && $this->set['line_height']['font'] !== null && $calc_line_height > $this->set['line_height']['font'])
          {
            echo 'Warning: line_height of (space) =' . $calc_line_height . ' which is > than font line_height.<br />';
          }

          $this->set['line_height']['calc'] = $calc_line_height;
        }
        $calc_line_height = 0;

        $current_letter = ' ';
        $this->letter_arr[$current_letter] = array(0);
      }
			//if the current line is a new character A
			//and that character is in the list of characters this font uses...
      else if($match_new_char && in_array($new_char_line, $char_arr))
      {
        if($this->set['line_height']['calc'] === null || $calc_line_height > $this->set['line_height']['calc'])
        {
          if($this->debug && $this->set['line_height']['font'] !== null && $calc_line_height > $this->set['line_height']['font'])
          {
            echo 'Warning: line_height of ' . $new_char_line . '=' . $calc_line_height . ' which is > than font line_height.<br />';
          }

          $this->set['line_height']['calc'] = $calc_line_height;
        }
        $calc_line_height = 0;

        $current_letter = $new_char_line;
        $this->letter_arr[$current_letter] = array(0);
      }
			//these are ascii characters to add to the current character
      else if($current_letter !== false)
      {
        $l = preg_replace('/[\n\r]+/', '', $line);
        if(mb_strlen($l) > $this->letter_arr[$current_letter][0])
        {
          $this->letter_arr[$current_letter][0] = mb_strlen($l);
        }

        if(mb_strlen($l) > $this->set['space_width']['calc'])
        {
          $this->set['space_width']['calc'] = mb_strlen($l);
        }

        $calc_line_height++;

        array_push($this->letter_arr[$current_letter], $l);
      }
    }
  }

  //make settings, some like line_width aren't calced until
  //the next bit if they're not set manually.
  private function set_set()
  {
    foreach($this->schema as $key => $schema)
    {
      if($this->debug && isset($this->force_set[$key]))
      {
        $this->set[$key]['val'] = $this->force_set[$key];
      }
      else if($schema['ui'] === true && isset($_POST[$key]))
      {
        if($schema['type'] === 'int' || $schema['type'] === 'bool')
        {
          $this->set[$key]['val'] = (int)$_POST[$key];
          $this->set[$key]['ui'] = (int)$_POST[$key];
        }
        else
        {
          $this->set[$key]['val'] = $_POST[$key];
          $this->set[$key]['ui'] = $_POST[$key];
        }
      }
      else if($schema['font'] === true && $this->set[$key]['font'] !== null)
      {
        if($schema['type'] === 'int' || $schema['type'] === 'bool')
        {
          $this->set[$key]['val'] = (int)$this->set[$key]['font'];
        }
        else
        {
          $this->set[$key]['val'] = $this->set[$key]['font'];
        }
      }
      else if($schema['calc'] === true && $this->set[$key]['calc'] !== null)
      {
        if($schema['type'] === 'int' || $schema['type'] === 'bool')
        {
          $this->set[$key]['val'] = (int)$this->set[$key]['calc'];
        }
        else
        {
          $this->set[$key]['val'] = $this->set[$key]['calc'];
        }
      }
      else if($this->debug)
      {
        //echo 'Warning: ' . $key . ' not found.<br />';
      }
    }

    if($this->set['case_insensitive']['val'] === 1)
    {
      $this->text = strtoupper($this->text);

      foreach($this->letter_arr as $letter => $arr)
      {
        $this->letter_arr[strtoupper($letter)] = $arr;
      }
    }

    if($this->set['line_height']['val'] > $this->set['line_height']['calc'])
    {
      $this->set['max_line_height']['val'] = $this->set['line_height']['val'];
    }
    else
    {
      $this->set['max_line_height']['val'] = $this->set['line_height']['calc'];
    }

    //single char is for single line fonts.
		if($this->set['single_char']['val'] !== 1)
		{
	    if($this->set['letters']['val'] !== 1 &&
        ($this->set['line_height']['val'] < $this->set['line_height']['calc'] ||
	      $this->set['letter_spacing']['val'] < 0))
	    {
	      $this->load_combos();
	    }
		}
    else
    {
      $this->set['line_height']['val'] = 1;

      if($this->set['font_size']['font'] === null &&
       $this->set['font_size']['ui'] === null)
      {
        $this->set['font_size']['val'] = 3;
      }

      if($this->set['space_width']['font'] === null &&
       $this->set['space_width']['ui'] === null)
      {
        $this->set['space_width']['val'] = 1;
      }
    }

    $this->pre('set',$this->set);
  }

  public function create_text()
  {
    if($this->set['single_char']['val'] === 1)
    {
      return $this->create_text_single_line();
    }
    else
    {
      return $this->create_text_multi_line();
    }
  }

  private function create_text_single_line()
  {
    $ascii_arr = array();
    $current_line = array();

    //split text at linebreaks
    $text_lines = preg_split('/(\r\n|\n|\r)/', $this->text);
    foreach($text_lines as $line_i => $txt)
    {
      $text_arr = str_split($txt);
      $current_line = '';

      foreach ($text_arr as $letter_i => $letter)
      {
        if(isset($this->letter_arr[$letter]))
        {
					if($this->debug) echo $letter . '<br />';
					if($this->set['rand_char']['val'])
					{
						//$letter_ascii = $this->letter_arr[$letter][1][rand(0, strlen($this->letter_arr[$letter][1])-1)];
						$letters_from = array_slice($this->letter_arr[$letter], 1);
						$letters_from = mb_str_split($letters_from[0]);
						$letter_ascii = $letters_from[array_rand($letters_from)];
					}
					else
					{
						$letter_ascii = array_slice($this->letter_arr[$letter], 1)[0];
					}

          $current_line .= $letter_ascii;
        }
        else if($letter === ' ' && !isset($this->letter_arr[' ']))
        {
          $space = ' ';
          if($this->set['space_width']['val'] > 0)
          {
            $space = str_repeat(' ', $this->set['space_width']['val']);
          }

          $current_line .= $space;
        }
        else if($this->set['not_found']['val'] !== '')
        {
          $nf_char = $this->set['not_found']['val'] === 'char' ? $letter : $this->set['not_found']['val'];
          $current_line .= $nf_char;

          if($this->debug)
          {
            echo 'Letter not found, used not_found: ' . $letter . ' -> "' . $nf_char . '"<br />';
          }
        }
        else
        {
          if($this->debug)
          {
            echo 'Letter not found: ' . $letter . '<br />';
          }
        }
      }

      if(mb_strlen($current_line) > $this->set['max_line_width']['calc'])
      {
        $this->set['max_line_width']['calc'] = mb_strlen($current_line);
      }

      $ascii_arr[] = array($this->zalgo_muck($current_line));
    }

    $ret_set = array();
    foreach($this->set as $key => $vals)
    {
      if($this->schema[$key]['ui'] === true)
      {
        $ret_set[$key] = $vals['val'];
      }
    }

    return array(
      'settings' => $ret_set,
      'ascii' => $ascii_arr,
    );
  }

  private function create_text_multi_line()
  {
    $ascii_letter_arr = array();
    $letter_current_line = array();

    $ascii_arr = array();
    $next_line = array();
    $current_line = false;
		$move_current_line_down = 0;

    //split text at linebreaks
    $text_lines = preg_split('/(\r\n|\n|\r)/', $this->text);
    foreach($text_lines as $line_i => $txt)
    {
      $text_arr = str_split($txt);

      if($current_line !== false)
      {
				if($this->debug) echo 'set[line_height][val]:' . $this->set['line_height']['val']  . ' count($current_line):' . count($current_line) . ' move_current_line_down:'.$move_current_line_down.'<br />';

				if(count($current_line) > $this->set['line_height']['val'] + $move_current_line_down)
				{
					$next_line = array_splice($current_line,  $this->set['line_height']['val'] - count($current_line) + $move_current_line_down);
				}

        array_push($ascii_arr, $current_line);
        array_push($ascii_letter_arr, $letter_current_line);

        if(count($next_line) > 0)
        {
          $current_line = $next_line;
        }

        $letter_current_line = array();
      }

      for($l = 0; $l < $this->set['max_line_height']['val']; $l++)
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

            'line_height' => $this->set['line_height']['val'],
            'letter_spacing' => $this->set['letter_spacing']['val'],

						'x' => isset($this->set['letter_settings']['val'][$line_i][$letter_i]['x']) ? $this->set['letter_settings']['val'][$line_i][$letter_i]['x'] : 0,
						'y' => isset($this->set['letter_settings']['val'][$line_i][$letter_i]['y']) ? $this->set['letter_settings']['val'][$line_i][$letter_i]['y'] : 0,
          ),
        );

				//move letter right/left
				$letter_set[0]['letter_spacing'] = $letter_set[0]['letter_spacing'] + $letter_set[0]['x'];

        if(isset($this->letter_arr[$letter]))
        {
					if($this->debug) echo $letter . '<br />';

          $letter_width = $this->letter_arr[$letter][0];

					if($this->set['rand_char']['val'])
					{
						//$letter_ascii = $this->letter_arr[$letter][1][rand(0, strlen($this->letter_arr[$letter][1])-1)];
						$letters_from = array_slice($this->letter_arr[$letter], 1);
						$letters_from = mb_str_split($letters_from[0]);
						$letter_ascii = array(
							$letters_from[array_rand($letters_from)]
						);
					}
					else
					{
						$letter_ascii = array_slice($this->letter_arr[$letter], 1);
					}

					$letter_set[0]['letter_width'] = $letter_width;

					if($this->debug) echo 'move_current_line_down:' . $move_current_line_down . '<br />';

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
						if($this->debug) echo 'y > 0, move down:' . $letter_set[0]['y'] . '<br />';

						for($i = 0; $i < $letter_set[0]['y']; $i++)
						{
							array_unshift($letter_ascii, '');
						}
					}
					else if($letter_set[0]['y'] < 0) //move letter up
					{
						if($this->debug) echo 'y < 0, move up:' . $letter_set[0]['y'] . '<br />';

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
							if($this->debug) echo 'add_to_top > move_current_line_down:' . $add_to_top . '<br />';

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
					if(count($letter_ascii) > $this->set['max_line_height']['val'])
					{
						if($this->debug) echo 'current letter taller than max line height:' . count($letter_ascii) . '<br />';

						$str_len = mb_strlen($current_line[0]);
						for($i = count($current_line); $i < count($letter_ascii); $i++)
						{
							$current_line[$i] = str_repeat(' ', $str_len);
						}

						$this->set['max_line_height']['val'] = count($letter_ascii);
					}

					$current_line_width = mb_strlen($current_line[0]);
          for($l = 0; $l < $this->set['max_line_height']['val']; $l++)
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

              $current_line[$l] .= $this->muck($space_before . $line_add . $space);
            }
            else //letter_spacing <= 0
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
                  if($current_line_arr[$cl] !== ' ' && isset($this->combos[$current_line_arr[$cl]][$line_add_arr[$la]]))
                  {
                    $current_line_arr[$cl] = $this->combos[$current_line_arr[$cl]][$line_add_arr[$la]];
                  }
									else if($current_line_arr[$cl] === $line_add_arr[$la])
									{
										//do nothing, the char doesn't need to be replaced
									}
                  else
                  {
										$darker = $this->get_darker_char($current_line_arr[$cl], $line_add_arr[$la]);
										if($this->debug)
	                  {
	                    echo '1 Combo not found for "' . $current_line_arr[$cl] . '" + "' . $line_add_arr[$la] . '" using darker "' . $darker . '"<br />';
	                  }

                    $current_line_arr[$cl] = $darker;
                  }
                }
              }

              $current_line[$l] = $space_before . implode('', $this->muck($current_line_arr));
            }

            if(mb_strlen($current_line[$l]) > $this->set['max_line_width']['calc'])
            {
              $this->set['max_line_width']['calc'] = mb_strlen($current_line[$l]);
            }
          }

					$this->pre('letter_set',$letter_set);

          $letter_current_line[] = $letter_set;
        }
        else if($letter === ' ' && !isset($this->letter_arr[' ']))
        {
          $space = ' ';
          if($this->set['space_width']['val'] + $letter_set[0]['x'] > 0)
          {
            $space = str_repeat(' ', $this->set['space_width']['val'] + $letter_set[0]['x']);
          }

          for($l = 0; $l < $this->set['max_line_height']['val']; $l++)
          {
            $current_line[$l] .= $space;
            $letter_set[] = $space;

            if(mb_strlen($current_line[$l]) > $this->set['max_line_width']['calc'])
            {
              $this->set['max_line_width']['calc'] = mb_strlen($current_line[$l]);
            }
          }

          $letter_current_line[] = $letter_set;
        }
        else if($this->set['not_found']['val'] !== '')
        {
					$letter_set[0]['not_found'] = true;

          $space = ' ';
          $nf_char = $this->set['not_found']['val'] === 'char' ? $letter : $this->set['not_found']['val'];
          $nf_line = floor($this->set['line_height']['val'] / 2);

          if($this->set['space_width']['val'] > 0)
          {
            $space = str_repeat(' ', $this->set['space_width']['val']);
            $nf_char = str_repeat(' ', floor(($this->set['space_width']['val'] - 1) / 2)) . $nf_char . str_repeat(' ', floor(($this->set['space_width']['val'] - 1) / 2));
          }

          $letter_set[0]['used_char'] = $nf_char;

          for($l = 0; $l < $this->set['max_line_height']['val']; $l++)
          {
            $current_line[$l] .= ($l == $nf_line ? $nf_char : $space);
            $letter_set[] = ($l == $nf_line ? $nf_char : $space);

            if(mb_strlen($current_line[$l]) > $this->set['max_line_width']['calc'])
            {
              $this->set['max_line_width']['calc'] = mb_strlen($current_line[$l]);
            }
          }

          if($this->debug)
          {
            echo 'Letter not found, used not_found: ' . $letter . ' -> "' . $nf_char . '" ' . $nf_line . '<br />';
          }

          $letter_current_line[] = $letter_set;
        }
        else
        {
					$letter_set[0]['not_found'] = true;

          if($this->debug)
          {
            echo 'Letter not found: ' . $letter . '<br />';
          }
        }
      }

      $this->pre('next_line',$next_line);
      $this->pre('current_line',$current_line);

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


                  if($next_line_arr[$l] !== ' ' && isset($this->combos[$next_line_arr[$l]][$current_line_arr[$l]]))
                  {
                    $current_line_arr[$l] = $this->combos[$next_line_arr[$l]][$current_line_arr[$l]];
                  }
									else if($next_line_arr[$l] === $current_line_arr[$l])
									{
										//do nothing, the char doesn't need to be replaced
									}
                  else
                  {
										$darker = $this->get_darker_char($next_line_arr[$l], $current_line_arr[$l]);
										if($this->debug)
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

        $this->pre('add_to_prev_line',$add_to_prev_line);

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
	                  if($prev_line_arr[$l] !== ' ' && isset($this->combos[$prev_line_arr[$l]][$add_prev_line_arr[$l]]))
	                  {
	                    $prev_line_arr[$l] = $this->combos[$prev_line_arr[$l]][$add_prev_line_arr[$l]];
	                  }
										else if($prev_line_arr[$l] === $add_prev_line_arr[$l])
										{
											//do nothing, the char doesn't need to be replaced
										}
										else
										{
											$darker = $this->get_darker_char($prev_line_arr[$l], $add_prev_line_arr[$l]);
											if($this->debug)
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
						if($this->debug) echo 'notset ' . $prev_line_key . ' ' . $prev_letter_line_key;
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

    if(isset($current_line[0]) && mb_strlen($current_line[0]) > $this->set['max_line_width']['calc'])
    {
      $this->set['max_line_width']['calc'] = mb_strlen($current_line[0]);
    }
    $this->set['max_line_width']['val'] = $this->set['max_line_width']['calc'];
    if($this->set['line_width']['val'] === null || $this->set['line_width']['val'] === 0)
    {
      $this->set['line_width']['val'] = $this->set['max_line_width']['calc'];
    }

		//delete empty space at end of ascii_arr
		$last_line = end($ascii_arr);
		$last_line_key = key($ascii_arr);

		for (end($last_line); ($i=key($last_line))!==null; prev($last_line))
    {
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

    foreach($ascii_arr as $line_i => $line)
    {
      foreach($line as $letter_line_i => $letter_line)
      {
        $ascii_arr[$line_i][$letter_line_i] = $this->zalgo_muck($letter_line, 60);
      }
    }

    if($this->debug)
    {
      //$this->pre('ascii_arr',$ascii_arr);

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

    if($this->set['letters']['val'] === 1)
    {
      return array(
        'ascii' => $ascii_letter_arr,
      );
    }
    else
    {
      $ret_set = array();
      foreach($this->set as $key => $vals)
      {
        if($this->schema[$key]['ui'] === true)
        {
          $ret_set[$key] = $vals['val'];
        }
      }

      return array(
        'settings' => $ret_set,
        'ascii' => $ascii_arr,
      );
    }
  }

  private function load_combos()
  {
    $string = file_get_contents(__DIR__ . "/combos.json");
    $this->combos = json_decode($string, true);
  }

  public function pre($label='', $arr=array())
  {
    if($this->debug)
    {
      print("<pre style='font-size:13px;line-height:13px;'>$label:".print_r($arr,true)."</pre>");
    }
  }

  private function zalgo_muck($str, $max_muck=20)
  {
    if($this->set['muck_amount']['val'] === 0 || $this->set['muck_amount']['val'] === null)
    {
      return $str;
    }

    $muck_types = array();

    if($this->set['zalgo_above']['val'] === 1) $muck_types[] = 'above';
    if($this->set['zalgo_over']['val'] === 1) $muck_types[] = 'over';
    if($this->set['zalgo_below']['val'] === 1) $muck_types[] = 'below';
    if($this->set['zalgo_lative_above']['val'] === 1) $muck_types[] = 'latin_above';

    if(count($muck_types) === 0)
    {
      return $str;
    }

    $return_arr = is_array($str);

    if($return_arr)
    {
      $line_arr = $str;
    }
    else
    {
      $line_arr = mb_str_split($str);
    }

    $new_line_arr = array();

    foreach($line_arr as $letter_i => $letter)
    {
      $new_letter = $letter;

      for($i = 0; $i < $this->set['muck_amount']['val']; $i++)
      {
        $muck_type = $muck_types[array_rand($muck_types)];

        $add = rand(1, $max_muck);
        if(($letter === ' ' && $add === 1) || ($letter !== ' ' && $add < 10))
        {
          $new_letter .= $this->zalgo[$muck_type][array_rand($this->zalgo[$muck_type])]['u'];
        }
      }

      $new_line_arr[] = json_decode(sprintf('"%s"', $new_letter));
    }

    if($return_arr)
    {
      return $new_line_arr;
    }
    else
    {
      return implode('', $new_line_arr);
    }
  }

  private function muck($str)
  {
    if($this->set['muck_amount']['val'] === 0 || $this->set['muck_amount']['val'] === null ||
    $this->set['muck_chars']['val'] === '' || $this->set['muck_chars']['val'] === null)
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

    $char_arr = mb_str_split($this->set['muck_chars']['val']);

    foreach($str_arr as $l => $letter)
    {
      if($letter === ' ' && rand(1, 50) < $this->set['muck_amount']['val'])
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

  private function get_darker_char($char1=' ', $char2=' ')
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
}
