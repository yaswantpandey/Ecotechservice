/**
 * Ecotech Service — Admin Panel JavaScript
 */

// Sidebar toggle on mobile
const sidebar = document.getElementById('sidebar');
const toggle  = document.getElementById('sidebarToggle');
if (toggle && sidebar) {
  toggle.addEventListener('click', () => {
    sidebar.classList.toggle('-translate-x-full');
  });
  // Close sidebar on outside click (mobile)
  document.addEventListener('click', (e) => {
    if (!sidebar.contains(e.target) && !toggle.contains(e.target)) {
      sidebar.classList.add('-translate-x-full');
    }
  });
}

// Confirm delete with custom message
document.querySelectorAll('[data-confirm]').forEach(el => {
  el.addEventListener('click', (e) => {
    if (!confirm(el.dataset.confirm || 'Are you sure?')) {
      e.preventDefault();
    }
  });
});

// Image preview on file input change
document.querySelectorAll('input[type="file"][accept*="image"]').forEach(input => {
  input.addEventListener('change', () => {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = (e) => {
      let preview = input.nextElementSibling;
      if (!preview || preview.tagName !== 'IMG') {
        preview = document.createElement('img');
        preview.className = 'mt-2 w-32 h-20 object-cover rounded border border-gray-700';
        input.parentNode.insertBefore(preview, input.nextSibling);
      }
      preview.src = e.target.result;
    };
    reader.readAsDataURL(file);
  });
});
