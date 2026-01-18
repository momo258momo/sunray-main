let images = [];
let currentIndex = 0;
let maxStock = 0;

function openModal(i){
    currentIndex = i;
    modalImage.src = images[i];
    imageModal.style.display = 'flex';
}

function closeModal(){
    imageModal.style.display = 'none';
}

function changeImage(step){
    currentIndex = (currentIndex + step + images.length) % images.length;
    modalImage.src = images[currentIndex];
}

document.addEventListener('DOMContentLoaded', () => {
    images = window.productImages || [];
    maxStock = window.productStock || 0;

    const qty = document.getElementById('quantity');
    const increase = document.getElementById('increase');
    const decrease = document.getElementById('decrease');

    if(!qty) return;

    increase.onclick = () => {
        if (+qty.value < maxStock) qty.value++;
    };

    decrease.onclick = () => {
        if (+qty.value > 1) qty.value--;
    };
});
function buyNow() {
    document.getElementById('buyNowInput').value = 1;
}
