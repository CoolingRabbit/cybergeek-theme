<?php
/**
 * CyberGeek v2 MAX Theme - Index Template
 * 整页 CRT 屏幕 + Nixie 辉光管标题（每根管子闪烁节奏错开）+ 机械键盘分页
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');

// 把站点标题拆成独立字符，生成"每根管子"并错开闪烁节奏
// 注意：必须用属性访问取值；$this->options->title() 方法会直接 echo 导致文本泄漏到页首
$siteTitle = $this->options->title;
$titleChars = preg_split('//u', $siteTitle, -1, PREG_SPLIT_NO_EMPTY);
?>

<div class="container">
    <!-- Hero：Nixie 辉光管标题 -->
    <section class="hero">
        <h1 class="hero-title nixie-title" aria-label="<?php echo htmlspecialchars($siteTitle); ?>"><?php
            $i = 0;
            foreach ($titleChars as $ch) {
                // 每根管子的闪烁相位错开 0.13s，周期也有细微差异
                $delay = sprintf('%.2f', $i * 0.13);
                $display = ($ch === ' ') ? '&nbsp;' : htmlspecialchars($ch);
                echo '<span class="nixie-char" data-char="' . htmlspecialchars($ch) . '" style="--d: -' . $delay . 's; animation-duration: ' . (3.6 + ($i % 3) * 0.5) . 's;" aria-hidden="true">' . $display . '</span>';
                $i++;
            }
        ?></h1>
        <p class="hero-desc"><?php $this->options->description(); ?></p>
        <div class="hero-line"></div>
    </section>

    <!-- 整个页面即 CRT 屏幕，文章列表直接铺在屏幕里 -->
    <div class="post-grid">
        <?php if ($this->have()): ?>
            <?php while ($this->next()): ?>
                <?php
                $thumb = getThumbnail($this);
                $catColor = 'default';
                $catName = '';
                if (!empty($this->categories) && is_array($this->categories)) {
                    $firstCat = reset($this->categories);
                    if (is_array($firstCat)) {
                        if (isset($firstCat['slug'])) $catColor = getCategoryColor($firstCat['slug']);
                        if (isset($firstCat['name'])) $catName = $firstCat['name'];
                    }
                }
                ?>
                <article class="post-card" data-category="<?php echo $catColor; ?>">
                    <?php if ($thumb): ?>
                        <img src="<?php echo $thumb; ?>" alt="<?php $this->title(); ?>" class="post-card-thumbnail" loading="lazy">
                    <?php endif; ?>
                    <div class="post-card-body">
                        <h2 class="post-card-title">
                            <a href="<?php $this->permalink(); ?>" data-scramble><?php $this->title(); ?></a>
                        </h2>
                        <p class="post-card-excerpt"><?php echo getExcerpt($this, 110); ?></p>
                        <div class="post-card-meta">
                            <time datetime="<?php $this->date('c'); ?>"><?php $this->date('Y-m-d'); ?></time>
                            <?php if ($catName): ?>
                                <span class="separator">/</span>
                                <span class="cat-tag"><?php echo $catName; ?></span>
                            <?php endif; ?>
                            <span class="separator">/</span>
                            <span><?php echo getReadingTime($this); ?></span>
                        </div>
                    </div>
                </article>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="post-card-empty"><?php _e('// 没有找到内容'); ?></div>
        <?php endif; ?>
    </div>

    <!-- 机械键盘分页 -->
    <div class="pagination">
        <?php
        $currentPage = max(1, intval($this->_currentPage));
        $totalPage = max(1, intval($this->getTotalPage()));
        ?>
        <div class="pagination-keyboard">
            <?php if ($currentPage > 1): ?>
                <?php $this->pageLink('←', 'prev', array('class' => 'page-key page-key-nav')); ?>
            <?php else: ?>
                <span class="page-key page-key-nav page-key-disabled">←</span>
            <?php endif; ?>

            <span class="page-key page-key-current"><?php echo $currentPage; ?></span>

            <?php if ($currentPage < $totalPage): ?>
                <?php $this->pageLink('→', 'next', array('class' => 'page-key page-key-nav')); ?>
            <?php else: ?>
                <span class="page-key page-key-nav page-key-disabled">→</span>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $this->need('footer.php'); ?>
