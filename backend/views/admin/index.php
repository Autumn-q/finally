<h1>管理员表</h1>
<a class="btn btn-info" href="<?=\yii\helpers\Url::to(['admin/add'])?>">添加</a>
<table class="table table-bordered table-hover">
    <tr>
        <th>id</th>
        <th>用户名</th>
        <th>邮箱</th>
        <th>注册时间</th>
        <th>最后登录时间</th>
        <th>最后登录ip</th>
        <th>操作</th>
    </tr>
    <?php foreach($rows as $row):?>
        <tr>
            <td><?=$row->id?></td>
            <td><?=$row->username?></td>
            <td><?=$row->email?></td>
            <td><?=date('Y-m-d h:i:s',$row->add_time)?></td>
            <td><?=$row->last_login_time?date('Y-m-d h:i:s',$row->last_login_time):'从未登录'?></td>
            <td><?=$row->last_login_ip?></td>
            <td>
                <?=\yii\bootstrap\Html::a('编辑',['admin/edit','id'=>$row->id],['class'=>'btn btn-success'])?>
                <?=\yii\bootstrap\Html::a('删除',['admin/del','id'=>$row->id],['class'=>'btn btn-danger'])?>
            </td>
        </tr>
    <?php endforeach;?>
</table>

