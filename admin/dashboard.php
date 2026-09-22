<?php
require __DIR__ . '/includes/auth.php';
$adminTitle='Dashboard';
$stats=[
 ['Projects',(int)db()->query('SELECT COUNT(*) FROM projects')->fetchColumn(),'building-2','from-blue-500 to-cyan-400','projects.php'],
 ['House Designs',(int)db()->query('SELECT COUNT(*) FROM house_designs')->fetchColumn(),'house','from-violet-500 to-fuchsia-400','houses.php'],
 ['New Quotations',(int)db()->query("SELECT COUNT(*) FROM quotations WHERE status='New'")->fetchColumn(),'file-text','from-amber-500 to-orange-400','quotations.php'],
 ['New Messages',(int)db()->query("SELECT COUNT(*) FROM contact_messages WHERE status='New'")->fetchColumn(),'mail','from-emerald-500 to-teal-400','messages.php'],
];
$quotes=db()->query('SELECT * FROM quotations ORDER BY id DESC LIMIT 6')->fetchAll();
$messages=db()->query('SELECT * FROM contact_messages ORDER BY id DESC LIMIT 5')->fetchAll();
$projectOverview=[
 ['Published',(int)db()->query("SELECT COUNT(*) FROM projects WHERE status='published'")->fetchColumn(),'bg-emerald-500'],
 ['Drafts',(int)db()->query("SELECT COUNT(*) FROM projects WHERE status='draft'")->fetchColumn(),'bg-slate-400'],
 ['Completed',(int)db()->query("SELECT COUNT(*) FROM projects WHERE project_status='Completed'")->fetchColumn(),'bg-blue-500'],
 ['Ongoing',(int)db()->query("SELECT COUNT(*) FROM projects WHERE project_status='Ongoing'")->fetchColumn(),'bg-amber-500'],
];
$activeServices=(int)db()->query("SELECT COUNT(*) FROM services WHERE is_active=1")->fetchColumn();
$galleryItems=(int)db()->query("SELECT COUNT(*) FROM gallery WHERE is_active=1")->fetchColumn();
$testimonials=(int)db()->query("SELECT COUNT(*) FROM testimonials WHERE is_active=1")->fetchColumn();
require __DIR__ . '/includes/header.php';
?>
<section class="admin-welcome overflow-hidden rounded-[2rem] p-6 text-white sm:p-8 lg:p-10">
  <div class="relative z-10 flex flex-col justify-between gap-8 lg:flex-row lg:items-center">
    <div class="max-w-2xl">
      <div class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-2 text-xs font-extrabold uppercase tracking-[.18em]"><span class="h-2 w-2 rounded-full bg-emerald-400"></span>Website Control Center</div>
      <h2 class="mt-5 font-display text-4xl font-bold uppercase leading-tight sm:text-5xl">Welcome back, <?= e(explode(' ', trim($user['name'] ?? 'Administrator'))[0]) ?>.</h2>
      <p class="mt-4 max-w-xl leading-7 text-blue-100">Manage website content, monitor customer enquiries and keep the J & S Constructions portfolio updated from one place.</p>
    </div>
    <div class="grid shrink-0 grid-cols-2 gap-3">
      <a href="<?= url('admin/projects.php?new=1') ?>" class="rounded-2xl border border-white/15 bg-white/10 px-5 py-4 text-center font-extrabold backdrop-blur transition hover:bg-white/20"><i data-lucide="plus" class="mx-auto mb-2 h-5 w-5"></i>Add Project</a>
      <a href="<?= url('admin/quotations.php') ?>" class="rounded-2xl bg-white px-5 py-4 text-center font-extrabold text-brand-950 transition hover:bg-blue-50"><i data-lucide="inbox" class="mx-auto mb-2 h-5 w-5"></i>View Enquiries</a>
    </div>
  </div>
</section>

<div class="mt-7 grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
  <?php foreach($stats as $stat): ?>
    <a href="<?= url('admin/'.$stat[4]) ?>" class="admin-stat-card group overflow-hidden rounded-[1.6rem] border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
      <div class="flex items-center justify-between gap-4">
        <span class="grid h-13 w-13 place-items-center rounded-2xl bg-gradient-to-br <?= e($stat[3]) ?> text-white shadow-lg"><i data-lucide="<?= e($stat[2]) ?>"></i></span>
        <i data-lucide="arrow-up-right" class="h-5 w-5 text-slate-300 transition group-hover:text-brand-700"></i>
      </div>
      <div class="mt-6 font-display text-4xl font-bold text-brand-950"><?= $stat[1] ?></div>
      <div class="mt-1 text-xs font-extrabold uppercase tracking-[.12em] text-slate-500"><?= e($stat[0]) ?></div>
    </a>
  <?php endforeach; ?>
</div>

