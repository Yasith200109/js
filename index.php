<?php
require __DIR__ . '/includes/bootstrap.php';
$meta = page_meta('Home', 'J & S Constructions — trusted residential, commercial and infrastructure construction solutions in Sri Lanka since 1995.');
$services = db()->query("SELECT * FROM services WHERE is_active=1 ORDER BY sort_order, id LIMIT 6")->fetchAll();
$projects = db()->query("SELECT * FROM projects WHERE is_featured=1 AND status='published' ORDER BY completed_year DESC, id DESC LIMIT 3")->fetchAll();
$houses = db()->query("SELECT * FROM house_designs WHERE is_featured=1 AND status='published' ORDER BY id DESC LIMIT 3")->fetchAll();
$testimonials = db()->query("SELECT * FROM testimonials WHERE is_active=1 ORDER BY sort_order, id LIMIT 4")->fetchAll();
require __DIR__ . '/includes/header.php';
?>
<main>
<section class="relative overflow-hidden bg-brand-950 text-white">
  <img src="<?= asset('images/hero-banner.jpg') ?>" alt="J & S Constructions premium modern house project" class="absolute inset-0 h-full w-full object-cover object-center">
  <div class="hero-overlay-soft absolute inset-0"></div>
  <div class="hero-grid absolute inset-0 opacity-30"></div>
  <div class="container-shell hero-shell grid min-h-[680px] items-center gap-10 py-20 sm:py-24 lg:min-h-[780px] lg:grid-cols-[minmax(0,1.15fr)_380px] lg:gap-14 lg:pb-36">
    <div class="max-w-3xl reveal">
      <div class="mb-5 inline-flex items-center gap-3 rounded-full border border-white/15 bg-white/10 px-4 py-2 text-xs font-extrabold uppercase tracking-[.2em] backdrop-blur"><span class="h-2 w-2 rounded-full bg-blue-400"></span>Trusted Since 1995</div>
      <h1 class="font-display text-4xl font-bold uppercase leading-[1.02] tracking-tight sm:text-6xl lg:text-8xl">We Build More Than Structures. <span class="text-blue-400">We Build Trust.</span></h1>
      <p class="mt-6 max-w-2xl text-base leading-8 text-slate-200 sm:text-lg lg:text-xl">Quality, reliable and efficient construction solutions for residential, commercial and infrastructure projects across Sri Lanka.</p>
      <div class="mt-8 hero-badge-line">
        <span><i data-lucide="shield-check" class="h-4 w-4"></i> Quality Workmanship</span>
        <span><i data-lucide="clock-3" class="h-4 w-4"></i> Reliable Timelines</span>
        <span><i data-lucide="building-2" class="h-4 w-4"></i> Residential • Commercial • Infrastructure</span>
      </div>
      <div class="mt-9 flex flex-col gap-4 sm:flex-row sm:flex-wrap">
        <a href="<?= url('quotation.php') ?>" class="rounded-2xl bg-blue-600 px-7 py-4 text-center font-extrabold text-white shadow-xl shadow-blue-900/30 transition hover:bg-blue-500">Start Your Project</a>
        <a href="<?= url('projects.php') ?>" class="rounded-2xl border border-white/25 bg-white/10 px-7 py-4 text-center font-extrabold backdrop-blur transition hover:bg-white/20">Explore Our Work</a>
      </div>
    </div>

    <div class="reveal lg:justify-self-end">
      <div class="hero-info-card rounded-[2rem] p-5 sm:p-6">
        <div class="text-xs font-extrabold uppercase tracking-[.22em] text-blue-300">Build Your Dream House</div>
        <h2 class="mt-3 font-display text-3xl font-bold uppercase leading-tight">30+ Years Of Construction Excellence</h2>
        <p class="mt-4 text-sm leading-7 text-slate-200">A trusted Sri Lankan construction company helping homeowners and businesses move from planning to confident project handover.</p>
        <div class="mt-5 grid gap-3">
          <?php foreach ([
            ['phone-call', setting('phone_1', '075 089 6076')],
            ['phone-call', setting('phone_2', '077 077 0671')],
            ['mail', setting('email', 'jsconstructions@gmail.com')],
            ['globe', setting('website', 'jsconstructions.lk')],
          ] as $detail): ?>
            <div class="flex items-center gap-3 rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-slate-100">
              <span class="grid h-10 w-10 place-items-center rounded-xl bg-white/10 text-blue-300"><i data-lucide="<?= e($detail[0]) ?>" class="h-4 w-4"></i></span>
              <span class="break-all font-semibold"><?= e($detail[1]) ?></span>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
  <div class="hero-stat-panel border-t border-white/10 bg-brand-950/75 backdrop-blur-xl">
    <div class="container-shell grid grid-cols-2 divide-x divide-y divide-white/10 md:grid-cols-4 md:divide-y-0">
      <?php foreach ([['30+','Years of Experience'],['150+','Projects Delivered'],['100%','Quality Commitment'],['Islandwide','Project Support']] as $stat): ?>
      <div class="p-5 sm:p-7"><div class="font-display text-3xl font-bold text-blue-300 sm:text-4xl"><?= e($stat[0]) ?></div><div class="mt-1 text-xs font-bold uppercase tracking-wider text-slate-300"><?= e($stat[1]) ?></div></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="py-24">
  <div class="container-shell grid items-center gap-14 lg:grid-cols-2">
    <div class="relative reveal"><div class="overflow-hidden rounded-[2rem] shadow-2xl"><img src="<?= asset('images/pages/about-cover.jpg') ?>" class="aspect-[4/3] w-full object-cover object-center" alt="Modern construction and premium residential work"></div><div class="absolute -bottom-7 -right-3 rounded-3xl bg-brand-700 p-6 text-white shadow-xl sm:right-8"><div class="font-display text-4xl font-bold">1995</div><div class="mt-1 text-xs font-extrabold uppercase tracking-[.18em]">The Journey Began</div></div></div>
    <div class="reveal"><span class="section-kicker">About J & S</span><h2 class="mt-5 font-display text-4xl font-bold uppercase leading-tight text-brand-950 sm:text-5xl">Building Dreams With Precision & Purpose</h2><p class="mt-6 text-lg leading-8 text-slate-600">J & S Constructions is a trusted construction company delivering quality, reliable and efficient building solutions for residential, commercial and infrastructure projects.</p><p class="mt-4 leading-7 text-slate-600">From initial planning to final handover, our approach is grounded in transparent communication, careful project management and workmanship built to last.</p><div class="mt-7 grid gap-4 sm:grid-cols-2"><?php foreach ([['shield-check','Trusted workmanship'],['ruler','Accurate planning'],['clock-3','Reliable timelines'],['badge-check','Quality materials']] as $item): ?><div class="flex items-center gap-3 rounded-2xl bg-slate-50 p-4 font-bold text-slate-700"><span class="grid h-10 w-10 place-items-center rounded-xl bg-blue-100 text-brand-700"><i data-lucide="<?= e($item[0]) ?>" class="h-5 w-5"></i></span><?= e($item[1]) ?></div><?php endforeach; ?></div><a href="<?= url('about.php') ?>" class="mt-8 inline-flex items-center gap-2 font-extrabold text-brand-700">Discover our story <i data-lucide="arrow-right" class="h-5 w-5"></i></a></div>
  </div>
