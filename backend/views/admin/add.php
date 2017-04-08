<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'username');
echo $form->field($model,'password')->passwordInput();
echo $form->field($model,'password2')->passwordInput();
echo $form->field($model,'email');
echo $form->field($model,'role',['inline'=>true])->checkboxList(\backend\models\Admin::getRoleOption());
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();