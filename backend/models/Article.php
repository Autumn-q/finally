<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $name
 * @property integer $article_category_id
 * @property string $intro
 * @property integer $status
 * @property integer $sort
 * @property integer $inputtime
 */
class Article extends \yii\db\ActiveRecord
{
    public $content;
    public static $status_name=['1'=>'是', 0=>'否'];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_category_id', 'status','sort', 'inputtime'], 'integer'],
            [['intro','content'], 'required'],
            [['intro'], 'string'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '文章名',
            'article_category_id' => '文章分类id',
            'intro' => '简介',
            'status' => '状态',
            'sort' => '排序',
            'content'=>'内容',
            'inputtime' => '录入时间',
        ];
    }
    //关联文章分类
    public function getArticle_category(){
        return $this->hasOne(ArticleCategory::className(),['id'=>'article_category_id']);
    }
    //查询出分类数据
    public static function getCategoryOptions()
    {
        $category = ArticleCategory::find()->asArray()->all();
        return ArrayHelper::map($category,'id','name');
    }
}
