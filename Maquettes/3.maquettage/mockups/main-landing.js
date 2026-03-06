// Simple Landing Scroll Logic
document.addEventListener('DOMContentLoaded', function () {
    const navbar = document.getElementById('navbar');

    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            navbar.classList.add('shadow-xl', 'bg-white/95');
        } else {
            navbar.classList.remove('shadow-xl', 'bg-white/95');
        }
    });

    // Smooth appearance for stats
    const stats = document.querySelectorAll('.sd-stat');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('opacity-100', 'translate-y-0');
                entry.target.classList.remove('opacity-0', 'translate-y-10');
            }
        });
    }, { threshold: 0.1 });

    stats.forEach(stat => {
        stat.classList.add('opacity-0', 'translate-y-10', 'transition-all', 'duration-700');
        observer.observe(stat);
    });
});
