<!--<p class="sec_nav">分类管理： <a href="index.php?admin_category-list" class="on"  > <span>{lang magManageCat}</span></a> <a href="index.php?admin_category-add"  ><span>{lang magAddCat}</span></a> <a href="index.php?admin_category-merge"  ><span>{lang magUniteCat}</span></a> </p>-->

<h3 class="col-h3">版块管理</h3>
<ul class="col-ul tips">
  <li><b>提示: </b></li>
  <li>双击版块名称可编辑版块标题</li>
</ul>
<form method="post" action="http://localhost/phpwind/admin.php?m=bbs&amp;c=setforum&amp;a=dorun" onsubmit="return doSubmit();">
  <div class="table_list">
    <table width="100%" style="table-layout:fixed;" class="table" id="act_table">
      <colgroup>
      <col width="30">
      <col width="400">
      <col width="60">
      <col width="210">
      <col>
      </colgroup>
      <thead>
        <tr>
          <td></td>
          <td><span >[顺序]</span>版块名称</td>
          <td class="tar">fid</td>
          <td>版主</td>
          <td>操作</td>
        </tr>
      </thead>
      
      <?php foreach($forums as $key=>$val){?>
          <tbody>
            <tr id="tr_<?php echo $val['id']?>">
              <td><span ></span></td>
              <td><input type="text" name="old[<?php echo $val['id']?>]['order']" style="width:20px;" value="<?php echo $val['display_order']?>" class="inp_txt2">
                <span><?php echo $val['name']?></span> 
                <a class="link_add" href="#" style="display: none;" fid="<?php echo $val['id']?>" ftype="1">添加新版块</a></td>
              <td class="tar"><?php echo $val['id']?></td>
              <td><input type="text" name="old[<?php echo $val['id']?>]['manager']" value="<?php echo $val['manager']?>" class="inp_txt2"></td>
              <td><a target="_blank" href="#">[访问]</a> <a href="#">[编辑]</a> <a href="#">[删除]</a></td>
            </tr>
          <?php if(!empty($val['sub'])){ $total = count($val['sub']);?>
            <?php	foreach($val['sub'] as $k=>$v){?>
            <tr id="tr_<?php echo $v['id']?>">
              <td></td>
              <td><span class="plus_icon <?php if($k+1 == $total){?>plus_end_icon <?php }?>"></span>
                <input type="text" name="old[<?php echo $v['id']?>]['order']" style="width:20px;" value="<?php echo $v['display_order']?>" class="inp_txt2">
                <span><?php echo $v['name']?></span>
                <a class="link_add" href="#" style="display: none;" fid="<?php echo $v['id']?>" ftype="2">添加二级版块</a></td>
              <td class="tar"><?php echo $v['id']?></td>
              <td><input type="text" name="old[<?php echo $v['id']?>]['manager']" value="<?php echo $v['manager']?>" class="inp_txt2"></td>
              <td><a target="_blank" href="#">[访问]</a> <a href="#">[编辑]</a> <a href="#">[删除]</a></td>
            </tr>
                <?php if(!empty($v['sub'])){
					$num = count($v['sub']);
					?>
                	
					<?php foreach($v['sub'] as $sk=>$sv){?>
                    <tr id="tr_<?php echo $sv['id']?>">
                      <td></td>
                      <td><span class="plus_icon plus_none_icon"></span>
                      <span class="plus_icon <?php if($sk+1 == $num){?>plus_end_icon <?php }?>"></span>
                        <input type="text" name="old[<?php echo $sv['id']?>]['order']" style="width:20px;" value="<?php echo $sv['display_order']?>" class="inp_txt2">
                        <span><?php echo $sv['name']?></span></td>
                      <td class="tar"><?php echo $sv['id']?></td>
                      <td><input type="text" value="<?php echo $sv['manager']?>" name="old[<?php echo $sv['id']?>]['manager']" class="inp_txt2"></td>
                      <td><a target="_blank" href="#">[访问]</a> <a href="#">[编辑]</a> <a href="#">[删除]</a></td>
                    </tr>
                    <?php }?>
                <?php }?>
            <?php }?>
          
          <?php }?>
          </tbody>
      <?php }?>
      
      <tbody id="line_group">
        <tr>
          <td style="padding-left:38px;" colspan="5"><input type="button" id="add_group" value="+添加新分类" class="inp_btn2 m-r10"/></td>
        </tr>
      </tbody>
    </table>
  </div>
  <div style="margin-top:20px;">
    <button class="inp_btn m-r10" type="submit">提交</button>
  </div>
