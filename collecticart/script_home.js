// Mobile Navigation Toggle
const hamburger = document.querySelector('.hamburger');
const navMenu = document.querySelector('.nav-menu');

hamburger.addEventListener('click', () => {
    hamburger.classList.toggle('active');
    navMenu.classList.toggle('active');
});

// Close mobile menu when clicking on a link
document.querySelectorAll('.nav-link').forEach(n => n.addEventListener('click', () => {
    hamburger.classList.remove('active');
    navMenu.classList.remove('active');
}));

// Add to Cart functionality
document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function() {
        const productName = this.parentElement.querySelector('h3').textContent;
        const productPrice = this.parentElement.querySelector('.price').textContent;
        
        // Show notification
        showNotification(`${productName} added to cart!`);
        
        // cart functionality here (wip)
        console.log(`Added to cart: ${productName} - ${productPrice}`);
    });
});

// Notification function
function showNotification(message) {
    // notification element
    const notification = document.createElement('div');
    notification.className = 'notification';
    notification.textContent = message;
    
    // notif style
    notification.style.cssText = `
        position: fixed;
        top: 100px;
        right: 20px;
        background: #27ae60;
        color: white;
        padding: 15px 20px;
        border-radius: 5px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 10000;
        transform: translateX(100%);
        transition: transform 0.3s ease;
    `;
    
    // Add to page
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// Smooth scrolling - anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// scroll effect to navbar
window.addEventListener('scroll', () => {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 100) {
        navbar.style.background = 'rgba(255, 255, 255, 0.95)';
        navbar.style.backdropFilter = 'blur(10px)';
    } else {
        navbar.style.background = '#fff';
        navbar.style.backdropFilter = 'none';
    }
});

// Product card hover effects
document.querySelectorAll('.product-card').forEach(card => {
    card.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-10px) scale(1.02)';
    });
    
    card.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0) scale(1)';
    });
});

// Category card click handlers
document.querySelectorAll('.category-card').forEach(card => {
    card.addEventListener('click', function() {
        const category = this.querySelector('h3').textContent;
        // add category filtering functionality here (wip)
        console.log(`Selected category: ${category}`);
    });
});

// Form validation for contact form
const contactForm = document.querySelector('#contact-form');
if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const name = this.querySelector('#name').value;
        const email = this.querySelector('#email').value;
        const message = this.querySelector('#message').value;
        
        if (!name || !email || !message) {
            showNotification('Please fill in all fields!');
            return;
        }
        
        if (!isValidEmail(email)) {
            showNotification('Please enter a valid email address!');
            return;
        }
        
        // Simulate form submission
        showNotification('Message sent successfully!');
        this.reset();
    });
}

