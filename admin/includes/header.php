<?php
if (!isset($_SESSION)) {
    // Set secure session cookie parameters
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'domain' => '',
        'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
        'httponly' => true,
        'samesite' => 'Strict'
    ]);
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TECHNEXA Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary:'#1e2a4a',secondary:'#17a2b8',accent:'#20c997'
          }
        }
      }
    }
    </script>
</head>
<body class="bg-slate-100">
    <!-- Top Navigation -->
    <nav class="bg-white shadow-lg border-b border-slate-200 fixed w-full top-0 z-50">
        <div class="px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <h1 class="text-xl font-bold text-primary">TECHNEXA Admin</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-slate-600">Welcome, <?php echo htmlspecialchars($_SESSION['admin_user']); ?></span>
                    <a href="logout.php" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm">
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex pt-16">
        <!-- Sidebar -->
        <nav class="bg-white w-64 min-h-screen shadow-lg border-r border-slate-200 fixed">
            <div class="p-6">
                <ul class="space-y-2">
                    <li>
                        <a href="dashboard.php" class="flex items-center px-4 py-3 text-slate-700 rounded-lg hover:bg-slate-100 <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'bg-secondary text-white hover:bg-secondary' : ''; ?>">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="messages.php" class="flex items-center px-4 py-3 text-slate-700 rounded-lg hover:bg-slate-100 <?php echo basename($_SERVER['PHP_SELF']) == 'messages.php' ? 'bg-secondary text-white hover:bg-secondary' : ''; ?>">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            Messages
                        </a>
                    </li>
                    <li>
                        <a href="projects.php" class="flex items-center px-4 py-3 text-slate-700 rounded-lg hover:bg-slate-100 <?php echo basename($_SERVER['PHP_SELF']) == 'projects.php' ? 'bg-secondary text-white hover:bg-secondary' : ''; ?>">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            Projects
                        </a>
                    </li>
                    <li>
                        <a href="clients.php" class="flex items-center px-4 py-3 text-slate-700 rounded-lg hover:bg-slate-100 <?php echo basename($_SERVER['PHP_SELF']) == 'clients.php' ? 'bg-secondary text-white hover:bg-secondary' : ''; ?>">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Clients
                        </a>
                    </li>
                    <li>
                        <a href="blog.php" class="flex items-center px-4 py-3 text-slate-700 rounded-lg hover:bg-slate-100 <?php echo basename($_SERVER['PHP_SELF']) == 'blog.php' ? 'bg-secondary text-white hover:bg-secondary' : ''; ?>">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                            Blog Posts
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-1 ml-64 p-6">