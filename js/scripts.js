/*!
* Start Bootstrap - Shop Homepage v5.0.5 (https://startbootstrap.com/template/shop-homepage)
* Copyright 2013-2022 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-shop-homepage/blob/master/LICENSE)
*/
// This file is intentionally blank
// Use this file to add JavaScript to your project

let btnCargar = document.querySelectorAll('.aggCarrito');

console.log(btnCargar);

btnCargar.forEach(agregarAlCarrito => {
    agregarAlCarrito.addEventListener('click', (e)=> {
        
        const boton = e.target;
        const item = boton.closest('.card');
        const itemTitulo = item.querySelector('.title').textContent;
        const itemPrecio = item.querySelector('.price').textContent;
        const itemImg = item.querySelector('.card-img-top').src;
        console.log(itemImg);
    })
})