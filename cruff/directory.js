(() => {
  const directory = document.getElementById('sb-directory');
  const entries = [...directory.querySelectorAll('.sb-entry')];
  const openKey = 'sbshell-open:' + location.pathname;
  let saved = [];
  try { saved = JSON.parse(sessionStorage.getItem(openKey) || '[]'); } catch {}
  function loadMedia(entry) {
    if (!entry.open) return;
    entry.querySelectorAll('[data-src]').forEach(media => {
      if (media.tagName === 'OBJECT' && navigator.pdfViewerEnabled === false) media.classList.add('sb-pdf-fallback');
      media.setAttribute(media.tagName === 'OBJECT' ? 'data' : 'src', media.dataset.src);
      delete media.dataset.src;
    });
  }
  function remember() {
    try { sessionStorage.setItem(openKey, JSON.stringify(entries.filter(entry => entry.open).map(entry => entry.dataset.file))); } catch {}
  }
  entries.forEach(entry => {
    entry.open = Array.isArray(saved) && saved.includes(entry.dataset.file);
    loadMedia(entry);
    entry.addEventListener('toggle', () => { loadMedia(entry); remember(); });
  });
  if (entries.length) {
    directory.querySelector('.sb-file-controls').hidden = false;
    document.getElementById('sb-expand-all').addEventListener('click', () => {
      entries.forEach(entry => { entry.open = true; loadMedia(entry); });
      remember();
    });
    document.getElementById('sb-collapse-all').addEventListener('click', () => {
      entries.forEach(entry => { entry.open = false; });
      remember();
    });
  }

  const refresh = document.getElementById('auto-refresh');
  const key = 'sbshell-refresh:' + location.pathname;
  const refreshUrl = new URL(location.href);
  refreshUrl.searchParams.set('sb-refresh', '1');
  let timer, controller;
  try { refresh.checked = localStorage.getItem(key) !== 'off'; } catch {}
  async function check() {
    if (!refresh.checked) return;
    controller = new AbortController();
    try {
      const response = await fetch(refreshUrl, {cache:'no-store', signal:controller.signal});
      if (response.ok) {
        const result = await response.json();
        if (refresh.checked && result.stamp && result.stamp !== refresh.dataset.stamp) {
          remember();
          location.reload();
          return;
        }
      }
    } catch { /* Keep the current page when the local server is unavailable. */ }
    finally { controller = null; schedule(); }
  }
  function schedule() {
    clearTimeout(timer);
    if (refresh.checked && refresh.dataset.stamp && /^https?:$/.test(location.protocol)) timer = setTimeout(check, 10000);
  }
  refresh.addEventListener('change', () => {
    controller?.abort();
    try { localStorage.setItem(key, refresh.checked ? 'on' : 'off'); } catch {}
    schedule();
  });
  schedule();
})();
