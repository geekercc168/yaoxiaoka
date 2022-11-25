<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;

Route::domain('dazhanhongtu.1xiaoka.com', function () {
    Route::rule('/admin/index/verify', 'admin/index/verify');
    Route::rule('/kjt_notify', 'admin/index/kjt_notify');//后台打款kjt支付回调
    Route::rule('/dazhang', 'admin/Finance/budan');
    Route::rule('/yinglitongji_auto', 'admin/index/yinglitongji_auto');
    Route::rule('all$', 'pc/index/index');
    Route::rule('/', 'pc/index/index');
    Route::rule('/bulou', 'pc/card/bulou');//主动轮询提交渠道
    //管理后台
    Route::rule('/zdcx_hst', 'pc/card/zdcx_hst');//主动查询-汇速通
    Route::rule('/zdcx_sxk', 'pc/card/zdcx_sxk');
    Route::rule('/zdcx_sup', 'pc/card/zdcx_sup');
    Route::rule('/zdcx_xm', 'pc/card/zdcx_xm');
    Route::rule('/zdcx_xkl', 'pc/card/zdcx_xkl');
});

Route::domain('1xiaoka.com', function () {
    //总后台 //动态注册域名的路由规则
    Route::rule('/admin', 'pc/index');//该域名重置，避免后台暴露
    Route::rule('/admin/index/verify', 'admin/index/verify');
    Route::rule('/kjt_notify', 'admin/index/kjt_notify');//后台打款要销卡的kjt支付回调
    Route::rule('/kjt_jjf', 'admin/index/kjt_jjf');//后台打款集集付的kjt支付回调
    Route::rule('/budan', 'admin/Finance/budan');
    Route::rule('/yinglitongji_auto', 'admin/index/yinglitongji_auto');
    Route::rule('all$', 'pc/index/index');
    Route::rule('/', 'pc/index/index');
    Route::rule('/help/gzh', 'pc/help/gzh');
    Route::rule('/yk_card', 'pc/card/index');
    Route::rule('/sign/in', 'pc/sign/in');
    Route::rule('/sign/up', 'pc/sign/up');
    Route::rule('/sign/out', 'pc/sign/out');
    Route::rule('/passwd', 'pc/sign/passwd');
    Route::rule('/user', 'pc/user/index');//用户后台首页
    Route::rule('/user/profile', 'pc/user/profile');//移动端个人中心
    Route::rule('/cardinfo', 'pc/card/cardinfo');//卡类型
    Route::rule('/cardval', 'pc/card/cardval');//卡品牌
    Route::rule('/bulou', 'pc/card/bulou');//主动轮询提交渠道
    Route::rule('/notice', 'pc/help/notice_list');//公告列表
    Route::rule('/question', 'pc/help/question_list');//问题列表
    Route::rule('/ninfo', 'pc/help/notice_info');//公告，新闻，问题详情
    Route::rule('/article', 'pc/help/article_list');
    Route::rule('/about/service', 'pc/about/service');//服务协议
    Route::rule('/about/protocol', 'pc/about/protocol');//转让协议
    Route::rule('/about/ze', 'pc/about/ze');//免责申明
    Route::rule('/about/privacy', 'pc/about/privacy');//隐私政策
    Route::rule('/help/api', 'pc/help/api');//api接口咨询
    Route::rule('/company', 'pc/help/company');//企业合作
    Route::rule('/me', 'pc/about/me');//公司简介
    //管理后台
    Route::rule('/zdcx_hst', 'pc/card/zdcx_hst');//主动查询-汇速通
    Route::rule('/zdcx_sxk', 'pc/card/zdcx_sxk');
    Route::rule('/zdcx_sup', 'pc/card/zdcx_sup');
    Route::rule('/zdcx_xm', 'pc/card/zdcx_xm');
    Route::rule('/zdcx_xkl', 'pc/card/zdcx_xkl');
});
Route::domain('www.1xiaoka.com', function () {
    //总后台 //动态注册域名的路由规则
    Route::rule('/admin', '/');//该域名重置
    Route::rule('/admin/index/verify', 'admin/index/verify');
    Route::rule('/kjt_notify', 'admin/index/kjt_notify');//后台打款要销卡的kjt支付回调
    Route::rule('/kjt_jjf', 'admin/index/kjt_jjf');//后台打款集集付的kjt支付回调
    Route::rule('/budan', 'admin/Finance/budan');
    Route::rule('/yinglitongji_auto', 'admin/index/yinglitongji_auto');
    Route::rule('all$', 'pc/index/index');
    Route::rule('/', 'pc/index/index');
    Route::rule('/help/gzh', 'pc/help/gzh');
    Route::rule('/yk_card', 'pc/card/index');
    Route::rule('/sign/in', 'pc/sign/in');
    Route::rule('/sign/up', 'pc/sign/up');
    Route::rule('/sign/out', 'pc/sign/out');
    Route::rule('/passwd', 'pc/sign/passwd');
    Route::rule('/user', 'pc/user/index');//用户后台首页
    Route::rule('/user/profile', 'pc/user/profile');//移动端个人中心
    Route::rule('/cardinfo', 'pc/card/cardinfo');//卡类型
    Route::rule('/cardval', 'pc/card/cardval');//卡品牌
    Route::rule('/bulou', 'pc/card/bulou');//主动轮询提交渠道
    Route::rule('/notice', 'pc/help/notice_list');//公告列表
    Route::rule('/question', 'pc/help/question_list');//问题列表
    Route::rule('/ninfo', 'pc/help/notice_info');//公告，新闻，问题详情
    Route::rule('/article', 'pc/help/article_list');
    Route::rule('/about/service', 'pc/about/service');//服务协议
    Route::rule('/about/protocol', 'pc/about/protocol');//转让协议
    Route::rule('/about/ze', 'pc/about/ze');//免责申明
    Route::rule('/about/privacy', 'pc/about/privacy');//隐私政策
    Route::rule('/help/api', 'pc/help/api');//api接口咨询
    Route::rule('/company', 'pc/help/company');//企业合作
    Route::rule('/me', 'pc/about/me');//公司简介
    //管理后台
    Route::rule('/zdcx_hst', 'pc/card/zdcx_hst');//主动查询-汇速通
    Route::rule('/zdcx_sxk', 'pc/card/zdcx_sxk');
    Route::rule('/zdcx_sup', 'pc/card/zdcx_sup');
    Route::rule('/zdcx_xm', 'pc/card/zdcx_xm');
    Route::rule('/zdcx_xkl', 'pc/card/zdcx_xkl');
});
Route::domain('api888.1xiaoka.com', function () {
    Route::rule('/cardTypeQuery', 'api/card/card_type_query');
    Route::rule('/cardRateQuery', 'api/card/card_rate_query');
    Route::rule('/cardOrderCreate', 'api/card/card_order_create');
    Route::rule('/cardOrderQuery', 'api/card/card_order_query');
    Route::rule('/kjt_notify', 'admin/index/kjt_notify');//后台打款要销卡的kjt支付回调
});

