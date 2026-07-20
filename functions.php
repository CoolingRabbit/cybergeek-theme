<?php
/**
 * CyberGeek v2 Theme Functions
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
    $content = $archive->content;
    if (empty($content)) {
        $content = $archive->excerpt;
    }
    // 先解码 HTML 实体，再去标签，避免摘要中出现残留标记
    $content = html_entity_decode($content, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $content = strip_tags($content);
    $content = preg_replace('/<[^>]*>/', '', $content);
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
 * 估算阅读时长（v2 新增）
 * 中文约 400 字/分钟，英文按词数折算约 200 词/分钟
 * @param Widget_Archive $archive
 * @return string
 */
function getReadingTime($archive) {
    $content = html_entity_decode($archive->content, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $content = strip_tags($content);

    // 统计中日韩字符数
    preg_match_all('/[\x{4E00}-\x{9FFF}\x{3040}-\x{30FF}\x{AC00}-\x{D7AF}]/u', $content, $cjk);
    $cjkCount = count($cjk[0]);

    // 统计英文单词数
    $plain = preg_replace('/[\x{4E00}-\x{9FFF}\x{3040}-\x{30FF}\x{AC00}-\x{D7AF}]/u', ' ', $content);
    $wordCount = str_word_count($plain);

    $minutes = (int) ceil($cjkCount / 400 + $wordCount / 200);
    if ($minutes < 1) $minutes = 1;
    return $minutes . ' 分钟读完';
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
