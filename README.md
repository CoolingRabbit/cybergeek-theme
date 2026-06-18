# CyberGeek Theme

Typecho 博客主题 —— CRT 显示器 + 机械键盘风格

## 当前问题

### 1. 分页按钮点击无效（紧急）
- **文件**: `index.php`
- **问题**: `pageLink()` 参数传反了
- **Typecho API**: `pageLink($word, $page)` — 第1个参数是显示文本，第2个是页码
- **当前错误代码**:
  ```php
  <a href="<?php $this->pageLink($currentPage + 1); ?>">→</a>
  ```
  这导致 `$word = 2`（页码作为文本），`$page = null`（页码为空），所以 `href=""`
- **正确写法**:
  ```php
  <?php $this->pageLink('', $currentPage + 1); ?>
  ```
  空字符串作为显示文本，正确页码作为第2参数

### 2. 备案号布局
- **文件**: `footer.php` + `style.css`
- 当前使用 `white-space: nowrap` 强制一行，但需要验证实际效果

### 3. 键盘风格分页
- **文件**: `style.css` + `index.php`
- CSS 已添加 CRT 键盘底座和键帽效果
- 需要确认浏览器缓存刷新后是否正常显示

## 文件结构

```
cybergeek-theme/
├── index.php      # 首页模板（含分页）
├── header.php     # 头部（CSS 版本号已加 ?v=20250618）
├── footer.php     # 页脚（含备案号）
├── style.css      # 主题样式（键盘分页 + 备案号布局）
├── functions.php  # 主题函数
├── post.php       # 文章页
├── page.php       # 独立页面
├── archive.php    # 归档页
├── comments.php   # 评论
├── 404.php        # 404页面
├── design-spec.md # 设计规范
└── screenshot.png # 主题截图
```

## 技术栈

- Typecho 博客系统
- PHP 模板
- CSS3（Flexbox、渐变、阴影）
- 无 JavaScript 依赖（纯 CSS 实现 CRT 效果）

## 服务器信息

- 主机: 新网虚拟共享主机
- 主题路径: `/www/usr/themes/cybergeek/`
- 博客地址: https://www.kjifds.top/
