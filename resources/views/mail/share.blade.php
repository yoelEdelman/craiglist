<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Partage d'une annonce</title>
</head>
<style>
    .mail{
        padding: 10px;
    }
    .content{
        margin-top: 10px;
    }
</style>
<body>
<div class="mail">
    <div>
        Bonjour <br>
        <span> {{$lastName}} {{$firstName}} vous a partagé une annonce, voici le lien ci-dessous</span><br>
        <a href="{{$linkUrl}}">{{$titleAd}}</a>

        <p class="content">{{$message}}</p>
    </div>
</div>
</body>
</html>
