<?php
$company = setting('company_name', 'J & S Constructions');
$phone1 = setting('phone_1', '075 089 6076');
$phone2 = setting('phone_2', '077 077 0671');
$email = setting('email', 'jsconstructions@gmail.com');
?>
<footer class="mt-24 bg-brand-950 text-white">
  <div class="container-shell grid gap-12 py-16 md:grid-cols-2 lg:grid-cols-4">
    <div class="lg:col-span-2">
      <div class="flex items-center gap-4"><img src="<?= asset('images/logo.jpg') ?>" class="h-16 w-16 rounded-2xl object-cover" alt="<?= e($company) ?>"><div><div class="font-display text-2xl font-bold">J & S CONSTRUCTIONS</div><div class="text-xs font-bold uppercase tracking-[.24em] text-blue-300">Since 1995</div></div></div>
      <p class="mt-5 max-w-xl leading-7 text-slate-300"><?= e(setting('company_description', 'A trusted construction company delivering quality, reliable and efficient building solutions for residential, commercial and infrastructure projects.')) ?></p>
      <div class="mt-6 flex flex-wrap gap-3">
        <a href="<?= whatsapp_link() ?>" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-xl bg-emerald-500 px-5 py-3 font-extrabold text-white hover:bg-emerald-600"><i data-lucide="message-circle" class="h-5 w-5"></i>Chat on WhatsApp</a>
        <a href="tel:<?= e(phone_link($phone1)) ?>" class="inline-flex items-center gap-2 rounded-xl border border-white/15 bg-white/5 px-5 py-3 font-extrabold text-white hover:bg-white/10"><i data-lucide="phone-call" class="h-5 w-5"></i>Call Now</a>
      </div>
    </div>
    <div>
      <h3 class="font-display text-xl font-bold">Quick Links</h3>
      <div class="mt-5 grid gap-3 text-sm text-slate-300"><a href="<?= url('about.php') ?>">About Us</a><a href="<?= url('services.php') ?>">Services</a><a href="<?= url('projects.php') ?>">Projects</a><a href="<?= url('house-designs.php') ?>">House Designs</a><a href="<?= url('quotation.php') ?>">Request a Quotation</a></div>
    </div>
    <div>
      <h3 class="font-display text-xl font-bold">Contact</h3>
      <div class="mt-5 grid gap-4 text-sm text-slate-300">
        <a href="tel:<?= e(phone_link($phone1)) ?>" class="flex gap-3"><i data-lucide="phone" class="h-5 w-5 text-blue-300"></i><span><?= e($phone1) ?><br><?= e($phone2) ?></span></a>
        <a href="mailto:<?= e($email) ?>" class="flex gap-3"><i data-lucide="mail" class="h-5 w-5 text-blue-300"></i><span><?= e($email) ?></span></a>
        <div class="flex gap-3"><i data-lucide="map-pin" class="h-5 w-5 text-blue-300"></i><span><?= e(setting('address', 'Sri Lanka')) ?></span></div>
      </div>
    </div>
  </div>
  <div class="border-t border-white/10"><div class="container-shell flex flex-col gap-2 py-5 text-xs text-slate-400 sm:flex-row sm:items-center sm:justify-between"><p>© <?= date('Y') ?> <?= e($company) ?>. All rights reserved.</p><p>Built for quality, reliability and trust.</p></div></div>
</footer>

<div class="contact-dock" data-contact-dock>
  <div class="contact-dock-actions" data-contact-actions>
    <a href="<?= url('quotation.php') ?>" class="contact-dock-link">
      <span class="contact-dock-label">Request a Quotation</span><span class="contact-dock-icon bg-blue-600"><i data-lucide="file-text" class="h-5 w-5"></i></span>
    </a>
    <a href="tel:<?= e(phone_link($phone1)) ?>" class="contact-dock-link">
      <span class="contact-dock-label">Call <?= e($phone1) ?></span><span class="contact-dock-icon bg-brand-700"><i data-lucide="phone-call" class="h-5 w-5"></i></span>
    </a>
    <a href="<?= whatsapp_link() ?>" target="_blank" rel="noopener" class="contact-dock-link">
      <span class="contact-dock-label">Chat on WhatsApp</span><span class="contact-dock-icon bg-emerald-500"><i data-lucide="message-circle" class="h-5 w-5"></i></span>
    </a>
  </div>
  <button type="button" class="contact-dock-toggle" data-contact-toggle aria-expanded="false"><strong>Contact Us</strong><span><i data-lucide="plus" class="h-5 w-5"></i></span></button>
</div>

<div class="mobile-contact-bar" aria-label="Quick contact">
  <a href="tel:<?= e(phone_link($phone1)) ?>"><i data-lucide="phone-call" class="h-4 w-4"></i>Call</a>
  <a href="<?= whatsapp_link() ?>" target="_blank" rel="noopener"><i data-lucide="message-circle" class="h-4 w-4"></i>WhatsApp</a>
  <a href="<?= url('quotation.php') ?>"><i data-lucide="file-text" class="h-4 w-4"></i>Quotation</a>
</div>
<script src="<?= asset('js/app.js') ?>"></script>
<script>lucide.createIcons();</script>
</body></html>
