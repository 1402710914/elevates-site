<?php include 'header.php'; ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&display=swap" rel="stylesheet">

<style>
    /* Hero uses shared .page-hero from style.css; content area aligned with site + AI assessment pages */
    .jp-page{
        --panel-bg:#f8f9fb;
        --input-bg:#fff;
        --line:#e2e5eb;
        --text:#1a1a2e;
        --muted:#5c6578;
        --accent:#a9167e;
        --accent2:#6a0dad;
        --r:14px;
        background:#fff;
        padding:56px 16px 72px;
    }
    .jp-page .wrap{
        max-width:1100px;
        margin:0 auto;
        display:grid;
        grid-template-columns: 1fr 1.12fr;
        gap:26px;
    }
    .jp-page .panel{
        background:var(--panel-bg);
        border:1px solid var(--line);
        border-radius:var(--r);
        padding:30px;
        color:var(--text);
        box-shadow:0 4px 24px rgba(26,26,46,.06);
    }
    .jp-page .eyebrow{
        display:inline-block;
        font-size:12px;
        letter-spacing:.65px;
        text-transform:uppercase;
        color:var(--accent2);
        margin-bottom:12px;
        font-weight:600;
    }
    .jp-page .sub{
        color:var(--muted);
        font-size:15px;
        line-height:1.75;
        margin-bottom:20px;
    }
    .jp-page .content-stack .sub:last-of-type{ margin-bottom:0; }
    .jp-page .consent-block{
        margin-top:4px;
        padding:14px 16px;
        border-radius:10px;
        border:1px solid var(--line);
        background:#fff;
    }
    .jp-page .consent-row{
        display:flex;
        gap:12px;
        align-items:flex-start;
    }
    .jp-page .consent-row input[type="checkbox"]{
        width:18px;
        height:18px;
        min-width:18px;
        margin-top:3px;
        cursor:pointer;
        accent-color:#6a0dad;
    }
    .jp-page .consent-row label{
        font-size:13px;
        font-weight:500;
        color:#374151;
        line-height:1.55;
        cursor:pointer;
        margin:0;
    }
    .jp-page .consent-row .disclaimer-tag{
        display:block;
        font-size:11px;
        font-weight:700;
        letter-spacing:.04em;
        text-transform:uppercase;
        color:var(--accent2);
        margin-bottom:8px;
    }

    .jp-page .form-title{
        font-family:'Syne',sans-serif;
        font-size:22px;
        margin-bottom:6px;
        color:var(--text);
    }
    .jp-page .form-sub{ color:var(--muted); font-size:14px; margin-bottom:18px; }
    .jp-page form{ display:grid; gap:14px; }
    .jp-page .grid2{
        display:grid;
        grid-template-columns: 1fr 1fr;
        gap:14px;
    }
    .jp-page .field{
        display:flex;
        flex-direction:column;
        gap:6px;
    }
    .jp-page label{
        font-size:12px;
        color:#374151;
        font-weight:600;
        letter-spacing:.25px;
    }
    .jp-page label .hint{ font-weight:400; color:var(--muted); }
    .jp-page input, .jp-page textarea{
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
    .jp-page textarea{
        min-height:120px;
        resize:vertical;
        line-height:1.5;
    }
    .jp-page input:focus, .jp-page textarea:focus{
        border-color:#7c3aed;
        box-shadow:0 0 0 3px rgba(124,58,237,.15);
    }
    .jp-page .btn-submit{
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
    .jp-page .btn-submit:hover{ opacity:.95; transform: translateY(-1px); }
    .jp-page .btn-submit:disabled{ opacity:.65; cursor:not-allowed; transform:none; }
    .jp-page .msg{
        display:none;
        margin-top:8px;
        padding:11px 12px;
        border-radius:10px;
        font-size:13px;
    }
    .jp-page .msg.ok{
        display:block;
        border:1px solid rgba(22,163,74,.35);
        background:rgba(22,163,74,.1);
        color:#14532d;
    }
    .jp-page .msg.err{
        display:block;
        border:1px solid rgba(220,38,38,.35);
        background:rgba(220,38,38,.08);
        color:#991b1b;
    }
    .jp-page .intro-title{
        font-family:'Syne',sans-serif;
        font-size:28px;
        line-height:1.2;
        letter-spacing:-.35px;
        margin-bottom:14px;
        color:var(--text);
    }
    @media (max-width: 900px){
        .jp-page{ padding-top:40px; }
        .jp-page .wrap{ grid-template-columns:1fr; }
    }
    @media (max-width: 620px){
        .jp-page .grid2{ grid-template-columns:1fr; }
        .jp-page .intro-title{ font-size:24px; }
        .jp-page .panel{ padding:22px; }
    }
</style>

    <section class="page-hero">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-9">
                    <h1 class="page-title">Job &amp; Placement Assistance</h1>
                    <p class="page-subtitle">Share your details to explore relevant opportunities—we align roles with your skills, experience, and career interests, and support you through interviews and onboarding.</p>
                </div>
            </div>
        </div>
    </section>

<section class="jp-page">
    <div class="wrap">
        <section class="panel">
            <span class="eyebrow">Career support</span>
            <h2 class="intro-title">Job assistance tailored to you</h2>
            <div class="content-stack">
                <p class="sub">
                    If you are looking for a suitable job, you can share your details with us.
                </p>
                <p class="sub">
                    In this service, based on your skills we will suggest matching job roles with various employers in your domain. Our Talent Acquisition team coordinates with potential employers, arranges interviews, and assists in smooth onboarding.
                </p>
            </div>
            <div class="note">
                <p><strong>Note:</strong> Your personal information is secure with us and it will be used for job assistance purpose only.</p>
                <p>Your data will never be shared with any third party without your permission.</p>
            </div>
        </section>

        <section class="panel">
            <h2 class="form-title">Register for assistance</h2>
            <p class="form-sub">All fields are required. Use <strong>0</strong> for years of experience if you are a fresher; describe your designation and expertise in detail so we can represent you well to employers.</p>

            <form id="jpForm" novalidate>
                <div class="grid2">
                    <div class="field">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" placeholder="Full name" required autocomplete="name">
                    </div>
                    <div class="field">
                        <label for="phone">Contact number</label>
                        <input type="tel" id="phone" name="phone" placeholder="Mobile / WhatsApp" required autocomplete="tel">
                    </div>
                </div>

                <div class="field">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="you@example.com" required autocomplete="email">
                </div>

                <div class="grid2">
                    <div class="field">
                        <label for="total_experience_years">Total years of experience <span class="hint">(0 if fresher)</span></label>
                        <input type="number" id="total_experience_years" name="total_experience_years" min="0" max="50" step="0.1" placeholder="e.g. 0 or 4.5" required>
                    </div>
                    <div class="field">
                        <label for="qualification">Your qualification</label>
                        <input type="text" id="qualification" name="qualification" placeholder="e.g. B.Tech, MBA" required>
                    </div>
                </div>

                <div class="field">
                    <label for="current_organization">Name of your current organization</label>
                    <input type="text" id="current_organization" name="current_organization" placeholder="Company / college / NA" required>
                </div>

                <div class="field">
                    <label for="designation_expertise">Current designation &amp; area of expertise <span class="hint">(write in detail)</span></label>
                    <textarea id="designation_expertise" name="designation_expertise" placeholder="Role title, tech stack, domain, achievements—help us understand your strengths." required></textarea>
                </div>

                <div class="grid2">
                    <div class="field">
                        <label for="current_ctc">Current CTC</label>
                        <input type="text" id="current_ctc" name="current_ctc" placeholder="e.g. 8 LPA, 12 fixed" required>
                    </div>
                    <div class="field">
                        <label for="expected_ctc">Expected CTC</label>
                        <input type="text" id="expected_ctc" name="expected_ctc" placeholder="e.g. 12–15 LPA" required>
                    </div>
                </div>

                <div class="consent-block">
                    <div class="consent-row">
                        <input type="checkbox" id="consent_job_placement" name="consent_job_placement" value="1" required>
                        <label for="consent_job_placement">
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
        const form = document.getElementById('jpForm');
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
                const res = await fetch('save_job_placement_assistance.php', {
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
