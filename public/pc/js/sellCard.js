$(function () {
    // 单张提交
    $("#type_single").click(function(){
        $(this).addClass("lx_choose").siblings("li").removeClass("lx_choose");
        let import_txt = $(".import_txt");
        import_txt.hide();
        import_txt.find("input").val("");
        $(".import_one").show();
        $('[name=submitType]').val("single");
    });
    // 批量提交
    $("#type_batch").click(function(){
        $(this).addClass("lx_choose").siblings("li").removeClass("lx_choose");
        let import_one = $(".import_one");
        import_one.hide();
        import_one.find("input").val("");
        $(".import_txt").show();
        $('[name=submitType]').val("batch");
    });

    $('.jj_d').click(function () {
        let urgent = $('[name=urgent]');
        if (urgent.val() === "yes") {
            $(this).find("div").removeClass("agree_check");
            urgent.val("");
            $(this).find("span").hide();
        } else {
            $(this).find("div").addClass("agree_check");
            urgent.val("yes");
            $(this).find("span").show();
        }
    });

    $('.qr_bottom').find("div").click(function () {
        let confirmXY = $('[name=confirmXY]');
        if (confirmXY.val() === "yes") {
            $(this).find("div").removeClass("agree_check");
            confirmXY.val("");
        } else {
            $(this).find("div").addClass("agree_check");
            confirmXY.val("yes");
        }
    });
    /**
     * 改变按钮
     */
    $(this).on("click", "label[for=legal],label[for=confirmXY]", function () {
        setTimeout(function () {
            let cv = $('#confirmXY').is(':checked');
            let cx = $('#legal').is(':checked');
            if (cv && cx) {
                $('.add_btn').css('background', '#5978fb').css('cursor', 'pointer');
            } else {
                $('.add_btn').css('background', 'gray').css('cursor', 'default');
            }
        }, 100);
    });


    $(this).on("click", "#urgent", function () {
        if($('#urgent').is(':checked')) {
            $('#urgent').attr("checked",'checked');
            $('#urgent-money').show();
        } else {
            $('#urgent').removeAttr("checked");
            $('#urgent-money').hide();
        }
    });

    //监听批量提交输入框
    $(document).on("keyup", '#cardBatch', function (e){
        tidyBathCardsFn();
    });

    //整理卡号、卡密
    $(document).on("click", '.import_top_btn1', function (e){
        if($(this).hasClass('no-allowed')){
            ToastInfo("该卡暂不支持自动整理，请手动整理");
        }else{
            tidyBathCardsFn();
        }
    });


    /**
     * 改变按钮
     */
    $(this).on("click", "label[for=legal],label[for=confirmXY]", function () {
        setTimeout(function () {
            let cv = $('#confirmXY').is(':checked');
            let cx = $('#legal').is(':checked');
            if (cv && cx) {
                $('.buy_btn').css('background', '#5978fb').css('cursor', 'pointer');
            } else {
                $('.buy_btn').css('background', 'gray').css('cursor', 'default');
            }
        }, 100);
    });

});


function changeSubmitType(type) {
    let submitType;
    if (type === "" || type === undefined) {
        submitType = "batch";
    } else if(type === 1) {
        submitType = "single";
    } else {
        submitType = "batch";
    }
    $('[name=submitType]').val(submitType);
}
function cardNum(a, c) {
    var b = $(a).val();
    if ("blur" === c) {
        b = b.replace("\r\n", "\n"), b = b.split("\n");
        $("#lineCount").text(b.length);
    } else {
        var d = c.keyCode,
            b = b.replace("\r\n", "\n");
        if (13 == d || 86 == d) b = b.split("\n"), $("#lineCount").text(b.length)
    }
    // 判断是否超出1000张限制
    if (b.length > 1000) {
        showErrorBorder(a);
    } else {
        $(a).removeAttr("style")
    }
    $('#count').text(b.length - 1 + "张");
}


/**
 * 获取卡类下所有的品牌
 * @param event
 * @param card_type_id
 * @param card_info_id
 */
let isClicked = true;
//$('.type_1').click();
function getAllCardBrand(event, card_type_id, card_info_id) {
    $("[name=cardInfoId]").val(card_type_id);
    $.get("/cardinfo", {tid: card_type_id},function (ret) {
        // 查询成功，遍历后渲染tidyChar()
        if (ret.code === 1) {
            let list = '';
            let ids = "";   // 默认点击

            if($('#is_mobile').val()==1){
                $.each(ret.data, function (i, item) {
                    item.rate=(item.zc_profit/10).toFixed(2);
                    ids += item.id + ',';
                    let rate = item.isanyrate ? '自定义' : item.rate + "折";
                    if (item.status === 0) {
                        list += '<li class="info_' + item.id + ' weihu" onclick="getAllCardRate($(this), ' + item.id + ', ' + item.status + ', ' + item.card + ', ' + item.pwd + ', ' + item.urgent + ', ' + item.isanyrate + ', \''+ item.content +'\');return false"><img src="' + item.img + '" alt=""><span>' + item.title + '</span><span class="zk">' + rate + '</span></li>'
                    } else {
                        list += '<li class="info_' + item.id + '" onclick="getAllCardRate($(this), ' + item.id + ', ' + item.status + ', ' + item.card + ', ' + item.pwd + ', ' + item.urgent + ', ' + item.isanyrate + ', \''+ item.content +'\');return false"><img src="' + item.img + '" alt=""><span>' + item.title + '</span><span class="zk">' + rate + '</span></li>'
                    }
                });
                $('#brand_list').html(list);
                //移动端选择卡种
                if (card_info_id !== "" && ids.indexOf(card_info_id) >= 0) {
                    $('.info_' + card_info_id).click();
                } else {
                    $('#brand_list li:first-child').click();
                }
                let shell_show_kl = $('.shell_show_kl ul>li.active');
                // 卡类名字
                let kl_name = shell_show_kl.children("span").first().text();
                $('.kl').text(kl_name);
                // 卡类图片
                let icon = shell_show_kl.find("i").attr("class");
                $('.kl_icon i').attr("class", icon);
                //移动端结束选择
            }else{
                $.each(ret.data, function(i, item) {
                    item.rate=(item.zc_profit/10).toFixed(2);
                    ids += item.id + ',';
                    let rate = item.isanyrate ? '自定义' : item.rate + "折";
                    if (item.status === 0) {
                        list += '<li class="info_'+ item.id +' weihu" onclick="getAllCardRate($(this), '+ item.id +','+ item.status +', '+ item.card +', '+ item.pwd +', '+ item.urgent +', '+ item.isanyrate +', \''+ item.content +'\');return false"><a href="/huishou/'+ item.identification +'.html"><a class="zhe" style="display: block">'+ rate +'</a> <img src="'+ item.img +'" alt="" class="cardimg"><span>'+ item.title +'</span></a></li>'
                    } else if (card_info_id === item.id) {
                        list += '<li class="info_'+ item.id +'" class="lx_choose" onclick="getAllCardRate($(this), '+ item.id +','+ item.status +', '+ item.card +', '+ item.pwd +', '+ item.urgent +', '+ item.isanyrate +', \''+ item.content +'\');return false"><a href="/huishou/'+ item.identification +'.html"><a class="zhe" style="display: block">'+ rate +'</a> <img src="'+ item.img +'" alt="" class="cardimg"><span>'+ item.title +'</span></a></li>'
                    } else {
                        list += '<li class="info_'+ item.id +'" onclick="getAllCardRate($(this), '+ item.id +','+ item.status +', '+ item.card +', '+ item.pwd +', '+ item.urgent +', '+ item.isanyrate +', \''+ item.content +'\');return false"><a href="/huishou/'+ item.identification +'.html"><a class="zhe">'+ rate +'</a> <img src="'+ item.img +'" alt="" class="cardimg"><span>'+ item.title +'</span></a></li>'
                    }
                });
                $('#brand_list').html(list);
                if (card_info_id === "" || card_info_id === undefined) {
                    if (!isClicked) {
                        isClicked = true;
                        $('.type_'+card_type_id).click();
                    }
                    $('#brand_list li:first-child').click();
                }  else {
                    $('.info_'+card_info_id).click();
                }
            }
        } else {
            if (!isClicked) {
                isClicked = true;
                $('.type_'+card_type_id).click();
            }
            $('#brand_list').html("<li class='weihu'><span>暂无可选种类</span></li>");
            $('#mz_list').html("<li class='weihu'><span>暂无可选面额</span></li>");
            $('#customRateShow').hide();
        }
    },'json')
    
    let _txt = $(event).find('.lx_txt h3').html();
    $('#type').text(_txt);
}


