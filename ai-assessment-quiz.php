<?php
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
include 'header.php';
?>

<style>
.quiz-page{
    --panel:#f8f9fb;--line:#e8eaef;--text:#1a1a2e;--muted:#5c6578;
    --brand-purple:#6a0dad;--brand-magenta:#a9167e;--brand-pink:#e530ad;--brand-blue:#6eafe3;
    --accent:var(--brand-magenta);--accent-dark:var(--brand-purple);--accent2:var(--brand-blue);
    --accent-soft:rgba(106,13,173,.08);
    --btn-bg:linear-gradient(135deg,#6a0dad,#a9167e);
    --btn-bg-hover:linear-gradient(135deg,#e530ad,#6eafe3);
    --ok:#059669;--err:#dc2626;--r:16px;
    --font-body:'Inter',sans-serif;--font-heading:'Playfair Display',serif;
    font-family:var(--font-body);
    background:linear-gradient(180deg,#fff 0%,#fafbfc 100%);padding:0 0 80px;
}
.quiz-page .page-hero{padding:150px 0 70px}
.quiz-page .page-subtitle{max-width:640px;margin:0 auto;font-size:1.1rem;opacity:.9}
.quiz-wrap{max-width:1440px;margin:0 auto;padding:48px 24px 0;width:100%}
.quiz-content{width:100%}

/* Step progress */
.quiz-progress-track{
    display:flex;align-items:center;justify-content:center;gap:0;margin-top:8px;margin-bottom:32px;flex-wrap:wrap
}
.quiz-progress-step{
    display:flex;align-items:center;gap:0
}
.quiz-step-pill{
    display:flex;align-items:center;gap:10px;padding:10px 18px;border-radius:999px;
    font-size:13px;font-weight:600;background:#fff;border:1px solid var(--line);color:var(--muted);
    transition:all .25s;white-space:nowrap
}
.quiz-step-pill .num{
    width:28px;height:28px;border-radius:50%;display:grid;place-items:center;
    font-size:12px;font-weight:700;background:#f0f1f4;color:var(--muted)
}
.quiz-step-pill.active{
    background:var(--btn-bg);color:#fff;border-color:transparent;
    box-shadow:0 8px 24px rgba(106,13,173,.28)
}
.quiz-step-pill.active .num{background:rgba(255,255,255,.25);color:#fff}
.quiz-step-pill.done{border-color:rgba(110,175,227,.45);color:var(--brand-purple);background:rgba(106,13,173,.06)}
.quiz-step-pill.done .num{background:var(--btn-bg);color:#fff}
.quiz-step-line{width:32px;height:2px;background:var(--line);margin:0 4px}
.quiz-step-line.done{background:var(--brand-blue)}

/* Layout */
.quiz-grid{display:grid;grid-template-columns:1fr 1.1fr;gap:24px;align-items:start}
.quiz-panel{
    background:var(--panel);border:1px solid var(--line);border-radius:var(--r);
    padding:28px;box-shadow:0 4px 30px rgba(26,26,46,.05)
}
.quiz-panel h2{font-family:var(--font-heading);font-size:24px;color:var(--text);margin-bottom:8px}
.quiz-sub{color:var(--muted);font-size:15px;line-height:1.7;margin-bottom:20px}
.quiz-eyebrow{
    display:inline-block;font-size:11px;letter-spacing:.12em;text-transform:uppercase;
    color:var(--accent2);font-weight:700;margin-bottom:12px
}
.quiz-bullets{list-style:none;padding:0;margin:0;display:grid;gap:10px}
.quiz-bullets li{
    display:flex;align-items:flex-start;gap:12px;background:#fff;border:1px solid var(--line);
    border-radius:12px;padding:14px 16px;font-size:14px;color:#374151;line-height:1.5
}
.quiz-bullets li i{color:var(--accent);margin-top:2px;flex-shrink:0}

.quiz-field{margin-bottom:18px}
.quiz-field label{display:block;font-size:13px;font-weight:600;color:var(--text);margin-bottom:7px}
.quiz-field input{
    width:100%;padding:14px 16px;border:1px solid var(--line);border-radius:12px;
    font-size:15px;background:#fff;color:var(--text);transition:border-color .2s,box-shadow .2s
}
.quiz-field input:focus{outline:none;border-color:var(--accent);box-shadow:0 0 0 4px var(--accent-soft)}

.quiz-btn{
    display:inline-flex;align-items:center;justify-content:center;gap:8px;
    background:var(--btn-bg);color:#fff;border:none;border-radius:999px;
    padding:14px 30px;font-size:15px;font-weight:600;cursor:pointer;
    transition:transform .2s,box-shadow .2s,background .25s;box-shadow:0 8px 24px rgba(106,13,173,.25)
}
.quiz-btn:hover{transform:translateY(-2px);color:#fff;background:var(--btn-bg-hover);box-shadow:0 12px 28px rgba(229,48,173,.35)}
.quiz-btn:disabled{opacity:.55;cursor:not-allowed;transform:none;box-shadow:none}
.quiz-btn-outline{background:#fff;color:var(--brand-purple);border:2px solid var(--brand-purple);box-shadow:none}
.quiz-btn-outline:hover{background:var(--accent-soft);color:var(--brand-magenta);border-color:var(--brand-magenta)}
.quiz-btn-teal{background:var(--btn-bg);box-shadow:0 8px 24px rgba(106,13,173,.25)}
.quiz-btn-teal:hover{background:var(--btn-bg-hover);box-shadow:0 12px 28px rgba(229,48,173,.35)}

.quiz-msg{padding:14px 16px;border-radius:12px;font-size:14px;margin-top:16px;display:none;line-height:1.5}
.quiz-msg.show{display:flex;align-items:flex-start;gap:10px}
.quiz-msg.err{background:#fef2f2;color:var(--err);border:1px solid #fecaca}
.quiz-msg.ok{background:#ecfdf5;color:var(--ok);border:1px solid #a7f3d0}

/* Instructions */
.quiz-meta{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:28px}
.quiz-meta-item{
    text-align:center;background:#fff;border:1px solid var(--line);border-radius:14px;padding:20px 14px;
    box-shadow:0 2px 12px rgba(26,26,46,.04)
}
.quiz-meta-item i{font-size:24px;color:var(--accent);margin-bottom:10px;display:block}
.quiz-meta-item strong{display:block;font-family:var(--font-heading);font-size:26px;color:var(--text)}
.quiz-meta-item span{font-size:12px;color:var(--muted);text-transform:uppercase;letter-spacing:.04em}

/* Instructions page layout */
.quiz-instr-panel{
    background:var(--panel);border:1px solid var(--line);border-radius:20px;
    padding:0;box-shadow:0 8px 40px rgba(26,26,46,.06);overflow:visible
}
.quiz-instr-hero{
    background:linear-gradient(135deg,#1a1a2e 0%,#2d2d44 55%,#1a3a4a 100%);
    color:#fff;padding:32px 40px;display:flex;align-items:flex-start;justify-content:space-between;gap:24px;flex-wrap:wrap
}
.quiz-instr-hero-text{flex:1;min-width:260px}
.quiz-instr-hero .quiz-eyebrow{color:rgba(255,255,255,.7)}
.quiz-instr-hero h2{font-family:var(--font-heading);font-size:28px;color:#fff;margin:8px 0 10px}
.quiz-instr-hero p{font-size:15px;line-height:1.7;color:rgba(255,255,255,.82);margin:0;max-width:720px}
.quiz-instr-hero-badge{
    display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,.12);
    border:1px solid rgba(255,255,255,.2);border-radius:999px;padding:8px 16px;font-size:13px;font-weight:600
}
.quiz-instr-body{padding:32px 40px 36px;overflow:visible}
.quiz-instr-grid{
    display:grid;grid-template-columns:1fr;gap:20px;margin-bottom:28px;align-items:start
}
.quiz-instr-stack{display:flex;flex-direction:column;gap:20px;margin-bottom:28px}
.quiz-instr-col{display:flex;flex-direction:column;gap:20px;min-width:0;width:100%}
.quiz-instr-card{
    background:#fff;border:1px solid var(--line);border-radius:16px;padding:24px 26px;
    height:auto;overflow:visible;position:relative;scroll-margin-top:120px
}
.quiz-instr-card + .quiz-instr-card{margin-top:0}
.quiz-instr-card h4{
    font-family:var(--font-heading);font-size:18px;color:var(--text);margin:0 0 14px;
    display:flex;align-items:center;gap:10px
}
.quiz-instr-card h4 i{color:var(--accent);font-size:16px}
.quiz-instr-card p{color:#374151;font-size:14px;line-height:1.85;margin:0}
.quiz-instr-card .lead{
    font-size:15px;color:var(--text);font-weight:500;margin:0;padding:14px 16px;
    background:linear-gradient(135deg,rgba(106,13,173,.06),rgba(110,175,227,.08));border-radius:12px;border:1px solid var(--line);
    line-height:1.75;word-wrap:break-word;overflow-wrap:break-word
}
.quiz-instr-card p{word-wrap:break-word;overflow-wrap:break-word}
.quiz-pillar-grid{display:grid;gap:12px;margin-top:4px}
.quiz-pillar-row{
    display:flex;flex-direction:column;align-items:stretch;gap:8px;padding:14px 16px;
    background:#fafbfc;border:1px solid var(--line);border-radius:12px;font-size:13px
}
.quiz-pillar-row .pw-top{display:flex;justify-content:space-between;align-items:flex-start;gap:12px;flex-wrap:wrap}
.quiz-pillar-row strong{color:var(--text);font-size:13px;line-height:1.45;flex:1;min-width:0}
.quiz-pillar-row .pw-count{color:var(--muted);font-size:12px;font-weight:600;white-space:nowrap;flex-shrink:0}
.quiz-pillar-row .pw-bar{width:100%;height:8px;background:#e8eaef;border-radius:999px;overflow:hidden}
.quiz-pillar-row .pw-fill{height:100%;background:linear-gradient(90deg,var(--accent2),var(--accent));border-radius:999px}
.quiz-type-list{display:grid;grid-template-columns:1fr;gap:10px}
.quiz-type-item{
    padding:12px 14px;background:#fafbfc;border:1px solid var(--line);border-radius:12px;font-size:12px;line-height:1.55
}
.quiz-type-item code{
    display:inline-block;font-weight:700;color:#fff;background:var(--accent2);
    padding:2px 8px;border-radius:6px;font-size:11px;margin-bottom:6px
}
.quiz-type-item strong{display:block;color:var(--text);font-size:13px;margin:8px 0 4px}
.quiz-type-item .type-hint-text{display:block;color:#374151;line-height:1.55}
.quiz-bands-wrap{
    margin-top:8px;padding:28px 32px;background:linear-gradient(180deg,#f8f9fb 0%,#fff 100%);
    border:1px solid var(--line);border-radius:16px
}
.quiz-bands-wrap h4{
    font-family:var(--font-heading);font-size:20px;margin:0 0 18px;color:var(--text);
    display:flex;align-items:center;gap:10px
}
.quiz-bands-wrap h4 i{color:var(--accent)}
.quiz-band-stack{display:flex;flex-direction:column;gap:10px}
.quiz-band-row{
    display:grid;grid-template-columns:148px 1fr;gap:20px;align-items:start;
    padding:16px 20px;background:#fff;border:1px solid var(--line);border-radius:12px;
    border-left:4px solid var(--accent);transition:box-shadow .2s
}
.quiz-band-row:hover{box-shadow:0 4px 16px rgba(26,26,46,.06)}
.quiz-band-row.b-advanced{border-left-color:#7c3aed}
.quiz-band-row.b-advanced .band-title{color:#7c3aed}
.quiz-band-row.b-proficient{border-left-color:var(--accent2)}
.quiz-band-row.b-proficient .band-title{color:var(--accent2)}
.quiz-band-row.b-competent{border-left-color:#2563eb}
.quiz-band-row.b-competent .band-title{color:#2563eb}
.quiz-band-row.b-emerging{border-left-color:#d97706}
.quiz-band-row.b-emerging .band-title{color:#d97706}
.quiz-band-row.b-developing{border-left-color:#dc2626}
.quiz-band-row.b-developing .band-title{color:#dc2626}
.quiz-band-row .band-head{display:flex;flex-direction:column;gap:4px}
.quiz-band-row .band-title{
    font-family:var(--font-heading);font-size:15px;font-weight:700;letter-spacing:.04em
}
.quiz-band-row .band-range{font-size:13px;font-weight:600;color:var(--muted)}
.quiz-band-row .band-desc{margin:0;font-size:14px;line-height:1.65;color:#374151}

.quiz-instr-footer{padding:0;background:#fff;border-top:1px solid var(--line)}
.quiz-instr-notice{
    display:flex;align-items:center;gap:10px;padding:14px 40px;
    background:linear-gradient(90deg,rgba(106,13,173,.08),rgba(110,175,227,.08));
    border-bottom:1px solid var(--line);font-size:14px;color:#374151;line-height:1.5
}
.quiz-instr-notice i{color:var(--accent2);font-size:16px;flex-shrink:0}
.quiz-instr-actions{
    display:flex;align-items:center;justify-content:flex-end;gap:14px;
    padding:22px 40px 26px;flex-wrap:wrap
}
.quiz-instr-actions .quiz-btn{min-width:160px;padding:14px 28px}
.quiz-instr-actions .quiz-btn-outline{min-width:120px}
.quiz-instructions{
    background:#fff;border:1px solid var(--line);border-radius:14px;padding:22px 24px;
    white-space:pre-line;color:#374151;font-size:14px;line-height:1.85;margin-bottom:24px
}
.quiz-instructions ul{margin:8px 0 0;padding-left:18px}
.quiz-instr-section{margin-bottom:22px}
.quiz-instr-section h4{font-family:var(--font-heading);font-size:16px;color:var(--text);margin:0 0 10px}
.quiz-instr-section p{color:#374151;font-size:14px;line-height:1.8;margin:0}
.quiz-type-hint{
    display:flex;align-items:flex-start;gap:10px;background:rgba(110,175,227,.1);border:1px solid rgba(110,175,227,.25);
    border-radius:12px;padding:12px 14px;margin-bottom:18px;font-size:13px;color:#0f766e;line-height:1.6
}
.quiz-type-hint i{margin-top:2px}
.quiz-action-row{display:flex;gap:12px;flex-wrap:wrap;align-items:center}

/* Quiz step */
.quiz-exam-card{
    background:#fff;border:1px solid var(--line);border-radius:var(--r);
    box-shadow:0 8px 40px rgba(26,26,46,.07);overflow:hidden
}
.quiz-timer-bar{
    background:linear-gradient(135deg,#1a1a2e,#2d2d44);color:#fff;
    padding:16px 28px;display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap
}
.quiz-timer-label{font-size:12px;opacity:.7;text-transform:uppercase;letter-spacing:.06em}
.quiz-timer{font-family:var(--font-heading);font-size:28px;font-weight:700;letter-spacing:.02em}
.quiz-timer.warn{color:#fca5a5;animation:pulse 1s infinite}
@keyframes pulse{0%,100%{opacity:1}50%{opacity:.7}}
.quiz-timer-progress{flex:1;max-width:320px;min-width:160px}
.quiz-timer-progress small{display:block;font-size:12px;opacity:.8;margin-bottom:6px}
.quiz-progress{height:8px;background:rgba(255,255,255,.15);border-radius:999px;overflow:hidden}
.quiz-progress-fill{height:100%;background:var(--btn-bg);transition:width .35s;border-radius:999px}

.quiz-exam-body{padding:32px 28px 24px}
.quiz-q-header{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:20px;flex-wrap:wrap}
.quiz-q-badge{
    display:inline-flex;align-items:center;gap:8px;background:var(--accent-soft);
    color:var(--accent);font-size:12px;font-weight:700;padding:6px 14px;border-radius:999px
}
.quiz-q-cat{font-size:13px;color:var(--muted)}
.quiz-q-text{
    font-family:var(--font-heading);font-size:20px;font-weight:600;color:var(--text);
    line-height:1.55;margin-bottom:24px
}
.quiz-options{display:grid;gap:12px}
.quiz-opt{
    display:flex;align-items:flex-start;gap:14px;padding:16px 18px;border:2px solid var(--line);
    border-radius:14px;cursor:pointer;transition:all .18s;background:#fafbfc
}
.quiz-opt:hover{border-color:var(--brand-purple);background:var(--accent-soft)}
.quiz-opt.selected{border-color:var(--brand-purple);background:var(--accent-soft);box-shadow:0 4px 16px rgba(106,13,173,.12)}
.quiz-opt-key{
    width:32px;height:32px;border-radius:50%;background:#fff;border:2px solid var(--line);
    display:grid;place-items:center;font-size:13px;font-weight:700;color:var(--muted);flex-shrink:0;
    transition:all .18s
}
.quiz-opt.selected .quiz-opt-key{background:var(--brand-purple);border-color:var(--brand-purple);color:#fff}
.quiz-opt-text{font-size:15px;color:#374151;line-height:1.55;padding-top:4px}
.quiz-opt input{position:absolute;opacity:0;pointer-events:none}

.quiz-q-nav{
    display:flex;align-items:center;justify-content:space-between;gap:12px;
    padding:20px 28px;border-top:1px solid var(--line);background:#fafbfc;flex-wrap:wrap
}
.quiz-q-dots{display:none}
.quiz-q-progress-label{
    flex:1;text-align:center;font-size:14px;font-weight:600;color:var(--muted);padding:0 12px
}
.quiz-q-progress-label strong{color:var(--text);font-family:var(--font-heading);font-size:18px}
.quiz-assess-loading{
    text-align:center;padding:48px 24px;color:var(--muted)
}
.quiz-assess-loading i{font-size:32px;color:var(--accent2);margin-bottom:16px;display:block}
.quiz-assess-loading p{font-size:18px;font-weight:600;color:var(--text);margin:0 0 8px}
.quiz-assess-loading small{font-size:14px}

/* Result */
.quiz-result-wrap{text-align:center;max-width:720px;margin:0 auto}
.quiz-result-icon{
    width:80px;height:80px;border-radius:50%;margin:0 auto 20px;
    background:var(--btn-bg);color:#fff;
    display:grid;place-items:center;font-size:36px;
    box-shadow:0 12px 32px rgba(106,13,173,.3)
}
.quiz-result-score{
    padding:32px;background:linear-gradient(135deg,rgba(106,13,173,.06),rgba(110,175,227,.08));
    border-radius:20px;margin-bottom:24px;border:1px solid var(--line)
}
.quiz-result-score .pct{
    font-family:var(--font-heading);font-size:64px;font-weight:700;
    background:linear-gradient(135deg,var(--brand-purple),var(--brand-magenta));
    -webkit-background-clip:text;background-clip:text;color:transparent;line-height:1
}
.quiz-result-score .detail{font-size:16px;color:var(--muted);margin-top:10px}
.quiz-result-box{
    background:#fff;border:1px solid var(--line);border-radius:16px;
    padding:28px;text-align:left;margin-bottom:28px
}
.quiz-result-box h3{font-family:var(--font-heading);font-size:22px;color:var(--text);margin-bottom:12px}
.quiz-result-heading{font-family:var(--font-heading);font-size:24px;margin-bottom:20px;color:var(--text)}
.quiz-result-box p{color:#374151;font-size:15px;line-height:1.85;white-space:pre-line}

.quiz-hidden{display:none!important}
.quiz-content{scroll-margin-top:140px}
.quiz-single-card{width:100%;max-width:100%;margin:0}

/* Category cards — 5 in one row */
.persona-grid{display:grid;gap:12px;margin-bottom:22px}
.persona-grid-wide{grid-template-columns:repeat(5,minmax(0,1fr))}
.persona-card{
    display:flex;flex-direction:column;text-align:center;padding:18px 12px 16px;border:2px solid var(--line);
    border-radius:16px;background:#fff;cursor:pointer;transition:all .2s;min-height:168px;position:relative
}
.persona-card:hover{border-color:var(--brand-purple);background:var(--accent-soft);transform:translateY(-3px);box-shadow:0 10px 28px rgba(106,13,173,.12)}
.persona-card.selected{
    border-color:var(--brand-purple);background:linear-gradient(180deg,rgba(106,13,173,.1),#fff);
    box-shadow:0 12px 32px rgba(106,13,173,.18)
}
.persona-card.selected::after{
    content:'\f00c';font-family:'Font Awesome 6 Free';font-weight:900;
    position:absolute;top:10px;right:10px;width:22px;height:22px;border-radius:50%;
    background:var(--btn-bg);color:#fff;font-size:10px;display:grid;place-items:center
}
.persona-card .pc-code{
    font-size:10px;font-weight:700;color:var(--brand-purple);text-transform:uppercase;letter-spacing:.08em;margin-bottom:6px
}
.persona-card .pc-name{font-family:var(--font-heading);font-size:14px;font-weight:600;color:var(--text);line-height:1.35;margin-bottom:8px;flex:1}
.persona-card .pc-meta{font-size:10px;color:var(--muted);line-height:1.45;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden}
.persona-card .pc-tagline{display:none}
.persona-card .pc-ready{
    font-size:10px;color:var(--ok);margin-top:10px;font-weight:700;padding-top:10px;border-top:1px solid var(--line)
}
.persona-card.not-ready{opacity:.55;cursor:not-allowed;transform:none!important}
.persona-card.not-ready .pc-ready{color:var(--err);border-color:var(--line)}

/* Step 2 form wider */
.quiz-details-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px}
.quiz-step-header{text-align:center;margin-bottom:28px}
.quiz-step-header h2{margin-bottom:8px}
.quiz-step-header .quiz-sub{margin-bottom:0;max-width:640px;margin-left:auto;margin-right:auto}

.selected-category-banner{
    display:flex;align-items:center;gap:14px;background:var(--accent-soft);
    border:1px solid rgba(106,13,173,.2);border-radius:14px;padding:14px 18px;margin-bottom:20px
}
.selected-category-banner .scb-code{
    font-size:11px;font-weight:700;color:var(--accent2);text-transform:uppercase;letter-spacing:.06em
}
.selected-category-banner .scb-name{font-family:var(--font-heading);font-size:18px;font-weight:600;color:var(--text)}
.selected-category-banner .scb-meta{font-size:13px;color:var(--muted);margin-top:2px}
.selected-category-banner i{font-size:22px;color:var(--accent)}

.quiz-category-label{
    font-size:12px;font-weight:600;color:rgba(255,255,255,.75);text-transform:uppercase;letter-spacing:.06em
}
.quiz-category-name{font-family:var(--font-heading);font-size:15px;color:#fff;margin-top:2px}

@media(max-width:1280px){
    .persona-grid-wide{grid-template-columns:repeat(5,minmax(140px,1fr))}
    .quiz-type-list{grid-template-columns:1fr}
}
@media(max-width:1024px){
    .quiz-instr-grid{grid-template-columns:1fr}
    .quiz-instr-hero,.quiz-instr-body,.quiz-instr-notice,.quiz-instr-actions{padding-left:24px;padding-right:24px}
    .quiz-bands-wrap{padding:22px 20px}
    .quiz-meta{grid-template-columns:repeat(2,1fr)}
}
@media(max-width:900px){
    .quiz-wrap{padding:32px 16px 0}
    .quiz-grid{grid-template-columns:1fr}
    .quiz-meta{grid-template-columns:1fr 1fr}
    .quiz-step-line{display:none}
    .quiz-progress-track{gap:8px}
    .quiz-exam-body{padding:22px 18px}
    .quiz-q-nav{padding:16px 18px}
    .quiz-timer-bar{padding:14px 18px}
    .quiz-q-text{font-size:17px}
    .quiz-details-grid{grid-template-columns:1fr}
    .quiz-band-row{grid-template-columns:1fr;gap:8px}
    .persona-grid-wide{
        display:flex;overflow-x:auto;scroll-snap-type:x mandatory;gap:12px;padding-bottom:8px;
        -webkit-overflow-scrolling:touch
    }
    .persona-card{flex:0 0 160px;scroll-snap-align:start;min-height:150px}
    .quiz-instr-actions{justify-content:stretch;flex-direction:column-reverse}
    .quiz-instr-actions .quiz-btn,.quiz-instr-actions .quiz-btn-outline{width:100%;min-width:0}
}
@media(max-width:600px){
    .quiz-meta{grid-template-columns:1fr}
    .quiz-step-pill{padding:8px 12px;font-size:11px}
    .quiz-step-pill .num{width:24px;height:24px;font-size:11px}
}
</style>

<section class="page-hero">
    <div class="container text-center">
        <span class="badge rounded-pill mb-3" style="background:rgba(255,255,255,.15);color:#fff;font-weight:600;padding:8px 16px">
            <i class="fas fa-brain me-1"></i> AI-Powered Assessment
        </span>
        <h1 class="page-title" id="heroTitle">ELEVATES Professional Growth Assessment</h1>
        <p class="page-subtitle text-white-50" id="heroSubtitle">Five persona-based assessments — 40 questions per attempt — calibrated to your career stage</p>
    </div>
</section>

<section class="quiz-page">
    <div class="quiz-wrap">

        <div class="quiz-progress-track" id="stepIndicators">
            <div class="quiz-progress-step">
                <div class="quiz-step-pill active" data-step="1"><span class="num">1</span> Select Category</div>
            </div>
            <div class="quiz-step-line"></div>
            <div class="quiz-progress-step">
                <div class="quiz-step-pill" data-step="2"><span class="num">2</span> Your Details</div>
            </div>
            <div class="quiz-step-line"></div>
            <div class="quiz-progress-step">
                <div class="quiz-step-pill" data-step="3"><span class="num">3</span> Instructions</div>
            </div>
            <div class="quiz-step-line"></div>
            <div class="quiz-progress-step">
                <div class="quiz-step-pill" data-step="4"><span class="num">4</span> Assessment</div>
            </div>
            <div class="quiz-step-line"></div>
            <div class="quiz-progress-step">
                <div class="quiz-step-pill" data-step="5"><span class="num">5</span> Result</div>
            </div>
        </div>

        <!-- Step 1: Category selection -->
        <div id="step1" class="quiz-content">
            <div class="quiz-panel" style="padding:36px 40px">
                <div class="quiz-step-header">
                    <span class="quiz-eyebrow">Step 1 of 5</span>
                    <h2>Select Your Assessment Category</h2>
                    <p class="quiz-sub">Choose the persona that matches your career stage. All five assessments are shown below — pick one to continue.</p>
                </div>
                <div class="persona-grid persona-grid-wide" id="personaGrid"></div>
                <div class="quiz-msg" id="step1Msg"></div>
                <div class="quiz-action-row" style="margin-top:24px;justify-content:center">
                    <button class="quiz-btn" id="btnToDetails" disabled>Continue <i class="fas fa-arrow-right"></i></button>
                </div>
            </div>
        </div>

        <!-- Step 2: Contact details -->
        <div class="quiz-hidden quiz-content" id="step2">
            <div class="quiz-panel" style="padding:36px 40px;max-width:720px;margin:0 auto">
                <div class="quiz-step-header">
                    <span class="quiz-eyebrow">Step 2 of 5</span>
                    <h2>Your Details</h2>
                    <p class="quiz-sub">Enter your contact details to continue.</p>
                </div>
                <div class="selected-category-banner" id="selectedCategoryBanner"></div>
                <div class="quiz-details-grid">
                    <div class="quiz-field">
                        <label for="userPhone"><i class="fas fa-phone me-1"></i> Phone Number *</label>
                        <input type="tel" id="userPhone" placeholder="+91 98765 43210" required>
                    </div>
                    <div class="quiz-field">
                        <label for="userEmail"><i class="fas fa-envelope me-1"></i> Email Address *</label>
                        <input type="email" id="userEmail" placeholder="you@company.com" required>
                    </div>
                </div>
                <div class="quiz-action-row" style="margin-top:8px">
                    <button class="quiz-btn" id="btnToInstructions">Continue <i class="fas fa-arrow-right"></i></button>
                    <button class="quiz-btn quiz-btn-outline" id="btnBackToCategory"><i class="fas fa-arrow-left"></i> Change Category</button>
                </div>
                <div class="quiz-msg" id="step2Msg"></div>
            </div>
        </div>

        <!-- Step 3: Instructions -->
        <div class="quiz-hidden quiz-content" id="step3">
            <div class="quiz-instr-panel">
                <div class="quiz-instr-hero">
                    <div class="quiz-instr-hero-text">
                        <span class="quiz-eyebrow">Step 3 of 5 · Before You Begin</span>
                        <h2 id="quizTitle">Assessment Instructions</h2>
                        <p id="quizHeroTagline"></p>
                    </div>
                    <div class="quiz-instr-hero-badge" id="quizHeroBadge"></div>
                </div>
                <div class="quiz-instr-body">
                    <div class="quiz-meta" id="quizMeta"></div>
                    <div id="quizInstructionsRich"></div>
                </div>
                <div class="quiz-instr-footer">
                    <div class="quiz-instr-notice">
                        <i class="fas fa-clock"></i>
                        <span>Read all instructions carefully. The <strong>90-minute timer</strong> starts when you click Start Assessment.</span>
                    </div>
                    <div class="quiz-instr-actions">
                        <button type="button" class="quiz-btn quiz-btn-outline" id="btnBackToStep2"><i class="fas fa-arrow-left"></i> Back</button>
                        <button type="button" class="quiz-btn quiz-btn-teal" id="btnStartQuiz"><i class="fas fa-play"></i> Start Assessment</button>
                    </div>
                </div>
                <div class="quiz-instructions quiz-hidden" id="quizInstructions"></div>
                <div class="quiz-msg" id="step3Msg" style="margin:0 40px 24px"></div>
            </div>
        </div>

        <!-- Step 4: Quiz -->
        <div class="quiz-hidden quiz-content" id="step4">
            <div class="quiz-exam-card">
                <div class="quiz-timer-bar">
                    <div>
                        <div class="quiz-category-label" id="examCategoryLabel">Assessment</div>
                        <div class="quiz-category-name" id="examCategoryName"></div>
                        <div class="quiz-timer-label" style="margin-top:10px">Time Remaining</div>
                        <div class="quiz-timer" id="timerDisplay">90:00</div>
                    </div>
                    <div class="quiz-timer-progress">
                        <small><span id="answeredCount">0</span> of <span id="totalCount">40</span> answered</small>
                        <div class="quiz-progress"><div class="quiz-progress-fill" id="progressFill" style="width:0%"></div></div>
                    </div>
                </div>
                <div class="quiz-exam-body" id="questionArea"></div>
                <div class="quiz-q-nav">
                    <button class="quiz-btn quiz-btn-outline" id="btnPrev" style="padding:10px 20px"><i class="fas fa-chevron-left"></i> Previous</button>
                    <div class="quiz-q-progress-label" id="questionProgressLabel">Question <strong>1</strong> of <strong>40</strong></div>
                    <div class="quiz-q-dots" id="questionDots" aria-hidden="true"></div>
                    <button class="quiz-btn" id="btnNext" style="padding:10px 20px">Next <i class="fas fa-chevron-right"></i></button>
                </div>
                <div style="padding:0 28px 20px">
                    <button class="quiz-btn quiz-btn-teal" id="btnSubmitQuiz" style="width:100%;margin-top:4px">
                        <i class="fas fa-paper-plane"></i> Submit Assessment
                    </button>
                    <div class="quiz-msg" id="step4Msg"></div>
                </div>
            </div>
        </div>

        <!-- Step 5: Result -->
        <div class="quiz-hidden quiz-content" id="step5">
            <div class="quiz-panel quiz-result-wrap" style="padding:40px;max-width:900px;margin:0 auto">
                <div class="quiz-result-icon"><i class="fas fa-trophy"></i></div>
                <h2 class="quiz-result-heading">Your Assessment Result</h2>
                <div class="quiz-result-score" id="resultScore"></div>
                <div class="quiz-result-box" id="resultBox"></div>
                <div class="quiz-result-box quiz-hidden" id="resultPillars"></div>
                <div class="quiz-action-row" style="justify-content:center">
                    <a href="ai-assessment-quiz.php" class="quiz-btn"><i class="fas fa-redo"></i> Take Again</a>
                    <a href="contact-us.php" class="quiz-btn quiz-btn-outline"><i class="fas fa-headset"></i> Talk to Us</a>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
(function () {
    const API = 'quiz_api.php';
    let settings = {};
    let categories = [];
    let selectedCategory = null;
    let attemptToken = '';
    let questions = [];
    let answers = {};
    let currentIndex = 0;
    let timerInterval = null;
    let timerStartedAt = 0;
    let timerDurationMs = 90 * 60 * 1000;
    let quizSubmitting = false;
    let quizStarted = false;
    let quizStarting = false;

    const $ = (id) => document.getElementById(id);

    function showMsg(el, type, text) {
        el.className = 'quiz-msg show ' + type;
        el.innerHTML = '<i class="fas fa-' + (type === 'err' ? 'exclamation-circle' : 'check-circle') + '"></i><span>' + text + '</span>';
    }
    function hideMsg(el) { el.className = 'quiz-msg'; el.innerHTML = ''; }

    function setStep(n) {
        n = parseInt(n, 10) || 1;
        if (n < 4) {
            stopTimer();
            quizStarted = false;
            quizSubmitting = false;
            quizStarting = false;
        }
        ['step1','step2','step3','step4','step5'].forEach((id, i) => {
            $(id).classList.toggle('quiz-hidden', i + 1 !== n);
        });
        document.querySelectorAll('.quiz-step-pill').forEach((el) => {
            const s = parseInt(el.dataset.step, 10);
            el.classList.remove('active', 'done');
            if (s === n) el.classList.add('active');
            else if (s < n) el.classList.add('done');
        });
        document.querySelectorAll('.quiz-step-line').forEach((line, i) => {
            line.classList.toggle('done', i < n - 1);
        });
        const stepEl = $('step' + n);
        if (stepEl) {
            stepEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    function quizAttemptMinutes() {
        return (settings && settings.duration_minutes) ? settings.duration_minutes : 50;
    }

    function quizAttemptQuestionCount() {
        return (settings && settings.total_questions) ? settings.total_questions : 40;
    }

    function getPersonaCategories() {
        return categories.filter(c => c.persona_code);
    }

    function renderSelectedCategoryBanner() {
        const banner = $('selectedCategoryBanner');
        if (!banner || !selectedCategory) return;
        banner.innerHTML = `
            <i class="fas fa-check-circle"></i>
            <div>
                <div class="scb-code">${escapeHtml(selectedCategory.persona_code)}</div>
                <div class="scb-name">${escapeHtml(selectedCategory.name)}</div>
                <div class="scb-meta">${selectedCategory.total_questions} questions · ${quizAttemptMinutes()} minutes</div>
            </div>
        `;
    }

    function updateCategoryContinueBtn() {
        const btn = $('btnToDetails');
        if (btn) btn.disabled = !selectedCategory || !selectedCategory.bank_ready;
    }

    async function apiCall(action, data = {}) {
        const res = await fetch(API, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action, ...data })
        });
        const text = await res.text();
        try {
            return JSON.parse(text);
        } catch (e) {
            return { ok: false, message: 'Server error. Please try again.' };
        }
    }

    function renderPersonaGrid() {
        const grid = $('personaGrid');
        if (!grid) return;
        const personaCats = getPersonaCategories();
        if (!personaCats.length) {
            grid.innerHTML = '<p class="quiz-sub">No assessment categories available yet.</p>';
            updateCategoryContinueBtn();
            return;
        }
        grid.innerHTML = personaCats.map(c => {
            const shortMeta = (c.context_line || '').replace(/\s+/g, ' ').trim();
            return `
            <button type="button" class="persona-card ${c.bank_ready ? '' : 'not-ready'}${selectedCategory && selectedCategory.id === c.id ? ' selected' : ''}" data-id="${c.id}" ${c.bank_ready ? '' : 'disabled'}>
                <div class="pc-code">${escapeHtml(c.persona_code)}</div>
                <div class="pc-name">${escapeHtml(c.name)}</div>
                <div class="pc-meta">${escapeHtml(shortMeta)}</div>
                <div class="pc-ready">${c.bank_ready ? c.total_questions + ' Q' : 'Not ready'}</div>
            </button>
        `}).join('');
        grid.querySelectorAll('.persona-card:not(.not-ready)').forEach((btn) => {
            btn.addEventListener('click', () => {
                const id = parseInt(btn.dataset.id, 10);
                selectedCategory = personaCats.find(c => c.id === id) || null;
                hideMsg($('step1Msg'));
                renderPersonaGrid();
                updateCategoryContinueBtn();
            });
        });
        updateCategoryContinueBtn();
    }

    function bandClass(title) {
        const t = (title || '').toUpperCase();
        if (t.includes('ADVANCED')) return 'b-advanced';
        if (t.includes('PROFICIENT')) return 'b-proficient';
        if (t.includes('COMPETENT')) return 'b-competent';
        if (t.includes('EMERGING')) return 'b-emerging';
        return 'b-developing';
    }

    function renderInstructionsRich() {
        const el = $('quizInstructionsRich');
        if (!el || !selectedCategory) return;
        const c = selectedCategory;
        let left = '';
        let right = '';

        if (c.tagline) {
            const heroTag = $('quizHeroTagline');
            if (heroTag) heroTag.textContent = c.tagline;
        }
        const heroBadge = $('quizHeroBadge');
        if (heroBadge) {
            heroBadge.innerHTML = `<i class="fas fa-user-tag"></i> ${escapeHtml(c.persona_label || c.persona_code)}`;
        }

        if (c.about) {
            left += `<div class="quiz-instr-card"><h4><i class="fas fa-book-open"></i> About This Assessment</h4><p>${escapeHtml(c.about).replace(/\n/g, '<br>')}</p></div>`;
        }
        if (c.how_to) {
            left += `<div class="quiz-instr-card"><h4><i class="fas fa-lightbulb"></i> How to Take</h4><p class="lead">${escapeHtml(c.how_to)}</p></div>`;
        }

        if ((c.pillar_weights || []).length) {
            right += `<div class="quiz-instr-card"><h4><i class="fas fa-columns"></i> Five Pillars &amp; Weights</h4><div class="quiz-pillar-grid">`;
            c.pillar_weights.forEach(pw => {
                const pct = parseFloat(String(pw.weight).replace('%', '')) || 0;
                right += `<div class="quiz-pillar-row">
                    <div class="pw-top">
                        <strong>${escapeHtml(pw.num)} · ${escapeHtml(pw.name)}</strong>
                        <span class="pw-count">${pw.items} Q · ${escapeHtml(pw.weight)}</span>
                    </div>
                    <div class="pw-bar"><div class="pw-fill" style="width:${pct}%"></div></div>
                </div>`;
            });
            right += `</div></div>`;
        }
        if ((c.item_types || []).length) {
            right += `<div class="quiz-instr-card"><h4><i class="fas fa-shapes"></i> Item Types</h4><div class="quiz-type-list">`;
            c.item_types.forEach(it => {
                right += `<div class="quiz-type-item"><code>${escapeHtml(it.code)}</code><strong>${escapeHtml(it.name)}</strong><span class="type-hint-text">${escapeHtml(it.hint)}</span></div>`;
            });
            right += `</div></div>`;
        }

        let html = `<div class="quiz-instr-stack">`;
        if (left) html += `<div class="quiz-instr-col">${left}</div>`;
        if (right) html += `<div class="quiz-instr-col">${right}</div>`;
        html += `</div>`;

        if ((c.proficiency_bands || []).length) {
            const bands = [...c.proficiency_bands].sort((a, b) => (b.min || 0) - (a.min || 0));
            html += `<div class="quiz-bands-wrap"><h4><i class="fas fa-chart-line"></i> Proficiency Bands</h4><div class="quiz-band-stack">`;
            bands.forEach(b => {
                html += `<div class="quiz-band-row ${bandClass(b.title)}">
                    <div class="band-head">
                        <span class="band-title">${escapeHtml(b.title)}</span>
                        <span class="band-range">${b.min}–${b.max}%</span>
                    </div>
                    <p class="band-desc">${escapeHtml(b.descriptor)}</p>
                </div>`;
            });
            html += `</div></div>`;
        }
        el.innerHTML = html;
    }

    function applyCategoryToUI() {
        if (!selectedCategory) return;
        const c = selectedCategory;
        $('quizTitle').textContent = c.name;
        $('heroTitle').textContent = (settings.title || 'ELEVATES Professional Growth Assessment');
        $('heroSubtitle').textContent = c.name + ' — ' + (c.context_line || c.tagline || '');
        const attemptQ = c.total_questions || quizAttemptQuestionCount();
        const attemptMin = quizAttemptMinutes();
        $('quizMeta').innerHTML = `
            <div class="quiz-meta-item"><i class="fas fa-list-ol"></i><strong>${attemptQ}</strong><span>Questions</span></div>
            <div class="quiz-meta-item"><i class="fas fa-hourglass-half"></i><strong>${attemptMin} min</strong><span>Time Limit</span></div>
            <div class="quiz-meta-item"><i class="fas fa-layer-group"></i><strong>${(c.pillars || []).length || 5}</strong><span>Pillars</span></div>
            <div class="quiz-meta-item"><i class="fas fa-database"></i><strong>${c.question_bank_size || c.question_count || '—'}</strong><span>Question Bank</span></div>
        `;
        $('totalCount').textContent = attemptQ;
        $('examCategoryName').textContent = c.name;
        renderSelectedCategoryBanner();
        renderInstructionsRich();
    }

    async function loadSettings() {
        const data = await apiCall('get_settings');
        if (!data.ok) {
            showMsg($('step1Msg'), 'err', data.message || 'Assessment unavailable.');
            return;
        }
        settings = data.settings;
        categories = data.categories || [];
        $('heroTitle').textContent = settings.title || 'ELEVATES Professional Growth Assessment';
        $('heroSubtitle').textContent = `Five persona-based assessments — ${settings.total_questions || 40} questions per attempt — calibrated to your career stage`;
        $('totalCount').textContent = settings.total_questions || 40;
        renderPersonaGrid();
        if (getPersonaCategories().filter(c => c.bank_ready).length === 0) {
            showMsg($('step1Msg'), 'err', 'Assessments are being prepared. Please check back soon.');
        }
    }

    $('btnToDetails').addEventListener('click', () => {
        hideMsg($('step1Msg'));
        if (!selectedCategory) {
            showMsg($('step1Msg'), 'err', 'Please select an assessment category.');
            return;
        }
        if (!selectedCategory.bank_ready) {
            showMsg($('step1Msg'), 'err', 'This category is not ready yet.');
            return;
        }
        applyCategoryToUI();
        setStep(2);
    });

    $('btnBackToCategory').addEventListener('click', () => setStep(1));

    $('btnToInstructions').addEventListener('click', () => {
        hideMsg($('step2Msg'));
        if (!selectedCategory) {
            showMsg($('step2Msg'), 'err', 'Please select an assessment category.');
            setStep(1);
            return;
        }
        const phone = $('userPhone').value.trim();
        const email = $('userEmail').value.trim();
        if (!phone || !email) { showMsg($('step2Msg'), 'err', 'Please enter phone and email.'); return; }
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { showMsg($('step2Msg'), 'err', 'Please enter a valid email.'); return; }
        applyCategoryToUI();
        setStep(3);
    });

    $('btnBackToStep2').addEventListener('click', () => setStep(2));

    function resolveExpiresAt(data) {
        const secs = parseInt(data.duration_seconds, 10);
        timerDurationMs = (secs > 0 ? secs : 90 * 60) * 1000;
        timerStartedAt = Date.now();
        return timerStartedAt + timerDurationMs;
    }

    function stopTimer() {
        if (timerInterval) clearInterval(timerInterval);
        timerInterval = null;
    }

    function showAssessmentLoading() {
        const area = $('questionArea');
        if (!area) return;
        area.innerHTML = `
            <div class="quiz-assess-loading">
                <i class="fas fa-spinner fa-spin"></i>
                <p>Preparing your assessment…</p>
                <small>Loading ${quizAttemptQuestionCount()} random questions from the bank. Please wait.</small>
            </div>
        `;
        if ($('btnSubmitQuiz')) $('btnSubmitQuiz').disabled = true;
        if ($('btnPrev')) $('btnPrev').disabled = true;
        if ($('btnNext')) $('btnNext').disabled = true;
        $('timerDisplay').textContent = '--:--';
    }

    $('btnStartQuiz').addEventListener('click', async (e) => {
        e.preventDefault();
        e.stopPropagation();
        hideMsg($('step3Msg'));
        if (quizSubmitting || quizStarted || quizStarting) return;
        quizStarting = true;
        $('btnStartQuiz').disabled = true;
        $('btnStartQuiz').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Starting...';
        setStep(4);
        showAssessmentLoading();
        try {
            const data = await apiCall('start', {
                phone: $('userPhone').value.trim(),
                email: $('userEmail').value.trim(),
                category_id: selectedCategory ? selectedCategory.id : 0
            });
            if (!data.ok) {
                setStep(3);
                showMsg($('step3Msg'), 'err', data.message || 'Could not start quiz.');
                return;
            }
            if (!data.questions || !data.questions.length) {
                setStep(3);
                showMsg($('step3Msg'), 'err', 'No questions loaded. Please try again.');
                return;
            }
            attemptToken = data.attempt_token;
            questions = data.questions;
            answers = {};
            currentIndex = 0;
            resolveExpiresAt(data);
            if (data.settings && data.settings.category_name) {
                $('examCategoryName').textContent = data.settings.category_name;
            }
            $('totalCount').textContent = questions.length;
            quizStarted = true;
            quizSubmitting = false;
            renderCurrentQuestion();
            updateProgress();
            startTimer();
            setTimeout(() => {
                if ($('btnSubmitQuiz')) $('btnSubmitQuiz').disabled = false;
            }, 600);
        } catch (err) {
            setStep(3);
            showMsg($('step3Msg'), 'err', 'Network error. Please try again.');
        } finally {
            quizStarting = false;
            if (!quizStarted) {
                $('btnStartQuiz').disabled = false;
                $('btnStartQuiz').innerHTML = '<i class="fas fa-play"></i> Start Assessment';
            }
        }
    });

    function updateQuestionProgressLabel() {
        const el = $('questionProgressLabel');
        if (el) {
            el.innerHTML = `Question <strong>${currentIndex + 1}</strong> of <strong>${questions.length}</strong>`;
        }
    }

    function renderCurrentQuestion() {
        const q = questions[currentIndex];
        if (!q) return;
        const area = $('questionArea');
        let optsHtml = '';
        (q.options || []).forEach((opt) => {
            const sel = answers[q.id] === opt.key ? ' selected' : '';
            optsHtml += `
                <label class="quiz-opt${sel}" data-key="${opt.key}">
                    <input type="radio" name="q_${q.id}" value="${opt.key}"${sel ? ' checked' : ''}>
                    <span class="quiz-opt-key">${opt.key.toUpperCase()}</span>
                    <span class="quiz-opt-text">${escapeHtml(opt.text)}</span>
                </label>
            `;
        });
        area.innerHTML = `
            <div class="quiz-q-header">
                <span class="quiz-q-badge"><i class="fas fa-question-circle"></i> Question ${currentIndex + 1} of ${questions.length}${q.question_label ? ' · ' + escapeHtml(q.question_label) : ''}</span>
                ${q.pillar_name ? `<span class="quiz-q-cat"><i class="fas fa-columns me-1"></i>${escapeHtml(q.pillar_name)}</span>` : ''}
            </div>
            ${q.type_hint ? `<div class="quiz-type-hint"><i class="fas fa-info-circle"></i><span><strong>${escapeHtml(q.question_type)}:</strong> ${escapeHtml(q.type_hint)}</span></div>` : ''}
            <div class="quiz-q-text">${escapeHtml(q.question)}</div>
            <div class="quiz-options">${optsHtml}</div>
        `;
        area.querySelectorAll('.quiz-opt').forEach((label) => {
            label.addEventListener('click', () => {
                const key = label.dataset.key;
                answers[q.id] = key;
                area.querySelectorAll('.quiz-opt').forEach((l) => l.classList.remove('selected'));
                label.classList.add('selected');
                label.querySelector('input').checked = true;
                updateProgress();
            });
        });
        updateQuestionProgressLabel();
        updateNavButtons();
    }

    $('btnPrev').addEventListener('click', () => {
        if (currentIndex > 0) { currentIndex--; renderCurrentQuestion(); }
    });
    $('btnNext').addEventListener('click', () => {
        if (currentIndex < questions.length - 1) { currentIndex++; renderCurrentQuestion(); }
    });

    function updateNavButtons() {
        const prev = $('btnPrev');
        const next = $('btnNext');
        if (!prev || !next) return;
        prev.disabled = currentIndex === 0;
        const hasNext = questions.length > 0 && currentIndex < questions.length - 1;
        next.style.display = hasNext ? 'inline-flex' : 'none';
        next.disabled = false;
    }

    function updateProgress() {
        const answered = Object.keys(answers).length;
        $('answeredCount').textContent = answered;
        const pct = questions.length ? (answered / questions.length) * 100 : 0;
        $('progressFill').style.width = pct + '%';
    }

    function escapeHtml(str) {
        const d = document.createElement('div');
        d.textContent = str;
        return d.innerHTML;
    }

    function startTimer() {
        stopTimer();
        if (!quizStarted || !timerStartedAt) return;
        function tick() {
            if (!quizStarted || quizSubmitting) return;
            const left = Math.max(0, timerStartedAt + timerDurationMs - Date.now());
            const mins = Math.floor(left / 60000);
            const secs = Math.floor((left % 60000) / 1000);
            $('timerDisplay').textContent = String(mins).padStart(2, '0') + ':' + String(secs).padStart(2, '0');
            $('timerDisplay').classList.toggle('warn', left <= 5 * 60 * 1000);
            if (left <= 0) {
                const elapsed = Date.now() - timerStartedAt;
                if (elapsed < 60000) return;
                stopTimer();
                autoSubmit();
            }
        }
        tick();
        timerInterval = setInterval(tick, 1000);
    }

    async function submitQuiz() {
        if (quizSubmitting || !quizStarted || !attemptToken) return;
        quizSubmitting = true;
        stopTimer();
        $('btnSubmitQuiz').disabled = true;
        $('btnSubmitQuiz').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';
        hideMsg($('step4Msg'));
        try {
            const data = await apiCall('submit', { attempt_token: attemptToken, answers });
            if (!data.ok) {
                showMsg($('step4Msg'), 'err', data.message || 'Submit failed.');
                quizSubmitting = false;
                $('btnSubmitQuiz').disabled = false;
                $('btnSubmitQuiz').innerHTML = '<i class="fas fa-paper-plane"></i> Submit Assessment';
                return;
            }
            showResult(data.result);
            quizStarted = false;
            setStep(5);
        } catch (e) {
            showMsg($('step4Msg'), 'err', 'Network error during submit.');
            quizSubmitting = false;
            $('btnSubmitQuiz').disabled = false;
            $('btnSubmitQuiz').innerHTML = '<i class="fas fa-paper-plane"></i> Submit Assessment';
        }
    }

    function autoSubmit() {
        if (!quizStarted || quizSubmitting) return;
        showMsg($('step4Msg'), 'err', 'Time is up! Submitting your answers...');
        submitQuiz();
    }

    $('btnSubmitQuiz').addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        if (!quizStarted || quizSubmitting || $('btnSubmitQuiz').disabled) return;
        const unanswered = questions.length - Object.keys(answers).length;
        if (unanswered > 0 && !confirm(`You have ${unanswered} unanswered question(s). Submit anyway?`)) return;
        submitQuiz();
    });

    function showResult(r) {
        $('resultScore').innerHTML = `
            <div class="pct">${r.score_percent}%</div>
            <div class="detail">Composite score · ${r.correct_count} fully correct of ${r.total_questions} items</div>
        `;
        $('resultBox').innerHTML = `
            <h3>${escapeHtml(r.result_title || 'Your Result')}</h3>
            <p>${escapeHtml(r.result_text || '')}</p>
        `;
        const pillarEl = $('resultPillars');
        const weights = selectedCategory && selectedCategory.pillar_weights ? selectedCategory.pillar_weights : [];
        if (pillarEl && r.pillar_scores && weights.length) {
            let ph = '<h3>Pillar Breakdown</h3><div class="quiz-pillar-grid">';
            weights.forEach(pw => {
                const key = pw.num;
                const ps = r.pillar_scores[key];
                const pct = ps ? ps.percent : '—';
                ph += `<div class="quiz-pillar-row"><strong>${escapeHtml(pw.name)}</strong><span>${pct}% · weight ${escapeHtml(pw.weight)}</span></div>`;
            });
            ph += '</div>';
            pillarEl.innerHTML = ph;
            pillarEl.classList.remove('quiz-hidden');
        } else if (pillarEl) {
            pillarEl.classList.add('quiz-hidden');
        }
    }

    loadSettings();
})();
</script>

<?php include 'footer.php'; ?>
