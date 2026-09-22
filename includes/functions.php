<?php

declare(strict_types=1);

function db(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $config = require BASE_PATH . '/config/database.php';
    $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=%s', $config['host'], $config['port'], $config['name'], $config['charset']);
    $pdo = new PDO($dsn, $config['user'], $config['pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
    return $pdo;
}

function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function url(string $path = ''): string
{
    $base = rtrim((string) setting('site_url', ''), '/');
    if ($base === '') {
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $script = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/'));
        $script = preg_replace('#/admin$#', '', $script) ?: '';
        $base = $scheme . '://' . $host . rtrim($script, '/');
    }
    return $base . '/' . ltrim($path, '/');
}

function asset(string $path): string
{
    return url('assets/' . ltrim($path, '/'));
}

function upload_url(?string $path): string
{
    if (!$path) {
        return asset('images/placeholder-house.svg');
    }
    if (preg_match('#^https?://#', $path)) {
        return $path;
    }
    return url('uploads/' . ltrim($path, '/'));
}

function redirect(string $path): never
{
    header('Location: ' . (preg_match('#^https?://#', $path) ? $path : url($path)));
    exit;
}

function setting(string $key, mixed $default = null): mixed
{
    static $settings = null;
    if ($settings === null) {
        try {
            $settings = [];
            foreach (db()->query('SELECT setting_key, setting_value FROM settings')->fetchAll() as $row) {
                $settings[$row['setting_key']] = $row['setting_value'];
            }
        } catch (Throwable) {
            $settings = [];
        }
    }
    return $settings[$key] ?? $default;
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

function verify_csrf(): void
{
    $token = $_POST['csrf_token'] ?? '';
    if (!$token || !hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        http_response_code(419);
        exit('Your session expired. Please refresh and try again.');
    }
}

function flash(string $type, string $message): void
{
    $_SESSION['flash'][] = compact('type', 'message');
}

function flashes(): array
{
    $items = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $items;
}

function slugify(string $text): string
{
    $text = trim(strtolower($text));
    $text = preg_replace('/[^a-z0-9]+/i', '-', $text) ?? '';
    $text = trim($text, '-');
    return $text !== '' ? $text : bin2hex(random_bytes(4));
}

function unique_slug(string $table, string $title, ?int $ignoreId = null): string
{
    $allowed = ['projects', 'house_designs'];
    if (!in_array($table, $allowed, true)) {
        throw new InvalidArgumentException('Invalid slug table.');
    }
    $base = slugify($title);
    $slug = $base;
    $counter = 2;
    do {
        $sql = "SELECT id FROM {$table} WHERE slug = ?" . ($ignoreId ? ' AND id != ?' : '');
        $stmt = db()->prepare($sql);
        $params = $ignoreId ? [$slug, $ignoreId] : [$slug];
        $stmt->execute($params);
        if (!$stmt->fetch()) {
            return $slug;
        }
        $slug = $base . '-' . $counter++;
    } while (true);
}

function old(string $key, mixed $default = ''): mixed
{
    return $_POST[$key] ?? $default;
}

function is_post(): bool
{
    return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
}

function current_page(string $page): bool
{
    return basename($_SERVER['SCRIPT_NAME'] ?? '') === $page;
}

function admin_user(): ?array
{
    return $_SESSION['admin_user'] ?? null;
}

function admin_required(): void
{
    if (!admin_user()) {
        flash('error', 'Please sign in to continue.');
        redirect('admin/login.php');
    }
}

function upload_image(array $file, string $folder, ?string $oldPath = null): ?string
{
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return $oldPath;
    }
    if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Image upload failed.');
    }
    if (($file['size'] ?? 0) > 5 * 1024 * 1024) {
        throw new RuntimeException('Image must be smaller than 5 MB.');
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    $extensions = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    if (!isset($extensions[$mime])) {
        throw new RuntimeException('Only JPG, PNG and WEBP images are allowed.');
    }

    $folder = trim($folder, '/');
    $targetDir = UPLOAD_PATH . '/' . $folder;
    if (!is_dir($targetDir) && !mkdir($targetDir, 0755, true) && !is_dir($targetDir)) {
        throw new RuntimeException('Unable to create upload directory.');
    }

    $filename = date('YmdHis') . '-' . bin2hex(random_bytes(6)) . '.' . $extensions[$mime];
    $target = $targetDir . '/' . $filename;
    if (!move_uploaded_file($file['tmp_name'], $target)) {
        throw new RuntimeException('Unable to save uploaded image.');
    }

    if ($oldPath && !preg_match('#^https?://#', $oldPath) && !str_starts_with(ltrim($oldPath, '/'), 'library/')) {
        $oldFile = UPLOAD_PATH . '/' . ltrim($oldPath, '/');
        if (is_file($oldFile)) {
            @unlink($oldFile);
        }
    }
    return $folder . '/' . $filename;
}

function delete_uploaded_file(?string $path): void
{
    if (!$path || preg_match('#^https?://#', $path) || str_starts_with(ltrim($path, '/'), 'library/')) {
        return;
    }
    $file = UPLOAD_PATH . '/' . ltrim($path, '/');
    if (is_file($file)) {
        @unlink($file);
    }
}

function excerpt(string $text, int $length = 140): string
{
    $text = trim(strip_tags($text));
    if (mb_strlen($text) <= $length) {
        return $text;
    }
    return rtrim(mb_substr($text, 0, $length - 1)) . '…';
}

function phone_link(string $number): string
{
    return preg_replace('/[^0-9+]/', '', $number) ?: $number;
}

function whatsapp_link(string $message = 'Hello J & S Constructions, I would like to discuss a construction project.'): string
{
    $number = preg_replace('/\D+/', '', (string) setting('whatsapp', '94750896076'));
    if (str_starts_with($number, '0')) {
        $number = '94' . substr($number, 1);
    }
    return 'https://wa.me/' . $number . '?text=' . rawurlencode($message);
}

function page_meta(string $title, string $description = ''): array
{
    return [
        'title' => $title . ' | ' . setting('company_name', 'J & S Constructions'),
        'description' => $description ?: (string) setting('meta_description', 'Trusted residential and commercial construction services in Sri Lanka since 1995.'),
    ];
}

function service_image(string $title): string
{
    $map = [
        'residential construction' => 'images/services/residential-construction.jpg',
        'commercial construction' => 'images/services/commercial-construction.jpg',
        'infrastructure projects' => 'images/services/infrastructure-projects.jpg',
        'architectural planning' => 'images/services/architectural-planning.jpg',
        'renovations & extensions' => 'images/services/renovations-extensions.jpg',
        'interior construction' => 'images/services/interior-construction.jpg',
        'project management' => 'images/services/commercial-construction.jpg',
        'construction consultation' => 'images/services/architectural-planning.jpg',
    ];

    $key = strtolower(trim($title));
    return asset($map[$key] ?? 'images/hero-banner.jpg');
}

function service_highlights(string $title): array
{
    $map = [
        'residential construction' => ['Turnkey house builds', 'Structural to final finishes'],
        'commercial construction' => ['Office and retail projects', 'Efficient site coordination'],
        'infrastructure projects' => ['Civil work support', 'Reliable project execution'],
        'architectural planning' => ['Space planning support', 'Drawing coordination'],
        'renovations & extensions' => ['Upgrade existing buildings', 'Smart additions and alterations'],
        'interior construction' => ['Ceilings and partitioning', 'Customized interior finishing'],
        'project management' => ['Planning and supervision', 'Timeline and quality tracking'],
        'construction consultation' => ['Early-stage guidance', 'Practical project advice'],
    ];

    $key = strtolower(trim($title));
    return $map[$key] ?? ['Tailored construction support', 'Discuss your exact requirement'];
}
