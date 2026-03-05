<?php
// =============================================
// SECTION 0: PHP CONFIG (top of file)
// =============================================
$form_success = false;
$form_error   = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form_submit'])) {
    // Sanitize inputs
    $name     = htmlspecialchars(trim($_POST['name'] ?? ''));
    $company  = htmlspecialchars(trim($_POST['company'] ?? ''));
    $email    = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $phone    = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $pkg_type = htmlspecialchars(trim($_POST['pkg_type'] ?? ''));
    $quantity = htmlspecialchars(trim($_POST['quantity'] ?? ''));
    $message  = htmlspecialchars(trim($_POST['message'] ?? ''));

    // Honeypot spam check
    $honeypot = trim($_POST['website'] ?? '');

    if (!empty($name) && !empty($phone) && empty($honeypot)) {
        // ── CONFIGURE YOUR EMAIL HERE ──
        $to      = 'info@spppl.com';               // ← Change to your email
        $subject = "New Packaging Quote Request – $name ($company)";

        $body  = "NEW PACKAGING QUOTE REQUEST\n";
        $body .= "============================\n\n";
        $body .= "Name     : $name\n";
        $body .= "Company  : $company\n";
        $body .= "Email    : $email\n";
        $body .= "Phone    : $phone\n";
        $body .= "Pkg Type : $pkg_type\n";
        $body .= "Quantity : $quantity\n";
        $body .= "Message  : $message\n\n";
        $body .= "Submitted on: " . date('d M Y, h:i A') . "\n";
        $body .= "IP: " . $_SERVER['REMOTE_ADDR'] . "\n";

        $headers  = "From: Solar Landing <noreply@solarprintprocess.com>\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();

        if (mail($to, $subject, $body, $headers)) {
            $form_success = true;
        } else {
            $form_error = true;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Custom Packaging Manufacturer Noida | Solar Print Process Pvt Ltd</title>
<meta name="description" content="Solar Print Process – Direct packaging manufacturer in Noida since 1975. Mono cartons, rigid boxes, FMCG, cosmetic & food packaging. 200,000 sq ft plant. Get quote in 2 hours.">
<meta name="robots" content="index, follow">

<!-- OpenGraph -->
<meta property="og:title" content="Premium Custom Packaging & Printing | Solar Print Process">
<meta property="og:description" content="Direct manufacturer since 1975. Mono cartons, rigid boxes, FMCG packaging. Factory pricing. Pan India delivery.">
<meta property="og:url" content="https://www.solarprintprocess.com">
<meta property="og:type" content="website">

<!-- Schema.org -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "LocalBusiness",
  "name": "Solar Print Process Pvt Ltd",
  "telephone": "+919871713676",
  "email": "info@spppl.com",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "C-10, Sector 85",
    "addressLocality": "Noida",
    "addressRegion": "Uttar Pradesh",
    "postalCode": "201305",
    "addressCountry": "IN"
  },
  "foundingDate": "1975",
  "url": "https://www.solarprintprocess.com"
}
</script>

<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700;800;900&family=Barlow:wght@400;500;600&display=swap" rel="stylesheet">

<style>
/* =============================================
   SECTION A: DESIGN SYSTEM — SOLAR COLORS
   Primary:   #C8242A  (Solar deep red)
   Accent:    #E8312A  (Solar bright red)
   Dark:      #1A1A2E  (near-black navy)
   Deepest:   #0D0D1A
   CTA orange:#E85D00  (high-visibility CTA)
   Light bg:  #F7F5F3
   ============================================= */
