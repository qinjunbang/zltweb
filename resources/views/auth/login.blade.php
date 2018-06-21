@extends ('layouts/app')

@section ('content')
    <div class="lgoin-header">
        <div class="logo">
            <img src="./img/login-bg.jpg" alt="" class="img-responsive">
        </div>
    </div>
    <div class="weui-tab">
        <div class="login-content">
            <form method="POST" action="{{ route('register') }}" name="formInfo" id="formInfo">
                <div class="weui-cells weui-cells_form no-border">
                    <div class="weui-cells no-border">
                        <div class="weui-cell">
                            <div class="weui-cell__hd mr-10">
                                <svg class="icon f28 white" aria-hidden="true">
                                    <use xlink:href="#icon-user"></use>
                                </svg>
                            </div>
                            <div class="weui-cell__bd">
                                <input class="weui-input white" type="text" placeholder="请输入用户名/Email/手机号">
                            </div>
                        </div>
                        <div class="weui-cell">
                            <div class="weui-cell__hd mr-10">
                                <svg class="icon f28 white" aria-hidden="true">
                                    <use xlink:href="#icon-lock"></use>
                                </svg>
                            </div>
                            <div class="weui-cell__bd">
                                <input class="weui-input white" type="password" placeholder="请输入密码">
                            </div>
                        </div>
                        <div class="weui-cell">
                            <button type="button" class="weui-btn weui-btn_blue btn-login">登录</button>
                        </div>
                        <div class="other">
                            <a href="{{ route('register') }}" class="pull-left">注册</a>
                            <a href="{{ route('password.request') }}" class="pull-right">忘记密码</a>
                        </div>
                    </div>
                </div>
            </form>
            <div class="other-login">
                <div class="title text-center white">第三方登录</div>
                <div class="weui-flex">
                    <div class="weui-flex__item text-center">
                        <div class="round">
                            <a href="">
                                <svg class="icon f28 wechat-green" aria-hidden="true">
                                    <use xlink:href="#icon-wechat-fill"></use>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="weui-flex__item text-center">
                        <div class="round">
                            <a href="">
                                <svg class="icon f28 qq-blue" aria-hidden="true">
                                    <use xlink:href="#icon-QQ"></use>
                                </svg>
                            </a>

                        </div>
                    </div>
                    <div class="weui-flex__item text-center">
                        <div class="round">
                            <a href="">
                                <svg class="icon f28 weibo-red" aria-hidden="true">
                                    <use xlink:href="#icon-weibo"></use>
                                </svg>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection