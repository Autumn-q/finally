<?=\yii\bootstrap\Html::a('添加',['role/add'],['class'=>'btn btn-warning'])?>
<table class="table table-hover table-bordered">
    <tr>
        <th>角色名</th>
        <th>简介</th>
        <th>操作</th>
    </tr>
    <?php foreach($rows as $row):?>
        <tr>
            <td><?=$row->name?></td>
            <td><?=$row->description?></td>
            <td>
                <?=\yii\bootstrap\Html::a('编辑',['role/edit','name'=>$row->name],['class'=>'btn btn-success'])?>
                <?=\yii\bootstrap\Html::a('删除',['role/del','name'=>$row->name],['class'=>'btn btn-info'])?>
            </td>
        </tr>
    <?php endforeach;?>
</table>