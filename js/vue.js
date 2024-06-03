var originalImageSrc; 

function changeImage(src) {
    originalImageSrc = document.getElementById('featured-image').src;
    document.getElementById('featured-image').src = src;
}

function restoreOriginalImage() {
    document.getElementById('featured-image').src = originalImageSrc;
}

