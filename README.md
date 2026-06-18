# CyberGeek Theme

Typecho 博客主题 —— CRT 显示器 + 机械键盘风格

## 特色

- **CRT 显示器效果**：扫描线、荧光粉纹理、曲面畸变、发光文字
- **辉光管标题**：暖橙色数字管风格首页标题
- **机械键盘分页**：立体键帽、按压下沉效果、方向键图标
- **赛博朋克配色**：深灰底色 + 琥珀/赤陶/暖金点缀

## 修复记录

### 2026-06-18

#### 分页按钮修复
- **问题**：点击翻页按钮无反应
- **原因**：`pageLink()` 参数传反了，导致 `href=""` 为空
- **解决**：使用 `pageLink('→', 'next', array('class' => '...'))` 标准调用

#### 键盘风格箭头
- **问题**：左右箭头是简单字符 `← →`
- **解决**：用 CSS 伪元素绘制精致方向键图标
  - 三角形箭头头 + 横线箭身
  - 悬停高亮，不互相干扰
  - 精确定位在键帽中心

#### 备案号布局
- **问题**：ICP + 公安备案号换行显示
- **解决**：`white-space: nowrap` + 图标尺寸限制

#### CSS 缓存
- **解决**：header.php 中 CSS 链接添加 `?v=20250618` 版本号

## 文件结构

```
cybergeek-theme/
├── index.php      # 首页模板（含键盘分页）
├── header.php     # 头部（含 CSS 版本号）
├── footer.php     # 页脚（含 ICP + 公安备案）
├── style.css      # 主题样式（CRT 效果 + 键盘键帽）
├── functions.php  # 主题函数
├── post.php       # 文章页
├── page.php       # 独立页面
├── archive.php    # 归档页
├── comments.php   # 评论
├── 404.php        # 404 页面
├── design-spec.md # 设计规范
└── screenshot.png # 主题截图
```

## 技术栈

- Typecho 博客系统
- PHP 模板
- CSS3（渐变、阴影、伪元素、CSS 变量）
- 无 JavaScript 依赖

## 服务器信息

- 主机：新网虚拟共享主机
- 主题路径：`/www/usr/themes/cybergeek/`
- 博客地址：https://www.kjifds.top/

## Typecho 分页 API 参考

```php
// 生成分页链接（内部输出 <a> 标签）
$this->pageLink($word, $page, $tag);
// $word: 显示文本
// $page: 页码（'prev'/'next' 或数字）
// $tag: HTML 属性数组

// 获取分页 URL（不输出标签）
$this->getPageLink($page);
```

## License

MIT
