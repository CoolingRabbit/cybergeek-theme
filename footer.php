<?php
/**
 * CyberGeek v2 MAX Theme Footer
 * JS 仅用于必要交互：scramble 解码 / 逐行高亮行号 / 复制键帽 / LED 进度条
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
?>
    </main>

    <button class="back-to-top" id="backToTop" aria-label="回到顶部">↑</button>

    <footer class="site-footer">
        <div class="container">
            <div class="footer-status"><span class="prompt">&gt;</span> session.active <span class="ok">[OK]</span> — uptime <?php echo date('Y'); ?> · cybergeek v2 max</div>
            <div class="footer-content">
                <p>&copy; <?php echo date('Y'); ?> <a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title(); ?></a>. All rights reserved.</p>
                <?php
                $cgBeian = $this->options->beian;
                $cgBeianGov = $this->options->beianGov;
                if (!empty($cgBeian) || !empty($cgBeianGov)): ?>
                <p class="footer-beian">
                    <?php if (!empty($cgBeian)): ?>
                    <a href="https://beian.miit.gov.cn/" target="_blank" rel="noopener"><?php echo htmlspecialchars($cgBeian, ENT_QUOTES, 'UTF-8'); ?></a>
                    <?php endif; ?>
                    <?php if (!empty($cgBeian) && !empty($cgBeianGov)): ?><span class="beian-sep">|</span><?php endif; ?>
                    <?php if (!empty($cgBeianGov)): ?>
                    <img src="https://beian.mps.gov.cn/web/assets/logo01.6189a29f.png" alt="" class="beian-icon">
                    <a href="https://www.beian.gov.cn/portal/registerSystemInfo?recordcode=<?php echo preg_replace('/\D/', '', $cgBeianGov); ?>" target="_blank" rel="noopener"><?php echo htmlspecialchars($cgBeianGov, ENT_QUOTES, 'UTF-8'); ?></a>
                    <?php endif; ?>
                </p>
                <?php endif; ?>
            </div>
        </div>
    </footer>

    <!-- Highlight.js 自托管合并版（core + 常用语言，单文件 defer 加载）；样式由主题 style.css 内嵌配色接管 -->
    <script src="<?php $this->options->themeUrl('hljs.min.js'); ?>?v=<?php echo cgAssetVer('hljs.min.js'); ?>" defer></script>

    <script>
    (function() {
        'use strict';

        var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        // ---- 导航栏滚动效果 ----
        var nav = document.getElementById('siteNav');
        function updateNav() {
            nav.classList.toggle('scrolled', window.scrollY > 50);
        }
        window.addEventListener('scroll', updateNav, { passive: true });
        updateNav();

        // ---- 移动端菜单 ----
        var menuToggle = document.getElementById('menuToggle');
        var navMenu = document.getElementById('navMenu');
        if (menuToggle && navMenu) {
            menuToggle.addEventListener('click', function() {
                menuToggle.classList.toggle('active');
                navMenu.classList.toggle('active');
            });
            navMenu.querySelectorAll('a').forEach(function(link) {
                link.addEventListener('click', function() {
                    menuToggle.classList.remove('active');
                    navMenu.classList.remove('active');
                });
            });
        }

        // ---- 回到顶部 ----
        var backToTop = document.getElementById('backToTop');
        function updateBackToTop() {
            backToTop.classList.toggle('visible', window.scrollY > 300);
        }
        window.addEventListener('scroll', updateBackToTop, { passive: true });
        updateBackToTop();
        backToTop.addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // ---- LED 阅读进度条 ----
        var ledBar = document.getElementById('ledProgressBar');
        if (ledBar) {
            var updateLed = function() {
                var doc = document.documentElement;
                var total = doc.scrollHeight - doc.clientHeight;
                var pct = total > 0 ? (window.scrollY / total) * 100 : 0;
                ledBar.style.width = pct + '%';
            };
            window.addEventListener('scroll', updateLed, { passive: true });
            updateLed();
        }

        // ---- scramble / decode：hover 时字符乱码解码 ----
        var SCRAMBLE_CHARS = '!<>-_\\/[]{}=+*^?#01';
        function scramble(el) {
            if (reducedMotion) return;
            var original = el.dataset.original || el.textContent;
            el.dataset.original = original;
            if (el._scrambleTimer) clearInterval(el._scrambleTimer);

            var frame = 0;
            var chars = Array.from(original);
            // 中文等宽字符直接逐步锁定，ASCII 参与乱码
            el._scrambleTimer = setInterval(function() {
                var out = '';
                var done = true;
                for (var i = 0; i < chars.length; i++) {
                    var revealAt = i * 2 + 3;
                    if (frame >= revealAt) {
                        out += chars[i];
                    } else {
                        done = false;
                        out += /[\x20-\x7E]/.test(chars[i])
                            ? SCRAMBLE_CHARS[Math.floor(Math.random() * SCRAMBLE_CHARS.length)]
                            : chars[i];
                    }
                }
                el.textContent = out;
                frame++;
                if (done) {
                    clearInterval(el._scrambleTimer);
                    el._scrambleTimer = null;
                    el.textContent = original;
                }
            }, 30);
        }

        document.querySelectorAll('[data-scramble]').forEach(function(el) {
            el.addEventListener('mouseenter', function() { scramble(el); });
        });

        // ---- 工具：HTML 转义 ----
        function escapeHtml(text) {
            var div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // ---- shell 代码按行渲染为终端风格 ----
        function renderShellTerminal(code, terminalBody) {
            var text = code.textContent || code.innerText || '';
            var lines = text.split('\n');
            var html = '';

            lines.forEach(function(line) {
                if (line.length === 0) {
                    html += '<div class="terminal-line">&nbsp;</div>';
                    return;
                }
                var trimmed = line.trimStart();
                var leadingSpaces = line.substring(0, line.length - trimmed.length);
                var indent = leadingSpaces.replace(/ /g, '&nbsp;').replace(/\t/g, '&nbsp;&nbsp;&nbsp;&nbsp;');

                if (trimmed.match(/^(Error|error|ERROR|ERR|WARN|WARNING|FATAL|FAIL|Failed|failed)\b/)) {
                    html += '<div class="terminal-line">' + indent + '<span class="terminal-error">' + escapeHtml(trimmed) + '</span></div>';
                    return;
                }
                var promptMatch = trimmed.match(/^(\[.*?@.*?\].*?[#$])(\s+.*)?$/);
                if (promptMatch) {
                    html += '<div class="terminal-line">' + indent +
                        '<span class="terminal-prompt">' + escapeHtml(promptMatch[1]) + '</span>' +
                        (promptMatch[2] ? '<span class="terminal-command">' + escapeHtml(promptMatch[2]) + '</span>' : '') +
                        '</div>';
                    return;
                }
                var simplePromptMatch = trimmed.match(/^(\$)(\s+.*)?$/);
                if (simplePromptMatch) {
                    html += '<div class="terminal-line">' + indent +
                        '<span class="terminal-prompt">$</span>' +
                        (simplePromptMatch[2] ? '<span class="terminal-command">' + escapeHtml(simplePromptMatch[2]) + '</span>' : '') +
                        '</div>';
                    return;
                }
                if (trimmed.match(/^#/)) {
                    html += '<div class="terminal-line">' + indent + '<span class="terminal-comment">' + escapeHtml(trimmed) + '</span></div>';
                    return;
                }
                html += '<div class="terminal-line">' + indent + '<span class="terminal-output">' + escapeHtml(trimmed) + '</span></div>';
            });

            terminalBody.innerHTML = html;
        }

        // ---- 复制按钮（小键帽） ----
        function createCopyButton(code) {
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'terminal-copy';
            btn.textContent = 'copy';
            btn.addEventListener('click', function() {
                var text = code.textContent || code.innerText || '';
                var done = function() {
                    btn.textContent = 'copied';
                    btn.classList.add('copied');
                    setTimeout(function() {
                        btn.textContent = 'copy';
                        btn.classList.remove('copied');
                    }, 1600);
                };
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(text).then(done, done);
                } else {
                    var ta = document.createElement('textarea');
                    ta.value = text;
                    document.body.appendChild(ta);
                    ta.select();
                    try { document.execCommand('copy'); } catch (e) {}
                    document.body.removeChild(ta);
                    done();
                }
            });
            return btn;
        }

        // ---- 非 shell 代码：逐行高亮 + 磷光绿行号 ----
        function renderNumberedCode(code, pre) {
            var text = code.textContent || code.innerText || '';
            var lines = text.replace(/\n$/, '').split('\n');
            var lang = 'plaintext';
            var m = code.className.match(/language-(\w+)/);
            if (m && window.hljs && hljs.getLanguage(m[1])) lang = m[1];

            var html = '';
            lines.forEach(function(line) {
                var content;
                if (window.hljs && line.trim().length > 0) {
                    try {
                        content = hljs.highlight(line, { language: lang, ignoreIllegals: true }).value;
                    } catch (e) {
                        content = escapeHtml(line);
                    }
                } else {
                    content = escapeHtml(line) || '&nbsp;';
                }
                html += '<span class="code-line">' + content + '</span>';
            });
            code.innerHTML = html;
            code.classList.add('hljs');
            pre.setAttribute('data-numbered', '1');
        }

        // ---- 代码块终端化 ----
        function terminalizeCodeBlocks() {
            var codeBlocks = document.querySelectorAll('.post-content pre, .page-content pre');

            codeBlocks.forEach(function(pre) {
                if (pre.parentElement && pre.parentElement.classList.contains('code-terminal')) {
                    return;
                }
                var code = pre.querySelector('code');
                if (!code) return;

                var lang = 'text';
                var classMatch = code.className.match(/language-(\w+)/);
                if (classMatch) {
                    lang = classMatch[1];
                } else if (code.className.match(/lang-(\w+)/)) {
                    lang = code.className.match(/lang-(\w+)/)[1];
                }

                var isShell = (lang === 'bash' || lang === 'shell' || lang === 'sh' || lang === 'zsh');

                var terminal = document.createElement('div');
                terminal.className = 'code-terminal';

                var header = document.createElement('div');
                header.className = 'terminal-header';
                var titleText = isShell ? 'guest@cybergeek: ~' : lang;
                header.innerHTML =
                    '<span class="terminal-dot red"></span>' +
                    '<span class="terminal-dot yellow"></span>' +
                    '<span class="terminal-dot green"></span>' +
                    '<span class="terminal-title">' + titleText + '</span>';
                header.appendChild(createCopyButton(code));

                pre.parentNode.insertBefore(terminal, pre);
                terminal.appendChild(header);

                if (isShell) {
                    var terminalBody = document.createElement('div');
                    terminalBody.className = 'terminal-body';
                    renderShellTerminal(code, terminalBody);
                    terminal.appendChild(terminalBody);
                    pre.style.display = 'none'; // 保留在 DOM 中用于复制与降级
                    terminal.appendChild(pre);
                } else {
                    renderNumberedCode(code, pre);
                    terminal.appendChild(pre);
                }
            });
        }

        if (window.hljs) {
            terminalizeCodeBlocks();
        } else {
            var checkHljs = setInterval(function() {
                if (window.hljs) {
                    clearInterval(checkHljs);
                    terminalizeCodeBlocks();
                }
            }, 100);
            setTimeout(function() {
                clearInterval(checkHljs);
                terminalizeCodeBlocks();
            }, 5000);
        }
    })();
    </script>

    <?php $this->footer(); ?>
</body>
</html>
