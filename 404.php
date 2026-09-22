<?php
require_once __DIR__ . '/includes/bootstrap.php';
$meta=page_meta('Page Not Found','The requested page could not be found.');
require __DIR__ . '/includes/header.php';
?>
<main class="grid min-h-[60vh] place-items-center px-6 py-24 text-center"><div><div class="font-display text-8xl font-bold text-blue-100">404</div><h1 class="mt-2 font-display text-4xl font-bold uppercase text-brand-950">Page Not Found</h1><p class="mt-4 text-slate-600">The page may have moved or the link may be incorrect.</p><a href="<?= url() ?>" class="mt-7 inline-flex rounded-xl bg-brand-700 px-6 py-3 font-extrabold text-white">Back to Home</a></div></main>
<?php require __DIR__ . '/includes/footer.php'; ?>