/**
 * 获取卡品牌下所有的金额种类
 * @param event
 * @param card_id
 * @param isMaintain
 * @param isCard
 * @param isPwd
 * @param isUrgent
 * @param isAnyRate
 * @param remark  getAllCardRate($(this), '+ item.id +', '+ item.card +','+ item.status +', '+ item.pwd +', '+ item.urgent +', '+ item.isanyrate +', \''+ item.content +'\')
 */
function getAllCardRate(event, card_id, isMaintain, isCard, isPwd, isUrgent, isAnyRate, remark) {
    $("[name=cardValueId]").val(card_id);
    $.get("/cardval", {cid: card_id},function (ret) {
        // 查询成功，遍历后渲染
        //console.log(ret);
        if (ret.code === 1) {
            let list = '';
            if($('#is_mobile').val()==1){
                $.each(ret.data, function(i, item) {
                    // 支持自定义费率
                    if (isAnyRate === 1) {
                        if (item.status === 0 || isMaintain === 2) {
                            list += '<li class="weihu">' + item.value + '元<span class="hs"><span class="red" id="customRate">回收折扣<br>自定义</span></li>'
                        } else {
                            list += '<li onclick="cardAnyRateValueBtnClicked($(this), '+ item.cardvalueId +', '+ item.value +', '+ item.minRate +', '+ item.maxRate +', '+ item.rate +');return false">' + item.value + '元<span class="hs"><span class="red" id="customRate">回收折扣<br>自定义</span></li>'
                        }
                    } else {
                        if (item.value === 0) {
                            if (item.status === 0 || isMaintain === 2) {
                                list += '<li class="weihu">自定义<span class="hs"><span class="red" id="customMZ">'+item.rate +'折</span><br>自定义</span></li>'
                            } else {
                                list += '<li class="free_set" onclick="cardAnyValueBtnClicked($(this), '+ item.cardvalueId +', '+ item.rate +');return false">自定义<span class="hs"><span class="red" id="customMZ">'+item.rate +'折</span><br>自定义</span></li>'
                            }
                        } else {
                            if (item.status === 0 || isMaintain === 2) {
                                list += '<li class="weihu">'+item.value +'元<span class="hs"><span class="red">'+item.rate +'折</span><br>'+ item.price +'元</span></li>'
                            } else {
                                list += '<li onclick="cardValueBtnClicked($(this), '+ item.cardvalueId +', '+ item.value +', '+ item.rate +', '+ item.price +', '+ isAnyRate +');return false">'+item.value +'元<span class="hs"><span class="red">'+item.rate +'折</span><br>'+ item.price +'元</span></li>'
                            }
                        }
                    }
                });
                tidyBathCardsFn(); // 自动整理卡密
                $('#mz_list').html(list);
                $('[name=cardAnyValue]').val("0"); //面值重置为0
                $(".mz_big").text("点击选择面值");
                $(".mz_small>span").first().text("");
                $("#recyclePrice").text("");
                $(".discount").text("");
                // 卡种名字
                let kz_name = $('.shell_show_kz ul>li.active').children("span").first().text();
                $('.kz').text(kz_name);
                $('#cardName').text(kz_name);
                $('#brand').text(kz_name);
                // 卡类图片
                let imgPath = $('#brand_list>li.active').find("img").attr("src");
                $('.kzImg').find("img").attr("src", imgPath);
                $('#cardImg').attr("src", imgPath);
            }else{
                $.each(ret.data, function(i, item) {
                    // 支持自定义费率
                    if (isAnyRate === 1) {
                        if (item.status === 0 || isMaintain === 2) {
                            list += '<li class="weihu"><div class="mid_line"></div><div class="mz_list_left">'+item.value +'元</div><div class="mz_list_right"><h4 id="customRate">回收折扣<br><br>自定义</h4></div></li>'
                        } else {
                            list += '<li onclick="cardAnyRateValueBtnClicked($(this), '+ item.cardvalueId +', '+ item.value +', '+ item.minRate +', '+ item.maxRate +', '+ item.rate +');return false"><div class="mid_line"></div><div class="mz_list_left">'+item.value +'元</div><div class="mz_list_right"><h4 id="customRate">回收折扣<br><br>自定义</h4></div></li>'
                        }
                    } else {
                        if (item.value === 0) {
                            if (item.status === 0 || isMaintain === 2) {
                                list += '<li class="weihu"><div class="mid_line"></div><div class="mz_list_left" id="customMZ">自定义</div><div class="mz_list_right"><h4>'+ item.rate +'折</h4><p id="customPrice">￥'+ item.price +'元</p></div></li>'
                            } else {
                                list += '<li onclick="cardAnyValueBtnClicked($(this), '+ item.cardvalueId +', '+ item.rate +');return false"><div class="mid_line"></div><div class="mz_list_left" id="customMZ">自定义</div><div class="mz_list_right"><h4>'+ item.rate +'折</h4><p id="customPrice">￥'+ item.price +'元</p></div></li>'
                            }
                        } else {
                            if (item.status === 0 || isMaintain === 2) {
                                list += '<li class="weihu"><div class="mid_line"></div><div class="mz_list_left">'+item.value +'元</div><div class="mz_list_right"><h4>'+ item.rate +'折</h4><p>￥'+ item.price +'元</p></div></li>'
                            } else {
                                list += '<li onclick="cardValueBtnClicked($(this), '+ item.cardvalueId +', '+ item.value +', '+ item.rate +');return false"><div class="mid_line"></div><div class="mz_list_left">'+item.value +'元</div><div class="mz_list_right"><h4>'+ item.rate +'折</h4><p>￥'+ item.price +'元</p></div></li>'
                            }
                        }
                    }
                });
                tidyBathCardsFn(); // 自动整理卡密
                $('#mz_list').html(list);
                $('[name=cardAnyValue]').val("0"); //面值重置为0
            }
            $('#tips').html(remark + "因卡号和卡密不匹配，或者面值不正确，如造成损失后果自负！");
            // 无需卡号
            if (isCard === 0) {
                $('#cardNo').hide();
            } else {
                $('#cardNo').show();
            }
            // 无需卡密
            if (isPwd === 0) {
                $('#cardP').hide();
            } else {
                $('#cardP').show();
            }
            // 支持加急
            if (isUrgent === 1) {
                $('#urgentShow').show();
            } else {
                $('#urgentShow').hide();
            }
            // 自定义费率
            if (isAnyRate) {
                $('#isAnyRate').val(1);
                $('#customRateShow').show();
            } else {
                $('#isAnyRate').val(0);
                $('#customRateShow').hide();
            }
        } else {
            $('#mz_list').html("");
            layer.msg(ret.msg,{icon:5});
        }
    },'json')
    if($('#is_mobile').val()==1){
        event.addClass('active').siblings('li').removeClass('active');
        $('.shell_show').hide();
        $('.shadow').hide();
    }else{
        event.siblings("li").removeClass("lx_choose");
        event.addClass("lx_choose");
        event.children('a').find(".zhe").show();
        event.siblings('li').children('a').find(".zhe").hide();
    }

}

