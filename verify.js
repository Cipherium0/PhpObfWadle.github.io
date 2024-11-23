// Random şifre üretme fonksiyonu
function generateRandomCode() {
    const code = Math.floor(Math.random() * 900000) + 100000;  // 100000 ile 999999 arasında bir sayı
    return code;
}

// Şifreyi kaydetme ve yönlendirme fonksiyonu
function generateAndSaveCode() {
    const code = generateRandomCode();
    localStorage.setItem("verificationCode", code);  // Şifreyi localStorage'a kaydet
    alert("Şifre kaydedildi: " + code);
    window.location.href = "config.html";  // config.html sayfasına yönlendir
}
