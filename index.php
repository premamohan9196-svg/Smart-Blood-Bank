<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Smart Blood Bank — Donate Blood, Save Lives</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="assets/css/theme.css">

</head>
<body>

<?php include 'navbar.php'; ?>



<!-- ================= HERO ================= -->
<section class="hero">
  <div class="container">
    <div class="row">
      <div class="col-lg-8">

        <div class="eyebrow-line">
          <span class="dot"></span> Every 2 seconds, someone needs blood
        </div>

        <h1 class="font-display">GIVE THE GIFT ONLY <em>YOU</em> CAN GIVE.</h1>

        <p class="lead">
          One donation of blood can help save up to three lives. Register as a donor,
          search for a match, or raise an emergency request — all from one trusted platform.
        </p>

        <div class="d-flex flex-wrap gap-2">
          <a href="register.php" class="btn-gold">Become a Donor</a>
          <a href="request.php" class="btn-brand-outline">Request Blood</a>
        </div>

      </div>
    </div>
  </div>
</section>

<!-- ============ PULSE / STAT STRIP ============ -->
<section class="pulse-strip">
  <div class="container">

    <svg class="pulse-line-svg" viewBox="0 0 1200 70" preserveAspectRatio="none" aria-hidden="true">
      <polyline points="0,35 260,35 300,10 330,60 360,35 520,35 555,15 580,55 605,35 780,35 815,12 840,58 865,35 1040,35 1070,15 1095,55 1120,35 1200,35"
        fill="none" stroke="#cfa5aa" stroke-width="2.5" stroke-linejoin="round" stroke-linecap="round" opacity="0.28"/>
    </svg>

    <div class="pulse-stats">
      <div>
        <div class="stat-num">500+</div>
        <div class="stat-label">Registered Donors</div>
      </div>
      <div>
        <div class="stat-num">150+</div>
        <div class="stat-label">Blood Requests</div>
      </div>
      <div>
        <div class="stat-num">300+</div>
        <div class="stat-label">Lives Saved</div>
      </div>
      <div>
        <div class="stat-num">24/7</div>
        <div class="stat-label">Emergency Support</div>
      </div>
    </div>

  </div>
</section>

<!-- ================= FEATURES ================= -->
<section class="py-5">
  <div class="container py-4">

    <div class="section-head">
      <div class="text-eyebrow">How it works</div>
      <h2 class="font-display">Three ways to be part of the story</h2>
      <p>Whether you're giving blood or need it urgently, the process takes minutes — not days.</p>
    </div>

    <div class="row g-4">

      <div class="col-lg-4 col-md-6">
        <div class="feature-card">
          <div class="icon-badge"><i class="bi bi-heart-pulse"></i></div>
          <h3>Become a Donor</h3>
          <p>Register with your blood group and city so patients nearby can find and reach you when it matters most.</p>
          <a href="register.php" class="card-link">Register now <i class="bi bi-arrow-right"></i></a>
        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="feature-card">
          <div class="icon-badge"><i class="bi bi-search"></i></div>
          <h3>Search Blood</h3>
          <p>Filter verified donors instantly by blood group and location — no phone trees, no delays.</p>
          <a href="search.php" class="card-link">Search donors <i class="bi bi-arrow-right"></i></a>
        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="feature-card">
          <div class="icon-badge"><i class="bi bi-hospital"></i></div>
          <h3>Emergency Request</h3>
          <p>Raise a request with patient and hospital details, and track its status until it's fulfilled.</p>
          <a href="request.php" class="card-link">Request blood <i class="bi bi-arrow-right"></i></a>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ================= CTA BANNER ================= -->
<section class="py-4">
  <div class="container">
    <div class="cta-banner">
      <div class="row align-items-center">
        <div class="col-lg-8">
          <h2 class="font-display">Your blood type could be someone's only match today.</h2>
          <p>It takes about 30 minutes to donate. It could take a lifetime away from someone if you don't.</p>
          <a href="register.php" class="btn-gold">Join as a Donor <i class="bi bi-arrow-right ms-1"></i></a>
        </div>
      </div>
    </div>
  </div>
</section>



<?php include 'footer.php'; ?>
<script src="chatbot.js"></script>
<link rel="stylesheet" href="chatbot.css">

<div class="chat-icon" onclick="openChat()"><P>💬</P></div>

<div class="chat-box" id="chatBox">

    <div class="chat-header">
        🤖 Smart Blood Assistant
        <span onclick="closeChat()">×</span>
    </div>

    <div id="chatBody">
        <div class="bot-message">
            👋 Hello! Welcome to Smart Blood Donation System.
        </div>
    </div>

    <div class="chat-footer">
        <input type="text" id="userInput" placeholder="Type your question...">
        <button id="sendBtn" type="button">Send</button>
    </div>

</div>

<script>
function openChat(){
    document.getElementById("chatBox").style.display="block";
}

function closeChat(){
    document.getElementById("chatBox").style.display="none";
}
</script>
<script>
let lastScrollTop = 0;
const navbar = document.querySelector(".custom-navbar");

window.addEventListener("scroll", function () {

    let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

    if (scrollTop > lastScrollTop && scrollTop > 50) {
        // Scroll Down -> Hide Navbar
        navbar.classList.add("hide");
    } else {
        // Scroll Up -> Show Navbar
        navbar.classList.remove("hide");
    }

    lastScrollTop = scrollTop;
});
</script>


</body>
</html>
