<?php

namespace App\Http\Controllers;

use Response;
use Illuminate\Support\Facades\Log;

/**
 * 星火教育点赞
 * @author jason <numberjason@gmail.com>
 */
class PageHomeController extends Controller
{
    /**
     * [xinghuo 触发事件]
     */
    public function xinghuo()
    {
        try {
            for ($i=0; $i < 5; $i++) {
                $resp = $this->apiTest();
                Log::info($resp);
                $time = rand(5, 11);
                $count = $i + 2;
                $sleepInfo = '睡眠时间为' . $time . '秒；准备第' . $count . '次捕捉';
                Log::info($sleepInfo);
                sleep($time);
                echo $resp;
            }
        } catch (Exception $e) {
            Log::error($e);
        }
    }

    /**
     * [apiTest 星火点赞接口信息]
     * @return json $resp 返回数据
     */
    public function apiTest()
    {
        try {
            $data = [];
            $header = array(
                "Accept:*/*
                Accept-Encoding:gzip, deflate
                Accept-Language:en-US,en;q=0.8,zh-TW;q=0.6,zh;q=0.4
                Cache-Control:no-cache
                Connection:keep-alive
                Content-Length:509
                Content-Type:application/json
                Host:datalog.eqxiu.com
                Origin:http://g.eqxiu.com
                Pragma:no-cache
                Referer:http://g.eqxiu.com/s/bHya7s8d?eqrcode=1&from=groupmessage
                User-Agent:Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36"
            );
            $time = time() . '020';
            $data = '{"ua":"mozilla/5.0 (macintosh; intel mac os x 10_12_4) applewebkit/537.36 (khtml, like gecko) chrome/58.0.3029.110 safari/537.36","netType":"unknown","eqxPlatformType":"view","eqxPlatformVersion":"fc0eb4e","categoryOne":"scene_preview","categoryOneId":"11","categoryTwoId":15,"categoryTwo":"互动计数喜欢","itemType":"内容页","itemId":84905486,"pageSizeTotal":"12","pageCurrentNum":null,"itemMaps":null,"pubOwner":84905486,"mediaType":"MacIntel","refer":null,"actionType":4,"actionTime":"'.$time.'"}';
            $resp = $this->post('http://datalog.eqxiu.com/logserver/v0.1/push', '', $data, $header);
            return $resp;
        } catch (Exception $e) {
            Log::error($e);
        }
    }

    /**
     * [post post请求]
     * @param string $url 路径
     * @param array $params 传输参数
     * @param array $data 传输参数
     * @param string $headers http报头
     * @return json $response 返回数据
     */
    protected function post($url, $params = '', $data = '', $headers = [])
    {
        // if (strpos($url, 'https://') === false && strpos($url, 'http://') === false) {
        //     $url = $this->url . $url;
        // }
        if ($params) {
            $url .= '?'.http_build_query($params);
        }
        $ch = curl_init();
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_TIMEOUT => 180,
            CURLOPT_CONNECTTIMEOUT => 30
        ];
        if ($headers) {
            $options[CURLOPT_HTTPHEADER] = $headers;
        }
        if ($data) {
            $options[CURLOPT_POSTFIELDS] = $data;
        }
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        $resp_status = curl_getinfo($ch);
        curl_close($ch);
        if (intval($resp_status["http_code"]) == 200) {
            return $response;
        } else {
            throw new Exception('请求超时[' . $resp_status['http_code'] . ']');
        }
    }
}
