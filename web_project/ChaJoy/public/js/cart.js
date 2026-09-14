document.addEventListener("DOMContentLoaded", function () {
    var cartTable = document.getElementById("cartTable");
    if (!cartTable) return;

    function post(url, params, callback) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                try {
                    callback(JSON.parse(xhr.responseText));
                } catch (err) {
                    showToast("Something went wrong updating your cart.", "error");
                }
            }
        };
        xhr.send(params);
    }

    function updateTotalsUI(totals, count) {
        document.getElementById("summarySubtotal").textContent = "Tk " + totals.subtotal.toFixed(2);
        document.getElementById("summaryDelivery").textContent = "Tk " + totals.delivery_charge.toFixed(2);
        document.getElementById("summaryTotal").textContent = "Tk " + totals.total.toFixed(2);
        var badge = document.getElementById("cartBadge");
        if (badge) badge.textContent = count;
    }

    cartTable.addEventListener("click", function (e) {
        var incBtn = e.target.closest(".qty-increase");
        var decBtn = e.target.closest(".qty-decrease");
        var removeBtn = e.target.closest(".remove-item-btn");

        if (incBtn || decBtn) {
            var row = (incBtn || decBtn).closest("tr");
            var itemId = row.getAttribute("data-item-id");
            var qtyDisplay = row.querySelector(".qty-value");
            var qty = parseInt(qtyDisplay.textContent, 10);
            qty = incBtn ? qty + 1 : Math.max(1, qty - 1);

            post("index.php?page=ajax_cart_update", "cart_item_id=" + itemId + "&quantity=" + qty, function (data) {
                if (data.success) {
                    qtyDisplay.textContent = qty;
                    var price = parseFloat(row.getAttribute("data-price"));
                    row.querySelector(".row-subtotal").textContent = "Tk " + (price * qty).toFixed(2);
                    updateTotalsUI(data.totals, data.cart_count);
                }
            });
        }

        if (removeBtn) {
            var row2 = removeBtn.closest("tr");
            var itemId2 = row2.getAttribute("data-item-id");

            post("index.php?page=ajax_cart_remove", "cart_item_id=" + itemId2, function (data) {
                if (data.success) {
                    row2.remove();
                    updateTotalsUI(data.totals, data.cart_count);
                    showToast(data.message, "success");
                    if (data.cart_count === 0) {
                        window.location.reload();
                    }
                }
            });
        }
    });
});