*{margin:0;padding:0;box-sizing:border-box}
html{scroll-behavior:smooth}
body{font-family:'Barlow',sans-serif;color:#1a1a2e;background:#fff;font-size:16px;line-height:1.6}

/* === TOPBAR === */
.topbar{background:#0d0d1a;padding:9px 20px;text-align:center;font-size:13.5px;color:#aaa}
.topbar strong{color:#e8312a}
.topbar a{color:#fff;text-decoration:none;font-weight:700}

/* === NAVIGATION === */
.nav{position:sticky;top:0;z-index:200;background:#fff;border-bottom:3px solid #c8242a;box-shadow:0 2px 16px rgba(0,0,0,.09)}
.nav-wrap{max-width:1140px;margin:0 auto;padding:11px 24px;display:flex;align-items:center;justify-content:space-between;gap:12px}
.logo{font-family:'Barlow Condensed',sans-serif;font-size:21px;font-weight:900;color:#1a1a2e;line-height:1.1;text-decoration:none}
.logo span{color:#c8242a}
.logo small{display:block;font-size:10px;font-weight:500;color:#999;letter-spacing:.9px;text-transform:uppercase}
.nav-btns{display:flex;gap:10px;align-items:center;flex-shrink:0}
.btn-call,.btn-wa{display:inline-flex;align-items:center;gap:7px;padding:9px 16px;border-radius:7px;font-weight:700;font-size:14px;text-decoration:none;white-space:nowrap;transition:filter .15s,transform .15s}
.btn-call{background:#1a1a2e;color:#fff}
.btn-wa{background:#25d366;color:#fff}
.btn-call:hover,.btn-wa:hover{filter:brightness(1.12);transform:translateY(-1px)}
.ni{width:16px;height:16px;fill:#fff;flex-shrink:0}

/* === HERO === */
.hero{background:linear-gradient(135deg,#0d0d1a 0%,#1a1a2e 50%,#2a0505 100%);padding:52px 0 0;position:relative;overflow:hidden}
.hero::after{content:'';position:absolute;inset:0;
  background:url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.015'%3E%3Cpath d='M0 0h20v20H0V0zm20 20h20v20H20V20z'/%3E%3C/g%3E%3C/svg%3E");
  pointer-events:none}
.hero-wrap{max-width:1140px;margin:0 auto;padding:0 24px;display:grid;grid-template-columns:1fr 400px;gap:52px;align-items:start;position:relative;z-index:1}
.hero-left{padding-bottom:56px}

.badge{display:inline-flex;align-items:center;gap:8px;background:rgba(200,36,42,.14);border:1px solid rgba(200,36,42,.3);color:#f26268;padding:6px 14px;border-radius:100px;font-size:12.5px;font-weight:700;letter-spacing:.4px;text-transform:uppercase;margin-bottom:22px;font-family:'Barlow Condensed',sans-serif}
.bdot{width:7px;height:7px;border-radius:50%;background:#e8312a;animation:blink 2s infinite}
@keyframes blink{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.3;transform:scale(1.5)}}

.hero h1{font-family:'Barlow Condensed',sans-serif;font-size:clamp(40px,5.5vw,68px);font-weight:900;color:#fff;line-height:1.02;text-transform:uppercase;letter-spacing:-1px;margin-bottom:18px}
.hero h1 em{font-style:normal;color:#e8312a}
.hero-desc{font-size:17px;color:#9999bb;margin-bottom:28px;max-width:500px;line-height:1.7}

.chips{display:flex;flex-wrap:wrap;gap:9px;margin-bottom:36px}
.chip{background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);color:#ccccdd;padding:6px 14px;border-radius:6px;font-size:13px;font-weight:500}

.stats{display:grid;grid-template-columns:repeat(3,1fr);background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);border-radius:13px;overflow:hidden}
.stat{padding:18px 12px;text-align:center;border-right:1px solid rgba(255,255,255,.07)}
.stat:last-child{border-right:none}
.sn{font-family:'Barlow Condensed',sans-serif;font-size:32px;font-weight:900;color:#e8312a;line-height:1;margin-bottom:3px}
.sl{font-size:11px;color:#55557a;text-transform:uppercase;letter-spacing:.6px;font-weight:500}

/* === LEAD FORM CARD === */
.fc{background:#fff;border-radius:14px;padding:28px 24px;box-shadow:0 24px 64px rgba(0,0,0,.5);position:sticky;top:82px}
.fc-badge{display:inline-block;background:#e8f5e9;color:#1a7a3f;font-size:11px;font-weight:700;padding:4px 12px;border-radius:100px;text-transform:uppercase;letter-spacing:.5px;margin-bottom:10px}
.fc-title{font-family:'Barlow Condensed',sans-serif;font-size:25px;font-weight:900;color:#1a1a2e;text-transform:uppercase;margin-bottom:4px}
.fc-sub{font-size:13px;color:#888;margin-bottom:20px;padding-bottom:18px;border-bottom:2px solid #f0f0f4}
.fg{margin-bottom:13px}
.fg label{display:block;font-size:11px;font-weight:700;color:#333;margin-bottom:5px;text-transform:uppercase;letter-spacing:.5px}
.fg input,.fg select,.fg textarea{width:100%;padding:11px 13px;border:1.5px solid #e0e0e8;border-radius:7px;font-size:14.5px;font-family:'Barlow',sans-serif;color:#1a1a2e;background:#fff;outline:none;transition:border-color .2s,box-shadow .2s}
.fg input:focus,.fg select:focus,.fg textarea:focus{border-color:#c8242a;box-shadow:0 0 0 3px rgba(200,36,42,.1)}
.fg textarea{height:64px;resize:none}
.fg-row{display:grid;grid-template-columns:1fr 1fr;gap:10px}
/* Honeypot hidden */
.hp{display:none!important;position:absolute;left:-9999px}
.btn-sub{width:100%;background:#c8242a;color:#fff;border:none;padding:16px;border-radius:8px;font-family:'Barlow Condensed',sans-serif;font-size:20px;font-weight:900;text-transform:uppercase;letter-spacing:.8px;cursor:pointer;margin-top:4px;transition:background .2s,transform .1s}
.btn-sub:hover{background:#a51e22;transform:translateY(-1px)}
.fn{text-align:center;font-size:11.5px;color:#999;margin-top:9px}

/* Form success / error states */
.fdone{display:none;text-align:center;padding:20px 10px}
.fdone .tk{font-size:52px;margin-bottom:10px}
.fdone h3{font-family:'Barlow Condensed',sans-serif;font-size:27px;font-weight:900;color:#1a7a3f;margin-bottom:6px}
.fdone p{font-size:14px;color:#666;margin-bottom:16px}
.wa-g{display:inline-flex;align-items:center;gap:8px;background:#25d366;color:#fff;padding:12px 20px;border-radius:8px;text-decoration:none;font-weight:700;font-size:15px}

/* === TRUST BAR === */
.trust{background:#c8242a;padding:15px 0}
.tw{max-width:1140px;margin:0 auto;padding:0 24px;display:flex;flex-wrap:wrap;justify-content:center;gap:26px}
.ti{display:flex;align-items:center;gap:7px;color:#fff;font-weight:700;font-size:13.5px;font-family:'Barlow Condensed',sans-serif;text-transform:uppercase;letter-spacing:.4px}
.ti svg{width:17px;height:17px;fill:rgba(255,255,255,.8);flex-shrink:0}

/* === GENERIC SECTIONS === */
.sec{padding:68px 0}
.sec.grey{background:#f7f5f3}
.sec.dark{background:#0d0d1a}
.wrap{max-width:1140px;margin:0 auto;padding:0 24px}
.sh{font-family:'Barlow Condensed',sans-serif;font-size:40px;font-weight:900;text-transform:uppercase;line-height:1.04;margin-bottom:8px;letter-spacing:-.3px}
.sh span{color:#c8242a}
.sh.lt{color:#fff}
.sp{font-size:16px;color:#777;margin-bottom:44px;max-width:580px}
.sp.lt{color:#5555aa}

/* === PRODUCTS GRID === */
.pg{display:grid;grid-template-columns:repeat(3,1fr);gap:18px}
.pc{background:#fff;border:1.5px solid #e8e5e5;border-radius:12px;padding:26px 22px;transition:transform .2s,box-shadow .2s,border-color .2s;position:relative;overflow:hidden}
.pc::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:#c8242a;transform:scaleX(0);transform-origin:left;transition:transform .25s}
.pc:hover::before{transform:scaleX(1)}
.pc:hover{transform:translateY(-4px);box-shadow:0 14px 40px rgba(0,0,0,.09);border-color:#c8242a}
.pi{font-size:30px;margin-bottom:14px;display:block}
.pc h3{font-family:'Barlow Condensed',sans-serif;font-size:21px;font-weight:800;color:#1a1a2e;text-transform:uppercase;margin-bottom:8px}
.pc p{font-size:13.5px;color:#777;line-height:1.65;margin-bottom:13px}
.ptags{display:flex;flex-wrap:wrap;gap:5px}
.pt{font-size:11px;background:#f4f0f0;color:#6a2020;padding:3px 9px;border-radius:100px;font-weight:600}

/* === INDUSTRIES GRID === */
.ig{display:grid;grid-template-columns:repeat(4,1fr);gap:14px}
.ii{background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);color:#bbbbd0;padding:14px 18px;border-radius:9px;font-family:'Barlow Condensed',sans-serif;font-size:16px;font-weight:700;text-transform:uppercase;text-align:center;letter-spacing:.3px;transition:background .2s,border-color .2s,color .2s;cursor:default}
.ii:hover{background:rgba(200,36,42,.13);border-color:rgba(200,36,42,.4);color:#f26268}

/* === WHY US === */
.wg{display:grid;grid-template-columns:1fr 1fr;gap:20px}
.wc{display:flex;gap:18px;padding:26px;background:#fff;border:1.5px solid #ede8e8;border-radius:12px;transition:border-color .2s,box-shadow .2s}
.wc:hover{border-color:#c8242a;box-shadow:0 8px 30px rgba(200,36,42,.07)}
.wn{font-family:'Barlow Condensed',sans-serif;font-size:48px;font-weight:900;color:rgba(200,36,42,.1);line-height:1;flex-shrink:0;width:54px}
.wc h3{font-family:'Barlow Condensed',sans-serif;font-size:20px;font-weight:800;text-transform:uppercase;margin-bottom:7px;color:#1a1a2e}
.wc p{font-size:13.5px;color:#777;line-height:1.7}

/* === PROCESS STEPS === */
.proc-grid{display:grid;grid-template-columns:repeat(5,1fr);gap:0;position:relative}
.proc-grid::before{content:'';position:absolute;top:32px;left:10%;right:10%;height:2px;background:linear-gradient(90deg,#c8242a,#e8312a);z-index:0}
.ps{text-align:center;position:relative;z-index:1;padding:0 8px}
.ps-num{width:64px;height:64px;border-radius:50%;background:#c8242a;color:#fff;font-family:'Barlow Condensed',sans-serif;font-size:26px;font-weight:900;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;box-shadow:0 6px 20px rgba(200,36,42,.35)}
.ps h4{font-family:'Barlow Condensed',sans-serif;font-size:17px;font-weight:800;text-transform:uppercase;color:#1a1a2e;margin-bottom:5px}
.ps p{font-size:12.5px;color:#888;line-height:1.5}

/* === TESTIMONIALS === */
.tg{display:grid;grid-template-columns:repeat(3,1fr);gap:20px}
.tc{background:#fff;border:1.5px solid #ede8e8;border-radius:12px;padding:26px 22px}
.tq{font-size:14px;color:#555;line-height:1.75;margin-bottom:16px;font-style:italic}
.ta{display:flex;align-items:center;gap:12px}
.tav{width:42px;height:42px;border-radius:50%;background:#c8242a;color:#fff;font-family:'Barlow Condensed',sans-serif;font-size:19px;font-weight:900;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.tan{font-family:'Barlow Condensed',sans-serif;font-size:17px;font-weight:800;color:#1a1a2e;text-transform:uppercase}
.tac{font-size:12px;color:#999;margin-top:2px}
.stars{color:#f5a623;font-size:13px;margin-bottom:10px}

/* === CTA BANNER === */
.csec{background:linear-gradient(135deg,#c8242a,#8a1519);padding:64px 0;text-align:center}
.csec h2{font-family:'Barlow Condensed',sans-serif;font-size:clamp(30px,4.5vw,52px);font-weight:900;color:#fff;text-transform:uppercase;line-height:1.04;margin-bottom:14px}
.csec p{font-size:17px;color:rgba(255,255,255,.85);max-width:560px;margin:0 auto 32px}
.cbtns{display:flex;justify-content:center;gap:14px;flex-wrap:wrap}
.cbw{display:inline-flex;align-items:center;gap:9px;background:#fff;color:#c8242a;padding:15px 30px;border-radius:8px;font-family:'Barlow Condensed',sans-serif;font-size:20px;font-weight:900;text-transform:uppercase;text-decoration:none;letter-spacing:.4px;transition:transform .2s}
.cbwa{display:inline-flex;align-items:center;gap:9px;background:#25d366;color:#fff;padding:15px 30px;border-radius:8px;font-family:'Barlow Condensed',sans-serif;font-size:20px;font-weight:900;text-transform:uppercase;text-decoration:none;letter-spacing:.4px;transition:transform .2s}
.cbw:hover,.cbwa:hover{transform:translateY(-2px)}
.ci{font-size:13.5px;color:rgba(255,255,255,.7);margin-top:18px}

/* === FOOTER === */
footer{background:#0d0d1a;padding:44px 0 0}
.fg2{max-width:1140px;margin:0 auto;padding:0 24px;display:grid;grid-template-columns:1.3fr 1fr 1fr;gap:36px}
footer h4{font-family:'Barlow Condensed',sans-serif;font-size:15px;font-weight:700;color:#e8312a;text-transform:uppercase;letter-spacing:.8px;margin-bottom:13px}
footer p,footer a{font-size:13.5px;text-decoration:none;display:block;line-height:1.95;color:#44445a}
footer a:hover{color:#fff}
.fb{max-width:1140px;margin:28px auto 0;padding:18px 24px;border-top:1px solid rgba(255,255,255,.04);text-align:center}
.fb p{font-size:12.5px;color:#2a2a4a}

/* === FLOATING WHATSAPP === */
.swa{position:fixed;bottom:26px;right:26px;z-index:999;width:58px;height:58px;background:#25d366;border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 6px 24px rgba(37,211,102,.45);text-decoration:none;animation:bob 2.5s ease-in-out infinite}
@keyframes bob{0%,100%{transform:translateY(0)}50%{transform:translateY(-7px)}}
.swa svg{width:30px;height:30px;fill:#fff}

/* === SCROLL ANIMATIONS === */
.fi{opacity:0;transform:translateY(24px);transition:opacity .5s,transform .5s}
.fi.vis{opacity:1;transform:none}

/* === ALERTS === */
.alert-success{background:#e8f5e9;border:1.5px solid #4caf50;color:#1a7a3f;padding:14px 18px;border-radius:8px;margin-bottom:16px;font-size:14px;font-weight:600}
.alert-error{background:#fdecea;border:1.5px solid #e53935;color:#b71c1c;padding:14px 18px;border-radius:8px;margin-bottom:16px;font-size:14px;font-weight:600}

/* =============================================
   RESPONSIVE
   ============================================= */
@media(max-width:960px){
  .hero-wrap{grid-template-columns:1fr}
  .fc{position:static}
  .pg{grid-template-columns:1fr 1fr}
  .ig{grid-template-columns:1fr 1fr}
  .wg{grid-template-columns:1fr}
  .fg2{grid-template-columns:1fr;gap:22px}
  .proc-grid{grid-template-columns:1fr 1fr;gap:28px}
  .proc-grid::before{display:none}
  .tg{grid-template-columns:1fr 1fr}
}
@media(max-width:600px){
  .pg{grid-template-columns:1fr}
  .fg-row{grid-template-columns:1fr}
  .tw{gap:14px}
  .ti{font-size:12px}
  .proc-grid{grid-template-columns:1fr}
  .tg{grid-template-columns:1fr}
  .nav-btns .btn-call span{display:none}
}
</style>
</head>
<body>

<?php if ($form_success): ?>
<script>
  document.addEventListener('DOMContentLoaded',function(){
    const d=document.getElementById('formDone');
    const f=document.getElementById('theForm');
    if(d&&f){f.style.display='none';d.style.display='block';}
    const el=document.getElementById('formCard');
    if(el)el.scrollIntoView({behavior:'smooth'});
  });
</script>
<?php endif; ?>

<!-- =============================================
     SECTION 1: TOP BAR
     ============================================= -->
<div class="topbar">
  Direct Packaging Manufacturer Since <strong>1975</strong>
  &nbsp;|&nbsp; 200,000 Sq Ft Plant, Noida
  &nbsp;|&nbsp; Call: <a href="tel:+919871713676">+91 98717 13676</a>
</div>

<!-- =============================================
     SECTION 2: NAVIGATION
     ============================================= -->
<nav class="nav">
  <div class="nav-wrap">
    <a href="#" class="logo">
      SOLAR<span> PRINT PROCESS</span>
      <small>Custom Packaging &amp; Printing Manufacturer · Noida</small>
    </a>
    <div class="nav-btns">
      <a href="tel:+919871713676" class="btn-call">
        <svg class="ni" viewBox="0 0 24 24"><path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.27-.27.67-.36 1-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1C10.29 21 3 13.71 3 5c0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.24 1L6.6 10.8z"/></svg>
        <span>Call Now</span>
      </a>
      <a href="https://wa.me/919871713676?text=Hello%2C+I+need+a+packaging+quote" class="btn-wa" target="_blank" rel="noopener">
        <svg class="ni" viewBox="0 0 24 24"><path d="M17.47 14.38c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15s-.77.97-.94 1.16-.35.22-.65.07-.3-.15-1.25-.46-2.39-1.47-.88-.79-1.48-1.76-1.65-2.06-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.08-.15-.67-1.61-.92-2.21-.24-.58-.49-.5-.67-.51-.17 0-.37-.01-.57-.01-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.48s1.07 2.88 1.21 3.07c.15.2 2.1 3.2 5.08 4.49.71.31 1.26.49 1.69.62.71.23 1.36.2 1.87.12.57-.09 1.76-.72 2.01-1.41.25-.7.25-1.29.17-1.41-.07-.12-.27-.2-.57-.35zm-5.42 7.4h-.01a9.87 9.87 0 01-5.03-1.38l-.36-.21-3.74.98 1-3.65-.24-.37A9.86 9.86 0 012 12C2 6.6 6.44 2.16 12 2.16c2.64 0 5.12 1.03 6.99 2.9a9.83 9.83 0 012.89 7c0 5.45-4.44 9.88-9.89 9.88zm8.41-18.3A11.82 11.82 0 0012.05 0C5.5 0 .16 5.34.16 11.89c0 2.1.55 4.14 1.59 5.95L.06 24l6.31-1.66a11.88 11.88 0 005.68 1.45h.01c6.55 0 11.89-5.34 11.89-11.89a11.82 11.82 0 00-3.49-8.42z"/></svg>
        WhatsApp Quote
      </a>
    </div>
  </div>
</nav>

<!-- =============================================
     SECTION 3: HERO + LEAD FORM
     ============================================= -->
<section class="hero">
  <div class="hero-wrap">
    <!-- Left: Headline + trust chips -->
    <div class="hero-left">
      <div class="badge"><span class="bdot"></span>Direct Factory · Noida, Delhi NCR</div>
      <h1>Custom Packaging<br><em>&amp; Printing</em><br>Since 1975</h1>
      <p class="hero-desc">
        Mono cartons, rigid boxes, FMCG, food and cosmetic packaging.
        Factory-direct pricing. 200,000 sq ft Noida plant.
        Bulk orders welcome. Pan India delivery.
      </p>
      <div class="chips">
        <span class="chip">Mono Cartons</span>
        <span class="chip">Rigid Boxes</span>
        <span class="chip">Cosmetic Boxes</span>
        <span class="chip">Food Packaging</span>
        <span class="chip">FMCG Boxes</span>
        <span class="chip">POS Display Units</span>
      </div>
      <div class="stats">
        <div class="stat"><div class="sn">50+</div><div class="sl">Years Est.</div></div>
        <div class="stat"><div class="sn">200K</div><div class="sl">Sq Ft Plant</div></div>
        <div class="stat"><div class="sn">500+</div><div class="sl">B2B Clients</div></div>
      </div>
    </div>

    <!-- Right: Lead capture form -->
    <div class="fc" id="formCard">
      <div class="fc-badge">&#10003; Response in 2 Hours</div>
      <div class="fc-title">Get Free Quote Now</div>
      <div class="fc-sub">Fill your requirement — we respond same day</div>

      <?php if ($form_success): ?>
        <div class="fdone" id="formDone" style="display:block">
          <div class="tk">&#x2705;</div>
          <h3>Request Received!</h3>
          <p>We will call or WhatsApp you within 2 hours with your personalised quote.</p>
          <a href="https://wa.me/919871713676?text=Hi%2C+I+just+submitted+a+quote+request" class="wa-g" target="_blank">
            Chat on WhatsApp Now
          </a>
        </div>
      <?php elseif ($form_error): ?>
        <div class="alert-error">Something went wrong. Please call us directly at <strong>+91 98717 13676</strong>.</div>
      <?php endif; ?>

      <form id="theForm" method="POST" action="#formCard" <?php if($form_success) echo 'style="display:none"'; ?>>
        <input type="hidden" name="form_submit" value="1">
        <!-- Honeypot -->
        <div class="hp" aria-hidden="true">
          <label for="website">Leave blank</label>
          <input type="text" name="website" id="website" tabindex="-1" autocomplete="off">
        </div>

        <div class="fg">
          <label for="name">Your Name *</label>
          <input type="text" id="name" name="name" placeholder="Your full name" required
            value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
        </div>

        <div class="fg-row">
          <div class="fg">
            <label for="company">Company</label>
            <input type="text" id="company" name="company" placeholder="Company name"
              value="<?= htmlspecialchars($_POST['company'] ?? '') ?>">
          </div>
          <div class="fg">
            <label for="phone">Phone / WhatsApp *</label>
            <input type="tel" id="phone" name="phone" placeholder="+91 XXXXX XXXXX" required
              value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
          </div>
        </div>

        <div class="fg">
          <label for="email">Email Address</label>
          <input type="email" id="email" name="email" placeholder="your@email.com"
            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        </div>

        <div class="fg">
          <label for="pkg_type">Packaging Type Needed *</label>
          <select id="pkg_type" name="pkg_type" required>
            <option value="">Select packaging type…</option>
            <option <?= ($_POST['pkg_type']??'')==='Mono Cartons'?'selected':'' ?>>Mono Cartons</option>
            <option <?= ($_POST['pkg_type']??'')==='Rigid Boxes'?'selected':'' ?>>Rigid Boxes</option>
            <option <?= ($_POST['pkg_type']??'')==='Gift Boxes'?'selected':'' ?>>Gift Boxes</option>
            <option <?= ($_POST['pkg_type']??'')==='Food Packaging'?'selected':'' ?>>Food Packaging</option>
            <option <?= ($_POST['pkg_type']??'')==='FMCG Packaging'?'selected':'' ?>>FMCG Packaging</option>
            <option <?= ($_POST['pkg_type']??'')==='Cosmetic / Beauty Boxes'?'selected':'' ?>>Cosmetic / Beauty Boxes</option>
            <option <?= ($_POST['pkg_type']??'')==='POS Display Units'?'selected':'' ?>>POS Display Units</option>
            <option <?= ($_POST['pkg_type']??'')==='Commercial Printing'?'selected':'' ?>>Commercial Printing (Books, Brochures)</option>
            <option <?= ($_POST['pkg_type']??'')==='Ecommerce Packaging'?'selected':'' ?>>Ecommerce / Mailer Boxes</option>
            <option <?= ($_POST['pkg_type']??'')==='Other'?'selected':'' ?>>Other</option>
          </select>
        </div>

        <div class="fg">
          <label for="quantity">Approximate Quantity</label>
          <select id="quantity" name="quantity">
            <option value="">Select quantity range…</option>
            <option>500 – 1,000 pieces</option>
            <option>1,000 – 5,000 pieces</option>
            <option>5,000 – 25,000 pieces</option>
            <option>25,000+ pieces</option>
            <option>Not sure yet</option>
          </select>
        </div>

        <div class="fg">
          <label for="message">Specific Requirement (optional)</label>
          <textarea id="message" name="message" placeholder="Size, finish, print, deadline, product name…"><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
        </div>

        <button type="submit" class="btn-sub">GET FREE QUOTE →</button>
        <p class="fn">&#128274; Confidential. No spam. Mon–Sat response guaranteed.</p>
      </form>
    </div>
    <!-- /form card -->
  </div>
</section>

<!-- =============================================
     SECTION 4: TRUST BAR
     ============================================= -->
<div class="trust">
  <div class="tw">
    <div class="ti">
      <svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
      Established 1975
    </div>
    <div class="ti">
      <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
      C-10 Sector 85, Noida
    </div>
    <div class="ti">
      <svg viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/></svg>
      200,000 Sq Ft Factory
    </div>
    <div class="ti">
      <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
      500+ B2B Clients
    </div>
    <div class="ti">
      <svg viewBox="0 0 24 24"><path d="M1 3h15v13H1zM16 8h4l3 3v5h-7V8z"/></svg>
      Pan India Delivery
    </div>
    <div class="ti">
      <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
      ISO Grade Quality
    </div>
  </div>
</div>

<!-- =============================================
     SECTION 5: PACKAGING PRODUCTS
     ============================================= -->
<section class="sec grey">
  <div class="wrap">
    <h2 class="sh fi">Our <span>Packaging</span> Products</h2>
    <p class="sp fi">Everything manufactured at our Noida plant. No middlemen. Direct factory pricing on all orders.</p>
    <div class="pg">
      <div class="pc fi">
        <span class="pi">&#x1F4E6;</span>
        <h3>Mono Cartons</h3>
        <p>Offset-printed folding cartons for FMCG, pharma, food and personal care. Matte, gloss, UV and foil finishes.</p>
        <div class="ptags"><span class="pt">FMCG</span><span class="pt">Pharma</span><span class="pt">Food</span><span class="pt">Bulk Orders</span></div>
      </div>
      <div class="pc fi">
        <span class="pi">&#x1F381;</span>
        <h3>Rigid Boxes</h3>
        <p>Premium setup boxes for luxury brands, jewellery, electronics and gifting. Hi-gloss, matte, magnetic closure.</p>
        <div class="ptags"><span class="pt">Luxury</span><span class="pt">Beauty</span><span class="pt">Electronics</span><span class="pt">Gifting</span></div>
      </div>
      <div class="pc fi">
        <span class="pi">&#x1F9F4;</span>
        <h3>Cosmetic Packaging</h3>
        <p>Custom beauty and skincare boxes with embossing, hot foil stamping and premium laminates.</p>
        <div class="ptags"><span class="pt">Skincare</span><span class="pt">Perfume</span><span class="pt">D2C Beauty</span></div>
      </div>
      <div class="pc fi">
        <span class="pi">&#x1F371;</span>
        <h3>Food Packaging</h3>
        <p>Food-safe printed cartons and boxes for bakery, confectionery, snacks and packaged food. Eco options available.</p>
        <div class="ptags"><span class="pt">Bakery</span><span class="pt">FMCG</span><span class="pt">Food Safe</span><span class="pt">Eco</span></div>
      </div>
      <div class="pc fi">
        <span class="pi">&#x1F5A8;</span>
        <h3>POS Display Units</h3>
        <p>3D corrugated and printed display systems for retail shelf, counter-top and floor-standing brand activation.</p>
        <div class="ptags"><span class="pt">Retail</span><span class="pt">FMCG</span><span class="pt">Counter Display</span></div>
      </div>
      <div class="pc fi">
        <span class="pi">&#x1F4DA;</span>
        <h3>Commercial Printing</h3>
        <p>Brochures, catalogues, coffee table books, business kits and marketing collaterals. Full in-house production.</p>
        <div class="ptags"><span class="pt">Brochures</span><span class="pt">Catalogues</span><span class="pt">Business Kits</span></div>
      </div>
    </div>
  </div>
</section>

<!-- =============================================
     SECTION 6: INDUSTRIES
     ============================================= -->
<section class="sec dark">
  <div class="wrap">
    <h2 class="sh lt fi">Industries We <span>Serve</span></h2>
    <p class="sp lt fi">14 industries. 500+ B2B clients. Trusted packaging partner for India's biggest brands since 1975.</p>
    <div class="ig">
      <div class="ii fi">FMCG</div>
      <div class="ii fi">Pharma</div>
      <div class="ii fi">Beauty &amp; Skincare</div>
      <div class="ii fi">Food &amp; Beverages</div>
      <div class="ii fi">IT &amp; Electronics</div>
      <div class="ii fi">Automotive</div>
      <div class="ii fi">Banking</div>
      <div class="ii fi">Telecom</div>
      <div class="ii fi">Education</div>
      <div class="ii fi">Hospitality</div>
      <div class="ii fi">Jewellery &amp; Fashion</div>
      <div class="ii fi">Spirits &amp; Liquor</div>
      <div class="ii fi">Real Estate</div>
      <div class="ii fi">Ecommerce</div>
    </div>
  </div>
</section>

<!-- =============================================
     SECTION 7: WHY CHOOSE SOLAR
     ============================================= -->
<section class="sec">
  <div class="wrap">
    <h2 class="sh fi">Why Brands <span>Choose</span> Solar</h2>
    <p class="sp fi">What 50 years of manufacturing gives you that no startup agency ever can.</p>
    <div class="wg">
      <div class="wc fi">
        <div class="wn">01</div>
        <div>
          <h3>Direct Manufacturer — Zero Middlemen</h3>
          <p>You deal directly with the factory. No broker, no reseller. This means 20–35% lower cost and full accountability on every order.</p>
        </div>
      </div>
      <div class="wc fi">
        <div class="wn">02</div>
        <div>
          <h3>50 Years of Proven Production</h3>
          <p>Since 1975. We have delivered packaging for Fortune 500 companies. Quality processes tested and refined over decades.</p>
        </div>
      </div>
      <div class="wc fi">
        <div class="wn">03</div>
        <div>
          <h3>200,000 Sq Ft — Everything In-House</h3>
          <p>Design, Print, Cut, Finish, QC, Dispatch — all under one roof. No outsourcing. No delays. No surprises.</p>
        </div>
      </div>
      <div class="wc fi">
        <div class="wn">04</div>
        <div>
          <h3>Quote in 2 Hours. Sample in 3 Days.</h3>
          <p>WhatsApp or call your requirement. Detailed quote in 2 hours. Physical sample dispatched within 3 working days.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- =============================================
     SECTION 8: PRODUCTION PROCESS
     ============================================= -->
<section class="sec grey">
  <div class="wrap">
    <h2 class="sh fi">Our Production <span>Process</span></h2>
    <p class="sp fi">From concept to delivery — every step handled in-house at our Noida plant.</p>
    <div class="proc-grid">
      <div class="ps fi">
        <div class="ps-num">01</div>
        <h4>Concept &amp; Brief</h4>
        <p>Share your requirement. Our team analyses size, finish and print specs.</p>
      </div>
      <div class="ps fi">
        <div class="ps-num">02</div>
        <h4>Design</h4>
        <p>In-house artwork and structural design. Dieline ready within 24 hours.</p>
      </div>
      <div class="ps fi">
        <div class="ps-num">03</div>
        <h4>Prototype</h4>
        <p>Physical sample dispatched in 3 working days. Review before production.</p>
      </div>
      <div class="ps fi">
        <div class="ps-num">04</div>
        <h4>Production</h4>
        <p>Full-run printing, cutting, finishing and quality control on-site.</p>
      </div>
      <div class="ps fi">
        <div class="ps-num">05</div>
        <h4>Delivery</h4>
        <p>Pan India dispatch. On-time guaranteed. Bulk orders handled with ease.</p>
      </div>
    </div>
  </div>
</section>

<!-- =============================================
     SECTION 9: TESTIMONIALS
     ============================================= -->
<section class="sec">
  <div class="wrap">
    <h2 class="sh fi">What Our <span>Clients</span> Say</h2>
    <p class="sp fi">Packaging partners for India's most trusted brands across 14 industries.</p>
    <div class="tg">
      <div class="tc fi">
        <div class="stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
        <p class="tq">"Solar Print Process has been our packaging partner for over 8 years. Consistent quality, fast turnaround and the pricing is unmatched for the finish quality we get."</p>
        <div class="ta">
          <div class="tav">R</div>
          <div><div class="tan">Rajiv Mehta</div><div class="tac">Procurement Head, FMCG Brand, Delhi NCR</div></div>
        </div>
      </div>
      <div class="tc fi">
        <div class="stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
        <p class="tq">"We launched our cosmetic line with Solar's rigid boxes. The finish, foil and embossing were perfect first time. Sample was with us in 3 days as promised."</p>
        <div class="ta">
          <div class="tav">P</div>
          <div><div class="tan">Priya Sharma</div><div class="tac">Founder, D2C Beauty Brand, Mumbai</div></div>
        </div>
      </div>
      <div class="tc fi">
        <div class="stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
        <p class="tq">"For our pharma mono cartons, accuracy matters. Solar delivers on every count — correct colours, exact specs and always on-time. Truly a world-class facility."</p>
        <div class="ta">
          <div class="tav">A</div>
          <div><div class="tan">Amit Gupta</div><div class="tac">Supply Chain Director, Pharma Group, Noida</div></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- =============================================
     SECTION 10: CTA URGENCY BANNER
     ============================================= -->
<section class="csec">
  <div class="wrap">
    <h2>Ready to Get Your Packaging Quote?</h2>
    <p>Fill the form above or WhatsApp your brief. We respond within 2 hours, Monday to Saturday.</p>
    <div class="cbtns">
      <a href="#formCard" class="cbw">Fill Quote Form</a>
      <a href="https://wa.me/919871713676?text=Hello%2C+I+need+a+custom+packaging+quote" class="cbwa" target="_blank" rel="noopener">WhatsApp Us Now</a>
    </div>
    <p class="ci">C-10, Sector 85, Noida UP 201305 &nbsp;|&nbsp; +91 98717 13676 &nbsp;|&nbsp; info@spppl.com</p>
  </div>
</section>

<!-- =============================================
     SECTION 11: FOOTER
     ============================================= -->
<footer>
  <div class="fg2">
    <div>
      <h4>Solar Print Process Pvt. Ltd.</h4>
      <p>Established 1975. Custom packaging manufacturer in Noida. 200,000 sq ft facility. Serving FMCG, Pharma, Beauty, Food and 10+ industries across India.</p>
    </div>
    <div>
      <h4>Our Products</h4>
      <a href="#">Mono Cartons</a>
      <a href="#">Rigid Boxes</a>
      <a href="#">Cosmetic Packaging</a>
      <a href="#">Food Packaging</a>
      <a href="#">POS Display Units</a>
      <a href="#">Commercial Printing</a>
    </div>
    <div>
      <h4>Contact Us</h4>
      <a href="tel:+919871713676">+91 98717 13676</a>
      <a href="mailto:info@spppl.com">info@spppl.com</a>
      <a href="https://wa.me/919871713676" target="_blank" rel="noopener">WhatsApp Now</a>
      <p style="margin-top:10px">C-10, Sector 85, Noida UP 201305</p>
      <p>Mon–Sat: 9:00 AM – 7:00 PM</p>
    </div>
  </div>
  <div class="fb">
    <p>&copy; <?= date('Y') ?> Solar Print Process Pvt. Ltd. &mdash; C-10, Sector 85, Noida &mdash; +91 98717 13676</p>
  </div>
</footer>

<!-- =============================================
     FLOATING WHATSAPP BUTTON
     ============================================= -->
<a class="swa" href="https://wa.me/919871713676?text=Hello%2C+I+need+a+packaging+quote" target="_blank" rel="noopener" aria-label="WhatsApp">
  <svg viewBox="0 0 24 24"><path d="M17.47 14.38c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15s-.77.97-.94 1.16-.35.22-.65.07-.3-.15-1.25-.46-2.39-1.47-.88-.79-1.48-1.76-1.65-2.06-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.08-.15-.67-1.61-.92-2.21-.24-.58-.49-.5-.67-.51-.17 0-.37-.01-.57-.01-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.48s1.07 2.88 1.21 3.07c.15.2 2.1 3.2 5.08 4.49.71.31 1.26.49 1.69.62.71.23 1.36.2 1.87.12.57-.09 1.76-.72 2.01-1.41.25-.7.25-1.29.17-1.41-.07-.12-.27-.2-.57-.35zm-5.42 7.4h-.01a9.87 9.87 0 01-5.03-1.38l-.36-.21-3.74.98 1-3.65-.24-.37A9.86 9.86 0 012 12C2 6.6 6.44 2.16 12 2.16c2.64 0 5.12 1.03 6.99 2.9a9.83 9.83 0 012.89 7c0 5.45-4.44 9.88-9.89 9.88zm8.41-18.3A11.82 11.82 0 0012.05 0C5.5 0 .16 5.34.16 11.89c0 2.1.55 4.14 1.59 5.95L.06 24l6.31-1.66a11.88 11.88 0 005.68 1.45h.01c6.55 0 11.89-5.34 11.89-11.89a11.82 11.82 0 00-3.49-8.42z"/></svg>
</a>

<!-- =============================================
     JAVASCRIPT: Scroll animations + form client validation
     ============================================= -->
<script>
// Scroll-triggered fade-in animations
const obs = new IntersectionObserver(entries => {
  entries.forEach((e, i) => {
    if (e.isIntersecting) {
      setTimeout(() => e.target.classList.add('vis'), i * 65);
      obs.unobserve(e.target);
    }
  });
}, { threshold: 0.08 });
document.querySelectorAll('.fi').forEach(el => obs.observe(el));

// Client-side form validation before submit
document.getElementById('theForm')?.addEventListener('submit', function(e) {
  const name  = document.getElementById('name').value.trim();
  const phone = document.getElementById('phone').value.trim();
  const ptype = document.getElementById('pkg_type').value;

  if (!name || !phone || !ptype) {
    e.preventDefault();
    alert('Please fill in Name, Phone and Packaging Type before submitting.');
    return false;
  }
  // Basic phone validation (India)
  const phoneRegex = /^[6-9]\d{9}$/;
  const cleanPhone = phone.replace(/[\s\-+]/g, '').replace(/^91/, '');
  if (!phoneRegex.test(cleanPhone)) {
    e.preventDefault();
    alert('Please enter a valid 10-digit Indian mobile number.');
    return false;
  }
});
</script>

</body>
</html>
