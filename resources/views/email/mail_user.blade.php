<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test Email</title>
</head>
<body>
    <h1>DATI DI RIEPILOGO</h1>
    <p>Name: {{ $mailData['name'] }}</p>
    <p>Email: {{ $mailData['email'] }}</p>
    <p>Ubicazione: {{ $mailData['ubicazione'] }}</p>
    <p>Password: {{ $mailData['password'] }}</p>
    <p>Ruolo: {{ $mailData['ruolo'] }}</p>
</body>
</html>