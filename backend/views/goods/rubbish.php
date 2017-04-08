<h1>回收站</h1>
<a class="btn btn-info" href="<?=\yii\helpers\Url::to(['goods/index'])?>">返回</a>
<table class="table table-bordered table-hover">
    <tr>
        <th>id</th>
        <th>商品名</th>
        <th>货号</th>
        <th>logo</th>
        <th>价格</th>
        <th>分类</th>
        <th>品牌</th>
        <th>添加时间</th>
        <th>操作</th>
    </tr>
    <?php foreach($rows as $row):?>
        <tr>
        <td><?=$row->id?></td>
        <td><?=$row->name?></td>
        <td><?=$row->sn?></td>
        <td><?=\yii\bootstrap\Html::img('@web/'.$row->logo,['width'=>'50px'])?></td>
        <td><?=$row->shop_price?></td>
        <td><?=$row->categoryName->name?></td>
        <td><?=$row->brandName->name?></td>
        <td><?=date('Y-m-d h:i:s',$row->inputtime)?></td>
        <td>
            <?=\yii\bootstrap\Html::a('撤销',['goods/save','id'=>$row->id],['class'=>'btn btn-success'])?>
            <?=\yii\bootstrap\Html::a('彻底删除',['goods/delete','id'=>$row->id],['class'=>'btn btn-danger'])?>
        </td>
        </tr>
    <?php endforeach;?>
</table>
<?php
$form = \yii\bootstrap\ActiveForm::begin([
    'method'=>'get',
    'options'=> ['class'=>'form-inline'],
    'action'=>\yii\helpers\Url::to(['goods/rubbish'])
]);
echo $form->field($model,'name')->textInput(['placeholder'=>'商品名'])->label(false);
echo '&emsp;';
echo $form->field($model,'sn')->textInput(['placeholder'=>'货号'])->label(false);
echo '&emsp;';
echo $form->field($model,'minShop')->textInput(['placeholder'=>'￥'])->label(false);
echo '-';
echo $form->field($model,'maxShop')->textInput(['placeholder'=>'￥'])->label(false);
echo '&emsp;';
echo \yii\bootstrap\Html::submitButton('搜索',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();

echo \yii\widgets\LinkPager::widget([
    'pagination'=>$pager,
    'nextPageLabel'=>'下一页',
    'prevPageLabel'=>'上一页'

])
?>
