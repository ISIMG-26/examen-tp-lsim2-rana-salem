/* =========================================================
   FitZone — script.js
   Covers:
   1. Welcome message (DOM)
   2. Tab switch auth.php (DOM)
   3. Form validation (auth + contact)
   4. AJAX — email check on register
   5. AJAX — live search on all.php
   6. Panier modal — open, fill, validate, send AJAX to PHP
   ========================================================= */

/* ----------------------------------------------------------
   1. Welcome message on index.php
---------------------------------------------------------- */
const welcomeEl = document.getElementById("welcome-message");
if (welcomeEl) {
    const hour = new Date().getHours();
    let msg = "";
    if (hour < 12)       msg = "☀️ Bonne matinée ! Prêt à s'entraîner ?";
    else if (hour < 18)  msg = "💪 Bonne après-midi ! Venez découvrir nos machines.";
    else                 msg = "🌙 Bonsoir ! La qualité FitZone vous attend.";
    welcomeEl.textContent = msg;
}

/* ----------------------------------------------------------
   2. Tabs — auth.php (Connexion / Inscription)
---------------------------------------------------------- */
const tabBtns = document.querySelectorAll(".tab-btn");
const authForms = document.querySelectorAll(".auth-form");

tabBtns.forEach(btn => {
    btn.addEventListener("click", () => {
        tabBtns.forEach(b => b.classList.remove("active"));
        authForms.forEach(f => f.classList.remove("active"));
        btn.classList.add("active");
        const target = document.getElementById(btn.dataset.target);
        if (target) target.classList.add("active");
    });
});

/* ----------------------------------------------------------
   3. Form validation helpers
---------------------------------------------------------- */
function showError(id, msg) {
    const el = document.getElementById(id);
    if (el) el.textContent = msg;
}
function clearError(id) {
    const el = document.getElementById(id);
    if (el) el.textContent = "";
}

// --- Login form ---
const loginForm = document.getElementById("login-form");
if (loginForm) {
    loginForm.addEventListener("submit", e => {
        let valid = true;

        const email = document.getElementById("login-email").value.trim();
        const pass  = document.getElementById("login-password").value;

        clearError("login-email-error");
        clearError("login-password-error");

        if (!email || !/\S+@\S+\.\S+/.test(email)) {
            showError("login-email-error", "Email invalide.");
            valid = false;
        }
        if (pass.length < 4) {
            showError("login-password-error", "Mot de passe trop court.");
            valid = false;
        }
        if (!valid) e.preventDefault();
    });
}

// --- Register form ---
const registerForm = document.getElementById("register-form");
if (registerForm) {
    registerForm.addEventListener("submit", e => {
        let valid = true;

        const nom     = document.getElementById("reg-nom").value.trim();
        const email   = document.getElementById("reg-email").value.trim();
        const pass    = document.getElementById("reg-password").value;
        const confirm = document.getElementById("reg-confirm").value;

        clearError("reg-nom-error");
        clearError("reg-email-error");
        clearError("reg-password-error");
        clearError("reg-confirm-error");

        if (nom.length < 2) {
            showError("reg-nom-error", "Nom requis (min 2 caractères).");
            valid = false;
        }
        if (!email || !/\S+@\S+\.\S+/.test(email)) {
            showError("reg-email-error", "Email invalide.");
            valid = false;
        }
        if (pass.length < 6) {
            showError("reg-password-error", "Mot de passe : min 6 caractères.");
            valid = false;
        }
        if (pass !== confirm) {
            showError("reg-confirm-error", "Les mots de passe ne correspondent pas.");
            valid = false;
        }
        if (!valid) e.preventDefault();
    });
}

// --- Contact form ---
const contactForm = document.getElementById("contact-form");
if (contactForm) {
    contactForm.addEventListener("submit", e => {
        let valid = true;

        const nom     = document.getElementById("contact-nom").value.trim();
        const email   = document.getElementById("contact-email").value.trim();
        const message = document.getElementById("contact-message").value.trim();

        clearError("contact-nom-error");
        clearError("contact-email-error");
        clearError("contact-message-error");

        if (nom.length < 2) {
            showError("contact-nom-error", "Nom requis.");
            valid = false;
        }
        if (!email || !/\S+@\S+\.\S+/.test(email)) {
            showError("contact-email-error", "Email invalide.");
            valid = false;
        }
        if (message.length < 10) {
            showError("contact-message-error", "Message trop court (min 10 caractères).");
            valid = false;
        }
        if (!valid) e.preventDefault();
    });
}

