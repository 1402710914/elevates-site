<?php include 'header.php'; ?>

<style>
.bap-it * { box-sizing: border-box; }
.bap-it .program-overview { background: #fff; padding: 90px 0; }
.bap-it .program-overview .container { max-width: 1140px; margin: 0 auto; padding: 0 15px; }
.bap-it .overview-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 48px;
    align-items: center;
}
.bap-it .overview-visual {
    position: relative;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 20px 50px rgba(26, 54, 93, 0.15);
}
.bap-it .overview-visual img {
    width: 100%;
    height: auto;
    display: block;
    vertical-align: middle;
}
.bap-it .overview-kicker {
    font-size: 0.85rem;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: #3a49a9;
    margin-bottom: 12px;
}
.bap-it .overview-text h2 {
    color: #1a365d;
    font-size: clamp(1.5rem, 2.5vw, 2rem);
    font-weight: 700;
    line-height: 1.25;
    margin-bottom: 18px;
}
.bap-it .overview-text p {
    color: #4a5568;
    font-size: 1.05rem;
    line-height: 1.85;
    margin-bottom: 16px;
}
.bap-it .overview-text p:last-child { margin-bottom: 0; }

.bap-it .who-section {
    background: linear-gradient(180deg, #f0f4ff 0%, #f8fafc 100%);
    padding: 90px 0;
}
.bap-it .who-section .container { max-width: 1140px; margin: 0 auto; padding: 0 15px; }
.bap-it .section-head {
    text-align: center;
    max-width: 720px;
    margin: 0 auto 52px;
}
.bap-it .section-head h2 {
    font-size: clamp(1.6rem, 2.5vw, 2.15rem);
    font-weight: 700;
    color: #1a365d;
    margin-bottom: 12px;
}
.bap-it .cards-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 22px;
}
.bap-it .audience-card {
    background: #fff;
    border-radius: 12px;
    padding: 26px 24px;
    border-top: 4px solid #3a49a9;
    box-shadow: 0 8px 28px rgba(26, 54, 93, 0.08);
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}
.bap-it .audience-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 40px rgba(26, 54, 93, 0.12);
}
.bap-it .audience-card h3 {
    font-size: 1.05rem;
    font-weight: 700;
    color: #1a365d;
    margin-bottom: 12px;
    line-height: 1.35;
}
.bap-it .audience-card p {
    color: #4a5568;
    font-size: 0.95rem;
    line-height: 1.7;
    margin: 0;
}

.bap-it .story-section {
    background: #fff;
    padding: 80px 0;
}
.bap-it .story-section .container { max-width: 800px; margin: 0 auto; padding: 0 15px; }
.bap-it .story-section p {
    color: #2d3748;
    font-size: 1.1rem;
    line-height: 1.9;
    text-align: center;
}

