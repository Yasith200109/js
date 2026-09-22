document.addEventListener('DOMContentLoaded', () => {
  const menuBtn = document.querySelector('[data-menu-button]');
  const mobileMenu = document.querySelector('[data-mobile-menu]');
  menuBtn?.addEventListener('click', () => mobileMenu?.classList.toggle('hidden'));

  const header = document.querySelector('[data-header]');
  const updateHeader = () => header?.classList.toggle('shadow-lg', window.scrollY > 20);
  updateHeader();
  window.addEventListener('scroll', updateHeader, { passive: true });

  if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver(entries => entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      }
    }), { threshold: .12 });
    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
  } else {
    document.querySelectorAll('.reveal').forEach(el => el.classList.add('visible'));
  }

  document.querySelectorAll('[data-filter]').forEach(btn => btn.addEventListener('click', () => {
    const value = btn.dataset.filter;
    document.querySelectorAll('[data-filter]').forEach(x => x.classList.remove('bg-blue-700', 'text-white'));
    btn.classList.add('bg-blue-700', 'text-white');
    document.querySelectorAll('[data-filter-item]').forEach(item => {
      item.classList.toggle('hidden', value !== 'all' && item.dataset.filterItem !== value);
    });
  }));

  document.querySelectorAll('[data-confirm]').forEach(form => form.addEventListener('submit', e => {
    if (!confirm(form.dataset.confirm || 'Are you sure?')) e.preventDefault();
  }));

  const contactDock = document.querySelector('[data-contact-dock]');
  const contactToggle = document.querySelector('[data-contact-toggle]');
  contactToggle?.addEventListener('click', () => {
    const isOpen = contactDock?.classList.toggle('is-open') ?? false;
    contactToggle.setAttribute('aria-expanded', String(isOpen));
  });
  document.addEventListener('click', event => {
    if (contactDock && !contactDock.contains(event.target)) {
      contactDock.classList.remove('is-open');
      contactToggle?.setAttribute('aria-expanded', 'false');
    }
  });

  const galleryItems = Array.from(document.querySelectorAll('[data-gallery-image]'));
  const lightbox = document.querySelector('[data-lightbox]');
  const lightboxImage = lightbox?.querySelector('[data-lightbox-image]');
  const lightboxCount = lightbox?.querySelector('[data-lightbox-count]');
  let currentIndex = 0;

  const showLightboxImage = index => {
    if (!galleryItems.length || !lightbox || !lightboxImage) return;
    currentIndex = (index + galleryItems.length) % galleryItems.length;
    const source = galleryItems[currentIndex].dataset.galleryImage;
    const alt = galleryItems[currentIndex].dataset.galleryAlt || 'Project gallery image';
    lightboxImage.src = source;
    lightboxImage.alt = alt;
    if (lightboxCount) lightboxCount.textContent = `${currentIndex + 1} / ${galleryItems.length}`;
  };

  const openLightbox = index => {
    showLightboxImage(index);
    lightbox?.classList.add('is-open');
    document.body.style.overflow = 'hidden';
  };

  const closeLightbox = () => {
    lightbox?.classList.remove('is-open');
    document.body.style.overflow = '';
  };

  galleryItems.forEach((item, index) => {
    item.addEventListener('click', event => {
      event.preventDefault();
      openLightbox(index);
    });
  });
  lightbox?.querySelector('[data-lightbox-close]')?.addEventListener('click', closeLightbox);
  lightbox?.querySelector('[data-lightbox-prev]')?.addEventListener('click', () => showLightboxImage(currentIndex - 1));
  lightbox?.querySelector('[data-lightbox-next]')?.addEventListener('click', () => showLightboxImage(currentIndex + 1));
  lightbox?.addEventListener('click', event => {
    if (event.target === lightbox) closeLightbox();
  });
  document.addEventListener('keydown', event => {
    if (!lightbox?.classList.contains('is-open')) return;
    if (event.key === 'Escape') closeLightbox();
    if (event.key === 'ArrowLeft') showLightboxImage(currentIndex - 1);
    if (event.key === 'ArrowRight') showLightboxImage(currentIndex + 1);
  });
});
