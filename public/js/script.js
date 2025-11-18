// Dashboard Interactivity
document.addEventListener('DOMContentLoaded', function() {
    // Option card selection
    const optionCards = document.querySelectorAll('.option-card');
    
    optionCards.forEach(card => {
        card.addEventListener('click', function() {
            // Remove active class from all cards
            optionCards.forEach(c => c.classList.remove('active'));
            
            // Add active class to clicked card
            this.classList.add('active');
            
            // Get the value of the selected option
            const value = this.getAttribute('data-value');
            console.log(`Selected option: ${value}`);
        });
    });
    
    // Category card selection
    const categoryCards = document.querySelectorAll('.category-card');
    
    categoryCards.forEach(card => {
        card.addEventListener('click', function() {
            const categoryName = this.querySelector('span').textContent;
            console.log(`Selected category: ${categoryName}`);
            alert(`Anda memilih kategori: ${categoryName}`);
        });
    });
    
    // Add animation to cards on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observe all cards for animation
    const cards = document.querySelectorAll('.option-card, .category-card, .feature-card, .popular-card, .special-card');
    cards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        observer.observe(card);
    });
    
    // Add hover effects to special badges
    const specialBadges = document.querySelectorAll('.special-badge');
    specialBadges.forEach(badge => {
        badge.addEventListener('mouseover', function() {
            this.style.transform = 'scale(1.1)';
        });
        
        badge.addEventListener('mouseout', function() {
            this.style.transform = 'scale(1)';
        });
    });
    
    // Simulate loading animation
    setTimeout(() => {
        document.body.classList.add('loaded');
    }, 500);

    // Flash Sale Countdown Timer
    function updateFlashSaleTimer() {
        const hoursElement = document.getElementById('hours');
        const minutesElement = document.getElementById('minutes');
        const secondsElement = document.getElementById('seconds');
        
        if (hoursElement && minutesElement && secondsElement) {
            let hours = parseInt(hoursElement.textContent);
            let minutes = parseInt(minutesElement.textContent);
            let seconds = parseInt(secondsElement.textContent);
            
            // Decrement seconds
            seconds--;
            
            if (seconds < 0) {
                seconds = 59;
                minutes--;
                
                if (minutes < 0) {
                    minutes = 59;
                    hours--;
                    
                    if (hours < 0) {
                        // Timer ended
                        hours = 0;
                        minutes = 0;
                        seconds = 0;
                        clearInterval(timerInterval);
                        document.querySelector('.sale-timer').innerHTML = '<div class="sale-ended">Flash Sale Ended!</div>';
                        return;
                    }
                }
            }
            
            // Update display
            hoursElement.textContent = hours.toString().padStart(2, '0');
            minutesElement.textContent = minutes.toString().padStart(2, '0');
            secondsElement.textContent = seconds.toString().padStart(2, '0');
        }
    }

    // Start the flash sale timer
    let timerInterval;
    timerInterval = setInterval(updateFlashSaleTimer, 1000);
    
    // Buy Now button functionality for Flash Sale
    const flashSaleBuyButtons = document.querySelectorAll('.flash-sale-card .buy-now-btn');
    flashSaleBuyButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productCard = this.closest('.flash-sale-card');
            const productName = productCard.querySelector('h4').textContent;
            
            // Add animation
            this.textContent = 'Added to Cart!';
            this.style.background = 'linear-gradient(135deg, #4CAF50, #45a049)';
            
            setTimeout(() => {
                this.textContent = 'Buy Now';
                this.style.background = 'linear-gradient(135deg, #ff6b6b, #ff8e8e)';
            }, 2000);
        });
    });
    
    // Update individual product timers every second
    setInterval(() => {
        document.querySelectorAll('.time-left').forEach(timer => {
            const timeText = timer.textContent.replace('⏰ ', '');
            const [hours, minutes, seconds] = timeText.split(':').map(Number);
            
            let newSeconds = seconds - 1;
            let newMinutes = minutes;
            let newHours = hours;
            
            if (newSeconds < 0) {
                newSeconds = 59;
                newMinutes--;
                
                if (newMinutes < 0) {
                    newMinutes = 59;
                    newHours--;
                    
                    if (newHours < 0) {
                        timer.textContent = '⏰ Sale Ended!';
                        return;
                    }
                }
            }
            
            timer.textContent = `⏰ ${newHours.toString().padStart(2, '0')}:${newMinutes.toString().padStart(2, '0')}:${newSeconds.toString().padStart(2, '0')}`;
        });
    }, 1000);

    // Buy Now functionality untuk Specials Section
    const specialsBuyButtons = document.querySelectorAll('.specials-section .buy-now-btn');
    specialsBuyButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productName = this.getAttribute('data-product');
            const originalText = this.innerHTML;
            
            // Animation feedback
            this.innerHTML = '✓ Ditambahkan!';
            this.style.background = 'linear-gradient(135deg, #4CAF50, #45a049)';
            
            // Show notification
            showSpecialNotification(productName);
            
            // Reset button after 2 seconds
            setTimeout(() => {
                this.innerHTML = originalText;
                this.style.background = 'linear-gradient(135deg, #ff6b6b, #ff8e8e)';
            }, 2000);
        });
    });
    
    // Function untuk show special notification
    function showSpecialNotification(productName) {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = 'special-notification';
        notification.innerHTML = `
            <div class="notification-content">
                <span class="notification-icon">🎉</span>
                <div class="notification-text">
                    <strong>Yeay! Penawaran Spesial!</strong>
                    <span>${productName} berhasil ditambahkan ke keranjang</span>
                </div>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (document.body.contains(notification)) {
                    document.body.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }
    
    // Add hover effects untuk special cards
    const specialCards = document.querySelectorAll('.special-card');
    specialCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            const img = this.querySelector('img');
            const badge = this.querySelector('.special-badge');
            if (img) {
                img.style.transform = 'scale(1.05)';
            }
            if (badge) {
                badge.style.transform = 'scale(1.1)';
            }
        });
        
        card.addEventListener('mouseleave', function() {
            const img = this.querySelector('img');
            const badge = this.querySelector('.special-badge');
            if (img) {
                img.style.transform = 'scale(1)';
            }
            if (badge) {
                badge.style.transform = 'scale(1)';
            }
        });
    });

    // Header Search Functionality
    const searchInput = document.querySelector('.search-input');
    const searchForm = document.querySelector('.search-form');
    
    if (searchInput && searchForm) {
        // Search suggestions click
        document.querySelectorAll('.suggestion-tag').forEach(tag => {
            tag.addEventListener('click', function(e) {
                e.preventDefault();
                searchInput.value = this.textContent;
                // searchForm.submit(); // Uncomment jika sudah ada backend
            });
        });
        
        // Search input focus effect
        searchInput.addEventListener('focus', function() {
            this.parentElement.style.boxShadow = '0 4px 15px rgba(216, 191, 216, 0.3)';
        });
        
        searchInput.addEventListener('blur', function() {
            this.parentElement.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.1)';
        });
    }
    
    // Cart functionality
    const cartButtons = document.querySelectorAll('.quantity-btn');
    const removeButtons = document.querySelectorAll('.remove-item');
    const cartCount = document.querySelector('.cart-count');
    
    cartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const isIncrement = this.textContent === '+';
            updateCartCount(isIncrement ? 1 : -1);
        });
    });
    
    removeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const cartItem = this.closest('.cart-item');
            cartItem.style.opacity = '0';
            setTimeout(() => {
                if (cartItem.parentElement) {
                    cartItem.remove();
                    updateCartCount(-1);
                }
            }, 300);
        });
    });
    
    function updateCartCount(change) {
        if (!cartCount) return;
        
        let currentCount = parseInt(cartCount.textContent) || 0;
        currentCount += change;
        if (currentCount < 0) currentCount = 0;
        cartCount.textContent = currentCount;
        
        // Animation
        cartCount.style.transform = 'scale(1.3)';
        setTimeout(() => {
            cartCount.style.transform = 'scale(1)';
        }, 300);
    }

    // Add to Cart functionality untuk Popular Items
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            console.log('Clicked product ID:', productId);
            
            if (!productId) {
                showNotification('Error: Product ID tidak valid', 'error');
                return;
            }
            
            addToCart(productId, 1);
        });
    });
    
    function addToCart(productId, quantity) {
        // Show loading state
        const button = document.querySelector(`[data-product-id="${productId}"]`);
        if (!button) {
            showNotification('Error: Tombol tidak ditemukan', 'error');
            return;
        }
        
        const originalText = button.innerHTML;
        button.innerHTML = 'Loading...';
        button.disabled = true;
        
        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                product_id: parseInt(productId),
                quantity: parseInt(quantity)
            })
        })
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Success data:', data);
            
            if (data.success) {
                // Update cart count
                updateCartCountElement(data.cart_count);
                showNotification('✅ Produk berhasil ditambahkan ke keranjang!');
            } else {
                throw new Error(data.message || 'Unknown error from server');
            }
        })
        .catch(error => {
            console.error('Detailed error:', error);
            
            if (error.name === 'TypeError' && error.message.includes('Failed to fetch')) {
                showNotification('❌ Gagal terhubung ke server. Periksa koneksi internet Anda.', 'error');
            } else if (error.message.includes('500')) {
                showNotification('❌ Error server internal. Silakan coba lagi.', 'error');
            } else {
                showNotification('❌ Gagal menambahkan produk: ' + error.message, 'error');
            }
        })
        .finally(() => {
            // Reset button state
            button.innerHTML = originalText;
            button.disabled = false;
        });
    }
    
    function updateCartCountElement(count) {
        document.querySelectorAll('.cart-count').forEach(el => {
            el.textContent = count;
        });
    }
    
    function showNotification(message, type = 'success') {
        // Remove existing notifications
        const existing = document.querySelector('.cart-notification');
        if (existing) existing.remove();
        
        const notification = document.createElement('div');
        notification.className = `cart-notification ${type}`;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${type === 'success' ? '#4CAF50' : '#f44336'};
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            z-index: 10000;
            transform: translateX(400px);
            transition: transform 0.3s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            font-family: Arial, sans-serif;
            max-width: 300px;
        `;
        
        notification.innerHTML = `
            <div style="display: flex; align-items: center; gap: 10px;">
                <span style="font-size: 16px;">${message}</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);
        
        // Remove after 4 seconds
        setTimeout(() => {
            notification.style.transform = 'translateX(400px)';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 4000);
    }
    
    // Function untuk show cart notification
    function showCartNotification(productName) {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = 'cart-notification';
        notification.innerHTML = `
            <div class="notification-content">
                <span class="notification-icon">✓</span>
                <span class="notification-text">${productName} added to cart!</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (document.body.contains(notification)) {
                    document.body.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }
    
    // Add hover effects untuk popular cards
    const popularCards = document.querySelectorAll('.popular-card');
    popularCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            const img = this.querySelector('img');
            if (img) {
                img.style.transform = 'scale(1.05)';
            }
        });
        
        card.addEventListener('mouseleave', function() {
            const img = this.querySelector('img');
            if (img) {
                img.style.transform = 'scale(1)';
            }
        });
    });
});