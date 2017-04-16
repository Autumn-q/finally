<div class="address_bd mt10">
        <h4>新增收货地址</h4>
        <?php
            /**
             * @var $this \yii\web\view
             */
            $form = \yii\widgets\ActiveForm::begin();
            echo '<ul>';
            echo $form->field($model,'name',[
                'options'=>['tag'=>'li'],
            ])->textInput(['class'=>'txt']);
            echo '<li><label for>所在地区</label><select id="cmbProvince" name="cmbProvince"></select>';
            echo '<select id="cmbCity" name="cmbCity"></select>';
            echo '<select id="cmbArea" name="cmbArea"></select></li>';
            echo $form->field($model,'address',[
                'options'=>['tag'=>'li'],
            ])->textInput(['class'=>'txt']);
            echo $form->field($model,'tel',[
                'options'=>['tag'=>'li'],
            ])->textInput(['class'=>'txt']);
            echo '<li><label for="">&nbsp;</label>'.$form->field($model,'status')->checkbox().'</li><br/><br/>';
        echo '<li><label for="">&nbsp;</label>'.\yii\helpers\Html::submitButton('保存',['class'=>'btn']).'</li>';
            echo '</ul>';
            \yii\widgets\ActiveForm::end();
        ?>
    </div>

<?php
echo "<script type='text/javascript'>
    addressInit('cmbProvince', 'cmbCity', 'cmbArea','".$model->province."','".$model->city."','".$model->area."');
</script>";
?>


