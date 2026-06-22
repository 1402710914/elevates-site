<?php include 'header.php'; ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&display=swap" rel="stylesheet">

<style>
    .ha-page{
        --panel-bg:#f8f9fb;
        --input-bg:#fff;
        --line:#e2e5eb;
        --text:#1a1a2e;
        --muted:#5c6578;
        --accent:#3a49a9;
        --accent2:#1e3a5f;
        --r:14px;
        background:#fff;
        padding:56px 16px 72px;
    }
    .ha-page .wrap{
        max-width:1100px;
        margin:0 auto;
        display:grid;
        grid-template-columns: 1fr 1.12fr;
        gap:26px;
    }
    .ha-page .panel{
        background:var(--panel-bg);
        border:1px solid var(--line);
        border-radius:var(--r);
        padding:30px;
        color:var(--text);
        box-shadow:0 4px 24px rgba(26,26,46,.06);
    }
    .ha-page .eyebrow{
        display:inline-block;
        font-size:12px;
        letter-spacing:.65px;
        text-transform:uppercase;
        color:var(--accent);
        margin-bottom:12px;
        font-weight:600;
    }
    .ha-page .sub{
        color:var(--muted);
        font-size:15px;
        line-height:1.75;
        margin-bottom:20px;
    }
    .ha-page .content-stack .sub:last-of-type{ margin-bottom:0; }
    .ha-page .consent-block{
        margin-top:4px;
        padding:14px 16px;
        border-radius:10px;
        border:1px solid var(--line);
        background:#fff;
    }
    .ha-page .consent-row{
        display:flex;
        gap:12px;
        align-items:flex-start;
    }
    .ha-page .consent-row input[type="checkbox"]{
        width:18px;
        height:18px;
        min-width:18px;
        margin-top:3px;
        cursor:pointer;
        accent-color:#3a49a9;
    }
    .ha-page .consent-row label{
        font-size:13px;
        font-weight:500;
        color:#374151;
        line-height:1.55;
        cursor:pointer;
        margin:0;
    }
    .ha-page .consent-row .disclaimer-tag{
        display:block;
        font-size:11px;
        font-weight:700;
        letter-spacing:.04em;
        text-transform:uppercase;
        color:var(--accent);
        margin-bottom:8px;
    }
    .ha-page .form-title{
        font-family:'Syne',sans-serif;
        font-size:22px;
        margin-bottom:6px;
        color:var(--text);
    }
    .ha-page .form-sub{ color:var(--muted); font-size:14px; margin-bottom:18px; }
    .ha-page form{ display:grid; gap:14px; }
    .ha-page .grid2{
        display:grid;
        grid-template-columns: 1fr 1fr;
        gap:14px;
    }
    .ha-page .field{
        display:flex;
        flex-direction:column;
        gap:6px;
    }
    .ha-page label{
        font-size:12px;
        color:#374151;
        font-weight:600;
        letter-spacing:.25px;
    }
    .ha-page label .hint{ font-weight:400; color:var(--muted); }
    .ha-page input, .ha-page textarea{
        width:100%;
        background:var(--input-bg);
        border:1px solid var(--line);
        color:var(--text);
        border-radius:10px;
        padding:12px 12px;
        font-size:14px;
        outline:none;
        font-family:inherit;
    }
    .ha-page textarea{
        min-height:130px;
        resize:vertical;
        line-height:1.5;
    }
    .ha-page input:focus, .ha-page textarea:focus{
        border-color:#3a49a9;
        box-shadow:0 0 0 3px rgba(58,73,169,.15);
    }
    .ha-page .btn-submit{
        margin-top:4px;
        border:none;
        border-radius:10px;
        padding:13px 18px;
        font-size:14px;
        font-weight:700;
        background:linear-gradient(135deg, #6a0dad, #a9167e);
        color:#fff;
        cursor:pointer;
        transition: opacity .2s ease, transform .15s ease;
    }
    .ha-page .btn-submit:hover{ opacity:.95; transform: translateY(-1px); }
    .ha-page .btn-submit:disabled{ opacity:.65; cursor:not-allowed; transform:none; }
    .ha-page .msg{
        display:none;
        margin-top:8px;
        padding:11px 12px;
        border-radius:10px;
        font-size:13px;
    }
    .ha-page .msg.ok{
        display:block;
        border:1px solid rgba(22,163,74,.35);
        background:rgba(22,163,74,.1);
        color:#14532d;
    }
    .ha-page .msg.err{
        display:block;
        border:1px solid rgba(220,38,38,.35);
        background:rgba(220,38,38,.08);
        color:#991b1b;
    }
    .ha-page .intro-title{
        font-family:'Syne',sans-serif;
        font-size:28px;
        line-height:1.2;
        letter-spacing:-.35px;
        margin-bottom:14px;
        color:var(--text);
    }
    @media (max-width: 900px){
        .ha-page{ padding-top:40px; }
        .ha-page .wrap{ grid-template-columns:1fr; }
    }
    @media (max-width: 620px){
        .ha-page .grid2{ grid-template-columns:1fr; }
        .ha-page .intro-title{ font-size:24px; }
        .ha-page .panel{ padding:22px; }
    }
</style>

    <section class="page-hero">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-9">
                    <h1 class="page-title">Hiring Assistance</h1>
                    <p class="page-subtitle">Share your hiring needs—we help identify candidates with the right skills and experience, and support interviews and onboarding.</p>
                </div>
            </div>
        </div>
    </section>

<section class="ha-page">
    <div class="wrap">
        <section class="panel">
            <span class="eyebrow">For business</span>
            <h2 class="intro-title">Build the team you need</h2>
            <div class="content-stack">
                <p class="sub">
                    If you are looking for suitable talent to build your <strong>Sales</strong>, <strong>Business Development</strong>, <strong>Pre-Sales</strong>, <strong>Solution Architect</strong>, <strong>Cloud Engineers</strong>, <strong>Cybersecurity professionals</strong>, <strong>Client Handling</strong>, <strong>Software Development</strong>, <strong>Support Operations</strong>, or <strong>Implementation</strong> teams, you can share your hiring requirements with us. Based on your needs, we help identify and recommend candidates with relevant skills, experience, and domain fit.
                </p>
                <p class="sub">
                    Our Talent Acquisition team coordinates with potential candidates, schedules interviews, and supports the onboarding process to ensure a smooth hiring experience.
                </p>
            </div>
        </section>

        <section class="panel">
            <h2 class="form-title">Submit your hiring request</h2>
            <p class="form-sub">All fields are required. Please outline roles, headcount (if known), and salary or CTC expectations in the last field so we can match you accurately.</p>

            <form id="haForm" novalidate>
                <div class="grid2">
                    <div class="field">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" placeholder="Your full name" required autocomplete="name">
                    </div>
                    <div class="field">
                        <label for="phone">Contact no.</label>
                        <input type="tel" id="phone" name="phone" placeholder="Mobile / landline" required autocomplete="tel">
                    </div>
                </div>

                <div class="field">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="you@company.com" required autocomplete="email">
                </div>

                <div class="field">
                    <label for="organization_name">Name of your organization</label>
                    <input type="text" id="organization_name" name="organization_name" placeholder="Company / legal name" required autocomplete="organization">
                </div>

                <div class="field">
                    <label for="resources_salary">What type of resources you need and at what salary package? <span class="hint">(be specific)</span></label>
                    <textarea id="resources_salary" name="resources_salary" placeholder="Example: 2 mid-level Java developers, 4–7 years, hybrid Bangalore, budget 18–24 LPA CTC each…" required></textarea>
                </div>

                <div class="consent-block">
                    <div class="consent-row">
                        <input type="checkbox" id="consent_hiring_assistance" name="consent_hiring_assistance" value="1" required>
                        <label for="consent_hiring_assistance">
                            <span class="disclaimer-tag">Disclaimer</span>
                            I consent to ELEVATES using my submitted information for job assistance and recruitment-related purposes, including sharing my profile with potential employers or hiring partners for relevant job opportunities.
                        </label>
                    </div>
                </div>

                <button class="btn-submit" type="submit" id="submitBtn">Submit request</button>
                <div id="formMsg" class="msg"></div>
            </form>
        </section>
    </div>
</section>

<script>
    (function () {
        const form = document.getElementById('haForm');
        const submitBtn = document.getElementById('submitBtn');
        const formMsg = document.getElementById('formMsg');

        function showMsg(type, text) {
            formMsg.className = 'msg ' + type;
            formMsg.textContent = text;
        }

        form.addEventListener('submit', async function (e) {
            e.preventDefault();
            formMsg.className = 'msg';
            formMsg.textContent = '';

            const fd = new FormData(form);
            submitBtn.disabled = true;
            submitBtn.textContent = 'Submitting...';

            try {
                const res = await fetch('save_hiring_assistance.php', {
                    method: 'POST',
                    body: fd
                });
                const data = await res.json();

                if (!res.ok || !data.ok) {
                    showMsg('err', data.message || 'Submission failed. Please try again.');
                    return;
                }

                showMsg('ok', data.message || 'Submitted successfully.');
                form.reset();
            } catch (err) {
                showMsg('err', 'Network error. Please try again in a moment.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Submit request';
            }
        });
    })();
</script>
<?php include 'footer.php'; ?>
