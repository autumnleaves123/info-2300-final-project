// referenced from https://www.w3schools.com/howto/howto_js_lightbox.asp

// open lightbox
function openLightbox() {
  document.getElementById('lightbox-section').style.display = "block";
}

// close lightbox
function closeLightbox() {
  document.getElementById('lightbox-section').style.display = "none";
}

var imageIndex = 1;
showImages(imageIndex);

// arrow controls
function plusImages(n) {
  showImages(imageIndex += n);
}

// thumbnail controls
function currentImage(n) {
  showImages(imageIndex = n);
}

function showImages(n) {
  var i;
  var images = document.getElementsByClassName("lightbox-image");
  if (n > images.length) {imageIndex = 1}
  if (n < 1) {imageIndex = images.length}
  for (i = 0; i < images.length; i++) {
    images[i].style.display = "none";
  }
  images[imageIndex-1].style.display = "block";
}
