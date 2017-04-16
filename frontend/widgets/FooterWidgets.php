<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/11
 * Time: 19:23
 */

namespace frontend\widgets;


use frontend\models\ArticleCategory;
use yii\base\Widget;

class FooterWidgets extends Widget
{
    public function run()
    {
        $html = '';
        $rows = ArticleCategory::find()->all();
        foreach($rows as $k => $row){
        $k++;
        $html .=  "<div class='bnav$k'><h3><b></b> <em>".$row->name."</em></h3>";
        $html .="<ul>";
            foreach($row->article as $r){
                $html .= '<li><a href="">'.$r->name.'</li>';
                    }
            $html .="</ul></div>";
            }
            return $html;
        }
    }


