<?php
/**
 * CyberGeek v2 Theme - Post Template
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>

<div class="container">
    <article class="post-single">
        <header class="post-header">
            <h1 class="post-title"><?php $this->title(); ?></h1>
            <div class="post-meta">
                <time datetime="<?php $this->date('c'); ?>"><?php $this->date('Y-m-d H:i'); ?></time>
                <span class="separator">/</span>
                <span><?php $this->category(','); ?></span>
                <span class="separator">/</span>
                <span><?php $this->author(); ?></span>
                <span class="separator">/</span>
                <span><?php echo getReadingTime($this); ?></span>
                <span class="separator">/</span>
                <span><?php $this->commentsNum('0 评论', '1 评论', '%d 评论'); ?></span>
            </div>
        </header>

        <div class="post-content">
            <?php $this->content(); ?>
        </div>

        <?php
        $tagStr = '';
        ob_start();
        $this->tags(' ', true, '');
        $tagStr = ob_get_clean();
        if (!empty($tagStr)):
        ?>
        <div class="post-tags">
            <?php echo $tagStr; ?>
        </div>
        <?php endif; ?>

        <nav class="post-nav">
            <div class="post-nav-prev">
                <div class="post-nav-label">上一篇</div>
                <div class="post-nav-title"><?php $this->thePrev('%s', '没有了'); ?></div>
            </div>
            <div class="post-nav-next">
                <div class="post-nav-label">下一篇</div>
                <div class="post-nav-title"><?php $this->theNext('%s', '没有了'); ?></div>
            </div>
        </nav>
    </article>

    <?php $this->need('comments.php'); ?>
</div>

<?php $this->need('footer.php'); ?>
