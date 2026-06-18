<?php
/**
 * CyberGeek Theme - Index Template (Geek Style + Warm Colors)
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>

<div class="container">
    <!-- Hero Section with Nixie Tube Title -->
    <section class="hero">
        <h1 class="hero-title nixie-title" data-text="<?php $this->options->title(); ?>"><?php $this->options->title(); ?></h1>
        <p class="hero-desc"><?php $this->options->description(); ?></p>
        <div class="hero-line"></div>
    </section>

    <!-- CRT Monitor -->
    <div class="crt-monitor">
        <div class="crt-bezel">
            <div class="crt-screen">
                <div class="crt-content">
                    <div class="post-grid">
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
                </div>
            </div>
            <div class="crt-brand">CyberGeek Monitor // Model KJ-2026</div>
            <div class="crt-power-led"></div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="pagination pagination-outside">
        <?php
        $currentPage = max(1, intval($this->_currentPage));
        $totalPage = max(1, intval($this->getTotalPage()));
        ?>
        <div class="pagination-keyboard">
            <?php if ($currentPage > 1): ?>
                <a href="<?php $this->pageLink($currentPage - 1); ?>" class="page-key page-key-nav">←</a>
            <?php else: ?>
                <span class="page-key page-key-nav page-key-disabled">←</span>
            <?php endif; ?>
            
            <span class="page-key page-key-current"><?php echo $currentPage; ?></span>
            
            <?php if ($currentPage < $totalPage): ?>
                <a href="<?php $this->pageLink($currentPage + 1); ?>" class="page-key page-key-nav">→</a>
            <?php else: ?>
                <span class="page-key page-key-nav page-key-disabled">→</span>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $this->need('footer.php'); ?>
