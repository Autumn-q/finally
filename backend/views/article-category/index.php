<?php
/* @var $this yii\web\View */
?>
<h1>文章分类</h1>

<a class="btn btn-info" href="<?=\yii\helpers\Url::to(['article-category/add'])?>">添加</a>
<table class="table table-bordered table-hover">
    <tr>
        <th>id</th>
        <th>分类名</th>
        <th>简介</th>
        <th>状态</th>
        <th>操作</th>
    </tr>
    <?php foreach($rows as $row):?>
        <tr>
            <td><?=$row->id?></td>
            <td><?=$row->name?></td>
            <td><?=mb_substr($row->name,0,20)?></td>
            <td><?=\backend\models\ArticleCategory::$status_name[$row->status]?></td>
            <td>
                <?=\yii\bootstrap\Html::a('编辑',['article/edit','id'=>$row->id],['class'=>'btn btn-success'])?>
                <?=\yii\bootstrap\Html::a('删除',['article/del','id'=>$row->id],['class'=>'btn btn-danger'])?>
            </td>
        </tr>
    <?php endforeach?>
</table>
<?php
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$pager,
    'nextPageLabel'=>'下一页',
    'prevPageLabel'=>'上一页'

])
?>

