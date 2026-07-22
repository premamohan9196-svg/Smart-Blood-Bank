<?php
header('Content-Type: application/json');

$message = strtolower(trim($_POST['message'] ?? ''));

$reply = "🤖 Sorry, I couldn't understand your question. Please ask about blood donation, donor registration, blood request, blood groups, camps, login, or contact information.";

// Greeting
if (
    strpos($message, "hi") !== false ||
    strpos($message, "hello") !== false ||
    strpos($message, "hai") !== false
) {

    $reply = "👋 Hello! Welcome to Smart Blood Donation System. How can I help you today?";

// Blood Donation
} elseif (
    strpos($message, "blood donation") !== false ||
    strpos($message, "donation") !== false
) {

    $reply = "🩸 Blood donation saves lives. Click on 'Become a Donor', fill in your details and submit the registration form.";

// Become Donor
} elseif (
    strpos($message, "donor") !== false ||
    strpos($message, "donate") !== false ||
    strpos($message, "become donor") !== false
) {

    $reply = "❤️ To become a donor:<br><br>
    1️⃣ Register/Login<br>
    2️⃣ Click 'Become Donor'<br>
    3️⃣ Fill the donor form<br>
    4️⃣ Submit your details";

// Blood Request
} elseif (
    strpos($message, "blood request") !== false ||
    strpos($message, "request blood") !== false ||
    strpos($message, "request") !== false
) {

    $reply = "📝 Go to the Blood Request page, enter patient details, blood group, hospital name and submit your request.";

// Search Donor
} elseif (
    strpos($message, "search donor") !== false ||
    strpos($message, "find donor") !== false ||
    strpos($message, "search") !== false
) {

    $reply = "🔍 Open the Search Blood page, select the blood group and search for available donors.";

// Register
} elseif (strpos($message, "register") !== false) {

    $reply = "📝 Click the Register menu and create your account before using the system.";

// Login
} elseif (strpos($message, "login") !== false) {

    $reply = "🔐 Click Login and enter your Email ID and Password.";

// Blood Group
} elseif (
    strpos($message, "blood group") !== false ||
    strpos($message, "group") !== false
) {

    $reply = "🩸 Available Blood Groups:<br>
    🔴 A+<br>
    🔴 A-<br>
    🔴 B+<br>
    🔴 B-<br>
    🔴 AB+<br>
    🔴 AB-<br>
    🔴 O+<br>
    🔴 O-";

// Eligibility
} elseif (
    strpos($message, "eligible") !== false ||
    strpos($message, "eligibility") !== false
) {

    $reply = "❤️ A healthy person aged 18 to 65 years and weighing at least 50 kg can usually donate blood.";

// Camp
} elseif (
    strpos($message, "camp") !== false ||
    strpos($message, "blood camp") !== false
) {

    $reply = "📅 Visit the Blood Donation Camps page to see upcoming donation camps.";

// Emergency
} elseif (
    strpos($message, "emergency") !== false ||
    strpos($message, "urgent") !== false
) {

    $reply = "🚨 For emergency blood requirements, immediately submit a Blood Request or contact the administrator.";

// Contact
} elseif (
    strpos($message, "contact") !== false ||
    strpos($message, "phone") !== false ||
    strpos($message, "email") !== false
) {

    $reply = "📞 Contact Information:<br><br>
    📧 admin@bloodbank.com<br>
    ☎️ +91 9876543210";

// About
} elseif (
    strpos($message, "about") !== false
) {

    $reply = "🏥 Smart Blood Donation System helps connect blood donors with patients quickly and efficiently.";

// Thanks
} elseif (
    strpos($message, "thanks") !== false ||
    strpos($message, "thank you") !== false
) {

    $reply = "😊 You're welcome! Happy to help. Have a wonderful day!";

// Bye
} elseif (
    strpos($message, "bye") !== false
) {

    $reply = "👋 Goodbye! Stay healthy and thank you for supporting blood donation.";

}

echo json_encode([
    "reply" => $reply
]);
?>