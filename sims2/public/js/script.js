function logoutUser() {
    document.querySelector('form[action*="logout"]').submit();
}

function checkSession() {
    return true;
}

function setInventoryFilter(filter) {
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.toggle('active', btn.textContent.trim() === (filter === 'all' ? 'All Items' : filter.replace('-', ' ').replace(/\b\w/g, c => c.toUpperCase())));
    });

    document.querySelectorAll('#inventory-table tbody tr').forEach(row => {
        const category = row.dataset.category;
        const stock = Number(row.dataset.stock);

        if (filter === 'all') {
            row.style.display = '';
            return;
        }

        if (filter === 'low-stock') {
            row.style.display = stock < 20 ? '' : 'none';
            return;
        }

        row.style.display = category === filter ? '' : 'none';
    });
}

function handleInventoryAction(action, itemId) {
    const actionText = action === 'edit' ? 'Edit' : 'Delete';
    alert(`${actionText} action for item ${itemId} is ready. This can be connected to a real form or route.`);
}

function refreshReports() {
    alert('Reports refreshed successfully. Charts are updated with the latest sample data.');
}

function exportReport(type) {
    alert(`Report exported as ${type.toUpperCase()}.`);
}