</section>

<section class="bg-slate-50 py-24">
  <div class="container-shell"><div class="mx-auto max-w-3xl text-center reveal"><span class="section-kicker">What We Do</span><h2 class="mt-5 font-display text-4xl font-bold uppercase text-brand-950 sm:text-5xl">Complete Construction Solutions</h2><p class="mt-5 leading-7 text-slate-600">Practical expertise for every stage of your construction journey.</p></div>
  <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
    <?php foreach ($services as $service): $highlights = service_highlights($service['title']); ?>
    <article class="card-lift reveal overflow-hidden rounded-3xl border border-slate-200 bg-white p-5 sm:p-6">
      <div class="service-thumb">
        <img src="<?= service_image($service['title']) ?>" alt="<?= e($service['title']) ?>">
        <span class="service-icon-badge"><i data-lucide="<?= e($service['icon'] ?: 'building-2') ?>"></i></span>
      </div>
      <div class="mt-4 flex flex-wrap gap-2">
        <span class="service-chip">Premium Finish</span>
        <span class="service-chip">Tailored Planning</span>
      </div>
      <h3 class="mt-4 font-display text-2xl font-bold uppercase text-brand-950"><?= e($service['title']) ?></h3>
      <p class="mt-3 leading-7 text-slate-600"><?= e(excerpt($service['description'], 150)) ?></p>
      <ul class="service-highlight-list">
        <?php foreach ($highlights as $point): ?>
          <li><i data-lucide="check-circle-2" class="h-4 w-4"></i><span><?= e($point) ?></span></li>
        <?php endforeach; ?>
      </ul>
      <a href="<?= url('services.php') ?>#service-<?= (int)$service['id'] ?>" class="mt-6 inline-flex items-center gap-2 text-sm font-extrabold text-brand-700">Learn more <i data-lucide="arrow-up-right" class="h-4 w-4"></i></a>
    </article>
    <?php endforeach; ?>
  </div></div>
