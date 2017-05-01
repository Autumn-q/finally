<table class="table table-border table-hover">
    <tr>
        <th>用户名</th>
        <th>邮箱</th>
        <th>手机号</th>
        <th>注册时间</th>
        <th>最后登录时间</th>
        <th>修改</th>
    </tr>
    <tr>
        <td><?=$rows->username?></td>
        <td><?=$rows->email?></td>
        <td><?=$rows->tel?></td>
        <td><?=date('Y-m-d H:i:s',$rows->create_add)?></td>
        <td><?=date('Y-m-d H:i:s',$rows->last_login_time)?></td>
        <td><?=\yii\bootstrap\Html::a('修改',[\yii\helpers\Url::to(['wechat/edit'])],['class'=>'btn btn-info'])?></td>
    </tr>
</table>