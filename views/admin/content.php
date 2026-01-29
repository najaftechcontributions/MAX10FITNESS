<?php
/**
 * Admin Content View
 * Contains only the main content
 */

// Require admin access
requireAdmin();

$siteContent = new SiteContent($db);

$success = '';
$error = '';
$search_term = '';
$selected_page = '';
$selected_section = '';

// Handle content update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'update') {
    $siteContent->id = (int)$_POST['content_id'];
    $siteContent->content_value = $_POST['content_value'];
    $siteContent->description = $_POST['description'];
    
    if ($siteContent->update()) {
        $success = 'Content updated successfully';
    } else {
        $error = 'Failed to update content';
    }
}

// Get filter values
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_term = $_GET['search'];
}
if (isset($_GET['page']) && !empty($_GET['page'])) {
    $selected_page = $_GET['page'];
}
if (isset($_GET['section']) && !empty($_GET['section'])) {
    $selected_section = $_GET['section'];
}

// Use new filtered method that combines all filters
$all_content = $siteContent->getFiltered($selected_page, $selected_section, $search_term);

// Get all pages and sections for filters
$pages = $siteContent->getPages();
$sections = $siteContent->getSections();

$pageTitle = 'Content Management - MAX1ON1FITNESS';
$currentAdminPage = 'content';
$pageHeading = 'Site Content Management';
$currentUsername = getCurrentUsername();

// Include admin header
require_once __DIR__ . '/../../includes/admin-header.php';
?>

