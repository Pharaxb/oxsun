// Sidebar & Page Navigation
const bodyEl = document.body;
const sidebarNav = document.getElementById('sidebar-nav');
const pageContents = document.querySelectorAll('.page-content');
const sidebarToggleBtn = document.getElementById('sidebar-toggle');
const sidebarOverlay = document.getElementById('sidebar-overlay');

// Main toggle button logic for all screen sizes
sidebarToggleBtn.addEventListener('click', () => {
    bodyEl.classList.toggle('sidebar-collapsed');
});

// Overlay click should only collapse the sidebar
sidebarOverlay.addEventListener('click', () => {
    bodyEl.classList.add('sidebar-collapsed');
});

// Navigation link click logic
/*sidebarNav.addEventListener('click', (e) => {
    e.preventDefault();
    const link = e.target.closest('.nav-link');
    if (!link) return;

    // Update active link
    sidebarNav.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
    link.classList.add('active');

    // Show selected page
    const pageId = 'page-' + link.dataset.page;
    pageContents.forEach(page => {
        page.classList.toggle('d-none', page.id !== pageId);
    });

    // On mobile, also close the sidebar after clicking a link
    if (window.innerWidth < 992) {
        bodyEl.classList.add('sidebar-collapsed');
    }
});*/

// Collapse sidebar on mobile by default for better initial view
if (window.innerWidth < 992) {
    bodyEl.classList.add('sidebar-collapsed');
}
