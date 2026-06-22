<?php include 'header.php'; ?>

<?php
$teamMembers = [
    [
        'name' => 'ABHINAV JOHARI',
        'title' => 'Founder & Chief Growth Officer & Value Selling Coach & Mentor',
        'image' => 'team/Abhinav Johari.png',
    ],
    [
        'name' => 'PURSHOTTAM NIGAM',
        'title' => 'Founder & Chief Business Officer & Value Selling Coach & Mentor',
        'image' => 'team/Purshottam Nigam.jpeg',
    ],
    [
        'name' => 'Vimmi Gupta',
        'title' => 'Honorary Executive Advisor & Executive Leadership Coach & Mentor',
        'image' => 'team/Vimmi Gupta.jpeg',
    ],
    [
        'name' => 'Versha Sharma',
        'title' => 'Honorary Executive Advisor - Personality Development & Communications Coach & Mentor',
        'image' => 'team/Versha Sharma.jpeg',
    ],
    [
        'name' => 'Ruchika Goyal',
        'title' => 'Honorary Executive Advisor - Business English & Communication Coach & Mentor',
        'image' => 'team/Ruchika Goyal.jpeg',
    ],
    [
        'name' => 'Sakshi Vyas',
        'title' => 'Honorary Executive Advisor - Value Selling Coach & Mentor',
        'image' => 'team/Sakshi Vyas.jpeg',
    ],
    [
        'name' => 'Pushkar Bisht',
        'title' => 'Honorary Executive Advisor - Value Selling Coach & Mentor',
        'image' => 'team/Puskar Bisht.jpeg',
    ],
    [
        'name' => 'Anuraj Tyagi',
        'title' => 'Honorary Executive Advisor - AI Coach & Mentor',
        'image' => 'team/Anuraj tyagi.jpeg',
    ],
    [
        'name' => 'Deependra Chokkasamudra',
        'title' => 'Executive Advisor - PDP & Communications Coach & Mentor',
        'image' => 'team/Deependra Chokkasamudra.jpeg',
    ],
    [
        'name' => 'Kamya Jain',
        'title' => 'Honorary Executive Consultant, PDP & Mental Wellness Coach and Mentor',
        'image' => 'team/Kamya Jain.jpeg',
    ],
    [
        'name' => 'Parth Joshi',
        'title' => 'Honorary Executive Advisor - Leadership Coach & Mentor',
        'image' => 'team/Parth Joshi.jpeg',
    ],
    [
        'name' => 'Arpana Khanna',
        'title' => 'Business English Communication Coach & Mentor',
        'image' => 'team/Arpana Khanna.jpeg',
    ],
    [
        'name' => 'Kanav Khanna',
        'title' => 'Honorary Executive Advisor - Cybersecurity Coach & Mentor',
        'image' => 'team/noimg.png',
    ],
];

$mainTeamMembers = array_slice($teamMembers, 0, 2);
$advisorMembers = array_slice($teamMembers, 2);
?>

<section class="page-hero">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h1 class="page-title">Our Team</h1>
                <p class="page-subtitle">Meet the mentors and advisors powering growth for professionals and businesses.</p>
            </div>
        </div>
    </div>
</section>

<section class="our-team-section py-5">
    <div class="container">
        <div class="row justify-content-center text-center mb-4">
            <div class="col-lg-7">
                <h2 class="our-team-section-title">Founders</h2>
            </div>
        </div>
        <div class="row g-4 justify-content-center mb-5">
            <?php foreach ($mainTeamMembers as $member): ?>
                <?php
                $memberImage = trim($member['image']) !== '' ? $member['image'] : 'founder.jpeg';
                ?>
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <article class="our-team-card">
                        <div class="our-team-image-wrap">
                            <img
                                src="<?php echo htmlspecialchars($memberImage); ?>"
                                alt="<?php echo htmlspecialchars($member['name']); ?>"
                                class="our-team-image our-team-image-founder"
                                loading="lazy"
                                onerror="this.onerror=null;this.src='founder.jpeg';"
                            >
                        </div>
                        <div class="our-team-body">
                            <h3 class="our-team-name"><?php echo htmlspecialchars($member['name']); ?></h3>
                            <p class="our-team-role"><?php echo htmlspecialchars($member['title']); ?></p>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="row justify-content-center text-center mb-4">
            <div class="col-lg-8">
                <h2 class="our-team-section-title">Advisors & Mentors</h2>
            </div>
        </div>
        <div class="row g-4">
            <?php foreach ($advisorMembers as $member): ?>
                <?php
                $memberImage = trim($member['image']) !== '' ? $member['image'] : 'founder.jpeg';
                ?>
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <article class="our-team-card">
                        <div class="our-team-image-wrap">
                            <img
                                src="<?php echo htmlspecialchars($memberImage); ?>"
                                alt="<?php echo htmlspecialchars($member['name']); ?>"
                                class="our-team-image"
                                loading="lazy"
                                onerror="this.onerror=null;this.src='founder.jpeg';"
                            >
                        </div>
                        <div class="our-team-body">
                            <h3 class="our-team-name"><?php echo htmlspecialchars($member['name']); ?></h3>
                            <p class="our-team-role"><?php echo htmlspecialchars($member['title']); ?></p>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<style>
    .our-team-section {
        background: #f9f8fc;
    }

    .our-team-section-title {
        font-size: 2rem;
        font-weight: 700;
        color: #251046;
        margin-bottom: 0;
        font-family: 'Playfair Display', serif;
    }

    .our-team-card {
        height: 100%;
        background: #fff;
        border: 1px solid #ece8f6;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 10px 24px rgba(25, 14, 63, 0.08);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .our-team-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 34px rgba(25, 14, 63, 0.14);
    }

    .our-team-image-wrap {
        width: 100%;
        aspect-ratio: 1 / 1;
        background: #eee;
    }

    .our-team-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        display: block;
    }

    .our-team-image-founder {
        object-position: top center;
    }

    .our-team-body {
        padding: 18px 16px 20px;
    }

    .our-team-name {
        font-size: 1.08rem;
        font-weight: 700;
        color: #251046;
        margin-bottom: 8px;
        line-height: 1.3;
        text-transform: uppercase;
    }

    .our-team-role {
        margin: 0;
        color: #5f5b6b;
        font-size: 0.92rem;
        line-height: 1.5;
    }

    @media (max-width: 767.98px) {
        .our-team-section-title {
            font-size: 1.6rem;
        }

        .our-team-body {
            padding: 16px 14px 18px;
        }

        .our-team-name {
            font-size: 1rem;
        }

        .our-team-role {
            font-size: 0.88rem;
        }
    }
</style>

<?php include 'footer.php'; ?>
