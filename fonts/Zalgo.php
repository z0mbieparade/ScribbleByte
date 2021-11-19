<?php
function gen_text($use_set=array(), $text='', $debug=false)
{
  $font_set = array(
    'case_insensitive' => null,
    'char_pre' => '',
    'font_size' => 3,
    'letter_spacing' => 0,
    'letters' => null,
    'line_height' => 1,
    'muck_amount' => 10,
    'much_chars' => '',
    'not_found' => 'char',
    'not_found' => null,
    'single_char' => 1,
    'space_width' => 1,
  );

  foreach($use_set as $key => $val)
  {
    if($use_set[$key] === null)
    {
      if(isset($font_set[$key]) && $font_set[$key] !== null)
      {
        $use_set[$key] = $font_set[$key];
      }
      else
      {
        if($debug)
        {
          echo 'Warning: ' . $key . ' not found in font file.<br />';
        }
      }
    }
  }

  $marks = array(
    //Marks that appear above a letter...
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
    //Marks that appear below a letter...
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
    //Marks that appear over a letter...
    array('u'=>'\u0334', 'h'=>'820'),
    array('u'=>'\u0335', 'h'=>'821'),
    array('u'=>'\u0336', 'h'=>'822'),
    array('u'=>'\u0337', 'h'=>'823'),
    array('u'=>'\u0338', 'h'=>'824'),
    //Latin marks that appear above a letter...
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
  );

  $ascii_arr = array();
  $text_lines = preg_split('/(\r\n|\n|\r)/', $text);
  foreach($text_lines as $line_i => $line)
  {
    $line_arr = mb_str_split($line);
    $new_line = '';

    foreach($line_arr as $letter_i => $letter)
    {
      $new_line .= $letter;

      for($i = 0; $i < $use_set['muck_amount']; $i++)
      {
        $add = rand(1, 10);
        if($add > 3)
        {
          //$new_line .= '&#' . $marks[array_rand($marks)]['h'] . ';';
          $new_line .= $marks[array_rand($marks)]['u'];
        }
      }
    }

    $ascii_arr[] = array(json_decode(sprintf('"%s"', $new_line)));
  }

  return array(
    'settings' => $use_set,
    'ascii' => $ascii_arr,
  );
}
