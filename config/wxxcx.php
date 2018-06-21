<?php

return [
	/**
	 * 小程序APPID
	 */
    'appid' => 'wx1fbcf9abe2de12d7',
    /**
     * 小程序Secret
     */
    'secret' => 'cf8e5f3c9bce229d0d6c0a746dd0fa31',
    /**
     * 小程序登录凭证 code 获取 session_key 和 openid 地址，不需要改动
     */
    'code2session_url' => "https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code",
];
