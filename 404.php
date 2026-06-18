<?php
/**
 * CyberGeek Theme - 404 Template (Terminal Style)
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>

<div class="container">
    <div class="terminal-404">
        <div class="terminal-header">
            <span class="terminal-dot red"></span>
            <span class="terminal-dot yellow"></span>
            <span class="terminal-dot green"></span>
            <span class="terminal-title">kjifds@cybergeek: ~</span>
        </div>
        <div class="terminal-body">
            <div class="terminal-line">
                <span class="terminal-prompt">$</span>
                <span class="terminal-command"> curl <?php $this->options->siteUrl(); ?><?php echo htmlspecialchars(ltrim($_SERVER['REQUEST_URI'], '/')); ?></span>
            </div>
            <div class="terminal-line">
                <span class="terminal-error-glow">HTTP/1.1 404 Not Found</span>
            </div>
            <div class="terminal-line">
                <span class="terminal-output">Content-Type: text/html; charset=utf-8</span>
            </div>
            <div class="terminal-line">
                <span class="terminal-output">Date: <?php echo gmdate('D, d M Y H:i:s T'); ?></span>
            </div>
            <div class="terminal-line" style="margin-top: 16px;">
                <span class="terminal-error">Error: Page not found</span>
            </div>
            <div class="terminal-line">
                <span class="terminal-error">The requested URL was not found on this server.</span>
            </div>
            <div class="terminal-line" style="margin-top: 16px;">
                <span class="terminal-prompt">$</span>
                <span class="terminal-command"> echo "Maybe try going home?"</span>
            </div>
            <div class="terminal-line">
                <span class="terminal-output">Maybe try going home?</span>
            </div>
            <div class="terminal-line" style="margin-top: 16px;">
                <span class="terminal-prompt">$</span>
                <span class="terminal-cursor"></span>
            </div>
        </div>
    </div>

    <div style="text-align: center; margin-top: var(--space-xl);">
        <a href="<?php $this->options->siteUrl(); ?>" class="back-home-btn">返回首页</a>
    </div>
</div>

<?php $this->need('footer.php'); ?>
