<table class="table table-hover table-bordered">
    <tr>
        <th>id</th>
        <th>菜单名</th>
        <th>描述</th>
        <th>路由</th>
        <th>操作</th>
    </tr>
    <?php foreach($rows as $row):?>
        <tr>
            <td><?=$row->id?></td>
            <td><?=str_repeat('----',$row->depth).$row->name?></td>
            <td><?=$row->description?></td>
            <td><?=$row->url?></td>
            <td>
                <?=\yii\helpers\Html::a('编辑',['menu/edit','id'=>$row->id],['class'=>'btn btn-success'])?>
                <?=\yii\helpers\Html::a('删除',['menu/del','id'=>$row->id],['class'=>'btn btn-danger'])?>
            </td>
        </tr>
        <?php foreach($row->children as $child):?>
            <tr>
                <td><?=$child->id?></td>
                <td><?=str_repeat('----',$child->depth).$child->name?></td>
                <td><?=$child->description?></td>
                <td><?=$child->url?></td>
                <td>
                    <?=\yii\helpers\Html::a('编辑',['menu/edit','id'=>$child->id],['class'=>'btn btn-success'])?>
                    <?=\yii\helpers\Html::a('删除',['menu/del','id'=>$child->id],['class'=>'btn btn-danger'])?>
                </td>
            </tr>
        <?php endforeach;?>
    <?php endforeach;?>
</table>