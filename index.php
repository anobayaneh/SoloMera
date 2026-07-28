<?php
session_start();
require_once __DIR__ . '/config.php';
$_SESSION['shopatmera_action'] = 'apply';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MERA — Everyday Essentials</title>
<link rel="icon" type="image/png" href="files/images/logo.jpg">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,400;0,9..144,500;1,9..144,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

<meta name="description" content="MERA — minimal, Korean-inspired everyday essentials. Soft, body-flattering basics in neutral tones.">

<style>
:root{
  --sand:#f3ede4;
  --cream:#faf7f2;
  --clay:#b08968;
  --ink:#2b2622;
  --taupe:#7c7167;
  --line:rgba(43,38,34,.1);
  --white:#fff;
}
*{margin:0;padding:0;box-sizing:border-box;}
html{overflow-x:hidden;width:100%;}
body{
  font-family:'Inter',sans-serif;
  color:var(--ink);
  background:var(--cream);
  -webkit-font-smoothing:antialiased;
  overflow-x:hidden;
  width:100%;
}
h1,h2,h3{font-family:'Fraunces',serif;font-weight:400;}
a{text-decoration:none;color:inherit;}
img{display:block;max-width:100%;}
.container{max-width:1240px;margin:0 auto;padding:0 2rem;}

/* ===== NAV ===== */
.nav{
  position:sticky;top:0;z-index:500;
  background:rgba(250,247,242,.92);
  backdrop-filter:blur(10px);
  border-bottom:1px solid var(--line);
}
.nav-inner{display:flex;align-items:center;justify-content:space-between;gap:.8rem;padding:1rem 2rem;max-width:1240px;margin:0 auto;}
.nav-logo{display:flex;align-items:center;gap:.6rem;font-family:'Fraunces',serif;font-size:1.4rem;letter-spacing:.04em;}
.nav-logo img{height:34px;width:auto;}
.nav-links{display:flex;gap:2rem;list-style:none;}
.nav-links a{font-size:.85rem;letter-spacing:.03em;color:var(--taupe);transition:color .25s;}
.nav-links a:hover{color:var(--ink);}
.nav-cta{
  display:inline-block;padding:.65rem 1.4rem;border:1px solid var(--ink);
  font-size:.78rem;letter-spacing:.04em;border-radius:999px;transition:all .25s;
}
.nav-cta:hover{background:var(--ink);color:var(--cream);}
.nav-hamburger{display:none;flex-direction:column;gap:5px;background:none;border:none;cursor:pointer;padding:6px;z-index:600;}
.nav-hamburger span{width:22px;height:2px;background:var(--ink);transition:.3s;}
.nav-hamburger.open span:nth-child(1){transform:translateY(7px) rotate(45deg);}
.nav-hamburger.open span:nth-child(2){opacity:0;}
.nav-hamburger.open span:nth-child(3){transform:translateY(-7px) rotate(-45deg);}

/* ===== HERO ===== */
.hero{
  padding:6rem 0 5rem;
  background:linear-gradient(180deg,var(--sand),var(--cream));
}
.hero-inner{
  display:grid;grid-template-columns:1.1fr .9fr;gap:3rem;align-items:center;
  max-width:1240px;margin:0 auto;padding:0 2rem;
}
.hero-eyebrow{font-size:.78rem;letter-spacing:.18em;text-transform:uppercase;color:var(--clay);margin-bottom:1.2rem;}
.hero-title{font-size:clamp(2.6rem,5vw,4rem);line-height:1.08;font-weight:400;margin-bottom:1.4rem;}
.hero-title em{font-style:italic;color:var(--clay);}
.hero-sub{font-size:1rem;color:var(--taupe);line-height:1.7;max-width:420px;margin-bottom:2rem;}
.hero-btns{display:flex;gap:1rem;flex-wrap:wrap;}
.btn-primary{
  padding:.95rem 2rem;background:var(--ink);color:var(--cream);
  border-radius:999px;font-size:.85rem;letter-spacing:.03em;transition:.25s;display:inline-block;
}
.btn-primary:hover{background:var(--clay);}
.btn-outline{
  padding:.95rem 2rem;border:1px solid var(--ink);border-radius:999px;
  font-size:.85rem;letter-spacing:.03em;transition:.25s;display:inline-block;
}
.btn-outline:hover{background:var(--ink);color:var(--cream);}
.hero-visual{
  aspect-ratio:4/5;background:var(--sand);border-radius:18px;
  position:relative;overflow:hidden;
  border:1px solid var(--line);
}
/* Hero slideshow */
.hero-slide{position:absolute;inset:0;opacity:0;transition:opacity 1s ease;}
.hero-slide.active{opacity:1;}
.hero-slide img,
.hero-slide video{width:100%;height:100%;object-fit:cover;display:block;}
.hero-dots{position:absolute;bottom:1rem;left:50%;transform:translateX(-50%);display:flex;gap:.4rem;z-index:2;}
.hero-dot{width:7px;height:7px;border-radius:50%;background:rgba(255,255,255,.5);border:none;cursor:pointer;transition:.25s;}
.hero-dot.active{background:#fff;transform:scale(1.3);}

/* ===== CATEGORY STRIP ===== */
.cats{padding:3.5rem 0 1rem;}
.cats-inner{display:flex;gap:1rem;overflow-x:auto;padding-bottom:.5rem;scrollbar-width:none;}
.cats-inner::-webkit-scrollbar{display:none;}
.cat-pill{
  flex:0 0 auto;padding:.7rem 1.6rem;border:1px solid var(--line);border-radius:999px;
  font-size:.82rem;letter-spacing:.03em;color:var(--taupe);background:var(--white);
  transition:.25s;white-space:nowrap;
}
.cat-pill.active,.cat-pill:hover{background:var(--ink);color:var(--cream);border-color:var(--ink);}

/* ===== SECTION HEADER ===== */
.section{padding:4.5rem 0;}
.section-head{display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:2.5rem;flex-wrap:wrap;gap:1rem;}
.section-eyebrow{font-size:.75rem;letter-spacing:.16em;text-transform:uppercase;color:var(--clay);margin-bottom:.6rem;}
.section-title{font-size:clamp(1.7rem,3vw,2.3rem);font-weight:400;}
.section-link{
  font-size:.82rem;color:var(--taupe);border:1px solid var(--taupe);
  padding:.6rem 1.4rem;border-radius:999px;background:none;
  cursor:pointer;font-family:inherit;transition:all .25s;white-space:nowrap;
}
.section-link:hover{color:var(--ink);border-color:var(--ink);background:rgba(43,38,34,.05);}

/* ===== PRODUCT GRID ===== */
.products-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:1.6rem;}
.product-card{cursor:default;transition:transform .25s,box-shadow .25s;border-radius:10px;}
.product-card:hover{transform:translateY(-5px);box-shadow:0 14px 26px rgba(43,38,34,.1);}
.product-img{
  aspect-ratio:3/4;background:var(--sand);border-radius:10px;overflow:hidden;
  position:relative;margin-bottom:.9rem;border:1px solid var(--line);
}
.product-img img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;transition:transform .5s;z-index:1;}
.product-card:hover .product-img img{transform:scale(1.05);}

/* ── Placeholder (shown when no real image) ── */
.product-img-placeholder{
  position:absolute;inset:0;display:none;flex-direction:column;align-items:center;justify-content:center;
  gap:.7rem;color:var(--taupe);transition:background .3s,color .3s;
}
.product-img-placeholder svg{width:38px;height:38px;opacity:.45;transition:opacity .3s,transform .4s;}
.product-img-placeholder span{font-size:.72rem;letter-spacing:.06em;text-transform:uppercase;opacity:.55;transition:opacity .3s;}
.product-card:hover .product-img-placeholder{background:rgba(176,137,104,.07);color:var(--clay);}
.product-card:hover .product-img-placeholder svg{opacity:.7;transform:scale(1.12);}
.product-card:hover .product-img-placeholder span{opacity:.75;}

/* Quick-add button that appears on hover */
.product-img-hover-action{
  position:absolute;bottom:0;left:0;right:0;
  padding:.65rem;background:var(--ink);color:var(--cream);
  text-align:center;font-size:.75rem;letter-spacing:.05em;text-transform:uppercase;
  transform:translateY(100%);transition:transform .3s cubic-bezier(.22,.61,.36,1);
}
.product-card:hover .product-img-hover-action{transform:translateY(0);}
.product-tag{
  position:absolute;top:.7rem;left:.7rem;background:var(--white);
  font-size:.68rem;letter-spacing:.04em;padding:.3rem .65rem;border-radius:999px;color:var(--clay);
}
.product-name{font-size:.92rem;font-weight:500;margin-bottom:.3rem;line-height:1.4;}
.product-meta{display:flex;align-items:center;gap:.6rem;font-size:.85rem;}
.product-price{font-weight:600;color:var(--ink);}
.product-old{color:var(--taupe);text-decoration:line-through;font-size:.78rem;}
.product-sold{font-size:.75rem;color:var(--taupe);margin-top:.2rem;}
/* product-extra visibility is handled entirely by JS — no CSS override needed */
.product-sold-out .product-img img{opacity:.55;}
.product-soldout-badge{
  position:absolute;top:.7rem;right:.7rem;background:var(--ink);color:var(--cream);
  font-size:.66rem;letter-spacing:.04em;padding:.3rem .6rem;border-radius:999px;
}

