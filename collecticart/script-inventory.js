let currentProductId = null;
let currentAction = null;

// Handle Publish button click
document.querySelectorAll(".btn-publish").forEach(btn => {
  btn.addEventListener("click", function() {
    const row = this.closest("tr");
    currentProductId = row.dataset.id;
    currentAction = "publish";
    document.getElementById("publishModal").style.display = "flex";
  });
});

// Handle Unpublish button click
document.querySelectorAll(".btn-unpublish").forEach(btn => {
  btn.addEventListener("click", function() {
    const row = this.closest("tr");
    currentProductId = row.dataset.id;
    currentAction = "unpublish";
    document.getElementById("publishModal").style.display = "flex";
  });
});

document.getElementById("publishConfirm").addEventListener("click", () => {
  if (currentProductId) {
    fetch("inventory_publish.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `id=${currentProductId}&publish=1`
    }).then(res => res.text()).then(data => {
      const row = document.querySelector(`tr[data-id='${currentProductId}']`);
      if (row) {
        const actionCell = row.querySelector("td:last-child");
        actionCell.querySelector(".btn-publish")?.remove(); // remove publish btn
        const label = document.createElement("span");
        label.classList.add("published-label");
        label.textContent = "✅ Published";
        actionCell.appendChild(label);
      }
      document.getElementById("publishModal").style.display = "none";
    });
  }
});

/* Confirm modal action
document.getElementById("publishConfirm").addEventListener("click", () => {
  if (currentProductId) {
    fetch("inventory_publish.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `id=${currentProductId}&action=${currentAction}`
    }).then(res => res.text()).then(data => {
      const row = document.querySelector(`tr[data-id='${currentProductId}']`);
      const actionCell = row.querySelector("td:last-child");

      if (currentAction === "publish") {
        actionCell.querySelector(".btn-publish")?.remove();
        const label = document.createElement("span");
        label.classList.add("published-label");
        label.textContent = "✅ Published";
        actionCell.appendChild(label);

        const unpublishBtn = document.createElement("button");
        unpublishBtn.classList.add("action-btn", "btn-unpublish");
        unpublishBtn.textContent = "🚫 Unpublish";
        actionCell.appendChild(unpublishBtn);
      } else {
        actionCell.querySelector(".published-label")?.remove();
        actionCell.querySelector(".btn-unpublish")?.remove();

        const publishBtn = document.createElement("button");
        publishBtn.classList.add("action-btn", "btn-publish");
        publishBtn.textContent = "🌐 Publish";
        actionCell.appendChild(publishBtn);
      }

      document.getElementById("publishModal").style.display = "none";
    });
  }
}); */

// Add product modal
const addModal = document.getElementById("addModal");
document.getElementById("addProductBtn").addEventListener("click", () => {
  addModal.style.display = "flex";
});
document.getElementById("closeAddModal").addEventListener("click", () => {
  addModal.style.display = "none";
});

// Handle add product form
document.getElementById("addProductForm").addEventListener("submit", e => {
  e.preventDefault();
  const formData = new FormData(e.target);

  fetch("inventory-add.php", {
    method: "POST",
    body: formData
  }).then(res => res.text()).then(data => {
    alert(data);
    location.reload();
  });
});

// Delete product
document.querySelectorAll(".btn-delete").forEach(btn => {
  btn.addEventListener("click", function() {
    const row = this.closest("tr");
    const id = row.dataset.id;

    if (confirm("Are you sure you want to delete this product?")) {
      fetch("inventory_delete.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `id=${id}`
      }).then(res => res.text()).then(data => {
        alert(data);
        location.reload();
      });
    }
  });
});

document.querySelectorAll(".btn-save").forEach(btn => {
  btn.addEventListener("click", function () {
    const row = this.closest("tr");
    const id = row.dataset.id;
    const stocks = row.querySelector(".stock-input").value;
    const availability = row.querySelector(".availability-select").value;

    // Create or reuse a status span
    let status = row.querySelector(".save-status");
    if (!status) {
      status = document.createElement("span");
      status.classList.add("save-status");
      this.insertAdjacentElement("afterend", status);
    }

    fetch("inventory_update.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `id=${id}&stocks=${stocks}&availability=${availability}`
    })
    .then(res => res.text())
    .then(data => {
      if (data.includes("✅")) {
        status.textContent = "✅ Saved!";
        status.style.color = "green";
      } else {
        status.textContent = "❌ Failed";
        status.style.color = "red";
      }
      // Remove after 2.5 seconds
      setTimeout(() => { status.textContent = ""; }, 2500);
    })
    .catch(err => {
      status.textContent = "⚠️ Error";
      status.style.color = "red";
      setTimeout(() => { status.textContent = ""; }, 2500);
      console.error(err);
    });
  });
});

function openAddProductModal() {
  document.getElementById("addProductModal").style.display = "flex";
}

function closeAddProductModal() {
  document.getElementById("addProductModal").style.display = "none";
}