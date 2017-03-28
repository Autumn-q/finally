<h1>品牌回收站</h1>
<a class="btn btn-info" href="<?=\yii\helpers\Url::to(['brand/index'])?>">返回品牌页</a>
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
                <?=\yii\bootstrap\Html::a('撤销',['brand/revoke','id'=>$row->id],['class'=>'btn btn-success'])?>
                <?=\yii\bootstrap\Html::a('彻底删除',['brand/delete','id'=>$row->id],['class'=>'btn btn-danger'])?>
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