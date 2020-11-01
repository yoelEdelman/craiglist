<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Response à une annonce</title>
</head>
<style>
    .mail{
        padding: 10px;
    }
</style>
<body>
<div class="mail">
    <div class="content">
        Bonjour <b>{{$nameUser}}</b><br>
        <span>Vous venez de recevoir un message de {{$lastName}} {{$firstName}} sur l'intitulé de l'annonce suivante: <b>{{$titleAd}}</b></span><br>
        <p>L'objet du mail est: {{$subject}}</p>
        <p>{{$message}}</p>
    </div>
</div>
</body>
</html>
