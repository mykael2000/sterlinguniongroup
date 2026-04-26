 // --- Hamburger Menu Script ---
const menuBtn = document.getElementById('menu-btn');
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('overlay');
const closeMenuBtn = document.getElementById('close-menu-btn');

function toggleMenu() {
    sidebar.classList.toggle('translate-x-full');
    overlay.classList.toggle('hidden');
}

// Event listeners for the menu button and overlay
menuBtn.addEventListener('click', toggleMenu);
overlay.addEventListener('click', toggleMenu);
closeMenuBtn.addEventListener('click', toggleMenu);