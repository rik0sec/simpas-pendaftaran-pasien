/* =========================================================
   SIMPAS — main.js
   Dark mode, greeting clock, sidebar toggle (mobile),
   dan helper untuk inisialisasi Chart.js sesuai tema.
   ========================================================= */

(function () {
  const html = document.documentElement;
  const THEME_KEY = 'simpas-theme';

  /* ---------- Dark mode ---------- */
  function applyTheme(theme) {
    html.setAttribute('data-bs-theme', theme);
    const icon = document.getElementById('darkModeIcon');
    if (icon) {
      icon.className = theme === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-stars-fill';
    }
    // beritahu chart (jika ada) supaya warnanya menyesuaikan
    document.dispatchEvent(new CustomEvent('simpas:theme-changed', { detail: { theme } }));
  }

  const savedTheme = localStorage.getItem(THEME_KEY) ||
    (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
  applyTheme(savedTheme);

  const darkToggleBtn = document.getElementById('darkModeToggle');
  if (darkToggleBtn) {
    darkToggleBtn.addEventListener('click', function () {
      const current = html.getAttribute('data-bs-theme');
      const next = current === 'dark' ? 'light' : 'dark';
      localStorage.setItem(THEME_KEY, next);
      applyTheme(next);
    });
  }

  /* ---------- Sidebar toggle (mobile) ---------- */
  const sidebar = document.getElementById('sidebar');
  const sidebarToggle = document.getElementById('sidebarToggle');
  if (sidebarToggle && sidebar) {
    sidebarToggle.addEventListener('click', () => sidebar.classList.toggle('show'));
    document.addEventListener('click', function (e) {
      if (window.innerWidth < 992 && sidebar.classList.contains('show') &&
          !sidebar.contains(e.target) && e.target !== sidebarToggle) {
        sidebar.classList.remove('show');
      }
    });
  }

  /* ---------- Greeting + jam berjalan ---------- */
  function updateGreeting() {
    const labelEl = document.getElementById('greetingLabel');
    const timeEl = document.getElementById('greetingTime');
    if (!labelEl || !timeEl) return;

    const now = new Date();
    const hour = now.getHours();
    let sapaan = 'Selamat malam,';
    if (hour >= 4 && hour < 11) sapaan = 'Selamat pagi,';
    else if (hour >= 11 && hour < 15) sapaan = 'Selamat siang,';
    else if (hour >= 15 && hour < 18) sapaan = 'Selamat sore,';

    labelEl.textContent = sapaan;
    timeEl.textContent = now.toLocaleString('id-ID', {
      weekday: 'long', day: 'numeric', month: 'long', year: 'numeric',
      hour: '2-digit', minute: '2-digit'
    });
  }
  updateGreeting();
  setInterval(updateGreeting, 30000);

  /* ---------- Helper: inisialisasi Chart.js sesuai tema ---------- */
  window.SIMPAS = window.SIMPAS || {};
  window.SIMPAS.chartTheme = function () {
    const isDark = html.getAttribute('data-bs-theme') === 'dark';
    return {
      text: isDark ? '#94a3b8' : '#64748b',
      grid: isDark ? 'rgba(148,163,184,.12)' : 'rgba(100,116,139,.10)',
    };
  };
})();
