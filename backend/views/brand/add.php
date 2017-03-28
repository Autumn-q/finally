<?php

$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'intro')->textarea();
echo $form->field($model,'logo_file')->fileInput();
echo $form->field($model,'sort');
echo $form->field($model,'status',['inline'=>true])->radioList(\backend\models\Brand::$status_name);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();