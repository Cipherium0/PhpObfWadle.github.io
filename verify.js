// Şifreyi otomatik olarak oluşturma fonksiyonu
function generateVerificationCode() {
    const timestamp = Math.floor(Date.now() / 60000); // Dakika bazında zaman damgası
    const code = (timestamp % 900000) + 100000;  // 100000 ile 999999 arasında bir sayı
    return code;
}

// Şifreyi kaydet ve yönlendirme fonksiyonu
function saveCode() {
    const code = generateVerificationCode();
    localStorage.setItem("verificationCode", code);  // Şifreyi localStorage'a kaydet
    alert("Şifre kaydedildi: " + code);
    window.location.href = "config.html";  // config.html sayfasına yönlendir
}
