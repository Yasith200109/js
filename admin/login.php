<?php
require_once dirname(__DIR__) . '/includes/bootstrap.php';
if(admin_user()) redirect('admin/dashboard.php');
$error='';
if(is_post()){
 verify_csrf();$email=trim($_POST['email']??'');$password=$_POST['password']??'';
 $stmt=db()->prepare('SELECT * FROM admins WHERE email=? LIMIT 1');$stmt->execute([$email]);$user=$stmt->fetch();
 if($user&&password_verify($password,$user['password'])){session_regenerate_id(true);$_SESSION['admin_user']=['id'=>(int)$user['id'],'name'=>$user['name'],'email'=>$user['email']];redirect('admin/dashboard.php');}
 $error='Invalid email address or password.';
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin Login | J & S Constructions</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Oswald:wght@500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>tailwind.config={theme:{extend:{colors:{brand:{950:'#09064f',900:'#0a1257',700:'#075bb8',500:'#0b8ee8',50:'#eef7ff'}}}}}</script>
  <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
  <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="min-h-screen bg-slate-100 font-sans text-slate-800">
  <main class="grid min-h-screen lg:grid-cols-[1.05fr_.95fr]">
    <section class="relative hidden overflow-hidden bg-brand-950 text-white lg:block">
      <img src="<?= asset('images/hero-banner.jpg') ?>" alt="J & S Constructions" class="absolute inset-0 h-full w-full object-cover">
      <div class="absolute inset-0 bg-gradient-to-br from-brand-950/95 via-brand-950/80 to-brand-700/55"></div>
      <div class="hero-grid absolute inset-0 opacity-30"></div>
      <div class="relative flex min-h-screen flex-col justify-between p-12 xl:p-16">
        <a href="<?= url() ?>" class="flex items-center gap-4">
          <img src="<?= asset('images/logo.jpg') ?>" class="h-16 w-16 rounded-2xl border border-white/15 object-cover shadow-2xl" alt="J & S">
          <div><div class="font-display text-2xl font-bold uppercase">J & S Constructions</div><div class="text-xs font-extrabold uppercase tracking-[.22em] text-blue-300">Since 1995</div></div>
        </a>
        <div class="max-w-2xl">
          <div class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-2 text-xs font-extrabold uppercase tracking-[.18em] backdrop-blur"><span class="h-2 w-2 rounded-full bg-emerald-400"></span>Secure Website Management</div>
          <h1 class="mt-6 font-display text-6xl font-bold uppercase leading-[1.05] xl:text-7xl">Manage Every Detail From One Control Center.</h1>
          <p class="mt-6 max-w-xl text-lg leading-8 text-slate-200">Update projects, services, house designs, galleries and customer enquiries through the J & S Constructions admin panel.</p>
          <div class="mt-8 grid max-w-xl grid-cols-3 gap-3 text-center text-xs font-bold text-slate-200">
            <?php foreach([['building-2','Projects'],['images','Gallery'],['inbox','Enquiries']] as $item): ?><div class="rounded-2xl border border-white/10 bg-white/5 p-4 backdrop-blur"><i data-lucide="<?= e($item[0]) ?>" class="mx-auto mb-2 h-5 w-5 text-blue-300"></i><?= e($item[1]) ?></div><?php endforeach; ?>
          </div>
        </div>
        <p class="text-xs text-slate-400">J & S Constructions Website Administration</p>
      </div>
    </section>

    <section class="relative grid place-items-center overflow-hidden p-5 sm:p-8 lg:p-12">
      <div class="absolute right-[-10rem] top-[-10rem] h-96 w-96 rounded-full bg-blue-100 blur-3xl"></div>
      <div class="absolute bottom-[-8rem] left-[-8rem] h-80 w-80 rounded-full bg-indigo-100 blur-3xl"></div>
      <div class="relative w-full max-w-md rounded-[2rem] border border-white bg-white/90 p-7 shadow-2xl shadow-slate-300/40 backdrop-blur sm:p-10">
        <div class="lg:hidden"><img src="<?= asset('images/logo.jpg') ?>" class="h-20 w-20 rounded-2xl object-cover shadow-lg" alt="J & S"></div>
        <div class="mt-5 lg:mt-0"><div class="text-xs font-extrabold uppercase tracking-[.2em] text-brand-700">Admin Access</div><h2 class="mt-2 font-display text-4xl font-bold uppercase text-brand-950">Welcome Back</h2><p class="mt-3 text-sm leading-6 text-slate-500">Sign in with your administrator account to manage the website.</p></div>
        <?php if($error): ?><div class="mt-6 flex items-start gap-3 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm font-bold text-red-700"><i data-lucide="circle-alert" class="mt-0.5 h-5 w-5 shrink-0"></i><?= e($error) ?></div><?php endif; ?>
        <form method="post" class="mt-7 grid gap-5"><?= csrf_field() ?>
          <label class="grid gap-2 text-sm font-bold text-slate-700">Email Address<div class="relative"><i data-lucide="mail" class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400"></i><input type="email" name="email" class="form-input !pl-12" placeholder="admin@jsconstructions.lk" required autofocus></div></label>
          <label class="grid gap-2 text-sm font-bold text-slate-700">Password<div class="relative"><i data-lucide="lock-keyhole" class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400"></i><input type="password" name="password" class="form-input !pl-12" placeholder="Enter your password" required></div></label>
          <button class="inline-flex items-center justify-center gap-2 rounded-2xl bg-brand-700 px-6 py-4 font-extrabold text-white shadow-lg shadow-blue-700/20 transition hover:bg-brand-950"><i data-lucide="log-in" class="h-5 w-5"></i>Sign In To Dashboard</button>
        </form>
        <div class="mt-6 border-t border-slate-100 pt-5 text-center"><a href="<?= url() ?>" class="inline-flex items-center gap-2 text-sm font-bold text-brand-700"><i data-lucide="arrow-left" class="h-4 w-4"></i>Back to public website</a></div>
      </div>
    </section>
  </main>
  <script>lucide.createIcons();</script>
</body>
</html>
