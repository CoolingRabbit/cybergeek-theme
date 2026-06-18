<?php
/**
 * CyberGeek Theme - Archive Template (Geek Style + Warm Colors)
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>

<div class="container">
    <header class="archive-header">
        <h1 class="archive-title">
            <?php $this->archiveTitle(array(
                'category'  =>  _t('分类 %s 下的文章'),
                'search'    =>  _t('包含关键字 %s 的文章'),
                'tag'       =>  _t('标签 %s 下的文章'),
                'author'    =>  _t('%s 发布的文章')
            ), '', ''); ?>
        </h1>
        <p class="archive-count">共 <?php echo $this->getTotal(); ?> 篇文章</p>
    </header>

    <div class="archive-list">
        <?php if ($this->have()): ?>
            <?php while ($this->next()): ?>
                <?php
                $thumb = getThumbnail($this);
                $catColor = 'default';
                if (!empty($this->categories) && is_array($this->categories)) {
                    $firstCat = reset($this->categories);
                    if (is_array($firstCat) && isset($firstCat['slug'])) {
                        $catColor = getCategoryColor($firstCat['slug']);
                    }
                }
                ?>
                <article class="post-card" data-category="<?php echo $catColor; ?>">
                    <?php if ($thumb): ?>
                        <img src="<?php echo $thumb; ?>" alt="<?php $this->title(); ?>" class="post-card-thumbnail" loading="lazy">
                    <?php endif; ?>
                    <div class="post-card-body">
                        <h2 class="post-card-title">
                            <a href="<?php $this->permalink(); ?>"><?php $this->title(); ?></a>
                        </h2>
                        <p class="post-card-excerpt"><?php echo getExcerpt($this, 120); ?></p>
                        <div class="post-card-meta">
                            <time datetime="<?php $this->date('c'); ?>"><?php $this->date('Y-m-d'); ?></time>
                            <span class="separator">·</span>
                            <span><?php $this->category(','); ?></span>
                            <?php
                            $tagStr = '';
                            ob_start();
                            $this->tags(',', true, '');
                            $tagStr = ob_get_clean();
                            if (!empty($tagStr)):
                            ?>
                                <span class="separator">·</span>
                                <span><?php echo $tagStr; ?></span>
                            <?php endif; ?>
                        </div>
                        <a href="<?php $this->permalink(); ?>" class="post-card-readmore">阅读全文</a>
                    </div>
                </article>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="post-card" style="text-align: center; padding: var(--space-2xl);">
                <p style="color: var(--text-muted);"><?php _e('没有找到内容'); ?></p>
            </div>
        <?php endif; ?>
    </div>

    <div class="pagination">
        <?php $this->pageNav('&laquo;', '&raquo;', 3, '...', array('wrapTag' => '', 'wrapClass' => '', 'itemTag' => '', 'currentClass' => 'page-current', 'prevClass' => 'page-link', 'nextClass' => 'page-link', 'itemClass' => 'page-link')); ?>
    </div>
</div>

<?php $this->need('footer.php'); ?>
