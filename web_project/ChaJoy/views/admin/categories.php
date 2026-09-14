<?php $adminPageTitle = 'Category Management';
require __DIR__ . '/../layouts/admin_header.php'; ?>

<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
        <h3 style="margin:0;">All Categories</h3>
        <button class="btn btn-primary open-category-modal" data-mode="add">+ Add Category</button>
    </div>

    <?php if (empty($categories)): ?>
        <p style="color:#7d6a58;">No categories yet.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $cat): ?>
                        <tr>
                            <td><?php echo clean($cat['name']); ?></td>
                            <td>
                                <button class="btn btn-outline btn-sm open-category-modal"
                                    data-mode="edit"
                                    data-id="<?php echo $cat['id']; ?>"
                                    data-name="<?php echo clean($cat['name']); ?>">Edit</button>
                                <a href="index.php?page=admin_category_delete&id=<?php echo $cat['id']; ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete this category?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<div class="modal-overlay" id="categoryModal">
    <div class="modal-box">
        <div class="modal-box-header">
            <h3 style="margin:0;">Category</h3>
            <button class="close-cat-modal">&times;</button>
        </div>
        <form method="POST" action="index.php?page=admin_category_save" id="categoryForm">
            <input type="hidden" name="id" id="cat_id">
            <div class="form-group">
                <label>Category Name</label>
                <input type="text" name="name" id="cat_name" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Save Category</button>
        </form>
    </div>
</div>

<?php require __DIR__ . '/../layouts/admin_footer.php'; ?>