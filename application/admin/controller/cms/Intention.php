<?php

namespace app\admin\controller\cms;

use app\common\controller\Adminbase;
use app\admin\model\cms\Category as CategoryModel;
use think\Db;

class Intention extends Adminbase
{

    protected function initialize()
    {
        parent::initialize();
        $this->modelClass = new CategoryModel;
        //取得当前内容模型模板存放目录
        $themePath = TEMPLATE_PATH . (config('site.theme') ?: "default") . DS . "cms" . DS;
        //取得栏目频道模板列表
        $this->categoryTemplate = str_replace($themePath . DS, '', glob($themePath . DS . 'category*'));
        //取得栏目列表模板列表
        $this->listTemplate = str_replace($themePath . DS, '', glob($themePath . DS . 'list*'));
        //取得内容页模板列表
        $this->showTemplate = str_replace($themePath . DS, '', glob($themePath . DS . 'show*'));
        //取得单页模板
        $this->pageTemplate = str_replace($themePath . DS, '', glob($themePath . DS . 'page*'));
    }

    public function index()
    {
        if ($this->request->isAjax()) {
            $limit = input("limit",10,"int");
            $page = input("page",1,"int");
            $filter = input("filter","");
            $where = [];
            if($filter){
                $filter = json_decode($filter,true);
                if(isset($filter["name"])){
                    $where[] = ["name","like",trim($filter["name"])];
                }
                if(isset($filter["intention"])){
                    $where[] = ["intention","like",trim($filter["intention"])];
                }
                if(isset($filter["tel"])){
                    $where[] = ["tel","like",trim($filter["tel"])];
                }
                if(isset($filter["weixin"])){
                    $where[] = ["weixin","like",trim($filter["weixin"])];
                }
                if(isset($filter["remark"])){
                    $where[] = ["remark","like",trim($filter["remark"])];
                }
            }
            $list = Db::table("yzn_intention")->where($where)->order("status asc,created_dt desc")->paginate($limit,NULL,["page"=>$page]);
            $list = $list->toArray();
            unset($v);
            $result = ["code" => 0, "count" => $list["total"], "data" =>$list["data"]];
            return json($result);
        }
        return $this->fetch();
    }

    public function edit(){
        $id= input("id",0,"int");
        if(!$id){
            return json(["code"=>400,"msg"=>"缺少参数"]);
        }
        Db::table("yzn_intention")->where("id",$id)->update(["status"=>1]);
    }
}