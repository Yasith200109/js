<?php
require __DIR__ . '/includes/bootstrap.php';
$slug = trim($_GET['slug'] ?? '');
$stmt = db()->prepare("SELECT * FROM projects WHERE slug=? AND status='published' LIMIT 1");
$stmt->execute([$slug]);
$project = $stmt->fetch();
if(!$project){ http_response_code(404); require __DIR__.'/404.php'; exit; }

$imagesStmt = db()->prepare("SELECT * FROM project_images WHERE project_id=? ORDER BY sort_order,id");
$imagesStmt->execute([$project['id']]);
$dbImages = $imagesStmt->fetchAll();

$gallery = [];
$seen = [];
$coverPath = (string)($project['cover_image'] ?? '');
if ($coverPath !== '') {
    $gallery[] = ['image_path' => $coverPath, 'caption' => $project['title'] . ' cover image'];
    $seen[$coverPath] = true;
}
foreach ($dbImages as $image) {
    $path = (string)$image['image_path'];
    if ($path === '' || isset($seen[$path])) continue;
    $gallery[] = $image;
    $seen[$path] = true;
}

$relatedStmt = db()->prepare("SELECT * FROM projects WHERE status='published' AND id!=? ORDER BY CASE WHEN category=? THEN 0 ELSE 1 END, is_featured DESC, id DESC LIMIT 3");
$relatedStmt->execute([$project['id'], $project['category']]);
$relatedProjects = $relatedStmt->fetchAll();

$meta = page_meta($project['title'], excerpt($project['description'],155));
require __DIR__ . '/includes/header.php';
?>
<main>
<section class="relative min-h-[580px] overflow-hidden bg-brand-950 text-white">
  <img src="<?= upload_url($project['cover_image']) ?>" class="absolute inset-0 h-full w-full object-cover" alt="<?= e($project['title']) ?>">
  <div class="absolute inset-0 bg-gradient-to-r from-brand-950 via-brand-950/80 to-brand-950/20"></div>
  <div class="hero-grid absolute inset-0 opacity-25"></div>
  <div class="container-shell relative flex min-h-[580px] items-end py-16 sm:py-20">
    <div class="max-w-4xl reveal">
      <div class="mb-4 flex flex-wrap gap-2"><span class="rounded-full bg-blue-500 px-3 py-1 text-xs font-extrabold uppercase tracking-wider"><?= e($project['category']) ?></span><span class="rounded-full bg-white/15 px-3 py-1 text-xs font-extrabold uppercase tracking-wider backdrop-blur"><?= e($project['project_status']) ?></span><?php if(count($gallery)>1): ?><span class="rounded-full bg-white/15 px-3 py-1 text-xs font-extrabold uppercase tracking-wider backdrop-blur"><?= count($gallery) ?> Project Images</span><?php endif; ?></div>
      <h1 class="font-display text-5xl font-bold uppercase sm:text-7xl"><?= e($project['title']) ?></h1>
      <div class="mt-5 flex flex-wrap gap-x-6 gap-y-3 text-slate-200"><p class="flex items-center gap-2"><i data-lucide="map-pin" class="h-5 w-5 text-blue-300"></i><?= e($project['location']) ?></p><p class="flex items-center gap-2"><i data-lucide="calendar-days" class="h-5 w-5 text-blue-300"></i><?= e($project['completed_year']) ?></p><?php if($project['area_sqft']): ?><p class="flex items-center gap-2"><i data-lucide="maximize" class="h-5 w-5 text-blue-300"></i><?= number_format((float)$project['area_sqft']) ?> sq.ft.</p><?php endif; ?></div>
    </div>
  </div>
</section>

