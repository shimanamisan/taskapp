<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script
        async
        src="https://www.googletagmanager.com/gtag/js?id=UA-138230091-1"
        ></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() {
            dataLayer.push(arguments);
        }
        gtag("js", new Date());

        gtag("config", "UA-138230091-1");
        </script>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="/css/style.css">
        <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
        <title>TaskApp</title>
      
        <script>
            window.Laravel = {};
            // グローバルオブジェクトのプロパティにcsrfトークンを格納
            window.Laravel.csrfToken = "{{ csrf_token() }}";
        </script>
    </head>
    <body id="js-modal-lock">
        <div id="app"></div>
    </body>
    
    <script src="{{ mix('js/app.js') }}"></script>
</html>