function cardValueBtnClicked(a, cardvalueId, price,rate) {
    $("[name=cardValueId]").val(cardvalueId);
    $("[name=cardAnyValue]").val(price);
    if($('#is_mobile').val()==1){
        a.addClass('active').siblings('li').removeClass('active');
        $('.shell_show').hide();
        $('.shadow').hide();
        $(".mz_big").text(price + "元");
        $("#cardPrice").text("（"+price + "元）");
        if ($('#isAnyRate').val()==1) {
            $(".mz_small>span").first().text("自定义折扣");
            $("#recyclePrice").text("自定义折扣");
            $(".discount").text("");
        } else {
            $(".mz_small>span").first().text("￥ " + price + "元");
            $("#recyclePrice").text("￥ " + price + "元");
            $(".discount").text(rate + "折");
        }
        $("#price").text("￥ " + price + "元");
        $('#type').html($('.kl').html())
        $('#brand').text(rate + "折" + $('.kz').html());
    }else{
        a.addClass("lx_choose").siblings("li").removeClass("lx_choose");
        $("#price").text("￥ " + price + "元");
        $('#brand').text(rate + "折" + $('.choose_list .lx_choose').find("span").text());
        $('.mz_tip').removeClass('mz_tip_show');
        
        $.get('/pc/index/backtime',{'id':cardvalueId,'price':price},function(res){
            if(res.code == 0){
                if(cardvalueId == res.id){
                    ht = '（仅供参考）'+res.name + price+'元面值最近1张回收成功的卡密，折扣是'+rate+'，' + res.time;
                    $('#backtime').html(ht);
                    $('#backtime').show();
                }
            }else{
                $('#backtime').hide();
            }
        })
    }
    //边缘弹出
    // layer.open({
    //     type: 1
    //     //,offset: 't' //具体配置参考：offset参数项
    //     ,content: "<div style='padding: 30px'>您选择的是单卡面值为<span style='color: red; font-size: 26px'>"+ price +"  元</span>，因面值选择不正确，造成损失后果自负，请谨慎选择！</div>"
    //     ,btn: ['确定面额', '我不确定']
    //     ,btnAlign: 'c' //按钮居中
    //     //,shade: 0 //不显示遮罩
    //     ,anim: 4 //动画类型
    //     ,yes: function(){
    //         a.addClass("lx_choose").siblings("li").removeClass("lx_choose");
    //         $("[name=cardValueId]").val(cardvalueId);
    //         $("[name=dcardAnyValue]").val(0);
    //         $("#price").text("￥ " + price + "元");
    //         $('#brand').text($('.choose_list .lx_choose').find("span").text());
    //         $('.mz_tip').removeClass('mz_tip_show');
    //         layer.closeAll();
    //     }
    //     ,btn2: function(){
    //         layer.closeAll();
    //     }
    // });
}

/**
 * 自定义费率
 * @param a
 * @param cardvalueId
 * @param price
 * @param min
 * @param max
 */
function cardAnyRateValueBtnClicked(a, cardvalueId, price, min, max,rate) {
    
    $("[name=cardValueId]").val(cardvalueId);
    $("[name=cardAnyValue]").val(price);
    let minRate = min.toFixed(1);
    let maxRate = max.toFixed(1);
    let cardAnyRate = $('#cardAnyRate');
    cardAnyRate.attr("placeholder", "允许输入的折扣区间为："+ minRate + "% - " + maxRate + "%");
    cardAnyRate.attr("min", minRate);
    cardAnyRate.attr("max", maxRate);
    $('#anyRateTips').html( "允许输入的折扣区间为：<span>"+ minRate + "</span>% - <span>" + maxRate + "</span>%，数值越低回收越快(单位0.01)")
    if($('#is_mobile').val()==1){
        a.addClass('active').siblings('li').removeClass('active');
        $('.shell_show').hide();
        $('.shadow').hide();
        $(".mz_big").text(price + "元");
        $("#cardPrice").text("（"+price + "元）");
        if ($('#isAnyRate').val()==1) {
            $(".mz_small>span").first().text("自定义折扣");
            $("#recyclePrice").text("自定义折扣");
            $(".discount").text("");
        } else {
            $(".mz_small>span").first().text("￥ " + price + "元");
            $("#recyclePrice").text("￥ " + price + "元");
            $(".discount").text(rate + "折");
        }
        $("#price").text("￥ " + price + "元");
    }else{
        a.addClass("lx_choose").siblings("li").removeClass("lx_choose");

        // $("[name=cardAnyValue]").val(price);
        $("#price").text("￥ " + price + "元");
        $('#brand').text($('.choose_list .lx_choose').find("span").text());
        
        $.get('/pc/index/backtime',{'id':cardvalueId,'price':price,'ck':1},function(res){
            if(res.code == 0){
                if(cardvalueId == res.id){
                    ht = '（仅供参考）'+res.name + price+'元面值最近1张回收成功的卡密，折扣是'+res.ckv+'，' + res.time;
                    $('#backtime').html(ht);
                    $('#backtime').show();
                }
            }else{
                $('#backtime').hide();
            }
        })
    }

    // layer.open({
    //     type: 1
    //     //,offset: 't' //具体配置参考：offset参数项
    //     ,content: "<div style='padding: 30px'>您选择的是单卡面值为<span style='color: red; font-size: 26px'>"+ price +"  元</span>，因面值选择不正确，造成损失后果自负，请谨慎选择！</div>"
    //     ,btn: ['确定面额', '我不确定']
    //     ,btnAlign: 'c' //按钮居中
    //     //,shade: 0 //不显示遮罩
    //     ,anim: 4 //动画类型
    //     ,yes: function(){
    //         let minRate = min.toFixed(2);
    //         let maxRate = max.toFixed(2);
    //         let cardAnyRate = $('#cardAnyRate');
    //         cardAnyRate.attr("placeholder", "允许输入的折扣区间为："+ minRate + "% - " + maxRate + "%");
    //         cardAnyRate.attr("min", minRate);
    //         cardAnyRate.attr("max", maxRate);
    //         $('#anyRateTips').html( "允许输入的折扣区间为：<span>"+ minRate + "</span>% - <span>" + maxRate + "</span>%，数值越低回收越快")
    //
    //         a.addClass("lx_choose").siblings("li").removeClass("lx_choose");
    //         $("[name=cardValueId]").val(cardvalueId);
    //         $("[name=dcardAnyValue]").val(0);
    //         $("#price").text("￥ " + price + "元");
    //         $('#brand').text($('.choose_list .lx_choose').find("span").text());
    //         layer.closeAll();
    //     }
    //     ,btn2: function(){
    //         layer.closeAll();
    //     }
    // });


    // Swal.fire({
    //     icon: 'warning', // 弹框类型
    //     html: "您选择的是单卡面值为<span style='color: red; font-size: 26px'>"+ price +"  元</span>，因面值选择不正确，造成损失后果自负，请谨慎选择！",
    //     confirmButtonColor: '#5673ff',// 确定按钮的 颜色
    //     confirmButtonText: '确定面额',// 确定按钮的 文字
    //     showCancelButton: true, // 是否显示取消按钮
    //     cancelButtonColor: '#c2c2c2', // 取消按钮的 颜色
    //     cancelButtonText: "我不确定", // 取消按钮的 文字
    //     focusCancel: false, // 是否聚焦 取消按钮
    //     reverseButtons: true,  // 是否 反转 两个按钮的位置 默认是  左边 确定  右边 取消
    //     allowOutsideClick: false
    // }).then(function (isConfirm) {
    //     try {
    //         //判断 是否 点击的 确定按钮
    //         if (isConfirm.value) {
    //             let minRate = min.toFixed(2);
    //             let maxRate = max.toFixed(2);
    //             let cardAnyRate = $('#cardAnyRate');
    //             cardAnyRate.attr("placeholder", "允许输入的折扣区间为："+ minRate + "% - " + maxRate + "%");
    //             cardAnyRate.attr("min", minRate);
    //             cardAnyRate.attr("max", maxRate);
    //             $('#anyRateTips').html( "允许输入的折扣区间为：<span>"+ minRate + "</span>% - <span>" + maxRate + "</span>%，数值越低回收越快")
    //
    //             a.addClass("lx_choose").siblings("li").removeClass("lx_choose");
    //             $("[name=cardValueId]").val(cardvalueId);
    //             $("[name=dcardAnyValue]").val(0);
    //             $("#price").text("￥ " + price + "元");
    //             $('#brand').text($('.choose_list .lx_choose').find("span").text());
    //         }
    //         else {
    //             Swal.close();
    //         }
    //     } catch (e) {
    //         alert(e);
    //     }
    // });
}