/* ----------------------------------------------------------
   4. AJAX — Email check on register (real-time)
---------------------------------------------------------- */
const regEmailInput = document.getElementById("reg-email");
if (regEmailInput) {
    let emailTimer;
    regEmailInput.addEventListener("input", () => {
        clearTimeout(emailTimer);
        const email = regEmailInput.value.trim();
        const ajaxResult = document.getElementById("ajax-result");

        if (!email || !/\S+@\S+\.\S+/.test(email)) {
            ajaxResult.textContent = "";
            return;
        }

        emailTimer = setTimeout(() => {
            fetch("back/check_email.php?email=" + encodeURIComponent(email))
                .then(r => r.json())
                .then(data => {
                    if (data.exists) {
                        ajaxResult.textContent = "⚠️ Cet email est déjà utilisé.";
                        ajaxResult.style.color = "#c0436e";
                    } else {
                        ajaxResult.textContent = "✅ Email disponible.";
                        ajaxResult.style.color = "#27ae60";
                    }
                });
        }, 500);
    });
}

/* ----------------------------------------------------------
   5. AJAX — Live search on all.php
---------------------------------------------------------- */
const searchInput = document.getElementById("search-input");
const searchResults = document.getElementById("search-results");

if (searchInput && searchResults) {
    let searchTimer;
    searchInput.addEventListener("input", () => {
        clearTimeout(searchTimer);
        const q = searchInput.value.trim();

        if (q.length < 2) {
            searchResults.innerHTML = "";
            return;
        }

        searchTimer = setTimeout(() => {
            fetch("back/search.php?q=" + encodeURIComponent(q))
                .then(r => r.json())
                .then(machines => {
                    if (machines.length === 0) {
                        searchResults.innerHTML = "<p style='color:#999;'>Aucun résultat trouvé.</p>";
                        return;
                    }
                    let html = "<ul style='list-style:none;padding:0;background:#fff;border:1px solid #f0c0d8;border-radius:10px;overflow:hidden;'>";
                    machines.forEach(m => {
                        html += `<li style="padding:10px 15px;border-bottom:1px solid #fce8f3;">
                            <strong style="color:#6b1d3e;">${m.nom}</strong>
                            <span style="float:right;color:#e05c8a;">${m.prix} DT</span>
                            <br><small style="color:#999;">${m.categorie}</small>
                        </li>`;
                    });
                    html += "</ul>";
                    searchResults.innerHTML = html;
                });
        }, 400);
    });
}

/* ----------------------------------------------------------
   6. Add to cart — all.php (instant, no modal)
---------------------------------------------------------- */
document.querySelectorAll(".btn-panier").forEach(btn => {
    btn.addEventListener("click", () => {
        const machineId  = btn.dataset.id;
        const machineNom = btn.dataset.nom;

        btn.disabled = true;
        btn.textContent = "Ajout...";

        fetch("back/panier_action.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ action: "panier", machine_id: machineId })
        })
        .then(r => r.json())
        .then(data => {
            btn.disabled = false;
            btn.textContent = "🛒 Ajouter au panier";
            if (data.success) {
                // Save commande_id in sessionStorage so panier.php can track it
                const ids = JSON.parse(sessionStorage.getItem("panier_ids") || "[]");
                ids.push(data.commande_id);
                sessionStorage.setItem("panier_ids", JSON.stringify(ids));

                // Also tell PHP via a quick call to sync session
                fetch("back/panier_sync.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ id: data.commande_id })
                });

                showToast(data.message);
            }
        })
        .catch(() => {
            btn.disabled = false;
            btn.textContent = "🛒 Ajouter au panier";
            showToast("❌ Erreur réseau.");
        });
    });
});

function showToast(msg) {
    const toast = document.getElementById("toast");
    if (!toast) return;
    toast.textContent = msg;
    toast.style.display = "block";
    setTimeout(() => { toast.style.display = "none"; }, 3000);
}

/* ----------------------------------------------------------
   7. Panier page — buy single item or all items
---------------------------------------------------------- */
const modalOverlay     = document.getElementById("modal-overlay");
const modalClose       = document.getElementById("modal-close");
const modalTitle       = document.getElementById("modal-title");
const modalMachineName = document.getElementById("modal-machine-name");
const modalConfirmBtn  = document.getElementById("modal-confirm-btn");
const modalFormDiv     = document.getElementById("modal-form");
const modalSuccess     = document.getElementById("modal-success");
const modalSuccessMsg  = document.getElementById("modal-success-msg");