</section>

<section class="py-24">
  <div class="container-shell"><div class="flex flex-col justify-between gap-6 md:flex-row md:items-end"><div class="reveal"><span class="section-kicker">Selected Projects</span><h2 class="mt-5 font-display text-4xl font-bold uppercase text-brand-950 sm:text-5xl">Work That Speaks For Itself</h2></div><a href="<?= url('projects.php') ?>" class="inline-flex items-center gap-2 font-extrabold text-brand-700">View all projects <i data-lucide="arrow-right"></i></a></div>
  <div class="mt-12 grid gap-7 lg:grid-cols-3">
    <?php foreach ($projects as $project): ?>
    <article class="group reveal overflow-hidden rounded-[1.75rem] border border-slate-200 bg-white shadow-sm"><a class="image-zoom block" href="<?= url('project-details.php?slug=' . urlencode($project['slug'])) ?>"><img class="aspect-[4/3] w-full object-cover" src="<?= upload_url($project['cover_image']) ?>" alt="<?= e($project['title']) ?>"></a><div class="p-6"><div class="flex items-center justify-between text-xs font-extrabold uppercase tracking-wider text-brand-700"><span><?= e($project['category']) ?></span><span><?= e($project['completed_year']) ?></span></div><h3 class="mt-3 font-display text-2xl font-bold uppercase text-brand-950"><a href="<?= url('project-details.php?slug=' . urlencode($project['slug'])) ?>"><?= e($project['title']) ?></a></h3><p class="mt-2 flex items-center gap-2 text-sm text-slate-500"><i data-lucide="map-pin" class="h-4 w-4"></i><?= e($project['location']) ?></p></div></article>
    <?php endforeach; ?>
  </div></div>
</section>


