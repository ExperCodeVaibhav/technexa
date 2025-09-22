<?php
require_once __DIR__ . '/../config/db.php';
include 'includes/header.php';

// Get statistics
try {
    $totalMessages = $pdo->query("SELECT COUNT(*) FROM messages")->fetchColumn();
    $unreadMessages = $pdo->query("SELECT COUNT(*) FROM messages WHERE is_read = 0")->fetchColumn();
    $totalProjects = $pdo->query("SELECT COUNT(*) FROM projects")->fetchColumn();
    $totalClients = $pdo->query("SELECT COUNT(*) FROM clients")->fetchColumn();
    $totalBlogPosts = $pdo->query("SELECT COUNT(*) FROM blog_posts")->fetchColumn();
    
    // Recent messages
    $recentMessages = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
    
    // Recent projects
    $recentProjects = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC LIMIT 3")->fetchAll(PDO::FETCH_ASSOC);
    
} catch (Exception $e) {
    $error = "Error loading dashboard data: " . $e->getMessage();
}
?>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Dashboard</h1>
    <p class="text-slate-600">Welcome to the TECHNEXA admin panel</p>
</div>

<?php if (isset($error)): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-2 bg-blue-100 rounded-lg">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-lg font-semibold text-slate-800"><?php echo $totalMessages; ?></h2>
                <p class="text-sm text-slate-600">Total Messages</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-2 bg-red-100 rounded-lg">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-lg font-semibold text-slate-800"><?php echo $unreadMessages; ?></h2>
                <p class="text-sm text-slate-600">Unread Messages</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-2 bg-green-100 rounded-lg">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-lg font-semibold text-slate-800"><?php echo $totalProjects; ?></h2>
                <p class="text-sm text-slate-600">Projects</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-2 bg-purple-100 rounded-lg">
                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-lg font-semibold text-slate-800"><?php echo $totalClients; ?></h2>
                <p class="text-sm text-slate-600">Clients</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-2 bg-yellow-100 rounded-lg">
                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-lg font-semibold text-slate-800"><?php echo $totalBlogPosts; ?></h2>
                <p class="text-sm text-slate-600">Blog Posts</p>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Messages -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-slate-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-slate-800">Recent Messages</h3>
                <a href="messages.php" class="text-secondary hover:text-accent text-sm">View All</a>
            </div>
        </div>
        <div class="p-6">
            <?php if (empty($recentMessages)): ?>
                <p class="text-slate-500 text-center py-4">No messages yet</p>
            <?php else: ?>
                <div class="space-y-4">
                    <?php foreach ($recentMessages as $message): ?>
                        <div class="flex items-start space-x-3 <?php echo $message['is_read'] ? '' : 'bg-blue-50 p-3 rounded-lg'; ?>">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-slate-200 rounded-full flex items-center justify-center">
                                    <span class="text-xs font-medium text-slate-600">
                                        <?php echo strtoupper(substr($message['name'], 0, 1)); ?>
                                    </span>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-slate-800">
                                    <?php echo htmlspecialchars($message['name']); ?>
                                </p>
                                <p class="text-sm text-slate-600 truncate">
                                    <?php echo htmlspecialchars(substr($message['message'], 0, 60)) . '...'; ?>
                                </p>
                                <p class="text-xs text-slate-400 mt-1">
                                    <?php echo date('M j, Y g:i A', strtotime($message['created_at'])); ?>
                                </p>
                            </div>
                            <?php if (!$message['is_read']): ?>
                                <div class="flex-shrink-0">
                                    <span class="inline-block w-2 h-2 bg-blue-500 rounded-full"></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Recent Projects -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-slate-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-slate-800">Recent Projects</h3>
                <a href="projects.php" class="text-secondary hover:text-accent text-sm">View All</a>
            </div>
        </div>
        <div class="p-6">
            <?php if (empty($recentProjects)): ?>
                <p class="text-slate-500 text-center py-4">No projects yet</p>
            <?php else: ?>
                <div class="space-y-4">
                    <?php foreach ($recentProjects as $project): ?>
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <?php if ($project['image_path']): ?>
                                    <img src="<?php echo htmlspecialchars($project['image_path']); ?>" 
                                         alt="<?php echo htmlspecialchars($project['title']); ?>"
                                         class="w-12 h-12 rounded-lg object-cover">
                                <?php else: ?>
                                    <div class="w-12 h-12 bg-slate-200 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-slate-800">
                                    <?php echo htmlspecialchars($project['title']); ?>
                                </p>
                                <p class="text-sm text-slate-600">
                                    <?php echo htmlspecialchars($project['category']); ?>
                                </p>
                                <p class="text-xs text-slate-400 mt-1">
                                    <?php echo date('M j, Y', strtotime($project['created_at'])); ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>