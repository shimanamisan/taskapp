<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <link rel="stylesheet" href="/css/style.css">
      <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
      <title>TodoApp</title>

        <script>
            window.Laravel = {};
            // window.Laravel.csrfTokenという変数にcsrfトークンを入れている
            window.Laravel.csrfToken = "{{ csrf_token() }}";
        </script>
    </head>
    <body>
        <div id="app">
        
        </div>
    </body>
    
    <script src="{{ mix('js/app.js') }}"></script>
</html>