<?php
$adminTitle = $adminTitle ?? 'Dashboard';
$user = admin_user();
$links = [
    ['label' => 'Overview', 'items' => [
        ['dashboard.php','layout-dashboard','Dashboard'],
    ]],
    ['label' => 'Website Content', 'items' => [
        ['projects.php','building-2','Projects'],
        ['services.php','briefcase-business','Services'],
        ['houses.php','house','House Designs'],
        ['gallery.php','images','Gallery'],
        ['testimonials.php','message-square-quote','Testimonials'],
    ]],
    ['label' => 'Customer Enquiries', 'items' => [
        ['quotations.php','file-text','Quotations'],
        ['messages.php','mail','Messages'],
    ]],
    ['label' => 'Administration', 'items' => [
        ['settings.php','settings','Website Settings'],
        ['profile.php','user-cog','Admin Profile'],
    ]],
];

try {
    $newQuotes = (int) db()->query("SELECT COUNT(*) FROM quotations WHERE status='New'")->fetchColumn();
    $newMessages = (int) db()->query("SELECT COUNT(*) FROM contact_messages WHERE status='New'")->fetchColumn();
} catch (Throwable) {
    $newQuotes = 0;
    $newMessages = 0;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?= e($adminTitle) ?> | J & S Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Oswald:wght@500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>tailwind.config={theme:{extend:{colors:{brand:{950:'#09064f',900:'#0a1257',800:'#0d1d6a',700:'#075bb8',500:'#0b8ee8',50:'#eef7ff'}}}}}</script>
  <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
  <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="admin-body bg-slate-50 text-slate-800">
<div class="admin-layout min-h-screen lg:grid lg:grid-cols-[292px_minmax(0,1fr)]">
  <aside class="admin-sidebar hidden h-screen overflow-y-auto text-slate-300 lg:sticky lg:top-0 lg:block">
    <div class="min-h-full">
      <a href="<?= url('admin/dashboard.php') ?>" class="flex min-h-24 items-center gap-3 border-b border-white/10 px-6 py-5">
        <span class="grid h-14 w-14 shrink-0 place-items-center overflow-hidden rounded-2xl border border-white/15 bg-white shadow-xl shadow-black/20"><img src="<?= asset('images/logo.jpg') ?>" class="h-full w-full object-cover" alt="J & S"></span>
        <div class="min-w-0"><div class="font-display text-xl font-bold text-white">J & S ADMIN</div><div class="mt-1 text-[10px] font-bold uppercase tracking-[.2em] text-blue-300">Website Control Center</div></div>
      </a>

      <div class="mx-4 mt-5 rounded-2xl border border-white/10 bg-white/5 p-4">
        <div class="flex items-center gap-3">
          <div class="grid h-11 w-11 place-items-center rounded-xl bg-blue-500/20 font-extrabold text-blue-200"><?= e(strtoupper(substr($user['name']??'A',0,1))) ?></div>
          <div class="min-w-0"><div class="truncate text-sm font-extrabold text-white"><?= e($user['name'] ?? 'Administrator') ?></div><div class="truncate text-xs text-slate-400"><?= e($user['email'] ?? 'admin') ?></div></div>
        </div>
      </div>

      <nav class="grid gap-5 p-4 pb-8 text-sm font-bold">
        <?php foreach($links as $group): ?>
          <div>
            <div class="mb-2 px-4 text-[10px] font-extrabold uppercase tracking-[.2em] text-slate-500"><?= e($group['label']) ?></div>
            <div class="grid gap-1">
              <?php foreach($group['items'] as $link):
                $isActive = current_page($link[0]);
                $badge = $link[0] === 'quotations.php' ? $newQuotes : ($link[0] === 'messages.php' ? $newMessages : 0);
              ?>
                <a class="admin-sidebar-link group relative flex items-center gap-3 rounded-xl px-4 py-3 <?= $isActive?'active bg-white/10 text-white':'' ?>" href="<?= url('admin/'.$link[0]) ?>">
                  <span class="grid h-8 w-8 place-items-center rounded-lg bg-white/5 text-slate-400 transition group-hover:bg-blue-500/20 group-hover:text-blue-200 <?= $isActive?'!bg-blue-500/25 !text-blue-200':'' ?>"><i data-lucide="<?= e($link[1]) ?>" class="h-4 w-4"></i></span>
                  <span class="min-w-0 flex-1 truncate"><?= e($link[2]) ?></span>
                  <?php if($badge > 0): ?><span class="grid min-w-6 place-items-center rounded-full bg-amber-400 px-1.5 py-0.5 text-[10px] font-extrabold text-slate-950"><?= $badge ?></span><?php endif; ?>
                </a>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </nav>

      <div class="mx-4 border-t border-white/10 py-5">
        <a href="<?= url() ?>" target="_blank" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-bold transition hover:bg-white/10 hover:text-white"><i data-lucide="external-link" class="h-5 w-5"></i>View Live Website</a>
        <a href="<?= url('admin/logout.php') ?>" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-bold text-red-300 transition hover:bg-red-500/10"><i data-lucide="log-out" class="h-5 w-5"></i>Sign Out</a>
      </div>
    </div>
  </aside>

  <div class="min-w-0">
    <header class="admin-topbar sticky top-0 z-30 border-b border-slate-200/80 bg-white/90 backdrop-blur-xl">
      <div class="flex min-h-20 items-center justify-between gap-4 px-4 sm:px-7">
        <div class="flex min-w-0 items-center gap-3">
          <button data-menu-button class="grid h-11 w-11 shrink-0 place-items-center rounded-xl border border-slate-200 bg-white shadow-sm lg:hidden" aria-label="Open admin menu"><i data-lucide="menu" class="h-5 w-5"></i></button>
          <div class="min-w-0"><div class="text-[10px] font-extrabold uppercase tracking-[.18em] text-brand-700 sm:text-xs">Website Management</div><h1 class="truncate font-display text-xl font-bold uppercase text-brand-950 sm:text-2xl"><?= e($adminTitle) ?></h1></div>
        </div>
        <div class="flex items-center gap-2 sm:gap-3">
          <a href="<?= url('admin/quotations.php') ?>" class="relative hidden h-11 w-11 place-items-center rounded-xl border border-slate-200 bg-white text-slate-600 shadow-sm sm:grid" aria-label="New quotations"><i data-lucide="bell" class="h-5 w-5"></i><?php if(($newQuotes+$newMessages)>0): ?><span class="absolute -right-1 -top-1 grid h-5 min-w-5 place-items-center rounded-full bg-red-500 px-1 text-[9px] font-extrabold text-white"><?= $newQuotes+$newMessages ?></span><?php endif; ?></a>
          <a href="<?= url() ?>" target="_blank" class="hidden items-center gap-2 rounded-xl bg-brand-950 px-4 py-2.5 text-sm font-extrabold text-white transition hover:bg-brand-700 md:inline-flex"><i data-lucide="external-link" class="h-4 w-4"></i>View Website</a>
          <div class="grid h-11 w-11 place-items-center rounded-xl bg-brand-50 font-extrabold text-brand-700"><?= e(strtoupper(substr($user['name']??'A',0,1))) ?></div>
        </div>
      </div>
      <nav data-mobile-menu class="hidden max-h-[75vh] overflow-y-auto border-t border-slate-200 bg-brand-950 p-3 text-sm font-bold text-slate-200 lg:hidden">
        <?php foreach($links as $group): ?>
          <div class="mb-3"><div class="px-4 py-2 text-[10px] uppercase tracking-[.18em] text-slate-500"><?= e($group['label']) ?></div><?php foreach($group['items'] as $link): ?><a class="flex items-center gap-3 rounded-xl px-4 py-3 hover:bg-white/10" href="<?= url('admin/'.$link[0]) ?>"><i data-lucide="<?= e($link[1]) ?>" class="h-5 w-5"></i><?= e($link[2]) ?></a><?php endforeach; ?></div>
        <?php endforeach; ?>
        <a href="<?= url('admin/logout.php') ?>" class="flex items-center gap-3 rounded-xl px-4 py-3 text-red-300 hover:bg-white/10"><i data-lucide="log-out" class="h-5 w-5"></i>Sign Out</a>
      </nav>
    </header>
    <main class="admin-main p-4 sm:p-7 lg:p-8">
      <?php foreach(flashes() as $notice): ?><div class="toast mb-5 rounded-2xl border px-5 py-4 <?= $notice['type']==='error'?'border-red-200 bg-red-50 text-red-800':'border-emerald-200 bg-emerald-50 text-emerald-800' ?>"><?= e($notice['message']) ?></div><?php endforeach; ?>
