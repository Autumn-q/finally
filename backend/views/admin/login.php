<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'username');
echo $form->field($model,'password')->passwordInput();
echo $form->field($model,'remember',['inline'=>true])->checkbox();
echo $form->field($model,'verifyCode')->widget(\yii\captcha\Captcha::className(),['captchaAction'=>'admin/captcha']);
//echo \yii\bootstrap\Html::a('注册',['admin/add'],['class'=>'btn btn-warning']);
echo '&emsp;';
echo \yii\bootstrap\Html::submitButton(' 登录',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();
