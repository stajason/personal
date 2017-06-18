<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Response;
use Exception;

class ApiBaseController extends Controller {

    /**
     * Api返回信息
     */
    protected $respInfo = ['errcode' => 50000, 'errmsg' => '系统错误,操作失败'];

    /**
     * init instance
     */
    public function __construct()
    {
    }

    /**
     * 异常处理
     */
    protected function handle(Exception $e)
    {
        $code = $e->getCode();
        if ($code == 0) {
            $code = 50000;
        }
        $this->respInfo['errcode'] = $code;
        $this->respInfo['errmsg'] = $e->getMessage();
        //$this->respInfo['errmsg'] = $e;
        Log::error($e);
        //$this->respInfo['errmsg'] = $e->getTraceAsString();
    }

    /**
     * 获取返回信息
     */
    protected function getRespInfo()
    {
        return $this->respInfo;
    }

    /**
     * 设置返回信息
     */
    protected function setRespInfo($respInfo)
    {
        $this->respInfo = $respInfo;
    }

    /**
     * 设置返回信息
     */
    protected function setRespMsg($info = [], $errmsg = 'success')
    {
        $resp = ['errcode' => 0, 'errmsg' => $errmsg];
        if (! is_array($info)) {
            $info = $info->toArray();
        }
        $resp = array_merge($resp, $info);
        $this->setRespInfo($resp);
    }

    /**
     * 输出
     */
    protected function output()
    {
        return Response::json($this->getRespInfo());
    }

}
