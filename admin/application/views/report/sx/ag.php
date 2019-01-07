<?php $id="form_".uniqid();?>
<table id="<?php echo $id;?>"></table>
<script>
    $("#<?php echo $id;?>").DataSource({url:'sxreport/getsxlist?game=<?php echo $game?>',
        fields:[[
            {field:'id',              title:'ID',         width:40},
            {field:'sn',              title:'站點標識',     width:100},
            {field:'username',        title:'站點用戶名',    width:100},
            {field:'total_bet',       title:'下注金額',     width:100},
            {field:'total_v_bet',     title:'有效下注金額',  width:100},
            {field:'payout',          title:'派彩金額',     width:100},
            {field:'game_type',       title:'游戲類型',     width:100},
            {field:'win_or_lose',     title:'輸贏',        width:100},
            {field:'game_type',       title:'游戲類型',     width:100},
            {field:'total_win_count', title:'贏(注數)',    width:100},
            {field:'total_count',     title:'總注數',      width:100},
            {field:'bet_time',        title:'下注時間',    width:100},
            {field:'is_fs',           title:'是否返水',    width:100, 
                formatter:function(v,r){
                        return v==1?'已返水':'未返水';
                }
            }
       ]], tools:[
            {instant:false}
        ],
        edit:true
    });
</script>