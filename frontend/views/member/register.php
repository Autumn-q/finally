<?php
/*
 * @var $this \yii\web\view
 */
?>
<!-- 登录主体部分start -->
<div class="login w990 bc mt10 regist">
    <div class="login_hd">
        <h2>用户注册</h2>
        <b></b>
    </div>
    <div class="login_bd">
        <div class="login_form fl">
            <?php
            $button =  '<input type="button" onclick="bindPhoneNum(this)" id="get_captcha" value="获取验证码" style="height: 25px;padding:3px 8px">';
            $form = \yii\widgets\ActiveForm::begin();
            echo '<ul>';
            echo $form->field($model,'username',[
                'options'=>['tag'=>'li'],//设置包裹的标签
                'errorOptions'=>['tag'=>'p']//设置错误信息包裹
            ])->textInput(['class'=>'txt','placeholder'=>'3-20位字符，可由中文、字母、数字和下划线组成']);
            echo $form->field($model,'password',[
                'options'=>['tag'=>'li'],//设置包裹的标签
                'errorOptions'=>['tag'=>'p']//设置错误信息包裹
            ])->passwordInput(['class'=>'txt','placeholder'=>'6-20位字符，可使用字母、数字和符号的组合']);
            echo $form->field($model,'repassword',[
                'options'=>['tag'=>'li'],//设置包裹的标签
                'errorOptions'=>['tag'=>'p']//设置错误信息包裹
            ])->passwordInput(['class'=>'txt','placeholder'=>'6-20位字符，可使用字母、数字和符号的组合']);
            echo $form->field($model,'email',[
                'options'=>['tag'=>'li'],//设置包裹的标签
                'errorOptions'=>['tag'=>'p']//设置错误信息包裹
            ])->textInput(['class'=>'txt','placeholder'=>'邮箱必须合法']);
            echo $form->field($model,'tel',[
                'options'=>['tag'=>'li'],//设置包裹的标签
                'errorOptions'=>['tag'=>'p']//设置错误信息包裹
            ])->textInput(['class'=>'txt','placeholder'=>'手机号码']);
            echo $form->field($model,'code',[
                'options'=>['class'=>'checkcode']
            ])->widget(\yii\captcha\Captcha::className());
            echo $form->field($model,'tel_captcha',[
                'options'=>['tag'=>'li'],//设置包裹的标签
                'errorOptions'=>['tag'=>'p'],//设置错误信息包裹
                'template'=>"{label}\n{input}$button\n{hint}\n{error}",//输出模板
            ])->textInput(['class'=>'txt','placeholder'=>'短信验证码']);

            echo '<li><label for="">&nbsp;</label>'.\yii\helpers\Html::submitButton('',['class'=>'login_btn']).'</li>';
            echo '</ul>';
            \yii\widgets\ActiveForm::end();
            ?>

        </div>

        <div class="mobile fl">
            <h3>手机快速注册</h3>
            <p>中国大陆手机用户，编辑短信 “<strong>XX</strong>”发送到：</p>
            <p><strong>1069099988</strong></p>
        </div>

    </div>
</div>
<!-- 登录主体部分end -->
<script type="text/javascript">
    function bindPhoneNum(){
        //获取输入的手机号
        var tel = $("#member-tel").val();
        var url = '<?=\yii\helpers\Url::to(['member/sms'])?>';
        var token = '<?=Yii::$app->request->csrfToken?>';
        $.post(url,{'tel':tel,'_csrf-frontend':token},function(data){
            console.debug(data);
        });

        var time=60;
        var interval = setInterval(function(){
            time--;
            if(time<=0){
                clearInterval(interval);
                var html = '获取验证码';
                $('#get_captcha').prop('disabled',false);
            } else{
                var html = time + ' 秒后再次获取';
                $('#get_captcha').prop('disabled',true);
            }

            $('#get_captcha').val(html);
        },1000);
    }
</script>