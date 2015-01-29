<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Subscribe to Newsletter</title>
  <style>
    /*Some Little Minor CSS to tidy up the form*/
    body{margin:0;font-family:Arial,Tahoma,sans-serif;
      text-align:center;padding-top:60px;color:#666;
      font-size:24px}
      input{font-size:18px}
      input[type=text]{width:300px}
      div.content{padding-top:24px;font-weight:700;
        font-size:24px}
        .success{color:#0b0}
        .error{color:#b00}
  </style>
</head>
<body>
  {{-- Form Starts Here --}}
  {{Form::open(array('url'=> URL::to('/'),'method' => 'post'))}}
    <p>Simple Newsletter Subscription</p>
    {{Form::text('email',null,array('placeholder'=>'Type your E-mail address here'))}}
    {{Form::submit('Submit!')}}
  {{Form::close()}}
  {{-- Form Ends Here --}}

  {{-- This div will show the ajax response --}}
  <div class="content"></div>

  {{-- Because it'll be sent over AJAX, We add the jQuery source --}}

  {{ HTML::script('http://code.jquery.com/jquery-1.8.3.min.js') }}

  <script type="text/javascript">
  //Even though it's on footer, I just like to make
    //sure that DOM is ready
  $(function(){
    //We hide de the result div on start
    $('div.content').hide();
    //This part is more jQuery Related. In short, we
      //make an Ajax post request and get the response
      //back from server
    $('input[type="submit"]').click(function(e){
      e.preventDefault();
      $.post('/', {
        email: $('input[name="email"]').val()
      }, function($data){
        if($data=='1') {
          $('div.content').hide().removeClass
            ('success error').addClass('success').html
            ('You\'ve successfully subscribed to our newsletter').fadeIn('fast');
        } else {
          //This part echos our form validation errors
          $('div.content').hide().removeClass
            ('success error').addClass('error').html
            ('There has been an error occurred:<br /><br />'+$data).fadeIn('fast');
        }
      });
    });
    //We prevented to submit by pressing enter or any other way
    $('form').submit(function(e){
      e.preventDefault();
      $('input[type="submit"]').click();
               });
             });
  </script>
</body>
</html>