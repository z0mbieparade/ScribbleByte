<?php //running this file in the browser generates combos.json.
class Combos
{
  public $quad_combos = array();
  public $border_combos = array();
  public $combos = array();
  public $white_space = array(
    ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
  );
  public $quad_blocks = array(
    '█' => '1234',
    '▛' => '124',
    '▜' => '123',
    '▘' => '1',
    '▝' => '2',
    '▞' => '24',
    '▚' => '13',
    '▖' => '4',
    '▗' => '3',
    '▙' => '134',
    '▟' => '234',
    '▄' => '34',
    '▀' => '12',
    '▐' => '23',
    '▌' => '14',
  );
  public $by_quad = array();
  public $similar_quad_blocks = array(
    ' ' => array('▔','▁','▕','▏','░'),
    '█' => array('▆','▇','▉','▊'),
    '▄' => array('▂','▃','▅'),
    '▌' => array('▎','▍','▋')
  );
  public $psudo_shade_blocks = array();
  public $h_slice_blocks = array(
    '▁' => '1',
    '▂' => '12',
    '▃' => '123',
    '▄' => '1234',
    '▅' => '12345',
    '▆' => '123456',
    '▇' => '1234567',
    '█' => '12345678',
    '▀' => '5678',
    '▔' => '8',
  );
  public $by_h_quad = array();
  public $v_slice_blocks = array(
    '▕' => '8',
    '▐' => '5678',
    '█' => '12345678',
    '▉' => '1234567',
    '▊' => '123456',
    '▋' => '12345',
    '▌' => '1234',
    '▍' => '123',
    '▎' => '12',
    '▏' => '1',
  );
  public $by_v_quad = array();

  public $shade_blocks = array(
    '░' => 1,
    '▒' => 2,
    '▓' => 3,
    '█' => 4,
  );
  public $by_shade = array();

  public $double_border = array(
    '╔' => 345,
    '╦' => 2345,
    '╗' => 235,
    '╠' => 1345,
    '═' => 234,
    '╣' => 1235,
    '║' => 135,
    '╬' => 12345,
    '╚' => 134,
    '╩' => 1234,
    '╝' => 123,
  );
  public $bold_border = array(
    '┏' => 345,
    '╸' => 23,
    '┳' => 2345,
    '┓' => 235,
    '┣' => 1345,
    '━' => 234,
    '┫' => 1235,
    '┃' => 135,
    '╻' => 53,
    '╋' => 12345,
    '┛' => 123,
    '╹' => 13,
    '┗' => 134,
    '┻' => 1234,
    '┛' => 123,
  );
  public $thin_border = array(
    //'╭' => ,
    '┌' => 345,
    '─' => 234,
    '┬' => 2345,
    '╶' => 34,
    '┐' => 235,
    //'╮' => ,
    '╵' => 13,
    '│' => 135,
    '╲' => 369,
    '╳' => 36789,
    '╱' => 378,
    '│' => 135,
    '├' => 1345,
    '┼' => 12345,
    '┤' => 1235,
    '╷' => 35,
    //'╰' => ,
    '└' => 134,
    '╴' => 23,
    '┴' => 1234,
    '─' => 234,
    '┘' => 123,
    //'╯' => ,
  );

  public $thin_double_border = array(
    '╒' => '35cd',
    '╤' => '35bcd',
    '╕' => '35bc',
    '╞' => '135cd',
    '╓' => '34ce',
    '╥' => '234ce',
    '╖' => '23ce',
    '╪' => '135bcd',
    '╟' => '34ace',
    '╫' => '234ace',
    '╢' => '23ace',
    '╪' => '135bcd',
    '╙' => '34ac',
    '╨' => '234ac',
    '╜' => '23ac',
    '╡' => '135cd',
    '╘' => '13cd',
    '╧' => '13bcd',
    '╛' => '13bc',
  );

