var settings = {
  font: $('#font').val(),
  text: $('#for_typing').val()
};

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

  var send_data_letters = {...send_data};
  send_data_letters.letters = 1;

  console.log('send_data', send_data);

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

          for(var key in json.settings)
          {
            settings[key] = json.settings[key];
          }

          $('#edit_ascii').empty();
          letter_json.ascii.forEach(function(line)
          {
            var $line = $('<div class="letter_line"></div>').css({
              height: settings.line_height + 'rem'
            });

            line.forEach(function(letter)
            {
              var $letter = $('#letter_template').clone();
              $letter.removeAttr('id').css({
                'margin-right': letter[0].letter_spacing + 'rem',
                height: settings.line_height + 'rem'
              });

              var letter_str = '';
              letter.forEach(function(l, i)
              {
                if(i === 0){ //settings
                  for(var key in l){
                    //$letter.find('.' + key).text(l[key]);
                  }
                }
                else
                {
                  letter_str += l + '\n';
                }
              })
              $letter.find('.letter_ascii').text(letter_str);
              $line.append($letter.show());
            })
            $('#edit_ascii').append($line);
          })

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
          settings.letters = letter_json.letters;

          set_settings();

        }
      });
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
