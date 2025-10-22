// ===== Sidebar Toggle =====
const sidebar = document.querySelector('.sidebar');
const toggleBtn = document.querySelector('.toggler');

if (toggleBtn) {
    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
    });
}

// ===== Image Preview Functionality =====
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('productImage');
    const previewImg = document.getElementById('previewImg');
    const placeholder = document.getElementById('placeholder');
    const removeBtn = document.getElementById('removeImage');
    const previewBox = document.getElementById('imagePreviewBox');

    // Handle file selection
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            
            if (file) {
                // Check if file is an image
                if (!file.type.startsWith('image/')) {
                    alert('Please select an image file');
                    fileInput.value = '';
                    return;
                }

                // Check file size (5MB max)
                if (file.size > 5 * 1024 * 1024) {
                    alert('File is too large. Maximum size is 5MB.');
                    fileInput.value = '';
                    return;
                }

                // Create FileReader to read the image
                const reader = new FileReader();
                
                reader.onload = function(event) {
                   

                    // Set image source
                    previewImg.src = event.target.result;
                    
                    // Wait for image to load before showing
                    previewImg.onload = function() {
                        // Show image, hide placeholder
                        previewImg.classList.add('show');
                        if (placeholder) {
                            placeholder.style.display = 'none';
                        }
                        if (removeBtn) {
                            removeBtn.classList.add('show');
                        }
                        if (previewBox) {
                            previewBox.classList.add('has-image');
                        }
                    };
                };

                reader.readAsDataURL(file);
            }
        });
    }

    // Handle remove button
    if (removeBtn) {
        removeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Clear file input
            if (fileInput) {
                fileInput.value = '';
            }
            
            // Reset preview
            if (previewImg) {
                previewImg.src = '';
                previewImg.classList.remove('show');
                // Also remove any inline styles that might have been added
                previewImg.removeAttribute('style');
            }
            if (placeholder) {
                placeholder.style.display = 'flex';
            }
            removeBtn.classList.remove('show');
            if (previewBox) {
                previewBox.classList.remove('has-image');
            }
        });
    }
});