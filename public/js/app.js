// ===== Theme Toggle =====
(function() {
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', savedTheme);

    document.addEventListener('DOMContentLoaded', function() {
        const themeToggle = document.getElementById('theme-toggle');
        if (themeToggle) {
            themeToggle.addEventListener('click', function() {
                const current = document.documentElement.getAttribute('data-theme');
                const next = current === 'dark' ? 'light' : 'dark';
                document.documentElement.setAttribute('data-theme', next);
                localStorage.setItem('theme', next);
            });
        }

        // ===== Mobile Sidebar Toggle =====
        const menuToggle = document.getElementById('menu-toggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        
        if (menuToggle && sidebar) {
            menuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('sidebar--open');
                if (overlay) overlay.classList.toggle('sidebar-overlay--active');
            });
        }
        if (overlay) {
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('sidebar--open');
                overlay.classList.remove('sidebar-overlay--active');
            });
        }

        // ===== Auto-dismiss flash messages =====
        const flashMessages = document.querySelectorAll('.alert');
        flashMessages.forEach(function(msg) {
            setTimeout(function() {
                msg.style.opacity = '0';
                msg.style.transform = 'translateY(-10px)';
                setTimeout(function() { msg.remove(); }, 300);
            }, 5000);
        });

        // ===== Close modals on Escape key =====
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('.modal--active').forEach(function(modal) {
                    modal.classList.remove('modal--active');
                });
            }
        });

        // ===== Animate stat card numbers =====
        document.querySelectorAll('.stat-card__value').forEach(function(el) {
            const target = parseInt(el.textContent);
            if (isNaN(target) || target === 0) return;
            let current = 0;
            const step = Math.max(1, Math.ceil(target / 30));
            const interval = setInterval(function() {
                current += step;
                if (current >= target) {
                    current = target;
                    clearInterval(interval);
                }
                el.textContent = current;
            }, 30);
        });
    });
})();
