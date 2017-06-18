<?php

namespace App\Http\Controllers;

use Response;
use Exception;
use CURLFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * 聚合数据
 * @author jason <numberjason@gmail.com>
 * @since 2017-05-19
 */
class ApiJuHeController extends ApiBaseController
{
    /**
     * [juheCard 聚合证件识别]
     */
    public function juheCard()
    {
        try {
            $data = [];
            $header = array(
                "Content-type:multipart/form-data"
            );
            $config = array(
                'key' => env('JUHE_CARD_KEY');
                //聚合数据证件识别接口的URL地址
                'url' => 'http://v.juhe.cn/certificates/query.php',
                //证件的类型,这里是身份证正面
                'type' => 'image/jpg',
                //证件图片的类型
                'cardType' => '3',  //二代身份证
                // 'cardType' => '1001',
            );
            if (class_exists('CURLFile')) {
                $cfile = new CURLFile(realpath('/Users/jason/Downloads/jason.jpg'));
            } else {
                $cfile = "@/Users/jason/Downloads/jason.jpg";
            }
            $data = array(
                'cardType' => $config['cardType'],
                'pic' => $cfile,
                'key' => $config['key']
            );
            $resp = $this->post($config['url'], '', $data, $header);
            Log::info($resp);
            dd($resp);
        } catch (Exception $e) {
            Log::error($e);
        }
    }

    /**
     * [get get请求]
     * @param string $url 路径
     * @param array $params 传输参数
     * @return json $response 返回数据
     */
    protected function get($url, $params = '')
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
            CURLOPT_TIMEOUT => 180,
            CURLOPT_CONNECTTIMEOUT => 30
        ];
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        $resp_status = curl_getinfo($ch);
        curl_close($ch);
        if (intval($resp_status["http_code"]) == 200) {
            return $response;
        } else {
            throw new Exception('请求超时[' . $resp_status["http_code"] . ']');
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
            CURLOPT_CONNECTTIMEOUT => 30,
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

    /**
     * [getMobileRegion 获取手机归属地]
     */
    public function getMobileRegion(Request $request)
    {
        try {
            $data = [];
            $config = array(
                'key' => env('MOBILE_REGION_KEY'),
                //聚合数据手机号码归属地接口的URL地址
                'url' => 'http://apis.juhe.cn/mobile/get'
            );
            $data['key'] = $config['key'];
            $data['phone'] = $request->input('phone');
            $data['dtype'] = 'json';
            $resp = $this->get($config['url'], $data);
            $this->setRespMsg($resp);
        } catch (Exception $e) {
            $this->handle($e);
        }
        return $this->output();
    }
}
