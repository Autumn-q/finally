<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/11
 * Time: 22:54
 */

namespace frontend\widgets;


use frontend\models\GoodsCategory;
use yii\base\Widget;

class CateGoryWidgets extends Widget
{
    public $cate_id = '';
    public function run()
    {
        //查出所有的三级分类
        $rows = GoodsCategory::find()->where(['id'=>$this->cate_id])->all();
        //var_dump($rows);exit;
        //查出二级分类
        foreach($rows as $row){
            $two = GoodsCategory::findOne(['id'=>$row->parent_id]);
        }
        //查出顶级分类
        $zero = GoodsCategory::findOne(['id'=>$two->parent_id]);

        //查出所有的二级分类
        $children = GoodsCategory::find()->where(['parent_id'=>$zero->id])->all();
        //查出顶级分类
        $html = '';
        $html .="<div style='clear:both;'></div>
                <!-- 列表主体 start -->
                 <div class='list w1210 bc mt10'>
                 <!-- 面包屑导航 start -->
                 <div class='breadcrumb'>
                 <h2>当前位置：<a href=''>首页</a> > <a href=''>".$two->name."</a></h2></div>
            <!-- 面包屑导航 end -->";
        $html .="<!-- 左侧内容 start -->
		<div class='list_left fl mt10'>
			<!-- 分类列表 start -->
            <div class='catlist'>";
        $html .="<h2>".$zero->name."</h2>
				<div class='catlist_wrap'>";
        foreach($children as $child){
            //var_dump($child);exit;
            $html .="<div class='child'>
                        <h3 class='on'><b></b>$child->name</h3>
						<ul>";
            foreach($rows as $row){
                $html .="<li><a href=''>$row->name</a></li";
            }
            $html .= "</ul>
					</div>";
        }
        $html .= "</div><div style='clear:both; height:1px;'></div></div><div style='clear:both;''></div>";
        return $html;
    }
}