function closeShadow() {
    $("body").css({overflow: "scroll"});
    $(".shadow").hide()
}

function cardAnyValueBtnClicked(a, c, b) {
    a.addClass("lx_choose").siblings("li").removeClass("lx_choose");
    // 弹层
    $('.mask').show();
    setTimeout(function () {
        $('.zdy_modal').addClass('modal_show');
    },100);
    $("[anyValue-target]").attr("anyValue-target-state", "off");
    a.attr("anyValue-target", "");
    a.attr("anyValue-target-state", "on");
    a.attr("anyValue-target-vid", c);
    a.attr("anyValue-target-rate", b)
    $('#brand').text($('.choose_list .lx_choose').find("span").text());
}

function setAnyValue() {
    let customValue = $("#customValue").val();
    customValue = parseInt(customValue);
    if (isNaN(customValue)) {
        ToastErr("面值输入错误，仅支持10-10000之间的整数");
        showErrorBorder("#customValue");
        return;
    }
    if (customValue < 10 || customValue > 10000) {
        ToastErr("仅回收面值在10-10000元之间的卡");
        showErrorBorder("#customValue");
        return
    }

    var c = $("[anyValue-target-state\x3don]"), b = parseFloat(c.attr("anyValue-target-rate")),
        d = parseInt(c.attr("anyValue-target-vid")), e = customValue * b / 10;
    $('#customMZ').text(customValue + '元')
    $('#customPrice').text("￥" + e + "元");
    $("#price").text("￥ " + customValue + "元");
    $("[name\x3dcardValueId]").val(d);
    $("[name\x3dcardAnyValue]").val(customValue.toFixed(2));
    $('.mask').hide();
    $('.modal').removeClass('modal_show');
}

function cardAnyValueBtnClicked0(a, c, b) {
    var d = prompt("\u8bf7\u8f93\u5165\u5361\u9762\u503c", "");
    if (null != d && "" != d) {
        try {
            if (d = parseInt(d), isNaN(d)) throw"\u9762\u503c\u8f93\u5165\u9519\u8bef";
        } catch (f) {
            ToastErr("\u9762\u503c\u8f93\u5165\u9519\u8bef");
            return
        }
        var e = d * b;
        a.html("\uffe5\x3cb\x3e" + d.toFixed(2) + "\x3c/b\x3e/\uffe5" + e.toFixed(2) + "\uff08" + (100 * b).toFixed(2) + "%\uff09");
        a.siblings("label").removeClass("actived");
        a.addClass("actived");
        $("[name\x3dcardValueId]").val(c);
        $("[name\x3dcardAnyValue]").val(d.toFixed(2))
    }
}



function saveSaleForm() {
    var a = $("#detailBlock").find(".lx_choose .mz_list_left").html();
    swal({
        type: "info",
        title: "\u63d0\u793a",
        text: "\x3cdiv\x3e\x3cdiv style\x3d'font-size:18px;color: #D35428;margin-top: 10px;text-align: center'\x3e\u60a8\u9009\u62e9\u5151\u6362\u7684\u9762\u989d\u662f\u201c\x3cb\x3e" + a + "\x3c/b\x3e\u201d\uff0c\u8bf7\u786e\u4fdd\u4e0e\u5b9e\u9645\u9762\u989d\u4e00\u81f4\uff0c\u5426\u5219\u540e\u679c\u81ea\u8d1f\uff01\x3c/div\x3e\x3c/div\x3e",
        html: !0,
        showCancelButton: !0,
        cancelButtonText: "\u786e\u5b9a\u4e00\u81f4",
        showConfirmButton: !0,
        confirmButtonText: "\u6211\u4e0d\u786e\u5b9a"
    }, function (a) {
        a || doFormSave()
    })
}

//去掉多字符
function delChar() {
    var cardMsg = $('[name=cardBatch]').val();
    var delchar = $('[name=del]').val();
    var reg ='/'+delchar+'/g';
    cardMsg = cardMsg.replace(eval(reg),'').trim();
    $('[name=cardBatch]').val(cardMsg);
    $('[name=del]').val('');
    getCount();
}
function getCount() {
    var text = $('[name=cardBatch]').val();
    var lines = text.split("\n");
    var linesCount = 0, blankLine = 0;
    for (var i = 0; i < lines.length; i++) {
        if (i === lines.length - 1 && lines[i].trim().length === 0) {
            return;
        }
        // if (lines[i].trim().length === 0) {
        //     blankLine++;
        // } else {
        linesCount++;
        // }
    }
    // if (blankLine > 0) {
    //     ToastWarn("检测卡密中有空行，请删除空行");
    //     showErrorBorder("[name=cardBatch]")
    // }
    if (linesCount > 1000) {
        layer.msg("单次最多可提交1000张，建议您拆分多次提交",{icon:5});
        showErrorBorder("[name=cardBatch]")
    }
    $('#lineCount').html(linesCount);
    $('#count').text(linesCount +" 张");

};

