<?php
// +----------------------------------------------------------------------
// | Yzncms [ 御宅男工作室 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2018 http://yzncms.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 御宅男 <530765310@qq.com>
// +----------------------------------------------------------------------

// +----------------------------------------------------------------------
// | Links模型
// +----------------------------------------------------------------------
namespace app\admin\model\links;

use think\Model;

/**
 * 模型
 */
class Terms extends Model
{
    protected static function init()
    {
        self::afterDelete(function ($row) {
            //删除分类下的友情链接
            Links::where('termsid', $row->id)->delete();
        });
    }
}
