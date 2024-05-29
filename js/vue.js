var originalImageSrc; // Variable to store the original image source

function changeImage(src) {
    // Store the original image source
    originalImageSrc = document.getElementById('featured-image').src;
    // Change the src attribute of the featured image to the src of the hovered small image
    document.getElementById('featured-image').src = src;
}

function restoreOriginalImage() {
    // Restore the src attribute of the featured image to its original value
    document.getElementById('featured-image').src = originalImageSrc;
}

