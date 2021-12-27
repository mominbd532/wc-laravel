
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>{{env('APP_NAME')}}PDF invoice</title>
	<link rel="stylesheet" href="{{asset('css/pdf-style.css')}}">
	<style type="text/css" ></style>

</head>
<body class="invoice">

	@yield('content')
</body>
</html>
