const wishlistBtn = document.querySelector('.wishlist-btn'); // wishlist btn
const sidebar = document.getElementById('loginSidebar');
const overlay = document.getElementById('loginSidebarOverlay');
const closeBtn = document.getElementById('closeSidebarBtn');
const showSignup = document.getElementById('showSignup');
const showLogin = document.getElementById('showLogin');
const loginForm = document.getElementById('loginForm');
const signupForm = document.getElementById('signupForm');
const sidebarTitle = document.getElementById('sidebarTitle');

function openSidebar() {
  if (sidebar) sidebar.classList.add('active');
  if (overlay) overlay.classList.add('active');
}

function closeSidebar() {
  if (sidebar) sidebar.classList.remove('active');
  if (overlay) overlay.classList.remove('active');
}

if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
if (overlay) overlay.addEventListener('click', closeSidebar);

if (showSignup) {
  showSignup.addEventListener('click', () => {
    if (loginForm) loginForm.classList.add('hidden');
    if (signupForm) signupForm.classList.remove('hidden');
    if (sidebarTitle) sidebarTitle.textContent = 'Sign Up';
  });
}

if (showLogin) {
  showLogin.addEventListener('click', () => {
    if (signupForm) signupForm.classList.add('hidden');
    if (loginForm) loginForm.classList.remove('hidden');
    if (sidebarTitle) sidebarTitle.textContent = 'Sign In';
  });
}



// Auto-open sidebar if backend says login is required
document.addEventListener("DOMContentLoaded", function () {
  if (typeof requireLogin !== "undefined" && requireLogin === true) {
    openSidebar();
  }
});

const loginFormEl = document.getElementById("loginForm");
if (loginFormEl) {
  loginFormEl.addEventListener("submit", async function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    const res = await fetch("login.php", {
      method: "POST",
      body: formData
    });

    const data = await res.json();

    if (data.success) {
      window.location.href = data.redirect; // go back to last browsed page
    } else {
      const err = document.getElementById("loginError");
      if (err) err.textContent = data.message;
    }
  });
}

// Signup via AJAX + toast
const signupFormEl = document.getElementById("signupForm");
if (signupFormEl) {
  signupFormEl.addEventListener("submit", async function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    try {
      const res = await fetch("signup.php", { method: "POST", body: formData });
      const data = await res.json();

      if (data.success) {
        showToast(data.message || "Account created successfully.", "success");
        this.reset();
        // Switch to login view
        const loginForm2 = document.getElementById("loginForm");
        const sidebarTitle2 = document.getElementById("sidebarTitle");
        if (loginForm2) {
          this.classList.add("hidden");
          loginForm2.classList.remove("hidden");
          if (sidebarTitle2) sidebarTitle2.textContent = "Sign In";
        }
      } else {
        showToast(data.message || "Could not create account.", "error");
      }
    } catch (err) {
      showToast("Network error. Please try again.", "error");
    }
  });
}

// Simple toast helper
function showToast(message, type) {
  const toast = document.createElement("div");
  toast.textContent = message || "";
  const ok = (type || "success") === "success";
  toast.style.cssText = [
    "position: fixed",
    "top: 100px",
    "right: 20px",
    `background: ${ok ? "#27ae60" : "#e74c3c"}`,
    "color: #fff",
    "padding: 12px 16px",
    "border-radius: 6px",
    "box-shadow: 0 4px 12px rgba(0,0,0,0.15)",
    "z-index: 10000",
    "transform: translateX(120%)",
    "transition: transform .3s ease",
    "max-width: 320px",
    "font-size: 14px",
    "line-height: 1.3",
  ].join(";");
  document.body.appendChild(toast);
  requestAnimationFrame(() => {
    toast.style.transform = "translateX(0)";
  });
  setTimeout(() => {
    toast.style.transform = "translateX(120%)";
    setTimeout(() => toast.remove(), 300);
  }, 3000);
}

// Message button click
const messageBtn = document.querySelector(".message-btn");
if (messageBtn) {
  messageBtn.addEventListener("click", () => {
    fetch("check_session.php")
      .then(res => res.text())
      .then(status => {
        if (status === "LOGGED_IN") {
          const chat = document.querySelector(".chat-widget");
          if (chat) chat.classList.add("active");
        } else {
          openSidebar();
        }
      });
  });
}

// Password visibility toggle for all password fields
// Places an eye button INSIDE the input (right side), button-only, color #c56127
(function initPasswordToggles() {
  function attachToggles(root) {
    const pwInputs = (root || document).querySelectorAll('input[type="password"]');
    pwInputs.forEach(input => {
      if (input.dataset.hasToggle === '1') return; // avoid duplicate buttons
      input.dataset.hasToggle = '1';

      // Create a wrapper to position the eye button inside the input
      const wrapper = document.createElement('div');
      wrapper.style.position = 'relative';
      wrapper.style.display = 'block';
      wrapper.style.width = '100%';

      // Insert wrapper before the input and move the input inside
      input.parentNode.insertBefore(wrapper, input);
      wrapper.appendChild(input);

      // Add right padding so text doesn't overlap the eye button
      const currentPR = parseInt(window.getComputedStyle(input).paddingRight || '0', 10);
      input.style.paddingRight = (currentPR + 36) + 'px';

      // Create the eye button
      const btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'toggle-password';
      btn.setAttribute('aria-label', 'Show password');
      btn.title = 'Show/Hide password';
      btn.style.position = 'absolute';
      btn.style.top = '50%';
      btn.style.right = '10px';
      btn.style.transform = 'translateY(-50%)';
      btn.style.height = '24px';
      btn.style.width = '24px';
      btn.style.display = 'grid';
      btn.style.placeItems = 'center';
      btn.style.padding = '0';
      btn.style.margin = '0';
      btn.style.border = 'none';
      btn.style.background = 'transparent';
      btn.style.color = '#c56127';
      btn.style.cursor = 'pointer';
      btn.style.lineHeight = '1';

      // Use Font Awesome if available, fallback to emoji
      const useFA = !!document.querySelector('link[href*="font-awesome"], link[href*="fontawesome"], link[href*="cdnjs.cloudflare.com/ajax/libs/font-awesome"]');
      if (useFA) {
        const i = document.createElement('i');
        i.className = 'fas fa-eye';
        i.style.pointerEvents = 'none';
        btn.appendChild(i);
      } else {
        btn.textContent = '👁';
      }

      wrapper.appendChild(btn);

      btn.addEventListener('click', (e) => {
        e.preventDefault();
        const showing = input.type === 'text';
        if (showing) {
          input.type = 'password';
          btn.setAttribute('aria-label', 'Show password');
          if (btn.firstChild && btn.firstChild.classList) {
            btn.firstChild.className = 'fas fa-eye';
          } else {
            btn.textContent = '👁';
          }
        } else {
          input.type = 'text';
          btn.setAttribute('aria-label', 'Hide password');
          if (btn.firstChild && btn.firstChild.classList) {
            btn.firstChild.className = 'fas fa-eye-slash';
          } else {
            btn.textContent = '🙈';
          }
        }
      });
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => attachToggles(document));
  } else {
    attachToggles(document);
  }
})();