//整理卡密格式
function tidyChar(){
    var a = $("[name=cardBatch]").val().split("\n");
    $("[name=cardBatch]").val(uptijiao(a))
}


/**
 * 正式提交
 */
function submitCard() {
    let cv = $('#confirmXY').is(':checked');
    let cx = $('#legal').is(':checked');
    if (!cv || !cx) {
        layer.msg("请勾选： 我已阅读，理解并接受「服务协议」和「回收说明」", {icon:5})
        return;
    }
    var number = $('.mz_list').find('.mz_list_left').html();
    //判断面值选择状态
    if (number == 0){
        layer.msg('请选择面值', {icon: 2});
        return;
    }

    var subType = $('[name="submitType"]').val();
    $('#submitBtn').html('卡密提交中...请稍等');
    $('#submitBtn').attr('disabled', true);//禁止重复点击
    $('#submitBtn').css('background', 'grey');
    switch (subType) {
        case 'batch':
            //批量提交
            //自动整理一下
            tidyChar();
            dkBatch();
            break;
        case 'single':
            //单张提交
            dk();
            break;
        default:
            layer.msg("提交方式错误，请刷新后重新操作！",{icon:5})
            break;
    }
    // });
}

//单张提交
function dk(){
    $.ajax({
        type:"POST",
        url:"/pc/Dk",
        dataType: 'json',
        data:{
            'cardValueId': ($('[name=cardValueId]')).val(),
            'cardAnyValue':$('[name=cardAnyValue]').val(),
            'cardNo':$.trim($('[name=cardNo]').val()),
            'cardPwd':$.trim($('[name=cardPwd]').val()),
            'cardAnyRate': $.trim($('[name=cardAnyRate]').val())
        },
        success:function(ret){
            //console.log(ret);
            $('.mask').hide();
            $('.modal').removeClass('modal_show');
            if (ret.code == 1) {
                layer.msg(ret.msg,{icon:1,time:2000},function () {
                    window.location.reload();
                });
            }else{
                layer.msg(ret.msg,{icon:5});
                $('.mask').hide();
                $('.modal').removeClass('modal_show');
                $("#cardBatch").focus();
            }
        },
        error: function(xhr, errorType, error) {
            layer.msg(xhr.status + ' ' + xhr.statusText,{icon:5});
        }
    })
}

//批量提交
function dkBatch(){
    $.ajax({
        type:"POST",
        url:"/pc/Dk/batch",
        dataType: 'json',
        data:{
            'cardValueId':($('[name=cardValueId]')).val(),//卡种id
            'cardAnyValue':$('[name=cardAnyValue]').val(),//卡种面值
            'cardBatch':$.trim($('[name=cardBatch]').val()),//卡号数据
            'cardAnyRate': $.trim($('[name=cardAnyRate]').val())//卡种费率
        },
        success:function(ret){
            $('.mask').hide();
            $('.modal').removeClass('modal_show');
            if (ret.code == 1) {
                layer.msg(ret.msg,{icon:1,time:2000},function () {
                    window.location.reload();
                });
            }else{
                layer.msg(ret.msg,{icon:5});
                $('.mask').hide();
                $('.modal').removeClass('modal_show');
                $("#cardBatch").focus();
            }
        },
        error: function(xhr, errorType, error) {
            layer.msg(xhr.status + ' ' + xhr.statusText,{icon:5});
        }
    })
}


/**
 * 显示红色的border外边框
 * @param element_id
 */
function showErrorBorder(element_id) {
    $(element_id).focus();
    $(element_id).css("border-color","#ff6d5a");
    $(element_id).css("box-shadow","0 0 15px rgba(255, 109, 90, 0.35)");
}


function uptijiao(a) {
    for (var c = "", b = Array(a.length), d = 0; d < a.length; d++)
        if (a[d]) {
            var e = a[d].replace(/[^\sA-Za-z0-9,-]*/g, "").replace(/\s+/g, " ").replace(/(^\s*)|(\s*$)|;|\uff1b/g, "").replace(
                /,/g, "*").replace(/[ ]/g, "*").replace(/\uff0c/g, "*").replace(/\t/g, "*").split("*");
            "" != e[0] && (b[d] = e[0]);
            c = void 0 == e[1] ? c + (e[0] + "\n") : c + (e[0] + " " + e[1] + "\n")
        } return c.replace(/(^\s*)|(\s*$)/g, "")
}





