# Changelog

## [2.0.1] - 2026-09-02

审查修复版：外部资源本地化、配置项接活、个人信息移出代码。

### Changed
- **移除 Google Fonts**：字体改用系统栈直出（`ui-monospace` / 系统中文字体栈），消除大陆环境首屏渲染阻塞
- **highlight.js 自托管**：core + 9 种常用语言合并为单文件 `hljs.min.js`，`defer` 加载，不再依赖 cdnjs
- **备案号改为配置项**：页脚 ICP / 公安备案号改读外观设置 `beian` / `beianGov`，留空则整块不输出；公安备案链接自动提取数字 recordcode
- **样式缓存破坏自动化**：`style.css` / `hljs.min.js` 版本号改用 `filemtime`（新增 `cgAssetVer()`），免手动维护
- **外观设置精简**：移除从未生效的 `logoText` / `heroTitle` 摆设字段（导航与 Hero 标题直接跟随「站点名称」），`beian` 默认值清空

### Fixed
- 分类名与缩略图 URL 输出统一 `htmlspecialchars(ENT_QUOTES)` 转义（index / archive）
- 移除 `pageLink` 被内核静默忽略的第三参数（class 实际由 `a.prev/a.next` 选择器接管）
- `getThumbnail` 正则同时匹配单引号 `src='...'`
- 404 与代码终端标题中的个人站点名中性化为 `guest@cybergeek`

## [2.0.0] - 2026-07-20

极繁炫技版重构：整站即一台复古工作站。加载 = 开机，页面 = 屏幕，分页 = 键盘，代码 = 终端，404 = 失败的 curl。

### Added
- **整页 CRT 屏幕**：扫描线（微闪）、曲面暗角、顶部玻璃反光以 fixed 全局层铺满全屏，页面本身即显示器（取代 v1 的显示器外壳边框）；品牌铭牌与呼吸电源灯保留为页面左下/右下角装饰
- **CRT 开机动画分级**：首页首次访问播放完整 boot（白噪点 → 亮线展开 → 淡出，sessionStorage 标记同会话不重播）；其它页面 0.5s 快速亮线闪入
- **Nixie 辉光管每管独立闪烁**：站点标题拆成独立字符，闪烁相位逐管错开、周期微调，多层 text-shadow 辉光 + 背后模糊余晖
- **Scramble 解码**：悬停导航链接 / 文章标题时字符乱码逐位还原
- **LED 状态栏进度条**：顶部琥珀色 LED 灯珠分段阅读进度条
- **代码块行号**：非 shell 代码逐行高亮 + 磷光绿两位行号、行 hover 微亮
- **复制键帽**：终端窗口 copy 按钮做成可按压小键帽
- **全站键帽化**：导航按钮、提交评论、返回首页、回到顶部全部 3D 键程按压（无声设计）
- **卡片 hover 炫技**：辉光扫过（glow sweep）、左边框点亮、标题 RGB 色散
- **阅读时长估算**：`getReadingTime()` 中文按字数、英文按词数

### Changed
- **阅读体验**：正文降对比（#C6CCD4）17px / 行高 1.9 / 46rem 居中栏；中文不使用斜体；中文字体栈显式含 PingFang SC / Microsoft YaHei / Noto Sans SC
- **表格免横滑**：width 100% + 全单元格可换行 + 最小列宽防逐字竖排，14px 紧凑排版，终端风表头；极宽表格保留 overflow-x 兜底
- **行内 code 防溢出**：可换行 + overflow-wrap anywhere，正文段落/链接/pre 全局防溢出兜底
- **可访问性**：prefers-reduced-motion 下关闭开机动画、闪烁、扫描线微闪等全部循环动画

### Fixed
- 首页标题泄漏：options->title() 方法直接 echo 的问题改为属性访问取值
- Markdown 表格逐字竖排（列过窄 + 换行策略冲突）

### Removed
- CRT 显示器外壳边框（改为整页即屏幕）
- Hero boot 启动日志序列（应实测反馈移除，Hero 只保留 Nixie 标题 + 简介）

### 保留自 v1
- GitHub 深灰蓝底 #0D1117 + 赤陶橙 #D97757 + 橄榄绿/铁锈辅色
- Nixie 辉光管标题、机械键盘键帽分页（伪元素方向箭头）
- 终端 curl 404 页、shell 代码终端化分色渲染
- highlight.js 语法高亮、登录态感知导航、备案页脚

## [1.1.0] - 2026-06-18

### Changed
- **CRT 显示器不再限制高度** — 移除 `.crt-content` 的 `max-height: 900px` 和 `overflow-y: auto`，5 个卡片完整显示，不再触发内部滚动，整页滚动更顺滑

### Added
- **备案信息展示** — 页脚添加 ICP 备案号与公安备案号展示位（v2.0.1 起改为外观设置配置项），带官方图标
- **键盘风格分页** — 首页分页改为 CRT 终端键盘按键样式，带键帽立体感和悬停/按下交互
- **CRT 终端代码块** — Shell 代码块渲染为终端窗口样式，带彩色提示符、命令高亮

### Fixed
- 备案号强制单行显示，防止换行错乱
- CSS 缓存策略：header 引用加版本号参数 `?v=20250618`

## [1.0.0] - 2026-06-12

### Added
- CyberGeek Typecho 主题初始版本
- CRT 显示器风格文章列表容器
- 赛博朋克配色 + 暖色点缀
- 响应式布局支持
