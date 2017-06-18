<?php

/**
 * 辅助函数
 * @author geekzhumail@gmail.com
 * @since 2015-03-04
 */

if (! function_exists('isWechatAgent')) {
    /**
     * 判断是否为微信浏览器
     */
    function isWechatAgent() {
        $ua = Request::server('HTTP_USER_AGENT');
        if (Agent::isMobile()) {
            // 确定为手机用户
            if (strpos($ua, 'MicroMessenger')) {
                // 确定为微信浏览器
                return true;
            }
        }
        return false;
    }
}

/**
 * 产生一个多位随机字符串
 */
if (! function_exists('createNoncestr')) {
    function createNoncestr( $length = 32, $type = 'all')
    {
        if ($type == 'all') {
            $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        } else if($type == 'number') {
            $chars = "0123456789";
        }
        $str ="";
        for ( $i = 0; $i < $length; $i++ )  {
            $str.= substr($chars, mt_rand(0, strlen($chars)-1), 1);
        }
        return $str;
    }
}
/**
 * laravel asset封装
 * @author geekzhumail@gmail.com
 * @since 2015-04-11
 */
if (! function_exists('asset_cdn')) {
    /**
     * 获取静态资源的绝对路径
     */
    function asset_cdn($path = '', $isSetSuffix = true) {
        $url = Config::get('app.static_url');
        $v = Config::get('app.static_version');
        if (App::isLocal() || empty($url)) {
            return asset($path);
        }
        $url = $url . $path;
        $urlParams = parse_url($url);
        $query = [];
        if (! empty($urlParams['query'])) {
            parse_str($urlParams['query'], $query);
        }
        if ($isSetSuffix === true) {
            $query = array_merge($query, ['_v' => $v]);
        }
        $url = $urlParams['scheme'] . '://' . $urlParams['host'] . (empty($urlParams['port']) || $urlParams['port'] == '80' || $urlParams['port'] == '443' ? '' : ':' . $urlParams['port']) . $urlParams['path'];
        if ($query) {
            $url .= '?' . http_build_query($query);
        }

        return asset($url);
    }
}

