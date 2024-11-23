document.getElementById("loginForm").addEventListener("submit", function (e) {
    e.preventDefault(); // Sayfa yenilenmesini önle

    const password = document.getElementById("password").value;
    const correctPassword = "Sexs0909"; // Sabit şifre

    if (password === correctPassword) {
        // Doğru şifre: verify.html sayfasına yönlendir
        window.location.href = "verify.html";
    } else {
        // Yanlış şifre: hata mesajını göster
        document.getElementById("error").classList.remove("hidden");
    }
});
