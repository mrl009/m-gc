<div class="tree_com" id="hierarchy"></div>
<script>
//分类树插件
(function($){
    var methods = {
        init: function(options){
			var params = $.extend({}, $.fn.fancyTree.defaults, options);
			return this.each(function(){
				$(this).data('options',params);
				var $this=$(this);
				methods.reload.apply($this);
				$this.on('mouseover','a',function(){$(this).find('i').css('visibility','visible');});
				$this.on('mouseout','a',function(){$(this).find('i').css('visibility','hidden');});
				$this.off('click','.edit').on('click','.edit',function(event){
					methods.edit.apply($this,$(event.target));
				});
				$this.off('click','.add').on('click','.add',function(event){
					methods.add.apply($this,$(event.target));
				});
				$this.off('click','.remove').on('click','.remove',function(event){
					methods.remove.apply($this,$(event.target));
				});
			});
        },
		add: function(e){
			var $this=this;
			Core.dialog('新增部门','manager/edit_role?pid='+$(e).parent().attr('data-id')+'&id=no',function(){
				methods.reload.apply($this);
			},true,false);
		},
		edit: function(e){
			var $this=this;
			Core.dialog('编辑部门','manager/edit_role?id='+$(e).parent().attr('data-id'),function(){
				methods.reload.apply($this);
			},true,false);
		},
		remove: function(e){
			var $this=this;
			var li=$(e).parent().parent();
			Core.dialog('温馨提示','<i class="entypo-info-circled"></i> 确实删除此员工及其下属员工吗？',function(){
				var id=[];
				li.find('span').each(function(){
					id.push($(this).attr('data-id'));
				});
				li.remove();
				$.post(WEB+'manager/delete_role',{id:id.join()},function(){
					methods.reload.apply($this);
					$('.modal').modal('hide');
				});
			},false,false);
		},
		reload: function(){
			var params = $(this).data('options');
			var html = '<ul>';
			var render = function(c){
				$.each(c,function(i,d){
					html+='<li><a href="#" '+(params.pid=='0'||params.pid==d.pid?'data-toggle="popover"':'')+' data-trigger="click" data-placement="bottom" data-html=true data-content="<span data-id=\''+d.id+'\'><i class=\'edit entypo-pencil\'></i> <i class=\'add entypo-plus-circled\'></i>'+(d.pid==0?'':'<i class=\'remove entypo-cancel\'></i></a>')+'</span>">'+d.name+'<br/>('+d.count+')</a>';
					if(d.child){
						html+='<ul>';render(d.child);html+='</ul>';
					}
					html+='</li>';
				});
			};
			var $this=$(this);
			$.getJSON($(this).data('options').url,function(c){
				render(c);
				$this.html(html+'</ul>');
				$this.find('[data-toggle="popover"]').click(function(){
					$this.find('[data-toggle="popover"]').popover('hide');
				});
				//Core.rebuildUI();
			});
		}
    };

    $.fn.fancyTree = function(options) {
        if(methods[options]){
            return methods[options].apply(this, Array.prototype.slice.call(arguments, 1));
        }else if(typeof options==='object'||! options){
            return methods.init.apply( this, arguments );
        }else{
            $.error('Method '+ options +' does not exist on jQuery.tooltip');
        }    
    };
	$.fn.fancyTree.defaults = {};
})(jQuery);

$('#hierarchy').fancyTree({url:WEB+'manager/getlist',pid:'<?php echo $pid?>'});
</script>
<style>
* {margin: 0; padding: 0;}
.tree_com{width:3000px;}
.tree_com ul {padding-top: 20px; position: relative;transition: all 0.5s;-webkit-transition: all 0.5s;-moz-transition: all 0.5s;}
.tree_com li {float: left; text-align: center;list-style-type: none;position: relative;padding: 20px 5px 0 5px;transition: all 0.5s;-webkit-transition: all 0.5s;-moz-transition: all 0.5s;}
.tree_com li::before, .tree_com li::after{content: '';position: absolute; top: 0; right: 50%;border-top: 1px solid #ccc;width: 50%; height: 20px;}
.tree_com li::after{right: auto; left: 50%;border-left: 1px solid #ccc;}
.tree_com li:only-child::after, .tree_com li:only-child::before {display: none;}
.tree_com li:only-child{ padding-top: 0;}
.tree_com li:first-child::before, .tree_com li:last-child::after{border: 0 none;}
.tree_com li:last-child::before{border-right: 1px solid #ccc;border-radius: 0 5px 0 0;-webkit-border-radius: 0 5px 0 0;-moz-border-radius: 0 5px 0 0;}
.tree_com li:first-child::after{border-radius: 5px 0 0 0;-webkit-border-radius: 5px 0 0 0;-moz-border-radius: 5px 0 0 0;}
.tree_com ul ul::before{content: '';position: absolute; top: 0; left: 50%;border-left: 1px solid #ccc;width: 0; height: 20px;}
.tree_com li a{border: 1px solid #ccc;-moz-box-shadow: 0 0 5px #ddd;-webkit-box-shadow: 0 0 5px #ddd;box-shadow: 0 0 5px #ddd;padding: 5px 10px;text-decoration: none;color: #666;display: inline-block;	border-radius: 5px;-webkit-border-radius: 5px;-moz-border-radius: 5px;transition: all 0.5s;-webkit-transition: all 0.5s;-moz-transition: all 0.5s;}
.tree_com i:hover{color:#ff6600}
.tree_com li a i{visibility:hidden}
.tree_com i{cursor:pointer}
.tree_com .popover-content{padding-left:5px;padding-right:5px}
.tree_com li a:hover, .tree_com li a:hover+ul li a {background: #c8e4f8; color: #000; border: 1px solid #94a0b4;}
.tree_com li a:hover+ul li::after, 
.tree_com li a:hover+ul li::before, 
.tree_com li a:hover+ul::before, 
.tree_com li a:hover+ul ul::before{border-color:  #94a0b4;}
</style>