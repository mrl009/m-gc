<form class="form-inline">
    <?php foreach ($odds as $k => $v) { ?>
        <div class="oddslist">
            <h4><?php echo $k ?></h4>
            <?php foreach ($v as $kk => $vv) { ?>
                <?php foreach ($vv as $kkk => $vvv) { ?>
                    <fieldset>
                        <legend><?php echo array_shift(explode('-', $kk)) . '--' . $vvv['name'] ?>
                            <?php
                            $arr = array('3z2', '2zt', '5bz', '6bz', '7bz', '7bz', '8bz', '9bz', '10bz', '11bz', '12bz', '5z1', '6z1', '7z1', '8z1', '9z1', '10z1', 'bz', 'z', '4qz', '3qz', '2qz', 'tc');
                            if (!in_array($vvv['sname'], $arr)) {
                                ?>
                                <!--<span style="padding-left: 15px;">賠率：</span>
                                <input type="text" class="form-control allrate" onkeyup="tsses.allUpdate(this)" maxlength="8">
                                <span style="padding-left: 15px;">退水：</span>
                                <input type="text" class="form-control allrebate" onkeyup="tsses.allTs(this)" maxlength="6">
                                <button class="btn btn-danger btn-icon" type="button" onclick="tsses.batchUpdate(this)">批量修改</button>
                                <input type="hidden" value="<?php /*echo $vvv['tid'] ? $vvv['tid'] : $vvv['balls'][1]['tid'] */?>" class="tid"/>-->
                            <?php } ?>
                        </legend>
                        <div class="oddslistInfo">
                            <?php if (in_array($vvv['sname'], $arr)){ ?>
                            <div class="fl listInfo" style="padding-right: 20px;margin-bottom:15px">
                                <div class="form-group" style="width:90px;">
                                    <input type="hidden" value="<?php echo $vvv['id'] ?>" class="setid"/>
                                    <h5 style="text-align: center;height: 20px;"><?php echo $vvv['name'] ?></h5>
                                </div>
                                <div class="form-group">
                                    <label>最大賠率：</label>
                                    <?php $all = explode(',', $vvv['rate']);
                                    if (count($all) > 1) {
                                        foreach ($all as $av) {
                                            echo '<input type="text" onkeyup="tsses.yz(this)" class="form-control easyui-validatebox ratelist" value="' . $av . '" style="width:70px" maxlength="8">';
                                        }
                                    } else {
                                        echo '<input type="text" onkeyup="tsses.yz(this)" class="form-control easyui-validatebox rate" value="' . $vvv['rate'] . '" style="width:450px" maxlength="8">';
                                    }
                                    ?>
                                </div>
                                <div class="form-group">
                                    <label>最小賠率：</label>
                                    <?php
                                    $arr = explode(',', $vvv['rate_min']);
                                    if (count($arr) > 1) {
                                        foreach ($arr as $av) {
                                            echo '<input type="text" class="fl form-control easyui-validatebox rate_minlist"  onkeyup="OddsSs.yz(this)" value="' . $av . '" style="width:60px;padding-left:1px"  maxlength="8">';
                                        }
                                    } else {
                                        echo '<input type="text" class="form-control easyui-validatebox rate_min"  onkeyup="OddsSs.yz(this)" value="' . $vvv['rate_min'] . '"  maxlength="8">';
                                    }
                                    ?>
                                </div>
                                <div class="form-group">
                                    <label class="fl" style="padding-top:10px">&nbsp;&nbsp;最大退水：</label>
                                    <input type="text" class="form-control rebate fl" style="width: 90px;" value="<?php echo $vvv['rebate'] ?>" onkeyup="tsses.yz(this)" maxlength="6">
                                    <div class="input-group-addon fl" style="width: 35px;height: 30px;padding-top:8px">%</div>
                                </div>
                                <lable>
                                    <button class="btn btn-success btn-icon" onclick="tsses.saveOdds(this)" type="button">保存 <i class="entypo-check"></i></button>
                                </lable>
                                <?php } else { ?>
                                    <?php foreach ($vvv['balls'] as $kkkk => $vvvv) { ?>
                                        <div class="fl listInfo" style="padding-right: 20px;margin-bottom:15px">
                                            <div class="form-group" style="width:90px;">
                                                <input type="hidden" value="<?php echo $vvvv['id'] ?>" class="setid"/>
                                                <h5 style="text-align: center;height: 20px;"><?php echo $vvvv['name'] ?></h5>
                                            </div>
                                            <div class="form-group">
                                                <label>最大賠率：</label>
                                                <input type="text" class="form-control easyui-validatebox rate" value="<?php echo $vvvv['rate'] ?>" style="width:250px" onkeyup="tsses.yz(this)">
                                            </div>
                                            <div class="form-group">
                                                <label>最小賠率：</label>
                                                <input type="text" class="form-control easyui-validatebox rate_min" value="<?php echo $vvvv['rate_min'] ?>" style="width:250px" onkeyup="tsses.yz(this)">
                                            </div>
                                            <div class="form-group">
                                                <label class="fl" style="padding-top:10px">&nbsp;&nbsp;最大退水：</label>
                                                <input type="text" class="form-control rebate fl" style="width: 90px;" value="<?php echo $vvvv['rebate'] ?>" onkeyup="tsses.yz(this)" maxlength="8">
                                                <div class="input-group-addon fl" style="width: 35px;height: 30px;padding-top:8px">%
                                                </div>
                                            </div>
                                            <label>
                                                <button class="btn btn-success btn-icon" onclick="tsses.saveOdds(this)" type="button">保存<i class="entypo-check"></i></button>
                                            </label>
                                        </div>
                                    <?php }
                                } ?>
                            </div>
                    </fieldset>
                <?php }
            } ?>
        </div>
        <div class="clearfix"></div>
    <?php } ?>
