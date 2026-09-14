document.addEventListener("DOMContentLoaded", function () {
    var statusSelects = document.querySelectorAll(".order-status-select");

    statusSelects.forEach(function (select) {
        select.addEventListener("change", function () {
            var orderId = this.getAttribute("data-order-id");
            var newStatus = this.value;
            var badge = document.getElementById("statusBadge_" + orderId);
            var select_ = this;

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "index.php?page=ajax_order_status_update", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    try {
                        var data = JSON.parse(xhr.responseText);
                        showToast(data.message, data.success ? "success" : "error");
                        if (data.success && badge) {
                            badge.textContent = data.status;
                            badge.className = "status status-" + data.status.replace(/ /g, "-");
                        }
                    } catch (err) {
                        showToast("Could not update order status.", "error");
                    }
                }
            };
            xhr.send("order_id=" + encodeURIComponent(orderId) + "&status=" + encodeURIComponent(newStatus));
        });
    });

  
    var modal = document.getElementById("beverageModal");
    if (modal) {
        document.querySelectorAll(".open-beverage-modal").forEach(function (btn) {
            btn.addEventListener("click", function () {
                modal.classList.add("open");
                if (this.dataset.mode === "edit") {
                    document.getElementById("modalTitle").textContent = "Edit Beverage";
                    document.getElementById("bev_id").value = this.dataset.id;
                    document.getElementById("bev_name").value = this.dataset.name;
                    document.getElementById("bev_category").value = this.dataset.category;
                    document.getElementById("bev_description").value = this.dataset.description;
                    document.getElementById("bev_price").value = this.dataset.price;
                    document.getElementById("bev_stock").value = this.dataset.stock;
                    document.getElementById("bev_available").checked = this.dataset.available === "1";
                } else {
                    document.getElementById("modalTitle").textContent = "Add Beverage";
                    document.getElementById("beverageForm").reset();
                    document.getElementById("bev_id").value = "";
                }
            });
        });
        document.querySelectorAll(".close-modal").forEach(function (btn) {
            btn.addEventListener("click", function () { modal.classList.remove("open"); });
        });
    }

    var catModal = document.getElementById("categoryModal");
    if (catModal) {
        document.querySelectorAll(".open-category-modal").forEach(function (btn) {
            btn.addEventListener("click", function () {
                catModal.classList.add("open");
                if (this.dataset.mode === "edit") {
                    document.getElementById("cat_id").value = this.dataset.id;
                    document.getElementById("cat_name").value = this.dataset.name;
                } else {
                    document.getElementById("categoryForm").reset();
                    document.getElementById("cat_id").value = "";
                }
            });
        });
        document.querySelectorAll(".close-cat-modal").forEach(function (btn) {
            btn.addEventListener("click", function () { catModal.classList.remove("open"); });
        });
    }
});
