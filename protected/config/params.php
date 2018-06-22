<?php
/**
 * 参数配置文件
 *
 * @author tivon
 * @date 2015-09-07
 */
return array(
    'cookieprefix' => 'house_',

    //css\js等静态资源路径
    'adminStaticPath' => '/static/admin/',
    'vipStaticPath' => '/static/vip/',
    'wapStaticPath' => '/static/wap/',
    'globalStaticPath' => '/static/global/',

    //总后台API
    'logApi' => 'api/log/',                     //日志api
    'bbsLoginApi' => 'api/bbs/login',           //前台登录
    'bbsGetuserinfoApi' => 'api/bbs/getuserinfo',           //前台登录
    'bbsLogoutApi' => 'api/bbs/logout',         //前台登录
    'smsApi' => 'api/mobile/sendMessage',       //短信发送接口
    'siteConfigApi' => array(                   //全站配置接口
        'list' => 'api/siteConfig/list/',
        'view' => 'api/siteConfig/view/',
        'create' => '',
        'update' => '',
        'delete' => '',
    ),
    'userApi' => array(                     //用户信息接口
        'list' => 'api/user/list/',
        'view' => 'api/user/view/',
        'create' => '',
        'update' => '',
        'delete' => '',
    ),
    //信息来源(包括resoldzf,resoldesf)
    'source' => array(
        '1' => '个人',
        '2' => '中介',
        '3' => '后台'
    ),
    //审核状态(二手房和租房共用)
    'checkStatus' => [
        '0' => '未审核',
        '1' => '正常',
        '2' => '审核中',
        '3' => '未通过'
    ],
    //销售状态(二手房和租房共用)
    'saleStatus' => [
        '1' => '上架',
        '2' => '下架',
        '3' => '回收'
    ],
    //电话确认
    'contacted' => [
        '0' => '否',
        '1' => '是'
    ],
    //房源分类
    'category' => [
        1 => '住房',
        2 => '商铺',
        3 => '写字楼'
    ],
    //房源分类
    'categoryPinyin' => [
        1 => 'zhuzhai',
        2 => 'shangpu',
        3 => 'xiezilou'
    ],
    //二手房求购状态
    'qgStatus' => [
        '0' => '未审核',
        '1' => '正常',
        '2' => '审核中',
        '3' => '未通过'
    ],
    //二手房求购状态
    'qzStatus' => [
        '0' => '未审核',
        '1' => '正常',
        '2' => '审核中',
        '3' => '未通过'
    ],
    //店铺状态
    'shopStatus' => [
        0 => '未审核',
        1 => '正常',
        2 => '禁用',
    ],
    //求租期望户型
    'qiuzufangtype' => [
        1 => '一居',
        2 => '二居',
        3 => '三居',
        4 => '四居',
        5 => '五居',
        6 => '五居以上'
    ],
    //房源举报处理状态
    'deal' => [
        0 => '未处理',
        1 => '已处理'
    ],
    //举报的房源类型
    'report_type' => [
        1 => '二手房',
        2 => '租房',
    ],
    //举报的链接
    'report_url' => [
        1 => '/resoldhome/esf/info',
        2 => '/resoldhome/zf/info',
    ],
    //判断二手房租房
    'esf_or_zf' => [
        1=> '二手房',
        2=>'租房'
    ],
    // 新房知识库标签分类
    'baikeTagCate'=> [
        0 => '新房',
        1 => '二手房',
        2 => '租房'
    ],
    
);