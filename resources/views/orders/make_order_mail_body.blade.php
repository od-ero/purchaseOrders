<!DOCTYPE html>
<html>
<head>
    <title>{{ $mailData['title'] ?? 'Test Mail' }}</title>
</head>
<body>
    <h1>{{ $mailData['title'] }}</h1>
    <p>{{$mailData['body'] }}</p>
    <ul>
      
    </ul>
</body>
</html>