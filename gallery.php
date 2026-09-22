<?php
require __DIR__ . '/includes/bootstrap.php';
$meta=page_meta('Gallery','View construction, interior, residential and commercial project images from J & S Constructions.');
$items=db()->query("SELECT * FROM gallery WHERE is_active=1 ORDER BY sort_order,id DESC")->fetchAll();
$categories=db()->query("SELECT DISTINCT category FROM gallery WHERE is_active=1 ORDER BY category")->fetchAll(PDO::FETCH_COLUMN);
require __DIR__ . '/includes/header.php';
?>
<main>
<section class="page-hero py-24 text-white"><img src="<?= upload_url('library/gallery-premium-interior.jpg') ?>" alt="Gallery images"><div class="container-shell relative z-10"><span class="section-kicker !text-blue-300">Gallery</span><h1 class="mt-5 font-display text-5xl font-bold uppercase sm:text-7xl">Details From The Worksite To The Finish</h1><p class="mt-6 max-w-2xl text-lg leading-8 text-slate-300">A visual collection of construction progress, completed spaces and architectural details.</p></div></section>
<section class="py-16"><div class="container-shell"><div class="flex flex-wrap gap-3"><button data-filter="all" class="rounded-full bg-brand-700 px-5 py-3 text-sm font-extrabold text-white">All</button><?php foreach($categories as $category): ?><button data-filter="<?= e($category) ?>" class="rounded-full bg-slate-100 px-5 py-3 text-sm font-extrabold text-slate-700"><?= e($category) ?></button><?php endforeach; ?></div><div class="mt-10 columns-1 gap-5 sm:columns-2 lg:columns-3"><?php foreach($items as $item): ?><figure data-filter-item="<?= e($item['category']) ?>" class="reveal mb-5 break-inside-avoid overflow-hidden rounded-3xl bg-slate-100"><img src="<?= upload_url($item['image_path']) ?>" alt="<?= e($item['title']) ?>" class="w-full object-cover"><figcaption class="p-5"><div class="text-xs font-extrabold uppercase tracking-wider text-brand-700"><?= e($item['category']) ?></div><div class="mt-1 font-extrabold text-brand-950"><?= e($item['title']) ?></div></figcaption></figure><?php endforeach; ?></div></div></section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