function tidyBathCardsFn(){
    var productTypeId = $("#productClassifyId").val();
    var batchCardlist = $("#cardBatch").val();

    var productCode = "";
    var cardtype = $("input[name='cardtype']").val();
    if(cardtype === "" || cardtype === undefined || cardtype === null){
        productCode = $("#idenification").val();
    }else{
        productCode = cardtype;
    }

    var bathInptVal = "";
    if(productTypeId === "1" || productTypeId === "3"){
        bathInptVal = batchCardlist.replace(/\D/g, '');

        if(productCode === 'MOBILE' || productCode === 'MOBILE_SLOW' || productCode === 'MOBILE_DISCOUNT' || productCode === 'ZJYDSK') {//移动卡快销、慢销:卡号 17，卡密 18

            onlyOneRuleCardNeaten(productCode, bathInptVal, 17, 18);

        }else if(productCode === 'UNICOM' || productCode === 'UNICOM_SLOW' || productCode === 'UNICOM_DISCOUNT'){//联通卡快销、慢销:卡号 15，卡密 19

            onlyOneRuleCardNeaten(productCode, bathInptVal, 15, 19);

        }else if(productCode === 'TELECOM' || productCode === 'TELECOM_SLOW' || productCode === 'TELECOM_DISCOUNT'){//电信卡快销、慢销:卡号 19，卡密 18

            onlyOneRuleCardNeaten(productCode, bathInptVal, 19, 18);

        }else if(productCode === 'HOIL' || productCode === 'HOIL_SLOW'){//中国石化快销、慢销:卡号 16，卡密 20

            onlyOneRuleCardNeaten(productCode, bathInptVal, 16, 20);

        }else if(productCode === 'ZSY'){//中石油:卡号 17，卡密 19

            onlyOneRuleCardNeaten(productCode, bathInptVal, 17, 19);

        }

    }else if(productTypeId == "2" || productTypeId == "4"){

        if(productCode != 'TH'){
            bathInptVal = batchCardlist.replace(/\W/g, '');
        }
        else{
            bathInptVal = batchCardlist;
        }

        if(productCode === 'TH'){//天宏一卡通:卡号 12，卡密 15 或者 卡号 10，卡密 10
            //alert("只能输入字母、数字、换行、中英文逗号、空格");
            /*var cardString = $.trim(batchCardlist).replace(/[^A-Za-z0-9\n\r，\, ]/g, '');
            $("#batchCardlist").val(cardString);*/
            thRulesCardNeaten(productCode, bathInptVal, 15);

        }else if(productCode == "SD" || productCode === 'SFT' || productCode === 'ZT'){//盛大一卡通、盛付通一卡通、征途一卡通:卡号 16，卡密 8

            onlyOneRuleCardNeaten(productCode, bathInptVal, 16, 8);

        }else if(productCode === 'QB'){//Q币一卡通:卡号 9，卡密 12

            onlyOneRuleCardNeaten(productCode, bathInptVal, 9, 12);

        }else if(productCode === 'WM'){//完美一卡通:卡号 10，卡密 15

            onlyOneRuleCardNeaten(productCode, bathInptVal, 10, 15);

        }else if(productCode === 'WY'){//网易一卡通:卡号 13，卡密 9

            onlyOneRuleCardNeaten(productCode, bathInptVal, 13, 9);

        }else if(productCode === 'JY'){//久游一卡通:卡号 13，卡密 10

            onlyOneRuleCardNeaten(productCode, bathInptVal, 13, 10);

        }else if(productCode === 'SH'){//搜狐一卡通:卡号 20，卡密 12

            onlyOneRuleCardNeaten(productCode, bathInptVal, 20, 12);

        }else if(productCode === 'ZY'){//纵游一卡通:卡号 15，卡密 15

            onlyOneRuleCardNeaten(productCode, bathInptVal, 15, 15);

        }else if(productCode === 'JW' || productCode === 'APPLE'){//骏网一卡通、苹果卡:卡号 16，卡密 16

            onlyOneRuleCardNeaten(productCode, bathInptVal, 16, 16);

        }else if(productCode === 'JW_ALL'){//骏网全业务卡：无卡号，卡密19位纯数字
            bathInptVal = batchCardlist.replace(/\D/g, '');
            onlyCardPassNeaten(productCode, bathInptVal, 0, 19);

        }else if(productCode === 'ZYK'){//自游卡：卡号 19，卡密 6 纯数字
            bathInptVal = batchCardlist.replace(/\D/g, '');
            onlyOneRuleCardNeaten(productCode, bathInptVal, 19, 6);
        }else if(productCode === 'JS'){//金山一卡通：卡号13位数字，卡密9位纯字母

            onlyOneRuleCardNeaten(productCode, bathInptVal, 13, 9);
        }else{
            noLimitRule(productCode, batchCardlist);
        }

        /*else if(productCode === 'JD_E'){//京东E卡：无卡号，卡密16位数字或字母
            onlyCardPassNeatenByBar(productCode, bathInptVal, 0, 16);
        }*/
    }else{
        noLimitRule(productCode, batchCardlist);
    }

}

function isNoRuleFn(){
    var cardNumLenHidVal = $.trim($("#cardNumRule").val());
    var cardPassLenHidVal = $.trim($("#cardPassRule").val());
    if(cardNumLenHidVal != '-1' && cardPassLenHidVal != '-1'){
        // 两种情况(0， 具体数字； 具体数字， 具体数字)
        return false;
    }else{
        // 四种无法整理卡号的情况（-1， -1； -1， 具体数字； 0， -1； 具体数字， -1）
        return true;
    }
}

function noLimitRule(productCode, batchCardlist){
    var cardNumLenHidVal = $.trim($("#cardNumRule").val());
    var cardPassLenHidVal = $.trim($("#cardPassRule").val());
    var noruleResult = isNoRuleFn();
    if(!noruleResult){
        var filteredData = batchCardlist.replace(/\s/g, '').replace(/\n/g, '').replace(/\r/g, '');
        if(parseInt(cardNumLenHidVal) == 0){
            // 不需要卡号
            onlyCardPassNeaten(productCode, filteredData, parseInt(cardNumLenHidVal), parseInt(cardPassLenHidVal));
        }else{
            onlyOneRuleCardNeaten(productCode, filteredData, parseInt(cardNumLenHidVal), parseInt(cardPassLenHidVal));
        }
    }else{

    }
}

/**
 * 批量提交卡号卡密处理--天宏一卡通规则的情况
 */
function thRulesCardNeaten(productCode, textareaVal, maxCardPwdLength){
    var cardNums = [];
    var cardPwds = [];
    //console.log("textareaVal:" + textareaVal);
    var filteredData = textareaVal.replace(/[\，]/g,',').replace(/\s/g,",").replace(/\n/g, ',');
    //console.log("filteredData:" + filteredData);
    var splitData = filteredData.split(",");

    for(var i = 0; i < splitData.length; i++){
        if(i % 2 == 0){
            if(splitData[i] != ""){
                cardNums.push(splitData[i]);
            }
        }
        else{
            if(splitData[i] != ""){
                cardPwds.push(splitData[i]);
            }
        }
    }

    //console.log("cardNums length:" + cardNums.length);

    if(cardNums.length > 0 && cardNums.length == cardPwds.length){

        var data = "";

        for(var i = 0; i < cardNums.length; i++){
            console.log("cardNums:" + cardNums[i]);
            if(cardNums[i].length == 10){
                if(cardPwds[i].length >= 10){
                    data += cardNums[i] + ' ' + cardPwds[i] + '\n';
                }
                else{
                    data += cardNums[i] + ' ' + cardPwds[i];
                }
            }
            else{
                if(cardPwds[i].length >= 15){
                    data += cardNums[i] + ' ' + cardPwds[i] + '\n';
                }
                else{
                    data += cardNums[i] + ' ' + cardPwds[i];
                }
            }
        }

        data = data.replace(/,/g, '');
        $("#batchCardlist").val(data);

        try {
            //计算输入了几张卡
            var _length = cardPwds.length;
            //var _length = batchData[batchData.length - 1][1].length === (cardPassLen + 1) ? batchData.length : batchData.length - 1;
            $('.card-operation-txt .txt-red').html(_length);
        } catch (err) {

        }
    }

    /*var batchData = [];

    for(var j = 0; j < cardNumberLens.length; j++){
    	var totalLen = cardNumberLens[j] + cardPassLens[j];

        for (var i = 0; i < textareaVal.length; i += totalLen) {//24 = 卡号长度+卡密长度
            batchData.push(textareaVal.substr(i, totalLen))
        }
    }

    batchData = batchData.map(function (item) {
        var item0 = item.substr(0, cardNumberLen).length === cardNumberLen ? item.substr(0, cardNumberLen) + '   ': item.substr(0, cardNumberLen);
        var item1 = item.substr(cardNumberLen, cardPassLen).length === cardPassLen ? item.substr(cardNumberLen, cardPassLen) + '\n' : item.substr(cardNumberLen, cardPassLen);
        return [item0, item1];
    }, this);

    batchData = batchData.slice(0, 1000);//slice() 方法可从已有的数组中返回选定的元素;  join() 方法用于把数组中的所有元素放入一个字符串，元素是通过指定的分隔符进行分隔的，如果省略，则使用逗号作为分隔符。

    var _val = batchData.join('').replace(/,/g, '');*/
    /*$("#batchCardlist").val(_val);

    try {
        //计算输入了几张卡
        var _length = cardPwds.length;
        //var _length = batchData[batchData.length - 1][1].length === (cardPassLen + 1) ? batchData.length : batchData.length - 1;
        $('.card-operation-txt .txt-red').html(_length);
    } catch (err) {

    }*/
}