<div class="mt-7 grid gap-7 xl:grid-cols-[1.4fr_1fr]">
  <section class="admin-card p-6 sm:p-7">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between"><div><h2 class="font-display text-2xl font-bold uppercase text-brand-950">Project Overview</h2><p class="mt-1 text-sm text-slate-500">Current portfolio publishing status</p></div><a href="<?= url('admin/projects.php') ?>" class="inline-flex items-center gap-2 text-sm font-extrabold text-brand-700">Manage projects <i data-lucide="arrow-right" class="h-4 w-4"></i></a></div>
    <?php $projectTotal=max(1,array_sum(array_column($projectOverview,1))); ?>
    <div class="mt-7 overflow-hidden rounded-full bg-slate-100"><div class="flex h-3 w-full"><?php foreach($projectOverview as $item): ?><span class="<?= e($item[2]) ?>" style="width:<?= number_format(($item[1]/$projectTotal)*100,2) ?>%"></span><?php endforeach; ?></div></div>
    <div class="mt-6 grid grid-cols-2 gap-4 sm:grid-cols-4"><?php foreach($projectOverview as $item): ?><div class="rounded-2xl bg-slate-50 p-4"><div class="flex items-center gap-2 text-xs font-bold text-slate-500"><span class="h-2.5 w-2.5 rounded-full <?= e($item[2]) ?>"></span><?= e($item[0]) ?></div><div class="mt-2 font-display text-3xl font-bold text-brand-950"><?= $item[1] ?></div></div><?php endforeach; ?></div>
  </section>

  <section class="admin-card p-6 sm:p-7">
    <h2 class="font-display text-2xl font-bold uppercase text-brand-950">Content Health</h2><p class="mt-1 text-sm text-slate-500">Active website content at a glance</p>
    <div class="mt-6 grid gap-4">
      <?php foreach([
        ['briefcase-business','Active Services',$activeServices,'services.php'],
        ['images','Gallery Images',$galleryItems,'gallery.php'],
        ['message-square-quote','Testimonials',$testimonials,'testimonials.php'],
      ] as $item): ?>
      <a href="<?= url('admin/'.$item[3]) ?>" class="group flex items-center gap-4 rounded-2xl border border-slate-100 p-4 transition hover:border-blue-100 hover:bg-brand-50">
        <span class="grid h-11 w-11 place-items-center rounded-xl bg-brand-50 text-brand-700 group-hover:bg-white"><i data-lucide="<?= e($item[0]) ?>" class="h-5 w-5"></i></span>
        <div class="min-w-0 flex-1"><div class="text-sm font-extrabold text-brand-950"><?= e($item[1]) ?></div><div class="text-xs text-slate-500">Visible on the public website</div></div>
        <span class="font-display text-3xl font-bold text-brand-950"><?= (int)$item[2] ?></span>
      </a>
      <?php endforeach; ?>
    </div>
  </section>
</div>

<div class="mt-7 grid gap-7 xl:grid-cols-[1.4fr_1fr]">
  <section class="admin-card p-6 sm:p-7"><div class="flex items-center justify-between"><div><h2 class="font-display text-2xl font-bold uppercase text-brand-950">Recent Quotations</h2><p class="mt-1 text-sm text-slate-500">Latest website requests</p></div><a href="<?= url('admin/quotations.php') ?>" class="text-sm font-extrabold text-brand-700">View all</a></div><div class="mt-5 grid gap-3"><?php foreach($quotes as $quote): ?><a href="<?= url('admin/quotations.php?view='.(int)$quote['id']) ?>" class="flex items-center justify-between gap-4 rounded-2xl border border-slate-100 p-4 transition hover:border-blue-100 hover:bg-brand-50"><div class="min-w-0"><div class="truncate font-extrabold text-brand-950"><?= e($quote['name']) ?></div><div class="mt-1 truncate text-sm text-slate-500"><?= e($quote['service']) ?> · <?= e($quote['phone']) ?></div></div><span class="status-badge <?= $quote['status']==='New'?'bg-amber-100 text-amber-700':'bg-slate-100 text-slate-700' ?>"><?= e($quote['status']) ?></span></a><?php endforeach; ?><?php if(!$quotes): ?><p class="py-8 text-center text-slate-500">No quotation requests yet.</p><?php endif; ?></div></section>
  <section class="admin-card p-6 sm:p-7"><div class="flex items-center justify-between"><div><h2 class="font-display text-2xl font-bold uppercase text-brand-950">Latest Messages</h2><p class="mt-1 text-sm text-slate-500">Contact form enquiries</p></div><a href="<?= url('admin/messages.php') ?>" class="text-sm font-extrabold text-brand-700">View all</a></div><div class="mt-5 grid gap-3"><?php foreach($messages as $message): ?><a href="<?= url('admin/messages.php?view='.(int)$message['id']) ?>" class="rounded-2xl border border-slate-100 p-4 transition hover:border-blue-100 hover:bg-brand-50"><div class="flex items-center justify-between gap-3"><div class="font-extrabold text-brand-950"><?= e($message['name']) ?></div><span class="text-xs font-bold text-slate-400"><?= date('d M',strtotime($message['created_at'])) ?></span></div><p class="mt-2 truncate text-sm text-slate-500"><?= e($message['subject'] ?: excerpt($message['message'],60)) ?></p></a><?php endforeach; ?><?php if(!$messages): ?><p class="py-8 text-center text-slate-500">No messages yet.</p><?php endif; ?></div></section>
</div>

<div class="mt-7 admin-card p-6 sm:p-7"><div class="flex items-center justify-between"><div><h2 class="font-display text-2xl font-bold uppercase text-brand-950">Quick Actions</h2><p class="mt-1 text-sm text-slate-500">Common management shortcuts</p></div></div><div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-4"><?php foreach([['projects.php?new=1','plus-circle','Add Project','Create a new portfolio item'],['houses.php?new=1','house-plus','Add House Design','Publish a new design'],['gallery.php?new=1','image-plus','Add Gallery Image','Grow the visual gallery'],['settings.php','settings','Company Details','Update contact and SEO']] as $action): ?><a href="<?= url('admin/'.$action[0]) ?>" class="group rounded-2xl bg-slate-50 p-5 transition hover:bg-brand-50"><span class="grid h-11 w-11 place-items-center rounded-xl bg-white text-brand-700 shadow-sm"><i data-lucide="<?= e($action[1]) ?>"></i></span><div class="mt-4 font-extrabold text-brand-950"><?= e($action[2]) ?></div><div class="mt-1 text-xs leading-5 text-slate-500"><?= e($action[3]) ?></div></a><?php endforeach; ?></div></div>
<?php require __DIR__ . '/includes/footer.php'; ?>
