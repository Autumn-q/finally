<?php
use yii\web\JsExpression;
use yii\bootstrap\Html;
use xj\uploadify\Uploadify;
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'market_price');
echo $form->field($model,'shop_price');
echo $form->field($model,'goods_category_id')->hiddenInput();
echo $form->field($model,'depth')->hiddenInput();
echo '<div>
    <ul id="treeDemo" class="ztree"></ul>
</div>';
echo $form->field($model,'stock');
echo $form->field($model,'sort');
echo $form->field($model,'is_on_sale',['inline'=>true])->radioList(\backend\models\Goods::$is_on_sale_name);
echo $form->field($model,'status',['inline'=>true])->radioList(\backend\models\Goods::$status_name);
echo $form->field($model,'logo_file')->fileInput();
echo $form->field($models,'content')->widget('kucha\ueditor\UEditor',[]);
echo $form->field($model,'brand_id')->dropDownList(\backend\models\Goods::getBrand());
$tree = <<<ETO
var zTreeObj;
        // zTree 的参数配置，深入使用请参考 API 文档（setting 配置详解）
        var setting = {
        //把goods_category_id赋值给goods的字段上
        callback: {
		onClick: function(event, treeId, treeNode){
		    $('#goods-goods_category_id').val(treeNode.id);
		    $('#goods-depth').val(treeNode.depth);
		}
	        },
        data: {
                simpleData: {
                    enable: true,
                    idKey: "id",
                    pIdKey: "parent_id",
                    rootPId: 0
                }
              }
            };
        // zTree 的数据属性，深入使用请参考 API 文档（zTreeNode 节点数据详解）
        var zNodes = {$rows};

        zTreeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
        zTreeObj.expandAll(true);
ETO;
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();
$this->registerJs($tree);
$this->registerJsFile('@web/assets/zTree/js/jquery.ztree.core.js',['depends'=>\yii\web\JqueryAsset::className()]);
?>
<link rel="stylesheet" href="/assets/zTree/css/zTreeStyle/zTreeStyle.css" type="text/css">