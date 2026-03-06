/* ══════════════════════════════════════════
   SMARTDRESS — main.js
   Interactions & UI behaviors
══════════════════════════════════════════ */

document.addEventListener('DOMContentLoaded', () => {

  /* ── 1. Navbar scroll shadow ── */
  const navbar = document.getElementById('navbar');

  const onScroll = () => {
    if (window.scrollY > 20) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }
  };

  window.addEventListener('scroll', onScroll, { passive: true });


  /* ── 2. Smooth active navlink highlight ── */
  const sections  = document.querySelectorAll('section[id]');
  const navLinks  = document.querySelectorAll('.sd-navlink');

  const highlightNav = () => {
    let current = '';
    sections.forEach(section => {
      const top = section.offsetTop - 100;
      if (window.scrollY >= top) current = section.getAttribute('id');
    });

    navLinks.forEach(link => {
      link.style.opacity = link.getAttribute('href') === `#${current}` ? '1' : '';
    });
  };

  window.addEventListener('scroll', highlightNav, { passive: true });


  /* ── 3. Intersection Observer — fade-up on scroll ── */
  const observerOptions = {
    threshold: 0.15,
    rootMargin: '0px 0px -40px 0px',
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      }
    });
  }, observerOptions);

  // Add observe-me class to feature cards and testimonials
  document.querySelectorAll('.sd-feat-card, .sd-testimonial, .sd-stat').forEach(el => {
    el.classList.add('observe-me');
    observer.observe(el);
  });


  /* ── 4. Feature cards stagger delay ── */
  document.querySelectorAll('.sd-feat-card').forEach((card, i) => {
    card.style.transitionDelay = `${i * 60}ms`;
  });


  /* ── 5. Typing effect on hero title ── */
  // subtle: just ensure animation plays on load
  const heroTitle = document.querySelector('.sd-hero-title');
  if (heroTitle) {
    heroTitle.style.animationPlayState = 'running';
  }


  /* ── 6. Mobile menu: close on link click ── */
  const mobileMenu  = document.getElementById('mobile-menu');
  const mobileLinks = mobileMenu ? mobileMenu.querySelectorAll('a') : [];

  mobileLinks.forEach(link => {
    link.addEventListener('click', () => {
      // Trigger Preline collapse close
      if (window.HSCollapse) {
        const instance = window.HSCollapse.getInstance(mobileMenu);
        if (instance) instance.hide();
      }
    });
  });


  /* ── 7. CTA button ripple effect ── */
  document.querySelectorAll('.sd-btn-primary').forEach(btn => {
    btn.addEventListener('click', function (e) {
      const rect   = this.getBoundingClientRect();
      const ripple = document.createElement('span');
      const size   = Math.max(rect.width, rect.height);

      ripple.style.cssText = `
        position: absolute;
        width: ${size}px;
        height: ${size}px;
        top: ${e.clientY - rect.top  - size / 2}px;
        left: ${e.clientX - rect.left - size / 2}px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        transform: scale(0);
        animation: ripple 0.5s ease-out;
        pointer-events: none;
      `;

      this.style.position = 'relative';
      this.style.overflow  = 'hidden';
      this.appendChild(ripple);

      setTimeout(() => ripple.remove(), 500);
    });
  });

});


/* ── CSS injected by JS for dynamic effects ── */
const dynamicStyles = document.createElement('style');
dynamicStyles.textContent = `
  .observe-me {
    opacity: 0;
    transform: translateY(24px);
    transition: opacity 0.6s ease, transform 0.6s ease;
  }
  .observe-me.visible {
    opacity: 1;
    transform: translateY(0);
  }
  @keyframes ripple {
    to { transform: scale(2.5); opacity: 0; }
  }
`;
document.head.appendChild(dynamicStyles);
