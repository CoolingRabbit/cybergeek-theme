# Kimi Code Windows FTP 工作提示词

## 目标
通过 FTP 连接修改 Typecho 博客主题文件，修复分页按钮和样式问题。

---

## FTP 连接信息

```
主机: host2644876008.xincache1.cn
用户名: host2644876008
密码: T*4sbtZeXpVeZZVtwjNQ
端口: 21（默认）
协议: FTP（非 FTPS/SFTP）
```

**主题路径**: `/www/usr/themes/cybergeek/`

---

## 需要修改的文件

### 1. index.php — 修复分页按钮点击无效（最紧急）

**问题**: 点击翻页按钮无反应
**原因**: `pageLink()` 参数传反了

**当前错误代码**（约第 83 和 91 行）:
```php
<a href="<?php $this->pageLink($currentPage - 1); ?>" class="page-key page-key-nav">←</a>
```
```php
<a href="<?php $this->pageLink($currentPage + 1); ?>" class="page-key page-key-nav">→</a>
```

**修复方案**:  
Typecho 的 `$this->pageLink($word, $page)` 方法中：
- 参数 1 `$word`: 链接显示的文本
- 参数 2 `$page`: 目标页码

之前的代码把页码传给了 `$word`，导致 `$page` 为空，所以 `href=""`。

**正确代码**:
```php
<?php $this->pageLink('', $currentPage - 1); ?>
```
```php
<?php $this->pageLink('', $currentPage + 1); ?>
```

注意：使用 `pageLink()` 方法时不需要手写 `<a>` 标签，方法内部会自动生成。正确的完整分页代码：

```php
<!-- Pagination -->
<div class="pagination pagination-outside">
    <?php
    $currentPage = max(1, intval($this->_currentPage));
    $totalPage = max(1, intval($this->getTotalPage()));
    ?>
    <div class="pagination-keyboard">
        <?php if ($currentPage > 1): ?>
            <?php $this->pageLink('', $currentPage - 1); ?>
        <?php else: ?>
            <span class="page-key page-key-nav page-key-disabled">←</span>
        <?php endif; ?>
        
        <span class="page-key page-key-current"><?php echo $currentPage; ?></span>
        
        <?php if ($currentPage < $totalPage): ?>
            <?php $this->pageLink('', $currentPage + 1); ?>
        <?php else: ?>
            <span class="page-key page-key-nav page-key-disabled">→</span>
        <?php endif; ?>
    </div>
</div>
```

但注意：直接调用 `$this->pageLink('', $currentPage + 1)` 生成的链接可能不带 `page-key` 等 class。如果需要保留自定义 class，需要查看 pageLink 的源码或使用另一种方式。

**更简单可靠的方案**（保留自定义 class）:
使用 `$this->getPageLink()` 获取 URL，手写 `<a>` 标签：

```php
<?php if ($currentPage > 1): ?>
    <a href="<?php echo $this->getPageLink($currentPage - 1); ?>" class="page-key page-key-nav">←</a>
<?php else: ?>
    <span class="page-key page-key-nav page-key-disabled">←</span>
<?php endif; ?>
```

```php
<?php if ($currentPage < $totalPage): ?>
    <a href="<?php echo $this->getPageLink($currentPage + 1); ?>" class="page-key page-key-nav">→</a>
<?php else: ?>
    <span class="page-key page-key-nav page-key-disabled">→</span>
<?php endif; ?>
```

**推荐用这个方案**，因为它保留了自定义的 CSS class。

---

### 2. style.css — 键盘风格分页 + 备案号布局

已在文件中，需要确认是否完整：

**分页键盘样式**（搜索 `.pagination-keyboard`）:
- 键帽立体感（顶部高光、厚重底部边框）
- 悬停上浮效果
- 按下下沉效果
- 当前页橙色发光

**备案号样式**（搜索 `.footer-beian`）:
- `white-space: nowrap` 强制一行
- 图标限制 16x16px

---

### 3. header.php — CSS 版本号

确认 CSS 链接包含版本号：
```php
<link rel="stylesheet" href="<?php $this->options->themeUrl('style.css'); ?>?v=20250618">
```

---

## 验证步骤

1. 修改 index.php 后，访问博客首页
2. 检查分页按钮的 HTML:
   ```
   右键 → 检查 → 找到 <div class="pagination-keyboard">
   ```
3. 确认 `<a>` 标签的 `href` 属性不为空
4. 点击 → 按钮，应该能进入下一页

---

## 其他文件（无需修改，仅供参考）

- footer.php — 备案号 HTML 结构
- functions.php — 主题函数
- post.php / page.php / archive.php / 404.php / comments.php — 其他模板
- design-spec.md — 设计规范文档
- screenshot.png — 主题截图

---

## 注意事项

1. **备份**: 修改前下载原文件备份
2. **编码**: 文件使用 UTF-8 编码
3. **换行**: Windows 编辑注意换行符（LF vs CRLF），建议保持 LF
4. **缓存**: 修改后博客页面可能缓存，可尝试 `Ctrl+F5` 强制刷新
5. **权限**: FTP 用户有写入权限，直接覆盖即可

---

## 博客地址

https://www.kjifds.top/

修改后刷新首页验证效果。