  /*
  6 1 7  f a g
  2 3 4  b c d
  8 5 9  h e i
  */
  public $thin_bold_border = array(
    '┍' => '35cd',
    '┯' => '35bcd',
    '┭' => '345bc',
    '┰' => '234ce',
    '┮' => '235cd',
    '┱' => '34bce',
    '┲' => '23cde',
    '╾' => '24bc',
    '┒' => '23ce',
    '╽' => '13ce',
    '┎' => '34ce',
    '╁' => '1234ce',
    '┦' => '235ac',
    '┾' => '1235cd',
    '┫' => '23ace',
    '┡' => '35acd',
    '┑' => '35bc',
    '┩' => '35acb',
    '┠' => '34ace',
    '╄' => '235acd',
    '╃' => '345abc',
    '┟' => '134ce',
    '╊' => '23acde',
    '┿' => '135bcd',
    '┥' => '135bc',
    '╈' => '13bcde',
    '╇' => '35abcd',
    '┝' => '135cd',
    '┿' => '135bcd',
    '╉' => '34abce',
    '┞' => '345ac',
    '╆' => '123cde',
    '╅' => '134bce',
    '┨' => '23ace',
    '┢' => '13cde',
    '┕' => '13cd',
    '┪' => '13bce',
    '╂' => '234ace',
    '┽' => '1345bc',
    '┧' => '123ce',
    '╀' => '2345ac',
    '┚' => '23ac',
    '╿' => '35ac',
    '┖' => '34ac',
    '╼' => '23cd',
    '┹' => '34abc',
    '┺' => '23acd',
    '┵' => '134bc',
    '┸' => '234ac',
    '┶' => '123cd',
    '┷' => '13bcd',
    '┙' => '13bc',
  );

  public function __construct()
  {
    foreach($this->quad_blocks as $block => $quads) $this->by_quad[$quads] = $block;
    foreach($this->h_slice_blocks as $block => $quads) $this->by_h_quad[$quads] = $block;
    foreach($this->v_slice_blocks as $block => $quads) $this->by_v_quad[$quads] = $block;
    foreach($this->shade_blocks as $block => $shade) $this->by_shade[$shade] = $block;

    $this->mesh_quads($this->quad_blocks, $this->similar_quad_blocks, $this->by_quad, false);
    $this->mesh_quads($this->h_slice_blocks, array(), $this->by_h_quad, true);
    $this->mesh_quads($this->v_slice_blocks, array(), $this->by_v_quad, true);

    $this->mesh_shades($this->shade_blocks, $this->by_shade);

    //deal with " " blocks that aren't " ".
    foreach ($this->similar_quad_blocks[' '] as $block1)
    {
      if(!isset($this->quad_combos[$block1])) $this->quad_combos[$block1] = array();

      foreach($this->quad_combos as $block2 => $blocks)
      {
        $this->quad_combos[$block1][$block2] = $block2;

        if(!isset($this->quad_combos[$block2][$block1])) $this->quad_combos[$block2][$block1] = $block2;
      }
    }

    $this->border_quad($this->double_border);
    $this->border_quad($this->bold_border);
    $this->border_quad($this->thin_border);

    $this->multi_border_quad($this->thin_border, $this->double_border, $this->thin_double_border);
    $this->multi_border_quad($this->thin_border, $this->bold_border, $this->thin_bold_border);
    $this->multi_border_quad($this->bold_border, $this->double_border, array());

    //combine border/quads, quads cover border
    foreach($this->quad_combos as $block => $combo_arr)
    {
      if(!isset($this->combos[$block])) $this->combos[$block] = $combo_arr;

      foreach($this->border_combos as $border => $combo_arr2)
      {
        if(!isset($this->combos[$border])) $this->combos[$border] = $combo_arr2;

        $this->combos[$block][$border] = $block;
        $this->combos[$border][$block] = $block;
      }
    }

    //make sure all characters cover whitespace
    foreach($this->combos as $block => $combo_arr)
    {
      foreach($this->white_space as $empty_block)
      {
        if(!isset($this->combos[$empty_block])) $this->combos[$empty_block] = array();

        $this->combos[$block][$empty_block] = $block;
        $this->combos[$empty_block][$block] = $block;
      }
    }
  }

  public function get_char_rgb($char)
  {
    $img = imagecreatetruecolor(12, 20);
    $bg = imagecolorallocate($img, 255, 255, 255);
    $textcolor = imagecolorallocate($img, 0, 0, 0);
    imagefilledrectangle($img, 0, 0, 20, 20, $bg);
    imagettftext($img, 15, 0, 0, 15, $textcolor, 'css/Menlo-Regular.ttf', $char);

    $x = imagesx($img);
    $y = imagesy($img);
    $tmp_img = ImageCreateTrueColor(1,1);
    ImageCopyResampled($tmp_img,$img,0,0,0,0,1,1,$x,$y);
    $rgb = ImageColorAt($tmp_img,0,0);
    $r   = ($rgb >> 16) & 0xFF;
    $g = ($rgb >> 8) & 0xFF;
    $b  =  $rgb & 0xFF;

    var_dump($r, $g, $b);

    ob_start();
    imagepng($img);
    $imgData = ob_get_clean();
    imagedestroy($img);
    echo '<img style="border:1px solid #F00;" src="data:image/png;base64,'.base64_encode($imgData).'" /><br />';

    return array('r' => $r, 'g' => $g, 'b' => $b);
  }

