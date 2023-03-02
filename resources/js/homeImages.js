var slider = document.querySelector('.slider');
var images = slider.getElementsByTagName('img');
var totalWidth = 0;

for (var i = 0; i < images.length; i++) {
  totalWidth += images[i].offsetWidth;
}

slider.style.width = totalWidth + 'px';