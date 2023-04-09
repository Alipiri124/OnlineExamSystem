<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{ $data['title'] }}</title>
</head>
<body>
<table>
	<tr>
		<th>Name</th>
		<th>{{ $data['name'] }}</th>
	</tr>
	<tr>
		<th>Email</th>
		<th>{{ $data['email'] }}</th>
	</tr>
	<tr>
		<th>Password</th>
		<th>{{ $data['password'] }}</th>
	</tr>
</table>

<a href="{{ $data['url']}}">Click here to login your account.</a>
<p>Thank You!</p>
</body>
</html>