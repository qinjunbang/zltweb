<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>登入页面</title>
    <link rel="stylesheet" type="text/css" href="css/logincss/normalize.css" />
    <link rel="stylesheet" type="text/css" href="css/logincss/demo.css" />
    <!--必要样式-->
    <link rel="stylesheet" type="text/css" href="css/logincss/component.css" />
    <!--[if IE]>
    <script src="js/loginjs/html5.js"></script>
    <![endif]-->
</head>

<body>
<div class="container demo-1">
    <div class="content">
        <div id="large-header" class="large-header">
            <!--动态效果-->
            <canvas id="#"></canvas>
            <div class="logo_bos">
                <div class="logo_boss"></div>
            </div>
            <div class="logo_box">
                <form action="{{ route('login') }}" name="f" method="post">
                    @csrf
                    <div class="input_outer">
                        <span class="u_user"></span>
                        <input name="email" class="text" style="color: #FFFFFF !important" type="text" placeholder="请输入账户">
                    </div>
                    <div class="input_outer">
                        <span class="us_uer"></span>
                        <input name="password" class="text" style="color: #FFFFFF !important; position:absolute; z-index:100;"value="" type="password" placeholder="请输入密码">
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                        </label>
                    </div>
                    <div class="coded">
                        <a href="" class="left" style="  float:left;">忘记密码？</a>
                        <a href="" class="right" style=" float:right;">注册</a>
                    </div>
                    <input class="mb2" type="submit" value="Submit">

                </form>
            </div>
            <div class="iconic">
                <img src="img/security1.png" alt="">
                <img src="img/security2.png" style="margin:0  26%" alt="">
                <img src="img/security3.png"  style=" float:right;" alt="">
            </div>
        </div>
    </div>
</div><!-- /container -->
<script src="js/loginjs/TweenLite.min.js"></script>
<script src="js/loginjs/EasePack.min.js"></script>
<!--<script src="js/rAF.js"></script>-->
<script src="js/loginjs/demo-1.js"></script>
</body>