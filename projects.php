<?php
require __DIR__ . '/includes/bootstrap.php';
$meta = page_meta('Projects', 'Browse completed and ongoing residential, commercial and infrastructure projects by J & S Constructions.');
$category = trim($_GET['category'] ?? '');
$status = trim($_GET['project_status'] ?? '');
$sql = "SELECT * FROM projects WHERE status='published'";
$params = [];
if ($category !== '') { $sql .= ' AND category=?'; $params[] = $category; }
if ($status !== '') { $sql .= ' AND project_status=?'; $params[] = $status; }
$sql .= ' ORDER BY is_featured DESC, completed_year DESC, id DESC';
$stmt = db()->prepare($sql); $stmt->execute($params); $projects = $stmt->fetchAll();
$categories = db()->query("SELECT DISTINCT category FROM projects WHERE status='published' ORDER BY category")->fetchAll(PDO::FETCH_COLUMN);
require __DIR__ . '/includes/header.php';
?>
<main>
<section class="page-hero py-24 text-white"><img src="<?= upload_url('library/project-contemporary-family-residence.jpg') ?>" alt="J & S Construction projects"><div class="container-shell relative z-10"><span class="section-kicker !text-blue-300">Project Portfolio</span><h1 class="mt-5 max-w-4xl font-display text-5xl font-bold uppercase sm:text-7xl">Spaces Designed To Last</h1><p class="mt-6 max-w-2xl text-lg leading-8 text-slate-300">Explore a selection of residential, commercial and infrastructure work delivered with care.</p></div></section>
<section class="py-16"><div class="container-shell"><form class="flex flex-wrap gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm"><select name="category" class="form-input max-w-xs"><option value="">All Categories</option><?php foreach($categories as $item): ?><option <?= $category===$item?'selected':'' ?>><?= e($item) ?></option><?php endforeach; ?></select><select name="project_status" class="form-input max-w-xs"><option value="">All Statuses</option><option value="Completed" <?= $status==='Completed'?'selected':'' ?>>Completed</option><option value="Ongoing" <?= $status==='Ongoing'?'selected':'' ?>>Ongoing</option></select><button class="rounded-xl bg-brand-700 px-6 py-3 font-extrabold text-white">Filter Projects</button><a href="<?= url('projects.php') ?>" class="rounded-xl bg-slate-100 px-6 py-3 font-extrabold text-slate-700">Reset</a></form>
<div class="mt-10 grid gap-7 md:grid-cols-2 lg:grid-cols-3"><?php foreach($projects as $project): ?><article class="group reveal overflow-hidden rounded-[1.75rem] border border-slate-200 bg-white"><a href="<?= url('project-details.php?slug=' . urlencode($project['slug'])) ?>" class="image-zoom relative block"><img src="<?= upload_url($project['cover_image']) ?>" alt="<?= e($project['title']) ?>" class="aspect-[4/3] w-full object-cover"><span class="absolute left-4 top-4 rounded-full bg-white/90 px-3 py-1 text-xs font-extrabold text-brand-950 backdrop-blur"><?= e($project['project_status']) ?></span></a><div class="p-6"><div class="text-xs font-extrabold uppercase tracking-wider text-brand-700"><?= e($project['category']) ?></div><h2 class="mt-3 font-display text-2xl font-bold uppercase text-brand-950"><a href="<?= url('project-details.php?slug=' . urlencode($project['slug'])) ?>"><?= e($project['title']) ?></a></h2><div class="mt-4 flex items-center justify-between text-sm text-slate-500"><span class="flex items-center gap-2"><i data-lucide="map-pin" class="h-4 w-4"></i><?= e($project['location']) ?></span><span><?= e($project['completed_year']) ?></span></div></div></article><?php endforeach; ?></div>
<?php if(!$projects): ?><div class="mt-12 rounded-3xl bg-slate-50 p-12 text-center"><h2 class="text-xl font-extrabold text-brand-950">No projects found</h2><p class="mt-2 text-slate-600">Try changing the selected filters.</p></div><?php endif; ?>
</div></section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
