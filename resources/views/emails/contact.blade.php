<!DOCTYPE html>
<html>
<head>
    <title>Contact Form Email</title>
</head>
<body>
    <h2>Contact Form Submission</h2>

    <p>Name: {{ $data['name'] }}</p>
    <p>Email: {{ $data['email'] }}</p>
    <p>Subject: {{ $data['subject'] }}</p>
    <p>Message: {{ $data['message'] }}</p>
</body>
</html>
