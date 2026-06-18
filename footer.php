<?php
/**
 * CyberGeek Theme Footer - Geek Style + Warm Colors
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
?>
    </main>

    <button class="back-to-top" id="backToTop" aria-label="回到顶部">↑</button>

    <footer class="site-footer">
        <div class="container">
            <div class="footer-content">
                <p>&copy; <?php echo date('Y'); ?> <a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title(); ?></a>. All rights reserved.</p>
                <p class="footer-beian">
                    <a href="https://beian.miit.gov.cn/" target="_blank" rel="noopener">沪ICP备2026023383号-1</a>
                    <span class="beian-sep">|</span>
                    <img src="https://beian.mps.gov.cn/web/assets/logo01.6189a29f.png" alt="" class="beian-icon">
                    <a href="https://www.beian.gov.cn/portal/registerSystemInfo?recordcode=31010702010416" target="_blank" rel="noopener">沪公网安备31010702010416号</a>
                </p>
            </div>
        </div>
    </footer>

    <!-- Highlight.js for syntax highlighting -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github-dark.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/php.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/css.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/python.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/bash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/sql.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/json.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/xml.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/yaml.min.js"></script>

    <script>
    (function() {
        'use strict';

        // 导航栏滚动效果
        var nav = document.getElementById('siteNav');
        var scrollThreshold = 50;

        function updateNav() {
            if (window.scrollY > scrollThreshold) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        }

        window.addEventListener('scroll', updateNav, { passive: true });
        updateNav();

        // 移动端菜单切换
        var menuToggle = document.getElementById('menuToggle');
        var navMenu = document.getElementById('navMenu');

        if (menuToggle && navMenu) {
            menuToggle.addEventListener('click', function() {
                menuToggle.classList.toggle('active');
                navMenu.classList.toggle('active');
            });

            var menuLinks = navMenu.querySelectorAll('a');
            menuLinks.forEach(function(link) {
                link.addEventListener('click', function() {
                    menuToggle.classList.remove('active');
                    navMenu.classList.remove('active');
                });
            });
        }

        // 回到顶部按钮
        var backToTop = document.getElementById('backToTop');
        var backToTopThreshold = 300;

        function updateBackToTop() {
            if (window.scrollY > backToTopThreshold) {
                backToTop.classList.add('visible');
            } else {
                backToTop.classList.remove('visible');
            }
        }

        window.addEventListener('scroll', updateBackToTop, { passive: true });
        updateBackToTop();

        backToTop.addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // Shell 终端化渲染：将代码按行分析，渲染为 404 同款终端风格
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

                // Error line
                if (trimmed.match(/^(Error|error|ERROR|ERR|WARN|WARNING|FATAL|FAIL|Failed|failed)\b/)) {
                    html += '<div class="terminal-line">' + indent + '<span class="terminal-error">' + escapeHtml(trimmed) + '</span></div>';
                    return;
                }

                // Shell prompt: [user@host path]# command or [user@host path]$ command
                var promptMatch = trimmed.match(/^(\[.*?@.*?\].*?[#$])(\s+.*)?$/);
                if (promptMatch) {
                    var prompt = escapeHtml(promptMatch[1]);
                    var command = promptMatch[2] ? escapeHtml(promptMatch[2]) : '';
                    html += '<div class="terminal-line">' + indent +
                        '<span class="terminal-prompt">' + prompt + '</span>' +
                        (command ? '<span class="terminal-command">' + command + '</span>' : '') +
                        '</div>';
                    return;
                }

                // Simple $ prompt: $ command
                var simplePromptMatch = trimmed.match(/^(\$)(\s+.*)?$/);
                if (simplePromptMatch) {
                    var sprompt = escapeHtml(simplePromptMatch[1]);
                    var scmd = simplePromptMatch[2] ? escapeHtml(simplePromptMatch[2]) : '';
                    html += '<div class="terminal-line">' + indent +
                        '<span class="terminal-prompt">' + sprompt + '</span>' +
                        (scmd ? '<span class="terminal-command">' + scmd + '</span>' : '') +
                        '</div>';
                    return;
                }

                // Comment line starting with #
                if (trimmed.match(/^#/)) {
                    html += '<div class="terminal-line">' + indent + '<span class="terminal-comment">' + escapeHtml(trimmed) + '</span></div>';
                    return;
                }

                // Default: output
                html += '<div class="terminal-line">' + indent + '<span class="terminal-output">' + escapeHtml(trimmed) + '</span></div>';
            });

            terminalBody.innerHTML = html;
        }

        function escapeHtml(text) {
            var div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // 代码块终端化 + 高亮
        function terminalizeCodeBlocks() {
            var codeBlocks = document.querySelectorAll('.post-content pre, .page-content pre');
            
            codeBlocks.forEach(function(pre) {
                // Skip if already processed
                if (pre.parentElement && pre.parentElement.classList.contains('code-terminal')) {
                    return;
                }

                var code = pre.querySelector('code');
                if (!code) return;

                // Detect language from class
                var lang = 'text';
                var classMatch = code.className.match(/language-(\w+)/);
                if (classMatch) {
                    lang = classMatch[1];
                } else if (code.className.match(/lang-(\w+)/)) {
                    lang = code.className.match(/lang-(\w+)/)[1];
                }

                var isShell = (lang === 'bash' || lang === 'shell' || lang === 'sh' || lang === 'zsh');

                // Create terminal wrapper
                var terminal = document.createElement('div');
                terminal.className = 'code-terminal';

                // Terminal header
                var header = document.createElement('div');
                header.className = 'terminal-header';
                var titleText = isShell ? 'kjifds@cybergeek: ~' : lang;
                header.innerHTML = 
                    '<span class="terminal-dot red"></span>' +
                    '<span class="terminal-dot yellow"></span>' +
                    '<span class="terminal-dot green"></span>' +
                    '<span class="terminal-title">' + titleText + '</span>';

                // For shell blocks: replace pre with terminal-body div
                if (isShell) {
                    // Create terminal body
                    var terminalBody = document.createElement('div');
                    terminalBody.className = 'terminal-body';
                    renderShellTerminal(code, terminalBody);

                    // Replace pre with terminal structure
                    pre.parentNode.insertBefore(terminal, pre);
                    terminal.appendChild(header);
                    terminal.appendChild(terminalBody);
                    pre.style.display = 'none';
                    // Keep pre in DOM for accessibility/fallback, but hide it
                    terminal.appendChild(pre);
                } else {
                    // Non-shell: standard terminal wrapper + highlight.js
                    pre.parentNode.insertBefore(terminal, pre);
                    terminal.appendChild(header);
                    terminal.appendChild(pre);

                    // Apply highlight.js
                    if (window.hljs && !code.classList.contains('hljs')) {
                        hljs.highlightElement(code);
                    }
                }
            });
        }

        // Run terminalize after highlight.js loads
        if (window.hljs) {
            hljs.configure({ ignoreUnescapedHTML: true });
            terminalizeCodeBlocks();
        } else {
            // Wait for highlight.js to load
            var checkHljs = setInterval(function() {
                if (window.hljs) {
                    clearInterval(checkHljs);
                    hljs.configure({ ignoreUnescapedHTML: true });
                    terminalizeCodeBlocks();
                }
            }, 100);
            // Timeout after 5 seconds
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
