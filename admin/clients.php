<?php
require_once __DIR__ . '/../config/db.php';
include 'includes/header.php';
include 'includes/csrf.php';

$success = '';
$error = '';
$editClient = null;

// Handle form submissions
if ($_POST) {
    if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
        $error = 'Invalid security token. Please try again.';
    } else {
    try {
        if (isset($_POST['action'])) {
            if ($_POST['action'] == 'create') {
                $stmt = $pdo->prepare("INSERT INTO clients (name, logo_path, testimonial) VALUES (?, ?, ?)");
                $stmt->execute([
                    $_POST['name'],
                    $_POST['logo_path'],
                    $_POST['testimonial']
                ]);
                $success = 'Client created successfully!';
            } elseif ($_POST['action'] == 'update' && isset($_POST['id'])) {
                $stmt = $pdo->prepare("UPDATE clients SET name = ?, logo_path = ?, testimonial = ? WHERE id = ?");
                $stmt->execute([
                    $_POST['name'],
                    $_POST['logo_path'],
                    $_POST['testimonial'],
                    $_POST['id']
                ]);
                $success = 'Client updated successfully!';
            } elseif ($_POST['action'] == 'delete' && isset($_POST['id'])) {
                $stmt = $pdo->prepare("DELETE FROM clients WHERE id = ?");
                $stmt->execute([$_POST['id']]);
                $success = 'Client deleted successfully!';
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
        $stmt = $pdo->prepare("SELECT * FROM clients WHERE id = ?");
        $stmt->execute([$_GET['edit']]);
        $editClient = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $error = 'Error loading client: ' . $e->getMessage();
    }
}

// Get all clients
try {
    $clients = $pdo->query("SELECT * FROM clients ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $error = 'Error loading clients: ' . $e->getMessage();
    $clients = [];
}
?>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Clients</h1>
    <p class="text-slate-600">Manage client testimonials and logos</p>
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

<!-- Add/Edit Client Form -->
<div class="bg-white rounded-lg shadow mb-6">
    <div class="p-6 border-b border-slate-200">
        <h2 class="text-lg font-semibold text-slate-800">
            <?php echo $editClient ? 'Edit Client' : 'Add New Client'; ?>
        </h2>
    </div>
    <div class="p-6">
        <form method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <input type="hidden" name="action" value="<?php echo $editClient ? 'update' : 'create'; ?>">
            <?php echo getCSRFField(); ?>
            <?php if ($editClient): ?>
                <input type="hidden" name="id" value="<?php echo $editClient['id']; ?>">
            <?php endif; ?>
            
            <div>
                <label for="name" class="block text-sm font-medium text-slate-700 mb-2">Client Name</label>
                <input type="text" id="name" name="name" required
                       value="<?php echo $editClient ? htmlspecialchars($editClient['name']) : ''; ?>"
                       placeholder="Company Name or Client Name"
                       class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-secondary focus:border-secondary">
            </div>
            
            <div>
                <label for="logo_path" class="block text-sm font-medium text-slate-700 mb-2">Logo URL</label>
                <input type="url" id="logo_path" name="logo_path"
                       value="<?php echo $editClient ? htmlspecialchars($editClient['logo_path']) : ''; ?>"
                       placeholder="https://example.com/logo.png"
                       class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-secondary focus:border-secondary">
                <p class="text-sm text-slate-500 mt-1">Enter a full URL to the client's logo (optional)</p>
            </div>
            
            <div class="md:col-span-2">
                <label for="testimonial" class="block text-sm font-medium text-slate-700 mb-2">Testimonial</label>
                <textarea id="testimonial" name="testimonial" rows="4"
                          placeholder="What the client said about working with TECHNEXA..."
                          class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-secondary focus:border-secondary"><?php echo $editClient ? htmlspecialchars($editClient['testimonial']) : ''; ?></textarea>
                <p class="text-sm text-slate-500 mt-1">Optional: Add a testimonial quote from this client</p>
            </div>
            
            <div class="md:col-span-2 flex gap-4">
                <button type="submit" class="px-6 py-2 bg-secondary text-white rounded-md hover:bg-accent">
                    <?php echo $editClient ? 'Update Client' : 'Add Client'; ?>
                </button>
                <?php if ($editClient): ?>
                    <a href="clients.php" class="px-6 py-2 bg-slate-500 text-white rounded-md hover:bg-slate-600">
                        Cancel Edit
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<!-- Clients List -->
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b border-slate-200">
        <h2 class="text-lg font-semibold text-slate-800">All Clients</h2>
    </div>
    <div class="p-6">
        <?php if (empty($clients)): ?>
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <p class="mt-2 text-slate-500">No clients yet. Add your first client above!</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($clients as $client): ?>
                    <div class="border border-slate-200 rounded-lg p-6">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 mr-4">
                                <?php if ($client['logo_path']): ?>
                                    <img src="<?php echo htmlspecialchars($client['logo_path']); ?>" 
                                         alt="<?php echo htmlspecialchars($client['name']); ?> logo"
                                         class="w-12 h-12 rounded-lg object-contain bg-slate-50"
                                         onerror="this.parentElement.innerHTML='<div class=\'w-12 h-12 bg-slate-200 rounded-lg flex items-center justify-center\'><svg class=\'w-6 h-6 text-slate-400\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4\'></path></svg></div>'">
                                <?php else: ?>
                                    <div class="w-12 h-12 bg-slate-200 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-slate-800">
                                    <?php echo htmlspecialchars($client['name']); ?>
                                </h3>
                                <span class="text-xs text-slate-500">
                                    Added <?php echo date('M j, Y', strtotime($client['created_at'])); ?>
                                </span>
                            </div>
                        </div>
                        
                        <?php if ($client['testimonial']): ?>
                            <div class="mb-4">
                                <p class="text-sm text-slate-600 italic">
                                    "<?php echo htmlspecialchars($client['testimonial']); ?>"
                                </p>
                            </div>
                        <?php endif; ?>
                        
                        <div class="flex gap-2">
                            <a href="?edit=<?php echo $client['id']; ?>" 
                               class="flex-1 px-3 py-2 bg-blue-100 text-blue-700 text-center text-sm rounded hover:bg-blue-200">
                                Edit
                            </a>
                            <form method="POST" class="flex-1" onsubmit="return confirm('Are you sure you want to delete this client?')">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $client['id']; ?>">
                                <?php echo getCSRFField(); ?>
                                <button type="submit" class="w-full px-3 py-2 bg-red-100 text-red-700 text-sm rounded hover:bg-red-200">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>