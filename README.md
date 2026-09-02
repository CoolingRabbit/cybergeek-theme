# CyberGeek v2 MAX — Typecho 主题

> CRT 显示器 + Nixie 辉光管 + 机械键盘全家桶，由 Kimi K3 构建。

## 定位

硬件极客桌面世界观的极繁炫技主题：整个博客是一台复古工作站——页面加载是 CRT 开机，文章列表是屏幕内容，分页是机械键盘，代码块是终端窗口，404 是一次失败的 curl。炫技集中在装饰层（Hero、CRT 全局层、代码块、按钮），正文排版守住长文可读性底线：正文 17px / 行高 1.9 / 46rem 居中栏，中文不使用斜体，表格窄栏免横滑。

## 视觉效果技术

- **整页 CRT 屏幕**：扫描线微闪 + 曲面暗角 + 玻璃反光以 fixed 全局层铺满全屏，页面本身即显示器；品牌铭牌与呼吸电源灯为角落装饰（移动端隐藏）
- **CRT 开机动画分级**：首页首次访问播放完整 boot（白噪点 → 亮线展开 → 淡出，sessionStorage 标记同会话不重播）；其它页面 0.5s 快速亮线闪入
- **Nixie 辉光管标题**：站点标题拆成独立字符，每根"管子"闪烁相位错开 0.13s、周期微调，多层 text-shadow 辉光 + 背后模糊余晖
- **Scramble 解码**：悬停导航链接 / 文章标题时字符乱码逐位还原
- **终端代码块**：红黄绿窗头 + 语言名 + copy 复制键帽；非 shell 代码逐行高亮 + 磷光绿两位行号；shell 按行渲染提示符 / 命令 / 输出 / 错误分色
- **机械键盘分页**：键盘底座 + 3D 键程键帽（按下下沉、底边同步收），伪元素方向箭头，琥珀色当前页
- **细节层**：卡片 hover 辉光扫过 + 标题 RGB 色散、顶部 LED 灯珠分段阅读进度条、导航终端提示符 + 闪烁光标
- **工程底线**：动画几乎全部 CSS（keyframes + 伪元素），JS 只做状态逻辑；`prefers-reduced-motion` 一键关停全部循环动画；无声设计

## 大陆环境本地化特色

- **零外部 CDN 依赖**：highlight.js 自托管为单文件 `hljs.min.js`（core + 9 种常用语言，`defer` 加载）；字体全部使用系统栈，不加载 Google Fonts，杜绝大陆网络环境下首屏阻塞与装饰延迟
- **备案号开箱即用**：后台「控制台 → 外观 → 设置外观」可直接填写 **ICP 备案号** 和 **公安备案号**，留空则页脚整块不输出；填写公安备案号后自动附带官方 logo 图标，并生成带 recordcode 的联网查询链接
- **缓存破坏自动化**：`style.css` / `hljs.min.js` 版本号按文件修改时间（filemtime）自动生成，更新主题免手动改版本号

## 文件结构

```
cybergeek/
├── index.php       # 首页（Nixie 拆字标题 + 整页 CRT 文章列表 + 键盘分页）
├── header.php      # 公共头部（开机动画 + LED 进度条 + 导航）
├── footer.php      # 公共底部（scramble / 行号 / 复制键帽 JS）
├── post.php        # 文章页（含阅读时长）
├── page.php        # 独立页面
├── archive.php     # 归档 / 分类 / 标签页
├── comments.php    # 评论区
├── 404.php         # 404 终端页
├── functions.php   # 主题函数（阅读时长估算、缩略图提取、资源版本号等）
├── style.css       # 主样式（CSS 变量驱动）
├── hljs.min.js     # highlight.js 自托管合并版（core + 9 语言）
├── design-spec.md  # 设计规范
├── CHANGELOG.md    # 更新日志
└── README.md
```

## 安装方式

1. 下载 [最新 Release](https://github.com/CoolingRabbit/cybergeek-theme/releases) 并解压；
2. 将 `cybergeek/` 目录上传到 Typecho 站点的 `usr/themes/` 下；
3. 后台「控制台 → 外观」启用 CyberGeek v2 MAX；
4. 如需展示备案信息，在「设置外观」中填写 ICP 备案号 / 公安备案号即可。

兼容 Typecho 1.3.0+；`screenshot.png` 已内置预览图。

## License

MIT