  public function get_darker($char1=' ', $char2=' ')
  {
    $rgb1 = $this->get_char_rgb($char1);
    $rgb2 = $this->get_char_rgb($char2);

    if($rgb1['r'] < $rgb2['r']) return $char1;
    if($rgb1['r'] > $rgb2['r']) return $char2;
    return $char1;
  }

  public function closest_match($input, $match_arr)
  {
    $closest = null;
    $shortest = -1;
    foreach ($match_arr as $match)
    {
        $lev = levenshtein($input, $match);

        if ($lev == 0) //exact match
        {
            $closest = $match;
            $shortest = 0;

            break;
        }

        if ($lev <= $shortest || $shortest < 0)
        {
            $closest  = $match;
            $shortest = $lev;
        }
    }

    return $closest;
  }

  public function mesh_quads($quad_blocks=array(), $similar_quad_blocks=array(), $by_quad=array(), $get_closest=false)
  {
    foreach($quad_blocks as $block1 => $quads1)
    {
      if(!isset($this->quad_combos[$block1])) $this->quad_combos[$block1] = array();
      if(!isset($this->psudo_shade_blocks[$block1])) $this->psudo_shade_blocks[$block1] = mb_strlen($quads1);

      foreach($quad_blocks as $block2 => $quads2)
      {
        $new_quad = '';

        if($quads1 === $quads2){
          $new_quad = $quads1;
        } else {
          for($i = 1; $i < 10; $i++)
          {
            if(stripos($quads1, $i.'') !== false || stripos($quads2, $i.'') !== false) $new_quad .= $i;
          }
        }

        if(!isset($by_quad[$new_quad]))
        {
          if($get_closest)
          {
            $closest = $this->closest_match($new_quad, array_keys($by_quad));

            if(isset($by_quad[$closest]))
            {
              $this->quad_combos[$block1][$block2] = $by_quad[$closest];
              echo 'Quad not found: "' . $new_quad . '" quad1: ' . $quads1 . ' quad2: ' . $quads2 . ' closest used: "' . $closest . '"<br />';
            }
            else
            {
              echo 'Quad not found: "' . $new_quad . '" quad1: ' . $quads1 . ' quad2: ' . $quads2 . '<br />';
            }
          }
          else
          {
            echo 'Quad not found: "' . $new_quad . '" quad1: ' . $quads1 . ' quad2: ' . $quads2 . '<br />';
          }
        }
        else
        {
          $this->quad_combos[$block1][$block2] = $by_quad[$new_quad];
        }

        if(isset($similar_quad_blocks[$block2]))
        {
          foreach($similar_quad_blocks[$block2] as $blockish)
          {
            $this->quad_combos[$block1][$blockish] = $by_quad[$new_quad];
          }
        }
      }

      if(isset($similar_quad_blocks[$block1]))
      {
        foreach($similar_quad_blocks[$block1] as $blockish)
        {
          $this->quad_combos[$blockish] = $this->quad_combos[$block1];
          $this->quad_combos[$blockish][$blockish] = $blockish;
        }
      }
    }
  }

  public function mesh_shades($shade_blocks=array(), $by_shade=array())
  {
    foreach($shade_blocks as $block1 => $shade1)
    {
      if(!isset($this->quad_combos[$block1])) $this->quad_combos[$block1] = array();

      foreach($shade_blocks as $block2 => $shade2)
      {
        $max_shade = $shade2 > $shade1 ? $shade2 : $shade1;
        if($max_shade < 4) $max_shade++;

        if(!isset($by_shade[$max_shade]))
        {
          echo 'Shade not found: "' . $max_shade . '" shade1: ' . $shade1 . ' shade2: ' . $shade2 . '<br />';
        }
        else
        {
          $this->quad_combos[$block1][$block2] = $by_shade[$max_shade];
        }
      }

      foreach($this->psudo_shade_blocks as $p_block => $p_shade)
      {
        if(!isset($this->quad_combos[$block1][$p_block]))
        {
          if($p_shade > $shade1)
          {
            $this->quad_combos[$block1][$p_block] = $p_block;
            $this->quad_combos[$p_block][$block1] = $p_block;
          }
          else
          {
            $this->quad_combos[$block1][$p_block] = $block1;
            $this->quad_combos[$p_block][$block1] = $block1;
          }
        }
      }
    }
  }

