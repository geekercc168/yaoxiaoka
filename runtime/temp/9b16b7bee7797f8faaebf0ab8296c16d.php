<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:61:"/www/wwwroot/yaoxiaoka/application/pc/view/index/m_index.html";i:1626947321;s:62:"/www/wwwroot/yaoxiaoka/application/pc/view/common/mheader.html";i:1614909815;s:62:"/www/wwwroot/yaoxiaoka/application/pc/view/common/mfooter.html";i:1620488383;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
    <title>账户概览 -要销卡-专注充值卡回收兑换_话费卡回收_游戏点卡回收_加油卡回收</title>
    <link rel="stylesheet" type="text/css" href="/public/wap/css/iconfont.css?v=20211" />
    <link rel="stylesheet" href="/public/wap/css/style_mobile.css?v=20211">
    <link rel="stylesheet" href="/public/layer/theme/default/layer.css?v=20211">
<!--    <link rel="stylesheet" href="//at.alicdn.com/t/font_1786378_3f9wkx8x2vp.css">-->
    <script src="/public/pc/js/jquery-3.4.1.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/public/layer/layer.js?v=20211" type="text/javascript" charset="utf-8"></script>
</head>
<body>
<link rel="stylesheet" type="text/css" href="/public/pc/css/swiper.min.css" />
<?php if($uinfo['id']): ?>
<div class="section1">
    <div class="user">
        <div class="user_icon"><img src="/public/wap/img/user_icon.png" alt=""><div class="tag">钻</div></div>
        <div class="user_inf">
            <div class="user_inf_1"><?php echo $uinfo['username']; ?></div>
            <div class="user_inf_2">账户安全<div class="safe_lv"><div class="safe_lv_show safe_lv_0"></div></div></div>
        </div>
        <!--        <a class="user_center" href="/user/invitation">邀请有礼</a>-->
        <div class="clear"></div>
    </div>
    <ul class="sell_list">
        <li><h3><?php echo !empty($data['t_jy_ds']['bishu'])?$data['t_jy_ds']['bishu']:0; ?>张</h3><p>今日待售</p></li>
        <li><h3><?php echo !empty($data['t_jy_cg']['bishu'])?$data['t_jy_cg']['bishu']:0; ?>张</h3><p>今日已售</p></li>
        <li><h3><?php echo !empty($data['t_jy_sb']['bishu'])?$data['t_jy_sb']['bishu']:0; ?>张</h3><p>今日失败</p></li>
    </ul>

    <div class="se1_card">
        <p class="se1_card_p"><img src="/public/wap/img/card_icon.png" alt="">账户余额 <span><?php echo $uinfo['zj_cash']; ?>元</span></p>
        <a href="/pc/Tixian/add_tx" class="se1_card_a">马上提现</a>
        <div class="se1_card_bg"><img src="/public/wap/img/se1_card_bg.png" height="56" alt=""></div>
    </div>
    <div class="yuan"></div>
</div>
<div class="se1_arc"></div>
<?php else: ?>
<div class="main_top">
    <div class="login_left">
        <img src="/public/wap/img/user_icon.png" alt="">您还未登录账号 <a href="/sign/in">登录/注册</a>
    </div>
    <a class="kf_right">
        <img src="/public/wap/img/kf_icon.png" alt="">
    </a>
</div>
<div class="main_banner">
    <div class="se1_left">
        <h1>灵活售卡,官方护航</h1><p>让闲置回归价值</p>
    </div>
    <div class="se1_right"><img src="/public/wap/img/se1_pic1.png" height="120" alt=""></div>
