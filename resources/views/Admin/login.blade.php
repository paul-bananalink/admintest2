<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Account</title>
    
    <!--base css styles-->
    <link rel="stylesheet" href="{{ asset('css/common/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common/font-awesome/css/font-awesome.min.css') }}">
    <script src="{{ asset('js/common/jquery-2.1.4.min.js') }}"></script>

    @vite(['resources/vite/css/login.css'])
</head>

<body>
    <div class="style_bg">
        <div id="__layout">
            <form action="{{route('admin.login')}}" method="POST">
                @csrf
                <div class="login-header">
                    <div class="brand">
                        <strong>
                            <i class="fa fa-cog m-r-5 text-success"></i>ADMIN MODE </strong>
                    </div>
                </div>

                <div class="login-content">
                    <div class="form-group">
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-warning" role="alert">{{ $error }}</div>
                            @endforeach
                        @endif
                        <input type="text" id="member_id" name="member_id" placeholder="아이디를 입력하세요" class="form-control input-lg">
                    </div>

                    <div class="form-group m-b-20">
                        <input type="password" id="member_password" name="member_password" placeholder="비밀번호를 입력하세요" class="form-control input-lg">
                    </div>

                    <div class="form-group">
                        <div class="form-group">
                            <div class="inputcaptcha">
                                <input id="captcha_key" type="text" class="form-control input-lg"
                                    placeholder="캡차를 입력하세요" name="captcha_key">
                            </div>
                        </div>
                        <div class="captcha">
                            <span class="captcha-img">
                                <img id="captcha-img" style="width: 60%;" src="{{ captcha_src() }}" alt="captcha">
                            </span>
                            <div type="button" class="btn btn-danger" class="reload" id="reload">
                                &#x21bb;
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="controls">
                            <label class="checkbox">
                                <input type="checkbox" value="remember"> 
                                <span>Remember me</span>
                            </label>
                        </div>
                    </div>

                    <div class="login-buttons">
                        <button type="submit" tabindex="3" class="btn btn-success btn-block btn-lg"
                            style="font-family: arial; width: 315px;">
                            <strong>Admin Login</strong>
                           
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @vite(['resources/vite/js/captcha/captcha.js','resources/vite/js/login.js'])
</body>
</html>
