<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'username');
echo $form->field($model,'email');
echo $form->field($model,'tel');
echo $form->field($model,'code')->widget(\yii\captcha\Captcha::className());
echo \yii\bootstrap\Html::submitButton('修改',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();