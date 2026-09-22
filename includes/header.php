<?php
$meta = $meta ?? page_meta('Home');
$page = basename($_SERVER['SCRIPT_NAME'] ?? 'index.php');
$company = setting('company_name', 'J & S Constructions');
$phone1 = setting('phone_1', '075 089 6076');
$phone2 = setting('phone_2', '077 077 0671');
$email = setting('email', 'jsconstructions@gmail.com');
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($meta['title']) ?></title>
  <meta name="description" content="<?= e($meta['description']) ?>">
  <meta name="theme-color" content="#09064f">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Oswald:wght@500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>tailwind.config={theme:{extend:{colors:{brand:{950:'#09064f',800:'#0d1d6a',700:'#075bb8',500:'#0b8ee8',50:'#eef7ff'}}}}}</script>
  <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
  <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="antialiased">
<div class="bg-brand-950 text-white">
  <div class="container-shell flex min-h-10 items-center justify-between gap-4 py-2 text-xs font-semibold">
    <p class="hidden sm:block">Building dreams with confidence since 1995.</p>
    <div class="ml-auto flex items-center gap-4">
      <a class="hover:text-blue-300" href="tel:<?= e(phone_link($phone1)) ?>"><span class="hidden sm:inline"><?= e($phone1) ?></span><span class="sm:hidden">Call Us</span></a>
      <span class="text-white/30">|</span>
      <a class="hover:text-blue-300" href="mailto:<?= e($email) ?>"><?= e($email) ?></a>
    </div>
  </div>
</div>
<header data-header class="sticky top-0 z-50 border-b border-slate-100 bg-white/95 backdrop-blur transition-shadow">
  <div class="container-shell flex h-20 items-center justify-between gap-6">
    <a href="<?= url() ?>" class="flex items-center gap-3">
      <img src="<?= asset('images/logo.jpg') ?>" alt="<?= e($company) ?>" class="h-14 w-14 rounded-xl object-cover">
      <div class="hidden sm:block leading-tight"><div class="font-display text-xl font-bold tracking-wide text-brand-950">J & S CONSTRUCTIONS</div><div class="text-[10px] font-bold uppercase tracking-[.28em] text-brand-700">Since 1995</div></div>
    </a>
    <nav class="hidden items-center gap-6 text-sm font-bold lg:flex">
      <?php foreach ([
        'index.php'=>'Home','about.php'=>'About','services.php'=>'Services','projects.php'=>'Projects','house-designs.php'=>'House Designs','gallery.php'=>'Gallery','contact.php'=>'Contact'
      ] as $file=>$label): ?>
      <a class="nav-link <?= $page === $file ? 'active text-brand-700' : 'text-slate-700' ?>" href="<?= url($file === 'index.php' ? '' : $file) ?>"><?= e($label) ?></a>
      <?php endforeach; ?>
    </nav>
    <div class="hidden items-center gap-3 lg:flex">
      <a href="tel:<?= e(phone_link($phone1)) ?>" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-extrabold text-brand-950 transition hover:border-blue-200 hover:bg-brand-50"><i data-lucide="phone-call" class="h-4 w-4 text-brand-700"></i>Call Now</a>
      <a href="<?= url('quotation.php') ?>" class="inline-flex items-center gap-2 rounded-xl bg-brand-700 px-5 py-3 text-sm font-extrabold text-white shadow-lg shadow-blue-700/20 transition hover:bg-brand-950"><i data-lucide="file-text" class="h-4 w-4"></i>Get a Quote</a>
    </div>
    <button data-menu-button class="grid h-11 w-11 place-items-center rounded-xl border border-slate-200 lg:hidden" aria-label="Open menu"><i data-lucide="menu"></i></button>
  </div>
  <div data-mobile-menu class="hidden border-t border-slate-100 bg-white lg:hidden">
    <nav class="container-shell grid gap-1 py-4 text-sm font-bold">
      <?php foreach ([
        'index.php'=>'Home','about.php'=>'About Us','services.php'=>'Services','projects.php'=>'Projects','house-designs.php'=>'House Designs','gallery.php'=>'Gallery','contact.php'=>'Contact Us','quotation.php'=>'Request a Quotation'
      ] as $file=>$label): ?>
      <a class="rounded-xl px-4 py-3 hover:bg-brand-50 hover:text-brand-700" href="<?= url($file === 'index.php' ? '' : $file) ?>"><?= e($label) ?></a>
      <?php endforeach; ?>
    </nav>
  </div>
</header>
<?php foreach (flashes() as $notice): ?>
<div class="toast fixed right-4 top-28 z-[60] max-w-sm rounded-2xl border px-5 py-4 shadow-xl <?= $notice['type']==='error'?'border-red-200 bg-red-50 text-red-800':'border-emerald-200 bg-emerald-50 text-emerald-800' ?>"><?= e($notice['message']) ?></div>
<?php endforeach; ?>
