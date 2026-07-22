<nav class="navbar navbar-dark custom-navbar">
    <div class="container">

        <a class="navbar-brand" href="index.php">
            <span class="drop">🩸</span> Smart Blood Bank
        </a>

        <button class="menu-btn" id="desktopMenuBtn">
            ☰
        </button>

    </div>
</nav>

<div class="glass-menu" id="desktopMenu">

    <a href="index.php">🏠 Home</a>
    <a href="about.php">ℹ️ About</a>
    <a href="search.php">🔍 Find Donors</a>
    <a href="contact.php">📞 Contact</a>
    <a href="register.php">📝 Register</a>
    <a href="login.php">🔑 Login</a>
    <a href="admin/login.php">🛡 Admin</a>

</div>

<script>
const menuBtn = document.getElementById("desktopMenuBtn");
const menu = document.getElementById("desktopMenu");

menuBtn.onclick = () => {
    menu.classList.toggle("show");
}

window.addEventListener("scroll", () => {
    menu.classList.remove("show");
});

document.addEventListener("click", function(e){
    if(!menu.contains(e.target) && !menuBtn.contains(e.target)){
        menu.classList.remove("show");
    }
});
</script>