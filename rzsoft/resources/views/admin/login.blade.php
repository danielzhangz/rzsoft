<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv=X-UA-Compatible content=IE=EmulateIE11>
	<link rel="stylesheet" href="{{asset('resources/views/admin/style/css/ch-ui.admin.css')}}">
	<link rel="stylesheet" href="{{asset('resources/views/admin/style/font/css/font-awesome.min.css')}}">
</head>
{{--<body style="background:#F3F3F4;">--}}
<body style="margin:0; background:url(../../../resources/mypic/main3.jpg) no-repeat; background-size:100% 100%; ">
<div class="login_box" id="login1" style="position:absolute; width:147px; height:140px; left:60%; top:40%">
    {{--<div class="login_box" id="login1">--}}
		{{--<h1>OFFICE</h1>--}}
		{{--<h2>欢迎使用办公辅助平台</h2>--}}
		<div class="form">
			@if(session('msg'))
			<p style="color:red">{{session('msg')}}</p>
			@endif
			<form action="" method="post">
				{{csrf_field()}}
				<ul>
					<li>
					<input type="text" name="user_name" class="text"/>
						<span><i class="fa fa-user"></i></span>
					</li>
					<li>
						<input type="password" name="user_pass" class="text"/>
						<span><i class="fa fa-lock"></i></span>
					</li>
					<li>
						<input type="text" class="code" name="code"/>
						<span><i class="fa fa-check-square-o"></i></span>
						<img src="{{url('admin/code')}}" alt="" onclick="this.src='{{url('admin/code')}}?'+Math.random()">
					</li>
					<li>
						<input type="submit" value="立即登陆" />
					</li>
				</ul>
			</form>
			<p><a href="#">返回首页</a> &copy; 2016 Powered by <a href="http://www.zenitron.com.tw" target="_blank">http://www.zenitron.com.tw</a></p>
		</div>
	</div>
</body>

</html>