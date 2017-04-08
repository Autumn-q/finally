<?php
/*
 * @var $this \yii\web\view
 */
use yii\bootstrap\Html;

$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'imgFile[]')->fileInput(['multiple'=>true]);
echo Html::submitButton('上传',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();

echo '<div class="images"></div>';
$js = <<<EOT
    $("#goodsgallery-imgfile").on('change',function(){
        console.debug(1);
    });
EOT;
$this->registerJs($js);

