# CyberGeek v2 MAX — Typecho 主题

> 硬件极客桌面世界观 · 极繁炫技版。CRT 显示器 + Nixie 辉光管 + 机械键盘全家桶，同时守住长文可读性底线。

## 定位

v1 是"极客风"，v2 MAX 是"把一台复古工作站搬到浏览器里"：页面加载是 CRT 开机，文章列表是屏幕内容，分页是键盘，代码块是终端窗口，404 是一次失败的 curl。

## 保留的 v1 招牌元素

- GitHub 深灰蓝底 `#0D1117` + 赤陶橙 `#D97757` + 橄榄绿 / 铁锈辅色
- Nixie 辉光管首页标题
- 机械键盘键帽分页（伪元素方向箭头）
- 终端 curl 404 页
- shell 代码终端化渲染（提示符/命令/输出/错误分色）

## 新增炫技

| 效果 | 说明 |
|------|------|
| **整页 CRT 屏幕** | 扫描线微闪 + 曲面暗角 + 玻璃反光铺满全屏，页面本身即显示器；品牌铭牌/电源灯为角落装饰 |
| **CRT 开机动画分级** | 首页首次完整 boot（白噪点 → 亮线展开 → 淡出，sessionStorage 标记）；其它页面 0.5s 快速亮线闪入 |
| **Nixie 每管独立闪烁** | 标题拆成独立字符，每根"管子"闪烁相位错开 0.13s、周期微调，多层 text-shadow 辉光 + 背后模糊余晖 |
| **Scramble 解码** | 悬停导航链接 / 文章标题时字符乱码解码还原 |
| **RGB 色散** | 文章卡片 hover 时标题出现红蓝色差边缘 |
| **Glow sweep** | 卡片 hover 时一道辉光斜向扫过，左边框点亮 |
| **LED 进度条** | 顶部 4px 琥珀色 LED 灯珠分段阅读进度条，带辉光 |
| **代码块行号** | 非 shell 代码逐行高亮，磷光绿行号（`01` 两位格式），行 hover 微亮 |
| **复制键帽** | 终端窗口 copy 按钮做成小键帽，可按压下沉 |
| **全站键帽化** | 导航按钮、提交按钮、返回首页、回到顶部全部 3D 键程按压 |
| **终端光标** | 导航站点标识、shell 终端末尾的琥珀色闪烁光标 |

## 可读性底线

- 正文 `#C6CCD4` 降对比、17px / 行高 1.9 / 46rem 居中栏
- 中文不使用斜体；中文显式回退 PingFang SC / Hiragino Sans GB / Microsoft YaHei / Noto Sans SC
- 表格 100% 宽度全单元格可换行、最小列宽防逐字竖排，窄栏免横滑
- 行内 code 可换行防溢出；`prefers-reduced-motion` 全局兜底
- 无声设计：无任何音效

## 技术

- 动画几乎全部 CSS（keyframes + 伪元素）；JS 仅用于 scramble / 行号高亮 / 复制 / 进度条
- 依赖仅 highlight.js CDN 与 Google Fonts（Inter + JetBrains Mono）
- Typecho 1.3.0 模板 API 兼容，`$this->` 调用方式不变
- `functions.php` 保留 `getReadingTime()`（中文按字数、英文按词数估算）

## 实测修复记录（上线后）

- 修复首页标题泄漏：`$this->options->title()` 方法会直接 echo，改为属性访问 `$this->options->title` 取值后再拆字。
- CRT 外壳移除：不再有"页面里放一台显示器"，改为整页即 CRT 屏幕；品牌铭牌与电源灯保留为页面角落小装饰（移动端隐藏）。
- Markdown 表格修复：全单元格可换行 + 最小列宽 3.5em 杜绝逐字竖排；字号 14px 紧凑排版；极宽表格保留 overflow-x 兜底。
- 开机动画分级：仅首页首次访问播放完整 boot；其它页面 0.5s 快速闪入。
- 行内 code 溢出修复：可换行 + overflow-wrap anywhere，正文全局防溢出兜底。
- Hero boot 序列移除：应用户要求直接删除启动日志，Hero 只保留 Nixie 标题 + 简介；版本号统一为 v2.0.0。

## 文件结构

```
cybergeek/
├── index.php       # 首页（Nixie 拆字标题 + 整页 CRT 文章列表 + 键盘分页）
├── header.php      # 公共头部（开机动画 + LED 进度条 + 导航）
├── footer.php      # 公共底部（scramble / 行号 / 复制键帽 JS）
├── post.php        # 文章页（含阅读时长）
├── page.php        # 独立页面
├── archive.php     # 归档/分类/标签页
├── comments.php    # 评论区
├── 404.php         # 404 终端页
├── functions.php   # 主题函数（getReadingTime 等）
├── style.css       # 主样式（CSS 变量驱动）
├── design-spec.md  # 设计规范
├── CHANGELOG.md    # 更新日志
└── README.md
```

## 安装

上传到 `usr/themes/cybergeek/`，后台启用即可。`screenshot.png` 仓库已含预览图。

## License

MIT