</form>

<script type="text/javascript">
    var tsses = {
        init: function () {
            var id = $('#odds .cpbtn').eq(0).attr('val');
            var tmp = $('#odds .cpbtn').eq(0).attr('tmp');
            tsses.getlist(id, tmp);
            $('#odds .delone').text('清除' + $('#odds .cpbtn').eq(0).text() + '緩存');
            $('#odds .cpbtn').eq(0).removeClass('btn-link');
            $('#odds .cpbtn').eq(0).addClass('btn-danger');
        },
        getlist: function (id, tmp) {
            layer.msg('加載中', {icon: 16, shade: 0.01});
            $.get('odds/get_list_new?id=' + id + '&tmp=' + tmp + '&ctg=<?php echo $ctg?>', function (c) {
                $('#newsOdds').html(c);
                layer.closeAll();
            });
        },
        change: function (e) {
            $('#odds .delone').text('清除' + $(e).text() + '緩存');
            $('#odds .cpbtn').removeClass('btn-danger');
            $('#odds .cpbtn').addClass('btn-link');
            $(e).removeClass('btn-link');
            $(e).addClass('btn-danger');
            tsses.getlist($(e).attr('val'), $(e).attr('tmp'));
        },
        saveOdds: function (e) {
            var _ = $(e).parent().parent();
            setid = _.find('.setid').val();
            rate = _.find('.rate').val();
            rate_min = _.find('.rate_min').val();
            rebate = _.find('.rebate').val();
            ratelist = _.find('.ratelist');
            rate_minlist = _.find('.rate_minlist');

            if (setid == '' || rate == '') {
                Core.error('輸入信息有誤');
                return;
            }
            if (rate != undefined) {
                if (rate <= 0) {
                    Core.error('賠率數據不合法');
                    return;
                }
            } else {
                if (ratelist != undefined) {
                    var dd = [];
                    var Exit = false;
                    $.each(ratelist, function (i, d) {
                        if ($(d).val() == '') {
                            Core.error('輸入賠率有誤');
                            Exit = true;
                        }
                        dd.push($(d).val());
                    });
                    if (Exit) return false;
                    rate = dd.join(',');
                }
            }

            if (rate_min != undefined) {
                if (rate_min <= 0) {
                    Core.error('最小賠率數據不合法');
                    return;
                }
            } else {
                if (rate_minlist != undefined) {
                    var dd = [];
                    var Exit = false;
                    $.each(rate_minlist, function (i, d) {
                        if ($(d).val() == '') {
                            Core.error('輸入賠率有誤');
                            Exit = true;
                        }
                        dd.push($(d).val());
                    });
                    if (Exit) return false;
                    rate_min = dd.join(',');
                }

            }

            if (rebate != undefined && rebate != '') {
                if (rebate < 0 || isNaN(rebate)) {
                    Core.error('返水數據不合法');
                    return;
                }
            }
            $.post('odds/save_odds', {setid: setid, rate: rate, rate_min: rate_min, rebate: rebate}, function (c) {
                c = eval('(' + c + ')');
                if (c.status == 'OK') {
                    Core.ok('修改成功');
                } else {
                    Core.error(c.msg);
                }
            });
        },
        updateOdds: function () {
            var id = $('#cpLists .btn-danger').attr('val');
            var tmp = $('#cpLists .btn-danger').attr('tmp');
            $.messager.confirm('溫馨提示', '確定要初始化賠率嗎', function (r) {
                if (r) {
                    $.post('odds/rate_init', {id: id}, function (c) {
                        c = eval('(' + c + ')');
                        if (c.status == 'OK') {
                            Oddss.getlist(id, tmp);
                            Core.ok('初始化成功');
                        } else {
                            Core.error(c.msg);
                        }
                    });
                }
            });
        },
        //刪除緩存
        delCache: function (e) {
            var id = $('#cpLists .btn-danger').attr('val');
            var tmp = $('#cpLists .btn-danger').attr('tmp');
            var title = $('#cpLists .btn-danger').text();
            if (e == 'play') {
                id = '';
                title = '所有彩票';
            }
            $.messager.confirm('溫馨提示', '確定要刪除(' + title + ')緩存嗎', function (r) {
                if (r) {
                    $.post('odds/del_cache', {id: id}, function (c) {
                        c = eval('(' + c + ')');
                        if (c.status == 'OK') {
                            Oddss.getlist(id, tmp);
                            Core.ok('刪除緩存成功');
                        } else {
                            Core.error(c.msg);
                        }
                    });
                }
            });
        },
        batchUpdate: function (obj) {
            var tid = $(obj).parent().find('.tid').val();
            var allrate = $(obj).parent().find('.allrate').val();
            var allrebate = $(obj).parent().find('.allrebate').val();
            if (allrate == '' && allrebate == '') {
                Core.error('請輸入的賠率或返水');
                return;
            }
            $.post('odds/save_odds_batch', {tid: tid, rate: allrate, rebate: allrebate}, function (c) {
                c = eval('(' + c + ')');
                if (c.status == 'OK') {
                    //Oddss.getlist(id);
                    Core.ok('批量修改成功');
                } else {
                    Core.error(c.msg ? c.msg : '未知錯誤');
                }
            });

        },
        yz: function (obj) {
            //修復第壹個字符是小數點 的情況.
            if (obj.value != '' && obj.value.substr(0, 1) == '.') {
                obj.value = "";
            }
            obj.value = obj.value.replace(/[^\d.]/g, "");  //清除“數字”和“.”以外的字符
            //obj.value = obj.value.replace(/\.{2,}/g,"."); //只保留第壹個. 清除多余的
            obj.value = obj.value.replace(".", "$#$").replace(/\./g, "").replace("$#$", ".");
            1
            obj.value = obj.value.replace(/^(\-)*(\d+)\.(\d\d\d).*$/, '$1$2.$3');//只能輸入三個小數
            if (obj.value.indexOf(".") < 0 && obj.value != "") {	//以上已經過濾，此處控制的是如果沒有小數點，首位不能為類似於 01、02的金額
                if (obj.value.substr(0, 1) == '0' && obj.value.length == 2) {
                    obj.value = obj.value.substr(1, obj.value.length);
                }
            }
        },
        allUpdate: function (obj) {
            tsses.yz(obj);
            var _ = $(obj).parent().parent().find('.oddslistInfo .rate');
            _.val($(obj).val());
        },
        allTs: function (obj) {
            tsses.yz(obj);
            var _ = $(obj).parent().parent().find('.oddslistInfo .rebate');
            _.val($(obj).val());
        }
    };
</script>