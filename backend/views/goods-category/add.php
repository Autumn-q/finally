<?php
/**
 * @var $this \yii\web\view
 */
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'parent_id')->hiddenInput();
echo '<div>
    <ul id="treeDemo" class="ztree"></ul>
</div>';
$tree = <<<ETO
var zTreeObj;
        // zTree 的参数配置，深入使用请参考 API 文档（setting 配置详解）
        var setting = {
        callback: {
		onClick: function(event, treeId, treeNode){
		    $('#goodscategory-parent_id').val(treeNode.id);
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

echo $form->field($model,'intro')->textarea();
echo yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();
$this->registerJs($tree);
$this->registerJsFile('@web/assets/zTree/js/jquery.ztree.core.js',['depends'=>\yii\web\JqueryAsset::className()]);
?>
<link rel="stylesheet" href="/assets/zTree/css/zTreeStyle/zTreeStyle.css" type="text/css">
