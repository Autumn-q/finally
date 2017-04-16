/*
@功能：购物车页面js
@作者：diamondwang
@时间：2013年11月14日
*/
function total(){
	//总计金额
	var total = 0;
	$(".col5 span").each(function(){
		total += parseFloat($(this).text());
	});

	$("#total").text(total.toFixed(2));
}
$(function(){
	
	//减少
	$(".reduce_num").click(function(){
		var amount = $(this).parent().find(".amount");
		var goods_id = $(this).closest('tr').attr('data_goods_id');
		//获取数据
		var num  =parseInt(amount.val()) - 1;
		var tr = $(this).closest('tr');
		//获取csrf值
		var token = $(this).closest('tbody').attr('csrf');

		//增加后把新的数据保存的cookie中,发送ajax请求
		$.post('/cart/ajax?filter=modify',{goods_id:goods_id,num:num,'_csrf-frontend':token},function(data){
			if(data == 'success'){
				console.log(data);
				//小计
				$(amount).val(num);
				var subtotal = parseFloat(tr.find(".col3 span").text()) * parseInt($(amount).val());
				tr.find(".col5 span").text(subtotal.toFixed(2));
				//总计金额
				var total = 0;
				$(".col5 span").each(function(){
					total += parseFloat($(this).text());
				});

				$("#total").text(total.toFixed(2));
			}else{
				console.debug('修改失败:'+data);
			}
		});


	});

	//增加
	$(".add_num").click(function(){
		var amount = $(this).parent().find(".amount");
		var goods_id = $(this).closest('tr').attr('data_goods_id');
		//获取数据
		var num  =parseInt(amount.val()) + 1;
		var tr = $(this).closest('tr');
		//获取csrf值
		var token = $(this).closest('tbody').attr('csrf');

		//增加后把新的数据保存的cookie中,发送ajax请求
		$.post('/cart/ajax?filter=modify',{goods_id:goods_id,num:num,'_csrf-frontend':token},function(data){
		 	if(data == 'success'){
				console.log(data);
				//小计
				$(amount).val(num);
				var subtotal = parseFloat(tr.find(".col3 span").text()) * parseInt($(amount).val());
				tr.find(".col5 span").text(subtotal.toFixed(2));
				//总计金额
				var total = 0;
				$(".col5 span").each(function(){
					total += parseFloat($(this).text());
				});

				$("#total").text(total.toFixed(2));
			}else{
				console.debug('修改失败:'+data);
			}
		 });


	});

	//直接输入
	$(".amount").blur(function(){
		if (parseInt($(this).val()) < 1){
			alert("商品数量最少为1");
			$(this).val(1);
		}
		var amount = $(this).parent().find(".amount");
		var goods_id = $(this).closest('tr').attr('data_goods_id');
		var num  =parseInt(amount.val());
		var tr = $(this).closest('tr');
		//获取csrf值
		var token = $(this).closest('tbody').attr('csrf');
		//把新的数据保存的cookie中,发送ajax请求
		$.post('/cart/ajax?filter=modify',{goods_id:goods_id,num:num,'_csrf-frontend':token},function(data){
			if(data == 'success'){
				console.log(data);
				//小计
				$(amount).val(num);
				var subtotal = parseFloat(tr.find(".col3 span").text()) * parseInt($(amount).val());
				tr.find(".col5 span").text(subtotal.toFixed(2));
				//总计金额
				var total = 0;
				$(".col5 span").each(function(){
					total += parseFloat($(this).text());
				});

				$("#total").text(total.toFixed(2));
			}else{
				console.debug('修改失败:'+data);
			}
		});

	});
	//删除的方法事件
	$(".btn_del").click(function(){
		if(confirm('是否确定删除')){
			var tr = $(this).closest('tr');
			console.debug(tr);
			var goods_id = $(this).closest('tr').attr('data_goods_id');
			var token = $(this).closest('tbody').attr('csrf');
			$.post('/cart/ajax?filter=del',{goods_id:goods_id,'_csrf-frontend':token},function(data){
				if(data == 'success'){
					console.debug(1);
					tr.remove();
					total();
				}
			});
		}
	})
});