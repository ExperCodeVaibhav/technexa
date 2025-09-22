<?php
require_once __DIR__ . '/../config/db.php';
include 'includes/header.php';
include 'includes/csrf.php';

$success = '';
$error = '';
$editPost = null;

// Handle form submissions
if ($_POST) {
    if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
        $error = 'Invalid security token. Please try again.';
    } else {
    try {
        if (isset($_POST['action'])) {
            if ($_POST['action'] == 'create') {
                $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $_POST['title'])));
                $stmt = $pdo->prepare("INSERT INTO blog_posts (title, slug, content, image_path) VALUES (?, ?, ?, ?)");
                $stmt->execute([
                    $_POST['title'],
                    $slug,
                    $_POST['content'],
                    $_POST['image_path']
                ]);
                $success = 'Blog post created successfully!';
            } elseif ($_POST['action'] == 'update' && isset($_POST['id'])) {
                $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $_POST['title'])));
                $stmt = $pdo->prepare("UPDATE blog_posts SET title = ?, slug = ?, content = ?, image_path = ? WHERE id = ?");
                $stmt->execute([
                    $_POST['title'],
                    $slug,
                    $_POST['content'],
                    $_POST['image_path'],
                    $_POST['id']
                ]);
                $success = 'Blog post updated successfully!';
            } elseif ($_POST['action'] == 'delete' && isset($_POST['id'])) {
                $stmt = $pdo->prepare("DELETE FROM blog_posts WHERE id = ?");
                $stmt->execute([$_POST['id']]);
                $success = 'Blog post deleted successfully!';
            }
        }
        } catch (Exception $e) {
            $error = 'Error: ' . $e->getMessage();
        }
    }
}

// Handle edit request
if (isset($_GET['edit'])) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE id = ?");
        $stmt->execute([$_GET['edit']]);
        $editPost = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $error = 'Error loading blog post: ' . $e->getMessage();
    }
}

// Get all blog posts
try {
    $blogPosts = $pdo->query("SELECT * FROM blog_posts ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $error = 'Error loading blog posts: ' . $e->getMessage();
    $blogPosts = [];
}
?>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Blog Posts</h1>
    <p class="text-slate-600">Manage your blog content</p>
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

<!-- Add/Edit Blog Post Form -->
<div class="bg-white rounded-lg shadow mb-6">
    <div class="p-6 border-b border-slate-200">
        <h2 class="text-lg font-semibold text-slate-800">
            <?php echo $editPost ? 'Edit Blog Post' : 'Add New Blog Post'; ?>
        </h2>
    </div>
    <div class="p-6">
        <form method="POST" class="space-y-6">
            <input type="hidden" name="action" value="<?php echo $editPost ? 'update' : 'create'; ?>">
            <?php echo getCSRFField(); ?>
            <?php if ($editPost): ?>
                <input type="hidden" name="id" value="<?php echo $editPost['id']; ?>">
            <?php endif; ?>
            
            <div>
                <label for="title" class="block text-sm font-medium text-slate-700 mb-2">Title</label>
                <input type="text" id="title" name="title" required
                       value="<?php echo $editPost ? htmlspecialchars($editPost['title']) : ''; ?>"
                       class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-secondary focus:border-secondary">
                <p class="text-sm text-slate-500 mt-1">URL slug will be generated automatically from the title</p>
            </div>
            
            <div>
                <label for="image_path" class="block text-sm font-medium text-slate-700 mb-2">Featured Image URL</label>
                <input type="url" id="image_path" name="image_path"
                       value="<?php echo $editPost ? htmlspecialchars($editPost['image_path']) : ''; ?>"
                       placeholder="https://example.com/image.jpg"
                       class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-secondary focus:border-secondary">
            </div>
            
            <div>
                <label for="content" class="block text-sm font-medium text-slate-700 mb-2">Content</label>
                <textarea id="content" name="content" rows="12" required
                          placeholder="Write your blog post content here..."
                          class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-secondary focus:border-secondary"><?php echo $editPost ? htmlspecialchars($editPost['content']) : ''; ?></textarea>
                <p class="text-sm text-slate-500 mt-1">You can use HTML for formatting</p>
            </div>
            
            <div class="flex gap-4">
                <button type="submit" class="px-6 py-2 bg-secondary text-white rounded-md hover:bg-accent">
                    <?php echo $editPost ? 'Update Post' : 'Create Post'; ?>
                </button>
                <?php if ($editPost): ?>
                    <a href="blog.php" class="px-6 py-2 bg-slate-500 text-white rounded-md hover:bg-slate-600">
                        Cancel Edit
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<!-- Blog Posts List -->
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b border-slate-200">
        <h2 class="text-lg font-semibold text-slate-800">All Blog Posts</h2>
    </div>
    <div class="p-6">
        <?php if (empty($blogPosts)): ?>
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                </svg>
                <p class="mt-2 text-slate-500">No blog posts yet. Create your first post above!</p>
            </div>
        <?php else: ?>
            <div class="space-y-6">
                <?php foreach ($blogPosts as $post): ?>
                    <div class="border border-slate-200 rounded-lg p-6">
                        <div class="flex items-start gap-6">
                            <div class="flex-shrink-0">
                                <?php if ($post['image_path']): ?>
                                    <img src="<?php echo htmlspecialchars($post['image_path']); ?>" 
                                         alt="<?php echo htmlspecialchars($post['title']); ?>"
                                         class="w-24 h-24 rounded-lg object-cover"
                                         onerror="this.parentElement.innerHTML='<div class=\'w-24 h-24 bg-slate-200 rounded-lg flex items-center justify-center\'><svg class=\'w-8 h-8 text-slate-400\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\'></path></svg></div>'">
                                <?php else: ?>
                                    <div class="w-24 h-24 bg-slate-200 rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="flex-1">
                                <h3 class="text-xl font-semibold text-slate-800 mb-2">
                                    <?php echo htmlspecialchars($post['title']); ?>
                                </h3>
                                <p class="text-sm text-slate-500 mb-3">
                                    Slug: <?php echo htmlspecialchars($post['slug']); ?> • 
                                    Created: <?php echo date('M j, Y g:i A', strtotime($post['created_at'])); ?>
                                </p>
                                <div class="text-slate-600 mb-4">
                                    <?php 
                                    $content = strip_tags($post['content']);
                                    echo htmlspecialchars(substr($content, 0, 200)) . (strlen($content) > 200 ? '...' : ''); 
                                    ?>
                                </div>
                                <div class="flex gap-2">
                                    <a href="?edit=<?php echo $post['id']; ?>" 
                                       class="px-4 py-2 bg-blue-100 text-blue-700 text-sm rounded hover:bg-blue-200">
                                        Edit
                                    </a>
                                    <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this blog post?')">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
                                        <?php echo getCSRFField(); ?>
                                        <button type="submit" class="px-4 py-2 bg-red-100 text-red-700 text-sm rounded hover:bg-red-200">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>