/* ── Program detail blocks (clean, on-brand with other program pages) ── */
.bap-it .bap-suite-title {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: clamp(1.65rem, 2.6vw, 2.2rem);
    font-weight: 700;
    color: #99138a;
    text-align: center;
    margin-bottom: 0;
    padding-bottom: 18px;
    position: relative;
}
.bap-it .bap-suite-title::after {
    content: '';
    position: absolute;
    left: 50%;
    bottom: 0;
    transform: translateX(-50%);
    width: 72px;
    height: 4px;
    background: linear-gradient(90deg, #99138a, #6a0dad);
    border-radius: 2px;
}
.bap-it .bap-suite-lead {
    text-align: center;
    color: #5c6578;
    font-size: 1.02rem;
    line-height: 1.65;
    max-width: 620px;
    margin: 20px auto 0;
}

.bap-it .bap-block { padding: 80px 0; }
.bap-it .bap-block--muted { background: #f8f9fb; }

.bap-it .bap-clean-card {
    height: 100%;
    background: #fff;
    border: 1px solid #e8e8ef;
    border-radius: 12px;
    border-top: 4px solid #99138a;
    padding: 22px 24px;
    box-shadow: 0 6px 24px rgba(0, 0, 0, 0.04);
    transition: box-shadow 0.25s ease, transform 0.25s ease;
}
.bap-it .bap-clean-card:hover {
    box-shadow: 0 12px 32px rgba(153, 19, 138, 0.1);
    transform: translateY(-2px);
}
.bap-it .bap-clean-card p {
    margin: 0;
    color: #3d4a5c;
    font-size: 1rem;
    line-height: 1.7;
}

.bap-it .bap-step-card {
    height: 100%;
    background: #fff;
    border: 1px solid #e8e8ef;
    border-radius: 12px;
    padding: 24px 18px;
    text-align: center;
    box-shadow: 0 6px 24px rgba(0, 0, 0, 0.04);
    transition: box-shadow 0.25s ease, transform 0.25s ease;
}
.bap-it .bap-step-card:hover {
    box-shadow: 0 12px 32px rgba(58, 73, 169, 0.12);
    transform: translateY(-3px);
}
.bap-it .bap-step-num {
    width: 44px;
    height: 44px;
    margin: 0 auto 14px;
    border-radius: 50%;
    background: linear-gradient(135deg, #99138a 0%, #6a0dad 100%);
    color: #fff;
    font-weight: 700;
    font-size: 1.15rem;
    display: flex;
    align-items: center;
    justify-content: center;
}
.bap-it .bap-step-card p {
    margin: 0;
    color: #3d4a5c;
    font-size: 0.95rem;
    line-height: 1.65;
}

.bap-it .bap-focus-item {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    height: 100%;
    background: #fff;
    border: 1px solid #e8e8ef;
    border-radius: 12px;
    padding: 18px 20px;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.03);
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}
.bap-it .bap-focus-item:hover {
    border-color: rgba(153, 19, 138, 0.35);
    box-shadow: 0 8px 28px rgba(153, 19, 138, 0.08);
}
.bap-it .bap-focus-item i {
    color: #99138a;
    font-size: 1.1rem;
    margin-top: 3px;
    flex-shrink: 0;
}
.bap-it .bap-focus-item span {
    color: #3d4a5c;
    font-size: 0.98rem;
    line-height: 1.6;
    font-weight: 500;
}

.bap-it .cta-strip {
    background: linear-gradient(135deg, #1a1a2e 0%, #2d1b3d 55%, #1e3a5f 100%);
    padding: 72px 0;
    text-align: center;
}
.bap-it .cta-strip .container { max-width: 800px; margin: 0 auto; padding: 0 15px; }
.bap-it .cta-strip p {
    color: rgba(255,255,255,0.95);
    font-size: clamp(1.05rem, 2vw, 1.25rem);
    line-height: 1.65;
    font-weight: 500;
    margin: 0 0 28px;
}
.bap-it .cta-strip .btn-cta {
    display: inline-block;
    background: #fff;
    color: #1a365d;
    font-weight: 700;
    padding: 14px 36px;
    border-radius: 30px;
    text-decoration: none;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    box-shadow: 0 8px 24px rgba(0,0,0,0.2);
    border: none;
    cursor: pointer;
    font-size: 1rem;
}
.bap-it .cta-strip .btn-cta:hover {
    transform: translateY(-2px);
    color: #1a365d;
    box-shadow: 0 12px 32px rgba(0,0,0,0.25);
}

@media (max-width: 992px) {
    .bap-it .overview-grid { grid-template-columns: 1fr; gap: 36px; }
    .bap-it .cards-grid { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 640px) {
    .bap-it .cards-grid { grid-template-columns: 1fr; }
    .bap-it .program-overview, .bap-it .who-section, .bap-it .bap-block { padding: 56px 0; }
}
</style>

<div class="bap-it">

<section class="page-hero">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-10">
                <h1 class="page-title">Business Accelerator Program for IT &amp; Technology Companies</h1>
                <p class="page-subtitle">Strengthen commercial, consultative, and delivery capabilities to scale AI, Cloud, Cybersecurity, and digital solutions with confidence.</p>
            </div>
        </div>
    </div>
</section>

<section class="program-overview">
    <div class="container">
        <div class="overview-grid">
            <div class="overview-visual">
                <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=900&q=80" alt="Technology business team collaboration">
            </div>
            <div class="overview-text">
                <p class="overview-kicker">Who it serves</p>
                <h2>Business Accelerator Program for IT Systems Integrators, Tech Product Companies, IT Services, IT Distributors &amp; ISVs</h2>
                <p>We help technology businesses strengthen sales, presales, consulting, delivery, partner growth, and customer-facing teams to scale AI, Cloud, Cybersecurity, Infrastructure, and Digital solutions more effectively.</p>
            </div>
        </div>
    </div>
</section>

<section class="who-section">
    <div class="container">
        <div class="section-head">
            <h2>Who This Program Is For</h2>
        </div>
        <div class="cards-grid">
            <article class="audience-card">
                <h3>IT Systems Integrators</h3>
                <p>Care about solution selling, OEM alignment, account growth, managed services expansion, and consultative selling.</p>
            </article>
            <article class="audience-card">
                <h3>Software product companies</h3>
                <p>Selling AI, Cloud, or Cybersecurity—care about product positioning, customer use cases, demo-to-decision conversion, enterprise sales readiness, and customer success-led expansion.</p>
            </article>
            <article class="audience-card">
                <h3>IT Services firms</h3>
                <p>Care about service differentiation, delivery-to-growth alignment, mining existing accounts, and moving from staff augmentation to higher-value consulting conversations.</p>
            </article>
            <article class="audience-card">
                <h3>IT Distributors</h3>
                <p>Care about partner enablement, vendor growth plans, channel activation, and value-added service-led revenue.</p>
            </article>
            <article class="audience-card">
                <h3>ISVs (Independent Software Vendors)</h3>
                <p>Care about market positioning, GTM execution, enterprise conversations, partner ecosystem leverage, and repeatable sales playbooks.</p>
            </article>
            <article class="audience-card">
                <h3>Teams scaling new solution lines</h3>
                <p>Care about commercializing AI, Cloud, Cybersecurity, FinOps, observability, and managed services—moving from pilots to repeatable revenue and stronger account expansion.</p>
            </article>
        </div>
    </div>
</section>

<section class="story-section">
    <div class="container">
        <p>Many technology companies have strong products, services, or partnerships, but struggle to convert technical capability into predictable business growth. <strong>ELEVATES</strong> helps build the commercial, consultative, and execution capabilities needed to grow revenue, strengthen customer relationships, and scale with confidence.</p>
    </div>
</section>

<section class="bap-block" aria-labelledby="bap-problems-title">
    <div class="container">
        <h2 id="bap-problems-title" class="bap-suite-title">Typical Business Problems We Solve</h2>
        <p class="bap-suite-lead">When the commercial engine does not keep pace with your technical strengths, these patterns show up again and again.</p>
        <div class="row g-4 mt-2 mt-lg-4">
            <div class="col-md-6">
                <div class="bap-clean-card"><p>Teams sell products, not business outcomes.</p></div>
            </div>
            <div class="col-md-6">
                <div class="bap-clean-card"><p>Presales and sales are not aligned in customer conversations.</p></div>
            </div>
            <div class="col-md-6">
                <div class="bap-clean-card"><p>Existing accounts are under-leveraged for cross-sell and upsell.</p></div>
            </div>
            <div class="col-md-6">
                <div class="bap-clean-card"><p>New solution areas like FinOps, observability, cloud, AI, and cybersecurity are not being commercialized effectively.</p></div>
            </div>
            <div class="col-12">
                <div class="bap-clean-card"><p>Managers lack a structured review and coaching system to improve performance.</p></div>
            </div>
        </div>
    </div>
</section>

<section class="bap-block bap-block--muted" aria-labelledby="bap-covers-title">
    <div class="container">
        <h2 id="bap-covers-title" class="bap-suite-title">What the Program Covers</h2>
        <p class="bap-suite-lead">A clear sequence from diagnosis to sustained performance—not a one-off workshop.</p>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-5 g-3 mt-2 mt-lg-4">
            <div class="col">
                <div class="bap-step-card">
                    <div class="bap-step-num">1</div>
                    <p>Business and capability assessment.</p>
                </div>
            </div>
            <div class="col">
                <div class="bap-step-card">
                    <div class="bap-step-num">2</div>
                    <p>Gap analysis across people, process, sales, presales, and business growth.</p>
                </div>
            </div>
            <div class="col">
                <div class="bap-step-card">
                    <div class="bap-step-num">3</div>
                    <p>Custom learning and mentoring roadmap.</p>
                </div>
            </div>
            <div class="col">
                <div class="bap-step-card">
                    <div class="bap-step-num">4</div>
                    <p>Role-based intervention for leadership, managers, sales, presales, delivery, and customer-facing teams.</p>
                </div>
            </div>
            <div class="col">
                <div class="bap-step-card">
                    <div class="bap-step-num">5</div>
                    <p>Review mechanisms, KPIs, and success measurement.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bap-block" aria-labelledby="bap-focus-title">
    <div class="container">
        <h2 id="bap-focus-title" class="bap-suite-title">Possible Focus Areas</h2>
        <p class="bap-suite-lead">We prioritise what your teams need most—depth and format are tailored to your context.</p>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3 mt-2 mt-lg-4">
            <div class="col">
                <div class="bap-focus-item"><i class="fas fa-check" aria-hidden="true"></i><span>Value selling and consultative selling.</span></div>
            </div>
            <div class="col">
                <div class="bap-focus-item"><i class="fas fa-check" aria-hidden="true"></i><span>Account planning.</span></div>
            </div>
            <div class="col">
                <div class="bap-focus-item"><i class="fas fa-check" aria-hidden="true"></i><span>Presales effectiveness and solution articulation.</span></div>
            </div>
            <div class="col">
                <div class="bap-focus-item"><i class="fas fa-check" aria-hidden="true"></i><span>Winning demonstrations &amp; POC.</span></div>
            </div>
            <div class="col">
                <div class="bap-focus-item"><i class="fas fa-check" aria-hidden="true"></i><span>Impactful whiteboarding.</span></div>
            </div>
            <div class="col">
                <div class="bap-focus-item"><i class="fas fa-check" aria-hidden="true"></i><span>Cross-sell and upsell strategy.</span></div>
            </div>
            <div class="col">
                <div class="bap-focus-item"><i class="fas fa-check" aria-hidden="true"></i><span>GTM for AI, Cloud, Cybersecurity, managed services, and new solution lines.</span></div>
            </div>
            <div class="col">
                <div class="bap-focus-item"><i class="fas fa-check" aria-hidden="true"></i><span>Partner and OEM-led growth enablement.</span></div>
            </div>
            <div class="col">
                <div class="bap-focus-item"><i class="fas fa-check" aria-hidden="true"></i><span>Customer success and retention.</span></div>
            </div>
        </div>
    </div>
</section>

<section class="cta-strip">
    <div class="container">
        <p>Talk to us about a custom accelerator for your sales, presales, delivery, leadership, or partner teams.</p>
        <a class="btn-cta" onclick="openDiscoveryPopup(); return false;" href="#">Book a discovery session</a>
    </div>
</section>

</div>

<?php include 'footer.php'; ?>
