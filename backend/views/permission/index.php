<?=\yii\bootstrap\Html::a('添加',['permission/add'],['class'=>'btn btn-warning'])?>
<table class="table table-hover table-bordered">
    <tr>
        <th>权限名</th>
        <th>简介</th>
        <th>操作</th>
    </tr>
    <?php foreach($rows as $row):?>
        <tr>
            <td><?=$row->name?></td>
            <td><?=$row->description?></td>
            <td><?=\yii\bootstrap\Html::a('删除',['permission/del','name'=>$row->name],['class'=>'btn btn-info'])?></td>
        </tr>
    <?php endforeach;?>
</table>