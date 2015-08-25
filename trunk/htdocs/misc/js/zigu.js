var Zigu = {};

Zigu.__init__ = function () {
	
}

var question = {};
question.getQuestion = function(){
	var id = $("[id^='question_']").size()+1;//当前问题数
	$(question.getQuestionHtml(id)).appendTo($("#questions"));//增加一个问题
	$("#select_"+id).change(function(){
		question.getChange(this,id);//绑定切换类型chang事件
	}).end();
	$("#add_"+id).click(function(){
		question.getItem(id);//绑定增加选项click事件
	});
	$("#advq_"+id).click(function(){
		question.questionSetting(id);//绑定增加选项click事件
	});
}

question.getChange = function(obj,id){
	var item = "#item_"+id;
	//question.tmpSave(id);//临时存储
	$(item).empty();
	$("#layerQuestion_"+id).remove();//清除高级选项内容
	$(question.getHtml(obj.value,id)).appendTo($(item));

	$("#advi_"+id).click(function(){
		question.itemSetting(this,id);
	}).end();
	
	$("#del_"+id).click(function(){
		question.getDel(this);
	}).end();
}

question.tmpSave = function(id){
	var selected = $("#select_"+id).val();
	question.saveSingle(id);
	return ;
}

question.saveSingle = function(id){
	var tmp = $("#item_"+id).html();
	
	box = $("#tmp_"+id);//临时存储盒子
	var isExist = $("#tmp_"+id+", copy_1").html();//是否存在
	if(isExist == ''){
		 copy = '<div id="copy_1">'+tmp+'</div>';
		 $(copy).appendTo(box);
	}else{
		$("#copy_1").html(tmp);
	}
	return ;
}

question.saveMulit = function(id){
	
}

question.saveText = function(id){
	
}

question.saveTextArea = function(id){
	
}

question.getItem = function(id){
	var item = "#item_"+id;

	var obj = $(question.getTextHtml(id));
	
	obj.appendTo($(item));
	
	obj.find("#del_"+id).click(function(){
		question.getDel(this);
	}).end();	
	
	obj.find("#advi_"+id).click(function(){
		question.itemSetting(this,id);
	}).end();
}

question.itemSetting = function(obj,id){
	parents = $(obj).parents("[id^=option_]");
	var num = parents.get(0).id.split('_')[1];
	$("[id^='layer_']").hide();
	question.getAdvItem(id,num);
	
	$("#layer_"+num).hover(
		function() {
			$("[id^='layer_']").css("background","#FFF7F7");
	    },
	    function(){
	    	$("[id^='layer_']").hide();
	    }
    );
}

question.getAdvItem = function(id,num){
	$("[id^='layerQuestion_']").hide();
	$("[id^='layer_']").hide();
	var obj = $("#newi_"+num);
	var obji = $("#advi_"+id);
	if(obj.html() != ''){
		advitem = $("#layer_"+num);//存在
		advitem.slideToggle("slow");
	}else{
		advitem = $(question.advItemHtml(id,num));//不存在
		var offset = obj.offset();
		var right = offset.left+obj.width();
		var down = offset.top+obj.height();
		advitem.css({
			'position': 'absolute',
			'margin-left':'20px',
			'padding':'10px',
			//'left':'500px',
			//'top':'300px',
			'left':'300px',
			'top':down,
			'width':'400px',
			'background-color':'#f0f5FF',
			'border': '1px solid #000',
			'z-index': '50'});
		advitem.appendTo($("#newi_"+num));
	}
	
	advitem.find("#addAdv_"+num).click(function(){
		advitem.hide();
	}).end();
	
	advitem.find("#closeAdv_"+num).click(function(){
		advitem.hide();
	}).end();
	
}

question.advItemHtml = function(id,num){
	//css = 'position: absolute;left:500px;top:300px;width:400px;background-color:#f0f5FF;border: 1px solid #000;z-index: 50;padding:10px;';
	//html  = '<div id="layer_'+num+'" style="'+css+'">';
	var type = question.getSelected(id);
	html  = '<div id="layer_'+num+'">';
	html += '<dd>选项高级设置</dd>';
	html += '<dd>初始值：<input type="text" name="questions['+id+'][items]['+num+'][initCount]" value="" /></dd>';
	if(type == 3 || type == 4){
		html += '<dd>选项输入最小值：<input type="text" name="questions['+id+'][items]['+num+'][minLength]" value="" /></dd>';
		html += '<dd>选项输入最大值：<input type="text" name="questions['+id+'][items]['+num+'][maxLength]" value="" /></dd>';
	}
	html += '<dd>图片URL：<input type="text" name="questions['+id+'][items]['+num+'][imgUrl]" value="" /></dd>';
	html += '<dd>问题URL：<input type="text" name="questions['+id+'][items]['+num+'][itemUrl]" value="" /></dd>';
	html += '<dd><input type="button" value="确定" id="addAdv_'+num+'" /><input type="button" value="关闭" id="closeAdv_'+num+'" /></dd>';
	html += '</div>';
	return html;
}

