
function generateDynamicPassword() {
    const now = new Date();
    const seed = Math.floor(now.getTime() / (3 * 60 * 1000)); // 3 dakikalık blok
    const password = Math.abs(seed).toString().slice(-6); // Son 6 haneyi al
    return password.padStart(6, '0'); // 6 haneli şifre oluştur
}

// Şifreyi güncelleme fonksiyonu
function updateDynamicPassword() {
    const passwordElement = document.getElementById("dynamicPassword");
    const newPassword = generateDynamicPassword();
    passwordElement.textContent = newPassword;
}

// Sayfa yüklendiğinde ve her 3 dakikada bir güncelle
window.onload = function () {
    updateDynamicPassword();
    setInterval(updateDynamicPassword, 3 * 60 * 1000); // Her 3 dakikada bir güncelle
};
