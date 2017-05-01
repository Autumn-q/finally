<?php

namespace frontend\models;

use Yii;

class Locationxy extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'localtionxy';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['openId','string'],
            [['location_X','location_Y'],'required'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'openId' => 'openId',
            'location_X' => 'x坐标',
            'location_Y' => 'y坐标',
        ];
    }
    public static function getSearch($openId)
    {
        //根据openId去查询坐标
        $location  = self::findOne(['openId'=>$openId]);
        $location_x = $location->location_X;
        $location_y = $location->location_Y;
        $api = "http://api.map.baidu.com/place/v2/search?query=".$message->Content."&page_size=10&page_num=0&scope=1&location=".$location_x.",".$location_y."&radius=2000&output=xml&ak=C4bSjmxiZYAiubEGGZadu2GeQOe1U1PZ";
        $rows = simplexml_load_string(file_get_contents($api));
        $content ='';
        /*<result>
<name>mint薄荷餐厅(世纪金源购物中心店)</name>
<location>
<lat>39.964928</lat>
<lng>116.294304</lng>
</location>
<address>北京市海淀区远大路1号</address>
<telephone>(010)88875888</telephone>*/
        foreach($rows->results as $row){

            foreach($row as $r){
                $content .= "您的周围有:".$r['name']
                    ."联系电话:".$r->telephone
                    ."地址:".$r->address;
            }
        }
        return 1;
    }

}
