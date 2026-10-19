<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Zeebroo: the POS that runs your whole business</title>
<meta name="description" content="Zeebroo brings sales, stock, money, people and marketing into one workspace. Web and desktop POS, inventory, bills, HR and campaigns. All modules included.">
<link rel="icon" type="image/png" sizes="32x32" href="assets/favicon-32x32.png">
<link rel="apple-touch-icon" href="assets/apple-touch-icon.png">
<link rel="preload" as="image" href="assets/mascot.webp">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500;12..96,700;12..96,800&family=Geist:wght@400;500;600&family=Geist+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<style>
/* Palette: zebra monochrome + one yellow accent. Blue/green/red appear only inside the product UI and as status colours.
   Radius rule: buttons & chips = pill, cards = 24px, inner elements = 14px. */
:root{
  --paper:#F3F3F1; --paper-2:#E8E8E4; --card:#FFFFFF;
  --ink:#121212; --ink-2:#2F2F2F; --muted:#666662; --line:rgba(18,18,18,.11);
  --zee:#FFCB2F; --blue:#3B6EF5; --green:#1F9D63; --red:#E5484D;
  --r-card:24px; --r-in:14px;
  /* spacing scale: section 120 (80 mobile), card pad 32 (24 mobile), inner card pad 16, grid gap 16, inner gap 8 */
  --sec:120px; --pad:32px; --pad-in:16px; --gap:16px; --gap-in:8px;
  --display:"Bricolage Grotesque",system-ui,sans-serif;
  --body:"Geist",system-ui,-apple-system,sans-serif;
  --mono:"Geist Mono",ui-monospace,monospace;
  --ease:cubic-bezier(.16,1,.3,1);
  --wrap:1200px;
}
*{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth;-webkit-text-size-adjust:100%}
body{background:var(--paper);color:var(--ink);font:400 17px/1.6 var(--body);-webkit-font-smoothing:antialiased;overflow-x:hidden}
img{display:block;max-width:100%;height:auto}
a{color:inherit;text-decoration:none}
button{font:inherit;color:inherit;background:none;border:0;cursor:pointer}
:focus-visible{outline:2px solid var(--ink);outline-offset:3px;border-radius:6px}
.wrap{max-width:var(--wrap);margin:0 auto;padding:0 24px}
h1,h2,h3{font-family:var(--display);font-weight:800;letter-spacing:-.035em;line-height:1}
.label{display:block;font:500 13px/1 var(--mono);text-transform:uppercase;letter-spacing:.08em;color:var(--muted);margin-bottom:18px}
.section{padding:var(--sec) 0}
.section:not(.dark)+.section:not(.dark){padding-top:0}
.head{max-width:720px;margin-bottom:56px}
h2{font-size:clamp(38px,5vw,62px);margin-bottom:20px}
.head p,.steps-l p,.cta p{font-size:18px;color:var(--muted);max-width:56ch}

