/**
 * JavaScript pour la boutique e-commerce
 * Gestion du panier dynamique et interactions utilisateur
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // Gestion de l'ajout au panier via AJAX
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const productId = this.getAttribute('data-product-id');
            const originalText = this.innerHTML;
            
            // Animation de chargement
            this.innerHTML = '<span class="spinner"></span> Ajout...';
            this.disabled = true;
            
            // Requête AJAX vers la nouvelle méthode optimisée
            fetch('index.php?controller=commande&action=ajaxAjouterAuPanier', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `produit_id=${productId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Mise à jour directe du compteur panier avec la réponse JSON
                    const countElement = document.getElementById('panier-count');
                    if (countElement) {
                        countElement.textContent = data.panierCount;
                        // Animation du badge
                        countElement.classList.add('animate__animated', 'animate__pulse');
                        setTimeout(() => {
                            countElement.classList.remove('animate__animated', 'animate__pulse');
                        }, 1000);
                    }
                    
                    // Animation de succès
                    this.innerHTML = '<i class="fas fa-check"></i> Ajouté !';
                    this.classList.remove('btn-primary');
                    this.classList.add('btn-success');
                    
                    // Notification toast
                    showToast(data.message || 'Produit ajouté !', 'success');
                    
                    // Retour à l'état normal après 2 secondes
                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.classList.remove('btn-success');
                        this.classList.add('btn-primary');
                        this.disabled = false;
                    }, 2000);
                } else {
                    throw new Error(data.message || 'Erreur lors de l'ajout');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                this.innerHTML = originalText;
                this.disabled = false;
                showToast('Erreur lors de l\'ajout au panier', 'error');
            });
        });
    });
    
    // Mise à jour du compteur panier
    function updatePanierCount() {
        fetch('index.php?controller=commande&action=getPanierCount')
            .then(response => response.json())
            .then(data => {
                const countElement = document.getElementById('panier-count');
                if (countElement) {
                    countElement.textContent = data.count || 0;
                    
                    // Animation du badge
                    countElement.classList.add('animate__animated', 'animate__pulse');
                    setTimeout(() => {
                        countElement.classList.remove('animate__animated', 'animate__pulse');
                    }, 1000);
                }
            })
            .catch(error => console.error('Erreur mise à jour panier:', error));
    }
    
    // Gestion des quantités dans le panier
    window.updateQuantity = function(productId, change) {
        const quantityInput = document.querySelector(`input[data-product-id="${productId}"]`);
        if (!quantityInput) return;
        
        let currentQuantity = parseInt(quantityInput.value) || 1;
        let newQuantity = currentQuantity + change;
        
        if (newQuantity < 1) {
            newQuantity = 1;
            return;
        }

        fetch('index.php?controller=commande&action=updateQuantity', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `produit_id=${productId}&quantite=${newQuantity}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                quantityInput.value = newQuantity;
                location.reload();
            } else {
                showToast(data.message || 'Erreur lors de la mise à jour', 'error');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showToast('Erreur lors de la mise à jour', 'error');
        });
    };
    
    // Système de notifications toast
    function showToast(message, type = 'info') {
        // Créer le conteneur toast s'il n'existe pas
        let toastContainer = document.getElementById('toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.id = 'toast-container';
            toastContainer.className = 'position-fixed top-0 end-0 p-3';
            toastContainer.style.zIndex = '9999';
            document.body.appendChild(toastContainer);
        }
        
        // Créer le toast
        const toastId = 'toast-' + Date.now();
        const toastHtml = `
            <div id="${toastId}" class="toast align-items-center text-white bg-${type === 'success' ? 'success' : 'danger'} border-0" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        `;
        
        toastContainer.insertAdjacentHTML('beforeend', toastHtml);
        
        // Initialiser et afficher le toast
        const toastElement = document.getElementById(toastId);
        const toast = new bootstrap.Toast(toastElement, {
            autohide: true,
            delay: 3000
        });
        
        toast.show();
        
        // Supprimer le toast après fermeture
        toastElement.addEventListener('hidden.bs.toast', function() {
            this.remove();
        });
    }
    
    // Confirmation de suppression
    const deleteLinks = document.querySelectorAll('a[onclick*="confirm"]');
    deleteLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            const message = this.getAttribute('onclick').match(/confirm\('([^']+)'\)/)[1];
            
            if (confirm(message)) {
                window.location.href = this.href;
            }
        });
    });
    
    // Animation des cartes au scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    // Observer les cartes produits
    const productCards = document.querySelectorAll('.card');
    productCards.forEach(card => {
        observer.observe(card);
    });
    
    // Validation des formulaires
    const forms = document.querySelectorAll('form[data-validate]');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
            }
        });
    });
    
    function validateForm(form) {
        let isValid = true;
        const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
        
        inputs.forEach(input => {
            if (!input.value.trim()) {
                input.classList.add('is-invalid');
                isValid = false;
            } else {
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
            }
        });
        
        // Validation email
        const emailInputs = form.querySelectorAll('input[type="email"]');
        emailInputs.forEach(input => {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (input.value && !emailRegex.test(input.value)) {
                input.classList.add('is-invalid');
                isValid = false;
            }
        });
        
        // Validation mot de passe
        const passwordInputs = form.querySelectorAll('input[name="password"], input[name="confirm_password"]');
        if (passwordInputs.length === 2) {
            if (passwordInputs[0].value !== passwordInputs[1].value) {
                passwordInputs[1].classList.add('is-invalid');
                showToast('Les mots de passe ne correspondent pas', 'error');
                isValid = false;
            }
        }
        
        return isValid;
    }
    
    // Recherche en temps réel (si implémentée)
    const searchInput = document.getElementById('search');
    if (searchInput) {
        let searchTimeout;
        
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            
            searchTimeout = setTimeout(() => {
                const query = this.value.trim();
                if (query.length >= 2) {
                    performSearch(query);
                }
            }, 300);
        });
    }
    
    function performSearch(query) {
        // Implémentation de la recherche AJAX
        console.log('Recherche:', query);
    }
    
    // Gestion du mode sombre (optionnel)
    const darkModeToggle = document.getElementById('dark-mode-toggle');
    if (darkModeToggle) {
        darkModeToggle.addEventListener('click', function() {
            document.body.classList.toggle('dark-mode');
            localStorage.setItem('darkMode', document.body.classList.contains('dark-mode'));
        });
        
        // Restaurer le mode sombre
        if (localStorage.getItem('darkMode') === 'true') {
            document.body.classList.add('dark-mode');
        }
    }
    


    // Lazy loading des images
    const images = document.querySelectorAll('img[data-src]');
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                imageObserver.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
});

// Fonctions utilitaires globales
window.formatPrice = function(price) {
    return new Intl.NumberFormat('fr-FR', {
        style: 'currency',
        currency: 'EUR'
    }).format(price);
};

window.debounce = function(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
};