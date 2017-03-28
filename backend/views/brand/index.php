<h1>品牌表</h1>
<a class="btn btn-info" href="<?=\yii\helpers\Url::to(['brand/add'])?>">添加</a>
<a class="btn btn-warning" href="<?=\yii\helpers\Url::to(['brand/rubbish'])?>">回收站</a>
<table class="table table-bordered table-hover">
    <tr>
        <th>id</th>
        <th>name</th>
        <th>logo</th>
        <th>status</th>
        <th>操作</th>
    </tr>
    <?php foreach($rows as $row):?>
        <tr>
            <td><?=$row->id?></td>
            <td><?=$row->name?></td>
            <td><?=\yii\bootstrap\Html::img('@web/'.$row->logo,['width'=>'30px'])?></td>
            <td><?=\backend\models\Brand::$status_name[$row->status]?></td>
            <td>
                <?=\yii\bootstrap\Html::a('编辑',['brand/edit','id'=>$row->id],['class'=>'btn btn-success'])?>
                <?=\yii\bootstrap\Html::a('删除',['brand/del','id'=>$row->id],['class'=>'btn btn-danger'])?>
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

