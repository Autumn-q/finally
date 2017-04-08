<?php
/**
 * @var $this \yii\web\view
 */
?>
<h1>商品分类表</h1>

<a class="btn btn-info" href="<?=\yii\helpers\Url::to(['goods-category/add'])?>">添加</a>
<table class="table table-bordered table-hover">
    <tr>
        <th>id</th>
        <th>分类名</th>
        <!--<th>父类id</th>
        <th>左边界</th>
        <th>右边界</th>
        <th>深度</th>
        <th>树</th>
        <th>简介</th>-->
        <th>操作</th>
    </tr>
    <tbody class="category">
    <?php foreach($rows as $row):?>
        <tr lft=<?=$row->lft?> rgt=<?=$row->rgt?> tree=<?=$row->tree?>>
            <td><?=$row->id?></td>
            <td class=""><?=str_repeat('－－',$row->depth).$row->name?><span class="glyphicon glyphicon-minus goods" style="float:right;"></span></td>
            <td>
                <?=\yii\bootstrap\Html::a('编辑',['goods-category/edit','id'=>$row->id],['class'=>'btn btn-success'])?>
                <?=\yii\bootstrap\Html::a('删除',['goods-category/del','id'=>$row->id],['class'=>'btn btn-danger'])?>
            </td>
        </tr>
    <?php endforeach?>
    </tbody>
</table>
<?php
    $js=<<<EOT
    $('.goods').click(function(){
        //改变图标,如果有就删除,没有就添加一个类
        $(this).toggleClass('glyphicon glyphicon-minus');
        $(this).toggleClass('glyphicon glyphicon-plus');
        //获取当前的左值和右值,树值
        var lftValue = $(this).closest('tr').attr('lft');//当前左值
        var rgtValue = $(this).closest('tr').attr('rgt');//当前右值
        var treeValue = $(this).closest('tr').attr('tree');//当前树
        //获取所有左值比当前值大并且右值比当前值小的tr
        $(".category tr").each(function(){
            if($(this).attr('tree')==treeValue && $(this).attr('lft') > lftValue && $(this).attr('rgt') < rgtValue){
                $(this).fadeToggle();
            }

        })
    })
EOT;

    $this->registerJs($js);
?>

