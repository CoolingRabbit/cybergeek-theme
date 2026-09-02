<?php
/**
 * CyberGeek v2 MAX Theme Header - 硬件极客桌面 · 极繁炫技版
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php $this->archiveTitle(array(
        'category'  =>  _t('分类 %s 下的文章'),
        'search'    =>  _t('包含关键字 %s 的文章'),
        'tag'       =>  _t('标签 %s 下的文章'),
        'author'    =>  _t('%s 发布的文章')
    ), '', ' - '); ?><?php $this->options->title(); ?></title>
    <meta name="description" content="<?php $this->options->description(); ?>">
    <!-- 字体直接使用系统栈（见 style.css --font-sans / --font-mono），不加载远程字体，避免大陆环境首屏渲染阻塞 -->
    <link rel="stylesheet" href="<?php $this->options->themeUrl('style.css'); ?>?v=<?php echo cgAssetVer('style.css'); ?>">
    <?php $this->header(); ?>
</head>
<body>
    <?php $cgIsHome = $this->is('index'); ?>
    <!-- CRT 开机动画：首页首次播放完整 boot，其它页面仅快速亮线闪入（JS 决定加哪个类） -->
    <div class="boot-overlay" id="bootOverlay" aria-hidden="true" data-home="<?php echo $cgIsHome ? '1' : '0'; ?>">
        <div class="boot-line"></div>
        <div class="boot-text">CYBERGEEK SYS // POWER ON</div>
    </div>
    <script>
    (function() {
        var overlay = document.getElementById('bootOverlay');
        if (!overlay) return;
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
        var isHome = overlay.getAttribute('data-home') === '1';
        var booted = false;
        try { booted = sessionStorage.getItem('cg_booted') === '1'; } catch (e) {}
        if (isHome && !booted) {
            overlay.classList.add('boot-play');
            try { sessionStorage.setItem('cg_booted', '1'); } catch (e) {}
        } else {
            // 其它页面 / 同会话回首页：仅 0.5s 快速亮线闪入
            overlay.classList.add('boot-quick');
        }
    })();
    </script>

    <!-- 整页 CRT：扫描线 + 曲面暗角直接作用于全屏 -->
    <div class="crt-global-scanlines" aria-hidden="true"></div>
    <div class="crt-global-vignette" aria-hidden="true"></div>
    <!-- 角落拟物小件：品牌铭牌 + 电源灯 -->
    <div class="crt-page-brand" aria-hidden="true">CyberGeek // Model KJ-2026</div>
    <div class="crt-page-led" aria-hidden="true"></div>

    <!-- LED 状态栏式阅读进度条 -->
    <div class="led-progress"><div class="led-progress-bar" id="ledProgressBar"></div></div>

    <nav class="site-nav" id="siteNav">
        <div class="nav-container">
            <button class="menu-toggle" id="menuToggle" aria-label="切换菜单">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <!-- 站点标识：终端提示符 + 闪烁光标；logoText 留空时回退站点标题 -->
            <a href="<?php $this->options->siteUrl(); ?>" class="nav-brand"><span class="prompt">&gt;</span><?php $cgLogoText = $this->options->logoText; echo htmlspecialchars(!empty($cgLogoText) ? $cgLogoText : $this->options->title); ?></a>

            <ul class="nav-menu" id="navMenu">
                <li><a href="<?php $this->options->siteUrl(); ?>" data-scramble>首页</a></li>
                <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
                <?php while($pages->next()): ?>
                <li><a href="<?php $pages->permalink(); ?>" data-scramble><?php $pages->title(); ?></a></li>
                <?php endwhile; ?>
            </ul>

            <div class="nav-actions">
                <?php if (isUserLoggedIn()): ?>
                    <a href="<?php $this->options->siteUrl(); ?>admin/index.php" class="nav-btn nav-btn-primary">后台</a>
                <?php else: ?>
                    <a href="<?php $this->options->siteUrl(); ?>admin/login.php" class="nav-btn">登录</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <main class="site-main">
