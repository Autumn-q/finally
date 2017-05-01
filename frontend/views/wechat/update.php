<?php

if($user){
    echo "<a href='".\yii\helpers\Url::to(['wechat/unlink'])."' class = 'btn btn-danger'>解除绑定</a>";
}else{
    echo "<a  href='".\yii\helpers\Url::to(['wechat/bang'])."' class = 'btn btn-success'>绑定账号</a>";
}