# CyberGeek v2 MAX 设计规范（极繁炫技版）

## 1. 项目信息

- **主题名称**: CyberGeek v2 MAX
- **博客系统**: Typecho 1.3.0
- **适用站点**: 通用（技术博客 / 知识库型站点）
- **定位**: 硬件极客桌面世界观——整页 CRT + Nixie 辉光管 + 机械键盘的极繁炫技主题

## 2. 设计原则

1. **统一世界观**：整个博客是一台复古工作站。加载 = 开机，页面 = 屏幕，分页 = 键盘，代码 = 终端，404 = 失败的 curl。
2. **炫技有边界**：特效集中在装饰层（Hero、CRT 全局层、代码块、按钮），正文排版保持可读。
3. **CSS 优先**：动画用 CSS keyframes/伪元素实现；JS 只做必须的状态逻辑。
4. **可访问兜底**：`prefers-reduced-motion` 下一键关停全部循环动画与开机动画。

## 3. 配色（沿用 v1 原版）

| 变量 | 色值 | 用途 |
|------|------|------|
| `--bg-primary` | `#0D1117` | 主背景 |
| `--bg-secondary` | `#161B22` | 卡片/面板 |
| `--bg-code` | `#1E2530` | 行内代码/表头 |
| `--bg-terminal` | `#0D1117` | 终端窗口底色 |
| `--border` / `--border-light` | `#30363D` / `#21262D` | 边框 |
| `--accent-clay` | `#D97757` | 主强调（赤陶橙） |
| `--accent-clay-dark` | `#B85C3E` | hover 加深 |
| `--accent-olive` | `#788C5D` | 提示符/行号/成功态 |
| `--accent-rust` | `#B04A3F` | 错误 |
| `--nixie-core` | `#FFD4B8` | Nixie 管芯色 |
| `--nixie-glow` | `#FF6B35` | Nixie 辉光 |
| `--nixie-deep` | `#FF4500` | Nixie 深层辉光 |
| `--text-primary` | `#E6EDF3` | 标题 |
| `--text-body` | `#C6CCD4` | 正文（降对比护眼） |
| `--text-secondary` / `--text-muted` | `#8B949E` / `#6E7681` | 辅助/弱化 |

## 4. 字体

```css
--font-sans: -apple-system, BlinkMacSystemFont, "Segoe UI",
             "PingFang SC", "Hiragino Sans GB", "Microsoft YaHei",
             "Noto Sans SC", sans-serif;
--font-mono: ui-monospace, "SF Mono", SFMono-Regular, Menlo,
             "Cascadia Code", Consolas, "Liberation Mono", monospace;
```

- 系统字体栈直出，不加载任何远程字体；正文/标题 sans；UI/元信息/代码/Nixie mono。中文不使用斜体。

## 5. 排版底线

- 正文 17px / 行高 1.9 / 46rem 居中栏；段距 1.6em。
- h2 带琥珀侧边条（1.5rem），h3/h4 层级拉开；h3/h4 hover 显示 `#` 锚点。
- 引用块：左 4px 琥珀条 + 琥珀透明底，中文不斜体。
- 表格：100% 宽度 + 全单元格可换行 + `overflow-wrap: anywhere` + 最小列宽 3.5em（表头 4em）防逐字竖排；14px / 行高 1.55；表头 `--bg-code` 底 + 橄榄绿 mono 大写；`overflow-x: auto` 兜底。
- 行内 code：可换行 + `overflow-wrap: anywhere`；正文 p/li/a 防溢出兜底；pre `overflow-x: auto`。

## 6. 招牌组件

### 6.1 CRT 开机动画（`.boot-overlay`，分级）
默认隐藏，JS 决定：首页且 sessionStorage 无 `cg_booted` → `.boot-play` 完整 boot（白噪点 → 亮线横展 → 纵展 → 淡出，约 2s）；其它页面 → `.boot-quick` 0.5s 亮线闪入。`prefers-reduced-motion` 下不播放。

### 6.2 Nixie 标题（`.nixie-char`）
PHP 将站点标题拆成字符（属性访问 `$this->options->title` 取值，避免 echo 泄漏），每个字符独立 span：闪烁 keyframes + 内联 `--d` 负延迟错开相位 + 每管周期微调 + `::before` 模糊余晖。

### 6.3 整页 CRT（`.crt-global-scanlines` / `.crt-global-vignette`）
- 扫描线：fixed 全屏 repeating-linear-gradient，0.12s 微闪，z-index 998。
- 暗角：椭圆 vignette + 顶部玻璃反光 + 淡蓝光晕，z-index 999。
- 角落装饰：左下品牌铭牌、右下呼吸电源灯（移动端隐藏）。

### 6.4 文章卡片
行式（左图右文）+ 左侧 3px 分类色条；hover：上浮、左边框点亮为 Nixie 橙、辉光扫过（`::after` 斜向渐变 sweep）、标题 RGB 色散。

### 6.5 终端代码块
- 窗头：红黄绿圆点（带辉光）+ 语言名 + copy 小键帽。
- 非 shell：JS 逐行 `hljs.highlight` 渲染为 `.code-line`，CSS counter 生成磷光绿两位行号，行 hover 微亮。
- shell：按行渲染提示符（橄榄绿）/命令/输出/错误分色。

### 6.6 机械键盘
- 分页：键盘底座 + 键帽（`border-bottom: 5px` 键程，按下 `translateY(3px)` 且底边收到 2px）+ 伪元素方向箭头 + 琥珀当前页。
- 导航按钮、提交评论、返回首页、回到顶部均键帽化。

### 6.7 其他
- LED 进度条：顶部 4px，`mask` 分段灯珠，琥珀渐变 + 辉光。
- Scramble 解码：hover `[data-scramble]` 元素，ASCII 字符乱码后逐位还原（30ms/帧）。
- 404：curl 会话 + 琥珀辉光 404 行 + 铁锈报错 shake + 闪烁光标。

## 7. 响应式

| 断点 | 行为 |
|------|------|
| > 768px | 完整 CRT 全局层 + 行式卡片 |
| ≤ 768px | 汉堡菜单、卡片改纵向、角落装饰隐藏、代码块贴边全宽、Nixie 缩字号 |

## 8. 可访问性

- `prefers-reduced-motion`：关闭开机动画、Nixie 闪烁、扫描线微闪、光标闪烁、scramble；Nixie 保留静态辉光。
- Nixie 标题 `aria-label` 提供完整文字，字符 span `aria-hidden`。
- 无声设计。

## 9. 输出要求

- UTF-8 无 BOM；Typecho 1.3.0 模板 API 兼容。
- 外部依赖：仅公安备案图标（beian.mps.gov.cn，仅配置公安备案号时加载）；highlight.js 已自托管为单文件 `hljs.min.js`；字体全部使用系统栈。
- 函数增强：`getReadingTime()`（中文 400 字/分，英文 200 词/分）。