</div>
<?php endif; ?>
<div class="notice" style="margin: 20px auto">
    <img src="/public/wap/img/gg.png" alt="">
    <div class="swiper-container">
        <div class="swiper-wrapper" style="width: 85%;">
            <?php foreach($notice as $v): ?>
            <div class="swiper-slide" onclick="window.location.href='/ninfo/t/1/id/<?php echo $v['id']; ?>'"><p class="notice_p"><?php echo $v['title']; ?></p><span class="notice_span"><?php echo date('m-d',$v['pub_time']); ?> <img src="/public/wap/img/right_icon.png" style="vertical-align: middle" alt=""></span></div>
            <?php endforeach; ?>
        </div>
        <div style="position: absolute;width: 10%;right: 0px;top: 1px;">
            <a href="/notice" class="notice_more">更多<br>公告</a>
        </div>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="/public/wap/statics/dc.common.css?cv=1614425569.46a516a0">
<link rel="stylesheet" type="text/css" href="/public/wap/statics/dc.home-page.css?cv=1614425569.46a516a0">
<style type="text/css">
    ._3GSCwNQRJwIJZ58cybgYLW ._1IuUKlAGMrH1UXGdM1loCa ._1llDR_S4qcdLqGCY-veehm {
        margin-bottom: 1.2rem;
        height: 92px;
        background: none;
        margin-left: .6rem;
    }

    ._3GSCwNQRJwIJZ58cybgYLW ._3fjli6OU5bBO5wMUslOt_c ._2TcTCnWhzfeNsB8LpQM5pV {
        width: 4rem;
        height: 6rem;
        margin: .6rem;
    }
    ._3GSCwNQRJwIJZ58cybgYLW ._1IuUKlAGMrH1UXGdM1loCa ._1llDR_S4qcdLqGCY-veehm img {
        width: 100%;
        height: 72px;

    }
    .jaja_se2_bg1{
        color: #fff;
        margin: 0 auto 4px auto;
        background-image: linear-gradient(0deg,
        #f35c57 0%,
        #f88783 100%),
        linear-gradient(
                #05caae,
                #05caae) !important;
        background-blend-mode: normal,
        normal;
    }
    .jaja_se2_bg2{
        color: #fff;
        margin: 0 auto 4px auto;
        background-image: linear-gradient(0deg,
        #fcc93a 0%,
        #fcdd84 100%),
        linear-gradient(
                #05caae,
                #05caae) !important;;
        background-blend-mode: normal,
        normal;
    }
    .jaja_se2_bg3{
       
        color: #fff;
        margin: 0 auto 4px auto;
        
        background-image: linear-gradient(0deg,
        #05caae 0%,
        #2de6cc 100%),
        linear-gradient(
                #05caae,
                #05caae) !important;;
        background-blend-mode: normal,
        normal;
    }
    .jaja_se2_bg4{
        
        color: #fff;
        margin: 0 auto 4px auto;
        border-radius: 20px;
        background-image: linear-gradient(0deg,
        #ff985b 0%,
        #ffae7e 100%),
        linear-gradient(
                #05caae,
                #05caae) !important;;
        background-blend-mode: normal,
        normal;
    }
    .jaja_se2_bg5{
       
        color: #fff;
        margin: 0 auto 4px auto;
        border-radius: 20px;
        background-image: linear-gradient(0deg,
        #6198ff 0%,
        #85afff 100%),
        linear-gradient(
                #05caae,
                #05caae) !important;;
        background-blend-mode: normal,
        normal;
    }
    .jaja_se2_bg6{
        
        color: #fff;
        margin: 0 auto 4px auto;
        border-radius: 20px;
        background-image: linear-gradient(0deg,
        #6198ff 0%,
        #8c54ff 100%),
        linear-gradient(
                #05caae,
                #05caae) !important;;
        background-blend-mode: normal,
        normal;
    }
    ._3GSCwNQRJwIJZ58cybgYLW ._1IuUKlAGMrH1UXGdM1loCa {
        height: 315px;
        max-height: unset;
        padding-right: 1.5rem;
        margin-top: 0.44rem;
    }
</style>
<div class="section2" style="margin:0;">
    <div class="GVrv_-ojD5Q2QCfKhI5jm" style="position: unset;">
        <div class="_231ipfziOiE1KGBtx8t0mM">
            
            <section class="MEvhpqJsUzf5ML0TIC7Lx">
                <div class="_3GSCwNQRJwIJZ58cybgYLW">
                    <div class="_3fjli6OU5bBO5wMUslOt_c">
                        <div class="_2TcTCnWhzfeNsB8LpQM5pV _1rpAsy--1qc9_divhIv4W6" data-id="0">
                            <!-- <div class="SHA_z4ugAD8lQYQU372Rk"></div> -->
                            <span style="right: 49%;top: .2rem;font-size: 0.98rem;">我要销卡</span> 
                        </div>
                        <div class="_2TcTCnWhzfeNsB8LpQM5pV " data-id="1">
                            <!-- <div class=""></div> -->
                            <span style="right: 49%;top: .2rem;font-size: 0.98rem;">热门回收</span>
                        </div>
                        <div class="_2TcTCnWhzfeNsB8LpQM5pV" data-id="2">
                            <!-- <div class=""></div> -->
                            <span style="right: 49%;top: .2rem;font-size: 0.98rem;">更多服务</span>
                        </div>
                    </div>

                    <!-- 我要销卡 start -->

                    <div class="_1IuUKlAGMrH1UXGdM1loCa jaja_xiaoka_0">
                        
                        <div class="_1llDR_S4qcdLqGCY-veehm jaja_se2_bg1" onclick="jaja_url('/yk_card?tid=1')">
                            <i class="iconfont icon-smartphone-fill kl_icon_1" style="font-size: 60px;position: absolute;margin-top: 14px;margin-left: 5px">
                                <span style="font-size: 24px;margin-top: 16px;margin-left: 30px;position: absolute;width: 100px;">话费卡</span>
                            </i>
                        </div>
                        <div class="_1llDR_S4qcdLqGCY-veehm jaja_se2_bg2" onclick="jaja_url('/yk_card?tid=2')">
                            <i class="iconfont icon-gamepad-fill kl_icon_2" style="font-size: 60px;position: absolute;margin-top: 14px;margin-left: 12px">
                                <span style="font-size: 24px;margin-top: 16px;margin-left: 24px;position: absolute;width: 100px;">游戏卡</span>
                            </i>
                        </div>
                        <div class="_1llDR_S4qcdLqGCY-veehm jaja_se2_bg3" onclick="jaja_url('/yk_card?tid=3')">
                            <i class="iconfont icon-gas-station-fill kl_icon_3" style="font-size: 60px;position: absolute;margin-top: 14px;margin-left: 12px">
                                <span style="font-size: 24px;margin-top: 16px;margin-left: 24px;position: absolute;width: 100px;">加油卡</span>
                            </i>
                        </div>

                        <div class="_1llDR_S4qcdLqGCY-veehm jaja_se2_bg4" onclick="jaja_url('/yk_card?tid=4')">
                            <i class="iconfont icon-store--fill kl_icon_4" style="font-size: 60px;position: absolute;margin-top: 14px;margin-left: 12px">
                                <span style="font-size: 24px;margin-top: 16px;margin-left: 24px;position: absolute;width: 100px;">商超卡</span>
                            </i>
                        </div>
                        <div class="_1llDR_S4qcdLqGCY-veehm jaja_se2_bg5" onclick="jaja_url('/yk_card?tid=5')">
                            <i class="iconfont icon-shopping-cart-fill kl_icon_5" style="font-size: 60px;position: absolute;margin-top: 14px;margin-left: 12px">
                                <span style="font-size: 24px;margin-top: 16px;margin-left: 24px;position: absolute;width: 100px;">电商卡</span>
                            </i>
                        </div>
                        <div class="_1llDR_S4qcdLqGCY-veehm jaja_se2_bg6" onclick="jaja_url('/yk_card?tid=6')">
                            <i class="iconfont icon-movie--fill kl_icon_6" style="font-size: 60px;position: absolute;margin-top: 14px;margin-left: 12px">
                                <span style="font-size: 24px;margin-top: 16px;margin-left: 24px;position: absolute;width: 100px;">影视卡</span>
                            </i>
                        </div>
                        
                    </div>
                    <!-- 我要销卡 end -->

                    <!-- 热门回收 start -->
                    <div class="_1IuUKlAGMrH1UXGdM1loCa jaja_xiaoka_1" style="display: none;background: none">
                        <div class="_1llDR_S4qcdLqGCY-veehm " onclick="jaja_url('/yk_card?tid=1')">
                            <i style="background: url(/public/wap/statics/img/1.png)  no-repeat  100%;background-size: 50%;height: 72px;width: 264px;display: inline-block;background-position-x: 56px;background-position-y: 8px;"></i>
                        </div>
                        <div class="_1llDR_S4qcdLqGCY-veehm " onclick="jaja_url('/yk_card?tid=1')">
                            <i style="background: url(/public/wap/statics/img/2.png)  no-repeat  100%;background-size: 50%;height: 72px;width: 264px;display: inline-block;background-position-x: 56px;background-position-y: 17px;"></i>
                        </div>
                        <div class="_1llDR_S4qcdLqGCY-veehm " onclick="jaja_url('/yk_card?tid=1')">
                            <i style="background: url(/public/wap/statics/img/3.png)  no-repeat  100%;background-size: 50%;height: 72px;width: 264px;display: inline-block;background-position-x: 56px;background-position-y: -21px;"></i>
                        </div>
                        
                    </div>
                    <!-- 热门回收 end -->

                    <!-- 更多服务 start -->
                    <div class="_1IuUKlAGMrH1UXGdM1loCa jaja_xiaoka_2" style="display: none;">
                        <div class="_1llDR_S4qcdLqGCY-veehm ">
                            <i class="iconfont icon-download-cloud-fill" style="font-size: 60px;margin-top: 14px;position: absolute;margin-left: 13px;">
                                <span style="font-size: 16px;margin-top: 12px;position: absolute;width: 200px;">点卡寄售<br />移动端在线销卡</span>
                            </i>
                        </div>
                        <div class="_1llDR_S4qcdLqGCY-veehm ">
                            <i class="iconfont icon-building-fill" style="font-size: 60px;margin-top: 14px;position: absolute;margin-left: 13px;">
                                <span style="font-size: 16px;margin-top: 12px;position: absolute;width: 200px;">企业合作<br />极速资金回流</span>
                            </i>
                        </div>

                        <div class="_1llDR_S4qcdLqGCY-veehm ">
                            <i class="iconfont icon-question-fill" style="font-size: 60px;margin-top: 14px;position: absolute;margin-left: 13px;">
                                <span style="font-size: 16px;margin-top: 12px;position: absolute;width: 200px;">常见问题<br />有疑问，点我就对了</span>
                            </i>
                        </div>

                        <div class="_1llDR_S4qcdLqGCY-veehm ">
                            <i class="iconfont icon-chat-smile--fill" style="font-size: 60px;margin-top: 14px;position: absolute;margin-left: 13px;">
                                <span style="font-size: 16px;margin-top: 12px;position: absolute;width: 200px;">意见反馈<br />让我变得更好</span>
                            </i>
                        </div>
                    </div>
                    <!-- 更多服务 end -->

                </div>

                <script type="text/javascript">
                    $(function(){
                        $('._3fjli6OU5bBO5wMUslOt_c div').click(function(){
                            let _index = $(this).data('id');
                            console.log(_index)
                            $(this).addClass('_1rpAsy--1qc9_divhIv4W6').siblings().removeClass('_1rpAsy--1qc9_divhIv4W6');
                            $('._1IuUKlAGMrH1UXGdM1loCa').hide();
                            $('.jaja_xiaoka_' + _index).show();
                        })
                    })

                    function jaja_url(url){
                        
                        <?php if(\think\Session::get('uid')): ?>
                            location.href = url;
                        <?php else: ?>
                            location.href = '/sign/in';
                        <?php endif; ?>
                      
                    }
                </script>
            </section>
        </div>
    </div>
    <div class="clear"></div>
</div>
<div class="f_line"></div>
<!-- 常见问题 -->
<div class="section5" style="height: auto;">
    <h3 class="title_h1">常见问题</h3>
    <a class="title_span pull-right" href="/question">更多</a>
    <div style="height: 10px;"></div>
    <?php foreach($question as $v): ?>
        <p style="height: 25px;line-height: 25px;font-size: 14px;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;width: 80%;float: left;">
            <a href="/ninfo/t/2/id/<?php echo $v['id']; ?>"  style="color: #303753"  title="<?php echo $v['title']; ?>"><?php echo $v['title']; ?></a>
        </p>
        <span style="height: 25px;line-height: 25px;font-size: 14px;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;width: 13%;float: right;" class="news_time"><?php echo date('m-d',$v['pub_time']); ?></span>
    <?php endforeach; ?>
</div>

<div class="clear"></div>
<div class="f_line"></div>
<!-- 常见问题 -->
<div class="section5" style="height: auto;">
    <h3 class="title_h1">行业资讯</h3>
    <a class="title_span pull-right" href="/article">更多</a>
    <div style="height: 10px;"></div>
    <?php foreach($article as $v): ?>
        <p style="height: 25px;line-height: 25px;font-size: 14px;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;width: 80%;float: left;">
            <a href="/ninfo/t/3/id/<?php echo $v['id']; ?>" style="color: #303753" title="<?php echo $v['title']; ?>"><?php echo $v['title']; ?></a>
        </p>
        <span style="height: 25px;line-height: 25px;font-size: 14px;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;width: 13%;float: right;" class="news_time"><?php echo date('m-d',$v['pub_time']); ?></span>
    <?php endforeach; ?>
</div>

<div class="clear"></div>
<div class="f_line"></div>
<div class="f_line"></div>
<div class="section5" style="height: auto;"> <!--  style="height: 150px" -->
    <h3>咨询QQ：1828847938</h3>
    <h3>联系电话：400-075-5998</h3>
    <a  onclick="layer.open({
            type: 1,
            title: '官网客服QQ',
            shadeClose: true,
            area: ['100%', '100px'],
            shade: 0.8,
            content: '<br/>&nbsp;&nbsp;&nbsp;1828847938',})"><img src="/public/wap/img/kf_icon.png" alt=""> 在线客服</a>
   
    <h3>在线时间：09:00 - 23:00</h3>
   
</div>
<div class="section5" style="margin-bottom: 200px"> 

<p><a target="cyxyv" href="https://v.yunaq.com/certificate?domain=www.1xiaoka.com&from=label&code=90030"> <img src="https://aqyzmedia.yunaq.com/labels/label_sm_90030.png"></a></p>
	<br>
<p>
    <a target="_blank" href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=44030402004298">&nbsp;&nbsp;粤公网安备：44030402004298号</a> <br /><br />
    &nbsp;&nbsp;<a target="_blank" href="https://beian.miit.gov.cn/#/Integrated/index">ICP证&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;：粤ICP备2020113587号</a>
    
</p>
<p style="margin-top: 20px;line-height: 19px;">
    <a href="http://1xiaoka.com/sitemap.html">要销卡平台-提供充值卡回收|点卡回收</a>，
    <a href="http://1xiaoka.com/sitemap.html">充值卡兑换|点卡兑换，</a>
    <a href="http://1xiaoka.com/sitemap.html">充值卡/点卡寄售，充值卡/点卡api接口，充值卡/点卡回收平台</a>
</p>
</div>
<!--遮罩-->
<input type="hidden" value="<?php echo $is_truename; ?>" id="is_truename">
<div class="mask">
    <!--  认证提示弹窗  -->
    <div class="modal real_name_modal">
        <div class="close"></div>
        <div class="real"><img src="/public/pc/images/real.png" height="180" alt=""></div>
        <p class="real_name_modal_p1">为保障您的合法权益，请签署承诺书</p>
        <p class="real_name_modal_p2">为有效保障您的合法权益和正常合法经营，需实名认证并签署承诺书，才能使用点卡回收服务及提现操作，请您仔细阅读并签署！</p>
        <div class="smrz_list">
            <div class="tip4">请输入与您支付宝一致的姓名和身份证号</div>
            <div class="add_input" style="margin-top: 5px"><input type="text" name="real_name" placeholder="请输入真实姓名"></div>
            <div class="add_input"><input type="text" name="id_card" placeholder="请输入身份证号"></div>
            <button class="add_btn zfb_rz" id="signBtn" onclick="getSignUrl()">立即去签署</button>
        </div>
    </div>
    <!--  支付宝扫码弹窗  --> 
<!--    <div class="modal sm_modal">-->
<!--        <div class="close"></div>-->
<!--        <div class="title_icon"><img src="/v2020/img/acc_icon6.png" alt=""></div>-->
<!--        <div class="title_txt"><h3>用户承诺书</h3><p>为有效保障您的合法权益，请及时签署</p></div>-->
<!--        <div class="clear"></div>-->
<!--        <div class="sm_bg">-->
<!--            <img id="sign_img" src="" height="120" alt="">-->
<!--            <p><span class="blue">请长按二维码</span>-->
<!--                <br>识别途中二维码并完成签署</p>-->
<!--        </div>-->
<!--        <div class="clear"></div>-->
<!--    </div>-->
</div>
<script src="/public/pc/js/swiper.min.js" type="text/javascript" charset="utf-8"></script>
<script>
    $(function () {
        // 未实名
        // $('.mask').show();
        // setTimeout(function () {
        //     $('.real_name_modal').addClass('modal_show');
        // }, 100);//{if $uinfo.id}
        var uid="<?php echo $uinfo['id']; ?>";
        if($('#is_truename').val()!=1 && uid>0){
            layer.open({
                type: 2,
                title: '实名认证',
                shadeClose: true,
                area: ['90%', '90%'],
                shade: 0.8,
                content: '/pc/User/auth_name',
            });
            // layer.msg('您的账户未实名认证，即将跳转至实名认证...',{icon:5 ,time:3000},function () {
            //     window.location.href='/pc/User/auth_name';
            // });
            return;
        }
    });

    /**
     * 显示红色的border外边框
     * @param element_id
     */
    function showErrorBorder(element_id) {
        $(element_id).focus();
        $(element_id).css("border-color","#ff6d5a");
        $(element_id).css("box-shadow","0 0 15px rgba(255, 109, 90, 0.35)");
    }
</script>
<!--标签栏开始-->
<div class="tab_bar_bottom"></div>
<div class="tab_bar_nav">
    <!--active为当前页面选中效果-->
    <a href="/" class="active"><i class="iconfont icon-home-smile-line"></i>首页</a>
    <a href="/pc/user/orders" ><i class="iconfont icon-file-list--fill"></i>订单</a>
    <?php if(\think\Session::get('uid')): ?>
        
        <a href="/yk_card"><span class="home_btn"><i class="iconfont icon-maichu"></i></span></a>
    <?php else: ?>
        <a href="/sign/in"><span class="home_btn"><i class="iconfont icon-maichu"></i></span></a>
    <?php endif; ?>
    
    <a href="/pc/Tixian/add_tx" ><i class="iconfont icon-money-cny-circle-fill"></i>提现</a>
    <a href="/user/profile" ><i class="iconfont icon-user--fill"></i>我的</a>
</div>



<!--底部弹层开始-->
<link rel="stylesheet" href="//at.alicdn.com/t/font_1786378_02usjpdi4hev.css">
<div class="shadow"></div>
<script>
    // $('.kf_right').click(function () {
    //     $('.shadow').show();
    //     $('.kf_show_modal').show();
    // });
    $('.close_btn,.shadow').click(function () {
        $('.shell_show').hide();
        $('.shadow').hide();
    });
</script>
<!--底部弹层结束-->
<script>
    var mySwiper = new Swiper('.swiper-container', {
        autoplay: true,
        direction : 'vertical',
        loop : true,
        height: 300,
    })
    $('.close').click(function () {
        $('.mask').hide();
        $('.modal').removeClass('modal_show');
    });
</script>
</body>
</html>
<div class="shadow"></div>
<div class="shell_show kf_show_modal animated slideInUp">
    <div class="shell_show_head">请选择官网客服</div>
    <span class="close_btn"><img src="/public/wap/img/close_icon2.png" alt=""></span>
    <div class="shell_show_kl">
        <ul>
            <li onclick="layer.open({
            type: 1,
            title: '官网客服QQ',
            shadeClose: true,
            area: ['100%', '100px'],
            shade: 0.8,
            content: '<br/>&nbsp;&nbsp;&nbsp;1828847938',})"><i class="iconfont icon-message--line"></i>在线客服咨询<span class="shell_show_kl_right"><img src="/public/wap/img/right_icon.png" alt=""></span></li>
            <li onclick="window.location='tel:400-075-5998'"><i class="iconfont icon-phone-line"></i>在线客服电话<span class="shell_show_kl_right"><img src="/public/wap/img/right_icon.png" alt=""></span></li>
            <li onclick="window.location='/'"><i class="iconfont icon-home-smile-line"></i>返回点卡首页<span class="shell_show_kl_right"><img src="/public/wap/img/right_icon.png" alt=""></span></li>
        </ul>
    </div>
</div>
<script>
    $('.kf_right').click(function () {
        $('.shadow').show();
        $('.kf_show_modal').show();
    });
    $('.close_btn,.shadow').click(function () {
        $('.shell_show').hide();
        $('.shadow').hide();
    });
    // $('.kf_right').click(function () {
    //     // window.location.href='mqqwpa://im/chat?chat_type=wpa&uin=169632957&version=1&src_type=web&web_src=oicqzone.com';
    //     window.location.href='mqqwpa://im/chat?chat_type=wpa&uin=169632957&version=1&src_type=web&web_src=';
    // })
    var pos = function (event) {  //鼠标定位赋值函数
        var posX = 0, posY = 0;  //临时变量值
        var e = event || window.event;  //标准化事件对象
        if (e.pageX || e.pageY) {  //获取鼠标指针的当前坐标值
            posX = e.pageX;
            posY = e.pageY;
        } else if (e.clientX || e.clientY) {
            posX = event.clientX + document.documentElement.scrollLeft + document.body.scrollLeft;
            posY = event.clientY + document.documentElement.scrollTop + document.body.scrollTop;
        }
        sessionStorage.setItem("cookieLogin", posX.toString()+posY.toString());
        var d = new Date();
        sessionStorage.setItem("passTime", d.getTime());
       
    }

    // var div1 = document.getElementById("div1");
    document.onmousemove = function () {
        // pos();
    }
    
    function saveCookie(){
        let _cookieLogin = sessionStorage.getItem("cookieLogin");
        
        let _passTime = sessionStorage.getItem("passTime");

        let _d = new Date();
        let _now = _d.getTime();
        var _uuid = "<?php echo $_SESSION['think']['uid']; ?>";

        let _time = parseInt(_now) - parseInt(_passTime);
        console.log(_time)
        if(_time >= 30*1000*60){
            $.get('/pc/index/onlineCount',{uid:_uuid},function(res){
                console.log(res);
            },'json');
        }else{
            $.get('/pc/index/onlineCount',{uid:_uuid,redis_time:'yxk'},function(res){
                console.log(res);
            },'json');
        }
        
    }
    var _uuid = "<?php echo $_SESSION['think']['uid']; ?>";
    if(_uuid > 0 ){
       setInterval(saveCookie, 10000); 
    }
    $("body").on("click", function(e) {
        pos();
    });
</script>
