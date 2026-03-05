<?php
/**
 * =============================================
 * submit.php — Solar Print Process Lead Form Handler
 * Use this as a standalone AJAX endpoint OR
 * the form in index.php already handles submission
 * natively via POST without needing this file.
 *
 * HOW TO USE (AJAX version):
 *   fetch('submit.php', { method:'POST', body: formData })
 *     .then(r => r.json())
 *     .then(data => { if(data.success) showThankyou() })
 * =============================================
 */

header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');

// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// ── CONFIGURE EMAIL HERE ──────────────────────
define('RECIPIENT_EMAIL', 'info@spppl.com');      // ← Your email
define('CC_EMAIL',        '');                     // ← CC email (optional, leave empty)
define('COMPANY_NAME',    'Solar Print Process');
// ─────────────────────────────────────────────

// Honeypot check
if (!empty(trim($_POST['website'] ?? ''))) {
    echo json_encode(['success' => true]); // Silently succeed to fool bots
    exit;
}

// Sanitize inputs
$name     = htmlspecialchars(trim($_POST['name']     ?? ''), ENT_QUOTES, 'UTF-8');
$company  = htmlspecialchars(trim($_POST['company']  ?? ''), ENT_QUOTES, 'UTF-8');
$email    = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$phone    = htmlspecialchars(trim($_POST['phone']    ?? ''), ENT_QUOTES, 'UTF-8');
$pkg_type = htmlspecialchars(trim($_POST['pkg_type'] ?? ''), ENT_QUOTES, 'UTF-8');
$quantity = htmlspecialchars(trim($_POST['quantity'] ?? ''), ENT_QUOTES, 'UTF-8');
$message  = htmlspecialchars(trim($_POST['message']  ?? ''), ENT_QUOTES, 'UTF-8');

// Validation
$errors = [];
if (empty($name))     $errors[] = 'Name is required';
if (empty($phone))    $errors[] = 'Phone is required';
if (empty($pkg_type)) $errors[] = 'Packaging type is required';

if (!empty($errors)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'errors' => $errors]);
    exit;
}

// Rate limiting — simple file-based (1 submission per IP per 60 sec)
$ip       = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$lockFile = sys_get_temp_dir() . '/solar_form_' . md5($ip) . '.lock';
if (file_exists($lockFile) && (time() - filemtime($lockFile)) < 60) {
    http_response_code(429);
    echo json_encode(['success' => false, 'message' => 'Too many submissions. Please wait a minute.']);
    exit;
}
touch($lockFile);

// ── BUILD EMAIL ───────────────────────────────
$subject = "New Packaging Quote Request — {$name}" . ($company ? " ({$company})" : '');

$body  = "=" . str_repeat("=", 48) . "\n";
$body .= "  NEW PACKAGING QUOTE — " . COMPANY_NAME . "\n";
$body .= "=" . str_repeat("=", 48) . "\n\n";
$body .= sprintf("  %-14s %s\n", "Name:",         $name);
$body .= sprintf("  %-14s %s\n", "Company:",      $company ?: '—');
$body .= sprintf("  %-14s %s\n", "Email:",        $email   ?: '—');
$body .= sprintf("  %-14s %s\n", "Phone:",        $phone);
$body .= sprintf("  %-14s %s\n", "Pkg Type:",     $pkg_type);
$body .= sprintf("  %-14s %s\n", "Quantity:",     $quantity ?: '—');
$body .= "\n  MESSAGE / BRIEF:\n  " . ($message ?: 'None provided') . "\n\n";
$body .= str_repeat("-", 50) . "\n";
$body .= "  Submitted: " . date('d M Y, h:i A') . "\n";
$body .= "  IP Address: {$ip}\n";
$body .= "  Source: Landing Page\n";
$body .= str_repeat("=", 50) . "\n";

$headers  = "From: " . COMPANY_NAME . " <noreply@solarprintprocess.com>\r\n";
if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $headers .= "Reply-To: {$name} <{$email}>\r\n";
}
if (!empty(CC_EMAIL)) {
    $headers .= "Cc: " . CC_EMAIL . "\r\n";
}
$headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Send email
$sent = mail(RECIPIENT_EMAIL, $subject, $body, $headers);

if ($sent) {
    // Optional: log to a CSV file
    $logFile = __DIR__ . '/leads_log.csv';
    $logRow  = [
        date('Y-m-d H:i:s'),
        $name, $company, $email, $phone,
        $pkg_type, $quantity,
        str_replace(["\r","\n"], ' ', $message),
        $ip
    ];
    $fp = fopen($logFile, 'a');
    if ($fp) {
        fputcsv($fp, $logRow);
        fclose($fp);
    }

    echo json_encode([
        'success' => true,
        'message' => 'Quote request received. We will contact you within 2 hours.'
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Email delivery failed. Please call +91 98717 13676 directly.'
    ]);
}
exit;
