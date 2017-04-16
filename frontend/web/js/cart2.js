/*
@功能：购物车页面js
@作者：diamondwang
@时间：2013年11月14日
*/
$(function(){
	//收货人修改
	$("#address_modify").click(function(){
		$(this).hide();
		$(".address_info").hide();
		$(".address_select").show();
	});

	$(".new_address").click(function(){
		$("form[name=address_form]").show();
		$(this).parent().addClass("cur").siblings().removeClass("cur");

	}).parent().siblings().find("input").click(function(){
		$("form[name=address_form]").hide();
		$(this).parent().addClass("cur").siblings().removeClass("cur");
	});

	//送货方式修改
	$("#delivery_modify").click(function(){
		$(this).hide();
		$(".delivery_info").hide();
		$(".delivery_select").show();
	});

	$("input[name=delivery]").click(function(){
		$(this).parent().parent().addClass("cur").siblings().removeClass("cur");
	});

	//支付方式修改
	$("#pay_modify").click(function(){
		$(this).hide();
		$(".pay_info").hide();
		$(".pay_select").show();
	});

	$("input[name=pay]").click(function(){
		$(this).parent().parent().addClass("cur").siblings().removeClass("cur");
	});

	//发票信息修改
	$("#receipt_modify").click(function(){
		$(this).hide();
		$(".receipt_info").hide();
		$(".receipt_select").show();
	});

	$(".company").click(function(){
		$(".company_input").removeAttr("disabled");
	});

	$(".personal").click(function(){
		$(".company_input").attr("disabled","disabled");
	});
	function total(){
		//获取获取到有几个商品
		var count = $(".order tr").length;
		//将数量放到对应的位置上
		$(".count").text(count+'件商品，总商品金额：');
		//计算总金额
		var total = 0;
		$(".col5 span").each(function(){
			total += parseFloat($(this).text());
		});
		$(".total span").text(total.toFixed(2));
		//计算结账总金额
		var all_money = 0;
		all_money +=  parseFloat($(".total span").text());
		all_money = all_money-parseFloat($(".back_money span").text());

		all_money += parseFloat($(".ems_money span").text());
		$(".all_money").text("￥"+all_money.toFixed(2));
		$(".all_money2").text("￥"+all_money.toFixed(2));
	}
	//获取当前选中的配送方式
	$(".delivery_radio").click(function(){
		var val = $(this).closest('td').next().find('span');
		var ems_money = val.text();
		$(".ems_money span").text(ems_money);
		total();
	});

	total();
});
