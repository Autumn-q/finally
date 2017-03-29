
<h1>文章表</h1>

<a class="btn btn-info" href="<?=\yii\helpers\Url::to(['article/add'])?>">添加</a>
<table class="table table-bordered table-hover">
    <tr>
        <th>id</th>
        <th>文章名</th>
        <th>文章分类</th>
        <th>状态</th>
        <th>录入时间</th>
        <th>操作</th>
    </tr>
    <?php foreach($rows as $row):?>
        <tr>
            <td><?=$row->id?></td>
            <td><?=$row->name?></td>
            <td><?=$row->article_category->name?></td>
            <td><?=\backend\models\ArticleCategory::$status_name[$row->status]?></td>
            <td><?=date('Y-m-d h:i:s',$row->inputtime)?></td>
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