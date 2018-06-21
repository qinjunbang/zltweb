@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('register') }}" name="formInfo" id="formInfo">
        <div class="weui-cells weui-cells_form">
            <div class="weui-cells no-border">
                <div class="weui-cell">
                    <div class="weui-cell__hd">
                        <label class="weui-label">
                            <svg class="icon f28" aria-hidden="true">
                                <use xlink:href="#icon-user"></use>
                            </svg>
                            用户名:
                        </label>
                    </div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" type="text" placeholder="请输入用户名">
                    </div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__hd">
                        <label class="weui-label">
                            <svg class="icon f28" aria-hidden="true">
                                <use xlink:href="#icon-mobile"></use>
                            </svg>
                            手机号:
                        </label>
                    </div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" type="text" placeholder="请输入手机号">
                    </div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__hd">
                        <label class="weui-label">
                            <svg class="icon f28" aria-hidden="true">
                                <use xlink:href="#icon-lock"></use>
                            </svg>
                           密&nbsp;&nbsp;&nbsp;码:
                        </label>
                    </div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" type="text" placeholder="请输入密码">
                    </div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__bd">
                        <input class="weui-input-border" type="text" placeholder="请输入验证码">
                    </div>
                    <div class="weui-cell__hd">
                        <button type="button" class="weui-btn weui-btn_mini weui-btn_blue get-code">发送验证码</button>
                    </div>
                </div>
                <div class="weui-cell">
                    <button type="button" class="weui-btn weui-btn_blue btn-register">注册</button>
                </div>
            </div>
        </div>
    </form>


    <script>
        var timer;

        // 点击获取验证码
        $(".get-code").click(function () {
            console.log("timer", timer);
            $.alert("你点击获取验证码")
            $.post("", {}, function (res) {
                if (res) {
                    // 获取成功，开始倒计时
                    if (!timer) {
                        countdown(60);
                    }

                }
            });

        });

        // 倒计时
        function countdown(num) {
            if (num > 0) {
                num--;
                $(".get-code").text("重新发送(" + num + ")").removeClass("weui-btn_gray");
            } else {
                clearTimeout(timer);
                timer = 0;
                $(".get-code").text("发送验证码").addClass("weui-btn_blue");
                return;
            }

            console.log("num", num);
            timer = setTimeout(function () {
                countdown(num);
            }, 1000);
        }

        // 点击注册
        $(".btn-register").click(function () {
            $.alert("你点击了注册");
        });
    </script>
@endsection
