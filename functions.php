<?php
/**
 * CyberGeek Theme Functions - Retro Newspaper Edition
 * Typecho 1.3.0 Compatible
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;

/**
 * 主题初始化
 */
function themeConfig($form) {
    $logoText = new \Typecho\Widget\Helper\Form\Element\Text('logoText', NULL, '散热野兔', _t('站点 Logo 文字'), _t('显示在导航栏左侧'));
    $form->addInput($logoText);

    $heroTitle = new \Typecho\Widget\Helper\Form\Element\Text('heroTitle', NULL, '散热野兔', _t('Hero 区域大标题'));
    $form->addInput($heroTitle);

    $beian = new \Typecho\Widget\Helper\Form\Element\Text('beian', NULL, '沪ICP备2026023383号', _t('备案号'));
    $form->addInput($beian);
}

/**
 * 判断用户是否已登录
 * @return bool
 */
function isUserLoggedIn() {
    return Typecho_Widget::widget('Widget_User')->hasLogin();
}

/**
 * 获取当前用户名称
 * @return string
 */
function getCurrentUserName() {
    if (isUserLoggedIn()) {
        return Typecho_Widget::widget('Widget_User')->screenName;
    }
    return '';
}

/**
 * 获取文章摘要
 * @param Widget_Archive $archive
 * @param int $length 字数限制
 * @return string
 */
function getExcerpt($archive, $length = 120) {
    // Always use content to build excerpt, avoiding pre-generated excerpt with HTML
    $content = $archive->content;
    if (empty($content)) {
        $content = $archive->excerpt;
    }
    // Decode HTML entities first (e.g. &lt;h2&gt; -> <h2>)
    $content = html_entity_decode($content, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    // Strip all HTML tags
    $content = strip_tags($content);
    // Remove any remaining tag-like patterns as fallback
    $content = preg_replace('/<[^>]*>/', '', $content);
    // Normalize whitespace
    $content = preg_replace('/\s+/', ' ', $content);
    $content = trim($content);
    if (mb_strlen($content, 'UTF-8') > $length) {
        $content = mb_substr($content, 0, $length, 'UTF-8') . '...';
    }
    return $content;
}

/**
 * 获取文章首张图片
 * @param Widget_Archive $archive
 * @return string|null
 */
function getThumbnail($archive) {
    $content = $archive->content;
    preg_match_all('/<img[^>]+src="([^"]+)"/', $content, $matches);
    if (!empty($matches[1][0])) {
        return $matches[1][0];
    }
    return null;
}

/**
 * 获取分类颜色标识
 * @param string $slug
 * @return string
 */
function getCategoryColor($slug) {
    $colors = array(
        'tech' => 'tech',
        'technology' => 'tech',
        'code' => 'tech',
        'life' => 'life',
        'daily' => 'life',
        '随笔' => 'life',
    );
    return isset($colors[$slug]) ? $colors[$slug] : 'default';
}