/**
 * 批量提交卡号卡密处理--只有一种规则的情况
 * @param productCode
 * @param textareaVal
 * @param cardNumberLen
 * @param cardPassLen
 */
function onlyOneRuleCardNeaten(productCode, textareaVal, cardNumberLen, cardPassLen){
    var batchData = [];
    var totalLen = cardNumberLen + cardPassLen;
    for (var i = 0; i < textareaVal.length; i += totalLen) {//24 = 卡号长度+卡密长度
        batchData.push(textareaVal.substr(i, totalLen))
    }
    batchData = batchData.map(function (item) {
        var item0 = item.substr(0, cardNumberLen).length === cardNumberLen ? item.substr(0, cardNumberLen) + '   ': item.substr(0, cardNumberLen);
        var item1 = item.substr(cardNumberLen, cardPassLen).length === cardPassLen ? item.substr(cardNumberLen, cardPassLen) + '\n' : item.substr(cardNumberLen, cardPassLen);
        return [item0, item1];
    }, this);
    var maxSubNum = parseInt($("#maxSubmitCount").html());
    batchData = batchData.slice(0, maxSubNum);//slice() 方法可从已有的数组中返回选定的元素;  join() 方法用于把数组中的所有元素放入一个字符串，元素是通过指定的分隔符进行分隔的，如果省略，则使用逗号作为分隔符。

    var _val = batchData.join('').replace(/,/g, '');
    $("#batchCardlist").val(_val);
    try {
        //计算输入了几张卡
        var _length = batchData[batchData.length - 1][1].length === (cardPassLen + 1) ? batchData.length : batchData.length - 1;
        $('.card-operation-txt .txt-red').html(_length);
    } catch (err) {}
}

/**
 * 批量提交卡号卡密处理--无卡号，只有卡密的情况
 * @param productCode
 * @param textareaVal
 * @param cardNumberLen
 * @param cardPassLen
 */
function onlyCardPassNeaten(productCode, textareaVal, cardNumberLen, cardPassLen){
    var batchData = [];
    for (var i = 0; i < textareaVal.length; i += cardPassLen) {
        batchData.push(textareaVal.substr(i, cardPassLen))
    }
    batchData = batchData.map(function (item) {
        var newItem = item.substr(0, cardPassLen).length === cardPassLen ? item.substr(0, cardPassLen) + '\n': item.substr(0, cardPassLen);
        return newItem;
    }, this);
    var maxSubNum = parseInt($("#maxSubmitCount").html());
    batchData = batchData.slice(0, maxSubNum);
    var _val = batchData.join('').replace(/,/g, '');
    $("#batchCardlist").val(_val);
    try {
        //计算输入了几张卡
        var _length = batchData[batchData.length - 1].length === (cardPassLen + 1) ? batchData.length : batchData.length - 1;
        $('.card-operation-txt .txt-red').html(_length);
    } catch (err) {}
}

/**
 * 批量提交卡号卡密处理--无卡号，只有卡密的情况，每4位用横杠分割
 * @param productCode
 * @param textareaVal
 * @param cardNumberLen
 * @param cardPassLen
 */
function onlyCardPassNeatenByBar(productCode, textareaVal, cardNumberLen, cardPassLen){
    var batchData = [];
    for (var i = 0; i < textareaVal.length; i += cardPassLen) {
        batchData.push(textareaVal.substr(i, cardPassLen))
    }
    console.log('京东E卡：'+batchData)
    batchData = batchData.map(function (item) {
        var itemLen = item.length;
        if(itemLen > 4 && itemLen < 9){
            item = item .substr(0, 4) + '-' + item.substr(4)
        } else if (itemLen >= 9 && itemLen < 14) {
            item = item.substr(0, 4) + '-' + item.substr(4, 4) + '-' + item.substr(8, 4)
        } else if (itemLen >= 14) {
            item = item.substr(0, 4) + '-' + item.substr(4, 4) + '-' + item.substr(8, 4) + '-' + item.substr(12, 4)
        }
        var newItem = item.substr(0, cardPassLen+3).length === cardPassLen+3 ? item.substr(0, cardPassLen+3) + '\n': item.substr(0, cardPassLen+3);
        return newItem;
    }, this);
    console.log('京东E卡111：'+batchData)
    var maxSubNum = parseInt($("#maxSubmitCount").html());
    batchData = batchData.slice(0, maxSubNum);
    var _val = batchData.join('').replace(/,/g, '');
    console.log('京东E卡222：'+_val)
    $("#batchCardlist").val(_val);
    try {
        //计算输入了几张卡
        var _length = batchData[batchData.length - 1].length === (cardPassLen+3 + 1) ? batchData.length : batchData.length - 1;
        $('.card-operation-txt .txt-red').html(_length);
    } catch (err) {}
}

/**
 * 判断是否超过今日限额
 */
function checkTodayLimitIsEnough() {
    var memberTodayLimit = parseFloat($("#memberTodayLimit").val());
    var totalPrice = "";

    var submitWay = $("#type").val();
    if(submitWay=="1"){//单卡提交
        totalPrice = parseFloat($("#price").val());
    }else if(submitWay=="2"){//批量提交
        var num = parseInt($('.card-operation-txt .txt-red').text());
        totalPrice = num*parseFloat($("#price").val());
    }

    if(memberTodayLimit>0){
        if(totalPrice > memberTodayLimit){
            layer.msg('提交失败，本次提交的卡密总面值，超过今天剩余可用额度('+memberTodayLimit+'元)！', {icon : 2,shade : [ 0.4, '#000' ],time : 2000});
            return false;
        }else{
            return true;
        }
    }else if(memberTodayLimit==0){//额度已用完
        layer.msg('已到达今天提交限额，请明天再销卡', {icon : 2,shade : [ 0.4, '#000' ],time : 2000});
        return false;
    }else{//不限额
        return true;
    }
}

/**
 * 判断话费卡产品是否有选择面值
 */
function checkPhoneCardPrice(){
    var phoneCardPrice = $.trim($("#price").val());
    if(phoneCardPrice=="0" || phoneCardPrice=="" || phoneCardPrice==null || phoneCardPrice==undefined){
        layer.msg('请选择面值，面值选错，如造成损失后果自负', {icon : 2,shade : [ 0.4, '#000' ],time : 2000});
        return false;
    }else{
        return true;
    }
}

function isOnlyCardPass(){
    var productCode = "";
    var cardtype = $("input[name='cardtype']").val();
    if(cardtype == "" || cardtype == undefined || cardtype == null){
        productCode = $("#operatorsWrap .data-type-operator.active").attr("product-code");
    }else{
        productCode = cardtype;
    }
    var cardNumLenHidVal = $.trim($("#cardNumRule").val());
    if(productCode==='JW_ALL' || parseInt(cardNumLenHidVal) === 0){
        return true;
    }else{
        return false;
    }
}

/**
 * 运营商（卡种）是否正在维护中
 * @param status: 维护状态[0：正常   1：正在维护]	如果为空，那就默认是正常的;只有为1的时候，才是正在维护中
 */
