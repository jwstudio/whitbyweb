<?php
/**
 * Block: Services — hardcoded content.
 */

$btn_arrow = '<span class="btn-arrow"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></span>';
?>
<section class="services">
  <div class="container">

    <div class="row services-header">
      <div class="col-12 col-lg-6">
        <div class="eyebrow" style="margin-bottom:16px;">What We Do</div>
        <h2 class="section-heading">
          Whatever the problem,<br>
          <span class="gradient">we know how to fix it</span>
        </h2>
      </div>
      <div class="col-12 col-lg-6 services-header__sub">
        <p class="text-lead" style="margin-bottom:0;">
          Whether you're starting from scratch, built something yourself, or have a site that just isn't doing the job, we'll take it off your plate and hand back something you're genuinely glad to have.
        </p>
      </div>
    </div>

    <div class="services-grid">

      <div class="services-grid__cards">

        <div class="service-card card card--hoverable">
          <div class="service-card__icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/>
            </svg>
          </div>
          <div class="service-card__title">New Website</div>
          <p class="service-card__body">
            Starting from scratch or replacing something you're embarrassed by.
            Built properly, built to last, and built around your customers.
          </p>
          <div class="service-card__tags">
            <span class="service-tag">Design</span>
            <span class="service-tag">Development</span>
            <span class="service-tag">WordPress</span>
          </div>
        </div>

        <div class="service-card card card--hoverable">
          <div class="service-card__icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
              <path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"/>
            </svg>
          </div>
          <div class="service-card__title">Redesign &amp; Rebuild</div>
          <p class="service-card__body">
            Your site isn't converting, doesn't represent you, or was put together
            in a rush. We strip it back and rebuild it so it actually does its job.
          </p>
          <div class="service-card__tags">
            <span class="service-tag">Redesign</span>
            <span class="service-tag">Wix / Squarespace</span>
            <span class="service-tag">Migration</span>
          </div>
        </div>

        <div class="service-card card card--hoverable">
          <div class="service-card__icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
              <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
            </svg>
          </div>
          <div class="service-card__title">Speed Optimisation</div>
          <p class="service-card__body">
            A slow website loses customers before they've even read a word.
            We make yours fast enough to keep them, and keep Google happy too.
          </p>
          <div class="service-card__tags">
            <span class="service-tag">Core Web Vitals</span>
            <span class="service-tag">SEO</span>
            <span class="service-tag">Performance</span>
          </div>
        </div>

        <div class="service-card card card--hoverable">
          <div class="service-card__icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
              <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/>
            </svg>
          </div>
          <div class="service-card__title">One-Page Website</div>
          <p class="service-card__body">
            Not ready for a full build yet? Get online properly, quickly and
            affordably, with a focused one-page site that does the basics well.
          </p>
          <div class="service-card__tags">
            <span class="service-tag">Startups</span>
            <span class="service-tag">Small Business</span>
            <span class="service-tag">Quick Launch</span>
          </div>
        </div>

      </div>

      <div class="service-cta-card card">
        <div class="service-cta-card__photo">
          <img
            src="https://jameswhitbyweb-co-uk-345161.hostingersite.com/wp-content/uploads/2026/05/James-Whitby.jpg"
            alt="James Whitby"
            class="service-cta-card__img"
            loading="lazy"
          />
        </div>
        <div class="service-cta-card__content">
          <div class="eyebrow" style="margin-bottom:12px;">Based in Devon</div>
          <h3 class="service-cta-card__heading">
            Not happy with your site? <span class="gradient">Let's fix that.</span>
          </h3>
          <p class="service-cta-card__body">
            No jargon, no hard sell. Just an honest conversation about what's not working and what we can do about it.
          </p>
          <a href="/contact/" class="btn btn-primary">
            Start a conversation
            <?php echo $btn_arrow; // phpcs:ignore ?>
          </a>
        </div>
      </div>

    </div>
  </div>
</section>
