<?php
require __DIR__ . '/includes/bootstrap.php';
$meta = page_meta('House Designs', 'Explore modern, luxury, single-storey, two-storey and custom house design concepts from J & S Constructions.');
$category = trim($_GET['category'] ?? '');
$sql = "SELECT * FROM house_designs WHERE status='published'";
$params=[];
if($category!==''){ $sql.=' AND category=?'; $params[]=$category; }
$sql.=' ORDER BY is_featured DESC,id DESC';
$stmt=db()->prepare($sql);$stmt->execute($params);$houses=$stmt->fetchAll();
$categories=db()->query("SELECT DISTINCT category FROM house_designs WHERE status='published' ORDER BY category")->fetchAll(PDO::FETCH_COLUMN);
require __DIR__ . '/includes/header.php';
?>
<main>
<section class="page-hero py-24 text-white"><img src="<?= upload_url('library/house-azure-residence.jpg') ?>" alt="House design concepts"><div class="container-shell relative z-10"><span class="section-kicker !text-blue-300">House Design Catalogue</span><h1 class="mt-5 max-w-4xl font-display text-5xl font-bold uppercase sm:text-7xl">Find A Design That Feels Like Home</h1><p class="mt-6 max-w-2xl text-lg leading-8 text-slate-300">Flexible concepts that can be adapted to your land, lifestyle, budget and personal taste.</p></div></section>
<section class="py-16"><div class="container-shell"><div class="flex flex-wrap gap-3"><?php foreach(array_merge([''],$categories) as $item): ?><a href="<?= url('house-designs.php'.($item!==''?'?category='.urlencode($item):'')) ?>" class="rounded-full px-5 py-3 text-sm font-extrabold <?= $category===$item?'bg-brand-700 text-white':'bg-slate-100 text-slate-700 hover:bg-brand-50 hover:text-brand-700' ?>"><?= e($item===''?'All Designs':$item) ?></a><?php endforeach; ?></div>
<div class="mt-10 grid gap-7 md:grid-cols-2 lg:grid-cols-3"><?php foreach($houses as $house): ?><article class="card-lift reveal overflow-hidden rounded-[1.75rem] border border-slate-200 bg-white"><a class="image-zoom block" href="<?= url('house-details.php?slug=' . urlencode($house['slug'])) ?>"><img src="<?= upload_url($house['image']) ?>" class="aspect-[4/3] w-full object-cover" alt="<?= e($house['title']) ?>"></a><div class="p-6"><div class="text-xs font-extrabold uppercase tracking-wider text-brand-700"><?= e($house['category']) ?></div><h2 class="mt-3 font-display text-2xl font-bold uppercase text-brand-950"><a href="<?= url('house-details.php?slug=' . urlencode($house['slug'])) ?>"><?= e($house['title']) ?></a></h2><div class="mt-5 grid grid-cols-3 gap-2 text-center text-xs font-bold text-slate-600"><div class="rounded-xl bg-slate-50 p-3"><i data-lucide="bed-double" class="mx-auto mb-1 h-5 w-5 text-brand-700"></i><?= (int)$house['bedrooms'] ?> Beds</div><div class="rounded-xl bg-slate-50 p-3"><i data-lucide="bath" class="mx-auto mb-1 h-5 w-5 text-brand-700"></i><?= (int)$house['bathrooms'] ?> Baths</div><div class="rounded-xl bg-slate-50 p-3"><i data-lucide="maximize" class="mx-auto mb-1 h-5 w-5 text-brand-700"></i><?= number_format((float)$house['area_sqft']) ?> sqft</div></div></div></article><?php endforeach; ?></div>
<?php if(!$houses): ?><div class="mt-12 rounded-3xl bg-slate-50 p-12 text-center"><h2 class="text-xl font-extrabold text-brand-950">No designs found</h2><p class="mt-2 text-slate-600">New concepts will be added soon.</p></div><?php endif; ?></div></section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
