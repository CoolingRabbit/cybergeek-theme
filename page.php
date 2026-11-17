<?php
/**
 * CyberGeek v2 Theme - Page Template
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>

<div class="container">
    <article class="page-single">
        <header class="page-header">
            <h1 class="page-title"><?php $this->title(); ?></h1>
        </header>

        <div class="page-content">
            <?php $this->content(); ?>
        </div>
    </article>

    <?php $this->need('comments.php'); ?>
</div>

<?php $this->need('footer.php'); ?>
