<?php
/**
 * Single Post Template — PetsLets (Astra Child)
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();

/** Sidebars (honour Astra page layout) */
if ( astra_page_layout() === 'left-sidebar' ) { get_sidebar(); }
?>

<main id="primary" <?php astra_primary_class( 'pl-post' ); ?> role="main" itemscope itemtype="https://schema.org/Article">
	<?php
	while ( have_posts() ) : the_post();

		// Basics
		$post_id     = get_the_ID();
		$cats        = get_the_category( $post_id );
		$cat_primary = $cats ? $cats[0] : null;

		// Reading time
		$content_str = wp_strip_all_tags( get_post_field( 'post_content', $post_id ) );
		$word_count  = str_word_count( $content_str );
		$read_min    = max( 1, ceil( $word_count / 225 ) );

		// Featured image (if any)
		$has_thumb   = has_post_thumbnail();
		$img_html    = $has_thumb ? get_the_post_thumbnail( $post_id, 'large', [
			'class' => 'pl-post__image',
			'itemprop' => 'image',
			'loading' => 'eager',
			'decoding' => 'async'
		] ) : '';

		// Schema bits
		?>
		<meta itemprop="mainEntityOfPage" content="<?php the_permalink(); ?>" />
		<meta itemprop="author" content="<?php echo esc_attr( get_the_author() ); ?>" />
		<meta itemprop="datePublished" content="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" />
		<meta itemprop="dateModified" content="<?php echo esc_attr( get_the_modified_date( 'c' ) ); ?>" />

		<header class="pl-post-hero">
			<?php if ( $cat_primary ) : ?>
				<a class="pl-post-hero__eyebrow" href="<?php echo esc_url( get_category_link( $cat_primary ) ); ?>">
					<?php echo esc_html( $cat_primary->name ); ?>
				</a>
			<?php endif; ?>

			<h1 class="pl-post-hero__title" itemprop="headline"><?php the_title(); ?></h1>

			<div class="pl-post-hero__meta">
				<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" class="pl-post-hero__date">
					<?php echo esc_html( get_the_date() ); ?>
				</time>
				<span aria-hidden="true">·</span>
				<span class="pl-post-hero__read"><?php echo esc_html( $read_min ); ?> min read</span>
			</div>

			<?php if ( $img_html ) : ?>
				<figure class="pl-post-hero__figure">
					<?php echo $img_html; ?>
				</figure>
			<?php endif; ?>
		</header>

		<article class="pl-post-content e-content" itemprop="articleBody">
			<?php
				// Astra prints content via the_loop; we’ll output directly.
				the_content();

				// Pagination inside posts
				wp_link_pages( [
					'before' => '<nav class="pl-post-pages" aria-label="Post pages">',
					'after'  => '</nav>',
				] );
			?>
		</article>

		<section class="pl-share" aria-label="Share this post">
			<strong class="pl-share__label">Share the post:</strong>
			<?php
			$u = urlencode( get_permalink() );
			$t = urlencode( get_the_title() );
			?>
			<a class="pl-share__btn" href="https://twitter.com/intent/tweet?url=<?php echo $u; ?>&text=<?php echo $t; ?>" target="_blank" rel="noopener nofollow" aria-label="Share on X/Twitter">
				<i class="fab fa-x-twitter" aria-hidden="true"></i>
			</a>
			<a class="pl-share__btn" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $u; ?>" target="_blank" rel="noopener nofollow" aria-label="Share on Facebook">
				<i class="fab fa-facebook-f" aria-hidden="true"></i>
			</a>
			<a class="pl-share__btn" href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $u; ?>" target="_blank" rel="noopener nofollow" aria-label="Share on LinkedIn">
				<i class="fab fa-linkedin-in" aria-hidden="true"></i>
			</a>
			<button class="pl-share__btn pl-share__btn--copy" type="button" aria-label="Copy link" data-copy="<?php echo esc_attr( get_permalink() ); ?>">
				<i class="fas fa-link" aria-hidden="true"></i>
			</button>
		</section>

		<?php
		// Author card
		$desc = get_the_author_meta( 'description' );
		?>
		<section class="pl-author" itemprop="author" itemscope itemtype="https://schema.org/Person">
			<div class="pl-author__avatar"><?php echo get_avatar( get_the_author_meta( 'ID' ), 72 ); ?></div>
			<div class="pl-author__body">
				<h3 class="pl-author__name" itemprop="name"><?php the_author(); ?></h3>
				<?php if ( $desc ) : ?>
					<p class="pl-author__bio"><?php echo esc_html( $desc ); ?></p>
				<?php endif; ?>
			</div>
		</section>

		<nav class="pl-post-nav" aria-label="Post">
			<div class="pl-post-nav__prev">
				<?php previous_post_link( '%link', '<i class="fas fa-arrow-left" aria-hidden="true"></i> <span>Previous</span>' ); ?>
			</div>
			<div class="pl-post-nav__next">
				<?php next_post_link( '%link', '<span>Next</span> <i class="fas fa-arrow-right" aria-hidden="true"></i>' ); ?>
			</div>
		</nav>

		<?php
		// Related posts (same primary category)
		if ( $cat_primary ) :
			$rel = new WP_Query( [
				'cat'                 => $cat_primary->term_id,
				'post__not_in'        => [ $post_id ],
				'posts_per_page'      => 3,
				'ignore_sticky_posts' => true,
				'no_found_rows'       => true,
			] );
			if ( $rel->have_posts() ) : ?>
				<section class="pl-related">
					<h2 class="pl-related__title">More from <?php echo esc_html( $cat_primary->name ); ?></h2>
					<div class="pl-related__grid">
						<?php while ( $rel->have_posts() ) : $rel->the_post(); ?>
							<article class="pl-related__item">
								<a class="pl-related__thumb" href="<?php the_permalink(); ?>">
									<?php if ( has_post_thumbnail() ) {
										the_post_thumbnail( 'medium_large', [ 'loading' => 'lazy', 'decoding' => 'async' ] );
									} ?>
								</a>
								<h3 class="pl-related__h3"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<time class="pl-related__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
							</article>
						<?php endwhile; wp_reset_postdata(); ?>
					</div>
				</section>
			<?php endif; endif; ?>

	<?php endwhile; ?>
</main>

<?php if ( astra_page_layout() === 'right-sidebar' ) { get_sidebar(); } ?>
<?php get_footer(); ?>