<section class="py-20">
  <div class="container-shell">
    <?php if($gallery): ?>
      <div class="project-gallery-grid reveal">
        <a href="<?= upload_url($gallery[0]['image_path']) ?>" data-gallery-image="<?= upload_url($gallery[0]['image_path']) ?>" data-gallery-alt="<?= e($gallery[0]['caption'] ?: $project['title']) ?>" class="project-gallery-main group block">
          <img src="<?= upload_url($gallery[0]['image_path']) ?>" alt="<?= e($gallery[0]['caption'] ?: $project['title']) ?>">
          <span class="gallery-open-badge"><i data-lucide="expand" class="h-4 w-4"></i>Open Gallery</span>
        </a>
        <?php if(count($gallery)>1): ?>
          <div class="project-gallery-thumbs">
            <?php foreach(array_slice($gallery,1,3) as $index=>$image): ?>
              <a href="<?= upload_url($image['image_path']) ?>" data-gallery-image="<?= upload_url($image['image_path']) ?>" data-gallery-alt="<?= e($image['caption'] ?: $project['title']) ?>" class="project-gallery-thumb group block">
                <img src="<?= upload_url($image['image_path']) ?>" alt="<?= e($image['caption'] ?: $project['title']) ?>">
                <?php if($index===2 && count($gallery)>4): ?><span class="absolute inset-0 grid place-items-center bg-brand-950/65 font-display text-3xl font-bold text-white">+<?= count($gallery)-4 ?></span><?php endif; ?>
              </a>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
      <?php if(count($gallery)>4): ?>
        <div class="hidden">
          <?php foreach(array_slice($gallery,4) as $image): ?><a href="<?= upload_url($image['image_path']) ?>" data-gallery-image="<?= upload_url($image['image_path']) ?>" data-gallery-alt="<?= e($image['caption'] ?: $project['title']) ?>"></a><?php endforeach; ?>
        </div>
      <?php endif; ?>
    <?php endif; ?>

    <div class="mt-16 grid gap-12 lg:grid-cols-[minmax(0,1fr)_370px]">
      <article class="reveal">
        <span class="section-kicker">Project Overview</span>
        <h2 class="mt-5 font-display text-4xl font-bold uppercase text-brand-950 sm:text-5xl">Designed With Purpose. Built With Care.</h2>
        <div class="prose-content mt-7 text-lg"><?= nl2br(e($project['description'])) ?></div>

        <div class="mt-10 grid gap-4 sm:grid-cols-3">
          <?php foreach([
            ['ruler','Careful Planning','Every stage is coordinated around the site, brief and practical project needs.'],
            ['shield-check','Quality Execution','Materials, workmanship and finishing are managed with long-term value in mind.'],
            ['messages-square','Clear Communication','Clients receive structured updates and practical guidance throughout the build.'],
          ] as $feature): ?>
            <div class="rounded-3xl bg-slate-50 p-6"><span class="grid h-11 w-11 place-items-center rounded-xl bg-brand-50 text-brand-700"><i data-lucide="<?= e($feature[0]) ?>" class="h-5 w-5"></i></span><h3 class="mt-4 font-extrabold text-brand-950"><?= e($feature[1]) ?></h3><p class="mt-2 text-sm leading-6 text-slate-600"><?= e($feature[2]) ?></p></div>
          <?php endforeach; ?>
        </div>
      </article>

      <aside class="reveal">
        <div class="sticky top-28 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-xl shadow-slate-200/40">
          <div class="bg-brand-950 p-7 text-white"><div class="text-xs font-extrabold uppercase tracking-[.18em] text-blue-300">Project Information</div><h3 class="mt-2 font-display text-3xl font-bold uppercase">At A Glance</h3></div>
          <div class="p-7">
            <dl class="grid gap-5 text-sm"><?php foreach([['Category',$project['category']],['Status',$project['project_status']],['Location',$project['location']],['Year',$project['completed_year']],['Area',$project['area_sqft'] ? number_format((float)$project['area_sqft']).' sq.ft.' : 'Custom']] as $row): ?><div class="flex items-center justify-between gap-4 border-b border-slate-200 pb-4"><dt class="font-bold text-slate-500"><?= e($row[0]) ?></dt><dd class="text-right font-extrabold text-brand-950"><?= e($row[1]) ?></dd></div><?php endforeach; ?></dl>
            <a href="<?= url('quotation.php?project='.urlencode($project['title'])) ?>" class="mt-7 flex items-center justify-center gap-2 rounded-xl bg-brand-700 px-5 py-4 font-extrabold text-white"><i data-lucide="file-text" class="h-5 w-5"></i>Build Something Similar</a>
            <div class="mt-3 grid grid-cols-2 gap-3"><a href="tel:<?= e(phone_link(setting('phone_1','075 089 6076'))) ?>" class="flex items-center justify-center gap-2 rounded-xl bg-slate-100 px-4 py-3 text-sm font-extrabold text-brand-950"><i data-lucide="phone-call" class="h-4 w-4"></i>Call</a><a href="<?= whatsapp_link('Hello J & S Constructions, I am interested in a project similar to '.$project['title'].'.') ?>" target="_blank" class="flex items-center justify-center gap-2 rounded-xl bg-emerald-500 px-4 py-3 text-sm font-extrabold text-white"><i data-lucide="message-circle" class="h-4 w-4"></i>WhatsApp</a></div>
          </div>
        </div>
      </aside>
    </div>
  </div>
</section>

<?php if($relatedProjects): ?>
<section class="bg-slate-50 py-20"><div class="container-shell"><div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end"><div><span class="section-kicker">More Projects</span><h2 class="mt-4 font-display text-4xl font-bold uppercase text-brand-950">Explore Related Work</h2></div><a href="<?= url('projects.php') ?>" class="inline-flex items-center gap-2 font-extrabold text-brand-700">View all projects <i data-lucide="arrow-right" class="h-5 w-5"></i></a></div><div class="mt-10 grid gap-7 md:grid-cols-2 lg:grid-cols-3"><?php foreach($relatedProjects as $item): ?><article class="card-lift overflow-hidden rounded-[1.75rem] border border-slate-200 bg-white"><a href="<?= url('project-details.php?slug='.urlencode($item['slug'])) ?>" class="image-zoom block"><img src="<?= upload_url($item['cover_image']) ?>" class="aspect-[4/3] w-full object-cover" alt="<?= e($item['title']) ?>"></a><div class="p-6"><div class="text-xs font-extrabold uppercase tracking-wider text-brand-700"><?= e($item['category']) ?></div><h3 class="mt-3 font-display text-2xl font-bold uppercase text-brand-950"><a href="<?= url('project-details.php?slug='.urlencode($item['slug'])) ?>"><?= e($item['title']) ?></a></h3><p class="mt-2 flex items-center gap-2 text-sm text-slate-500"><i data-lucide="map-pin" class="h-4 w-4"></i><?= e($item['location']) ?></p></div></article><?php endforeach; ?></div></div></section>
<?php endif; ?>

<?php if($gallery): ?>
<div class="gallery-lightbox" data-lightbox role="dialog" aria-modal="true" aria-label="Project image gallery">
  <button type="button" class="gallery-lightbox-close" data-lightbox-close aria-label="Close gallery"><i data-lucide="x" class="h-6 w-6"></i></button>
  <button type="button" class="gallery-lightbox-nav gallery-lightbox-prev" data-lightbox-prev aria-label="Previous image"><i data-lucide="chevron-left" class="h-7 w-7"></i></button>
  <img src="" alt="" data-lightbox-image>
  <button type="button" class="gallery-lightbox-nav gallery-lightbox-next" data-lightbox-next aria-label="Next image"><i data-lucide="chevron-right" class="h-7 w-7"></i></button>
  <div class="gallery-lightbox-count" data-lightbox-count></div>
</div>
<?php endif; ?>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