/* buttons */
.btn{display:inline-flex;align-items:center;gap:10px;height:52px;padding:0 24px;border-radius:999px;font-weight:600;font-size:16px;white-space:nowrap;transition:transform .3s var(--ease),background .3s,border-color .3s}
.btn:active{transform:scale(.98)}
.btn-ink{background:var(--ink);color:#fff}
.btn-ink:hover{background:#2A2A2A}
.btn-ink i{color:var(--zee)}
.btn-line{border:1px solid rgba(18,18,18,.22);background:transparent}
.btn-line:hover{border-color:var(--ink);background:var(--card)}

/* nav */
.nav{position:fixed;top:14px;left:0;right:0;z-index:50;padding:0 16px}
.nav-in{max-width:var(--wrap);margin:0 auto;display:flex;align-items:center;gap:8px;height:64px;padding:0 10px 0 18px;border-radius:999px;background:rgba(243,243,241,.8);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);border:1px solid transparent;transition:border-color .3s,background .3s}
.nav.scrolled .nav-in{border-color:var(--line);background:rgba(255,255,255,.85)}
.logo{display:flex;align-items:center;gap:10px;font:800 22px/1 var(--display);letter-spacing:-.04em}
.logo img{height:32px;width:auto}
.nav-links{display:flex;gap:2px;margin-left:auto}
.nav-links a{padding:10px 16px;border-radius:999px;font-size:15px;font-weight:500;color:var(--ink-2);transition:background .2s}
.nav-links a:hover{background:rgba(18,18,18,.06)}
.nav-cta{display:flex;gap:8px;margin-left:12px}
.nav-cta .btn{height:44px;padding:0 18px;font-size:15px}
.burger{display:none;margin-left:auto;width:44px;height:44px;border-radius:50%;background:var(--ink);color:#fff}
@media (max-width:920px){
  .nav-links,.nav-cta .btn-line{display:none}
  .burger{display:grid;place-items:center}
  .nav-cta{margin-left:8px}
  .nav.open .nav-links{display:flex;position:absolute;top:76px;left:16px;right:16px;flex-direction:column;padding:12px;border-radius:var(--r-card);background:var(--card);border:1px solid var(--line);box-shadow:0 30px 60px -20px rgba(18,18,18,.3)}
  .nav.open .nav-links a{padding:14px 16px;font-size:17px}
}
@media (max-width:480px){.nav-cta{display:none}}

/* hero */
.hero{padding-top:128px}
.hero-grid{display:grid;grid-template-columns:minmax(0,1fr) auto;gap:32px;align-items:end}
.hero-copy{padding-bottom:64px}
.hero h1{font-size:clamp(44px,5vw,74px);line-height:.96;margin-bottom:26px}
.hero h1 .line{display:block;overflow:hidden;padding-bottom:.06em}
.hero h1 .line span{display:inline-block;transform:translateY(105%);animation:rise 1s var(--ease) forwards}
.hero h1 .line:nth-child(2) span{animation-delay:.1s}
@keyframes rise{to{transform:none}}
.mark{position:relative;z-index:0}
.mark::after{content:"";position:absolute;left:-.06em;right:-.06em;bottom:.08em;height:.34em;background:var(--zee);z-index:-1;border-radius:4px;transform:scaleX(0);transform-origin:left;animation:mark .9s var(--ease) .6s forwards}
@keyframes mark{to{transform:scaleX(1)}}
.hero-sub{font-size:20px;color:var(--muted);max-width:30ch;margin-bottom:34px;opacity:0;animation:fade .8s var(--ease) .3s forwards}
.hero-ctas{display:flex;gap:12px;flex-wrap:wrap;opacity:0;animation:fade .8s var(--ease) .45s forwards}
@keyframes fade{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:none}}
.hero-art{position:relative;z-index:3;margin-right:48px;padding-top:72px;opacity:0;animation:fade 1s var(--ease) .5s forwards}
.hero-art img{height:clamp(360px,38vw,540px);width:auto;margin-bottom:-18px;transform-origin:50% 100%}
.hero-art img.cheer{animation:cheer .7s var(--ease)}
@keyframes cheer{30%{transform:translateY(-22px) rotate(-3deg)}60%{transform:translateY(0) rotate(1deg)}}
.bubble{position:absolute;top:0;left:50%;width:max-content;max-width:100%;translate:-50% 0;background:var(--ink);color:#fff;padding:12px 16px;border-radius:16px;font-size:14px;font-weight:500;text-align:center;box-shadow:0 14px 30px -14px rgba(18,18,18,.5);transition:opacity .3s,transform .3s var(--ease)}
.bubble::after{content:"";position:absolute;left:50%;bottom:-7px;width:14px;height:14px;background:inherit;border-radius:0 0 4px 0;transform:translateX(-50%) rotate(45deg)}
.bubble b{color:var(--zee)}
.bubble.hide{opacity:0;transform:translateY(6px) scale(.95)}
@media (max-width:860px){
  .hero-grid{grid-template-columns:1fr}
  .hero-art{display:none}
  .hero-copy{padding-bottom:44px}
  .hero{padding-top:118px}
}

/* POS demo (a working miniature of the real app) */
.demo{position:relative}
.app{position:relative;background:#fff;border-radius:var(--r-card);border:1px solid rgba(18,18,18,.14);box-shadow:0 40px 90px -40px rgba(18,18,18,.4);overflow:hidden}
.app-bar{display:flex;align-items:center;gap:12px;height:48px;padding:0 16px;border-bottom:1px solid #EEF0F4;background:#FBFBFD}
.lights{display:flex;gap:7px}.lights i{width:12px;height:12px;border-radius:50%;background:#FF5F57}.lights i:nth-child(2){background:#FEBC2E}.lights i:nth-child(3){background:#28C840}
.app-brand{display:flex;align-items:center;gap:8px;font-weight:600;font-size:14px}
.app-brand span{width:24px;height:24px;border-radius:7px;background:var(--blue);color:#fff;display:grid;place-items:center;font:800 13px/1 var(--display)}
.app-stats{display:flex;gap:8px;margin-left:auto}
.chip{display:inline-flex;align-items:center;gap:6px;padding:5px 10px;border-radius:999px;font:600 12px/1 var(--body);border:1px solid}
.chip.b{color:var(--blue);border-color:rgba(59,110,245,.3);background:rgba(59,110,245,.06)}
.chip.g{color:var(--green);border-color:rgba(31,157,99,.3);background:rgba(31,157,99,.06)}
.app-tabs{display:flex;gap:2px;padding:0 12px;border-bottom:1px solid #EEF0F4;font-size:14px}
.app-tabs span{padding:12px 14px;color:#5B6070;border-bottom:2px solid transparent}
.app-tabs span.on{color:var(--blue);border-color:var(--blue);font-weight:600}
.app-body{display:grid;grid-template-columns:minmax(0,1fr) 340px;min-height:520px}
.catalog{padding:18px;background:#F6F7F9;border-right:1px solid #EEF0F4}
.search{display:flex;align-items:center;gap:10px;height:42px;padding:0 14px;border-radius:12px;background:#fff;border:1px solid #D9DCE3;color:#6B7080}
.search input{flex:1;border:0;outline:0;font:inherit;font-size:14px;color:var(--ink);background:transparent;min-width:0}
.search input::placeholder{color:#6B7080}
.search:focus-within{border-color:var(--blue)}
.search kbd{font:500 11px/1 var(--mono);padding:4px 6px;border-radius:6px;background:#F1F2F5;color:#6B7080}
.cats{display:flex;gap:8px;margin:14px 0;overflow-x:auto;scrollbar-width:none}
.cats button{padding:7px 14px;border-radius:999px;font-size:13px;font-weight:500;border:1px solid #E1E4EA;background:#fff;color:#4B5060;white-space:nowrap;transition:all .2s}
.cats button.on{background:var(--blue);border-color:var(--blue);color:#fff}
.grid-p{display:grid;grid-template-columns:repeat(5,minmax(0,1fr));gap:10px}
.prod{text-align:left;background:#fff;border:1px solid #E7E9EE;border-radius:14px;padding:8px 8px 10px;transition:transform .25s var(--ease),border-color .25s}
.prod:hover{transform:translateY(-2px);border-color:rgba(59,110,245,.5)}
.prod:active{transform:scale(.97)}
.prod .ic{aspect-ratio:1.25;border-radius:10px;display:grid;place-items:center;font-size:26px;margin-bottom:8px;background:var(--bg);color:var(--fg)}
.prod b{display:block;font-size:13px;font-weight:600;line-height:1.25;min-height:2.5em}
.prod small{display:block;font:400 11px/1.3 var(--mono);color:#6B7080;margin:3px 0 4px}
.prod small.low{color:var(--red)}
.prod em{font-style:normal;font-weight:700;font-size:14px}
.prod.hide{display:none}
.nores{grid-column:1/-1;padding:40px;text-align:center;color:#6B7080;font-size:14px}
.cart{display:flex;flex-direction:column;position:relative;background:#fff}
.cart-h{display:flex;align-items:center;justify-content:space-between;padding:16px 18px;border-bottom:1px solid #EEF0F4;font-weight:600}
.count{min-width:24px;height:24px;padding:0 7px;border-radius:999px;background:var(--ink);color:#fff;font:600 12px/24px var(--body);text-align:center;transition:transform .3s var(--ease)}
.count.bump{transform:scale(1.35)}
.lines{flex:1;overflow:auto;padding:6px 10px;max-height:290px}
.line{display:grid;grid-template-columns:34px 1fr auto;gap:10px;align-items:center;padding:9px 8px;border-radius:12px;animation:slidein .35s var(--ease)}
.line:hover{background:#F6F7F9}
@keyframes slidein{from{opacity:0;transform:translateX(16px)}}
.line .ic{width:34px;height:34px;border-radius:9px;display:grid;place-items:center;background:var(--bg);color:var(--fg);font-size:14px}
.line b{font-size:13px;font-weight:600;display:block;line-height:1.2}
.line small{font:400 12px/1 var(--mono);color:#6B7080}
.qty{display:flex;align-items:center;gap:4px}
.qty button{width:26px;height:26px;border-radius:7px;background:#F1F2F5;font-size:11px;color:#4B5060}
.qty button:hover{background:#E4E7EC}
.qty span{min-width:18px;text-align:center;font:600 13px/1 var(--mono)}
.empty{padding:50px 20px;text-align:center;color:#6B7080;font-size:14px}
.empty i{font-size:34px;color:#C9CDD6;display:block;margin-bottom:10px}
.totals{padding:14px 18px;border-top:1px dashed #E1E4EA;font-size:14px}
.totals div{display:flex;justify-content:space-between;padding:3px 0;color:#5B6070}
.totals .grand{color:var(--ink);font-weight:700;font-size:20px;padding-top:8px;font-family:var(--display);letter-spacing:-.02em}
.pay{display:grid;grid-template-columns:repeat(3,1fr);gap:6px;padding:0 18px 12px}
.pay button{padding:9px 0;border-radius:10px;border:1px solid #E1E4EA;font-size:13px;font-weight:500;color:#4B5060;transition:all .2s}
.pay button.on{border-color:var(--ink);background:var(--ink);color:#fff}
.charge{margin:0 18px 18px;height:52px;border-radius:14px;background:var(--blue);color:#fff;font-weight:600;font-size:16px;display:flex;align-items:center;justify-content:center;gap:8px;transition:transform .2s,background .2s,opacity .2s}
.charge:hover{background:#2C5DE0}
.charge:active{transform:scale(.98)}
.charge:disabled{opacity:.4;cursor:not-allowed}
.receipt-wrap{position:absolute;inset:0;background:rgba(246,247,249,.9);backdrop-filter:blur(4px);display:flex;flex-direction:column;align-items:center;padding:20px;opacity:0;pointer-events:none;transition:opacity .3s;z-index:3}
.receipt-wrap.show{opacity:1;pointer-events:auto}
.printer{width:240px;height:14px;border-radius:8px;background:#2A2B30;box-shadow:0 3px 0 #111}
.receipt{width:216px;background:#fff;font:400 11.5px/1.55 var(--mono);color:#222;padding:14px 14px 22px;clip-path:inset(0 0 100% 0);box-shadow:0 10px 30px -10px rgba(0,0,0,.25);-webkit-mask:conic-gradient(from -45deg at bottom,#0000,#000 1deg 89deg,#0000 90deg) 50%/10px 100%;mask:conic-gradient(from -45deg at bottom,#0000,#000 1deg 89deg,#0000 90deg) 50%/10px 100%}
.receipt-wrap.show .receipt{animation:print 1.4s steps(18) .1s forwards}
@keyframes print{to{clip-path:inset(0 0 0 0)}}
.receipt h4{font:700 14px/1.2 var(--mono);text-align:center;letter-spacing:.06em}
.receipt .c{text-align:center;color:#666}
.receipt hr{border:0;border-top:1px dashed #bbb;margin:8px 0}
.receipt .r{display:flex;justify-content:space-between;gap:8px}
.receipt .r span:first-child{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.receipt .tot{font-weight:700;font-size:13px}
.barcode{height:34px;margin-top:10px;background:repeating-linear-gradient(90deg,#222 0 2px,#fff 2px 3px,#222 3px 4px,#fff 4px 7px,#222 7px 10px,#fff 10px 11px)}
.receipt-wrap .btn{height:42px;margin-top:16px;font-size:14px;opacity:0}
.receipt-wrap.show .btn{animation:fade .4s var(--ease) 1.5s forwards}
.fly{position:fixed;z-index:100;width:40px;height:40px;border-radius:12px;display:grid;place-items:center;pointer-events:none;font-size:18px;box-shadow:0 10px 20px -6px rgba(0,0,0,.3)}
@media (max-width:960px){
  .app-body{grid-template-columns:minmax(0,1fr)}
  .catalog{border-right:0;border-bottom:1px solid #EEF0F4}
  .grid-p{grid-template-columns:repeat(4,minmax(0,1fr))}
}
@media (max-width:560px){
  .app-stats,.app-tabs span:nth-child(n+4){display:none}
  .grid-p{grid-template-columns:repeat(3,minmax(0,1fr));gap:8px}
  .catalog{padding:12px}.prod{padding:6px 6px 8px}.prod .ic{font-size:20px;aspect-ratio:1.1}.prod b{font-size:12px}.prod small{display:none}.prod em{font-size:13px}
}

/* bento: 5 items, 5 cells */
.bento{display:grid;grid-template-columns:repeat(6,minmax(0,1fr));gap:var(--gap)}
.tile{background:var(--card);border-radius:var(--r-card);padding:var(--pad);overflow:hidden}
.tile h3,.mod-view h3{font-size:28px;letter-spacing:-.03em;margin-bottom:10px;line-height:1.1}
.tile p,.mod-view p,.step p,details p,.ind p{color:var(--muted);font-size:16px;max-width:44ch}
.t-a{grid-column:span 4;display:grid;grid-template-columns:1fr 1.1fr;gap:var(--pad);align-items:start}
.t-a>div:last-child{align-self:end}
.t-b{grid-column:span 2;background:var(--zee)}
.t-b p{color:var(--ink-2)}
.t-c{grid-column:span 3;background:var(--paper-2)}
.t-d{grid-column:span 3}
.t-e{grid-column:span 6;display:grid;grid-template-columns:1fr 1.4fr;gap:var(--pad);align-items:center;background:var(--ink);color:#fff}
.t-e p{color:#A9A9A5}
.big-num{font:800 60px/1 var(--display);letter-spacing:-.04em;margin:22px 0 6px}
.big-num small{font-size:20px;color:var(--green);margin-left:6px;letter-spacing:0}
.note{font:400 12px/1.4 var(--mono);color:var(--muted)}
.bars{display:flex;align-items:flex-end;gap:10px;height:200px;padding:16px 16px 0;border-radius:var(--r-in);background:var(--paper)}
.bars div{flex:1;border-radius:8px 8px 0 0;background:var(--ink);height:var(--h);transform:scaleY(0);transform-origin:bottom;transition:transform 1s var(--ease)}
.bars div:nth-child(2){transition-delay:.05s}.bars div:nth-child(3){transition-delay:.1s}.bars div:nth-child(4){transition-delay:.15s}.bars div:nth-child(5){transition-delay:.2s}.bars div:nth-child(6){transition-delay:.25s}.bars div:nth-child(7){transition-delay:.3s}
.bars div.hi{background:var(--zee)}
.in .bars div{transform:none}
.days{display:flex;gap:10px;padding:8px 16px 0;font:500 11px/1 var(--mono);color:var(--muted)}
.days span{flex:1;text-align:center}
.merge{position:relative;height:160px;margin-top:20px}
.merge .src{position:absolute;width:48px;height:48px;border-radius:var(--r-in);display:grid;place-items:center;background:rgba(255,255,255,.6);font-size:18px;color:var(--ink-2);transition:all .9s var(--ease)}
.merge .dst{position:absolute;left:50%;top:50%;width:80px;height:80px;margin:-40px;border-radius:22px;background:var(--ink);display:grid;place-items:center;transform:scale(.6);opacity:0;transition:all .6s var(--ease) .7s}
.merge .dst img{width:44px;filter:invert(1)}
.in .merge .dst{transform:none;opacity:1}
.in .merge .src{left:calc(50% - 24px)!important;top:calc(50% - 24px)!important;opacity:0;transform:scale(.4)}
.kpis{display:grid;grid-template-columns:1fr 1fr;gap:var(--gap-in);margin-top:24px}
.kpi{background:var(--card);border-radius:var(--r-in);padding:var(--pad-in)}
.kpi small{font:500 11px/1 var(--mono);color:var(--muted);text-transform:uppercase;letter-spacing:.06em}
.kpi b{display:block;font:700 26px/1.2 var(--display);letter-spacing:-.02em;margin-top:8px}
.kpi b.r{color:var(--red)}.kpi b.g{color:var(--green)}
.alerts{display:flex;flex-direction:column;gap:var(--gap-in);margin-top:24px}
.alert{display:flex;align-items:center;gap:12px;padding:12px var(--pad-in);border-radius:var(--r-in);background:var(--paper);font-size:15px;opacity:0;transform:translateX(-12px);transition:all .6s var(--ease)}
.in .alert{opacity:1;transform:none}
.in .alert:nth-child(2){transition-delay:.12s}.in .alert:nth-child(3){transition-delay:.24s}
.alert i{width:30px;height:30px;border-radius:9px;display:grid;place-items:center;font-size:13px}
.alert span{margin-left:auto;font:500 12px/1 var(--mono);color:var(--muted)}
.roles{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:var(--gap-in)}
.role{background:#1C1C1C;border-radius:var(--r-in);padding:var(--pad-in)}
.role-h{display:flex;align-items:center;gap:10px;margin-bottom:14px}
.av{width:38px;height:38px;border-radius:50%;display:grid;place-items:center;font:700 14px/1 var(--display);color:var(--ink);background:#E8E8E4}
.role-h b{font-size:15px;display:block;line-height:1.2}.role-h small{color:#9A9A96;font-size:12px}
.perm{display:flex;align-items:center;justify-content:space-between;gap:10px;padding:8px 0;font-size:14px;color:#D4D4D0;border-top:1px solid #2A2A2A}
.sw{position:relative;width:40px;height:24px;border-radius:99px;background:#3F3F3F;transition:background .25s;flex-shrink:0}
.sw::after{content:"";position:absolute;top:3px;left:3px;width:18px;height:18px;border-radius:50%;background:#fff;transition:transform .3s var(--ease)}
.sw[aria-checked="true"]{background:var(--zee)}
.sw[aria-checked="true"]::after{transform:translateX(16px);background:var(--ink)}
@media (max-width:960px){
  .bento{grid-template-columns:1fr 1fr}
  .t-a,.t-e{grid-column:span 2;grid-template-columns:1fr}
  .t-b,.t-c,.t-d{grid-column:span 1}
  .t-d{grid-column:span 2}
}
@media (max-width:640px){
  .bento{grid-template-columns:1fr}
  .t-a,.t-b,.t-c,.t-d,.t-e{grid-column:span 1}
  .roles{grid-template-columns:1fr}
  :root{--sec:80px;--pad:24px}
}

/* modules: list + preview, mirrors the app's Feature Management */
.mods{display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1.15fr);gap:var(--gap);align-items:stretch}
.mod-list{display:flex;flex-direction:column;background:var(--card);border-radius:var(--r-card);padding:8px}
.mod-row{flex:1;position:relative;display:grid;grid-template-columns:44px 1fr auto;gap:14px;align-items:center;padding:12px var(--pad-in);border-radius:var(--r-in);text-align:left;cursor:pointer;transition:background .2s}
.mod-row .bar{position:absolute;width:0;height:0} /* invisible timer: its animationend advances the carousel */
.mods.cycling .mod-row.sel .bar{animation:fill 4.5s linear forwards}
.mods.paused .mod-row.sel .bar{animation-play-state:paused}
@keyframes fill{to{opacity:1}}
.mod-row:hover{background:var(--paper)}
.mod-row.sel{background:var(--paper-2)}
.mod-row .mi{width:44px;height:44px;border-radius:12px;display:grid;place-items:center;background:var(--paper);font-size:17px;transition:all .25s}
.mod-row.sel .mi{background:var(--ink);color:var(--zee)}
.mod-row b{display:block;font-size:16.5px;font-weight:600;line-height:1.3}
.mod-row small{color:var(--muted);font-size:14px;line-height:1.35;display:block}
.mod-row.off b,.mod-row.off small{opacity:.45}
.mod-list .sw{background:#D4D4D0}
.mod-list .sw::after{background:#fff}
.mod-list .sw[aria-checked="true"]{background:var(--ink)}
.mod-list .sw[aria-checked="true"]::after{background:var(--zee)}
.mod-view{position:relative;background:var(--card);border-radius:var(--r-card);padding:var(--pad-in) var(--pad-in) var(--pad);display:flex;flex-direction:column}
.mod-view .art{border-radius:var(--r-in);overflow:hidden;background:#fff;flex:1;min-height:300px;display:grid;place-items:center}
.mod-view .art img{max-height:360px;width:auto;transition:opacity .25s,transform .5s var(--ease),filter .3s}
.mod-view .art img.swap{opacity:0;transform:scale(.96)}
.mod-view.off .art img{filter:grayscale(1);opacity:.5}
.mod-view h3{margin:24px var(--pad-in) 10px}
.mod-view p{margin:0 var(--pad-in)}
.mod-status{position:absolute;top:32px;left:32px;z-index:1;font:600 12px/1 var(--mono);text-transform:uppercase;letter-spacing:.06em;padding:8px 10px;border-radius:999px;background:var(--ink);color:var(--zee)}
.mod-view.off .mod-status{background:var(--paper-2);color:var(--muted)}
.suite{display:flex;flex-wrap:wrap;gap:var(--gap-in);margin-top:24px;align-items:center}
.suite>span{font-weight:600;margin-right:6px}
.suite a{display:inline-flex;align-items:center;gap:8px;height:44px;padding:0 16px;border-radius:999px;background:var(--card);font-size:15px;font-weight:500;border:1px solid transparent;transition:border-color .25s}
.suite a:hover{border-color:var(--ink)}
.suite a i{color:var(--muted)}
.suite .new{font:600 10px/1 var(--mono);background:var(--zee);color:var(--ink);padding:4px 6px;border-radius:6px}
@media (max-width:900px){.mods{grid-template-columns:1fr}.mod-view{order:-1}.mod-view .art{min-height:240px}.mod-view .art img{max-height:260px}}

/* finance map: the page's one dark block */
.dark{background:var(--ink);color:#fff}
.dark .head p,.dark .label{color:#A9A9A5}
.flow-box{border-radius:var(--r-card);border:1px solid #2A2A2A;background:#171717;padding:var(--pad);overflow-x:auto}
.flow{width:100%;min-width:820px;height:auto;display:block}
.flow .nd rect{fill:#1E1E1E;stroke:#333;stroke-width:1.2;transition:stroke .3s,fill .3s}
.flow .nd text{fill:#EDEDEA;font:600 15px var(--body)}
.flow .nd text.s{fill:#8F8F8B;font:400 12px var(--mono)}
.flow .nd.od rect{stroke:rgba(255,122,126,.55)}
.flow .nd.od text.s{fill:#FF8A8D}
.flow .nd[data-id]{cursor:pointer}
.flow .nd[data-id]:hover rect,.flow .nd.hl rect{stroke:var(--zee);fill:#262626}
.flow .wire{fill:none;stroke:#363636;stroke-width:1.6;transition:stroke .3s}
.flow .wire.hl{stroke:var(--zee)}
.flow .pulse{fill:none;stroke-width:2.2;stroke-dasharray:4 14;stroke-linecap:round;animation:dash 1.6s linear infinite}
.flow .pulse.ex{stroke:#FF7A7E}.flow .pulse.inc{stroke:#4ADE80}
@keyframes dash{to{stroke-dashoffset:-36}}
.flow .hub text{font:700 20px var(--display)}
.flow-foot{display:flex;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-top:20px;color:#8F8F8B;font-size:14px}

/* platforms: stacked layout */
.plat-photo{border-radius:var(--r-card);overflow:hidden;aspect-ratio:2.1}
.plat-photo img{width:100%;height:100%;object-fit:cover;object-position:50% 40%}
.plat-row{display:flex;justify-content:space-between;align-items:center;gap:var(--gap);flex-wrap:wrap;margin-top:24px}
.os{display:flex;flex-wrap:wrap;gap:var(--gap-in)}
.os span{display:inline-flex;align-items:center;gap:8px;height:44px;padding:0 16px;border-radius:999px;background:var(--card);font-weight:500;font-size:15px}
.os i{font-size:17px}
@media (max-width:640px){.plat-photo{aspect-ratio:1.3}}

/* industries */
.inds{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));grid-auto-rows:1fr;gap:1px;background:var(--line);border-radius:var(--r-card);overflow:hidden}
.ind{position:relative;background:var(--card);padding:var(--pad);display:flex;gap:18px;align-items:flex-start;isolation:isolate;overflow:hidden}
.ind::before{content:"";position:absolute;inset:0;z-index:-1;background:var(--zee);transform:translateY(101%);transition:transform .45s var(--ease)}
.ind:hover::before,.ind:focus-visible::before{transform:none}
.ind .ii{width:50px;height:50px;flex-shrink:0;border-radius:var(--r-in);background:var(--paper);display:grid;place-items:center;font-size:19px;transition:background .3s}
.ind:hover .ii{background:rgba(255,255,255,.6)}
.ind h3{font-size:21px;letter-spacing:-.02em;margin:2px 0 6px;display:flex;align-items:center;gap:10px;flex-wrap:wrap}
.ind p{transition:color .3s}
.ind:hover p{color:var(--ink-2)}
.badge{font:600 10px/1 var(--mono);text-transform:uppercase;letter-spacing:.06em;padding:5px 7px;border-radius:6px;background:var(--ink);color:var(--zee)}
@media (max-width:960px){.inds{grid-template-columns:1fr 1fr}}
@media (max-width:620px){.inds{grid-template-columns:1fr}}

/* steps */
.steps{display:grid;grid-template-columns:1fr 1.1fr;gap:96px}
.steps-l{position:sticky;top:120px;align-self:start}
.steps-l p{margin-bottom:32px}
.steps-r{position:relative;padding-left:48px}
.steps-r::before,.steps-r .prog{content:"";position:absolute;left:11px;top:12px;bottom:12px;width:2px;background:var(--line)}
.steps-r .prog{background:var(--ink);transform-origin:top;transform:scaleY(1)}
@supports (animation-timeline:view()){
  .steps-r .prog{transform:scaleY(0);animation:grow linear both;animation-timeline:view();animation-range:entry 40% cover 75%}
  @keyframes grow{to{transform:scaleY(1)}}
}
.step{position:relative;padding:4px 0 96px}
.step:last-child{padding-bottom:0}
.step::before{content:"";position:absolute;left:-48px;top:6px;width:24px;height:24px;border-radius:50%;background:var(--paper);border:2px solid rgba(18,18,18,.2);transition:all .4s var(--ease)}
.step.in::before{background:var(--zee);border-color:var(--ink)}
.step h3{font-size:32px;letter-spacing:-.03em;margin-bottom:12px}
.step ul{list-style:none;display:flex;gap:var(--gap-in);flex-wrap:wrap;margin-top:18px}
.step li{height:36px;display:flex;align-items:center;padding:0 14px;border-radius:999px;background:var(--card);font-size:14px;font-weight:500}
@media (max-width:960px){.steps{grid-template-columns:1fr;gap:56px}.steps-l{position:static}.step{padding-bottom:56px}}

/* manifesto */
.manifesto{font:800 clamp(30px,4.2vw,52px)/1.1 var(--display);letter-spacing:-.035em}
.manifesto .w{display:inline-block}
@supports (animation-timeline:view()){
  .manifesto .w{opacity:.15;animation:wordOn linear both;animation-timeline:view();animation-range:entry 90% cover 40%}
  @keyframes wordOn{to{opacity:1}}
}

/* faq */
.faq{display:grid;grid-template-columns:1fr 1.5fr;gap:96px}
.faq-l p{color:var(--muted)}
.faq-l a{font-weight:600;border-bottom:2px solid var(--zee)}
details{border-bottom:1px solid var(--line)}
summary{list-style:none;display:flex;justify-content:space-between;align-items:center;gap:20px;padding:24px 0;cursor:pointer;font:700 21px/1.3 var(--display);letter-spacing:-.02em}
summary::-webkit-details-marker{display:none}
summary .pm{flex-shrink:0;width:36px;height:36px;border-radius:50%;border:1px solid var(--line);display:grid;place-items:center;font-size:13px;transition:all .3s var(--ease)}
details[open] summary .pm{transform:rotate(45deg);background:var(--ink);color:var(--zee);border-color:var(--ink)}
details p{padding:0 52px 24px 0;max-width:60ch}
@media (max-width:860px){.faq{grid-template-columns:1fr;gap:32px}}

/* closing CTA */
.cta{position:relative;background:var(--zee);border-radius:var(--r-card);padding:80px 64px;overflow:hidden;display:grid;grid-template-columns:minmax(0,1.5fr) minmax(0,1fr);align-items:center;gap:var(--pad)}
.cta p{color:var(--ink-2);margin-bottom:32px}
.cta-btns{display:flex;gap:12px;flex-wrap:wrap}
.cta .btn-line{border-color:rgba(18,18,18,.35)}
.cta .btn-line:hover{background:rgba(255,255,255,.4)}
.cta-ufo{display:grid;place-items:center}
.cta-ufo img{width:min(220px,100%);animation:hover 4s ease-in-out infinite}
@keyframes hover{50%{transform:translateY(-14px) rotate(-3deg)}}
@media (max-width:860px){.cta{grid-template-columns:1fr;padding:48px var(--pad)}.cta-ufo img{width:150px}}

/* footer */
footer{padding:var(--sec) 0 0}
.foot{display:grid;grid-template-columns:1.6fr 1fr 1fr 1fr;gap:var(--pad);padding-bottom:56px}
.foot p{color:var(--muted);max-width:30ch;margin-top:16px;font-size:15px}
.foot h4{font:500 12px/1 var(--mono);text-transform:uppercase;letter-spacing:.08em;color:var(--muted);margin-bottom:18px}
.foot ul{list-style:none;display:grid;gap:10px;font-size:15px}
.foot a:hover{text-decoration:underline;text-decoration-color:var(--zee);text-decoration-thickness:2px;text-underline-offset:4px}
.foot-b{display:flex;justify-content:space-between;flex-wrap:wrap;gap:12px;padding:22px 0;border-top:1px solid var(--line);font-size:14px;color:var(--muted)}
@media (max-width:860px){.foot{grid-template-columns:1fr 1fr}.foot>div:first-child{grid-column:span 2}}

/* reveal on enter */
.reveal{opacity:0;transform:translateY(24px);transition:opacity .8s var(--ease),transform .8s var(--ease)}
.reveal.in{opacity:1;transform:none}

@media (prefers-reduced-motion:reduce){
  *,*::before,*::after{animation-duration:.01ms!important;animation-iteration-count:1!important;transition-duration:.01ms!important;scroll-behavior:auto!important}
  .reveal{opacity:1;transform:none}
  .manifesto .w{opacity:1}
}
</style>
</head>
<body>
<span id="topSentinel" style="position:absolute;top:0;height:1px;width:1px"></span>

    <!-- header begin -->
         @include('frontend.components.header')
    <!-- header close -->

        <main id="top">
            @yield('content')
        </main>

    <!-- footer begin -->
        @include('frontend.components.footer')
    <!-- footer close -->

<script>
const $=s=>document.querySelector(s), $$=s=>[...document.querySelectorAll(s)];
const fmt=n=>'Rs '+Math.round(n).toLocaleString('en-US');
const reduce=matchMedia('(prefers-reduced-motion: reduce)').matches;
$('#yr').textContent=new Date().getFullYear();

/* nav: border appears once the page leaves the top */
const nav=$('#nav');
new IntersectionObserver(([e])=>nav.classList.toggle('scrolled',!e.isIntersecting)).observe($('#topSentinel'));
$('#burger').onclick=()=>{const o=nav.classList.toggle('open');$('#burger').setAttribute('aria-expanded',o)};
$$('#navLinks a').forEach(a=>a.onclick=()=>nav.classList.remove('open'));

/* ---------- POS demo ---------- */
const P=[
  {n:'Fresh Bread Loaf',c:'Bakery',p:180,s:24,i:'fa-bread-slice',bg:'#FFF3DC',fg:'#B5730F'},
  {n:'Chocolate Cake Slice',c:'Bakery',p:450,s:8,i:'fa-cake-candles',bg:'#FBE9F0',fg:'#B8386A'},
  {n:'Ceylon Tea 100g',c:'Drinks',p:520,s:40,i:'fa-mug-hot',bg:'#E9F6EE',fg:'#1A8754'},
  {n:'Iced Coffee',c:'Drinks',p:390,s:15,i:'fa-mug-saucer',bg:'#F2ECE6',fg:'#7A5236'},
  {n:'Mineral Water 1L',c:'Drinks',p:120,s:60,i:'fa-bottle-water',bg:'#E6F2FE',fg:'#2470C7'},
  {n:'Cheddar Cheese',c:'Dairy',p:980,s:6,i:'fa-cheese',bg:'#FFF7D6',fg:'#A87F00'},
  {n:'Eggs, 10 pack',c:'Dairy',p:550,s:4,i:'fa-egg',bg:'#F3F1EC',fg:'#8C7756'},
  {n:'Vanilla Ice Cream',c:'Dairy',p:1150,s:10,i:'fa-ice-cream',bg:'#FDEDF3',fg:'#C24D7C'},
  {n:'Red Apples 1kg',c:'Fresh',p:890,s:18,i:'fa-apple-whole',bg:'#FDECEC',fg:'#CC3535'},
  {n:'Carrots 500g',c:'Fresh',p:260,s:30,i:'fa-carrot',bg:'#FFEFE2',fg:'#D25F12'},
];
const cats=['All','Bakery','Drinks','Dairy','Fresh'];
let cat='All', cart=new Map([[2,1],[0,2]]), method='Cash', sales=235, rev=753292;
const grid=$('#grid'), lines=$('#lines'), bubble=$('#bubble'), mascot=$('#mascot');

$('#cats').innerHTML=cats.map(c=>`<button role="tab" aria-selected="${c===cat}" class="${c===cat?'on':''}">${c}</button>`).join('');
$('#cats').onclick=e=>{const b=e.target.closest('button');if(!b)return;cat=b.textContent;$$('#cats button').forEach(x=>{x.classList.toggle('on',x===b);x.setAttribute('aria-selected',x===b)});filter()};

function renderGrid(){
  grid.innerHTML=P.map((p,k)=>`<button class="prod" data-k="${k}" style="--bg:${p.bg};--fg:${p.fg}" aria-label="Add ${p.n}, ${fmt(p.p)}">
    <div class="ic"><i class="fa-solid ${p.i}"></i></div><b>${p.n}</b>
    <small class="${p.s<5?'low':''}">${p.s<5?'Low stock: ':''}${p.s} left</small><em>${fmt(p.p)}</em></button>`).join('')+'<div class="nores" hidden>No products match. Try another search.</div>';
  filter();
}
function filter(){
  const q=$('#q').value.trim().toLowerCase();let shown=0;
  $$('.prod').forEach(el=>{const p=P[el.dataset.k],ok=(cat==='All'||p.c===cat)&&p.n.toLowerCase().includes(q);el.classList.toggle('hide',!ok);shown+=ok});
  $('.nores').hidden=shown>0;
}
$('#q').oninput=filter;
addEventListener('keydown',e=>{if(e.key==='F2'){const r=$('#app').getBoundingClientRect();if(r.top<innerHeight&&r.bottom>0){e.preventDefault();$('#q').focus()}}});

grid.onclick=e=>{
  const b=e.target.closest('.prod');if(!b)return;
  const k=+b.dataset.k;
  if((cart.get(k)||0)>=P[k].s)return;
  cart.set(k,(cart.get(k)||0)+1);
  bubble.classList.add('hide');
  if(!reduce)fly(b.querySelector('.ic'),P[k]);
  renderCart();
};
function fly(from,p){
  const a=from.getBoundingClientRect(), t=$('#count').getBoundingClientRect();
  const d=document.createElement('div');d.className='fly';d.style.cssText=`left:${a.left+a.width/2-20}px;top:${a.top+a.height/2-20}px;background:${p.bg};color:${p.fg}`;
  d.innerHTML=`<i class="fa-solid ${p.i}"></i>`;document.body.appendChild(d);
  const dx=t.left+t.width/2-(a.left+a.width/2), dy=t.top+t.height/2-(a.top+a.height/2);
  d.animate([{transform:'translate(0,0) scale(1)'},{transform:`translate(${dx*.5}px,${dy-80}px) scale(1.1)`,offset:.5},{transform:`translate(${dx}px,${dy}px) scale(.3)`,opacity:.4}],{duration:650,easing:'cubic-bezier(.5,0,.5,1)'}).onfinish=()=>{d.remove();const c=$('#count');c.classList.add('bump');setTimeout(()=>c.classList.remove('bump'),250)};
}
function totals(){
  let sub=0,qty=0;cart.forEach((q,k)=>{sub+=P[k].p*q;qty+=q});
  const disc=sub>=2000?Math.round(sub*.05):0; // demo rule: 5% off over Rs 2,000
  return {sub,disc,tot:sub-disc,qty};
}
function renderCart(){
  const t=totals();
  lines.innerHTML=cart.size?[...cart].map(([k,q])=>{const p=P[k];return `<div class="line" style="--bg:${p.bg};--fg:${p.fg}">
    <span class="ic"><i class="fa-solid ${p.i}"></i></span><div><b>${p.n}</b><small>${fmt(p.p*q)}</small></div>
    <div class="qty"><button data-k="${k}" data-d="-1" aria-label="Remove one ${p.n}"><i class="fa-solid fa-minus"></i></button><span>${q}</span><button data-k="${k}" data-d="1" aria-label="Add one ${p.n}"><i class="fa-solid fa-plus"></i></button></div></div>`}).join('')
    :`<div class="empty"><i class="fa-solid fa-cart-plus"></i>The cart is empty. Tap a product to start a sale.</div>`;
  $('#count').textContent=t.qty;
  $('#sub').textContent=fmt(t.sub);
  $('#disc').textContent=t.disc?'-'+fmt(t.disc)+' (5% over Rs 2,000)':'Rs 0';
  $('#tot').textContent=fmt(t.tot);
  $('#chargeAmt').textContent=fmt(t.tot);
  $('#charge').disabled=!t.qty;
}
lines.onclick=e=>{
  const b=e.target.closest('button[data-k]');if(!b)return;
  const k=+b.dataset.k, q=(cart.get(k)||0)+(+b.dataset.d);
  if(q>P[k].s)return;
  q<=0?cart.delete(k):cart.set(k,q);renderCart();
};
$('#pay').onclick=e=>{const b=e.target.closest('button');if(!b)return;method=b.dataset.m;$$('#pay button').forEach(x=>x.classList.toggle('on',x===b))};

function countTo(el,to,pre=''){
  const from=+el.dataset.v||0;el.dataset.v=to;
  if(reduce){el.textContent=pre+Math.round(to).toLocaleString('en-US');return}
  const t0=performance.now(),D=900;
  (function step(t){const k=Math.min(1,(t-t0)/D),e=1-Math.pow(1-k,3);el.textContent=pre+Math.round(from+(to-from)*e).toLocaleString('en-US');if(k<1)requestAnimationFrame(step)})(t0);
}
$('#stSales').dataset.v=sales;$('#stRev').dataset.v=rev;

$('#charge').onclick=()=>{
  const t=totals();if(!t.qty)return;
  const now=new Date(), no=String(1000+sales).padStart(6,'0');
  $('#receipt').innerHTML=`<h4>ZEEBROO MART</h4><div class="c">Colombo 03, Branch 1</div><div class="c">${now.toLocaleDateString('en-GB')} ${now.toLocaleTimeString('en-GB',{hour:'2-digit',minute:'2-digit'})}</div><div class="c">Receipt #${no}</div><hr>`+
    [...cart].map(([k,q])=>`<div class="r"><span>${q}x ${P[k].n}</span><span>${(P[k].p*q).toLocaleString('en-US')}</span></div>`).join('')+
    `<hr><div class="r"><span>Subtotal</span><span>${t.sub.toLocaleString('en-US')}</span></div>`+(t.disc?`<div class="r"><span>Discount</span><span>-${t.disc.toLocaleString('en-US')}</span></div>`:'')+
    `<div class="r tot"><span>TOTAL</span><span>${fmt(t.tot)}</span></div><div class="r"><span>Paid by ${method}</span><span>OK</span></div><hr><div class="c">Thank you, come again!</div><div class="barcode"></div>`;
  $('#rwrap').classList.add('show');
  cart.forEach((q,k)=>P[k].s-=q);
  sales++;rev+=t.tot;
  countTo($('#stSales'),sales);countTo($('#stRev'),rev);
  bubble.innerHTML=`Ka-ching! <b>${fmt(t.tot)}</b> sold.`;bubble.classList.remove('hide');
  if(!reduce){mascot.classList.remove('cheer');void mascot.offsetWidth;mascot.classList.add('cheer')}
  setTimeout(()=>bubble.classList.add('hide'),3000);
  setTimeout(()=>$('#newSale').focus({preventScroll:true}),1500);
};
$('#newSale').onclick=()=>{$('#rwrap').classList.remove('show');cart.clear();renderGrid();renderCart()};
renderGrid();renderCart();

/* ---------- roles ---------- */
const roles=[
  {n:'Nimali',r:'Cashier',p:[['Ring up sales',1],['Issue refunds',0],['View reports',0]]},
  {n:'Kasun',r:'Manager',p:[['Ring up sales',1],['Edit stock',1],['View reports',1]]},
  {n:'Ayesha',r:'Accountant',p:[['Pay bills',1],['View reports',1],['Edit stock',0]]},
];
$('#roles').innerHTML=roles.map(o=>`<div class="role"><div class="role-h"><span class="av">${o.n[0]}</span><div><b>${o.n}</b><small>${o.r}</small></div></div>`+
  o.p.map(([l,v])=>`<div class="perm"><span>${l}</span><button class="sw" role="switch" aria-checked="${!!v}" aria-label="${o.n}: ${l}"></button></div>`).join('')+`</div>`).join('');
$('#roles').onclick=e=>{const s=e.target.closest('.sw');if(s)s.setAttribute('aria-checked',s.getAttribute('aria-checked')!=='true')};

/* ---------- modules ---------- */
const M=[
  {t:'Point of Sale',s:'Fast checkout and receipts',d:'Scan items, take cash or card, and finish sales without slowing the queue. Works in the browser or on the desktop app.',img:'point-of-sale',i:'fa-cash-register'},
  {t:'Stock Management',s:'Products, batches, reorders',d:'Know what you have, what is running low and what to reorder. Track products and batches across shelves and warehouses.',img:'stock-management',i:'fa-boxes-stacked'},
  {t:'Account Management',s:'Accounts, branches, balances',d:'Manage business accounts, branches and balances in one view, with the full financial picture owners need.',img:'account-management',i:'fa-building-columns'},
  {t:'Bill Management',s:'Bills, loans, expenses',d:'Create, track and pay bills on time. Stay on top of what you owe suppliers and what customers owe you.',img:'bill-management',i:'fa-file-invoice-dollar'},
  {t:'Human Resources',s:'Staff, payroll, attendance',d:'Organise your team, roles and HR workflows so people operations sit alongside sales and finance.',img:'human-resource-management',i:'fa-people-group'},
  {t:'Social Campaigns',s:'Promotions tied to stock',d:'Plan and run campaigns from the same platform you run the business on, so promotions match what is in stock.',img:'social-media-campaign',i:'fa-bullhorn'},
];
const on=M.map(()=>true);let sel=0;
$('#modList').innerHTML=M.map((m,k)=>`<div class="mod-row${k?'':' sel'}" data-k="${k}" role="option" aria-selected="${!k}" tabindex="0"><span class="mi"><i class="fa-solid ${m.i}"></i></span><div><b>${m.t}</b><small>${m.s}</small></div><button class="sw" role="switch" aria-checked="true" aria-label="Enable ${m.t}"></button><span class="bar"></span></div>`).join('');
M.forEach(m=>{new Image().src=`assets/features/${m.img}.webp`});
function showMod(k){
  const m=M[k],img=$('#modImg'),changed=sel!==k;sel=k;
  $$('.mod-row').forEach((r,i)=>{r.classList.toggle('sel',i===k);r.setAttribute('aria-selected',i===k)});
  $('#modView').classList.toggle('off',!on[k]);
  $('#modStatus').textContent=on[k]?'Installed':'Turned off';
  $('#modTitle').textContent=m.t;$('#modDesc').textContent=m.d;
  img.alt='Zeebroo zebra illustration for '+m.t;
  if(changed&&!reduce){img.classList.add('swap');setTimeout(()=>{img.src=`assets/features/${m.img}.webp`;img.classList.remove('swap')},180)}else img.src=`assets/features/${m.img}.webp`;
}
$('#modList').onclick=e=>{
  const row=e.target.closest('.mod-row');if(!row)return;const k=+row.dataset.k;
  const s=e.target.closest('.sw');
  if(s){on[k]=!on[k];s.setAttribute('aria-checked',on[k]);row.classList.toggle('off',!on[k])}
  showMod(k);
};
$('#modList').onkeydown=e=>{const row=e.target.closest('.mod-row');if(row&&(e.key==='Enter'||e.key===' ')&&e.target===row){e.preventDefault();showMod(+row.dataset.k)}};
showMod(0);
/* autoplay: the active row's progress bar is the timer; hover pauses, a click hands control to the visitor */
const mods=$('.mods');let auto=!reduce;
if(auto){
  new IntersectionObserver(([e])=>mods.classList.toggle('cycling',auto&&e.isIntersecting),{threshold:.4}).observe(mods);
  mods.addEventListener('animationend',e=>{if(e.target.classList.contains('bar'))showMod((sel+1)%M.length)});
  mods.addEventListener('mouseenter',()=>mods.classList.add('paused'));
  mods.addEventListener('mouseleave',()=>mods.classList.remove('paused'));
  mods.addEventListener('focusin',()=>mods.classList.add('paused'));
  mods.addEventListener('focusout',()=>mods.classList.remove('paused'));
  $('#modList').addEventListener('click',()=>{auto=false;mods.classList.remove('cycling')},true);
}

/* ---------- finance map ---------- */
(function(){
  const L=[['Electricity Bill','Overdue',1],['Gas Bill','5,000.00, overdue',1],['Telephone Bill','Overdue',1],['Waste Bill','2,999.97, overdue',1],['Water Bill','Overdue',1],['Enterprise Loan','20,023.96 / month',0],['Car Rental','48,815.95 / month',0]];
  const R=[['POS Sales','Sales transactions'],['Quotations','Web panel'],['Invoices','Web panel'],['Credit Recovery','Outstanding credits']];
  let s='';
  const node=(x,y,w,h,t,sub,id,od)=>`<g class="nd${od?' od':''}" data-id="${id}" tabindex="0"><rect x="${x}" y="${y}" width="${w}" height="${h}" rx="${h/2}"/><text x="${x+26}" y="${y+h/2-3}">${t}</text><text class="s" x="${x+26}" y="${y+h/2+15}">${sub}</text></g>`;
  L.forEach((n,i)=>{const y=24+i*76+28;s+=`<path class="wire" id="wl${i}" d="M250 ${y} C 300 ${y}, 290 280, 330 280"/><path class="pulse ex" d="M330 280 C 290 280, 300 ${y}, 250 ${y}" style="animation-delay:${-i*.2}s"/>`});
  R.forEach((n,i)=>{const y=110+i*96+28;s+=`<path class="wire" id="wr${i}" d="M930 280 C 965 280, 955 ${y}, 990 ${y}"/><path class="pulse inc" d="M990 ${y} C 955 ${y}, 965 280, 930 280" style="animation-delay:${-i*.3}s"/>`});
  s+=`<path class="wire" d="M545 280 L500 280"/><path class="pulse ex" d="M545 280 L500 280"/><path class="wire" d="M780 280 L735 280"/><path class="pulse inc" d="M780 280 L735 280"/>`;
  L.forEach((n,i)=>s+=node(20,24+i*76,230,56,n[0],n[1],'l'+i,n[2]));
  R.forEach((n,i)=>s+=node(990,110+i*96,230,56,n[0],n[1],'r'+i));
  s+=`<g class="nd hub"><rect x="330" y="244" width="170" height="72" rx="36" style="stroke:#FF7A7E"/><text x="415" y="274" text-anchor="middle" style="fill:#FF7A7E">Expenses</text><text class="s" x="415" y="296" text-anchor="middle">106,839.88 / month</text></g>`;
  s+=`<g class="nd hub"><rect x="545" y="244" width="190" height="72" rx="36" style="fill:#FFCB2F;stroke:#FFCB2F"/><text x="640" y="287" text-anchor="middle" style="fill:#121212">Your business</text></g>`;
  s+=`<g class="nd hub"><rect x="780" y="244" width="150" height="72" rx="36" style="stroke:#4ADE80"/><text x="855" y="274" text-anchor="middle" style="fill:#4ADE80">Income</text><text class="s" x="855" y="296" text-anchor="middle">4 streams</text></g>`;
  const f=$('#flow');f.innerHTML=s;
  f.querySelectorAll('.nd[data-id]').forEach(g=>{
    const w=f.querySelector('#w'+g.dataset.id), hl=v=>{g.classList.toggle('hl',v);w.classList.toggle('hl',v)};
    g.addEventListener('mouseenter',()=>hl(true));g.addEventListener('mouseleave',()=>hl(false));
    g.addEventListener('focus',()=>hl(true));g.addEventListener('blur',()=>hl(false));
  });
})();

/* ---------- industries ---------- */
const I=[
  ['Restaurant','Tables, orders and kitchen flow','fa-utensils','restaurant',1],
  ['Retail Stores','Counter sales, stock and daily reports','fa-store','retail-stores',1],
  ['Ecommerce','Orders, inventory and fulfilment','fa-bag-shopping','ecommerce'],
  ['Manufacturing','Production, materials and dispatch','fa-industry','manufacturing'],
  ['Spare Parts','Parts catalogue and fast checkout','fa-gears','spare-parts'],
  ['Wholesale &amp; Distribution','Bulk orders and client accounts','fa-truck-ramp-box','wholesale-distribution'],
  ['Non-Profit','Donations, campaigns and volunteers','fa-hand-holding-heart','non-profit'],
  ['Pharmacy &amp; Healthcare','Medicine stock and compliance','fa-prescription-bottle-medical','pharmacy-healthcare'],
  ['Hotel &amp; Hospitality','Rooms, billing and staff','fa-bell-concierge','hotel-hospitality'],
];
$('#inds').innerHTML=I.map(([t,d,i,u,pop])=>`<a class="ind" href="https://www.zeebroo.com/industry/${u}"><span class="ii"><i class="fa-solid ${i}"></i></span><div><h3>${t}${pop?' <span class="badge">Popular</span>':''}</h3><p>${d}</p></div></a>`).join('');

/* ---------- manifesto words (revealed by CSS scroll timeline where supported) ---------- */
const mf=$('#manifesto');
mf.innerHTML=mf.innerHTML.split('<br>').map(l=>l.split(' ').map(w=>`<span class="w">${w}</span>`).join(' ')).join('<br>');

/* ---------- reveal, counters, step markers ---------- */
const io=new IntersectionObserver(es=>es.forEach(e=>{
  if(!e.isIntersecting)return;
  e.target.classList.add('in');
  e.target.querySelectorAll('[data-count]').forEach(el=>countTo(el,+el.dataset.count,el.dataset.pre||''));
  io.unobserve(e.target);
}),{threshold:.18,rootMargin:'0px 0px -40px 0px'});
$$('.reveal').forEach(el=>io.observe(el));
const so=new IntersectionObserver(es=>es.forEach(e=>e.isIntersecting&&e.target.classList.add('in')),{rootMargin:'0px 0px -45% 0px'});
$$('.step').forEach(el=>so.observe(el));
</script>
</body>
</html>
