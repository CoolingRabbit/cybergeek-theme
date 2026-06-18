<?php
/**
 * CyberGeek Theme - Comments Template (Geek Style + Warm Colors)
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
?>

<div class="comments-section" id="comments">
    <?php $this->comments()->to($comments); ?>

    <h3 class="comments-title">
        <?php $this->commentsNum(_t('暂无评论'), _t('1 条评论'), _t('%d 条评论')); ?>
    </h3>

    <?php if ($comments->have()): ?>
        <?php $comments->listComments(); ?>
        <?php $comments->pageNav('&laquo;', '&raquo;'); ?>
    <?php endif; ?>

    <?php if ($this->allow('comment')): ?>
        <div id="<?php $this->respondId(); ?>" class="comment-form">
            <h3 class="comments-title" id="response"><?php _e('发表评论'); ?></h3>

            <div class="cancel-comment-reply">
                <?php $comments->cancelReply(); ?>
            </div>

            <form method="post" action="<?php $this->commentUrl() ?>" id="comment-form" role="form">
                <?php if ($this->user->hasLogin()): ?>
                    <p style="margin-bottom: var(--space-md); color: var(--text-muted); font-family: var(--font-sans); font-size: 0.9em;">
                        <?php _e('登录身份'); ?>: <a href="<?php $this->options->profileUrl(); ?>"><?php $this->user->screenName(); ?></a>.
                        <a href="<?php $this->options->logoutUrl(); ?>" title="Logout"><?php _e('退出'); ?> &raquo;</a>
                    </p>
                <?php else: ?>
                    <div class="form-group">
                        <label for="author"><?php _e('称呼'); ?> <?php if ($this->options->commentsRequireMail): ?><span style="color: var(--accent-clay);">*</span><?php endif; ?></label>
                        <input type="text" name="author" id="author" class="form-input" value="<?php $this->remember('author'); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="mail"><?php _e('邮箱'); ?> <?php if ($this->options->commentsRequireMail): ?><span style="color: var(--accent-clay);">*</span><?php endif; ?></label>
                        <input type="email" name="mail" id="mail" class="form-input" value="<?php $this->remember('mail'); ?>" <?php if ($this->options->commentsRequireMail): ?>required<?php endif; ?>>
                    </div>
                    <div class="form-group">
                        <label for="url"><?php _e('网站'); ?></label>
                        <input type="url" name="url" id="url" class="form-input" placeholder="https://" value="<?php $this->remember('url'); ?>">
                    </div>
                <?php endif; ?>
                <div class="form-group">
                    <label for="textarea"><?php _e('内容'); ?> <span style="color: var(--accent-clay);">*</span></label>
                    <textarea name="text" id="textarea" class="form-textarea" rows="6" required><?php $this->remember('text'); ?></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="form-submit"><?php _e('提交评论'); ?></button>
                </div>
            </form>
        </div>
    <?php else: ?>
        <p style="color: var(--text-muted); text-align: center; padding: var(--space-lg); font-family: var(--font-sans); font-style: italic;"><?php _e('评论已关闭'); ?></p>
    <?php endif; ?>
</div>
