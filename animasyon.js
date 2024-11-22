// Yağmur Damlalarının Oluşturulması ve Animasyonu
document.addEventListener("DOMContentLoaded", function() {
    const rainContainer = document.createElement('div');
    rainContainer.classList.add('rain');
    document.body.appendChild(rainContainer);

    const createRainDrop = () => {
        const drop = document.createElement('div');
        drop.classList.add('drop');
        
        // Damlaların başlangıç pozisyonunu ve hızını rasgele yapalım
        drop.style.left = `${Math.random() * 100}vw`;  // Rasgele sağa-sola
        drop.style.animationDuration = `${Math.random() * 2 + 2}s`; // 2-4 saniye arasında hız
        drop.style.animationDelay = `${Math.random() * 2}s`; // Damlalar arasındaki gecikme
        
        rainContainer.appendChild(drop);

        // Damlayı silmek için animasyon bittiğinde temizleyelim
        drop.addEventListener('animationend', () => {
            drop.remove();
        });
    };

    // Damlaların yaratılması
    setInterval(createRainDrop, 30); // Her 30 ms'de yeni damla
});
