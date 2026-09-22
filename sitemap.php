<?php
require __DIR__ . '/includes/bootstrap.php';
header('Content-Type: application/xml; charset=utf-8');
$pages = ['', 'about.php', 'services.php', 'projects.php', 'house-designs.php', 'gallery.php', 'quotation.php', 'contact.php'];
$projects = db()->query("SELECT slug, updated_at FROM projects WHERE status='published'")->fetchAll();
$houses = db()->query("SELECT slug, updated_at FROM house_designs WHERE status='published'")->fetchAll();
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($pages as $page): ?><url><loc><?= e(url($page)) ?></loc></url><?php endforeach; ?>
<?php foreach ($projects as $item): ?><url><loc><?= e(url('project-details.php?slug=' . urlencode($item['slug']))) ?></loc><lastmod><?= e(date('c', strtotime($item['updated_at']))) ?></lastmod></url><?php endforeach; ?>
<?php foreach ($houses as $item): ?><url><loc><?= e(url('house-details.php?slug=' . urlencode($item['slug']))) ?></loc><lastmod><?= e(date('c', strtotime($item['updated_at']))) ?></lastmod></url><?php endforeach; ?>
</urlset>
