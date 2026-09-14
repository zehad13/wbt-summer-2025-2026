// ============================================
// ChaJoy - delivery.js
// AJAX "Pick Up Order" / "Mark as Delivered"
// buttons for the delivery personnel dashboard
// ============================================

document.addEventListener("DOMContentLoaded", function () {

    function postAction(url, orderId, callback) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                try {
                    callback(JSON.parse(xhr.responseText));
                } catch (err) {
                    showToast("Something went wrong. Please try again.", "error");
                }
            }
        };
        xhr.send("order_id=" + encodeURIComponent(orderId));
    }

    document.body.addEventListener("click", function (e) {
        var pickupBtn = e.target.closest(".pickup-btn");
        var deliveredBtn = e.target.closest(".delivered-btn");

        if (pickupBtn) {
            var orderId = pickupBtn.getAttribute("data-order-id");
            postAction("index.php?page=ajax_delivery_pickup", orderId, function (data) {
                showToast(data.message, data.success ? "success" : "error");
                if (data.success) {
                    var badge = document.getElementById("statusBadge_" + orderId);
                    if (badge) { badge.textContent = data.status; badge.className = "status status-" + data.status.replace(/ /g, "-"); }
                    pickupBtn.style.display = "none";
                    var deliverBtn = document.querySelector('.delivered-btn[data-order-id="' + orderId + '"]');
                    if (deliverBtn) deliverBtn.style.display = "inline-block";
                }
            });
        }

        if (deliveredBtn) {
            var orderId2 = deliveredBtn.getAttribute("data-order-id");
            postAction("index.php?page=ajax_delivery_delivered", orderId2, function (data) {
                showToast(data.message, data.success ? "success" : "error");
                if (data.success) {
                    var badge2 = document.getElementById("statusBadge_" + orderId2);
                    if (badge2) { badge2.textContent = data.status; badge2.className = "status status-" + data.status.replace(/ /g, "-"); }
                    deliveredBtn.style.display = "none";
                }
            });
        }
    });
});