<style>
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        align-items: center;
        justify-content: center;
        overflow-y: auto;
        backdrop-filter: blur(5px);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .modal.active {
        display: flex;
        opacity: 1;
    }

    .modal-content {
        background: white;
        padding: 2rem;
        border-radius: 15px;
        max-width: 700px;
        width: 90%;
        margin: 2rem auto;
        transform: scale(0.9);
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }

    .modal.active .modal-content {
        transform: scale(1);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f0f0f0;
    }

    .modal-header h2 {
        color: #333;
        font-size: 1.5rem;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: #666;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .modal-close:hover {
        background: #f3f4f6;
        color: #333;
        transform: rotate(90deg);
    }

    .modal-close:focus {
        outline: 2px solid #667eea;
        outline-offset: 2px;
    }
    
    .filter-bar {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }
    
    .filter-bar select,
    .filter-bar input {
        padding: 0.5rem 1rem;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 0.9rem;
    }
    
    .filter-bar input[type="text"] {
        flex: 1;
        min-width: 200px;
    }
    
    .content-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .badge-heading { background: #dbeafe; color: #1e40af; }
    .badge-text { background: #e0e7ff; color: #4338ca; }
    .badge-button { background: #fef3c7; color: #92400e; }
    .badge-link { background: #ccfbf1; color: #115e59; }
    .badge-paragraph { background: #fce7f3; color: #9f1239; }
    
    .content-key {
        font-family: 'Courier New', monospace;
        background: #f3f4f6;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.85rem;
    }
    
    .content-preview {
        max-width: 300px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

<?php if ($success): ?>
    <div class="alert alert-success"><?php echo $success; ?></div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="alert alert-error"><?php echo $error; ?></div>
<?php endif; ?>

<!-- Statistics -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-card-title">Total Content Items</span>
            <div class="stat-card-icon blue">📝</div>
        </div>
        <div class="stat-card-value"><?php echo count($all_content); ?></div>
    </div>
    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-card-title">Pages</span>
            <div class="stat-card-icon purple">📄</div>
        </div>
        <div class="stat-card-value"><?php echo count($pages); ?></div>
    </div>
</div>

<!-- Filter & Search -->
<div class="content-card">
    <form method="GET" action="" class="filter-bar">
        <select name="page">
            <option value="">All Pages</option>
            <?php foreach ($pages as $page): ?>
                <option value="<?php echo htmlspecialchars($page); ?>"
                        <?php echo $selected_page === $page ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars(ucfirst($page)); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select name="section">
            <option value="">All Sections</option>
            <?php foreach ($sections as $section): ?>
                <option value="<?php echo htmlspecialchars($section); ?>"
                        <?php echo $selected_section === $section ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars(ucfirst($section)); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <input type="text"
               name="search"
               placeholder="Search content..."
               value="<?php echo htmlspecialchars($search_term); ?>">

        <button type="submit" class="btn btn-primary btn-sm">Apply Filters</button>

        <?php if ($search_term || $selected_page || $selected_section): ?>
            <a href="/dashboard/content" class="btn btn-secondary btn-sm">Clear Filters</a>
        <?php endif; ?>
    </form>
</div>

<!-- Content Table -->
<div class="content-card">
    <div class="content-card-header">
        <h2 class="content-card-title">
            <?php
            $title_parts = [];
            if ($selected_page) {
                $title_parts[] = ucfirst($selected_page) . " Page";
            }
            if ($selected_section) {
                $title_parts[] = ucfirst($selected_section) . " Section";
            }
            if ($search_term) {
                $title_parts[] = "Search: '" . htmlspecialchars($search_term) . "'";
            }

            if (!empty($title_parts)) {
                echo implode(" | ", $title_parts) . " (" . count($all_content) . ")";
            } else {
                echo "All Content (" . count($all_content) . ")";
            }
            ?>
        </h2>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th>Content Key</th>
                <th>Page</th>
                <th>Section</th>
                <th>Type</th>
                <th>Content Preview</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($all_content)): ?>
                <?php foreach ($all_content as $content): ?>
                    <tr>
                        <td>
                            <span class="content-key"><?php echo htmlspecialchars($content['content_key']); ?></span>
                        </td>
                        <td><?php echo htmlspecialchars(ucfirst($content['page_name'])); ?></td>
                        <td><?php echo htmlspecialchars(ucfirst($content['section_name'])); ?></td>
                        <td>
                            <span class="content-badge badge-<?php echo $content['content_type']; ?>">
                                <?php echo htmlspecialchars($content['content_type']); ?>
                            </span>
                        </td>
                        <td>
                            <div class="content-preview" title="<?php echo htmlspecialchars($content['content_value']); ?>">
                                <?php echo htmlspecialchars($content['content_value']); ?>
                            </div>
                        </td>
                        <td>
                            <button onclick='editContent(<?php echo htmlspecialchars(json_encode($content)); ?>)' 
                                    class="btn btn-primary btn-sm">
                                Edit
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align: center; padding: 2rem; color: #666;">
                        No content found
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Edit Content Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Edit Content</h2>
            <button class="modal-close" onclick="closeEditModal()">&times;</button>
        </div>
        <form method="POST" action="">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="content_id" id="edit_content_id">
            
            <div class="form-group">
                <label>Content Key</label>
                <input type="text" class="form-control" id="edit_content_key" readonly 
                       style="background: #f3f4f6; font-family: 'Courier New', monospace;">
            </div>
            
            <div class="form-group">
                <label>Page</label>
                <input type="text" class="form-control" id="edit_page_name" readonly 
                       style="background: #f3f4f6;">
            </div>
            
            <div class="form-group">
                <label>Section</label>
                <input type="text" class="form-control" id="edit_section_name" readonly 
                       style="background: #f3f4f6;">
            </div>
            
            <div class="form-group">
                <label>Type</label>
                <input type="text" class="form-control" id="edit_content_type" readonly 
                       style="background: #f3f4f6;">
            </div>
            
            <div class="form-group">
                <label for="edit_content_value">Content Value *</label>
                <textarea class="form-control" id="edit_content_value" name="content_value" rows="4" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="edit_description">Description</label>
                <input type="text" class="form-control" id="edit_description" name="description" 
                       placeholder="What is this content for?">
            </div>
            
            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Cancel</button>
                <button type="submit" class="btn btn-primary">Update Content</button>
            </div>
        </form>
    </div>
</div>

<script>
    function editContent(content) {
        document.getElementById('edit_content_id').value = content.id;
        document.getElementById('edit_content_key').value = content.content_key;
        document.getElementById('edit_page_name').value = content.page_name;
        document.getElementById('edit_section_name').value = content.section_name;
        document.getElementById('edit_content_type').value = content.content_type;
        document.getElementById('edit_content_value').value = content.content_value || '';
        document.getElementById('edit_description').value = content.description || '';
        document.getElementById('editModal').classList.add('active');
    }
    
    function closeEditModal() {
        document.getElementById('editModal').classList.remove('active');
    }
    
    // Close modal when clicking outside
    document.getElementById('editModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeEditModal();
        }
    });
</script>

<?php
// Include admin footer
require_once __DIR__ . '/../../includes/admin-footer.php';
?>
