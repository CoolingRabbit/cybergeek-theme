<?php
/**
 * CyberGeek Theme Header - Geek Style + Warm Colors
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
    <link rel="stylesheet" href="<?php $this->options->themeUrl('style.css'); ?>?v=20250618">
    <?php $this->header(); ?>
</head>
<body>
    <nav class="site-nav" id="siteNav">
        <div class="nav-container">
            <button class="menu-toggle" id="menuToggle" aria-label="切换菜单">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <ul class="nav-menu" id="navMenu">
                <li><a href="<?php $this->options->siteUrl(); ?>">首页</a></li>
                <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
                <?php while($pages->next()): ?>
                <li><a href="<?php $pages->permalink(); ?>"><?php $pages->title(); ?></a></li>
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
