<?php include 'header.php'; ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&display=swap" rel="stylesheet">

<style>
    /* Hero uses shared .page-hero from style.css (same as About Us & program pages) */
    .ai-assessment-page{
        --panel-bg:#f8f9fb;
        --input-bg:#fff;
        --line:#e2e5eb;
        --text:#1a1a2e;
        --muted:#5c6578;
        --accent:#5b21b6;
        --accent2:#0d9488;
        --r:14px;
        background:#fff;
        padding:56px 16px 72px;
    }
    .ai-assessment-page .wrap{
        max-width:1060px;
        margin:0 auto;
        display:grid;
        grid-template-columns: 1fr 1.15fr;
        gap:24px;
    }
    .ai-assessment-page .panel{
        background:var(--panel-bg);
        border:1px solid var(--line);
        border-radius:var(--r);
        padding:28px;
        color:var(--text);
        box-shadow:0 4px 24px rgba(26,26,46,.06);
    }
    .ai-assessment-page .eyebrow{
        display:inline-block;
        font-size:12px;
        letter-spacing:.7px;
        text-transform:uppercase;
        color:var(--accent2);
        margin-bottom:14px;
    }
    .ai-assessment-page .sub{
        color:var(--muted);
        font-size:15px;
        line-height:1.7;
        margin-bottom:22px;
    }
    .ai-assessment-page .bullets{
        list-style:none;
        display:grid;
        gap:10px;
        padding-left:0;
        margin-bottom:0;
    }
    .ai-assessment-page .bullets li{
        background:#fff;
        border:1px solid var(--line);
        border-radius:10px;
        padding:11px 12px;
        color:#374151;
        font-size:14px;
    }
    .ai-assessment-page .bullets li strong{ color:var(--text); }

    .ai-assessment-page .form-title{
        font-family:'Syne',sans-serif;
        font-size:24px;
        margin-bottom:8px;
        color:var(--text);
    }
    .ai-assessment-page .form-sub{ color:var(--muted); font-size:14px; margin-bottom:18px; }
    .ai-assessment-page form{ display:grid; gap:14px; }
    .ai-assessment-page .grid2{
        display:grid;
        grid-template-columns: 1fr 1fr;
        gap:14px;
    }
    .ai-assessment-page .field{
        display:flex;
        flex-direction:column;
        gap:6px;
    }
    .ai-assessment-page label{
        font-size:12px;
        color:#374151;
        font-weight:600;
        letter-spacing:.3px;
    }
    .ai-assessment-page input{
        width:100%;
        background:var(--input-bg);
        border:1px solid var(--line);
        color:var(--text);
        border-radius:10px;
        padding:12px 12px;
        font-size:14px;
        outline:none;
    }
    .ai-assessment-page input:focus{
        border-color:#7c3aed;
        box-shadow:0 0 0 3px rgba(124,58,237,.15);
    }
    .ai-assessment-page .btn-submit{
        margin-top:4px;
        border:none;
        border-radius:10px;
        padding:12px 16px;
        font-size:14px;
        font-weight:700;
        background:linear-gradient(135deg, #6a0dad, #a9167e);
        color:white;
        cursor:pointer;
        transition: background-color .2s ease;
    }
    .ai-assessment-page .btn-submit:hover{  background:linear-gradient(135deg, #6a0dad, #a9167e); }
    .ai-assessment-page .btn-submit:disabled{ opacity:.7; cursor:not-allowed; }
    .ai-assessment-page .msg{
        display:none;
        margin-top:8px;
        padding:11px 12px;
        border-radius:10px;
        font-size:13px;
    }
    .ai-assessment-page .msg.ok{
        display:block;
        border:1px solid rgba(22,163,74,.35);
        background:rgba(22,163,74,.1);
        color:#14532d;
    }
    .ai-assessment-page .msg.err{
        display:block;
        border:1px solid rgba(220,38,38,.35);
        background:rgba(220,38,38,.08);
        color:#991b1b;
    }
    .ai-assessment-page .intro-title{
        font-family:'Syne',sans-serif;
        font-size:28px;
        line-height:1.2;
        letter-spacing:-.35px;
        margin-bottom:14px;
        color:var(--text);
    }
    @media (max-width: 900px){
        .ai-assessment-page{ padding-top:40px; }
        .ai-assessment-page .wrap{ grid-template-columns:1fr; }
    }
    @media (max-width: 620px){
        .ai-assessment-page .grid2{ grid-template-columns:1fr; }
        .ai-assessment-page .intro-title{ font-size:24px; }
        .ai-assessment-page .panel{ padding:20px; }
    }
</style>

    <section class="page-hero">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-9">
                    <h1 class="page-title">AI Based Assessment (Skill Gap Analysis)</h1>
                    <p class="page-subtitle">Evaluate your profile, identify skill gaps, and get role-focused recommendations to grow your career.</p>
                </div>
            </div>
        </div>
    </section>

<section class="ai-assessment-page">
    <div class="wrap">
        <section class="panel">
            <span class="eyebrow">Skill Gap Analysis</span>
            <h2 class="intro-title">Why take this assessment?</h2>
            <p class="sub">
                Fill this quick assessment form to help us evaluate your current profile, identify skill gaps,
                and recommend the right next role for you.
            </p>
            <ul class="bullets">
                <li><strong>Personalized:</strong> Role-focused recommendations based on your profile.</li>
                <li><strong>Practical:</strong> Highlights skills you need for your target job.</li>
                <li><strong>Fast:</strong> Takes less than 2 minutes to submit.</li>
            </ul>
        </section>

        <section class="panel">
            <h2 class="form-title">Start Your Assessment</h2>
            <p class="form-sub">Please enter accurate details so we can contact you with the right analysis.</p>

            <form id="assessmentForm" novalidate>
                <div class="grid2">
                    <div class="field">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" placeholder="Your full name" required>
                    </div>
                    <div class="field">
                        <label for="phone">Number</label>
                        <input type="tel" id="phone" name="phone" placeholder="Phone number" required>
                    </div>
                </div>

                <div class="grid2">
                    <div class="field">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Email address" required>
                    </div>
                    <div class="field">
                        <label for="designation">Designation</label>
                        <input type="text" id="designation" name="designation" placeholder="Current designation" required>
                    </div>
                </div>

                <div class="grid2">
                    <div class="field">
                        <label for="current_company">Current Company</label>
                        <input type="text" id="current_company" name="current_company" placeholder="Company name" required>
                    </div>
                    <div class="field">
                        <label for="experience_years">No. of Exp (Years)</label>
                        <input type="number" id="experience_years" name="experience_years" min="0" max="50" step="0.1" placeholder="e.g. 3.5" required>
                    </div>
                </div>

                <div class="field">
                    <label for="interested_role">Interested Role</label>
                    <input type="text" id="interested_role" name="interested_role" placeholder="Role you want to move into" required>
                </div>

                <button class="btn-submit" type="submit" id="submitBtn">Submit Assessment</button>
                <div id="formMsg" class="msg"></div>
            </form>
        </section>
    </div>
    </section>

    <script>
        const form = document.getElementById('assessmentForm');
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
                const res = await fetch('save_ai_assessment.php', {
                    method: 'POST',
                    body: fd
                });
                const data = await res.json();

                if (!res.ok || !data.ok) {
                    showMsg('err', data.message || 'Submission failed. Please try again.');
                    return;
                }

                showMsg('ok', 'Thank you! Your AI assessment request has been submitted.');
                form.reset();
            } catch (err) {
                showMsg('err', 'Network error. Please try again in a moment.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Submit Assessment';
            }
        });
    </script>
<?php include 'footer.php'; ?>