  /*
  6 1 7  f a g
  2 3 4  b c d
  8 5 9  h e i
  */
  public function border_quad($borders=array())
  {
    $by_border_quad = array();
    foreach($borders as $block => $quads) $by_border_quad[$quads] = $block;

    foreach($borders as $block1 => $quads1)
    {
      if(!isset($this->border_combos[$block1])) $this->border_combos[$block1] = array();

      foreach($borders as $block2 => $quads2)
      {
        $new_quad = '';

        if($quads1 === $quads2){
          $new_quad = $quads1;
        } else {
          for($i = 1; $i < 10; $i++)
          {
            if(stripos($quads1, $i.'') !== false || stripos($quads2, $i.'') !== false) $new_quad .= $i;
          }
        }

        if(!isset($by_border_quad[$new_quad]))
        {
          echo '!border_quad: "' . $new_quad . '" quad1: ' . $block1 . ' = ' . $quads1 . ' quad2: ' . $block2 . ' = ' . $quads2 . '<br />';
        }
        else
        {
          $this->border_combos[$block1][$block2] = $by_border_quad[$new_quad];
        }
      }
    }
  }

  function multi_border_quad($borders1=array(), $borders2=array(), $border_combos=array())
  {
    $by_border_quad1 = array();
    foreach($borders1 as $block => $quads) $by_border_quad1[$quads] = $block;
    $by_border_combo = array();
    foreach($border_combos as $block => $quads) $by_border_combo[$quads] = $block;

    $l_arr = array('a','b','c','d','e','f','g','h','i');
    $by_border_quad2 = array();
    foreach($borders2 as $block => $quads){
      $letter_quad = '';
      for($i = 1; $i < 10; $i++)
      {
        if(stripos($quads, $i.'') !== false) $letter_quad .= $l_arr[$i - 1];
      }
      $borders2[$block] = $letter_quad;
      $by_border_quad2[$letter_quad] = $block;
    }

    foreach($borders1 as $block1 => $quads1)
    {
      if(!isset($this->border_combos[$block1])) $this->border_combos[$block1] = array();

      foreach($borders2 as $block2 => $quads2)
      {
        if(!isset($this->border_combos[$block2])) $this->border_combos[$block2] = array();

        $new_quad = '';
        $darker_quad = '';

        if($quads1 === $quads2){
          $new_quad = $quads1;
        } else {
          for($i = 1; $i < 10; $i++)
          {
            if(stripos($quads1, $i.'') !== false) $new_quad .= $i;
          }

          for($i = 1; $i < 10; $i++)
          {
            if(stripos($quads2, $l_arr[$i - 1]) !== false) $new_quad .= $l_arr[$i - 1];
            if(stripos($quads1, $i.'') !== false || stripos($quads2, $l_arr[$i - 1]) !== false) $darker_quad .= $l_arr[$i - 1];
          }
        }

        if(!isset($by_border_combo[$new_quad]))
        {
          if(isset($by_border_quad2[$darker_quad]))
          {
            $this->border_combos[$block1][$block2] = $by_border_quad2[$darker_quad];
            $this->border_combos[$block2][$block1] = $by_border_quad2[$darker_quad];
          }
          else
          {
            echo '!multi_border_quad: "' . $new_quad . '" quad1: ' . $block1 . ' = ' . $quads1 . ' quad2: '. $block2 . ' = ' . $quads2 . '<br />';
          }
        }
        else
        {
          $this->border_combos[$block1][$block2] = $by_border_combo[$new_quad];
          $this->border_combos[$block2][$block1] = $by_border_combo[$new_quad];
        }
      }
    }
  }

  public function write_combos()
  {
    print("<pre>combos:".print_r($this->combos,true)."</pre>");

    $fp = fopen('combos.json', 'w');
    fwrite($fp, json_encode($this->combos));
    fclose($fp);
  }
}

$combos = New Combos();
$combos->write_combos();
