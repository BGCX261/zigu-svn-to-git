<?php
set_include_path(get_include_path().PATH_SEPARATOR.dirname(dirname(dirname(__FILE__)))."/Zigu/libs".PATH_SEPARATOR.dirname(dirname(dirname(__FILE__)))."/Zigu/src");
require_once 'Zigu/Service/PollServiceFactory.php';
$ziguService = PollServiceFactory::getInstance()->createPollService();
?>
<script language="javascript" type="text/javascript" src="http://image.dukuai.com/dukuai/js/jq/jquery-1.2.6m.js"></script>
<style>
<!--
/*全局CSS定义*/
body {font-family:Tahoma, Arial, sans-serif,"宋体";margin:0;padding:0;font-size:12px; color:#000;}
div,form,img,ul,ol,li,dl,dt,dd {margin: 0; padding: 0; border: 0;}
h1,h2,h3,h4,h5,h6 { margin:0; padding:0;}
table,td,tr,th{font-size:12px;}
a{text-decoration:none;color:#333;}
a:hover{text-decoration:underline;color:#000;}

/*新增投票投票*/
.pcontent{margin-left:20px;margin-top:10px;}
.pcontent dl dt{list-style-type:none;font-size:18px;color:red}
.pcontent dl dd{list-style-type:none;font-size:14px;}
.pcontent ul li{list-style-type:none;font-size:14px;}
-->
</style>

<div class="pcontent">
	<form action="index.php" method="POST">
		<div>
			<div>
				<dl>
					<dt>投票</dt>
					<dd>投票标题 <input type="text" name="pollTitle" value="" /></dd>
					<dd>投票限制 
						<select>
							<option>IP限制</option>
							<option>用户限制</option>
							<option>不限制</option>
							<option>ip与用户限制</option>
							<option>用户时间限制</option>
							<option>ip时间限制</option>
							<option>用户等级限制</option>
							<option>用户登陆限制</option>
							<option>用户注册时间限制</option>
						</select>
					</dd>
					<dd>投票状态
						<select>
							<option>草稿</option>
							<option>正式</option>
							<option>进行中</option>
							<option>关闭</option>
						</select>					
					</dd>
					<dd>投票结果是否可见 <input type="checkbox" name="resultVisiable" value="" /></dd>
					<dd>投票限制时间 <input type="text" name="freezeTime" value="" /></dd>
					<dd>投票开始时间 <input type="text" name="startTime" value="" /></dd>
					<dd>投票结束时间 <input type="text" name="endtime" value="" /></dd>
					<dd>结果排序方法 
						<select>
							<option>按录入顺序排序</option>
							<option>按票数从高到低</option>
							<option>按票数从低到高</option>
						</select>	
					</dd>
					<dd>初始投票人数 <input type="text" name="initCount" value="" /></dd>
					<dd>投票模板 <input type="text" name="template" value="" /></dd>
					<dd>定制模板 <input type="text" name="customTemplate" value="" /></dd>
					<dd>定制模板url <input type="text" name="templateUrl" value="" /></dd>
				</dl>
			</div>
			
			<div id="poll_contents"></div>
			
			<div id="">
				<div id="question_">
					<dl>
						<dt>问题</dt>
						<dd>问题标题<input type="text" name="questionTitle" value="" /> 问题类型
							<select name="questionType" id="question_type_select">
								<option value="1">单选</option>
								<option value="2">多选</option>
								<option value="3">文本</option>
								<option value="4">文本区域</option>
							</select>							
						</dd>
					</dl>
				</div>
				<div id="item_"></div>
				
				
			</div>
			
			
		</div>
		<input type="submit" value="提交" name="psubmit" />
	</form>
</div>

<script type="text/javascript">
<!--
jQuery(document).ready(function(){
	jQuery("#question_type_select").change(function(){
		jQuery('option:selected',this).each(function(){
			buildItem(this.value);
		});
	});
});

function buildItem(id){
	item = chooseType(id);
	jQuery("#item_").html(item);
}

function chooseType(type){
	if(type == 1){
		return buildInputs();
	}else if(type == 2){
		return buildMoreInputs();
	}else if(type == 3){
		return buildInput();
	}else if(type == 4){
		return buildTextArea();
	}
}

function buildInput(){
	html = "<dl><dt>选项内容</dt>";
	html += "<dd><input type=\"text\" name=\"itemTitle\" value=\"\" /></dd>";
	html += "<dd>选项最小值<input type=\"text\" name=\"minLength\" value=\"\" size=\"2\"/>";
	html += "选项最大值<input type=\"text\" name=\"maxLength\" value=\"\" size=\"2\"/></dd>";
	html += "</dl>";
	return html
}

function buildTextArea(){
	html = "<dl><dt>选项内容</dt>";
	html += "<dd><textarea name=\"itemTitle\" value=\"\" ></textarea></dd>";
	html += "<dd>选项最小值<input type=\"text\" name=\"minLength\" value=\"\" size=\"2\"/>";
	html += "选项最大值<input type=\"text\" name=\"maxLength\" value=\"\" size=\"2\"/></dd>";
	html += "</dl>";
	return html;
}

function buildInputs(){
	html = "<dl><dt>选项内容</dt>";
	html += "<dd><input type=\"text\" name=\"itemTitle\" value=\"\" /> 初始值 <input type=\"text\" name=\"initCount\" value=\"\" size=\"2\"/></dd>";
	html += "<dd><input type=\"text\" name=\"itemTitle\" value=\"\" /> 初始值 <input type=\"text\" name=\"initCount\" value=\"\" size=\"2\"/></dd>";
	html += "<dd><input type=\"text\" name=\"itemTitle\" value=\"\" /> 初始值 <input type=\"text\" name=\"initCount\" value=\"\" size=\"2\"/></dd>";
	html += "<dd><input type=\"text\" name=\"itemTitle\" value=\"\" /> 初始值 <input type=\"text\" name=\"initCount\" value=\"\" size=\"2\"/></dd>";
	html += "</dl>";
	return html;
}

function buildMoreInputs(){
	html = "<dl><dt>选项内容</dt>";
	html += "<dd><input type=\"text\" name=\"itemTitle\" value=\"\" /> 初始值 <input type=\"text\" name=\"initCount\" value=\"\" size=\"2\"/></dd>";
	html += "<dd><input type=\"text\" name=\"itemTitle\" value=\"\" /> 初始值 <input type=\"text\" name=\"initCount\" value=\"\" size=\"2\"/></dd>";
	html += "<dd><input type=\"text\" name=\"itemTitle\" value=\"\" /> 初始值 <input type=\"text\" name=\"initCount\" value=\"\" size=\"2\"/></dd>";
	html += "<dd><input type=\"text\" name=\"itemTitle\" value=\"\" /> 初始值 <input type=\"text\" name=\"initCount\" value=\"\" size=\"2\"/></dd>";
	html += "</dl>";
	return html;
}
//-->
</script>



































