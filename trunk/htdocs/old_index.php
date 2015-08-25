<?php
set_include_path(get_include_path().PATH_SEPARATOR.dirname(dirname(dirname(__FILE__)))."/Zigu/libs".PATH_SEPARATOR.dirname(dirname(dirname(__FILE__)))."/Zigu/src");
require_once 'Zigu/Service/PollServiceFactory.php';
$ziguService = PollServiceFactory::getInstance()->createPollService();
?>
<script language="javascript" type="text/javascript" src="http://image.dukuai.com/dukuai/js/jq/jquery-1.2.6m.js"></script>
<style>
<!--
/*ȫ��CSS����*/
body {font-family:Tahoma, Arial, sans-serif,"����";margin:0;padding:0;font-size:12px; color:#000;}
div,form,img,ul,ol,li,dl,dt,dd {margin: 0; padding: 0; border: 0;}
h1,h2,h3,h4,h5,h6 { margin:0; padding:0;}
table,td,tr,th{font-size:12px;}
a{text-decoration:none;color:#333;}
a:hover{text-decoration:underline;color:#000;}

/*����ͶƱͶƱ*/
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
					<dt>ͶƱ</dt>
					<dd>ͶƱ���� <input type="text" name="pollTitle" value="" /></dd>
					<dd>ͶƱ���� 
						<select>
							<option>IP����</option>
							<option>�û�����</option>
							<option>������</option>
							<option>ip���û�����</option>
							<option>�û�ʱ������</option>
							<option>ipʱ������</option>
							<option>�û��ȼ�����</option>
							<option>�û���½����</option>
							<option>�û�ע��ʱ������</option>
						</select>
					</dd>
					<dd>ͶƱ״̬
						<select>
							<option>�ݸ�</option>
							<option>��ʽ</option>
							<option>������</option>
							<option>�ر�</option>
						</select>					
					</dd>
					<dd>ͶƱ����Ƿ�ɼ� <input type="checkbox" name="resultVisiable" value="" /></dd>
					<dd>ͶƱ����ʱ�� <input type="text" name="freezeTime" value="" /></dd>
					<dd>ͶƱ��ʼʱ�� <input type="text" name="startTime" value="" /></dd>
					<dd>ͶƱ����ʱ�� <input type="text" name="endtime" value="" /></dd>
					<dd>������򷽷� 
						<select>
							<option>��¼��˳������</option>
							<option>��Ʊ���Ӹߵ���</option>
							<option>��Ʊ���ӵ͵���</option>
						</select>	
					</dd>
					<dd>��ʼͶƱ���� <input type="text" name="initCount" value="" /></dd>
					<dd>ͶƱģ�� <input type="text" name="template" value="" /></dd>
					<dd>����ģ�� <input type="text" name="customTemplate" value="" /></dd>
					<dd>����ģ��url <input type="text" name="templateUrl" value="" /></dd>
				</dl>
			</div>
			
			<div id="poll_contents"></div>
			
			<div id="">
				<div id="question_">
					<dl>
						<dt>����</dt>
						<dd>�������<input type="text" name="questionTitle" value="" /> ��������
							<select name="questionType" id="question_type_select">
								<option value="1">��ѡ</option>
								<option value="2">��ѡ</option>
								<option value="3">�ı�</option>
								<option value="4">�ı�����</option>
							</select>							
						</dd>
					</dl>
				</div>
				<div id="item_"></div>
				
				
			</div>
			
			
		</div>
		<input type="submit" value="�ύ" name="psubmit" />
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
	html = "<dl><dt>ѡ������</dt>";
	html += "<dd><input type=\"text\" name=\"itemTitle\" value=\"\" /></dd>";
	html += "<dd>ѡ����Сֵ<input type=\"text\" name=\"minLength\" value=\"\" size=\"2\"/>";
	html += "ѡ�����ֵ<input type=\"text\" name=\"maxLength\" value=\"\" size=\"2\"/></dd>";
	html += "</dl>";
	return html
}

function buildTextArea(){
	html = "<dl><dt>ѡ������</dt>";
	html += "<dd><textarea name=\"itemTitle\" value=\"\" ></textarea></dd>";
	html += "<dd>ѡ����Сֵ<input type=\"text\" name=\"minLength\" value=\"\" size=\"2\"/>";
	html += "ѡ�����ֵ<input type=\"text\" name=\"maxLength\" value=\"\" size=\"2\"/></dd>";
	html += "</dl>";
	return html;
}

function buildInputs(){
	html = "<dl><dt>ѡ������</dt>";
	html += "<dd><input type=\"text\" name=\"itemTitle\" value=\"\" /> ��ʼֵ <input type=\"text\" name=\"initCount\" value=\"\" size=\"2\"/></dd>";
	html += "<dd><input type=\"text\" name=\"itemTitle\" value=\"\" /> ��ʼֵ <input type=\"text\" name=\"initCount\" value=\"\" size=\"2\"/></dd>";
	html += "<dd><input type=\"text\" name=\"itemTitle\" value=\"\" /> ��ʼֵ <input type=\"text\" name=\"initCount\" value=\"\" size=\"2\"/></dd>";
	html += "<dd><input type=\"text\" name=\"itemTitle\" value=\"\" /> ��ʼֵ <input type=\"text\" name=\"initCount\" value=\"\" size=\"2\"/></dd>";
	html += "</dl>";
	return html;
}

function buildMoreInputs(){
	html = "<dl><dt>ѡ������</dt>";
	html += "<dd><input type=\"text\" name=\"itemTitle\" value=\"\" /> ��ʼֵ <input type=\"text\" name=\"initCount\" value=\"\" size=\"2\"/></dd>";
	html += "<dd><input type=\"text\" name=\"itemTitle\" value=\"\" /> ��ʼֵ <input type=\"text\" name=\"initCount\" value=\"\" size=\"2\"/></dd>";
	html += "<dd><input type=\"text\" name=\"itemTitle\" value=\"\" /> ��ʼֵ <input type=\"text\" name=\"initCount\" value=\"\" size=\"2\"/></dd>";
	html += "<dd><input type=\"text\" name=\"itemTitle\" value=\"\" /> ��ʼֵ <input type=\"text\" name=\"initCount\" value=\"\" size=\"2\"/></dd>";
	html += "</dl>";
	return html;
}
//-->
</script>



