// Email validation function
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Lazy loading for images
document.addEventListener('DOMContentLoaded', function() {
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

// FAQ Accordion functionality
document.querySelectorAll('.faq-question').forEach(question => {
    question.addEventListener('click', function() {
        const answer = this.nextElementSibling;
        const icon = this.querySelector('i');
        
        // Toggle answer visibility
        if (answer.style.maxHeight) {
            answer.style.maxHeight = null;
            icon.style.transform = 'rotate(0deg)';
        } else {
            answer.style.maxHeight = answer.scrollHeight + 'px';
            icon.style.transform = 'rotate(180deg)';
        }
    });
});

// Copy discount codes functionality
document.querySelectorAll('.copy-code').forEach(button => {
    button.addEventListener('click', function() {
        const code = this.dataset.code;
        navigator.clipboard.writeText(code).then(() => {
            const originalText = this.textContent;
            this.textContent = 'Copied!';
            this.style.background = '#27ae60';
            
            setTimeout(() => {
                this.textContent = originalText;
                this.style.background = '#3498db';
            }, 2000);
        });
    });
});

// Countdown timer for advertisements page
function updateCountdown() {
    const daysElement = document.getElementById('days');
    const hoursElement = document.getElementById('hours');
    const minutesElement = document.getElementById('minutes');
    const secondsElement = document.getElementById('seconds');
    
    if (daysElement && hoursElement && minutesElement && secondsElement) {
        // Set target date (2 days from now)
        const targetDate = new Date();
        targetDate.setDate(targetDate.getDate() + 2);
        
        const timer = setInterval(() => {
            const now = new Date().getTime();
            const distance = targetDate.getTime() - now;
            
            if (distance < 0) {
                clearInterval(timer);
                daysElement.textContent = '00';
                hoursElement.textContent = '00';
                minutesElement.textContent = '00';
                secondsElement.textContent = '00';
                return;
            }
            
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            daysElement.textContent = days.toString().padStart(2, '0');
            hoursElement.textContent = hours.toString().padStart(2, '0');
            minutesElement.textContent = minutes.toString().padStart(2, '0');
            secondsElement.textContent = seconds.toString().padStart(2, '0');
        }, 1000);
    }
}

// Initialize countdown timer
updateCountdown();

// Product search and filter functionality
const searchInput = document.getElementById('search-input');
const categoryFilter = document.getElementById('category-filter');
const priceFilter = document.getElementById('price-filter');
const sortFilter = document.getElementById('sort-filter');
const productsGrid = document.getElementById('products-grid');

function filterProducts() {
    const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
    const category = categoryFilter ? categoryFilter.value : '';
    const priceRange = priceFilter ? priceFilter.value : '';
    const sortBy = sortFilter ? sortFilter.value : '';
    
    const products = document.querySelectorAll('.product-card');
    
    products.forEach(product => {
        const productName = product.querySelector('h3').textContent.toLowerCase();
        const productCategory = product.dataset.category;
        const productPrice = parseFloat(product.dataset.price);
        
        let showProduct = true;
        
        // Search filter
        if (searchTerm && !productName.includes(searchTerm)) {
            showProduct = false;
        }
        
        // Category filter
        if (category && productCategory !== category) {
            showProduct = false;
        }
        
        // Price filter
        if (priceRange) {
            const [min, max] = priceRange.split('-').map(p => p === '+' ? Infinity : parseFloat(p));
            if (productPrice < min || (max !== Infinity && productPrice > max)) {
                showProduct = false;
            }
        }
        
        product.style.display = showProduct ? 'block' : 'none';
    });
    
    // Sort products
    if (sortBy && productsGrid) {
        const productsArray = Array.from(products);
        productsArray.sort((a, b) => {
            const nameA = a.querySelector('h3').textContent;
            const nameB = b.querySelector('h3').textContent;
            const priceA = parseFloat(a.dataset.price);
            const priceB = parseFloat(b.dataset.price);
            
            switch (sortBy) {
                case 'name':
                    return nameA.localeCompare(nameB);
                case 'price-low':
                    return priceA - priceB;
                case 'price-high':
                    return priceB - priceA;
                default:
                    return 0;
            }
        });
        
        productsArray.forEach(product => productsGrid.appendChild(product));
    }
}

// Add event listeners for filters
if (searchInput) searchInput.addEventListener('input', filterProducts);
if (categoryFilter) categoryFilter.addEventListener('change', filterProducts);
if (priceFilter) priceFilter.addEventListener('change', filterProducts);
if (sortFilter) sortFilter.addEventListener('change', filterProducts);

// Load more products functionality
const loadMoreBtn = document.getElementById('load-more-btn');
if (loadMoreBtn) {
    loadMoreBtn.addEventListener('click', function() {
        // Simulate loading more products
        this.textContent = 'Loading...';
        this.disabled = true;
        
        setTimeout(() => {
            // Add more product cards here
            this.textContent = 'Load More Products';
            this.disabled = false;
            showNotification('More products loaded!');
        }, 2000);
    });
}

// Newsletter signup functionality
const newsletterForm = document.querySelector('.newsletter-form');
if (newsletterForm) {
    newsletterForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const email = this.querySelector('input[type="email"]').value;
        
        if (isValidEmail(email)) {
            showNotification('Thank you for subscribing! Check your email for a 10% discount code.');
            this.reset();
        } else {
            showNotification('Please enter a valid email address.');
        }
    });
}

// Wishlist functionality
document.querySelectorAll('.wishlist').forEach(button => {
    button.addEventListener('click', function() {
        const icon = this.querySelector('i');
        const productName = this.closest('.product-card').querySelector('h3').textContent;
        
        if (icon.classList.contains('far')) {
            icon.classList.remove('far');
            icon.classList.add('fas');
            this.style.background = '#e74c3c';
            this.style.color = 'white';
            this.style.borderColor = '#e74c3c';
            showNotification(`${productName} added to wishlist!`);
        } else {
            icon.classList.remove('fas');
            icon.classList.add('far');
            this.style.background = '#f8f9fa';
            this.style.color = '#666';
            this.style.borderColor = '#ddd';
            showNotification(`${productName} removed from wishlist!`);
        }
    });
}); 