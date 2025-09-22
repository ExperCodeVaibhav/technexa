<?php
require_once __DIR__ . '/../config/db.php';
include 'includes/header.php';
include 'includes/csrf.php';

$success = '';
$error = '';
$editProject = null;

// Handle form submissions
if ($_POST) {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
        $error = 'Invalid security token. Please try again.';
    } else {
    try {
        if (isset($_POST['action'])) {
            if ($_POST['action'] == 'create') {
                $stmt = $pdo->prepare("INSERT INTO projects (title, category, description, image_path) VALUES (?, ?, ?, ?)");
                $stmt->execute([
                    $_POST['title'],
                    $_POST['category'],
                    $_POST['description'],
                    $_POST['image_path']
                ]);
                $success = 'Project created successfully!';
            } elseif ($_POST['action'] == 'update' && isset($_POST['id'])) {
                $stmt = $pdo->prepare("UPDATE projects SET title = ?, category = ?, description = ?, image_path = ? WHERE id = ?");
                $stmt->execute([
                    $_POST['title'],
                    $_POST['category'],
                    $_POST['description'],
                    $_POST['image_path'],
                    $_POST['id']
                ]);
                $success = 'Project updated successfully!';
            } elseif ($_POST['action'] == 'delete' && isset($_POST['id'])) {
                $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ?");
                $stmt->execute([$_POST['id']]);
                $success = 'Project deleted successfully!';
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
        $stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
        $stmt->execute([$_GET['edit']]);
        $editProject = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $error = 'Error loading project: ' . $e->getMessage();
    }
}

// Get all projects
try {
    $projects = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $error = 'Error loading projects: ' . $e->getMessage();
    $projects = [];
}
?>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Projects</h1>
    <p class="text-slate-600">Manage your portfolio projects</p>
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

<!-- Add/Edit Project Form -->
<div class="bg-white rounded-lg shadow mb-6">
    <div class="p-6 border-b border-slate-200">
        <h2 class="text-lg font-semibold text-slate-800">
            <?php echo $editProject ? 'Edit Project' : 'Add New Project'; ?>
        </h2>
    </div>
    <div class="p-6">
        <form method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <input type="hidden" name="action" value="<?php echo $editProject ? 'update' : 'create'; ?>">
            <?php echo getCSRFField(); ?>
            <?php if ($editProject): ?>
                <input type="hidden" name="id" value="<?php echo $editProject['id']; ?>">
            <?php endif; ?>
            
            <div>
                <label for="title" class="block text-sm font-medium text-slate-700 mb-2">Project Title</label>
                <input type="text" id="title" name="title" required
                       value="<?php echo $editProject ? htmlspecialchars($editProject['title']) : ''; ?>"
                       class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-secondary focus:border-secondary">
            </div>
            
            <div>
                <label for="category" class="block text-sm font-medium text-slate-700 mb-2">Category</label>
                <select id="category" name="category" required
                        class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-secondary focus:border-secondary">
                    <option value="">Select Category</option>
                    <option value="Web Development" <?php echo $editProject && $editProject['category'] == 'Web Development' ? 'selected' : ''; ?>>Web Development</option>
                    <option value="App Development" <?php echo $editProject && $editProject['category'] == 'App Development' ? 'selected' : ''; ?>>App Development</option>
                    <option value="AI/ML" <?php echo $editProject && $editProject['category'] == 'AI/ML' ? 'selected' : ''; ?>>AI/ML</option>
                    <option value="DevOps" <?php echo $editProject && $editProject['category'] == 'DevOps' ? 'selected' : ''; ?>>DevOps</option>
                    <option value="Cybersecurity" <?php echo $editProject && $editProject['category'] == 'Cybersecurity' ? 'selected' : ''; ?>>Cybersecurity</option>
                    <option value="Blockchain" <?php echo $editProject && $editProject['category'] == 'Blockchain' ? 'selected' : ''; ?>>Blockchain</option>
                    <option value="Marketing" <?php echo $editProject && $editProject['category'] == 'Marketing' ? 'selected' : ''; ?>>Marketing</option>
                </select>
            </div>
            
            <div class="md:col-span-2">
                <label for="description" class="block text-sm font-medium text-slate-700 mb-2">Description</label>
                <textarea id="description" name="description" rows="4" required
                          class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-secondary focus:border-secondary"><?php echo $editProject ? htmlspecialchars($editProject['description']) : ''; ?></textarea>
            </div>
            
            <div class="md:col-span-2">
                <label for="image_path" class="block text-sm font-medium text-slate-700 mb-2">Image URL</label>
                <input type="url" id="image_path" name="image_path"
                       value="<?php echo $editProject ? htmlspecialchars($editProject['image_path']) : ''; ?>"
                       placeholder="https://example.com/image.jpg"
                       class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-secondary focus:border-secondary">
                <p class="text-sm text-slate-500 mt-1">Enter a full URL to an image, or leave blank for default placeholder</p>
            </div>
            
            <div class="md:col-span-2 flex gap-4">
                <button type="submit" class="px-6 py-2 bg-secondary text-white rounded-md hover:bg-accent">
                    <?php echo $editProject ? 'Update Project' : 'Create Project'; ?>
                </button>
                <?php if ($editProject): ?>
                    <a href="projects.php" class="px-6 py-2 bg-slate-500 text-white rounded-md hover:bg-slate-600">
                        Cancel Edit
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<!-- Projects List -->
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b border-slate-200">
        <h2 class="text-lg font-semibold text-slate-800">All Projects</h2>
    </div>
    <div class="p-6">
        <?php if (empty($projects)): ?>
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                <p class="mt-2 text-slate-500">No projects yet. Create your first project above!</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($projects as $project): ?>
                    <div class="border border-slate-200 rounded-lg overflow-hidden">
                        <div class="aspect-video bg-slate-100 flex items-center justify-center">
                            <?php if ($project['image_path']): ?>
                                <img src="<?php echo htmlspecialchars($project['image_path']); ?>" 
                                     alt="<?php echo htmlspecialchars($project['title']); ?>"
                                     class="w-full h-full object-cover"
                                     onerror="this.parentElement.innerHTML='<svg class=\'w-12 h-12 text-slate-400\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\'></path></svg>'">
                            <?php else: ?>
                                <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            <?php endif; ?>
                        </div>
                        <div class="p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-secondary/10 text-secondary">
                                    <?php echo htmlspecialchars($project['category']); ?>
                                </span>
                                <span class="text-xs text-slate-500">
                                    <?php echo date('M j, Y', strtotime($project['created_at'])); ?>
                                </span>
                            </div>
                            <h3 class="font-semibold text-slate-800 mb-2">
                                <?php echo htmlspecialchars($project['title']); ?>
                            </h3>
                            <p class="text-sm text-slate-600 mb-4 line-clamp-3">
                                <?php echo htmlspecialchars(substr($project['description'], 0, 120)) . (strlen($project['description']) > 120 ? '...' : ''); ?>
                            </p>
                            <div class="flex gap-2">
                                <a href="?edit=<?php echo $project['id']; ?>" 
                                   class="flex-1 px-3 py-2 bg-blue-100 text-blue-700 text-center text-sm rounded hover:bg-blue-200">
                                    Edit
                                </a>
                                <form method="POST" class="flex-1" onsubmit="return confirm('Are you sure you want to delete this project?')">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?php echo $project['id']; ?>">
                                    <?php echo getCSRFField(); ?>
                                    <button type="submit" class="w-full px-3 py-2 bg-red-100 text-red-700 text-sm rounded hover:bg-red-200">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>