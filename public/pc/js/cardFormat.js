

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
    var productTypeId = $(".lx_active").attr("data-typeid");
    var batchCardlist = $("#cardBatch").val();

    var productCode = $("input[name='cardInfoId']").val();
    var bathInptVal = "";
    if(productTypeId === "15" || productTypeId === "17"){
        bathInptVal = batchCardlist.replace(/\D/g, '');

        if(productCode === '74' || productCode === '104') {//移动卡快销、慢销:卡号 17，卡密 18
            onlyOneRuleCardNeaten(productCode, bathInptVal, 17, 18);
        }else if(productCode === '75' || productCode === '103' || productCode === '109' || productCode === '119'){//联通卡快销、慢销:卡号 15，卡密 19
            onlyOneRuleCardNeaten(productCode, bathInptVal, 15, 19);
        }else if(productCode === '76' || productCode === '105'){//电信卡快销、慢销:卡号 19，卡密 18
            onlyOneRuleCardNeaten(productCode, bathInptVal, 19, 18);
        }else if(productCode === '84' || productCode === '106'){//中国石化快销、慢销:卡号 16，卡密 20
            onlyOneRuleCardNeaten(productCode, bathInptVal, 16, 20);
        }else if(productCode === '85'){//中石油:卡号 17，卡密 19
            onlyOneRuleCardNeaten(productCode, bathInptVal, 17, 19);
        }
    }else if(productTypeId === "16" || productTypeId === "14"){
        if(productCode != '87' || productCode != '88' || productCode != '89'){
            bathInptVal = batchCardlist.replace(/\W/g, '');
        }
        else{
            bathInptVal = batchCardlist;
        }

        if(productCode === '87' || productCode === '88' || productCode === '89'){//天宏一卡通:卡号 12，卡密 15 或者 卡号 10，卡密 10
            //alert("只能输入字母、数字、换行、中英文逗号、空格");
            /*var cardString = $.trim(batchCardlist).replace(/[^A-Za-z0-9\n\r，\, ]/g, '');
            $("#cardBatch").val(cardString);*/
            thRulesCardNeaten(productCode, bathInptVal, 15);

        }else if(productCode === "92" || productCode === '97' || productCode === '100'){//盛大一卡通、盛付通一卡通、征途一卡通:卡号 16，卡密 8

            onlyOneRuleCardNeaten(productCode, bathInptVal, 16, 8);

        }else if(productCode === '90'){//Q币一卡通:卡号 9，卡密 12

            onlyOneRuleCardNeaten(productCode, bathInptVal, 9, 12);

        }else if(productCode === '91'){//完美一卡通:卡号 10，卡密 15

            onlyOneRuleCardNeaten(productCode, bathInptVal, 10, 15);

        }else if(productCode === '98'){//网易一卡通:卡号 13，卡密 9

            onlyOneRuleCardNeaten(productCode, bathInptVal, 13, 9);

        }else if(productCode === '102'){//久游一卡通:卡号 13，卡密 10

            onlyOneRuleCardNeaten(productCode, bathInptVal, 13, 10);

        }else if(productCode === '94'){//搜狐一卡通:卡号 20，卡密 12

            onlyOneRuleCardNeaten(productCode, bathInptVal, 20, 12);

        }else if(productCode === '101'){//纵游一卡通:卡号 15，卡密 15

            onlyOneRuleCardNeaten(productCode, bathInptVal, 15, 15);

        }else if(productCode === '86' || productCode === '86'){//骏网一卡通、苹果卡:卡号 16，卡密 16

            onlyOneRuleCardNeaten(productCode, bathInptVal, 16, 16);

        }else if(productCode === 'JW_ALL'){//骏网全业务卡：无卡号，卡密19位纯数字
            bathInptVal = batchCardlist.replace(/\D/g, '');
            onlyCardPassNeaten(productCode, bathInptVal, 0, 19);

        }else if(productCode === '95'){//自游卡：卡号 19，卡密 6 纯数字
            bathInptVal = batchCardlist.replace(/\D/g, '');
            onlyOneRuleCardNeaten(productCode, bathInptVal, 19, 6);
        }else if(productCode === '93'){//金山一卡通：卡号13位数字，卡密9位纯字母

            onlyOneRuleCardNeaten(productCode, bathInptVal, 13, 9);
        }else{
            console.log(111);
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
    if(cardNumLenHidVal !== '' && cardPassLenHidVal !== undefined){
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
        $("#cardBatch").val(data);

        try {
            //计算输入了几张卡
            var _length = cardPwds.length;
            //var _length = batchData[batchData.length - 1][1].length === (cardPassLen + 1) ? batchData.length : batchData.length - 1;
            $('#lineCount').html(_length);
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
    /*$("#cardBatch").val(_val);

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
        var item0 = item.substr(0, cardNumberLen).length === cardNumberLen ? item.substr(0, cardNumberLen) + ' ': item.substr(0, cardNumberLen);
        var item1 = item.substr(cardNumberLen, cardPassLen).length === cardPassLen ? item.substr(cardNumberLen, cardPassLen) + '\n' : item.substr(cardNumberLen, cardPassLen);
        return [item0, item1];
    }, this);
    var maxSubNum = 1000;
    batchData = batchData.slice(0, maxSubNum);//slice() 方法可从已有的数组中返回选定的元素;  join() 方法用于把数组中的所有元素放入一个字符串，元素是通过指定的分隔符进行分隔的，如果省略，则使用逗号作为分隔符。

    var _val = batchData.join('').replace(/,/g, '');
    $("#cardBatch").val(_val);
    try {
        //计算输入了几张卡
        var _length = batchData[batchData.length - 1][1].length === (cardPassLen + 1) ? batchData.length : batchData.length - 1;
        $('#lineCount').html(_length);
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
    $("#cardBatch").val(_val);
    try {
        //计算输入了几张卡
        var _length = batchData[batchData.length - 1].length === (cardPassLen + 1) ? batchData.length : batchData.length - 1;
        $('#lineCount').html(_length);
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
    var maxSubNum = parseInt($("#maxSubmitCount").html());
    batchData = batchData.slice(0, maxSubNum);
    var _val = batchData.join('').replace(/,/g, '');
    $("#cardBatch").val(_val);
    try {
        //计算输入了几张卡
        var _length = batchData[batchData.length - 1].length === (cardPassLen+3 + 1) ? batchData.length : batchData.length - 1;
        $('#lineCount').html(_length);
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
 * @param state: 维护状态[0：正常   1：正在维护]	如果为空，那就默认是正常的;只有为1的时候，才是正在维护中
 */
function isOperatorMaintain(state){
    if (state === '1') {
        return true;
    } else {
        return false;
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