function isOperatorMaintain(status){
    if (status === '1') {
        return false;
    } else {
        return true;
    }
}

/**
 * 维护状态提交按钮设为灰色
 * @param canSubmit
 */
function setSubmitBtnBg(canSubmit){
    if(canSubmit){
        $(".card-submit-btn").removeClass('no-allowed');
    }else{
        $(".card-submit-btn").addClass('no-allowed');
    }

}

/**
 * 设置产品规则提示信息
 */
function setProductRuleTip(operatorId){
    var productCode = "";
    var cardtype = $("input[name='cardtype']").val();
    if(cardtype == "" || cardtype == undefined || cardtype == null){
        $(".data-type-operator").each(function(){
            if($(this).attr("id") == operatorId){
                productCode = $(this).attr("product-code");
            }
        });
    }else{
        productCode = cardtype;
    }

    var pRuleTipArr = [{
        code: 'YMS',
        tip: '如果没有卡号，在卡号那里也填卡密；面值一定要选择正确，如造成损失后果自负！'
    },{
        code: 'WLT',
        tip: '卡号和卡密必填！上传之前请确认卡是否已经开通激活，未激活的卡请联系发卡方激活，面值一定要选择正确，如造成损失后果自负！'
    },{
        code: 'YHD',
        tip: '卡号和卡密必填！卡密必填，面值一定要选择正确，如造成损失后果自负！'
    },{
        code: 'YQB',
        tip: '卡号和卡密必填！卡密必填，面值一定要选择正确，如造成损失后果自负！'
    },{
        code: 'GMMTK',
        tip: '卡号和卡密必填！卡密必填，面值一定要选择正确，如造成损失后果自负！'
    },{
        code: 'LHMSP',
        tip: '请务必确认领货码的使用范围为E型（食品+生鲜+酒水）G型（美妆个护+家居+母婴+食品+生鲜），实体卡背面面值后面有字母为E/G的可以上传,品类提交错误，系统无法退还损失自负！面值一定要选择正确，如造成损失后果自负！'
    },{
        code: 'JD_GB',
        tip: '面值一定要选择正确，如造成损失后果自负！'
    },{
        code: 'LHMSJ',
        tip: '请务必确认领货码的使用范围为手机或数码3C，品类提交错误，系统无法退还损失自负！实体卡背面面值后面有字母为A/B/C的可以上传，面值一定要选择正确，如造成损失后果自负！'
    },{
        code: 'DDLP',
        tip: '卡号和卡密必填！卡密必填，面值一定要选择正确，如造成损失后果自负！'
    },{
        code: 'FFT',
        tip: '卡号和卡密必填！卡密必填，面值一定要选择正确，如造成损失后果自负！'
    },{
        code: 'BLT',
        tip: '卡号和卡密必填！卡密必填，面值一定要选择正确，如造成损失后果自负！'
    },{
        code: 'WRM',
        tip: '只收2326开头的沃尔玛电子券和12和20位数字的兑换码，2326开头的沃尔玛必须有6位数的在线支付密码才能回收，面值一定要选择正确，如造成损失后果自负！'
    },{
        code: 'WST',
        tip: '卡号和卡密必填！卡密必填，面值一定要选择正确，如造成损失后果自负！'
    },{
        code: 'ZHXST',
        tip: '只收全国通用商通卡(7320***和 7360***号段)，面值一定要选择正确，如造成损失后果自负！'
    },{
        code: 'HXT',
        tip: '卡号和卡密必填！卡密必填，面值一定要选择正确，如造成损失后果自负！'
    },{
        code: 'HGT',
        tip: '【卡密规则】卡号19位+密码6位，面值一定要选择正确，如造成损失后果自负！'
    },{
        code: 'NSDK',
        tip: '卡号和卡密必填！卡密必填，面值一定要选择正确，如造成损失后果自负！'
    },{
        code: 'JD_E',
        // tip: '提交有效卡券后请勿擅自使用！京卡密为16位数字和字母组成，处理时间9:00-24:00'
        tip: '仅回收可购买大部分京东自营商品的京东E卡，如有京东其他类型礼品卡，造成损失后果自负，处理时间：9:00-24:00，面值一定要选择正确，如造成损失后果自负！'
    },{
        code: 'YDSHK',
        tip: '无法全额回收！以实际消耗金额结算（无论多少面额的卡都会剩余45元），面值一定要选择正确，如造成损失后果自负！'
    },{
        code: 'JJYKT',
        tip: '卡号卡密必填，面值一定要选择正确，如造成损失后果自负！'
    },{
        code: 'TMCSXTK',
        tip: '卡号和卡密必填！不能有误（http://jf.10086.cn 移动积分可兑换天猫超市卡），面值一定要选择正确，如造成损失后果自负！'
    },{
        code: 'MTMDK',
        tip: '卡号16位,卡密 6位，面值一定要选择正确，如造成损失后果自负！'
    },{
        code: 'SNYGLPK',
        tip: '【卡密规则】 卡号为16位，卡密为6位；苏宁电器卡请选择正确类型，苏宁超市卡无法回收请勿提交，提交错类型损失自负！提交前请确认卡种，并确保卡密及面值正确。'
    },{
        code: 'XCRWX',
        tip: '【卡密规则】 卡号为12位，卡密为6位；请确认卡密输入无误，面值一定要选择正确，如造成损失后果自负！'
    },{
        code: 'TNSLK',
        tip: '请确认卡密输入无误， 【卡号 9位 卡密 6位】，面值一定要选择正确，如造成损失后果自负！'
    },{
        code: 'WYYXK',
        tip: '请确认卡密输入无误，卡号16位，卡密16位，面值一定要选择正确，如造成损失后果自负！'
    },{
        code: 'WPHLPK',
        tip: '【卡密规则】卡号18位,卡密16位，面值一定要选择正确，如造成损失后果自负！'
    },{
        code: 'QNELPK',
        tip: '卡号卡密必填，面值一定要选择正确，如造成损失后果自负！'
    },{
        code: 'HMXS',
        tip: '注：卡密是12位的，正常处理时间1-2个工作日，请勿催单。请勿大量提交无效卡，面值一定要选择正确，如造成损失后果自负！'
    },{
        code: 'JLFCSDJQ',
        tip: '只收未绑定的2336开头的（卡号19位、卡密6位）的家乐福礼品卡，面值一定要选择正确，如造成损失后果自负！'
    },{
        code: 'MGTV',
        tip: '该卡密需人工处理，预计3-5个工作日回款，请保证卡密剩余7日有效期。请勿催单。卡密长度17位，请勿输错（严禁提交已被使用的激活码），面值一定要选择正确，如造成损失后果自负！'
    }];
    console.log('当前产品编码：'+productCode+';运营商ID：'+operatorId);
    for(var i=0; i<pRuleTipArr.length; i++){
        if(productCode===pRuleTipArr[i].code){
            if(cardtype == "" || cardtype == undefined || cardtype == null){
                $("#recycleRulesWrap").html(pRuleTipArr[i].tip);
            }else{
                $("#recycleRulesWrap").html('<i class="comm-icon icon-error"></i>'+pRuleTipArr[i].tip);
            }
        }
    }
}
