window.addEvetListener('scrill', function(){
    var cart = document.querySelector('.cart');
    cart.style.bottom = window.scrollY + 'px';
    cart.style.right = window.scrollX + 'px';
});