// Main JavaScript - Chung cho toàn bộ website

// Add to Cart Function
function addToCart(productId, quantity = 1) {
    const baseUrl =
        document.querySelector('meta[name="base-url"]')?.content || "";

    fetch(baseUrl + "/cart/add", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: "product_id=" + productId + "&quantity=" + quantity,
    })
        .then((response) => response.text())
        .then(() => {
            alert("Đã thêm sản phẩm vào giỏ hàng!");
            // Reload page để cập nhật số lượng giỏ hàng
            location.reload();
        })
        .catch((error) => {
            console.error("Error:", error);
            alert("Có lỗi xảy ra!");
        });
}

// Update Cart Quantity
function updateCart(itemId, quantity) {
    const baseUrl =
        document.querySelector('meta[name="base-url"]')?.content || "";

    const form = document.createElement("form");
    form.method = "POST";
    form.action = baseUrl + "/cart/update";

    const itemInput = document.createElement("input");
    itemInput.type = "hidden";
    itemInput.name = "item_id";
    itemInput.value = itemId;

    const quantityInput = document.createElement("input");
    quantityInput.type = "hidden";
    quantityInput.name = "quantity";
    quantityInput.value = quantity;

    form.appendChild(itemInput);
    form.appendChild(quantityInput);
    document.body.appendChild(form);
    form.submit();
}

// Remove from Cart
function removeFromCart(itemId) {
    if (confirm("Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?")) {
        const baseUrl =
            document.querySelector('meta[name="base-url"]')?.content || "";

        const form = document.createElement("form");
        form.method = "POST";
        form.action = baseUrl + "/cart/remove";

        const input = document.createElement("input");
        input.type = "hidden";
        input.name = "item_id";
        input.value = itemId;

        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
    }
}

// Clear Cart
function clearCart() {
    if (confirm("Bạn có chắc muốn xóa toàn bộ giỏ hàng?")) {
        const baseUrl =
            document.querySelector('meta[name="base-url"]')?.content || "";

        const form = document.createElement("form");
        form.method = "POST";
        form.action = baseUrl + "/cart/clear";

        document.body.appendChild(form);
        form.submit();
    }
}

// Form Validation
function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return true;

    const requiredFields = form.querySelectorAll("[required]");
    let isValid = true;

    requiredFields.forEach((field) => {
        if (!field.value.trim()) {
            field.style.borderColor = "#dc3545";
            isValid = false;
        } else {
            field.style.borderColor = "#ddd";
        }
    });

    return isValid;
}

// Auto hide alerts after 5 seconds
document.addEventListener("DOMContentLoaded", function () {
    const alerts = document.querySelectorAll(".alert");
    alerts.forEach((alert) => {
        setTimeout(() => {
            alert.style.opacity = "0";
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 5000);
    });
});

// Smooth scroll to top
function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: "smooth",
    });
}

// Format price
function formatPrice(price) {
    return new Intl.NumberFormat("vi-VN", {
        style: "currency",
        currency: "VND",
    }).format(price);
}

// Checkout Modal Functions
function showCheckoutModal() {
    // Kiểm tra có sản phẩm nào được chọn không
    const selectedItems = document.querySelectorAll(".item-select:checked");
    if (selectedItems.length === 0) {
        alert("Vui lòng chọn ít nhất một sản phẩm để đặt hàng!");
        return;
    }

    // Lấy danh sách item IDs được chọn
    const selectedIds = Array.from(selectedItems).map(
        (item) => item.dataset.id
    );

    // Điền vào hidden input
    const selectedItemIdsInput = document.getElementById("selectedItemIds");
    if (selectedItemIdsInput) {
        selectedItemIdsInput.value = selectedIds.join(",");
    }

    const modal = document.getElementById("checkoutModal");
    if (modal) {
        modal.style.display = "block";
        document.body.style.overflow = "hidden";
    }
}

function closeCheckoutModal() {
    const modal = document.getElementById("checkoutModal");
    if (modal) {
        modal.style.display = "none";
        document.body.style.overflow = "auto";
    }
}

// Toggle Select All Checkbox
function toggleSelectAll() {
    const selectAllCheckbox = document.getElementById("selectAll");
    const itemCheckboxes = document.querySelectorAll(".item-select");

    itemCheckboxes.forEach((checkbox) => {
        checkbox.checked = selectAllCheckbox.checked;
    });

    updateTotal();
}

// Update Total Based on Selected Items
function updateTotal() {
    const itemCheckboxes = document.querySelectorAll(".item-select");
    let total = 0;
    let selectedCount = 0;

    itemCheckboxes.forEach((checkbox) => {
        if (checkbox.checked) {
            const price = parseFloat(checkbox.dataset.price);
            const quantity = parseInt(checkbox.dataset.quantity);
            total += price * quantity;
            selectedCount++;
        }
    });

    // Update UI
    document.getElementById("subtotal").textContent = formatPrice(total);
    document.getElementById("totalAmount").textContent = formatPrice(total);
    document.getElementById("selectedCount").textContent = selectedCount;

    // Update select all checkbox state
    const selectAllCheckbox = document.getElementById("selectAll");
    const totalCheckboxes = itemCheckboxes.length;
    const checkedCheckboxes = document.querySelectorAll(
        ".item-select:checked"
    ).length;

    selectAllCheckbox.checked = checkedCheckboxes === totalCheckboxes;
    selectAllCheckbox.indeterminate =
        checkedCheckboxes > 0 && checkedCheckboxes < totalCheckboxes;
}

// Close modal when clicking outside
window.onclick = function (event) {
    const modal = document.getElementById("checkoutModal");
    if (event.target === modal) {
        closeCheckoutModal();
    }
};

// Close modal on Escape key
document.addEventListener("keydown", function (event) {
    if (event.key === "Escape") {
        closeCheckoutModal();
    }
});
