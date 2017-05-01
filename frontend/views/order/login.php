<div class="login w990 bc mt10">
    <div class="login_hd">
        <h2>用户注册</h2>
        <b></b>
    </div>
    <div class="login_bd">
        <div class="login_form fl">
            <?php
            $form = \yii\widgets\ActiveForm::begin();
            echo '<ul>';
            echo $form->field($model,'username',[
                'options'=>['tag'=>'li'],//设置包裹的标签
            ])->textInput(['class'=>'txt']);
            echo $form->field($model,'password',[
                'options'=>['tag'=>'li'],//设置包裹的标签
            ])->passwordInput(['class'=>'txt']);
            echo '<li><label for="">&nbsp;</label>'.$form->field($model,'remember')->checkbox().'</li><br/><br/>';
            echo '<li><label for="">&nbsp;</label>'.\yii\helpers\Html::submitButton('',['class'=>'login_btn']).'</li>';
            echo '</ul>';
            \yii\widgets\ActiveForm::end();
            ?>
        </div>
    </div>
</div>
