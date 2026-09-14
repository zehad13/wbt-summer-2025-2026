<?php
$adminPageTitle = 'Beverage Management';

require __DIR__ . '/../layouts/admin_header.php';
?>

<div class="card">

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">

        <h3 style="margin:0;">All Beverages</h3>

        <button class="btn btn-primary open-beverage-modal" data-mode="add">
            + Add Beverage
        </button>

    </div>


    <?php if (empty($beverages)): ?>

        <p style="color:#7d6a58;">
            No beverages yet. Add your first one!
        </p>

    <?php else: ?>

        <div class="table-responsive">

            <table>

                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach ($beverages as $b): ?>

                        <tr>

                            <td>
                                <?php echo clean($b['name']); ?>
                            </td>

                            <td>
                                <?php echo clean($b['category_name']); ?>
                            </td>

                            <td>
                                <?php echo formatMoney($b['price']); ?>
                            </td>

                            <td>
                                <?php echo intval($b['stock']); ?>
                            </td>

                            <td>

                                <span class="badge <?php echo $b['is_available'] ? 'badge-available' : 'badge-unavailable'; ?>">

                                    <?php
                                    if ($b['is_available']) {
                                        echo 'Available';
                                    } else {
                                        echo 'Unavailable';
                                    }
                                    ?>

                                </span>

                            </td>

                            <td>

                                <button
                                    class="btn btn-outline btn-sm open-beverage-modal"
                                    data-mode="edit"
                                    data-id="<?php echo $b['id']; ?>"
                                    data-name="<?php echo clean($b['name']); ?>"
                                    data-category="<?php echo $b['category_id']; ?>"
                                    data-description="<?php echo clean($b['description']); ?>"
                                    data-price="<?php echo $b['price']; ?>"
                                    data-stock="<?php echo $b['stock']; ?>"
                                    data-available="<?php echo $b['is_available']; ?>">
                                    Edit
                                </button>

                                <a
                                    href="index.php?page=admin_beverage_delete&id=<?php echo $b['id']; ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete this beverage? This cannot be undone.');">
                                    Delete
                                </a>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    <?php endif; ?>

</div>




<div class="modal-overlay" id="beverageModal">

    <div class="modal-box">

        <div class="modal-box-header">

            <h3 id="modalTitle" style="margin:0;">
                Add Beverage
            </h3>

            <button class="close-modal">X</button>

        </div>


        <form
            method="POST"
            action="index.php?page=admin_beverage_save"
            enctype="multipart/form-data"
            id="beverageForm">

            <input type="hidden" name="id" id="bev_id">


            <div class="form-group">

                <label>Beverage Name</label>

                <input
                    type="text"
                    name="name"
                    id="bev_name"
                    required>

            </div>


            <div class="form-group">

                <label>Category</label>

                <select
                    name="category_id"
                    id="bev_category"
                    required>

                    <?php foreach (($categories ?? []) as $cat): ?>

                        <option value="<?php echo $cat['id']; ?>">
                            <?php echo clean($cat['name']); ?>
                        </option>

                    <?php endforeach; ?>

                </select>

            </div>


            <div class="form-group">

                <label>Description</label>

                <textarea
                    name="description"
                    id="bev_description"
                    rows="3"></textarea>

            </div>


            <div class="form-row">

                <div class="form-group">

                    <label>Price (Tk)</label>

                    <input
                        type="number"
                        step="0.01"
                        min="0.01"
                        name="price"
                        id="bev_price"
                        required>

                </div>


                <div class="form-group">

                    <label>Stock Quantity</label>

                    <input
                        type="number"
                        min="0"
                        name="stock"
                        id="bev_stock"
                        required>

                </div>

            </div>


            <div class="form-group">

                <label>Image (optional)</label>

                <input
                    type="file"
                    name="image"
                    accept=".jpg,.jpeg,.png,.webp">

            </div>


            <div class="checkbox-row form-group">

                <input
                    type="checkbox"
                    name="is_available"
                    id="bev_available"
                    checked>

                <label for="bev_available" style="margin:0;">
                    Mark as available
                </label>

            </div>


            <button
                type="submit"
                class="btn btn-primary btn-block">

                Save Beverage

            </button>

        </form>

    </div>

</div>


<?php
require __DIR__ . '/../layouts/admin_footer.php';
?>