</form>
<script type="text/javascript">
$(document).ready(function() {
	var global_id = 1;
	$('#act_table').find('tr').live('mouseover', function() {
		$(this).addClass("hover");
		$(".link_add",this).show();
	}).live('mouseout', function () {
		$(this).removeClass("hover");
		$(".link_add",this).hide();
	});

	$(".link_add").live('click',function(){
		//得到点击者以及点击者的fid和级别。
		var fid = $(this).attr('fid'),ttr = $("#tr_"+fid),level = $(this).attr('ftype');
		var html = forumChild(+level+1,fid);
		ttr.after(html);
		return false;
	});
	
	$("#add_group").live('click',function(){
		//得到点击者以及点击者的fid和级别。
		var ttr = $("#line_group");
		var html = forumChild(1,0);
		html = '<tbody>'+html+'</tbody>';
		ttr.before(html);
		return false;
	});

	//返回一~三级版块添加的html
	function forumChild(forum_level, parent_id){
		global_id++;
		var forum_text, plus_icon='',plus_none_icon_arr = [], new_id = 'new_'+global_id;
		
		if (forum_level === 1) {
			forum_text = '添加新版块';
		} else if (forum_level === 2) {
			forum_text = '添加二级版块';
		} else {
			forum_text = '';
		} 
		if(forum_text!=''){
			forum_text = '<a style="display:none" href="#" class="link_add" ftype="'+forum_level+'" fid="'+new_id+'">'+ forum_text +'</a>';
		}
		//不同级别html差异
		for (var i=2; i < forum_level; i++){
			plus_none_icon_arr.push('<span class="plus_icon plus_none_icon"></span>');
		};
		plus_icon = plus_none_icon_arr.join('');
		if(forum_level>1){
			plus_icon += '<span class="plus_icon plus_end_icon"></span>';
		}
		
		return '<tr id="tr_'+new_id+'"><td></td>\
					<td>'+ plus_icon +'\
						<input type="text" name="order['+ new_id +']" class="inp_txt2" style="width:20px;" value="0" >\
						<input type="text" name="name['+ new_id +']"  class="inp_txt2" value="">\
						<input type="hidden" name="pid['+ new_id +']" value="'+parent_id+'">\
						'+ forum_text +'\
					</td>\
					<td class="tar"></td>\
					<td><input type="text" name="manager['+ new_id +']" class="inp_txt2"></td>\
					<td><a href="">[删除]</a></td>\
				</tr>';
	}
		
		
	//版块_新添加的行可直接删除
	$('#J_table_list').on('click', 'a.J_new_forum_del', function (e) {
		e.preventDefault();
		var $this = $(this), tr = $this.parents('tr');
		
		//跟当前行比较"del-level"的值，含子版不删除
		if(tr.data('del_level') < tr.next().data('del_level')) {
			Wind.use('dialog', function(){
				Wind.dialog.alert('该版块含有子版块，请先删除所有子版块，再进行此操作！', function(){
					$this.focus();
				});
			});
		}else{
			tr.remove();
		}
	});
		
	
	//双击编辑版块名称
	var org_val;
	$('#J_table_list').on('dblclick', '.J_forum_names', function() {
		var $this = $(this), $input = $('<input type="text" value="'+ $this.text() +'" data-id="'+  $this.data('id') +'" class="input mr5 J_forum_names_input" name="name">');
		org_val = $this.text(); //原始版块名
		$input.insertAfter($this).focus();
		$this.remove();
	});
	
	//版块名称input失焦ajax提交
	$('#J_table_list').on('blur', '.J_forum_names_input', function() {
		var $this = $(this),
			restore = function() { //版块取消编辑状态
				$this.hide().after('<span class="mr10 J_forum_names" data-id="'+ $this.data('id') +'">'+ $this.val() +'</span>');
				$this.remove();
			};
			
		//判断版块名是否修改过
		if($this.val() !== org_val) {
			$.post("http://localhost/phpwind/admin.php?m=bbs&c=setforum&a=editname", {fid: $this.data('id'), name: $this.val() }, function(data){
				if(data.state === 'success') {
					restore();
				}
			});
		}else{
			restore();
		}
		
	});
});
</script>