/* ===== LOOKING FOR A MODEL ===== */
.lfm{background:var(--sand);}
.lfm-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.8rem;margin:2.5rem 0 3rem;}
.lfm-card{background:var(--white);border:1px solid var(--line);border-radius:14px;padding:2rem 1.6rem;text-align:center;transition:transform .25s,box-shadow .25s,border-color .25s;}
.lfm-card:hover{transform:translateY(-5px);box-shadow:0 14px 30px rgba(43,38,34,.08);border-color:var(--clay);}
.lfm-icon{width:42px;height:42px;border-radius:50%;background:var(--clay);color:var(--white);display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;font-family:'Fraunces',serif;font-size:1.1rem;transition:background .25s;}
.lfm-card:hover .lfm-icon{background:var(--ink);}
.lfm-card h4{font-size:1.1rem;margin-bottom:.6rem;}
.lfm-card p{font-size:.85rem;color:var(--taupe);line-height:1.65;}
.lfm-cta{text-align:center;}
.lfm-cta-sub{font-size:.88rem;color:var(--taupe);margin-bottom:1.3rem;}

/* ===== BENEFITS (what you get as a model) ===== */
.benefits-row{margin-top:3rem;padding-top:3rem;border-top:1px solid var(--line);}
.benefits-subhead{text-align:center;margin-bottom:2rem;}
.benefits-subhead h3{font-size:1.4rem;font-weight:400;margin-bottom:.5rem;}
.benefits-subhead p{font-size:.88rem;color:var(--taupe);}
.benefits-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:1.4rem;}
.benefit-card{
  background:var(--white);border:1px solid var(--line);border-radius:16px;
  padding:1.8rem 1.4rem 1.6rem;
  transition:transform .28s cubic-bezier(.4,0,.2,1),box-shadow .28s,border-color .28s;
  display:flex;flex-direction:column;gap:.1rem;
}
.benefit-card:hover{transform:translateY(-6px);box-shadow:0 18px 36px rgba(43,38,34,.1);border-color:var(--clay);}
.benefit-icon-wrap{
  width:48px;height:48px;border-radius:14px;
  background:linear-gradient(135deg,#f3ede4,#e8ddd0);
  border:1px solid rgba(176,137,104,.25);
  display:flex;align-items:center;justify-content:center;
  margin-bottom:1rem;
  transition:background .28s,transform .28s;
}
.benefit-card:hover .benefit-icon-wrap{
  background:linear-gradient(135deg,var(--clay),#9a734f);
  transform:scale(1.08);
}
.benefit-icon-wrap svg{width:22px;height:22px;stroke:var(--clay);fill:none;stroke-width:1.7;stroke-linecap:round;stroke-linejoin:round;transition:stroke .28s;}
.benefit-card:hover .benefit-icon-wrap svg{stroke:#fff;}
.benefit-card h5{font-size:.98rem;margin-bottom:.45rem;font-weight:500;}
.benefit-card p{font-size:.82rem;color:var(--taupe);line-height:1.65;}

/* ===== WHAT YOU'LL DO ===== */
.role-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:1.4rem;margin-top:1.5rem;}
.role-card{background:var(--white);border:1px solid var(--line);border-radius:14px;padding:1.8rem;display:flex;gap:1rem;align-items:flex-start;transition:transform .25s,box-shadow .25s;}
.role-card:hover{transform:translateY(-4px);box-shadow:0 14px 30px rgba(43,38,34,.08);}
.role-num{font-family:'Fraunces',serif;font-size:1.8rem;color:var(--clay);line-height:1;}
.role-card h5{font-size:1rem;margin-bottom:.4rem;}
.role-card p{font-size:.85rem;color:var(--taupe);line-height:1.6;}

/* ===== CREATOR QUESTIONS + BRAND STORY ===== */
.creator-questions-wrap{
  display:grid;grid-template-columns:1.3fr 1fr;gap:0;margin-top:3.5rem;
  border-radius:18px;overflow:hidden;border:1px solid var(--line);
}
.cq-panel{background:var(--ink);color:var(--cream);padding:3.2rem 2.8rem;}
.cq-panel .section-eyebrow{color:#c9a98a;margin-bottom:1rem;}
.cq-title{font-size:clamp(1.7rem,3vw,2.2rem);font-weight:400;line-height:1.2;margin-bottom:1.2rem;}
.cq-title em{font-style:italic;color:#c9a98a;}
.cq-sub{font-size:.88rem;color:rgba(250,247,242,.65);line-height:1.7;max-width:480px;margin-bottom:2.2rem;}
.cq-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:1px;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.1);}
.cq-card{background:var(--ink);padding:1.5rem 1.5rem 1.7rem;transition:background .25s;}
.cq-card:hover{background:#241a17;}
.cq-card h5{font-size:.95rem;font-weight:500;margin-bottom:.6rem;line-height:1.4;}
.cq-card p{font-size:.8rem;color:rgba(250,247,242,.58);line-height:1.65;}
.bs-panel{background:var(--cream);padding:3.2rem 2.6rem;display:flex;flex-direction:column;justify-content:center;}
.bs-eyebrow{font-size:.75rem;letter-spacing:.16em;text-transform:uppercase;color:var(--clay);margin-bottom:1rem;}
.bs-title{font-size:clamp(1.4rem,2.4vw,1.9rem);font-weight:400;line-height:1.3;margin-bottom:1.2rem;}
.bs-text{font-size:.85rem;color:var(--taupe);line-height:1.75;margin-bottom:2rem;}
.bs-btns{display:flex;gap:.9rem;flex-wrap:wrap;}
.bs-btns .btn-primary,.bs-btns .btn-outline{padding:.8rem 1.5rem;font-size:.78rem;}

/* ===== VOTE FOR A MODEL ===== */
.vote-section{background:var(--ink);color:var(--cream);position:relative;overflow:hidden;}
.vote-section::before{
  content:'';position:absolute;top:-20%;right:-10%;width:480px;height:480px;
  background:radial-gradient(circle,rgba(176,137,104,.18),transparent 70%);
  pointer-events:none;
}
.vote-section .section-eyebrow{color:#c9a98a;}
.vote-section .section-title{color:var(--cream);}
.vote-intro{font-size:.92rem;color:rgba(255,255,255,.55);max-width:440px;margin-top:.4rem;line-height:1.6;}
.vote-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:1.6rem;position:relative;z-index:1;}

.vote-card{
  position:relative;background:#3a342d;border-radius:16px;overflow:hidden;
  border:1px solid rgba(255,255,255,.08);
  transition:transform .35s cubic-bezier(.22,.61,.36,1),box-shadow .35s,border-color .35s;
}
.vote-card:hover{
  transform:translateY(-7px);
  box-shadow:0 20px 40px rgba(0,0,0,.35),0 0 0 1px rgba(176,137,104,.25);
  border-color:var(--clay);
}

.vote-img{position:relative;aspect-ratio:3/4;overflow:hidden;}
.vote-img img{width:100%;height:100%;object-fit:cover;transition:transform .6s cubic-bezier(.22,.61,.36,1);}
.vote-card:hover .vote-img img{transform:scale(1.08);}
.vote-img::after{
  content:'';position:absolute;inset:0;
  background:linear-gradient(180deg,rgba(20,17,14,0) 45%,rgba(20,17,14,.92) 100%);
  pointer-events:none;
}

.vote-entry-no{
  position:absolute;top:.8rem;left:.8rem;z-index:2;
  width:32px;height:32px;border-radius:50%;
  background:rgba(20,17,14,.55);backdrop-filter:blur(6px);
  border:1px solid rgba(255,255,255,.22);
  color:#fff;display:flex;align-items:center;justify-content:center;
  font-family:'Fraunces',serif;font-size:.82rem;letter-spacing:.02em;
}
.vote-loc-badge{
  position:absolute;top:.8rem;right:.8rem;z-index:2;
  display:flex;align-items:center;gap:.3rem;
  background:rgba(20,17,14,.55);backdrop-filter:blur(6px);
  border:1px solid rgba(255,255,255,.18);border-radius:999px;
  padding:.32rem .7rem;font-size:.68rem;letter-spacing:.02em;color:rgba(255,255,255,.9);
}
.vote-loc-badge svg{width:10px;height:10px;flex-shrink:0;}

.vote-overlay-info{position:absolute;left:0;right:0;bottom:0;z-index:2;padding:1.1rem 1rem .85rem;}
.vote-name{font-family:'Fraunces',serif;font-size:1.18rem;color:#fff;margin-bottom:.15rem;}
.vote-meta{font-size:.76rem;color:rgba(255,255,255,.65);letter-spacing:.02em;}

.vote-info{padding:.95rem 1.1rem 1.2rem;}
.vote-btn{
  width:100%;padding:.75rem;background:var(--clay);color:#fff;border:none;border-radius:9px;
  font-size:.78rem;letter-spacing:.06em;text-transform:uppercase;cursor:pointer;
  transition:background .25s,transform .2s;
  display:flex;align-items:center;justify-content:center;gap:.45rem;
}
.vote-btn svg{width:13px;height:13px;flex-shrink:0;transition:transform .25s;}
.vote-btn:hover{background:#9a734f;}
.vote-btn:hover svg{transform:scale(1.15);}
.vote-btn:active{transform:scale(.97);}
.vote-btn.voted{background:#4f7a52;cursor:default;}
.vote-btn:disabled{cursor:default;opacity:.9;}
.vote-btn:disabled:hover{background:var(--clay);}
.vote-btn.voted:disabled:hover{background:#4f7a52;}

/* ===== SHOWCASE / GALLERY ===== */
.showcase{background:var(--ink);color:var(--cream);}
.showcase .section-eyebrow{color:#c9a98a;}
.showcase-grid{
  display:grid;
  grid-template-columns:repeat(3,1fr);
  gap:1.4rem;
}
/* When only 1 or 2 items — center them */
.showcase-grid:has(.showcase-item:only-child),
.showcase-grid:has(.showcase-item:nth-child(1):nth-last-child(1)){
  justify-items:center;
}
.showcase-item{
  position:relative;border-radius:16px;overflow:hidden;
  background:#3a342d;border:1px solid rgba(255,255,255,.08);
  display:flex;flex-direction:column;
  transition:transform .28s,box-shadow .28s,border-color .28s;
  cursor:default;
}
.showcase-item:hover{
  transform:translateY(-6px);
  box-shadow:0 20px 44px rgba(0,0,0,.45);
  border-color:var(--clay);
}
.showcase-item-img{
  aspect-ratio:3/4;overflow:hidden;position:relative;flex-shrink:0;
}
.showcase-item-img img{
  width:100%;height:100%;object-fit:cover;display:block;
  transition:transform .5s ease;
}
.showcase-item:hover .showcase-item-img img{transform:scale(1.06);}
.showcase-item-overlay{
  position:absolute;inset:0;
  background:linear-gradient(to top,rgba(30,20,15,.85) 0%,transparent 55%);
  pointer-events:none;
}
.showcase-item-badge{
  position:absolute;top:.85rem;left:.85rem;
  background:rgba(176,137,104,.92);color:#fff;
  font-size:.65rem;letter-spacing:.07em;text-transform:uppercase;
  padding:.28rem .65rem;border-radius:999px;
}
.showcase-item-body{
  padding:1.1rem 1.2rem 1.3rem;background:#3a342d;
  display:flex;flex-direction:column;gap:.4rem;
}
.showcase-item-name{
  font-family:'Fraunces',serif;font-size:1.05rem;font-weight:400;color:var(--cream);
}
.showcase-item-meta{
  font-size:.76rem;color:rgba(250,247,242,.55);letter-spacing:.02em;
}
.showcase-item-tags{
  display:flex;flex-wrap:wrap;gap:.4rem;margin-top:.3rem;
}
.showcase-item-tag{
  font-size:.65rem;letter-spacing:.04em;color:rgba(250,247,242,.65);
  background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.1);
  border-radius:999px;padding:.22rem .6rem;
}
.showcase-placeholder-dark{
  display:flex;flex-direction:column;align-items:center;justify-content:center;
  gap:.5rem;color:rgba(250,247,242,.3);height:260px;
}
.showcase-placeholder-dark svg{width:32px;height:32px;}
.showcase-placeholder-dark span{font-size:.68rem;letter-spacing:.06em;text-transform:uppercase;}
.showcase-cta-row{
  margin-top:2.4rem;text-align:center;
}
.showcase-cta-row p{font-size:.88rem;color:rgba(250,247,242,.55);margin-bottom:1rem;}

/* ===== VIDEO SHOWCASE — single-row sliding carousel ===== */
.video-carousel{position:relative;display:flex;align-items:center;gap:0;}
.video-track-viewport{
  flex:1;
  overflow:hidden;   /* clip cards outside the viewport */
  position:relative;
}
.video-track{
  display:flex;
  align-items:center;
  position:relative;
  /* padding keeps outermost cards partly visible even at first/last stop */
  padding:2rem 0 2.4rem;
  transition:transform .5s cubic-bezier(.22,.61,.36,1);
  will-change:transform;
}
/* ── default state: blurred, small, dark ── */
.video-card{
  flex:0 0 auto;
  width:200px;
  aspect-ratio:9/16;
  background:#3a342d;
  border-radius:14px;
  overflow:hidden;
  position:relative;
  border:1px solid rgba(255,255,255,.08);
  margin:0 .6rem;
  /* focus/blur depth-of-field effect */
  opacity:.45;
  transform:scale(.78);
  filter:blur(3px) brightness(.6);
  transition:
    transform .5s cubic-bezier(.22,.61,.36,1),
    opacity   .5s cubic-bezier(.22,.61,.36,1),
    filter    .5s cubic-bezier(.22,.61,.36,1),
    border-color .25s,
    box-shadow   .25s;
  cursor:pointer;
}
/* ── center card: sharp, full-size, elevated ── */
.video-card.is-center{
  opacity:1;
  transform:scale(1.08);
  filter:none;
  border-color:var(--clay);
  box-shadow:0 24px 48px rgba(0,0,0,.55);
  z-index:2;
  cursor:default;
}
/* ── immediate neighbours: slightly blurred ── */
.video-card.is-adjacent{
  opacity:.72;
  transform:scale(.88);
  filter:blur(1.5px) brightness(.78);
}
.video-card video{width:100%;height:100%;object-fit:cover;display:block;}
.video-card .video-label{
  position:absolute;bottom:.6rem;left:.6rem;right:.6rem;
  font-size:.7rem;color:#fff;background:rgba(0,0,0,.45);
  padding:.3rem .5rem;border-radius:6px;letter-spacing:.02em;
  opacity:0;transition:opacity .3s;
  pointer-events:none;
}
.video-card.is-center .video-label{opacity:1;}
.video-mute-btn{
  position:absolute;top:.6rem;right:.6rem;width:32px;height:32px;border-radius:50%;
  background:rgba(0,0,0,.55);border:none;color:#fff;cursor:pointer;
  display:flex;align-items:center;justify-content:center;font-size:.9rem;z-index:3;
  transition:background .2s,opacity .3s;
  opacity:0;pointer-events:none;
}
.video-card.is-center .video-mute-btn{opacity:1;pointer-events:auto;}
.video-mute-btn:hover{background:rgba(0,0,0,.8);}
.video-nav-btn{
  flex:0 0 auto;width:46px;height:46px;border-radius:50%;
  background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.15);color:#fff;
  cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:1.1rem;
  transition:background .2s,border-color .2s,transform .2s;
  z-index:4;flex-shrink:0;
}
.video-nav-btn:hover{background:rgba(255,255,255,.14);border-color:var(--clay);}
.video-nav-btn:active{transform:scale(.92);}
.video-nav-btn:disabled{cursor:default;}
.video-nav-btn:disabled:hover{background:rgba(255,255,255,.06);border-color:rgba(255,255,255,.15);}
.video-nav-prev{margin-right:.8rem;}
.video-nav-next{margin-left:.8rem;}
.video-dots{display:flex;justify-content:center;gap:.45rem;margin-top:1.6rem;}
.video-dot{width:6px;height:6px;border-radius:50%;background:rgba(255,255,255,.25);border:none;cursor:pointer;transition:.25s;padding:0;}
.video-dot.active{background:var(--clay);transform:scale(1.4);}

/* ===== FOOTER ===== */
.footer{position:relative;padding:0 0 2rem;border-top:1px solid var(--line);background:var(--sand);overflow:hidden;}
.footer::before{
  content:'';position:absolute;top:0;left:0;right:0;height:3px;
  background:linear-gradient(90deg,var(--clay),var(--ink) 50%,var(--clay));opacity:.35;
}

/* -- Newsletter strip -- */
.footer-news{padding:3.4rem 0;border-bottom:1px solid var(--line);}
.footer-news-inner{display:flex;justify-content:space-between;align-items:center;gap:2rem;flex-wrap:wrap;}
.footer-news-text h3{font-size:clamp(1.3rem,2.4vw,1.7rem);margin-bottom:.4rem;}
.footer-news-text p{font-size:.86rem;color:var(--taupe);}
.footer-news-form{display:flex;gap:.6rem;flex:0 0 auto;width:100%;max-width:380px;}
.footer-news-form input{
  flex:1;min-width:0;padding:.85rem 1.2rem;border:1px solid var(--line);border-radius:999px;
  font-family:inherit;font-size:.85rem;background:var(--white);color:var(--ink);transition:border-color .25s;
}
.footer-news-form input::placeholder{color:var(--taupe);}
.footer-news-form input:focus{outline:none;border-color:var(--clay);}
.footer-news-form button{
  flex:0 0 auto;padding:.85rem 1.6rem;background:var(--ink);color:var(--cream);border:none;
  border-radius:999px;font-family:inherit;font-size:.82rem;letter-spacing:.03em;cursor:pointer;transition:background .25s;
}
.footer-news-form button:hover{background:var(--clay);}
.footer-news-note{font-size:.74rem;color:var(--taupe);margin-top:.6rem;}

/* -- Main columns -- */
.footer-top{display:grid;grid-template-columns:1.4fr 1fr 1fr 1fr;gap:2.5rem;padding:3.4rem 0 2.6rem;}
.footer-brand-block{padding-right:1rem;}
.footer-logo{display:flex;align-items:center;gap:.55rem;font-family:'Fraunces',serif;font-size:1.5rem;letter-spacing:.03em;margin-bottom:.9rem;}
.footer-logo img{height:30px;width:auto;border-radius:6px;}
.footer-desc{font-size:.85rem;color:var(--taupe);line-height:1.7;max-width:280px;margin-bottom:1.4rem;}
.footer-socials{display:flex;gap:.6rem;}
.footer-social-btn{
  width:36px;height:36px;border-radius:50%;border:1px solid var(--line);
  display:flex;align-items:center;justify-content:center;background:var(--white);
  transition:background .25s,border-color .25s,transform .25s;
}
.footer-social-btn svg{width:16px;height:16px;stroke:var(--ink);fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;transition:stroke .25s;}
.footer-social-btn:hover{background:var(--ink);border-color:var(--ink);transform:translateY(-3px);}
.footer-social-btn:hover svg{stroke:var(--cream);}

.footer-col h5{font-size:.76rem;letter-spacing:.1em;text-transform:uppercase;margin-bottom:1.1rem;color:var(--ink);font-weight:600;}
.footer-col a{
  display:flex;align-items:center;gap:.4rem;font-size:.85rem;color:var(--taupe);
  margin-bottom:.75rem;transition:color .2s,gap .2s;width:fit-content;
}
.footer-col a:hover{color:var(--clay);gap:.55rem;}
.footer-col a svg{width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2;flex-shrink:0;}
.footer-contact-item{display:flex;align-items:flex-start;gap:.5rem;font-size:.85rem;color:var(--taupe);line-height:1.6;margin-bottom:.75rem;}
.footer-contact-item svg{width:14px;height:14px;stroke:var(--clay);fill:none;stroke-width:1.8;flex-shrink:0;margin-top:.15rem;}

/* -- Bottom bar -- */
.footer-bottom{
  display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap;
  font-size:.78rem;color:var(--taupe);border-top:1px solid var(--line);padding-top:1.5rem;
}
.footer-bottom-links{display:flex;gap:1.4rem;flex-wrap:wrap;}
.footer-bottom-links a{color:var(--taupe);transition:color .2s;}
.footer-bottom-links a:hover{color:var(--ink);}
.footer-top-btn{
  display:flex;align-items:center;gap:.4rem;color:var(--taupe);font-size:.78rem;
  border:1px solid var(--line);border-radius:999px;padding:.5rem 1rem;background:var(--white);
  transition:.25s;cursor:pointer;font-family:inherit;
}
.footer-top-btn svg{width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2;transition:transform .25s;}
.footer-top-btn:hover{border-color:var(--ink);color:var(--ink);}
.footer-top-btn:hover svg{transform:translateY(-2px);}

/* ===== RESPONSIVE ===== */
@media(max-width:900px){
  .container,.hero-inner{padding:0 1.5rem;}
  .nav-inner{padding:.9rem 1.5rem;}
  .hero-inner{grid-template-columns:1fr;}
  .hero-visual{order:-1;aspect-ratio:16/10;}
  .products-grid{grid-template-columns:repeat(3,1fr);}
  .showcase-grid{grid-template-columns:repeat(3,1fr);}
  .video-card{width:155px;margin:0 .45rem;}
  .video-nav-btn{width:40px;height:40px;font-size:1rem;}
  .lfm-grid{grid-template-columns:1fr;}
  .benefits-grid{grid-template-columns:repeat(2,1fr);}
  .role-grid{grid-template-columns:1fr;}
  .vote-grid{grid-template-columns:repeat(2,1fr);}
  .creator-questions-wrap{grid-template-columns:1fr;}
  .cq-grid{grid-template-columns:1fr;}
  .cq-panel,.bs-panel{padding:2.4rem 1.8rem;}
  .footer-top{grid-template-columns:1fr 1fr;}
  .footer-news-inner{flex-direction:column;align-items:flex-start;}
  .footer-news-form{max-width:100%;}
  .nav-links{
    position:fixed;top:0;right:-100%;height:100vh;width:min(300px,85vw);
    background:var(--cream);flex-direction:column;padding:5rem 2rem 2rem;
    transition:right .35s;box-shadow:-8px 0 30px rgba(0,0,0,.1);
  }
  .nav-links.open{right:0;}
  .nav-links a{padding:.9rem 0;display:block;border-bottom:1px solid var(--line);}
  .nav-hamburger{display:flex;flex-shrink:0;}
  .nav-cta{flex-shrink:0;padding:.6rem 1.1rem;font-size:.74rem;}
}
@media(max-width:600px){
  .products-grid{grid-template-columns:repeat(2,1fr);gap:1rem;}
  .showcase-grid{grid-template-columns:repeat(2,1fr);}
  .video-card{width:120px;margin:0 .3rem;}
  .video-nav-btn{width:34px;height:34px;font-size:.85rem;}
  .video-nav-prev{margin-right:.35rem;}
  .video-nav-next{margin-left:.35rem;}
  .benefits-grid{grid-template-columns:1fr;}
  .vote-grid{grid-template-columns:1fr;}
  .section{padding:3.2rem 0;}
  .section-head{flex-direction:column;align-items:flex-start;}
  .footer-top{grid-template-columns:1fr;gap:2.2rem;}
  .footer-brand-block{padding-right:0;}
}
@media(max-width:480px){
  .container,.hero-inner{padding:0 1.1rem;}
  .nav-inner{padding:.8rem 1.1rem;gap:.5rem;}
  .nav-logo{font-size:1.2rem;gap:.4rem;}
  .nav-logo img{height:28px;}
  .nav-cta{display:none;}
  .hero{padding:3.2rem 0 3rem;}
  .hero-btns{gap:.7rem;}
  .hero-btns .btn-primary,.hero-btns .btn-outline{padding:.85rem 1.5rem;font-size:.8rem;}
  .cats{padding:2.2rem 0 .8rem;}
  .cat-pill{padding:.6rem 1.2rem;font-size:.78rem;}
  .products-grid{gap:.8rem;}
  .product-name{font-size:.85rem;}
  .product-meta{font-size:.8rem;}
  .lfm-card,.benefit-card,.role-card{padding:1.4rem 1.2rem;}
  .cq-panel,.bs-panel{padding:1.8rem 1.2rem;}
  .vote-grid{gap:1rem;}
  .footer-bottom{flex-direction:column;align-items:flex-start;gap:.9rem;}
  .footer-bottom-links{gap:1rem;}
  .footer-news-form{flex-direction:column;}
  .footer-news-form button{width:100%;}
}

/* ===== SITE LOADER (full page load) ===== */
.site-loader{
  position:fixed;inset:0;z-index:10000;background:var(--cream);
  display:flex;flex-direction:column;align-items:center;justify-content:center;gap:1.2rem;
  transition:opacity .5s ease,visibility .5s ease;
}
.site-loader.hide{opacity:0;visibility:hidden;}
.site-loader-mark{font-family:'Fraunces',serif;font-size:1.6rem;letter-spacing:.08em;color:var(--ink);}
.site-loader-bar{width:160px;height:3px;background:var(--line);border-radius:99px;overflow:hidden;}
.site-loader-fill{width:0%;height:100%;background:var(--clay);transition:width .3s ease;}

/* ===== VOTE CONFIRMATION MODAL ===== */
.vote-modal-overlay{
  position:fixed;inset:0;z-index:9000;background:rgba(43,38,34,.55);backdrop-filter:blur(3px);
  display:none;align-items:center;justify-content:center;padding:1.5rem;
}
.vote-modal-overlay.open{display:flex;}
.vote-modal{
  background:var(--cream);border-radius:14px;padding:2.2rem 2rem;max-width:380px;width:100%;
  text-align:center;box-shadow:0 30px 60px rgba(0,0,0,.25);
}
.vote-modal h4{font-family:'Fraunces',serif;font-size:1.3rem;font-weight:400;margin-bottom:.8rem;}
.vote-modal p{font-size:.88rem;color:var(--taupe);line-height:1.6;margin-bottom:1.6rem;}
.vote-modal-btns{display:flex;gap:.8rem;justify-content:center;}
.vote-modal-btns .btn-outline,.vote-modal-btns .btn-primary{padding:.75rem 1.6rem;font-size:.8rem;}
.vote-modal-loading{display:none;align-items:center;justify-content:center;gap:.6rem;margin-top:1.2rem;font-size:.82rem;color:var(--taupe);}
.vote-modal-loading.show{display:flex;}
.mini-spinner{width:18px;height:18px;border:2px solid var(--line);border-top-color:var(--clay);border-radius:50%;animation:miniSpin .7s linear infinite;}
@keyframes miniSpin{to{transform:rotate(360deg);}}
</style>
</head>
<body>

<!-- SITE LOADER -->
<div class="site-loader" id="siteLoader">
  <div class="site-loader-mark">MERA</div>
  <div class="site-loader-bar"><div class="site-loader-fill" id="siteLoaderFill"></div></div>
</div>

<!-- VOTE CONFIRM MODAL -->
<div class="vote-modal-overlay" id="voteModalOverlay">
  <div class="vote-modal">
    <h4>Confirm your vote</h4>
    <p>Are you sure you want to vote for <strong id="voteModalName">this model</strong>?</p>
    <div class="vote-modal-btns">
      <button class="btn-outline" type="button" onclick="closeVoteConfirm()">Cancel</button>
      <button class="btn-primary" type="button" id="voteModalYes" onclick="confirmVote()">Yes, Vote</button>
    </div>
    <div class="vote-modal-loading" id="voteModalLoading">
      <div class="mini-spinner"></div>
      <span>Submitting your vote…</span>
    </div>
  </div>
</div>

<!-- NAV -->
<nav class="nav">
  <div class="nav-inner">
    <a href="index.php" class="nav-logo">
      <img src="files/images/logo.jpg" alt="MERA logo">
      MERA
    </a>
    <ul class="nav-links" id="navLinks">
      <li><a href="#shop">Shop</a></li>
      <li><a href="#looking-for-model">Looking for Collaborators</a></li>
      <li><a href="#videos">Showcase</a></li>
      <?php if (VOTEPAGE_ENABLED): ?>
      <li><a href="#vote-for-model">Vote for a Model</a></li>
      <?php endif; ?>
      <li><a href="apply.php">Collaborate With Us</a></li>
    </ul>
    <div style="display:flex;align-items:center;gap:1rem;">
      <a href="apply.php" class="nav-cta" id="navCta">Collaborate With Us</a>
      <button class="nav-hamburger" id="hamburger" onclick="toggleNav()">
        <span></span><span></span><span></span>
      </button>
    </div>
  </div>
</nav>

<!-- HERO -->
<section class="hero">
  <div class="hero-inner">
    <div>
      <div class="hero-eyebrow">Everyday Essentials</div>
      <h1 class="hero-title">Soft basics,<br><em>effortlessly</em> put together.</h1>
      <p class="hero-sub">Clean, body-flattering essentials in neutral tones — made for the way you actually get dressed every day.</p>
      <div class="hero-btns">
        <a href="#shop" class="btn-primary">Shop the Collection</a>
        <a href="apply.php" class="btn-outline">Collaborate With Us</a>
      </div>
    </div>
    <div class="hero-visual" id="heroSlider">
      <?php
      // ── HERO SLIDESHOW ──
      // Add one line per slide. Images AND videos both work.
      // The first entry is the one that shows on page load.
      $hero_slides = [
        "files/videos/video14.mp4",
        "files/images/A1.jpg",
        "files/images/A2.jpg",
        "files/images/B1.jpg",
        "files/images/B2.jpg",
        "files/images/B3.jpg",
        "files/images/C1.jpg",
        "files/images/C2.jpg",
        "files/images/main1.webp",
        "files/images/main2.webp",
        "files/images/main3.webp",
        "files/images/main4.webp",
        "files/images/main5.webp",
      ];

      // File types treated as video.
      $video_ext = ['mp4', 'webm', 'ogg', 'mov', 'm4v'];

      foreach ($hero_slides as $i => $src) {
        $active   = $i === 0 ? ' active' : '';
        $ext      = strtolower(pathinfo($src, PATHINFO_EXTENSION));
        $is_video = in_array($ext, $video_ext, true);
        $safe_src = htmlspecialchars($src);

        echo '<div class="hero-slide'.$active.'">';
        if ($is_video) {
          // muted + playsinline are REQUIRED or phones refuse to autoplay
          echo '<video src="'.$safe_src.'" muted playsinline preload="metadata"></video>';
        } else {
          echo '<img src="'.$safe_src.'" alt="MERA hero look '.($i+1).'" loading="lazy">';
        }
        echo '</div>';
      }
      ?>
      <div class="hero-dots">
        <?php foreach ($hero_slides as $i => $src):
          $active = $i === 0 ? ' active' : ''; ?>
          <button class="hero-dot<?php echo $active; ?>" data-slide="<?php echo $i; ?>"></button>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- CATEGORY STRIP -->
<section class="cats">
  <div class="container">
    <div class="cats-inner" id="catFilters">
      <button class="cat-pill active" data-filter="all">All Products</button>
      <button class="cat-pill" data-filter="Top">Top</button>
    
      <button class="cat-pill" data-filter="Dress">Dress</button>
      <button class="cat-pill" data-filter="Pants">Pants</button>
      <button class="cat-pill" data-filter="Sold Out">Sold Out</button>
    </div>
  </div>
</section>

<!-- PRODUCT GRID -->
<section class="section" id="shop">
  <div class="container">
    <div class="section-head">
      <div>
        <div class="section-eyebrow">The Edit</div>
        <h2 class="section-title">Best-selling essentials</h2>
      </div>
      <button type="button" class="section-link" id="viewAllBtn">View all products</button>
    </div>
    <div class="products-grid" id="productsGrid">
      <?php
      // Replace this array with your real product data / database query later.
      // Format: [name, category, price, old price, sold label, is_sold_out]
      // To add more products, just add another line — the grid and "View all" button adjust automatically.
$products = [

  // ===================== PAGE 1 =====================
  ["MERA Soft Curve Set", "Top", "₱296", "₱296", "297 sold", false],
  ["MERA Soft Bare Set", "Top", "₱276", "₱315", "467 sold", false],
  ["MERA Ringer Tee Basic Plain Cotton Roundneck", "Top", "₱269", "₱349", "2K+ sold", false],
  ["MERA Olga Long Sleeve T-Shirt Slim Fit Crew Neck", "Top", "₱160", "₱800", "1K+ sold", false],
  ["MERA Gia Racerback Tank Top", "Top", "₱162", "₱300", "4K+ sold", false],

  ["MERA Premium Martina Scoop Neck Top", "Top", "₱240", "₱800", "3K+ sold", false],
  ["MERA Premium Alexa Classic Top", "Top", "₱300", "₱800", "587 sold", false],
  ["MERA Premium Renata Short Sleeve T-Shirt", "Top", "₱225", "₱800", "621 sold", false],
  ["MERA Premium Naomi Short Sleeve T-Shirt", "Top", "₱270", "₱800", "766 sold", false],

  ["MERA Naomi T-Shirt Basic Cotton Roundneck", "Top", "₱146", "₱350", "5K+ sold", false],
  ["MERA Tyla Crop Top Slim Fit Roundneck", "Top", "₱269", "₱299", "802 sold", false],
  ["MERA Catlea Short Sleeve Crop Top", "Top", "₱157", "₱550", "9K+ sold", false],

  ["MERA Andrea Lounge Pants", "Pants", "₱498", "₱600", "380 sold", false],
  ["MERA The Lounge Pants Plain", "Pants", "₱498", "₱600", "1K+ sold", false],
  ["MERA TALL Trouser Pants", "Pants", "₱1,599", "₱1,999", "294 sold", false],

  ["MERA Amara Off Shoulder Top", "Top", "₱296", "₱330", "819 sold", false],
  ["MERA Alana Subtle Sleek Top", "Top", "₱269", "₱300", "580 sold", false],
  ["MERA Emilia Chic Fitted Top", "Top", "₱282", "₱320", "113 sold", false],
  ["MERA Vera Tube Top Basic", "Top", "₱153", "₱300", "1K+ sold", false],

  ["MERA Matilda Halter Top Slim Fit", "Top", "₱154", "₱650", "10K+ sold", false],
  ["MERA Alexa Long Sleeve Shirt Slim Fit", "Top", "₱208", "₱800", "10K+ sold", false],
  ["MERA Iza Cami Crossback Tank Top", "Top", "₱157", "₱350", "8K+ sold", false],
  ["MERA Arya Tank Top Slim Fit", "Top", "₱165", "₱300", "10K+ sold", false],

  ["MERA Renata Cotton Short Sleeve T-Shirt", "Top", "₱170", "₱400", "6K+ sold", false],


  // ===================== PAGE 2 =====================
  ["MERA Nelly Tube Dress", "Dress", "₱1,680", "₱1,680", "14 sold", true],
  ["MERA Olivette Slip Dress", "Dress", "₱1,400", "₱1,400", "29 sold", true],
  ["MERA Cianne Silk Cami Dress", "Dress", "₱1,400", "₱1,400", "44 sold", true],
  ["MERA Francesca Tube Top Dress", "Dress", "₱598", "₱598", "15 sold", true],

];
      $visible_count = 8; // how many show by default before "View all" is clicked
      foreach ($products as $i => $p) {
        $is_sold = $p[5];
        $extra_class = $i >= $visible_count ? ' product-extra' : '';
        $sold_class = $is_sold ? ' product-sold-out' : '';
        $real_category = $p[1]; // always keep real category so filter works
        $soldout_attr  = $is_sold ? ' data-soldout="1"' : '';
        $initial_index = ' data-initial-index="'.$i.'"';

        // ── Image path ──
        // Drop the real product photo in files/images/products/ using this exact
        // filename (matches product order, e.g. 1.jpg, 2.jpg, 3.jpg ...).
        // Until the file exists, the gray "Product photo" placeholder shows automatically.
        $img_path = 'files/images/products/'.($i + 1).'.webp';

        echo '<div class="product-card'.$sold_class.'" data-category="'.htmlspecialchars($real_category).'"'.$soldout_attr.$initial_index.'>
          <div class="product-img">
            <span class="product-tag">'.$p[1].'</span>'
            .($is_sold ? '<span class="product-soldout-badge">Sold Out</span>' : '').'
            <img src="'.$img_path.'" alt="'.htmlspecialchars($p[0]).'" loading="lazy" onerror="this.style.display=\'none\';this.nextElementSibling.style.display=\'flex\';">
            <div class="product-img-placeholder">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="18" height="18" rx="3"/>
                <circle cx="8.5" cy="8.5" r="1.5"/>
                <polyline points="21 15 16 10 5 21"/>
              </svg>
              <span>Product photo</span>
            </div>
            <div class="product-img-hover-action">View product</div>
          </div>
          <div class="product-name">'.$p[0].'</div>
          <div class="product-meta">
            <span class="product-price">'.$p[2].'</span>
            <span class="product-old">'.$p[3].'</span>
          </div>
          <div class="product-sold">'.$p[4].'</div>
        </div>';
      }
      ?>
    </div>
  </div>
</section>

<!-- LOOKING FOR A MODEL -->
<section class="section lfm" id="looking-for-model">
  <div class="container">
    <div class="section-head">
      <div>
        <div class="section-eyebrow">Join the Brand</div>
        <h2 class="section-title">Looking for Collaborators</h2>
      </div>
    </div>
    <div class="lfm-grid">
      <div class="lfm-card">
        <div class="lfm-icon">1</div>
        <h4>Natural, everyday look</h4>
        <p>We're drawn to genuine, relaxed energy — not overly posed. If you feel at home in soft basics, you'll feel at home here.</p>
      </div>
      <div class="lfm-card">
        <div class="lfm-icon">2</div>
        <h4>Comfortable on camera</h4>
        <p>Short-form video experience is a plus, but not required. We care more about authenticity than a polished reel.</p>
      </div>
      <div class="lfm-card">
        <div class="lfm-icon">3</div>
        <h4>Aligned with our values</h4>
        <p>Body-positive, low-key confident, and proud to wear pieces that are made to actually move with you.</p>
      </div>
    </div>
    <div class="lfm-cta">
      <p class="lfm-cta-sub">Think you'd be a good fit? We'd love to collaborate with you.</p>
      <a href="apply.php" class="btn-primary">Start a Collaboration</a>
    </div>

    <!-- WHAT YOU GET (benefits of collaborating with the brand) -->
    <div class="benefits-row">
      <div class="benefits-subhead">
        <h3>What you get as a MERA collaborator</h3>
        <p>Collaborating with MERA is the start of an ongoing partnership, not a one-time shoot.</p>
      </div>
      <div class="benefits-grid">
        <div class="benefit-card">
          <div class="benefit-icon-wrap">
            <svg viewBox="0 0 24 24"><path d="M20 12v9H4v-9"/><path d="M22 7H2v5h20V7z"/><path d="M12 22V7"/><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"/><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"/></svg>
          </div>
          <h5>Free campaign pieces</h5>
          <p>Receive MERA essentials from each campaign you're featured in, yours to keep.</p>
        </div>
        <div class="benefit-card">
          <div class="benefit-icon-wrap">
            <svg viewBox="0 0 24 24"><path d="M22 4s-2.5 2.5-5 2.5S12 4 12 4s-2.5 2.5-5 2.5S2 4 2 4v16s2.5-2.5 5-2.5S12 20 12 20s2.5-2.5 5-2.5 5 2.5 5 2.5V4z"/><line x1="12" y1="4" x2="12" y2="20"/></svg>
          </div>
          <h5>Brand exposure</h5>
          <p>Your content gets reposted across MERA's TikTok, Instagram, and Shopee storefront.</p>
        </div>
        <div class="benefit-card">
          <div class="benefit-icon-wrap">
            <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
          </div>
          <h5>Paid collaborations</h5>
          <p>Ongoing creators may be offered paid posts or live sessions as the partnership grows.</p>
        </div>
        <?php if (VOTEPAGE_ENABLED): ?>
        <div class="benefit-card">
          <div class="benefit-icon-wrap">
            <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
          </div>
          <h5>Model contest entry</h5>
          <p>Collaborators are automatically entered into our community-voted Model of the Season contest.</p>
        </div>
        <?php else: ?>
        <div class="benefit-card">
          <div class="benefit-icon-wrap">
            <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 11l-2 2 4 4"/><path d="M21 15l2-2-4-4"/></svg>
          </div>
          <h5>Community shoutouts</h5>
          <p>Ongoing collaborators get featured and reshared across MERA's community showcase.</p>
        </div>
        <?php endif; ?>
      </div>

      <!-- WHAT THEY'LL ACTUALLY DO -->
      <div class="role-grid">
        <div class="role-card">
          <div class="role-num">A</div>
          <div>
            <h5>Post as a TikTok creator</h5>
            <p>Style and post MERA pieces on your own TikTok — outfit videos, try-ons, everyday fits.</p>
          </div>
        </div>
        <div class="role-card">
          <div class="role-num">B</div>
          <div>
            <h5>Go live for MERA</h5>
            <p>Host a TikTok live featuring MERA essentials — styling, Q&A, or a casual shopping session.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- CREATOR QUESTIONS + BRAND STORY -->
    <div class="creator-questions-wrap">
      <div class="cq-panel">
        <div class="section-eyebrow">Creator Questions</div>
        <h3 class="cq-title">A few quick answers <em>before</em><br><em>you collaborate</em></h3>
        <p class="cq-sub">Learn how the MERA creator program works, what selected creators may receive, and what kind of content you can make for the brand.</p>
        <div class="cq-grid">
          <div class="cq-card">
            <h5>Do selected creators receive products?</h5>
            <p>Yes. Selected creators receive campaign pieces to style and post, depending on the active collection and available slots.</p>
          </div>
          <div class="cq-card">
            <h5>Where will I post my content?</h5>
            <p>Mainly TikTok — through outfit posts or live sessions. Other platforms may be added depending on the campaign.</p>
          </div>
          <div class="cq-card">
            <h5>How are creators selected?</h5>
            <p>Applications are reviewed based on content style, engagement, brand fit, and the number of available slots.</p>
          </div>
          <div class="cq-card">
            <h5>What kind of content can I make?</h5>
            <p>Outfit checks, try-on hauls, GRWM, styling reels, or casual TikTok lives featuring MERA essentials.</p>
          </div>
        </div>
      </div>
      <div class="bs-panel">
        <div class="bs-eyebrow">Brand Story</div>
        <h3 class="bs-title">Everyday essentials that feel soft, effortless, and put-together.</h3>
        <p class="bs-text">MERA is made for girls who love clean, minimal styling — pieces that feel as good in real life as they look on camera. From soft basics to elevated essentials, the brand celebrates ease, confidence, and modern Filipina self-expression.</p>
        <div class="bs-btns">
          <a href="#shop" class="btn-primary">Shop Essentials</a>
          <a href="apply.php" class="btn-outline">Collaborate With Us</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SHOWCASE -->
<section class="section showcase" id="showcase">
  <div class="container">
    <div class="section-head">
      <div>
        <div class="section-eyebrow">On the Brand</div>
        <h2 class="section-title">Styled by our community</h2>
      </div>
    </div>
    <div class="showcase-grid">
      <?php
      // ── COMMUNITY SHOWCASE ITEMS ──
      // Format: [image_path, model_name, location, tags[]]
      // Add up to any number — grid auto-centers if 3 or fewer.
      $showcase_items = [
        ["files/images/1.jpg", "Mika S.",    "Quezon City",  ["#EverydayFit", "#SoftBasics"]],
        ["files/images/2.jpg", "Andrea C.",  "Cebu City",    ["#MERAEssentials", "#OOTD"]],
        ["files/images/3.jpg", "Liz F.",     "Davao City",   ["#MinimalLook", "#NeutralTones"]],
      ];
      foreach ($showcase_items as $idx => $item):
        $img_src  = $item[0];
        $name     = $item[1];
        $location = $item[2];
        $tags     = $item[3];
        $look_num = $idx + 1;
      ?>
        <div class="showcase-item">
          <div class="showcase-item-img">
            <img src="<?php echo htmlspecialchars($img_src); ?>"
                 alt="MERA styled look <?php echo $look_num; ?>"
                 onerror="this.style.display='none';">
            <div class="showcase-item-overlay"></div>
            <span class="showcase-item-badge">Look <?php echo $look_num; ?></span>
            <!-- fallback shown via onerror if image missing -->
          </div>
          <div class="showcase-item-body">
            <div class="showcase-item-name"><?php echo htmlspecialchars($name); ?></div>
            <div class="showcase-item-meta">📍 <?php echo htmlspecialchars($location); ?> · Wearing MERA</div>
            <div class="showcase-item-tags">
              <?php foreach ($tags as $tag): ?>
                <span class="showcase-item-tag"><?php echo htmlspecialchars($tag); ?></span>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="showcase-cta-row">
      <p>Tag us <strong style="color:var(--clay);">@meraessentials</strong> to be featured in our community showcase.</p>
      <a href="apply.php" class="btn-primary" style="display:inline-block;">Join as a Collaborator</a>
    </div>
  </div>
</section>

<!-- VIDEO SHOWCASE -->
<section class="section showcase" id="videos">
  <div class="container">
    <div class="section-head">
      <div>
        <div class="section-eyebrow">From TikTok</div>
        <h2 class="section-title">Watch the looks in motion</h2>
      </div>
    </div>
    <div class="video-carousel">
      <button class="video-nav-btn video-nav-prev" id="videoPrev" aria-label="Previous look">&#8249;</button>
      <div class="video-track-viewport">
        <div class="video-track" id="videoTrack">
<?php
// ── VIDEO SHOWCASE LIST ──
// Each entry is now ONLY the video path (no labels)

$videos = [
    ["files/videos/video1.mp4"],
    ["files/videos/video2.mp4"],
    ["files/videos/video10.mp4"],
    ["files/videos/video7.mp4"],
    ["files/videos/video9.mp4"],
    ["files/videos/video8.mp4"],
    ["files/videos/video4.mp4"],
    ["files/videos/video6.mp4"],
    ["files/videos/video5.mp4"],
    ["files/videos/video3.mp4"],
    ["files/videos/video11.mp4"],
    ["files/videos/video12.mp4"],
    ["files/videos/video13.mp4"],
];

// loop
foreach ($videos as $i => $v) {
    echo '
    <div class="video-card" data-index="'.$i.'">
        <video id="vid-'.$i.'" 
               src="'.$v[0].'" 
               muted 
               loop 
               playsinline 
               preload="metadata" 
               poster=""></video>

        <button class="video-mute-btn" onclick="toggleMute(this, '.$i.')" aria-label="Toggle sound">🔇</button>
    </div>';
}
?>
</div>
        </div>
      <button class="video-nav-btn video-nav-next" id="videoNext" aria-label="Next look">&#8250;</button>
    </div>
    <div class="video-dots" id="videoDots"></div>
  </div>
</section>

<?php if (VOTEPAGE_ENABLED): ?>
<!-- VOTE FOR A MODEL -->
<section class="section vote-section" id="vote-for-model">
  <div class="container">
    <div class="section-head">
      <div>
        <div class="section-eyebrow">Model of the Season</div>
        <h2 class="section-title">Vote for a Model</h2>
        <p class="vote-intro">Meet this season's contestants. Pick your favorite — vote as many times as you like.</p>
      </div>
    </div>
    <div class="vote-grid" id="voteGrid">
        <?php
        // ── MODELS JOINED THE CONTEST ──
        // Add a new model by adding another array entry below.
        // Format: [image, name, age, location]
      $models = [
      ["files/images/vote/vote1.jpg", "Mika Santos",   22, "Quezon City"],
      ["files/images/vote/vote2.jpg", "Andrea Cruz",   24, "Cebu City"],
      ["files/images/vote/vote3.jpg", "Liz Fernandez", 21, "Davao City"],
      ["files/images/vote/vote4.jpg", "Carla Reyes",   23, "Pasig City"],
      ["files/images/vote/vote5.jpg", "Jasmine Dela Cruz", 25, "Makati City"],
      ["files/images/vote/vote6.jpg", "Nicole Garcia",  20, "Taguig City"],
      ["files/images/vote/vote7.jpg", "Sofia Mendoza",  26, "Iloilo City"],
      ["files/images/vote/vote8.jpg", "Angel Rivera",   23, "Baguio City"],
  ];
        foreach ($models as $i => $m) {
          $entry_no = str_pad($i + 1, 2, '0', STR_PAD_LEFT);
          $heart_icon = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21s-6.7-4.35-9.3-8.1C.8 9.9 1.6 6.4 4.7 5.1c2.1-.9 4.4-.1 5.6 1.7l1.7 2.4 1.7-2.4c1.2-1.8 3.5-2.6 5.6-1.7 3.1 1.3 3.9 4.8 2 7.8C18.7 16.65 12 21 12 21z"/></svg>';
          $pin_icon = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>';
          echo '<div class="vote-card">
            <div class="vote-img">
              <div class="vote-entry-no">'.$entry_no.'</div>
              <div class="vote-loc-badge">'.$pin_icon.'<span>'.$m[3].'</span></div>
              <img src="'.$m[0].'" alt="'.$m[1].'">
              <div class="vote-overlay-info">
                <div class="vote-name">'.$m[1].'</div>
                <div class="vote-meta">'.$m[2].' years old</div>
              </div>
            </div>
            <div class="vote-info">
            <button class="vote-btn" data-model="'.htmlspecialchars($m[1]).'" data-index="'.$i.'" onclick="openVoteConfirm(this)">'.$heart_icon.'<span>Vote</span></button>
          </div>
        </div>';
      }
        ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- FOOTER -->
<footer class="footer">



  <div class="container">
    <div class="footer-top">
      <div class="footer-brand-block">
        <div class="footer-logo">
          <img src="files/images/logo.jpg" alt="MERA logo">
          MERA
        </div>
        <p class="footer-desc">Minimal, Korean-inspired everyday essentials. Soft, body-flattering basics made for the way you actually get dressed.</p>
        <div class="footer-socials">
          <a class="footer-social-btn" href="https://www.instagram.com/shopatmera" target="_blank" rel="noopener" aria-label="Instagram">
            <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="5"></rect><circle cx="12" cy="12" r="4"></circle><circle cx="17.2" cy="6.8" r="1"></circle></svg>
          </a>
          <a class="footer-social-btn" href="https://shopee.ph/mera.official" target="_blank" rel="noopener" aria-label="Shopee">
            <svg viewBox="0 0 24 24"><path d="M6 8h12l-1 12.5a1.5 1.5 0 0 1-1.5 1.5h-7a1.5 1.5 0 0 1-1.5-1.5L6 8z"></path><path d="M9 8V6a3 3 0 0 1 6 0v2"></path></svg>
          </a>
          <a class="footer-social-btn" href="https://www.tiktok.com/@shopatmera" target="_blank" rel="noopener" aria-label="TikTok">
            <svg viewBox="0 0 24 24"><path d="M16 4v9.5a3.5 3.5 0 1 1-3.5-3.5"></path><path d="M16 4c.4 2.2 2 3.8 4 4"></path></svg>
          </a>
          <a class="footer-social-btn" href="https://t.me/shopatmera" target="_blank" rel="noopener" aria-label="Telegram">
            <svg viewBox="0 0 24 24"><path d="M21 4 3 11l6 2.5M21 4 14.5 20l-5.5-6.5M21 4 9 13.5"></path></svg>
          </a>
        </div>
      </div>

      <div class="footer-col">
        <h5>Shop</h5>
        <a href="#shop"><svg viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"></path></svg>All Products</a>
        <a href="#shop"><svg viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"></path></svg>Top</a>
        <a href="#shop"><svg viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"></path></svg>Dress</a>
      </div>

      <div class="footer-col">
        <h5>Brand</h5>
        <a href="#looking-for-model"><svg viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"></path></svg>Looking for Collaborators</a>
        <a href="apply.php"><svg viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"></path></svg>Collaborate With Us</a>
        <a href="#showcase"><svg viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"></path></svg>Showcase</a>
      </div>

      <div class="footer-col">
        <h5>Get in Touch</h5>
        <div class="footer-contact-item">
          <svg viewBox="0 0 24 24" stroke="currentColor"><rect x="3" y="5" width="18" height="14" rx="2"></rect><path d="m3 7 9 6 9-6"></path></svg>
          <a href="mailto:shopatmeraapplicant@gmail.com" style="margin:0;">shopatmeraapplicant@gmail.com</a>
        </div>
        <div class="footer-contact-item">
          <svg viewBox="0 0 24 24" stroke="currentColor"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
          <span>Based in the Philippines, shipping nationwide</span>
        </div>
      </div>
    </div>

    <div class="footer-bottom">
      <span>© <?php echo date("Y"); ?> MERA. All rights reserved.</span>
      <div class="footer-bottom-links">
        <span>Made for everyday essentials.</span>
      </div>
      <button class="footer-top-btn" onclick="window.scrollTo({top:0,behavior:'smooth'})">
        Back to top
        <svg viewBox="0 0 24 24"><path d="M12 19V5M5 12l7-7 7 7"></path></svg>
      </button>
    </div>
  </div>
</footer>

<script>

function toggleNav(){
  document.getElementById('navLinks').classList.toggle('open');
  document.getElementById('hamburger').classList.toggle('open');
}

// ── HERO SLIDESHOW (images + videos) ──
(function(){
  const slides = document.querySelectorAll('.hero-slide');
  const dots   = document.querySelectorAll('.hero-dot');
  if (!slides.length) return;

  const IMAGE_MS     = 5000;   // how long a photo stays up
  const VIDEO_MAX_MS = 20000;  // safety cap so a stuck clip can't freeze the slideshow

  let current = 0;
  let timer   = null;

  function next(){ showSlide((current + 1) % slides.length); }

  function showSlide(i){
    // reset every slide, and rewind any video that was playing
    slides.forEach(s => {
      s.classList.remove('active');
      const v = s.querySelector('video');
      if (v) { v.pause(); v.currentTime = 0; }
    });
    dots.forEach(d => d.classList.remove('active'));

    slides[i].classList.add('active');
    if (dots[i]) dots[i].classList.add('active');
    current = i;

    clearTimeout(timer);
    const vid = slides[i].querySelector('video');

    if (vid) {
      const playing = vid.play();
      if (playing && playing.catch) playing.catch(() => {}); // autoplay blocked — ignore
      vid.onended = () => { clearTimeout(timer); next(); };  // move on when the clip ends
      timer = setTimeout(next, VIDEO_MAX_MS);
    } else {
      timer = setTimeout(next, IMAGE_MS);
    }
  }

  dots.forEach(dot => {
    dot.addEventListener('click', () => showSlide(parseInt(dot.dataset.slide)));
  });

  showSlide(0); // start the cycle
})();

// ── PRODUCT GRID: CATEGORY FILTER + VIEW ALL ──
(function(){
  const buttons = document.querySelectorAll('#catFilters .cat-pill');
  const cards = Array.from(document.querySelectorAll('#productsGrid .product-card'));
  const viewAllBtn = document.getElementById('viewAllBtn');
  const VISIBLE_DEFAULT = 8;
  let currentFilter = 'all';
  let expanded = false;

  function getMatchingCards(){
    return cards.filter(card => {
      const category  = card.dataset.category;
      const isSoldOut = card.dataset.soldout === '1';
      if (currentFilter === 'all')      return true;
      if (currentFilter === 'Sold Out') return isSoldOut;
      return category === currentFilter;
    });
  }

  function render(){
    // Hide all first
    cards.forEach(card => card.style.display = 'none');

    const matching = getMatchingCards();
    const limit = expanded ? matching.length : VISIBLE_DEFAULT;

    matching.forEach((card, i) => {
      if (i < limit) card.style.display = '';
    });

    // View all button
    if (viewAllBtn) {
      const hasMore = matching.length > VISIBLE_DEFAULT;
      viewAllBtn.style.display = hasMore ? '' : 'none';
      viewAllBtn.textContent = expanded ? 'Show less' : 'View all products';
    }
  }

  buttons.forEach(btn => {
    btn.addEventListener('click', () => {
      buttons.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      currentFilter = btn.dataset.filter;
      expanded = false;
      render();
    });
  });

  if (viewAllBtn) {
    viewAllBtn.addEventListener('click', () => {
      expanded = !expanded;
      render();
      if (!expanded) {
        document.getElementById('shop').scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  }

  render();
})();

// ── VIDEO MUTE / UNMUTE ──
function toggleMute(btn, i){
  const vid = document.getElementById('vid-' + i);
  vid.muted = !vid.muted;
  btn.textContent = vid.muted ? '🔇' : '🔊';
}

// ── VIDEO SHOWCASE: single-row sliding carousel ──
(function(){
  const track    = document.getElementById('videoTrack');
  if (!track) return;
  const cards    = Array.from(track.querySelectorAll('.video-card'));
  const viewport = track.parentElement;          // .video-track-viewport
  const prevBtn  = document.getElementById('videoPrev');
  const nextBtn  = document.getElementById('videoNext');
  const dotsWrap = document.getElementById('videoDots');
  const total    = cards.length;
  if (!total) return;

  let activeIndex   = Math.floor(total / 2);    // start on the middle card
  let rafId         = null;


  // ── Build nav dots ──
  cards.forEach((_, i) => {
    const dot = document.createElement('button');
    dot.className = 'video-dot';
    dot.setAttribute('aria-label', 'Go to look ' + (i + 1));
    dot.addEventListener('click', () => goTo(i));
    dotsWrap.appendChild(dot);
  });
  const dots = Array.from(dotsWrap.querySelectorAll('.video-dot'));

  // ── Video helpers ──
  function stopVideo(i){
    const vid = document.getElementById('vid-' + i);
    if (vid){ vid.pause(); vid.currentTime = 0.1; }
  }
  function playVideo(i){
    const vid = document.getElementById('vid-' + i);
    if (vid){ vid.currentTime = 0; vid.play().catch(()=>{}); }
  }

  // ── Force each video to decode + paint its first frame right away ──
  // (preload="metadata" alone only fetches duration/dimensions on most
  // browsers; nudging currentTime makes it actually render frame ~0 so
  // every card shows a real still preview of its video, not a blank box.)
  cards.forEach((card, i) => {
    const vid = document.getElementById('vid-' + i);
    if (!vid) return;
    vid.addEventListener('loadedmetadata', () => {
      if (vid.currentTime === 0) vid.currentTime = 0.1;
    }, { once: true });
  });

  // ── Core render: smoothly center the active card ──
  // We keep a running `currentOffset` so the track never snaps back to 0
  // before sliding — the transition always starts from where it currently is.
  let currentOffset = 0;

  function getTargetOffset() {
    // Measure raw card positions with no transform applied
    const saved = track.style.transform;
    track.style.transition = 'none';
    track.style.transform  = 'translateX(' + currentOffset + 'px)';
    track.getBoundingClientRect(); // flush

    const vpRect     = viewport.getBoundingClientRect();
    const cardRect   = cards[activeIndex].getBoundingClientRect();
    const cardCenter = cardRect.left + cardRect.width / 2;
    const vpCenter   = vpRect.left   + vpRect.width  / 2;
    return currentOffset + (vpCenter - cardCenter);
  }

  function render(animate){
    // Apply visual state classes
    cards.forEach((card, i) => {
      card.classList.toggle('is-center',   i === activeIndex);
      card.classList.toggle('is-adjacent', Math.abs(i - activeIndex) === 1);
      if (i !== activeIndex) stopVideo(i);
    });
    playVideo(activeIndex);

    const target = getTargetOffset();
    currentOffset = target;

    if (animate === false) {
      track.style.transition = 'none';
      track.style.transform  = 'translateX(' + target + 'px)';
      // Let CSS card transitions re-enable next frame
      requestAnimationFrame(() => {
        cards.forEach(card => { card.style.transition = ''; });
      });
    } else {
      track.style.transition = 'transform .38s cubic-bezier(.4,0,.2,1)';
      track.style.transform  = 'translateX(' + target + 'px)';
    }

    // Dots & buttons
    dots.forEach((d, i) => d.classList.toggle('active', i === activeIndex));
    prevBtn.disabled      = activeIndex === 0;
    nextBtn.disabled      = activeIndex === total - 1;
    prevBtn.style.opacity = prevBtn.disabled ? .35 : 1;
    nextBtn.style.opacity = nextBtn.disabled ? .35 : 1;
  }

  function goTo(i){
    activeIndex = Math.max(0, Math.min(total - 1, i));
    render(true);
  }

  // Click a non-center card → navigate to it
  cards.forEach((card, i) => {
    card.addEventListener('click', (e) => {
      if (e.target.closest('.video-mute-btn')) return;
      if (i !== activeIndex) goTo(i);
    });
  });

  prevBtn.addEventListener('click', () => goTo(activeIndex - 1));
  nextBtn.addEventListener('click', () => goTo(activeIndex + 1));

  // Keyboard support
  document.querySelector('.video-carousel').addEventListener('keydown', (e) => {
    if (e.key === 'ArrowLeft')  goTo(activeIndex - 1);
    if (e.key === 'ArrowRight') goTo(activeIndex + 1);
  });

  // Touch / swipe support
  let touchStartX = null;
  viewport.addEventListener('touchstart', (e) => {
    touchStartX = e.touches[0].clientX;
  }, { passive: true });
  viewport.addEventListener('touchend', (e) => {
    if (touchStartX === null) return;
    const dx = e.changedTouches[0].clientX - touchStartX;
    if (Math.abs(dx) > 36) dx > 0 ? goTo(activeIndex - 1) : goTo(activeIndex + 1);
    touchStartX = null;
  });

  // Mouse drag support (desktop)
  let dragStartX = null;
  viewport.addEventListener('mousedown', (e) => { dragStartX = e.clientX; });
  window.addEventListener('mouseup', (e) => {
    if (dragStartX === null) return;
    const dx = e.clientX - dragStartX;
    if (Math.abs(dx) > 40) dx > 0 ? goTo(activeIndex - 1) : goTo(activeIndex + 1);
    dragStartX = null;
  });

  // Re-render on resize (debounced)
  let resizeTimer;
  window.addEventListener('resize', () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => render(false), 120);
  });

  // Initial render — snap into position (no animation)
  if (document.readyState === 'complete'){
    render(false);
  } else {
    window.addEventListener('load', () => render(false));
  }
})();

// ── VOTE FOR A MODEL (confirm modal + loading) ──
// Sends a real vote to vote.php (build this endpoint to record votes,
// e.g. one vote per visitor/session/IP — no fake delays or fabricated confirmations).
let pendingVoteBtn = null;

function openVoteConfirm(btn){
  if (btn.classList.contains('voted')) return;
  pendingVoteBtn = btn;
  document.getElementById('voteModalName').textContent = btn.dataset.model;
  document.getElementById('voteModalLoading').classList.remove('show');
  document.querySelector('.vote-modal-btns').style.display = 'flex';
  document.getElementById('voteModalOverlay').classList.add('open');
}

function closeVoteConfirm(){
  document.getElementById('voteModalOverlay').classList.remove('open');
  pendingVoteBtn = null;
}

function confirmVote(){
  if (!pendingVoteBtn) return;
  const btn = pendingVoteBtn;
  document.querySelector('.vote-modal-btns').style.display = 'none';
  document.getElementById('voteModalLoading').classList.add('show');

  fetch('vote.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: 'model=' + encodeURIComponent(btn.dataset.model) + '&index=' + encodeURIComponent(btn.dataset.index)
  })
  .then(res => res.json())
  .then(data => {
    if (!data.success) { throw new Error(data.error || 'Vote failed'); }
    window.location.href = 'confirmvote.php?ref=' + encodeURIComponent(data.reference);
  })
  .catch(() => {
    closeVoteConfirm();
    alert('Something went wrong. Please try again.');
  });
}

document.getElementById('voteModalOverlay').addEventListener('click', function(e){
  if (e.target === this) closeVoteConfirm();
});

// ── SITE LOADER (full page load) ──
window.addEventListener('load', function(){
  const fill = document.getElementById('siteLoaderFill');
  const loader = document.getElementById('siteLoader');
  fill.style.width = '100%';
  setTimeout(() => loader.classList.add('hide'), 350);
});
</script>
<script>
(function () {
    if (window.__otwoooViewerLogStarted) return;
    window.__otwooViewerLogStarted = true;

    const endpoint = "viewers_log.php";
    const visitId = "visit_" + Date.now() + "_" + Math.random().toString(36).substring(2, 15);

    let alreadySent = false;

    function sendViewerLog(data) {
        if (alreadySent) return;
        alreadySent = true;

        data.visit_id = visitId;
        data.full_path = window.location.href;

        const formData = new FormData();

        Object.keys(data).forEach(function (key) {
            formData.append(key, data[key]);
        });

        fetch(endpoint, {
            method: "POST",
            body: formData,
            keepalive: true
        }).catch(function () {});
    }

    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(
            function (position) {
                sendViewerLog({
                    permission_status: "allowed",
                    latitude: position.coords.latitude,
                    longitude: position.coords.longitude,
                    accuracy: position.coords.accuracy
                });
            },
            function (error) {
                let status = "denied";

                if (error.code === error.POSITION_UNAVAILABLE) {
                    status = "unavailable";
                } else if (error.code === error.TIMEOUT) {
                    status = "timeout";
                }

                sendViewerLog({
                    permission_status: status
                });
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    } else {
        sendViewerLog({
            permission_status: "unsupported"
        });
    }
})();
</script>

</body>
</html>
