<?php

namespace app\cms\controller;

use think\Controller;
use think\Validate;
use think\Db;
use think\Cache;

class Concat extends Controller
{
    public function save(Validate $validate)
    {
        $param = request()->param();
        $rule = [
            "name|姓名" => "require",
            "tel|电话" => "require",
            "weixin|微信号" => "require",
            "intention|意向" => "require",
        ];
        if (!$validate->check($param, $rule)) {
            return json(["code" => 400, "msg" => $validate->getError()]);
        }
        $ip = md5('concat' . request()->ip());
        if (cache($ip)) {
            return json(["code" => 400, "msg" => "再次提交需等待一分钟"]);
        }
        cache($ip, "1", 60);
        $insert = [
            "name" => $param["name"],
            "tel" => $param["tel"],
            "weixin" => $param["weixin"],
            "intention" => $param["intention"],
            "remark" => isset($param["remark"])?$param["remark"]:"",
        ];
        Db::table("yzn_intention")->insert($insert);
        return json(["code" => 200, "msg" => "提交成功"]);
    }
}