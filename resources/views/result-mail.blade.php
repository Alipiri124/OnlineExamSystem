<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{ $data['title']}}</title>
</head>
<body>

<p>
	<b>Hii {{ $data['name']}},</b> Your Exam({{ $data['exam_name']}}) review passed,
	So now you can check your Marks.
</p>

<a href="{{ $data['url']}}">Click here to go on results Page.</a>
<p>Thank you.</p>
</body>
</html>