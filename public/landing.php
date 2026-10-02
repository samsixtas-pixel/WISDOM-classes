<?php
declare(strict_types=1);
require __DIR__ . '/../config/bootstrap.php';
use Wisdom\Core\Guard;

if (Guard::user() !== null) {
    redirect('dashboard.php');
}

$pageTitle = 'CPSP Examination Preparation | Professional Development I & II';
$pageDesc = 'WISDOM BLENDED CLASSES — Executive preparation for the Certified Procurement and Supplies Professional (CPSP) qualification. Blended learning in Dar es Salaam, Tanzania.';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#0a2440">
    <meta name="description" content="<?= htmlspecialchars($pageDesc, ENT_QUOTES, 'UTF-8') ?>">
    <meta name="keywords" content="CPSP, Certified Procurement and Supplies Professional, PD I, PD II, Procurement examination, Supply Chain Tanzania, Kurasini, Wisdom Blended Classes">
    <meta name="author" content="Wisdom Blended Classes">
    <meta name="robots" content="index, follow">

    <!-- Open Graph & Social Cards -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="WISDOM BLENDED CLASSES — CPSP Examination Preparation">
    <meta property="og:description" content="Structured academic guidance and blended revision for CPSP PD I & PD II candidates.">
    <meta property="og:image" content="images/logo.jpeg">
    <meta property="og:url" content="https://wisdomclasses.co.tz/landing.php">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="WISDOM BLENDED CLASSES — CPSP Examination Preparation">
    <meta name="twitter:description" content="Learn. Think. Grow. Premier CPSP Examination Preparation.">
    <meta name="twitter:image" content="images/logo.jpeg">

    <!-- Structured Data (JSON-LD) for Search Engine Rich Cards -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "EducationalOrganization",
      "name": "WISDOM BLENDED CLASSES",
      "slogan": "Learn. Think. Grow.",
      "description": "Professional CPSP examination preparation providing blended physical and digital instruction.",
      "url": "https://wisdomclasses.co.tz",
      "logo": "https://wisdomclasses.co.tz/images/logo.jpeg",
      "telephone": ["+255772382320", "+255673266852"],
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Kurasini",
        "addressLocality": "Dar es Salaam",
        "addressCountry": "TZ"
      },
      "hasOfferCatalog": {
        "@type": "OfferCatalog",
        "name": "CPSP Preparation Programmes",
        "itemListElement": [
          {
            "@type": "Course",
            "name": "CPSP Professional Development I (PD I)",
            "description": "Core foundation in procurement principles, organizational processes, contract management, and supply chain operations."
          },
          {
            "@type": "Course",
            "name": "CPSP Professional Development II (PD II)",
            "description": "Advanced strategic procurement competencies, decision-making, and case study problem solving."
          }
        ]
      }
    }
    </script>

    <!-- FAQ Structured Data for Google Rich Snippets -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "FAQPage",
      "mainEntity": [
        {
          "@type": "Question",
          "name": "Who can join Wisdom Blended Classes?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Any candidate pursuing CPSP PD I or CPSP PD II may enrol in our classes."
          }
        },
        {
          "@type": "Question",
          "name": "Are classes offered online?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Yes. We offer both online and physical learning options."
          }
        },
        {
          "@type": "Question",
          "name": "Where are physical classes conducted?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Physical classes are conducted at Kurasini, Dar es Salaam."
          }
        },
        {
          "@type": "Question",
          "name": "Can working professionals attend?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Yes. Our blended learning model is specifically designed to accommodate working professionals."
          }
        },
        {
          "@type": "Question",
          "name": "Do you focus on examination preparation?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Yes. Our programmes are specifically structured to support candidates preparing for CPSP professional examinations."
          }
        }
      ]
    }
    </script>

    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?> · WISDOM</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/wisdom.css">

    <style>
        :root {
            --w-navy-950: #04101d;
            --w-navy-900: #061a2c;
            --w-navy-800: #0a2440;
            --w-navy-700: #0d2b45;
            --w-navy-600: #173b5e;
            --w-gold-600: #c9a227;
            --w-gold-500: #d4af37;
            --w-gold-400: #e2c65a;
            --w-gold-200: #f4e5b3;
            --w-gold-100: #fbf7ee;
            --w-gold-gradient: linear-gradient(135deg, #d4af37 0%, #c9a227 50%, #9a7610 100%);
            --w-surface: #ffffff;
            --w-paper: #f9f8f5;
            --w-line: #e6e2d8;
            --w-line-subtle: #f0ece3;
            --w-ink-900: #0e1520;
            --w-ink-700: #2d3748;
            --w-ink-500: #64748b;
            --w-ink-400: #94a3b8;
            --shadow-subtle: 0 1px 3px rgba(10,36,64,0.04), 0 4px 12px rgba(10,36,64,0.03);
            --shadow-hover: 0 12px 28px rgba(10,36,64,0.08), 0 2px 4px rgba(10,36,64,0.03);
            --shadow-card: 0 4px 18px rgba(6,26,44,0.05);
            --radius-md: 10px;
            --radius-lg: 16px;
            --radius-xl: 20px;
        }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 80px;
        }

        body {
            background-color: #faf9f6;
            color: var(--w-ink-900);
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        /* -------------------------------------------------------------
           READING / SCROLL PROGRESS BAR (Executive Micro-Interaction)
           ------------------------------------------------------------- */
        .w-scroll-progress {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            background: var(--w-gold-gradient);
            width: 0%;
            z-index: 10000;
            transition: width 0.1s linear;
        }

        /* -------------------------------------------------------------
           NAVIGATION BAR
           ------------------------------------------------------------- */
        .w-nav {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--w-line);
            transition: background 0.25s ease, box-shadow 0.25s ease;
        }

        .w-nav.scrolled {
            box-shadow: 0 4px 20px rgba(6, 26, 44, 0.06);
        }

        .w-nav__container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 12px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .w-nav__logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .w-nav__logo-img {
            width: 42px;
            height: 42px;
            border-radius: 8px;
            object-fit: cover;
            border: 1.5px solid var(--w-gold-600);
            flex-shrink: 0;
        }

        .w-nav__brand-title {
            font-size: 1.05rem;
            font-weight: 800;
            letter-spacing: 0.02em;
            color: var(--w-navy-900);
            display: block;
            line-height: 1.15;
        }

        .w-nav__brand-sub {
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.14em;
            color: var(--w-gold-600);
            text-transform: uppercase;
            display: block;
        }

        .w-nav__menu {
            display: flex;
            align-items: center;
            gap: 24px;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .w-nav__link {
            color: var(--w-ink-700);
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            position: relative;
            padding: 6px 0;
            transition: color 0.2s ease;
        }

        .w-nav__link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--w-gold-600);
            transition: width 0.25s ease;
        }

        .w-nav__link:hover {
            color: var(--w-navy-900);
            text-decoration: none;
        }

        .w-nav__link:hover::after {
            width: 100%;
        }

        .w-nav__actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* -------------------------------------------------------------
           SYSTEM BUTTONS & ICONS (Precision Micro-Interactions)
           ------------------------------------------------------------- */
        .w-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 0.88rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            border: 1px solid transparent;
            transition: transform 0.2s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.2s ease, background 0.2s ease, border-color 0.2s ease;
        }

        .w-btn:hover {
            transform: translateY(-2px);
            text-decoration: none;
        }

        .w-btn:active {
            transform: translateY(0);
        }

        .w-btn--gold {
            background: var(--w-gold-600);
            color: #ffffff;
            box-shadow: 0 2px 6px rgba(201, 162, 39, 0.25);
        }

        .w-btn--gold:hover {
            background: #b58f1f;
            box-shadow: 0 4px 14px rgba(201, 162, 39, 0.35);
            color: #ffffff;
        }

        .w-btn--ghost {
            background: transparent;
            color: var(--w-navy-800);
            border-color: var(--w-line);
        }

        .w-btn--ghost:hover {
            background: var(--w-paper);
            border-color: var(--w-navy-600);
            color: var(--w-navy-900);
        }

        .w-btn--navy {
            background: var(--w-navy-800);
            color: #ffffff;
        }

        .w-btn--navy:hover {
            background: var(--w-navy-900);
            color: #ffffff;
            box-shadow: 0 4px 16px rgba(10, 36, 64, 0.2);
        }

        .w-icon {
            width: 18px;
            height: 18px;
            display: inline-block;
            flex-shrink: 0;
            vertical-align: middle;
        }

        .w-icon-lg {
            width: 22px;
            height: 22px;
        }

        /* Mobile Hamburger */
        .w-nav__toggle {
            display: none;
            background: transparent;
            border: 0;
            padding: 6px;
            cursor: pointer;
            color: var(--w-navy-800);
            border-radius: 6px;
        }

        .w-nav__toggle:hover {
            background: var(--w-paper);
        }

        /* -------------------------------------------------------------
           HERO SECTION: Grounded, Clean, High Authority
           ------------------------------------------------------------- */
        .w-hero {
            padding: 64px 24px 72px;
            background: linear-gradient(180deg, #f5f3ec 0%, #faf9f6 100%);
            border-bottom: 1px solid var(--w-line-subtle);
        }

        .w-hero__container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1.15fr 0.85fr;
            align-items: center;
            gap: 48px;
        }

        .w-hero__pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 5px 14px;
            background: #ffffff;
            border: 1px solid var(--w-line);
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--w-navy-800);
            margin-bottom: 18px;
            box-shadow: var(--shadow-subtle);
        }

        .w-pill-indicator {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--w-gold-600);
        }

        .w-hero__title {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: clamp(2.3rem, 3.8vw, 3.4rem);
            font-weight: 700;
            color: var(--w-navy-900);
            line-height: 1.16;
            margin: 0 0 14px;
            letter-spacing: -0.015em;
        }

        .w-hero__motto {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--w-gold-600);
            letter-spacing: 0.14em;
            text-transform: uppercase;
            margin-bottom: 18px;
        }

        .w-hero__lead {
            font-size: 1.05rem;
            line-height: 1.68;
            color: var(--w-ink-700);
            margin-bottom: 28px;
            max-width: 580px;
        }

        .w-hero__actions {
            display: flex;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
            margin-bottom: 36px;
        }

        .w-hero__metrics {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            padding-top: 24px;
            border-top: 1px solid var(--w-line);
        }

        .w-metric__num {
            display: block;
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--w-navy-900);
            font-family: 'Playfair Display', serif;
        }

        .w-metric__label {
            font-size: 0.78rem;
            color: var(--w-ink-500);
            font-weight: 600;
        }

        /* Clean Hero Photo Frame */
        .w-hero__media {
            position: relative;
        }

        .w-hero__media-frame {
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: 0 16px 36px rgba(10, 36, 64, 0.08);
            border: 1px solid var(--w-line);
            background: #ffffff;
        }

        .w-hero__media-frame img {
            width: 100%;
            height: 380px;
            object-fit: cover;
            display: block;
        }

        .w-hero__caption-bar {
            padding: 14px 18px;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-top: 1px solid var(--w-line);
        }

        .w-caption-title {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--w-navy-900);
        }

        .w-caption-sub {
            font-size: 0.75rem;
            color: var(--w-ink-500);
        }

        /* -------------------------------------------------------------
           SECTIONS & LAYOUT ARCHITECTURE
           ------------------------------------------------------------- */
        .w-section {
            padding: 80px 24px;
        }

        .w-section--surface {
            background-color: #ffffff;
            border-top: 1px solid var(--w-line-subtle);
            border-bottom: 1px solid var(--w-line-subtle);
        }

        .w-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .w-section-header {
            max-width: 680px;
            margin: 0 auto 48px;
            text-align: center;
        }

        .w-eyebrow {
            display: inline-block;
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: var(--w-gold-600);
            margin-bottom: 8px;
        }

        .w-heading {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: clamp(1.85rem, 3vw, 2.4rem);
            font-weight: 700;
            color: var(--w-navy-900);
            line-height: 1.22;
            margin: 0 0 12px;
        }

        .w-section-desc {
            font-size: 0.98rem;
            color: var(--w-ink-500);
            margin: 0;
            line-height: 1.6;
        }

        /* -------------------------------------------------------------
           ABOUT US: Focused 2-Column Split
           ------------------------------------------------------------- */
        .w-about-grid {
            display: grid;
            grid-template-columns: 1fr 1.05fr;
            gap: 48px;
            align-items: center;
        }

        .w-about-media {
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-card);
            border: 1px solid var(--w-line);
        }

        .w-about-media img {
            width: 100%;
            height: 400px;
            object-fit: cover;
            display: block;
        }

        .w-about-copy p {
            font-size: 0.98rem;
            color: var(--w-ink-700);
            margin-bottom: 18px;
        }

        .w-check-list {
            list-style: none;
            padding: 0;
            margin: 24px 0 0;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .w-check-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--w-navy-900);
        }

        .w-check-icon {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: var(--w-gold-100);
            color: var(--w-gold-600);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* -------------------------------------------------------------
           PROGRAMMES: Precision Comparison Cards
           ------------------------------------------------------------- */
        .w-program-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 28px;
        }

        .w-program-card {
            background: #ffffff;
            border: 1px solid var(--w-line);
            border-radius: var(--radius-lg);
            padding: 36px 32px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: var(--shadow-subtle);
            transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.25s ease, border-color 0.25s ease;
            position: relative;
        }

        .w-program-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-hover);
            border-color: var(--w-gold-600);
        }

        .w-card-badge {
            display: inline-block;
            align-self: flex-start;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-bottom: 16px;
            background: var(--w-paper);
            color: var(--w-navy-800);
            border: 1px solid var(--w-line);
        }

        .w-program-card h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.45rem;
            color: var(--w-navy-900);
            margin: 0 0 10px;
        }

        .w-program-card p {
            font-size: 0.92rem;
            color: var(--w-ink-700);
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .w-outcome-list {
            list-style: none;
            padding: 0;
            margin: 0 0 28px;
            border-top: 1px solid var(--w-line-subtle);
            padding-top: 18px;
        }

        .w-outcome-list li {
            position: relative;
            padding: 6px 0 6px 24px;
            font-size: 0.88rem;
            color: var(--w-ink-700);
            line-height: 1.5;
        }

        .w-outcome-list li::before {
            content: '';
            position: absolute;
            left: 0;
            top: 12px;
            width: 14px;
            height: 2px;
            background: var(--w-gold-600);
        }

        /* -------------------------------------------------------------
           LEARNING APPROACH: 3-Pillar Cards
           ------------------------------------------------------------- */
        .w-approach-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .w-approach-card {
            background: #ffffff;
            border: 1px solid var(--w-line);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-subtle);
            transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.25s ease;
        }

        .w-approach-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-hover);
        }

        .w-approach-thumb {
            height: 180px;
            width: 100%;
            object-fit: cover;
            display: block;
            border-bottom: 1px solid var(--w-line-subtle);
        }

        .w-approach-body {
            padding: 24px 22px;
        }

        .w-approach-card h3 {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--w-navy-900);
            margin: 0 0 10px;
        }

        .w-approach-card p {
            font-size: 0.9rem;
            color: var(--w-ink-500);
            margin: 0;
            line-height: 1.55;
        }

        /* -------------------------------------------------------------
           WHY CHOOSE US: Clearly Visible Neomorphic Cards & Well-Defined Depth
           ------------------------------------------------------------- */
        .w-section--neomorphic {
            background: #ebe6dc;
            border-top: 1px solid #ded8cb;
            border-bottom: 1px solid #ded8cb;
        }

        .w-features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 28px;
        }

        .w-feature-tile {
            background: #ebe6dc;
            border-radius: 18px;
            padding: 28px 24px;
            border: 1px solid rgba(255, 255, 255, 0.45);
            /* Clearly visible authentic neomorphic dual light & shadow embossing */
            box-shadow:
                9px 9px 20px rgba(175, 168, 155, 0.72),
                -9px -9px 20px rgba(255, 255, 255, 0.95);
            transition: transform 0.26s cubic-bezier(0.16, 1, 0.3, 1),
                        box-shadow 0.26s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
        }

        .w-feature-tile:hover {
            transform: translateY(-4px);
            box-shadow:
                13px 13px 26px rgba(175, 168, 155, 0.85),
                -13px -13px 26px #ffffff;
        }

        /* Concave inset recess for icons */
        .w-tile-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            background: #ebe6dc;
            color: var(--w-gold-600);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 18px;
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow:
                inset 3px 3px 6px rgba(175, 168, 155, 0.65),
                inset -3px -3px 6px rgba(255, 255, 255, 0.95);
            transition: transform 0.2s ease, color 0.2s ease;
        }

        .w-feature-tile:hover .w-tile-icon {
            color: var(--w-navy-900);
            transform: scale(1.05);
        }

        .w-feature-tile h4 {
            font-size: 1.08rem;
            font-weight: 700;
            color: var(--w-navy-900);
            margin: 0 0 10px;
            letter-spacing: -0.01em;
        }

        .w-feature-tile p {
            font-size: 0.9rem;
            color: var(--w-ink-700);
            margin: 0;
            line-height: 1.6;
        }

        /* -------------------------------------------------------------
           MISSION, VISION & VALUES
           ------------------------------------------------------------- */
        .w-mv-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 40px;
        }

        .w-mv-card {
            background: #ffffff;
            border: 1px solid var(--w-line);
            border-left: 4px solid var(--w-gold-600);
            border-radius: var(--radius-md);
            padding: 28px 24px;
        }

        .w-mv-card h4 {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--w-navy-900);
            margin: 0 0 8px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .w-mv-card p {
            font-size: 0.92rem;
            color: var(--w-ink-700);
            margin: 0;
            line-height: 1.6;
        }

        .w-values-strip {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 16px;
        }

        .w-value-pill {
            background: #ffffff;
            border: 1px solid var(--w-line);
            border-radius: var(--radius-md);
            padding: 18px 14px;
            text-align: center;
            transition: transform 0.2s ease, border-color 0.2s ease;
        }

        .w-value-pill:hover {
            transform: translateY(-2px);
            border-color: var(--w-gold-600);
        }

        .w-value-icon {
            width: 32px;
            height: 32px;
            margin: 0 auto 10px;
            color: var(--w-gold-600);
        }

        .w-value-title {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--w-navy-900);
            margin-bottom: 4px;
        }

        .w-value-desc {
            font-size: 0.78rem;
            color: var(--w-ink-500);
            line-height: 1.4;
        }

        /* -------------------------------------------------------------
           FAQS: Sleek Accessible Accordion
           ------------------------------------------------------------- */
        .w-faq-list {
            max-width: 760px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .w-faq-item {
            background: #ffffff;
            border: 1px solid var(--w-line);
            border-radius: var(--radius-md);
            overflow: hidden;
            transition: border-color 0.2s ease;
        }

        .w-faq-item.active {
            border-color: var(--w-gold-600);
        }

        .w-faq-btn {
            width: 100%;
            text-align: left;
            padding: 18px 20px;
            background: transparent;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            font-size: 0.98rem;
            font-weight: 700;
            color: var(--w-navy-900);
        }

        .w-faq-arrow {
            width: 18px;
            height: 18px;
            color: var(--w-ink-500);
            transition: transform 0.2s ease;
            flex-shrink: 0;
        }

        .w-faq-item.active .w-faq-arrow {
            transform: rotate(180deg);
            color: var(--w-gold-600);
        }

        .w-faq-body {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.25s cubic-bezier(0.16, 1, 0.3, 1), padding 0.25s ease;
            padding: 0 20px;
            background: var(--w-paper);
        }

        .w-faq-item.active .w-faq-body {
            padding: 0 20px 18px;
            max-height: 160px;
        }

        .w-faq-body p {
            margin: 0;
            font-size: 0.92rem;
            color: var(--w-ink-700);
            line-height: 1.55;
        }

        /* -------------------------------------------------------------
           CONTACT SECTION: Executive Direct Info Box
           ------------------------------------------------------------- */
        .w-contact-card {
            background: var(--w-navy-800);
            color: #ffffff;
            border-radius: var(--radius-xl);
            padding: 48px;
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            align-items: center;
            gap: 40px;
            box-shadow: 0 16px 40px rgba(6, 26, 44, 0.16);
        }

        .w-contact-copy h3 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.6rem, 2.5vw, 2.2rem);
            color: #ffffff;
            margin: 0 0 12px;
        }

        .w-contact-copy p {
            color: #c5d3e3;
            font-size: 0.96rem;
            line-height: 1.6;
            margin-bottom: 24px;
        }

        .w-contact-points {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .w-contact-row {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 14px 16px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: var(--radius-md);
            transition: background 0.2s ease;
        }

        .w-contact-row:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .w-contact-point-icon {
            color: var(--w-gold-400);
            flex-shrink: 0;
            margin-top: 2px;
        }

        .w-point-label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--w-gold-400);
            margin-bottom: 2px;
        }

        .w-point-val a, .w-point-val span {
            color: #ffffff;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
        }

        .w-point-val a:hover {
            color: var(--w-gold-200);
            text-decoration: underline;
        }

        /* -------------------------------------------------------------
           FOOTER
           ------------------------------------------------------------- */
        .w-footer {
            background: var(--w-navy-950);
            color: var(--w-ink-400);
            padding: 50px 24px 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .w-footer__container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 40px;
            padding-bottom: 30px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .w-footer__brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .w-footer__brand-title {
            color: #ffffff;
            font-size: 1.05rem;
            font-weight: 700;
        }

        .w-footer__motto {
            color: var(--w-gold-400);
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            margin-bottom: 12px;
        }

        .w-footer__desc {
            font-size: 0.88rem;
            line-height: 1.6;
            max-width: 480px;
            margin: 0;
        }

        .w-footer__links-col h4 {
            color: #ffffff;
            font-size: 0.88rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin: 0 0 14px;
        }

        .w-footer__links {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-wrap: wrap;
            gap: 10px 18px;
        }

        .w-footer__links a {
            color: var(--w-ink-400);
            text-decoration: none;
            font-size: 0.88rem;
            transition: color 0.2s ease;
        }

        .w-footer__links a:hover {
            color: var(--w-gold-400);
        }

        .w-footer__copy {
            max-width: 1200px;
            margin: 20px auto 0;
            text-align: center;
            font-size: 0.82rem;
            color: var(--w-ink-500);
        }

        /* -------------------------------------------------------------
           RESPONSIVE DESIGN (All Screen Breakpoints)
           ------------------------------------------------------------- */
        @media (max-width: 1024px) {
            .w-hero__container {
                grid-template-columns: 1fr;
                gap: 40px;
            }
            .w-hero__media {
                max-width: 600px;
                margin: 0 auto;
            }
            .w-about-grid {
                grid-template-columns: 1fr;
                gap: 36px;
            }
            .w-values-strip {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 860px) {
            .w-nav__menu, .w-nav__actions {
                display: none;
            }
            .w-nav__toggle {
                display: block;
            }
            .w-nav__menu.open {
                display: flex;
                flex-direction: column;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: #ffffff;
                padding: 20px 24px;
                border-top: 1px solid var(--w-line);
                box-shadow: 0 12px 28px rgba(0, 0, 0, 0.08);
                align-items: flex-start;
                gap: 14px;
            }
            .w-program-grid,
            .w-approach-grid,
            .w-features-grid,
            .w-mv-row {
                grid-template-columns: 1fr;
            }
            .w-contact-card {
                grid-template-columns: 1fr;
                padding: 32px 24px;
            }
            .w-footer__container {
                grid-template-columns: 1fr;
                gap: 28px;
            }
            .w-values-strip {
                grid-template-columns: 1fr;
            }
            .w-check-list {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <!-- Reading Progress Bar -->
    <div class="w-scroll-progress" id="wScrollProgress" aria-hidden="true"></div>

    <!-- Navigation Bar -->
    <header>
        <nav class="w-nav" id="wNav" aria-label="Primary navigation">
            <div class="w-nav__container">
                <a href="landing.php" class="w-nav__logo" aria-label="WISDOM BLENDED CLASSES Home">
                    <img src="images/logo.jpeg" alt="WISDOM Logo" class="w-nav__logo-img" width="42" height="42">
                    <div class="w-nav__brand-text">
                        <span class="w-nav__brand-title">WISDOM</span>
                        <span class="w-nav__brand-sub">Blended Classes</span>
                    </div>
                </a>

                <ul class="w-nav__menu" id="wNavMenu">
                    <li><a href="#hero" class="w-nav__link">Home</a></li>
                    <li><a href="#about" class="w-nav__link">About Us</a></li>
                    <li><a href="#programmes" class="w-nav__link">Programmes</a></li>
                    <li><a href="#approach" class="w-nav__link">Learning Approach</a></li>
                    <li><a href="#why-us" class="w-nav__link">Why Choose Us</a></li>
                    <li><a href="#faqs" class="w-nav__link">FAQs</a></li>
                    <li><a href="#contact" class="w-nav__link">Contact</a></li>
                </ul>

                <div class="w-nav__actions">
                    <a href="login.php" class="w-btn w-btn--ghost">Login</a>
                    <a href="register.php" class="w-btn w-btn--gold">Register</a>
                </div>

                <button class="w-nav__toggle" id="wNavToggle" aria-label="Toggle navigation menu" aria-expanded="false">
                    <svg class="w-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </nav>
    </header>

    <main>
        <!-- Hero Section -->
        <section id="hero" class="w-hero">
            <div class="w-hero__container">
                <div class="w-hero__content">
                    <div class="w-hero__pill">
                        <span class="w-pill-indicator"></span>
                        CPSP Professional Examination Support
                    </div>
                    <h1 class="w-hero__title">
                        Professional CPSP Examination Preparation for Future Procurement Leaders
                    </h1>
                    <div class="w-hero__motto">Learn. Think. Grow.</div>
                    <p class="w-hero__lead">
                        WISDOM BLENDED CLASSES provides dedicated academic guidance for candidates pursuing the Certified Procurement and Supplies Professional (CPSP) qualification. We combine structured in-person classes with digital sessions to build examination readiness and professional competence.
                    </p>
                    <div class="w-hero__actions">
                        <a href="register.php" class="w-btn w-btn--gold">
                            <span>Register as Candidate</span>
                            <svg class="w-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"></path>
                            </svg>
                        </a>
                        <a href="login.php" class="w-btn w-btn--ghost">Candidate Sign In</a>
                    </div>
                    <div class="w-hero__metrics">
                        <div>
                            <span class="w-metric__num">PD I &amp; PD II</span>
                            <span class="w-metric__label">Curriculum Levels</span>
                        </div>
                        <div>
                            <span class="w-metric__num">Blended</span>
                            <span class="w-metric__label">Kurasini &amp; Online</span>
                        </div>
                        <div>
                            <span class="w-metric__num">Structured</span>
                            <span class="w-metric__label">Revision &amp; Practice</span>
                        </div>
                    </div>
                </div>

                <div class="w-hero__media">
                    <div class="w-hero__media-frame">
                        <img src="image/blended-classes.jpg" alt="Blended classroom session at WISDOM" width="600" height="380" loading="eager">
                        <div class="w-hero__caption-bar">
                            <div>
                                <div class="w-caption-title">Physical &amp; Online Cohorts</div>
                                <div class="w-caption-sub">Kurasini Centre &amp; Interactive Sessions</div>
                            </div>
                            <span class="w-badge-tag" style="font-size:0.75rem; font-weight:700; color:var(--w-gold-600); text-transform:uppercase; letter-spacing:0.05em;">CPSP Exam Prep</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Us Section -->
        <section id="about" class="w-section">
            <div class="w-container">
                <div class="w-about-grid">
                    <div class="w-about-media">
                        <img src="image/class-online.jpg" alt="Learners engaging in interactive academic discussions" width="560" height="400" loading="lazy">
                    </div>
                    <div class="w-about-copy">
                        <span class="w-eyebrow">About Wisdom Blended Classes</span>
                        <h2 class="w-heading">Who We Are</h2>
                        <p>
                            WISDOM BLENDED CLASSES was founded to provide structured academic mentorship and strategic examination support for professionals pursuing CPSP qualifications.
                        </p>
                        <p>
                            Professional qualifications require practical comprehension, consistent engagement, and targeted examination technique. Our revision sessions and guided discussions empower candidates to master the syllabus with confidence.
                        </p>
                        <ul class="w-check-list">
                            <li class="w-check-item">
                                <span class="w-check-icon">
                                    <svg class="w-icon" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path></svg>
                                </span>
                                Mentorship &amp; Guidance
                            </li>
                            <li class="w-check-item">
                                <span class="w-check-icon">
                                    <svg class="w-icon" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path></svg>
                                </span>
                                Practical Case Examples
                            </li>
                            <li class="w-check-item">
                                <span class="w-check-icon">
                                    <svg class="w-icon" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path></svg>
                                </span>
                                Guided Revision Sessions
                            </li>
                            <li class="w-check-item">
                                <span class="w-check-icon">
                                    <svg class="w-icon" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path></svg>
                                </span>
                                Exam-Oriented Practice
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Our Programmes Section -->
        <section id="programmes" class="w-section w-section--surface">
            <div class="w-container">
                <div class="w-section-header">
                    <span class="w-eyebrow">Our Programmes</span>
                    <h2 class="w-heading">Certified Procurement and Supplies Professional (CPSP)</h2>
                    <p class="w-section-desc">
                        A recognized qualification for procurement and supply chain practitioners seeking career advancement.
                    </p>
                </div>

                <div class="w-program-grid">
                    <!-- PD I -->
                    <article class="w-program-card">
                        <div>
                            <span class="w-card-badge">Foundational &amp; Intermediate</span>
                            <h3>CPSP Professional Development I (PD I)</h3>
                            <p>
                                Introduces core concepts in procurement principles, organizational processes, contract management, supply chain operations, and professional practice.
                            </p>
                            <ul class="w-outcome-list">
                                <li>Understand key procurement principles and regulations.</li>
                                <li>Strengthen analytical problem-solving skills.</li>
                                <li>Refine examination techniques and timing.</li>
                                <li>Participate in guided revision exercises.</li>
                            </ul>
                        </div>
                        <a href="register.php" class="w-btn w-btn--gold" style="width:100%;">Enroll for PD I</a>
                    </article>

                    <!-- PD II -->
                    <article class="w-program-card">
                        <div>
                            <span class="w-card-badge">Advanced Competencies</span>
                            <h3>CPSP Professional Development II (PD II)</h3>
                            <p>
                                Focuses on advanced strategic procurement, analytical decision-making, and practical application within modern supply chain environments.
                            </p>
                            <ul class="w-outcome-list">
                                <li>Master advanced procurement and strategic perspectives.</li>
                                <li>Apply professional concepts to complex case scenarios.</li>
                                <li>Enhance strategic decision-making capabilities.</li>
                                <li>Prepare systematically for CPSP examinations.</li>
                            </ul>
                        </div>
                        <a href="register.php" class="w-btn w-btn--navy" style="width:100%;">Enroll for PD II</a>
                    </article>
                </div>
            </div>
        </section>

        <!-- Our Learning Approach Section -->
        <section id="approach" class="w-section">
            <div class="w-container">
                <div class="w-section-header">
                    <span class="w-eyebrow">Our Learning Approach</span>
                    <h2 class="w-heading">Blended Learning Model</h2>
                    <p class="w-section-desc">
                        Combining face-to-face instruction with online accessibility to fit the schedules of working professionals.
                    </p>
                </div>

                <div class="w-approach-grid">
                    <div class="w-approach-card">
                        <img src="image/blended-classes.jpg" alt="Physical classroom sessions at Kurasini" class="w-approach-thumb" loading="lazy">
                        <div class="w-approach-body">
                            <h3>Physical Sessions</h3>
                            <p>Direct interaction with instructors and candidates at our Kurasini center for face-to-face collaborative discussions.</p>
                        </div>
                    </div>

                    <div class="w-approach-card">
                        <img src="image/online-class.jpg" alt="Online learning sessions" class="w-approach-thumb" loading="lazy">
                        <div class="w-approach-body">
                            <h3>Online Sessions</h3>
                            <p>Remote interactive classes offering flexibility for candidates balancing busy workplace commitments.</p>
                        </div>
                    </div>

                    <div class="w-approach-card">
                        <img src="image/class-online.jpg" alt="Integrated learning experience" class="w-approach-thumb" loading="lazy">
                        <div class="w-approach-body">
                            <h3>Integrated Learning</h3>
                            <p>A blended curriculum ensuring learning continuity, structured revision, and full syllabus coverage.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Why Choose Us Section -->
        <section id="why-us" class="w-section w-section--neomorphic">
            <div class="w-container">
                <div class="w-section-header">
                    <span class="w-eyebrow">Why Choose Us</span>
                    <h2 class="w-heading">Designed for Examination Success</h2>
                    <p class="w-section-desc">Key pillars that make WISDOM the trusted partner for CPSP candidates.</p>
                </div>

                <div class="w-features-grid">
                    <div class="w-feature-tile">
                        <div class="w-tile-icon">
                            <svg class="w-icon-lg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"></path></svg>
                        </div>
                        <h4>Exam-Focused Prep</h4>
                        <p>Curriculum structured directly around CPSP professional examination requirements.</p>
                    </div>

                    <div class="w-feature-tile">
                        <div class="w-tile-icon">
                            <svg class="w-icon-lg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342"></path></svg>
                        </div>
                        <h4>Experienced Instructors</h4>
                        <p>Instruction from mentors who understand academic rigour and procurement practice.</p>
                    </div>

                    <div class="w-feature-tile">
                        <div class="w-tile-icon">
                            <svg class="w-icon-lg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"></path></svg>
                        </div>
                        <h4>Structured Revision</h4>
                        <p>Systematic review sessions designed to reinforce comprehension and retention.</p>
                    </div>

                    <div class="w-feature-tile">
                        <div class="w-tile-icon">
                            <svg class="w-icon-lg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"></path></svg>
                        </div>
                        <h4>Interactive Learning</h4>
                        <p>Active peer discussions, case reviews, and question-and-answer exchanges.</p>
                    </div>

                    <div class="w-feature-tile">
                        <div class="w-tile-icon">
                            <svg class="w-icon-lg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h4>Flexible Study Schedule</h4>
                        <p>Balanced timings that respect the workloads of employed candidates.</p>
                    </div>

                    <div class="w-feature-tile">
                        <div class="w-tile-icon">
                            <svg class="w-icon-lg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941"></path></svg>
                        </div>
                        <h4>Career Growth Focus</h4>
                        <p>Long-term professional capability building beyond single examination cycles.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Mission, Vision & Core Values -->
        <section class="w-section">
            <div class="w-container">
                <div class="w-mv-row">
                    <div class="w-mv-card">
                        <h4>
                            <svg class="w-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"></path></svg>
                            Our Mission
                        </h4>
                        <p>To provide high-quality professional learning support that empowers CPSP candidates to achieve academic excellence, professional competence, and career advancement.</p>
                    </div>

                    <div class="w-mv-card">
                        <h4>
                            <svg class="w-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Our Vision
                        </h4>
                        <p>To become a leading professional learning centre recognized for excellence in procurement education, examination preparation, and professional development.</p>
                    </div>
                </div>

                <div class="w-section-header" style="margin-bottom:28px;">
                    <span class="w-eyebrow">Institutional Standards</span>
                    <h3 class="w-heading" style="font-size:1.8rem;">Core Values</h3>
                </div>

                <div class="w-values-strip">
                    <div class="w-value-pill">
                        <div class="w-value-icon">
                            <svg class="w-icon-lg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"></path></svg>
                        </div>
                        <div class="w-value-title">Excellence</div>
                        <div class="w-value-desc">High teaching and academic support standards.</div>
                    </div>

                    <div class="w-value-pill">
                        <div class="w-value-icon">
                            <svg class="w-icon-lg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0"></path></svg>
                        </div>
                        <div class="w-value-title">Professionalism</div>
                        <div class="w-value-desc">Ethical conduct and continuous accountability.</div>
                    </div>

                    <div class="w-value-pill">
                        <div class="w-value-icon">
                            <svg class="w-icon-lg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"></path></svg>
                        </div>
                        <div class="w-value-title">Integrity</div>
                        <div class="w-value-desc">Honesty, transparency, and trust in all activities.</div>
                    </div>

                    <div class="w-value-pill">
                        <div class="w-value-icon">
                            <svg class="w-icon-lg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.516 0c.85.493 1.508 1.333 1.508 2.316V18"></path></svg>
                        </div>
                        <div class="w-value-title">Innovation</div>
                        <div class="w-value-desc">Embracing modern learning technologies.</div>
                    </div>

                    <div class="w-value-pill">
                        <div class="w-value-icon">
                            <svg class="w-icon-lg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"></path></svg>
                        </div>
                        <div class="w-value-title">Commitment</div>
                        <div class="w-value-desc">Dedicated assistance for candidate progress.</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQs Section -->
        <section id="faqs" class="w-section w-section--surface">
            <div class="w-container">
                <div class="w-section-header">
                    <span class="w-eyebrow">Frequently Asked Questions</span>
                    <h2 class="w-heading">Answers for Prospective Candidates</h2>
                    <p class="w-section-desc">Key information on admissions, study formats, and examination prep.</p>
                </div>

                <div class="w-faq-list">
                    <div class="w-faq-item active">
                        <button class="w-faq-btn" type="button" aria-expanded="true">
                            <span>Who can join Wisdom Blended Classes?</span>
                            <svg class="w-faq-arrow" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path></svg>
                        </button>
                        <div class="w-faq-body">
                            <p>Any candidate pursuing CPSP PD I or CPSP PD II may enrol in our classes.</p>
                        </div>
                    </div>

                    <div class="w-faq-item">
                        <button class="w-faq-btn" type="button" aria-expanded="false">
                            <span>Are classes offered online?</span>
                            <svg class="w-faq-arrow" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path></svg>
                        </button>
                        <div class="w-faq-body">
                            <p>Yes. We offer both online and physical learning options.</p>
                        </div>
                    </div>

                    <div class="w-faq-item">
                        <button class="w-faq-btn" type="button" aria-expanded="false">
                            <span>Where are physical classes conducted?</span>
                            <svg class="w-faq-arrow" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path></svg>
                        </button>
                        <div class="w-faq-body">
                            <p>Physical classes are conducted at Kurasini, Dar es Salaam.</p>
                        </div>
                    </div>

                    <div class="w-faq-item">
                        <button class="w-faq-btn" type="button" aria-expanded="false">
                            <span>Can working professionals attend?</span>
                            <svg class="w-faq-arrow" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path></svg>
                        </button>
                        <div class="w-faq-body">
                            <p>Yes. Our blended learning model is designed to accommodate working professionals.</p>
                        </div>
                    </div>

                    <div class="w-faq-item">
                        <button class="w-faq-btn" type="button" aria-expanded="false">
                            <span>Do you focus on examination preparation?</span>
                            <svg class="w-faq-arrow" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path></svg>
                        </button>
                        <div class="w-faq-body">
                            <p>Yes. Our programmes are specifically structured to support candidates preparing for CPSP professional examinations.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="w-section">
            <div class="w-container">
                <div class="w-contact-card">
                    <div class="w-contact-copy">
                        <span class="w-eyebrow" style="color:var(--w-gold-400);">Contact Us</span>
                        <h3>Begin Your Professional Development Journey Today</h3>
                        <p>Whether you are preparing for CPSP PD I or CPSP PD II, Wisdom Blended Classes is ready to support your examination success and career growth.</p>
                        <div style="display:flex; gap:12px; flex-wrap:wrap;">
                            <a href="register.php" class="w-btn w-btn--gold">Register Now</a>
                            <a href="https://wa.me/255772382320" target="_blank" rel="noopener noreferrer" class="w-btn w-btn--ghost" style="color:#ffffff; border-color:rgba(255,255,255,0.25);">
                                <span>WhatsApp Support</span>
                                <svg class="w-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"></path></svg>
                            </a>
                        </div>
                    </div>

                    <div class="w-contact-points">
                        <div class="w-contact-row">
                            <div class="w-contact-point-icon">
                                <svg class="w-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"></path></svg>
                            </div>
                            <div>
                                <div class="w-point-label">Call / WhatsApp</div>
                                <div class="w-point-val">
                                    <a href="tel:+255772382320">+255 772 382 320</a> &nbsp;|&nbsp; <a href="tel:+255673266852">+255 673 266 852</a>
                                </div>
                            </div>
                        </div>

                        <div class="w-contact-row">
                            <div class="w-contact-point-icon">
                                <svg class="w-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"></path></svg>
                            </div>
                            <div>
                                <div class="w-point-label">Physical Learning Centre</div>
                                <div class="w-point-val">
                                    <span>Kurasini, Dar es Salaam, Tanzania</span>
                                </div>
                            </div>
                        </div>

                        <div class="w-contact-row">
                            <div class="w-contact-point-icon">
                                <svg class="w-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <div class="w-point-label">Admissions &amp; Enquiries</div>
                                <div class="w-point-val">
                                    <span>Open for Upcoming CPSP Cycle</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="w-footer">
        <div class="w-footer__container">
            <div>
                <div class="w-footer__brand">
                    <img src="images/logo.jpeg" alt="Wisdom Logo" style="width:34px; height:34px; border-radius:6px; border:1px solid var(--w-gold-600);" width="34" height="34">
                    <span class="w-footer__brand-title">WISDOM BLENDED CLASSES</span>
                </div>
                <div class="w-footer__motto">Learn • Think • Grow</div>
                <p class="w-footer__desc">
                    Providing professional learning support for CPSP candidates through quality education, flexible learning, and examination-focused preparation.
                </p>
            </div>

            <div class="w-footer__links-col">
                <h4>Quick Links</h4>
                <ul class="w-footer__links">
                    <li><a href="#hero">Home</a></li>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#programmes">Programmes</a></li>
                    <li><a href="#approach">Learning Approach</a></li>
                    <li><a href="#why-us">Why Choose Us</a></li>
                    <li><a href="#faqs">FAQs</a></li>
                    <li><a href="#contact">Contact</a></li>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                </ul>
            </div>
        </div>

        <div class="w-footer__copy">
            <p>© <?= date('Y') ?> Wisdom Blended Classes. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Executive Micro-Interactions Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Reading Progress Bar micro-interaction
            const progressBar = document.getElementById('wScrollProgress');
            const nav = document.getElementById('wNav');

            window.addEventListener('scroll', function() {
                const scrollTop = window.scrollY || document.documentElement.scrollTop;
                const scrollHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                if (scrollHeight > 0 && progressBar) {
                    const scrolledPct = (scrollTop / scrollHeight) * 100;
                    progressBar.style.width = scrolledPct + '%';
                }

                if (nav) {
                    if (scrollTop > 20) {
                        nav.classList.add('scrolled');
                    } else {
                        nav.classList.remove('scrolled');
                    }
                }
            }, { passive: true });

            // 2. Responsive Mobile Menu Toggle
            const navToggle = document.getElementById('wNavToggle');
            const navMenu = document.getElementById('wNavMenu');
            if (navToggle && navMenu) {
                navToggle.addEventListener('click', function() {
                    const isOpen = navMenu.classList.toggle('open');
                    navToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                });

                navMenu.querySelectorAll('a').forEach(function(link) {
                    link.addEventListener('click', function() {
                        navMenu.classList.remove('open');
                        navToggle.setAttribute('aria-expanded', 'false');
                    });
                });
            }

            // 3. Accessible FAQ Accordion (ARIA-compliant)
            const faqItems = document.querySelectorAll('.w-faq-item');
            faqItems.forEach(function(item) {
                const btn = item.querySelector('.w-faq-btn');
                if (!btn) return;

                btn.addEventListener('click', function() {
                    const isActive = item.classList.contains('active');
                    faqItems.forEach(function(other) {
                        other.classList.remove('active');
                        const otherBtn = other.querySelector('.w-faq-btn');
                        if (otherBtn) otherBtn.setAttribute('aria-expanded', 'false');
                    });

                    if (!isActive) {
                        item.classList.add('active');
                        btn.setAttribute('aria-expanded', 'true');
                    }
                });
            });
        });
    </script>
</body>
</html>
