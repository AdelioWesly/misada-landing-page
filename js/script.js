// JavaScript for MISADA Landing Page
document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.getElementById('mainNavbar');

    let lastScrolledState = null;
    let ticking = false;

    const updateNavbarState = () => {
        if (!navbar) return;
        const isScrolled = window.scrollY > 12;
        if (isScrolled !== lastScrolledState) {
            navbar.classList.toggle('scrolled', isScrolled);
            lastScrolledState = isScrolled;
        }
        ticking = false;
    };

    const onScroll = () => {
        if (!ticking) {
            window.requestAnimationFrame(updateNavbarState);
            ticking = true;
        }
    };

    handleInitialState();
    updateNavbarState();

    function handleInitialState() {
        lastScrolledState = window.scrollY > 12;
    }

    window.addEventListener('scroll', onScroll, { passive: true });

    // Smooth scroll for anchor links
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    anchorLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            if (!targetId || targetId === '#') return;
            const target = document.querySelector(targetId);
            if (target) {
                e.preventDefault();
                const navHeight = navbar ? navbar.offsetHeight : 0;
                const top = target.getBoundingClientRect().top + window.pageYOffset - navHeight - 4;
                window.scrollTo({ top, behavior: 'smooth' });
            }
        });
    });

    console.log('MISADA Landing Page loaded successfully');
});
