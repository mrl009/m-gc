<div class="row">
    <div class="button-group">
        <button type="button" class="button button-primary" onclick="e_swap(1)">额度转换</button>
        <button type="button" class="button button-primary" onclick="e_swap(2)">额度转换记录</button>
        <button type="button" class="button button-primary" onclick="e_swap(3)">掉单处理</button>
        <div class="col-lg-2">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="輸入用戶名">
                <span class="input-group-btn">
                <button class="button button-primary" type="button">查詢</button>
                </span>
            </div>
        </div>  
    </div>
</div>
<div id="EDZH"></div>
<script type="text/javascript">
    function e_swap(t){
        $.get(WEB+'moneychange/changeTmp?t='+t,function(c){
            $('#EDZH').html(c);
        });
    }
    e_swap(1);
</script>