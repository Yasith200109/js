<?php

declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

date_default_timezone_set('Asia/Colombo');

const BASE_PATH = __DIR__ . '/..';
const UPLOAD_PATH = BASE_PATH . '/uploads';

require_once __DIR__ . '/functions.php';

try {
    db();
} catch (Throwable $exception) {
    if (PHP_SAPI !== 'cli') {
        http_response_code(503);
        $isAdmin = str_contains($_SERVER['REQUEST_URI'] ?? '', '/admin/');
        echo '<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Database Setup Required</title><script src="https://cdn.tailwindcss.com"></script></head><body class="bg-slate-950 text-white min-h-screen grid place-items-center p-6"><div class="max-w-xl rounded-3xl border border-white/10 bg-white/5 p-8 shadow-2xl"><div class="text-blue-400 text-sm font-bold tracking-widest uppercase">J & S Constructions</div><h1 class="mt-3 text-3xl font-extrabold">Database connection required</h1><p class="mt-4 text-slate-300">Create the MySQL database, import <code class="text-blue-300">database.sql</code>, and update <code class="text-blue-300">config/database.php</code> or your environment variables.</p><p class="mt-4 text-sm text-slate-400">' . htmlspecialchars($exception->getMessage(), ENT_QUOTES, 'UTF-8') . '</p>' . ($isAdmin ? '' : '<a href="README.md" class="mt-6 inline-flex rounded-xl bg-blue-600 px-5 py-3 font-bold">Read installation guide</a>') . '</div></body></html>';
        exit;
    }
    throw $exception;
}
