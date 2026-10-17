/**
 * Ecotech Service — admin panel JavaScript.
 */
(function () {
  'use strict';

  // Sidebar (mobile): #sidebarToggle opens, overlay / Esc / outside click closes.
  var sidebar = document.getElementById('sidebar');
  var toggle  = document.getElementById('sidebarToggle');
  var overlay = document.getElementById('sidebarOverlay');

  function setOpen(open) {
    if (!sidebar) return;
    sidebar.classList.toggle('is-open', open);
    if (overlay) overlay.classList.toggle('is-open', open);
    if (toggle) toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
  }
  if (toggle && sidebar) {
    toggle.addEventListener('click', function (e) {
      e.stopPropagation();
      setOpen(!sidebar.classList.contains('is-open'));
    });
    document.addEventListener('click', function (e) {
      if (sidebar.classList.contains('is-open') && !sidebar.contains(e.target) && !toggle.contains(e.target)) setOpen(false);
    });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') setOpen(false); });
  }
  if (overlay) overlay.addEventListener('click', function () { setOpen(false); });

  // Confirm before destructive actions: [data-confirm="message"] on links or buttons.
  document.querySelectorAll('[data-confirm]').forEach(function (el) {
    el.addEventListener('click', function (e) {
      if (!confirm(el.dataset.confirm || 'Are you sure?')) e.preventDefault();
    });
  });

  // Image preview for image file inputs.
  document.querySelectorAll('input[type="file"][accept*="image"]').forEach(function (input) {
    input.addEventListener('change', function () {
      var file = input.files && input.files[0];
      if (!file) return;
      var reader = new FileReader();
      reader.onload = function (e) {
        var preview = input.nextElementSibling;
        if (!preview || preview.tagName !== 'IMG') {
          preview = document.createElement('img');
          preview.className = 'a-preview';
          preview.alt = '';
          input.parentNode.insertBefore(preview, input.nextSibling);
        }
        preview.src = e.target.result;
      };
      reader.readAsDataURL(file);
    });
  });
})();
