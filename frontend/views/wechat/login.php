<div class="login w990 bc mt10">
    <div class="login_hd">
        <h2>用户绑定</h2>
        <b></b>
    </div>
    <div class="login_bd">
        <div class="login_form fl">
            <?php
            $form = \yii\bootstrap\ActiveForm::begin();
            echo $form->field($model,'username');
            echo $form->field($model,'password')->passwordInput();
            echo \yii\helpers\Html::submitButton('绑定',['class'=>'btn btn-info']);
            \yii\bootstrap\ActiveForm::end();
            ?>
        </div>
    </div>
</div>