<section class="relative overflow-hidden bg-brand-950 py-24 text-white">
  <div class="absolute inset-0 opacity-20"><img src="<?= upload_url('library/house-grand-courtyard.jpg') ?>" alt="" class="h-full w-full object-cover"></div>
  <div class="absolute inset-0 bg-gradient-to-r from-brand-950 via-brand-950/95 to-brand-950/65"></div>
  <div class="hero-grid absolute inset-0 opacity-25"></div>
  <div class="container-shell relative">
    <div class="flex flex-col justify-between gap-6 md:flex-row md:items-end">
      <div class="max-w-3xl reveal"><span class="section-kicker !text-blue-300">Featured House Designs</span><h2 class="mt-5 font-display text-4xl font-bold uppercase sm:text-5xl">A Better Starting Point For Your Dream Home</h2><p class="mt-5 max-w-2xl leading-7 text-slate-300">Explore adaptable house concepts with practical layouts, modern façades and room configurations that can be tailored to your land and lifestyle.</p></div>
      <a href="<?= url('house-designs.php') ?>" class="inline-flex items-center gap-2 font-extrabold text-blue-300">Browse all designs <i data-lucide="arrow-right" class="h-5 w-5"></i></a>
    </div>
    <div class="mt-12 grid gap-6 lg:grid-cols-3">
      <?php foreach($houses as $house): ?>
        <article class="group reveal overflow-hidden rounded-[1.8rem] border border-white/10 bg-white/5 backdrop-blur">
          <a href="<?= url('house-details.php?slug='.urlencode($house['slug'])) ?>" class="image-zoom block"><img src="<?= upload_url($house['image']) ?>" alt="<?= e($house['title']) ?>" class="aspect-[4/3] w-full object-cover"></a>
          <div class="p-6">
            <div class="text-xs font-extrabold uppercase tracking-[.15em] text-blue-300"><?= e($house['category']) ?></div>
            <h3 class="mt-3 font-display text-2xl font-bold uppercase"><?= e($house['title']) ?></h3>
            <div class="mt-5 grid grid-cols-3 gap-2 text-center text-[11px] font-bold text-slate-300">
              <div class="rounded-xl bg-white/5 p-3"><i data-lucide="bed-double" class="mx-auto mb-1 h-4 w-4 text-blue-300"></i><?= (int)$house['bedrooms'] ?> Beds</div>
              <div class="rounded-xl bg-white/5 p-3"><i data-lucide="bath" class="mx-auto mb-1 h-4 w-4 text-blue-300"></i><?= (int)$house['bathrooms'] ?> Baths</div>
              <div class="rounded-xl bg-white/5 p-3"><i data-lucide="maximize" class="mx-auto mb-1 h-4 w-4 text-blue-300"></i><?= number_format((float)$house['area_sqft']) ?> sqft</div>
            </div>
            <a href="<?= url('house-details.php?slug='.urlencode($house['slug'])) ?>" class="mt-6 inline-flex items-center gap-2 text-sm font-extrabold text-blue-300">View design <i data-lucide="arrow-up-right" class="h-4 w-4"></i></a>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="blueprint py-24 text-white">
  <div class="container-shell grid items-center gap-12 lg:grid-cols-2"><div class="reveal"><span class="section-kicker !text-blue-300">Our Process</span><h2 class="mt-5 font-display text-4xl font-bold uppercase sm:text-5xl">A Clear Path From Idea To Handover</h2><p class="mt-5 max-w-xl leading-7 text-slate-300">We keep every stage structured, transparent and focused on your expectations.</p></div><div class="grid gap-4 sm:grid-cols-2"><?php foreach ([['01','Consultation','We understand your requirements, site and budget.'],['02','Planning','Concept, drawings, estimates and project scheduling.'],['03','Construction','Supervised execution with quality checks at every stage.'],['04','Handover','Final inspection, completion and confident handover.']] as $step): ?><div class="reveal rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur"><div class="font-display text-4xl font-bold text-blue-300"><?= $step[0] ?></div><h3 class="mt-4 text-lg font-extrabold"><?= e($step[1]) ?></h3><p class="mt-2 text-sm leading-6 text-slate-300"><?= e($step[2]) ?></p></div><?php endforeach; ?></div></div>
</section>

<section class="py-24">
  <div class="container-shell"><div class="mx-auto max-w-3xl text-center reveal"><span class="section-kicker">Client Stories</span><h2 class="mt-5 font-display text-4xl font-bold uppercase text-brand-950 sm:text-5xl">Built On Trust</h2></div><div class="mt-12 grid gap-6 md:grid-cols-2">
  <?php foreach ($testimonials as $item): ?><blockquote class="reveal rounded-3xl border border-slate-200 bg-white p-7 shadow-sm"><div class="flex gap-1 text-amber-400"><?php for($i=0;$i<5;$i++): ?><i data-lucide="star" class="h-4 w-4 fill-current"></i><?php endfor; ?></div><p class="mt-5 text-lg leading-8 text-slate-700">“<?= e($item['quote']) ?>”</p><footer class="mt-6 flex items-center gap-3"><div class="grid h-12 w-12 place-items-center rounded-full bg-brand-50 font-extrabold text-brand-700"><?= e(strtoupper(substr($item['client_name'],0,1))) ?></div><div><div class="font-extrabold text-brand-950"><?= e($item['client_name']) ?></div><div class="text-sm text-slate-500"><?= e($item['location']) ?></div></div></footer></blockquote><?php endforeach; ?>
  </div></div>
</section>

<section class="container-shell"><div class="overflow-hidden rounded-[2.25rem] bg-gradient-to-r from-brand-950 to-brand-700 px-7 py-12 text-white sm:px-12 lg:flex lg:items-center lg:justify-between lg:py-16"><div class="max-w-2xl"><div class="text-xs font-extrabold uppercase tracking-[.2em] text-blue-300">Ready to Build?</div><h2 class="mt-3 font-display text-4xl font-bold uppercase sm:text-5xl">Let’s Turn Your Vision Into Reality</h2><p class="mt-4 text-slate-200">Tell us about your land, design idea, budget and preferred timeline.</p></div><a href="<?= url('quotation.php') ?>" class="mt-8 inline-flex rounded-2xl bg-white px-7 py-4 font-extrabold text-brand-950 lg:mt-0">Request a Free Consultation</a></div></section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