question.questionSetting = function(id){
	obj = $("#newq_"+id);
	var objq = $("#advq_"+id);
	$("[id^='layerQuestion_']").hide();
	$("[id^='layer_']").hide();
	
	if(obj.html() != ''){
		advquestion = $("#layerQuestion_"+id);//存在
		advquestion.slideToggle("slow");
	}else{
		advquestion = $(question.advQuestionHtml(id));//不存在
		var offset = obj.offset();
		var right = offset.left+obj.width();
		var down = offset.top+obj.height();
		advquestion.css({
			'position': 'absolute',
			'left':'450px',
			'top':down,
			'width':'400px',
			'background-color':'#f0f5FF',
			'border': '1px solid #000',
			'z-index': '50',
			'padding':'10px'});
		advquestion.appendTo($("#newq_"+id));
	}
	
	advquestion.find("#addAdvQuestion_"+id).click(function(){
		advquestion.hide();
	}).end();
	
	advquestion.find("#closeAdvQuestion_"+id).click(function(){
		advquestion.hide();
	}).end();
	
	$("#layerQuestion_"+id).hover(
		function() {
			$("[id^='layerQuestion_']").css("background","#FFF7F7");
	    },
	    function(){
	    	$("[id^='layerQuestion_']").hide();
	    }
    );

}

question.advQuestionHtml = function(id){
	var type = question.getSelected(id);
	html  = '<div id="layerQuestion_'+id+'">';
	html += '<dd>问题高级设置</dd>';
	if(type == 2) {
		html += '<dd>多选限制数：<input type="text" name="questions['+id+'][maxMultiOptions]" value="" /></dd>';
	}
	html += '<dd>问题是否必填：<input type="checkbox" name="questions['+id+'][required]" value="1" /></dd>';
	html += '<dd>问题URL：<input type="text" name="questions['+id+'][questionUrl]" value="" /></dd>';
	html += '<dd>图片URL：<input type="text" name="questions['+id+'][imgUrl]" value="" /></dd>';
	html += '<dd><input type="button" value="确定" id="addAdvQuestion_'+id+'" /><input type="button" value="关闭" id="closeAdvQuestion_'+id+'" /></dd>';
	html += '</div>';
	return html;
}

question.getSelected = function(id){
	return $("#select_"+id+" option:selected").get(0).value;
}

question.getDel = function(obj){
	$(obj).parents("[id^=option_]").remove();
}

question.getHtml = function(type,id){
	if(type == 1 || type == 2 ){
		return question.getTextHtml(id);
	}else{
		$("#add_"+id).remove();
		return question.getTextAreaHtml(id);
	}
}

question.getTextHtml = function(id){
	var num = question.getItemNumber();
	html  = '<div id="option_'+num+'">选项';
	html += '<input type="text" name="questions['+id+'][items]['+num+'][title]" value="" />';
	html += '<input type="button" value="删除" id="del_'+id+'" />';
	html += '<input type="button" value="高级设置" id="advi_'+id+'" />';
	html += '<span id="newi_'+num+'" /></span>';//IE不兼容，用span
	html += '</div>';
	return html;
}

question.getTextAreaHtml = function(id){
	var num = question.getItemNumber();
	html  = '<div id="option_'+num+'">';
	html += '<textarea name="questions['+id+'][items]['+num+'][title]" value="" ></textarea>';
	html += '<input type="button" value="高级设置" id="advi_'+id+'" />';
	html += '<span id="newi_'+num+'" /></span>';//IE不兼容，用span
	html += '</div>';
	return html;
}

question.getItemNumber = function(){
	return $("[id^='option_']").size()+1;//当前选项个数
}

question.getQuestionHtml = function(id){
	html =  '<div id="question_'+id+'">';
	html += '<div>问题'+id+'：<input type="text" name="questions['+id+'][title]" value="" />';
	html += '&nbsp;类型：<select name="questions['+id+'][questionType]" id="select_'+id+'" ><option value="1">单选</option><option value="2">多选</option><option value="3">文本</option><option value="4">文本区域</option></select>';
	html += '<input type="button" value="高级设置" id="advq_'+id+'" />';
	html += '<span id="newq_'+id+'" /></span>';//IE不兼容，用span
	html += '<div id="item_'+id+'"></div>';
	html += '<div id="tmp_'+id+'"></div>';
	html += '<div>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="增加选项"  id="add_'+id+'"/></div>';
	html += '</div></div>';
	return html;
}