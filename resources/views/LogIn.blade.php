<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
@if(session('msg'))
@if(session('msg')->status=="false")
<script type="text/javascript">alert("{{session('msg')->message}}");</script>
@endif
@endif
<body>
	<div>
		<h4>LogIn API</h4>
		<form method="POST" action="{{url('logInPost')}}" enctype="multipart/form-data">
			@csrf

		<input type="text" name="email" placeholder="Email"><br>
		<input type="text" name="password" placeholder="Password"><br>
		<input type="submit" name="" value="submit">
		</form>
	</div>
	<br>
	<br>
	<br>
	<br>
	<h4>Register API</h4>
	<div>
		<form method="POST" action="{{url('RegisterUser')}}" enctype="multipart/form-data">
			@csrf
		<input type="text" name="name" placeholder="Name">
		<input type="text" name="email" placeholder="Email">
		<input type="text" name="password" placeholder="Password">
		<input type="text" name="c_password" placeholder="Password">
		<input type="submit" name="" value="submit">
		</form>

	</div>
	<br>
	<h4>Change Password API {{date('d-M-Y H:i:s')}} {{date('l')}} {{date('w')}}</h4>
	<div>
		<form method="POST" action="{{url('PutPatchDataCurl')}}" enctype="multipart/form-data">
			@csrf
		<input type="hidden" name="Put"  value="1">
		<input type="text" name="email" placeholder="Email">
		<input type="text" name="password" placeholder="Password">
		<input type="text" name="c_password" placeholder="New Password">
		<input type="submit" name="" value="submit">
		</form>

	</div>
	<br>
	<br>
	<br>
	<h4>Delete User API {{date('d-M-Y H:i:s')}}</h4>

</body>
</html>