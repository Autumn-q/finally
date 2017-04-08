<h1>商品相册</h1>
<?=\yii\bootstrap\Html::a('添加 ',['gallery/add?goods_id='.$goods_id],['class'=>'btn btn-info'])?>
&ensp;<a class="btn btn-warning" href="<?=\yii\helpers\Url::to(['goods/index'])?>">返回商品页</a>
<table class="table table-bordered table-hover">
    <tr>
        <th>相片</th>
        <th>操作</th>
    </tr>
    <?php foreach($rows as $row):?>
        <tr>
            <td><?=\yii\helpers\Html::img('@web/'.$row->path,['width'=>'100px'])?></td>
            <td>
                <?=\yii\bootstrap\Html::a('删除',['gallery/del?id='.$row->id.'&goods_id='.$row->goods_id],['class'=>'btn btn-danger'])?>
            </td>
        </tr>
    <?php endforeach;?>
</table>