// IDs to buy: either one or all
let buyIds = [];

function openBuyModal(ids, label) {
    if (!modalOverlay) return;
    buyIds = ids;
    modalMachineName.textContent = label;
    modalFormDiv.style.display    = "block";
    modalSuccess.style.display    = "none";
    document.getElementById("panier-nom").value   = "";
    document.getElementById("panier-email").value = "";
    document.getElementById("panier-phone").value = "";
    clearError("panier-nom-error");
    clearError("panier-email-error");
    clearError("panier-phone-error");
    modalConfirmBtn.disabled    = false;
    modalConfirmBtn.textContent = "✅ Confirmer l'achat";
    modalOverlay.style.display  = "flex";
}

// Buy single item
document.querySelectorAll(".btn-acheter-item").forEach(btn => {
    btn.addEventListener("click", () => {
        const id   = btn.dataset.id;
        const name = btn.closest(".panier-item").querySelector("h3").textContent;
        openBuyModal([id], name);
    });
});

// Buy all
const btnAll = document.getElementById("btn-acheter-tout");
if (btnAll) {
    btnAll.addEventListener("click", () => {
        const allIds = [...document.querySelectorAll(".btn-acheter-item")].map(b => b.dataset.id);
        openBuyModal(allIds, "Tous les articles du panier");
    });
}

// Close modal
if (modalClose) modalClose.addEventListener("click", () => { modalOverlay.style.display = "none"; });
if (modalOverlay) modalOverlay.addEventListener("click", e => {
    if (e.target === modalOverlay) modalOverlay.style.display = "none";
});

// Confirm buy
if (modalConfirmBtn) {
    modalConfirmBtn.addEventListener("click", () => {
        const nom   = document.getElementById("panier-nom").value.trim();
        const email = document.getElementById("panier-email").value.trim();
        const phone = document.getElementById("panier-phone").value.trim();

        clearError("panier-nom-error");
        clearError("panier-email-error");
        clearError("panier-phone-error");

        let valid = true;
        if (nom.length < 2)                        { showError("panier-nom-error",   "Nom requis.");          valid = false; }
        if (!/\S+@\S+\.\S+/.test(email))           { showError("panier-email-error", "Email invalide.");      valid = false; }
        if (phone.length < 8)                      { showError("panier-phone-error", "Téléphone invalide.");  valid = false; }
        if (!valid) return;

        modalConfirmBtn.disabled    = true;
        modalConfirmBtn.textContent = "Envoi...";

        // Buy each item sequentially
        const promises = buyIds.map(id =>
            fetch("back/panier_action.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ action: "achete", commande_id: id, nom, email, phone })
            }).then(r => r.json())
        );

        Promise.all(promises).then(results => {
            const allOk = results.every(r => r.success);
            if (allOk) {
                modalFormDiv.style.display  = "none";
                modalSuccess.style.display  = "block";
                modalSuccessMsg.textContent = "✅ Achat confirmé ! Merci " + nom + " 🎉";

                // Remove bought items from page
                buyIds.forEach(id => {
                    const el = document.getElementById("item-" + id);
                    if (el) el.remove();
                });

                // Update total
                updateTotal();

                setTimeout(() => { modalOverlay.style.display = "none"; }, 3000);
            } else {
                modalConfirmBtn.disabled    = false;
                modalConfirmBtn.textContent = "✅ Confirmer l'achat";
                showError("panier-phone-error", "Une erreur est survenue.");
            }
        });
    });
}

function updateTotal() {
    const prices = [...document.querySelectorAll(".panier-prix")];
    const total  = prices.reduce((sum, el) => sum + parseFloat(el.textContent), 0);
    const el     = document.getElementById("panier-total-montant");
    if (el) el.textContent = total.toFixed(2);
    if (prices.length === 0) location.reload(); // cart empty, reload to show empty state
}

// Remove item from cart
document.querySelectorAll(".btn-supprimer-item").forEach(btn => {
    btn.addEventListener("click", () => {
        const id = btn.dataset.id;
        fetch("back/panier_remove.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ id })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                const el = document.getElementById("item-" + id);
                if (el) el.remove();
                updateTotal();
            }
        });
    });
});
