var settings = {
  font: $('#font').val(),
  text: $('#for_typing').val(),
  letter_settings: {}
};

var rem_size = {};

function update_letter_settings($letter, key, val)
{
  clearTimeout(typingTimer);

  let line_i = $letter.attr('line_i');
  let letter_i = $letter.attr('letter_i');
  let current_val = $letter.prop('settings')[key];

  if(isNaN(line_i))
  {
    console.error('line_i NaN', line_i);
    return;
  }

  if(isNaN(letter_i))
  {
    console.error('letter_i NaN', letter_i);
    return;
  }

  if(isNaN(current_val))
  {
    console.error('current_val NaN', current_val);
    return;
  }

  line_i = +line_i;
  letter_i = +letter_i;

  try
  {
    settings.letter_settings[line_i][letter_i][key] = +current_val + +val;
  }
  catch(e)
  {
    settings.letter_settings[line_i] = settings.letter_settings[line_i] || {};
    settings.letter_settings[line_i][letter_i] = settings.letter_settings[line_i][letter_i] || {};
    settings.letter_settings[line_i][letter_i][key] = +current_val + +val;
  }

  if(settings.letter_settings[line_i][letter_i][key] === 0){
    delete settings.letter_settings[line_i][letter_i][key];
  }

  console.log(key, settings.letter_settings[line_i][letter_i][key]);
  typingTimer = setTimeout(update_ascii, 1000);
}

function update_ascii_letters(json, send_data, callback)
{
  var send_data_letters = {...send_data};
  send_data_letters.letters = 1;

  $.ajax({
    type: "POST",
    url: 'function.php',
    data: send_data_letters,
    success: function(response)
    {
      try {
        var letter_json = JSON.parse(response);
      } catch (e) {
        console.log(response);
        console.error(e);
        var letter_json = {error: e.message};
      }

      console.log('letter_json', letter_json);

      if(letter_json.error)
      {
        console.error(letter_json.error);
        return;
      }

      settings.letter_settings = settings.letter_settings || {};

      var lines_found = {};

      letter_json.ascii.forEach(function(line, line_i)
      {
        lines_found[line_i] = true;

        var letters_found = {};
        var append_line = false;
        var $line = $('.letter_line[line_i='+line_i+']');
        if($line.length === 0)
        {
          append_line = true;
          var $line = $('<div class="letter_line"></div>')
        }

        $line.css({
          height: settings.line_height + 'rem'
        }).attr('line_i', line_i);

        settings.letter_settings[line_i] = settings.letter_settings[line_i] || {};

        line.forEach(function(letter, letter_i)
        {
          if(!isNaN(letter.x) && letter.x != 0)
          {
            settings.letter_settings[line_i][letter_i] = settings.letter_settings[line_i][letter_i] || {};
            settings.letter_settings[line_i][letter_i].x = +letter.x;
          }

          if(!isNaN(letter.y) && letter.y != 0)
          {
            settings.letter_settings[line_i][letter_i] = settings.letter_settings[line_i][letter_i] || {};
            settings.letter_settings[line_i][letter_i].y = +letter.y;
          }

          if(!isNaN(letter.line_height) && +letter.line_height > settings.line_height)
          {
            $line.css({height: letter.line_height + 'rem'});
          }

          var append = false;
          var $letter = $('.letter[line_i='+line_i+'][letter_i='+letter_i+']');
          if($letter.length > 0)
          {
            $letter.css({
              'margin-right': letter[0].char === ' ' ? 0 : (+letter[0].letter_spacing * rem_size.width) + 'px',
              height: letter[0].line_height + 'rem'
            })
            .attr('char', letter[0].char)
            .prop('settings', letter[0]);
          }
          else
          {
            append = true;
            var $letter = $('#letter_template').clone();
            $letter.removeAttr('id')
            .css({
              'margin-right': letter[0].char === ' ' ? 0 : (+letter[0].letter_spacing * rem_size.width) + 'px',
              height: letter[0].line_height + 'rem'
            })
            .attr('char', letter[0].char)
            .attr('line_i', line_i)
            .attr('letter_i', letter_i)
            .prop('settings', letter[0]);

            $letter.find('.move_down').on('click.move_down', function()
            {
              update_letter_settings($(this).closest('.letter'), 'y', 1);
            });
            $letter.find('.move_up').on('click.move_up', function()
            {
              update_letter_settings($(this).closest('.letter'), 'y', -1);
            });
            $letter.find('.move_right').on('click.move_right', function()
            {
              update_letter_settings($(this).closest('.letter'), 'x', 1);
            });
            $letter.find('.move_left').on('click.move_left', function()
            {
              update_letter_settings($(this).closest('.letter'), 'x', -1);
            });
          }

          if(!Array.isArray(letter))
          {
            console.error({...letter});
            return;
          }

          if(letter[0].char === ' '){
            $letter.addClass('space_char');
          } else {
            $letter.removeClass('space_char');
          }

          if(letter[0].not_found){
            $letter.addClass('not_found');
          } else {
            $letter.removeClass('not_found');
          }

          letters_found[letter_i] = true;

          var letter_str = '';
          var move_current_line_down = letter[0].move_current_line_down ? +letter[0].move_current_line_down : 0;
          var move_current_letter_up = 0;
          var trim_top = true;
          letter.forEach(function(l, i)
          {
            if(i === 0){ //settings
              for(var key in l){
                $letter.find('.' + key).text(l[key]);
              }
            }
            else
            {
              if(l.trim() !== '')
              {
                trim_top = false;
              }

              if(i > move_current_line_down || trim_top === false)
              {
                letter_str += l + '\n';
              }

              if(i <= move_current_line_down && trim_top === false)
              {
                move_current_letter_up--;
              }
            }
          });

          $letter
          .css('margin-top', move_current_letter_up + 'rem')
          .find('.letter_ascii').text(letter_str);

          if(append)
          {
            $line.append($letter.show());
          }
        });

        //delete extra letters from line, happens sometimes if
        //line previously had more letters than it does currently
        $line.find('.letter').each(function()
        {
          var letter_i = $(this).attr('letter_i');
          if(!letters_found[letter_i])
          {
            $(this).remove();
          }
        });

        if(append_line)
        {
          $('#edit_ascii').append($line);
        }
      })

      //delete extra lines
      $('#edit_ascii .letter_line').each(function()
      {
        var line_i = $(this).attr('line_i');
        if(!lines_found[line_i])
        {
          $(this).remove();
        }
      });

      callback();
    }
  });
}

