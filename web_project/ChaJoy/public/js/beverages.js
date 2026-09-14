document.addEventListener("DOMContentLoaded", function () {
    var searchInput = document.getElementById("searchInput");
    var grid = document.getElementById("beverageGrid");
    var pills = document.querySelectorAll(".pill");
  
    var activeCategory = grid ? grid.getAttribute("data-active-category") || "0" : "0";
    var debounceTimer = null;

    if (!grid) return;

    function fetchBeverages(keyword, categoryId) {
        grid.style.opacity = "0.5";

        var xhr = new XMLHttpRequest();
        var url = "index.php?page=ajax_beverage_search&q=" + encodeURIComponent(keyword) + "&category=" + encodeURIComponent(categoryId);
        xhr.open("GET", url, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                grid.style.opacity = "1";
                try {
                    var data = JSON.parse(xhr.responseText);
                    renderBeverages(data.beverages);
                } catch (err) {
                    grid.innerHTML = "<p>Something went wrong loading beverages.</p>";
                }
            }
        };
        xhr.send();
    }

    function renderBeverages(beverages) {
        if (!beverages.length) {
            grid.innerHTML = '<div class="empty-state"><div class="empty-icon">🥤</div><p>No beverages match your search.</p></div>';
            return;
        }

        var html = "";
       beverages.forEach(function (b) {
    var available = b.is_available === 1 && b.stock > 0;

    html += '<div class="beverage-card">';

    html += '  <a href="index.php?page=beverage_details&id=' + b.id + '">';
    html += '    <div class="beverage-img">';
    html += '      <img src="public/images/' + b.image + '" alt="' + escapeHtml(b.name) + '">';
    html += '    </div>';
    html += '  </a>';

    html += '  <div class="beverage-body">';
    html += '    <span class="beverage-category">' + escapeHtml(b.category_name) + '</span>';

    html += '    <h3 class="beverage-name">';
    html += '      <a href="index.php?page=beverage_details&id=' + b.id + '">';
    html += escapeHtml(b.name);
    html += '      </a>';
    html += '    </h3>';

    html += '    <p class="beverage-desc">' + escapeHtml(b.description) + '</p>';

    html += '    <span class="badge ' +
        (available ? 'badge-available' : 'badge-unavailable') + '">' +
        (available ? 'Available' : 'Out of stock') +
        '</span>';

    html += '    <div class="beverage-price mt-2">Tk ' + b.price + '</div>';

    html += '    <div class="beverage-actions">';

    html += '      <button class="btn btn-primary btn-sm add-to-cart-btn" data-id="' +
        b.id + '" ' + (available ? '' : 'disabled') + '>Add to Cart</button>';

    html += '      <a href="index.php?page=beverage_details&id=' + b.id +
        '" class="btn btn-outline btn-sm">View</a>';

    html += '    </div>';

    html += '  </div>';
    html += '</div>';
});
        grid.innerHTML = html;
    }

    if (searchInput) {
        searchInput.addEventListener("keyup", function () {
            clearTimeout(debounceTimer);
            var keyword = this.value;
            debounceTimer = setTimeout(function () {
                fetchBeverages(keyword, activeCategory);
            }, 350);
        });
    }

    pills.forEach(function (pill) {
        pill.addEventListener("click", function () {
            pills.forEach(function (p) { p.classList.remove("active"); });
            this.classList.add("active");
            activeCategory = this.getAttribute("data-category");
            var keyword = searchInput ? searchInput.value : "";
            fetchBeverages(keyword, activeCategory);
        });
    });

    function escapeHtml(text) {
        var div = document.createElement("div");
        div.textContent = text || "";
        return div.innerHTML;
    }
});
