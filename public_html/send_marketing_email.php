<?php
// PHP Script to Send HTML Email for Marketing (Secured with a Secret Key)

// --- SECURITY CONFIGURATION (IMPORTANT: CHANGE THESE VALUES) ---
define('SECRET_ACCESS_KEY', 'MAYANK_1234567890ABCDEF'); // <--- CHANGE THIS TO A LONG, RANDOM STRING!
// Example: generate a long string using a password generator or a random string generator.
// e.g., 'aB4cDeF7gHiJkLmN0pQrStUvWxFyZ2wX5yZ8aB1cDeF4gHiJkLmN0pQrStUvWxFyZ'

// --- EMAIL CONFIGURATION (IMPORTANT: Customize these values) ---
$recipient_email = "mmayankpatodiaa@gmail.com"; // **CHANGE THIS: The email address you want to send to**
$sender_email = "contact@elevative.xyz"; // **CHANGE THIS: Your sender email address (e.g., info@yourcompany.com)**
$sender_name = "Elevative"; // **CHANGE THIS: Your company name**
$email_subject = "Elevate Your Digital Presence with Elevative!"; // **CHANGE THIS: Your email subject line**

// Path to your HTML email template file on your server
// IMPORTANT: Ideally, this file should be OUTSIDE your public web root (e.g., above public_html/htdocs)
// For now, assuming it's in the same directory or a sub-directory, but see section 2 below.
$template_file_path = __DIR__ . '/../private_files/email_template.html';

// --- SECURITY CHECK ---
if (!isset($_GET['key']) || $_GET['key'] !== SECRET_ACCESS_KEY) {
    // If the key is missing or incorrect, deny access
    http_response_code(403); // Forbidden
    die("Access Denied: Invalid or missing secret key.");
}

// --- REST OF THE EMAIL SENDING LOGIC ---

// 1. Check if the template file exists
if (!file_exists($template_file_path)) {
    die("Error: Email template file not found at " . htmlspecialchars($template_file_path));
}

// 2. Load the HTML content of the email template
$html_content = file_get_contents($template_file_path);

// 3. Replace placeholders in the HTML content
// IMPORTANT: Replace ALL placeholders with your actual values.
// This is critical for the email to function and display correctly.
$html_content = str_replace('https://www.tailorbrands.com/logo-maker', 'http://elevative.xyz/assets/images/logo/logo-white.png', $html_content); // Replace with actual logo URL
$html_content = str_replace('[Your Website URL]', 'https://www.elevative.xyz', $html_content);
$html_content = str_replace('[Your Services Page URL]', 'https://www.elevative.xyz/services.html', $html_content);
$html_content = str_replace('[Your Web Design Service URL]', 'https://www.elevative.xyz/services.html', $html_content);
$html_content = str_replace('[Your Digital Marketing Service URL]', 'https://www.elevative.xyz/services.html', $html_content);
$html_content = str_replace('[Your Contact Page URL]', 'https://www.elevative.xyz/contact.php', $html_content);
$html_content = str_replace('[Your Company Address, City, State, Zip]', 'Kolkata, West Bengal, India', $html_content);
$html_content = str_replace('[Your Facebook URL]', 'https://facebook.com/elevative', $html_content);
$html_content = str_replace('[Your LinkedIn URL]', 'https://linkedin.com/elevative', $html_content);
$html_content = str_replace('[Your Instagram URL]', 'https://instagram.com/elevative', $html_content);
$html_content = str_replace('[Your WhatsApp URL]', 'https://wa.me/919830778548', $html_content);
// Placeholder for unsubscribe link - THIS IS CRITICAL FOR COMPLIANCE.
// In a real scenario, this would link to a script that removes the user from your list.
$html_content = str_replace('[Unsubscribe Link]', 'https://www.elevative.xyz/unsubscribe.php?email=' . urlencode($recipient_email), $html_content); // <--- CHANGE THIS TO A LONG, RANDOM STRING!


// 4. Set up email headers for HTML content
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "From: " . $sender_name . " <" . $sender_email . ">" . "\r\n";
// Optional: Reply-To header
$headers .= "Reply-To: " . $sender_name . " <" . $sender_email . ">" . "\r\n";
// Optional: X-Mailer header (can sometimes help with deliverability, but not guaranteed)
$headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";

// 5. Send the email
if (mail($recipient_email, $email_subject, $html_content, $headers)) {
    echo "Email sent successfully to " . htmlspecialchars($recipient_email) . "!";
} else {
    echo "Failed to send email. Check your server's mail logs for details.";
    // You can also check error_get_last() for more PHP-specific mail errors
    // $error = error_get_last();
    // echo "<br>PHP Mail Error: " . $error['message'];
}

?>
