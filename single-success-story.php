<?php
/**
 * Template: Single Success Story
 * Flow: Hero → Story → CTAs → Outcome Snapshot (optional) → How It Works → Why Choose → Related Stories + Sticky CTA
 *
 * Theme: Astra (child-friendly, no Elementor dependency)
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();

while ( have_posts() ) :
    the_post();

    // Basic data
    $featured_id  = get_post_thumbnail_id();
    $featured_url = $featured_id ? wp_get_attachment_image_url( $featured_id, 'full' ) : '';
    $stories_url  = get_post_type_archive_link( get_post_type() );
    if ( ! $stories_url ) { $stories_url = home_url( '/success-stories/' ); }

    // Optional meta (use ACF or native post meta). Leave empty to hide chips/KPIs.
    $meta_location = trim( (string) get_post_meta( get_the_ID(), 'pl_location', true ) );
    $meta_service  = trim( (string) get_post_meta( get_the_ID(), 'pl_service', true ) );   // e.g. "Full Service"
    $meta_pets     = trim( (string) get_post_meta( get_the_ID(), 'pl_pets', true ) );       // e.g. "2 cats"

    // Outcome snapshot (optional KPIs)
    $kpi_time    = trim( (string) get_post_meta( get_the_ID(), 'pl_kpi_time', true ) );     // e.g. "13 days"
    $kpi_budget  = trim( (string) get_post_meta( get_the_ID(), 'pl_kpi_budget', true ) );   // e.g. "Within budget"
    $kpi_approve = trim( (string) get_post_meta( get_the_ID(), 'pl_kpi_approve', true ) );  // e.g. "100% pet-approved"

    // Optional pull quote
    $pull_quote  = trim( (string) get_post_meta( get_the_ID(), 'pl_pull_quote', true ) );   // text only
    ?>
    <!-- ===================== LOCAL STYLES ===================== -->
    <style>
        /* Base wrappers */
        .pl-ss-wrap{max-width:1120px;margin:0 auto;padding:48px 20px}
        .pl-ss-cta-btn{display:inline-block;padding:12px 16px;border-radius:12px;text-decoration:none}

        /* Hero */
        .pl-ss-hero{background:#fff}
        .pl-ss-hero .pl-ss-grid{display:grid;grid-template-columns:1.1fr .9fr;gap:24px;align-items:center}
        .pl-ss-hero h1{margin:0 0 10px;line-height:1.15;font-size:clamp(28px,3.2vw,40px);font-weight:800}
        .pl-ss-hero .pl-ss-hero__media{border-radius:16px;overflow:hidden;border:1px solid rgba(0,0,0,.08);box-shadow:0 6px 20px rgba(0,0,0,.06)}
        .pl-meta-chips{display:flex;flex-wrap:wrap;gap:8px;margin-top:10px}
        .pl-chip{font-size:12px;line-height:1;padding:7px 10px;border-radius:999px;border:1px solid rgba(0,0,0,.1);background:#fafafa;color:#111}

        /* Content + CTAs */
        .pl-ss-content{background:#fff}
        .pl-ss-ctas{display:flex;gap:12px;flex-wrap:wrap;margin:24px 0 8px}
        .pl-btn-primary{background:#111;color:#fff;border:1px solid #111}
        .pl-btn-secondary{background:#fff;color:#111;border:1px solid rgba(0,0,0,.12)}

        /* Outcome snapshot */
        .pl-outcome{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin:18px 0 10px}
        .pl-outcome .kpi{padding:14px;border:1px solid rgba(0,0,0,.08);border-radius:12px;background:#fff;box-shadow:0 6px 18px rgba(0,0,0,.05)}
        .pl-outcome .kpi b{display:block;font-size:18px;line-height:1.2}
        .pl-outcome .kpi span{color:rgba(0,0,0,.6);font-size:13px}
        @media (max-width:767px){.pl-ss-hero .pl-ss-grid{grid-template-columns:1fr}.pl-outcome{grid-template-columns:1fr}}

        /* Pull quote */
        .pl-pull{margin:20px 0;padding:14px 16px;border-left:3px solid #e11d48;background:#fff;border-radius:12px;box-shadow:0 6px 18px rgba(0,0,0,.05);color:#111}

        /* How It Works */
        .pl-how{background:#fff;color:inherit;padding:64px 20px}
        .pl-how .wrap{max-width:1120px;margin:0 auto}
        .pl-how h2{margin:0 0 10px;line-height:1.15;font-size:clamp(28px,3vw,38px);font-weight:800}
        .pl-how .intro{max-width:880px;margin:0 auto 28px;font-size:clamp(15px,1.6vw,17px);color:rgba(0,0,0,.68);text-align:center}
        .pl-how .grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:22px;align-items:stretch}
        @media (max-width:991px){.pl-how .grid{grid-template-columns:repeat(2,1fr)}}
        @media (max-width:575px){.pl-how{padding:44px 16px}.pl-how .grid{grid-template-columns:1fr;gap:14px}}
        .pl-how .card{background:#fff;border:1px solid rgba(0,0,0,.08);border-radius:16px;padding:22px;box-shadow:0 6px 20px rgba(0,0,0,.06);transition:transform .18s ease, box-shadow .18s ease;height:100%}
        .pl-how .card:hover{transform:translateY(-3px);box-shadow:0 12px 28px rgba(0,0,0,.08)}
        .pl-how .top{display:flex;align-items:center;gap:12px;margin-bottom:8px}
        .pl-how .num{--accent:#e11d48;flex:0 0 36px;height:36px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;background:var(--accent);color:#fff;font-weight:700;box-shadow:0 0 0 3px #fff,0 0 0 4px rgba(0,0,0,.06)}
        .pl-how .icon{--accent:#e11d48;width:40px;height:40px;border-radius:12px;display:inline-flex;align-items:center;justify-content:center;background:rgba(0,0,0,.04);color:var(--accent);border:1px solid rgba(0,0,0,.06);font-size:18px}
        .pl-how .card h3{margin:0;font-size:18px;font-weight:700;line-height:1.35}
        .pl-how .card p{margin:8px 0 0;font-size:15px;line-height:1.6;color:rgba(0,0,0,.75)}
        .pl-how ul.mini{margin:8px 0 0 18px;padding:0;font-size:15px;line-height:1.6;color:rgba(0,0,0,.75)}
        .pl-how .cta{display:flex;flex-wrap:wrap;gap:12px;justify-content:center;margin-top:26px}
        .pl-how .cta a{display:inline-block;text-decoration:none;border-radius:12px;padding:12px 16px;border:1px solid rgba(0,0,0,.1)}
        .pl-how .cta a.primary{background:#111;color:#fff;border-color:#111}
        .pl-how .cta a.secondary{background:#fff;color:#111}

        /* Why Choose */
        .pl-why{background:#fff;color:inherit;padding:64px 20px}
        .pl-why .wrap{max-width:1120px;margin:0 auto}
        .pl-why h2{margin:0 0 10px;line-height:1.15;font-size:clamp(28px,3vw,38px);font-weight:800}
        .pl-why .intro{max-width:840px;margin:0 auto 28px;font-size:clamp(15px,1.6vw,17px);color:rgba(0,0,0,.68);text-align:center}
        .pl-why .grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:22px}
        @media (max-width:991px){.pl-why .grid{grid-template-columns:repeat(2,1fr)}}
        @media (max-width:575px){.pl-why{padding:44px 16px}.pl-why .grid{grid-template-columns:1fr;gap:14px}}
        .pl-why .card{background:#fff;border:1px solid rgba(0,0,0,.08);border-radius:16px;padding:22px;box-shadow:0 6px 20px rgba(0,0,0,.06);transition:transform .18s ease, box-shadow .18s ease}
        .pl-why .card:hover{transform:translateY(-3px);box-shadow:0 12px 28px rgba(0,0,0,.08)}
        .pl-why .icon{--accent:#e11d48;width:44px;height:44px;border-radius:12px;margin-bottom:12px;display:inline-flex;align-items:center;justify-content:center;background:rgba(0,0,0,.04);color:var(--accent);border:1px solid rgba(0,0,0,.06);font-size:20px}
        .pl-why .card h3{margin:2px 0 8px;font-size:18px;font-weight:700;line-height:1.35}
        .pl-why .card p{margin:0;font-size:15px;line-height:1.6;color:rgba(0,0,0,.72)}

        /* Related stories (mobile swipe) */
        .pl-ss-related__grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:22px}
        @media (max-width:575px){
            .pl-ss-related__grid{display:flex;overflow:auto;gap:12px;padding-bottom:6px;scroll-snap-type:x mandatory}
            .pl-ss-related__card{min-width:80%;scroll-snap-align:start}
        }

        /* Sticky CTA (mobile) */
        .pl-sticky-cta{position:fixed;left:0;right:0;bottom:12px;z-index:50;display:none;justify-content:center}
        .pl-sticky-cta a{background:#111;color:#fff;border-radius:999px;padding:12px 18px;text-decoration:none;box-shadow:0 10px 24px rgba(0,0,0,.18)}
        @media (max-width:767px){.pl-sticky-cta{display:flex}}
    </style>

    <!-- ===================== HERO ===================== -->
    <section class="pl-ss-hero" aria-label="Success Story hero">
        <div class="pl-ss-wrap">
            <div class="pl-ss-grid">
                <div>
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    <?php if ( has_excerpt() ) : ?>
                        <p style="color:rgba(0,0,0,.68);font-size:clamp(15px,1.6vw,18px);margin:0 0 8px;"><?php echo esc_html( get_the_excerpt() ); ?></p>
                    <?php endif; ?>

                    <div style="font-size:14px;color:rgba(0,0,0,.56);margin-top:6px;"><?php echo esc_html( get_the_date() ); ?></div>

                    <?php if ( $meta_location || $meta_service || $meta_pets ) : ?>
                    <div class="pl-meta-chips">
                        <?php if ( $meta_location ) : ?><span class="pl-chip"><i class="fa fa-map-marker-alt"></i> <?php echo esc_html( $meta_location ); ?></span><?php endif; ?>
                        <?php if ( $meta_service )  : ?><span class="pl-chip"><i class="fa fa-briefcase"></i> <?php echo esc_html( $meta_service ); ?></span><?php endif; ?>
                        <?php if ( $meta_pets )     : ?><span class="pl-chip"><i class="fa fa-paw"></i> <?php echo esc_html( $meta_pets ); ?></span><?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <?php if ( $featured_url ) : ?>
                    <div class="pl-ss-hero__media">
                        <img src="<?php echo esc_url( $featured_url ); ?>" alt="" style="display:block;width:100%;height:auto;">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- ===================== STORY CONTENT + CTAS ===================== -->
    <section class="pl-ss-content">
        <div class="pl-ss-wrap" style="max-width:860px;">
            <?php if ( $kpi_time || $kpi_budget || $kpi_approve ) : ?>
            <div class="pl-outcome" aria-label="Outcome snapshot">
                <?php if ( $kpi_time )    : ?><div class="kpi"><b><?php echo esc_html( $kpi_time ); ?></b><span>Time to secure</span></div><?php endif; ?>
                <?php if ( $kpi_budget )  : ?><div class="kpi"><b><?php echo esc_html( $kpi_budget ); ?></b><span>Budget / terms</span></div><?php endif; ?>
                <?php if ( $kpi_approve ) : ?><div class="kpi"><b><?php echo esc_html( $kpi_approve ); ?></b><span>Pet approval</span></div><?php endif; ?>
            </div>
            <?php endif; ?>

            <article <?php post_class( 'pl-ss-article' ); ?> id="post-<?php the_ID(); ?>">
                <div class="entry-content">
                    <?php the_content(); ?>
                    <?php if ( $pull_quote ) : ?>
                        <div class="pl-pull"><?php echo esc_html( $pull_quote ); ?></div>
                    <?php endif; ?>
                </div>
            </article>

            <div class="pl-ss-ctas">
                <a class="pl-ss-cta-btn pl-btn-primary" href="https://calendly.com/hello-uug/quick-chat-with-russell" target="_blank" rel="noopener">
                    Arrange a Call
                </a>
                <a class="pl-ss-cta-btn pl-btn-secondary" href="<?php echo esc_url( $stories_url ); ?>">
                    All Success Stories
                </a>
            </div>
        </div>
    </section>

    <!-- ===================== HOW IT WORKS ===================== -->
    <section class="pl-how" aria-labelledby="pl-how-title">
        <div class="wrap">
            <header style="text-align:center;margin-bottom:18px">
                <h2 id="pl-how-title">How It Works</h2>
                <p class="intro">Finding a pet-friendly property in the UK doesn’t have to be overwhelming. At Pets Lets, we keep it simple:</p>
            </header>

            <div class="grid" role="list">
                <article class="card" role="listitem">
                    <div class="top"><div class="num">1</div><div class="icon" aria-hidden="true"><i class="fa fa-user"></i></div><h3>Tell Us About You &amp; Your Pets</h3></div>
                    <p>Share your rental or buying needs (locations, budget) and—most importantly—details about your pets. The more we know, the better we can target the right homes.</p>
                    <p class="small" style="font-size:13.5px;color:rgba(0,0,0,.68)">Usually covered on an initial <strong>30-minute call</strong>.</p>
                </article>

                <article class="card" role="listitem">
                    <div class="top"><div class="num">2</div><div class="icon" aria-hidden="true"><i class="fa fa-search"></i></div><h3>We Search &amp; Shortlist</h3></div>
                    <p>We cut through portals like Rightmove &amp; Zoopla, go straight to our network of agents &amp; landlords, and handpick homes that genuinely welcome <strong>your</strong> pets.</p>
                </article>

                <article class="card" role="listitem">
                    <div class="top"><div class="num">3</div><div class="icon" aria-hidden="true"><i class="fa fa-calendar-check"></i></div><h3>Viewings Made Easy</h3></div>
                    <ul class="mini">
                        <li>We book &amp; arrange viewings (<em>E-Service or Full Service</em>).</li>
                        <li>We can attend on your behalf (<em>Full Service</em>).</li>
                        <li>DIY toolkit <strong>£20</strong> — <strong>100% donated</strong> to pet charities.</li>
                    </ul>
                </article>

                <article class="card" role="listitem">
                    <div class="top"><div class="num">4</div><div class="icon" aria-hidden="true"><i class="fa fa-handshake"></i></div><h3>Negotiating With Landlords &amp; Agents</h3></div>
                    <p>With <strong>25+ years’ experience</strong>, we position your profile and pets in the best light and negotiate terms that work for you.</p>
                </article>

                <article class="card" role="listitem">
                    <div class="top"><div class="num">5</div><div class="icon" aria-hidden="true"><i class="fa fa-file-signature"></i></div><h3>Secure Your New Home</h3></div>
                    <p>From offer accepted to contracts signed, we oversee the process so the details work for both you and your pets. <span class="small">US clients often call us <em>property brokers</em>!</span></p>
                </article>

                <article class="card" role="listitem">
                    <div class="top"><div class="num">6</div><div class="icon" aria-hidden="true"><i class="fa fa-home"></i></div><h3>Move In With Confidence</h3></div>
                    <p>Relax—your new home is pet-approved. No stress, no surprises, just a smoother move for the whole family. Even after moving in, we’re a WhatsApp or email away.</p>
                </article>
            </div>

            <div class="cta" role="group" aria-label="Helpful links">
                <a class="secondary" href="<?php echo esc_url( $stories_url ); ?>">See Success Stories</a>
                <a class="primary" href="https://calendly.com/hello-uug/quick-chat-with-russell" target="_blank" rel="noopener"><i class="fa fa-calendar"></i> Arrange a Call</a>
            </div>
        </div>
    </section>

    <!-- ===================== WHY CHOOSE ===================== -->
    <section class="pl-why" aria-labelledby="pl-why-title">
        <div class="wrap">
            <header style="text-align:center;margin-bottom:18px">
                <h2 id="pl-why-title">Why Choose Pets Lets?</h2>
                <p class="intro">We specialise in pet-friendly rentals and purchases across London and the UK, pairing seasoned property know-how with genuine love for animals.</p>
            </header>

            <div class="grid" role="list">
                <article class="card" role="listitem"><div class="icon" aria-hidden="true"><i class="fa fa-paw"></i></div><h3>Leading UK Pets &amp; Property Specialists</h3><p>Over 25 years’ experience in the London property market, combined with unique expertise in pet-friendly rentals and purchases.</p></article>
                <article class="card" role="listitem"><div class="icon" aria-hidden="true"><i class="fa fa-clipboard-check"></i></div><h3>Tailored Service for Pet Owners</h3><p>From Pet CVs to negotiating with landlords, we overcome the barriers that make renting with pets so tough.</p></article>
                <article class="card" role="listitem"><div class="icon" aria-hidden="true"><i class="fa fa-handshake"></i></div><h3>Strong Agent &amp; Landlord Relationships</h3><p>We cut through portals and wasted viewings, dealing directly with trusted contacts to secure homes faster.</p></article>
                <article class="card" role="listitem"><div class="icon" aria-hidden="true"><i class="fa fa-tags"></i></div><h3>Clear, Flexible Pricing</h3><p>Options for every budget with transparent fees and no hidden extras.</p></article>
                <article class="card" role="listitem"><div class="icon" aria-hidden="true"><i class="fa fa-globe"></i></div><h3>Trusted by Relocators Worldwide</h3><p>Especially popular with US clients moving to the UK—we guide you through property, pets &amp; paperwork every step of the way.</p></article>
                <article class="card" role="listitem"><div class="icon" aria-hidden="true"><i class="fa fa-heart"></i></div><h3>Founded by a Pet Owner for Pet Owners</h3><p>Russell Hunt (with co-founder Biscuit, a beagle-basset) built Pets Lets to make the UK property market easier, friendlier, and fairer for people with pets.</p></article>
            </div>
        </div>
    </section>

    <!-- ===================== RELATED SUCCESS STORIES ===================== -->
    <?php
    $related = new WP_Query( array(
        'post_type'           => get_post_type(),
        'posts_per_page'      => 3,
        'post__not_in'        => array( get_the_ID() ),
        'ignore_sticky_posts' => true,
    ) );

    if ( $related->have_posts() ) : ?>
        <section class="pl-ss-related" style="background:#fff;">
            <div class="pl-ss-wrap">
                <h2 style="margin:0 0 18px;line-height:1.15;font-size:clamp(24px,2.6vw,32px);font-weight:800;">More Success Stories</h2>
                <div class="pl-ss-related__grid">
                    <?php while ( $related->have_posts() ) : $related->the_post(); $img = get_the_post_thumbnail_url( get_the_ID(), 'large' ); ?>
                        <article class="pl-ss-related__card" style="border:1px solid rgba(0,0,0,.08);border-radius:16px;overflow:hidden;background:#fff;box-shadow:0 6px 20px rgba(0,0,0,.06);">
                            <a href="<?php the_permalink(); ?>" style="display:block;text-decoration:none;color:inherit;">
                                <?php if ( $img ) : ?>
                                    <div style="aspect-ratio:16/9;background:#f5f6fa;">
                                        <img src="<?php echo esc_url( $img ); ?>" alt="" style="width:100%;height:100%;object-fit:cover;">
                                    </div>
                                <?php endif; ?>
                                <div style="padding:14px 16px;">
                                    <h3 style="margin:0 0 6px;font-size:18px;line-height:1.3;font-weight:700;"><?php the_title(); ?></h3>
                                    <p style="margin:0;color:rgba(0,0,0,.68);font-size:14px;"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
                                </div>
                            </a>
                        </article>
                    <?php endwhile; ?>
                </div>
            </div>
        </section>
        <?php wp_reset_postdata(); ?>
    <?php endif; ?>

    <!-- ===================== STICKY CTA (MOBILE) ===================== -->
    <div class="pl-sticky-cta" aria-hidden="false">
        <a href="https://calendly.com/hello-uug/quick-chat-with-russell" target="_blank" rel="noopener">
            <i class="fa fa-calendar"></i> Arrange a Call
        </a>
    </div>

    <!-- ===================== SCHEMA ===================== -->
    <script type="application/ld+json">
    {
      "@context":"https://schema.org",
      "@type":"Article",
      "headline": <?php echo wp_json_encode( get_the_title() ); ?>,
      "datePublished": "<?php echo esc_js( get_the_date( 'c' ) ); ?>",
      "image": <?php echo wp_json_encode( $featured_url ? $featured_url : '' ); ?>,
      "author": {"@type":"Organization","name":"Pets Lets"}
    }
    </script>
    <script type="application/ld+json">
    {
      "@context":"https://schema.org",
      "@type":"HowTo",
      "name":"How It Works – Pets Lets",
      "step":[
        {"@type":"HowToStep","name":"Tell Us About You & Your Pets"},
        {"@type":"HowToStep","name":"We Search & Shortlist"},
        {"@type":"HowToStep","name":"Viewings Made Easy"},
        {"@type":"HowToStep","name":"Negotiating With Landlords & Agents"},
        {"@type":"HowToStep","name":"Secure Your New Home"},
        {"@type":"HowToStep","name":"Move In With Confidence"}
      ]
    }
    </script>

<?php
endwhile;
get_footer();