Route::domain('1xiaoka.cn', function () {
    //总后台 //动态注册域名的路由规则
    Route::rule('/admin', 'pc/index');//该域名重置，避免后台暴露
    Route::rule('/admin/index/verify', 'admin/index/verify');
    Route::rule('/kjt_notify', 'admin/index/kjt_notify');//后台打款要销卡的kjt支付回调
    Route::rule('/kjt_jjf', 'admin/index/kjt_jjf');//后台打款集集付的kjt支付回调
    Route::rule('/budan', 'admin/Finance/budan');
    Route::rule('/yinglitongji_auto', 'admin/index/yinglitongji_auto');
    Route::rule('all$', 'pc/index/index');
    Route::rule('/', 'pc/index/index');
    Route::rule('/help/gzh', 'pc/help/gzh');
    Route::rule('/yk_card', 'pc/card/index');
    Route::rule('/sign/in', 'pc/sign/in');
    Route::rule('/sign/up', 'pc/sign/up');
    Route::rule('/sign/out', 'pc/sign/out');
    Route::rule('/passwd', 'pc/sign/passwd');
    Route::rule('/user', 'pc/user/index');//用户后台首页
    Route::rule('/user/profile', 'pc/user/profile');//移动端个人中心
    Route::rule('/cardinfo', 'pc/card/cardinfo');//卡类型
    Route::rule('/cardval', 'pc/card/cardval');//卡品牌
    Route::rule('/bulou', 'pc/card/bulou');//主动轮询提交渠道
    Route::rule('/notice', 'pc/help/notice_list');//公告列表
    Route::rule('/question', 'pc/help/question_list');//问题列表
    Route::rule('/ninfo', 'pc/help/notice_info');//公告，新闻，问题详情
    Route::rule('/article', 'pc/help/article_list');
    Route::rule('/about/service', 'pc/about/service');//服务协议
    Route::rule('/about/protocol', 'pc/about/protocol');//转让协议
    Route::rule('/about/ze', 'pc/about/ze');//免责申明
    Route::rule('/about/privacy', 'pc/about/privacy');//隐私政策
    Route::rule('/help/api', 'pc/help/api');//api接口咨询
    Route::rule('/company', 'pc/help/company');//企业合作
    Route::rule('/me', 'pc/about/me');//公司简介
    //管理后台
    Route::rule('/zdcx_hst', 'pc/card/zdcx_hst');//主动查询-汇速通
    Route::rule('/zdcx_sxk', 'pc/card/zdcx_sxk');
    Route::rule('/zdcx_sup', 'pc/card/zdcx_sup');
    Route::rule('/zdcx_xm', 'pc/card/zdcx_xm');
    Route::rule('/zdcx_xkl', 'pc/card/zdcx_xkl');
});
Route::domain('www.1xiaoka.cn', function () {
    //总后台 //动态注册域名的路由规则
    Route::rule('/admin', '/');//该域名重置
    Route::rule('/admin/index/verify', 'admin/index/verify');
    Route::rule('/kjt_notify', 'admin/index/kjt_notify');//后台打款要销卡的kjt支付回调
    Route::rule('/kjt_jjf', 'admin/index/kjt_jjf');//后台打款集集付的kjt支付回调
    Route::rule('/budan', 'admin/Finance/budan');
    Route::rule('/yinglitongji_auto', 'admin/index/yinglitongji_auto');
    Route::rule('all$', 'pc/index/index');
    Route::rule('/', 'pc/index/index');
    Route::rule('/help/gzh', 'pc/help/gzh');
    Route::rule('/yk_card', 'pc/card/index');
    Route::rule('/sign/in', 'pc/sign/in');
    Route::rule('/sign/up', 'pc/sign/up');
    Route::rule('/sign/out', 'pc/sign/out');
    Route::rule('/passwd', 'pc/sign/passwd');
    Route::rule('/user', 'pc/user/index');//用户后台首页
    Route::rule('/user/profile', 'pc/user/profile');//移动端个人中心
    Route::rule('/cardinfo', 'pc/card/cardinfo');//卡类型
    Route::rule('/cardval', 'pc/card/cardval');//卡品牌
    Route::rule('/bulou', 'pc/card/bulou');//主动轮询提交渠道
    Route::rule('/notice', 'pc/help/notice_list');//公告列表
    Route::rule('/question', 'pc/help/question_list');//问题列表
    Route::rule('/ninfo', 'pc/help/notice_info');//公告，新闻，问题详情
    Route::rule('/article', 'pc/help/article_list');
    Route::rule('/about/service', 'pc/about/service');//服务协议
    Route::rule('/about/protocol', 'pc/about/protocol');//转让协议
    Route::rule('/about/ze', 'pc/about/ze');//免责申明
    Route::rule('/about/privacy', 'pc/about/privacy');//隐私政策
    Route::rule('/help/api', 'pc/help/api');//api接口咨询
    Route::rule('/company', 'pc/help/company');//企业合作
    Route::rule('/me', 'pc/about/me');//公司简介
    //管理后台
    Route::rule('/zdcx_hst', 'pc/card/zdcx_hst');//主动查询-汇速通
    Route::rule('/zdcx_sxk', 'pc/card/zdcx_sxk');
    Route::rule('/zdcx_sup', 'pc/card/zdcx_sup');
    Route::rule('/zdcx_xm', 'pc/card/zdcx_xm');
    Route::rule('/zdcx_xkl', 'pc/card/zdcx_xkl');
});
