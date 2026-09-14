document.addEventListener("DOMContentLoaded", function () {

    
    var toggle = document.getElementById("navToggle");
    var links = document.getElementById("navLinks");
    if (toggle && links) {
        toggle.addEventListener("click", function () {
            links.classList.toggle("open");
        });
    }


    document.body.addEventListener("click", function (e) {
        var btn = e.target.closest(".add-to-cart-btn");
        if (!btn) return;

        e.preventDefault();

        if (btn.disabled) return;

        var beverageId = btn.getAttribute("data-id");
        var qtyInput = document.getElementById("qty_" + beverageId);
        var quantity = qtyInput ? parseInt(qtyInput.value, 10) : 1;
        if (!quantity || quantity < 1) quantity = 1;

        var originalText = btn.innerHTML;
        btn.innerHTML = "Adding...";
        btn.disabled = true;

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "index.php?page=ajax_cart_add", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                btn.innerHTML = originalText;
                btn.disabled = false;

                try {
                    var data = JSON.parse(xhr.responseText);
                    showToast(data.message, data.success ? "success" : "error");

                    if (data.success) {
                        var badge = document.getElementById("cartBadge");
                        if (badge) badge.textContent = data.cart_count;
                    } else if (data.message && data.message.indexOf("log in") !== -1) {
                        window.location.href = "index.php?page=login";
                    }
                } catch (err) {
                    showToast("Something went wrong. Please try again.", "error");
                }
            }
        };
        xhr.send("beverage_id=" + encodeURIComponent(beverageId) + "&quantity=" + encodeURIComponent(quantity));
    });
});


function showToast(message, type) {
    if (!message) return;

    var toast = document.createElement("div");
    toast.className = "chajoy-toast " + (type === "error" ? "toast-error" : "toast-success");
    toast.textContent = message;
    toast.style.position = "fixed";
    toast.style.bottom = "24px";
    toast.style.right = "24px";
    toast.style.padding = "14px 22px";
    toast.style.borderRadius = "12px";
    toast.style.fontWeight = "600";
    toast.style.color = "white";
    toast.style.background = type === "error" ? "#E15252" : "#4CA771";
    toast.style.boxShadow = "0 8px 20px rgba(0,0,0,0.15)";
    toast.style.zIndex = "9999";
    toast.style.opacity = "0";
    toast.style.transition = "opacity 0.25s ease";

    document.body.appendChild(toast);
    requestAnimationFrame(function () { toast.style.opacity = "1"; });

    setTimeout(function () {
        toast.style.opacity = "0";
        setTimeout(function () { toast.remove(); }, 300);
    }, 2500);
}
