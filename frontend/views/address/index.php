<!-- 右侧内容区域 start -->
<div class="content fl ml10">
    <div class="address_hd">
        <h3>收货地址薄</h3>
        <?php foreach($rows as $row):?>

            <dl>
                <dt><?=$row->name.' '.$row->province.$row->city.$row->area.$row->address.' '.$row->tel?></dt>
                <dd>
                    <?=\yii\helpers\Html::a('修改',['address/edit?id='.$row->id])?>
                    <?=\yii\helpers\Html::a('删除',['address/del?id='.$row->id])?>
                    <?=\yii\helpers\Html::a('设为默认地址',['address/status?id='.$row->id])?>
                </dd>
            </dl>
        <?php endforeach;?>

    </div>

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

</div>
<script type="text/javascript">
    addressInit('cmbProvince', 'cmbCity', 'cmbArea','四川','成都市','青羊区');
</script>