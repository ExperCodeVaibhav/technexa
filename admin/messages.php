<?php
require_once __DIR__ . '/../config/db.php';
include 'includes/header.php';
include 'includes/csrf.php';

$success = '';
$error = '';

// Handle actions
if ($_POST) {
    if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
        $error = 'Invalid security token. Please try again.';
    } else {
    if (isset($_POST['action'])) {
        try {
            if ($_POST['action'] == 'mark_read' && isset($_POST['message_id'])) {
                $stmt = $pdo->prepare("UPDATE messages SET is_read = 1 WHERE id = ?");
                $stmt->execute([$_POST['message_id']]);
                $success = 'Message marked as read.';
            } elseif ($_POST['action'] == 'mark_unread' && isset($_POST['message_id'])) {
                $stmt = $pdo->prepare("UPDATE messages SET is_read = 0 WHERE id = ?");
                $stmt->execute([$_POST['message_id']]);
                $success = 'Message marked as unread.';
            } elseif ($_POST['action'] == 'delete' && isset($_POST['message_id'])) {
                $stmt = $pdo->prepare("DELETE FROM messages WHERE id = ?");
                $stmt->execute([$_POST['message_id']]);
                $success = 'Message deleted successfully.';
            }
        } catch (Exception $e) {
            $error = 'Error: ' . $e->getMessage();
        }
    }
    }
}

// Get messages with pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$search = isset($_GET['search']) ? $_GET['search'] : '';
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

$whereClause = '';
$params = [];

if ($search) {
    $whereClause = "WHERE (name LIKE ? OR email LIKE ? OR message LIKE ?)";
    $params = ["%$search%", "%$search%", "%$search%"];
}

if ($filter == 'unread') {
    $whereClause = $whereClause ? "$whereClause AND is_read = 0" : "WHERE is_read = 0";
} elseif ($filter == 'read') {
    $whereClause = $whereClause ? "$whereClause AND is_read = 1" : "WHERE is_read = 1";
}

try {
    // Get total count
    $countQuery = "SELECT COUNT(*) FROM messages $whereClause";
    $stmt = $pdo->prepare($countQuery);
    $stmt->execute($params);
    $totalMessages = $stmt->fetchColumn();
    
    // Get messages
    $query = "SELECT * FROM messages $whereClause ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $totalPages = ceil($totalMessages / $limit);
} catch (Exception $e) {
    $error = 'Error loading messages: ' . $e->getMessage();
    $messages = [];
    $totalPages = 0;
}
?>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Messages</h1>
    <p class="text-slate-600">Manage contact form submissions</p>
</div>

<?php if ($success): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 alert-auto-hide">
        <?php echo htmlspecialchars($success); ?>
    </div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<!-- Filters and Search -->
<div class="bg-white rounded-lg shadow mb-6">
    <div class="p-6">
        <form method="GET" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-64">
                <label for="search" class="block text-sm font-medium text-slate-700 mb-1">Search</label>
                <input type="text" id="search" name="search" value="<?php echo htmlspecialchars($search); ?>"
                       placeholder="Search by name, email, or message..."
                       class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-secondary focus:border-secondary">
            </div>
            <div>
                <label for="filter" class="block text-sm font-medium text-slate-700 mb-1">Filter</label>
                <select id="filter" name="filter" 
                        class="px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-secondary focus:border-secondary">
                    <option value="all" <?php echo $filter == 'all' ? 'selected' : ''; ?>>All Messages</option>
                    <option value="unread" <?php echo $filter == 'unread' ? 'selected' : ''; ?>>Unread</option>
                    <option value="read" <?php echo $filter == 'read' ? 'selected' : ''; ?>>Read</option>
                </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-secondary text-white rounded-md hover:bg-accent">
                Filter
            </button>
            <?php if ($search || $filter != 'all'): ?>
                <a href="messages.php" class="px-4 py-2 bg-slate-500 text-white rounded-md hover:bg-slate-600">
                    Clear
                </a>
            <?php endif; ?>
        </form>
    </div>
</div>

<!-- Messages List -->
<div class="bg-white rounded-lg shadow">
    <div class="p-6">
        <?php if (empty($messages)): ?>
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
                <p class="mt-2 text-slate-500">No messages found</p>
            </div>
        <?php else: ?>
            <div class="space-y-4">
                <?php foreach ($messages as $message): ?>
                    <div class="border border-slate-200 rounded-lg p-4 <?php echo !$message['is_read'] ? 'bg-blue-50 border-blue-200' : ''; ?>">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-2">
                                    <h3 class="text-lg font-medium text-slate-800">
                                        <?php echo htmlspecialchars($message['name']); ?>
                                    </h3>
                                    <?php if (!$message['is_read']): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            New
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="grid md:grid-cols-2 gap-4 mb-3 text-sm text-slate-600">
                                    <div>
                                        <strong>Email:</strong> <?php echo htmlspecialchars($message['email']); ?>
                                    </div>
                                    <?php if ($message['phone']): ?>
                                        <div>
                                            <strong>Phone:</strong> <?php echo htmlspecialchars($message['phone']); ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($message['service']): ?>
                                        <div>
                                            <strong>Service:</strong> <?php echo htmlspecialchars($message['service']); ?>
                                        </div>
                                    <?php endif; ?>
                                    <div>
                                        <strong>Date:</strong> <?php echo date('M j, Y g:i A', strtotime($message['created_at'])); ?>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <strong class="text-slate-800">Message:</strong>
                                    <p class="mt-1 text-slate-700"><?php echo nl2br(htmlspecialchars($message['message'])); ?></p>
                                </div>
                            </div>
                            
                            <div class="flex flex-col gap-2 ml-4">
                                <form method="POST" class="inline">
                                    <input type="hidden" name="message_id" value="<?php echo $message['id']; ?>">
                                    <input type="hidden" name="action" value="<?php echo $message['is_read'] ? 'mark_unread' : 'mark_read'; ?>">
                                    <?php echo getCSRFField(); ?>
                                    <button type="submit" 
                                            class="px-3 py-1 text-xs rounded <?php echo $message['is_read'] ? 'bg-slate-100 text-slate-700 hover:bg-slate-200' : 'bg-blue-100 text-blue-700 hover:bg-blue-200'; ?>">
                                        <?php echo $message['is_read'] ? 'Mark Unread' : 'Mark Read'; ?>
                                    </button>
                                </form>
                                
                                <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this message?')">
                                    <input type="hidden" name="message_id" value="<?php echo $message['id']; ?>">
                                    <input type="hidden" name="action" value="delete">
                                    <?php echo getCSRFField(); ?>
                                    <button type="submit" class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded hover:bg-red-200">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
                <div class="mt-6 flex items-center justify-between">
                    <div class="text-sm text-slate-600">
                        Showing <?php echo $offset + 1; ?>-<?php echo min($offset + $limit, $totalMessages); ?> of <?php echo $totalMessages; ?> messages
                    </div>
                    <div class="flex space-x-2">
                        <?php if ($page > 1): ?>
                            <a href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>&filter=<?php echo $filter; ?>" 
                               class="px-3 py-2 bg-slate-100 text-slate-700 rounded hover:bg-slate-200">Previous</a>
                        <?php endif; ?>
                        
                        <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                            <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&filter=<?php echo $filter; ?>" 
                               class="px-3 py-2 <?php echo $i == $page ? 'bg-secondary text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'; ?> rounded">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>
                        
                        <?php if ($page < $totalPages): ?>
                            <a href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>&filter=<?php echo $filter; ?>" 
                               class="px-3 py-2 bg-slate-100 text-slate-700 rounded hover:bg-slate-200">Next</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>