function update_ascii(update_font)
{
  settings.text = $('#for_typing').val();

  if(update_font)
  {
    var send_data = {
      font: $('#font').val(),
      text: $('#for_typing').val()
    };
  }
  else
  {
    var send_data = {...settings};
    delete send_data.ascii;
    delete send_data.copy_ascii;
    delete send_data.letters;
  }

  $.ajax({
    type: "POST",
    url: 'function.php',
    data: send_data,
    success: function(response)
    {
      try {
        var json = JSON.parse(response);
      } catch (e) {
        console.log(response);
        console.error(e);
        var json = {error: e.message};
      }

      console.log('json', json);

      if(json.error)
      {
        console.error(json.error);
        return;
      }

      for(var key in json.settings)
      {
        if(!['letter_settings'].includes(key))
        {
          settings[key] = json.settings[key];
        }
      }

      if(settings.single_char)
      {
        $('#settings').addClass('single_char');
        var font_size = settings.font_size ? settings.font_size + 'rem' : 5 + 'rem';
        $('#copy_ascii').css({
          'font-size': font_size,
          'line-height': font_size
        });

        var copy_text = '';
        json.ascii.forEach(function(line)
        {
          line.forEach(function(letter_line)
          {
            copy_text += letter_line + '\n';
          })
        })

        settings.copy_ascii = copy_text;
        settings.ascii = json.ascii;

        set_settings();
      }
      else
      {
        $('#settings').removeClass('single_char');
        update_ascii_letters(json, send_data, function()
        {
          var copy_text = '';
          json.ascii.forEach(function(line)
          {
            line.forEach(function(letter_line)
            {
              copy_text += letter_line + '\n';
            })
          })

          settings.copy_ascii = copy_text;
          settings.ascii = json.ascii;

          set_settings();
        })
      }
    }
  });
}

function set_settings()
{
  for(var key in settings)
  {
    $('#' + key).val(settings[key]);

    if(!['font', 'text', 'copy_ascii', 'ascii'].includes(key))
    {
      $('#' + key).off('change').on('change', function()
      {
        settings[this.id] = $(this).val();
        update_ascii();
      });
    }
  }
}

var typingTimer;

$(document).ready(function()
{
  rem_size.width = $('#rem_size').width();
  rem_size.height = $('#rem_size').height();
  $('#rem_size').hide();

  update_ascii();

  $('#for_typing').on('keyup', function () {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(update_ascii, 500);
  }).on('keydown', function () {
    clearTimeout(typingTimer);
  });

  $('#font').on('change', function()
  {
    settings.font = $('#font option:selected').val()
    update_ascii(true);
  });
});
