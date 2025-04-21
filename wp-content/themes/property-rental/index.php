<?php get_header(); ?>

<section class="posts-list row">
  <?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post(); ?>
      <article id="post-<?php the_ID(); ?>" <?php post_class('col-md-4 mb-4'); ?>>
        <div class="card h-100">
          <?php if ( has_post_thumbnail() ) : ?>
            <a href="<?php the_permalink(); ?>">
              <?php the_post_thumbnail('medium', ['class'=>'card-img-top']); ?>
            </a>
          <?php endif; ?>
          <div class="card-body">
            <h2 class="card-title h5">
              <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h2>
            <?php the_excerpt(); ?>
          </div>
        </div>
      </article>
    <?php endwhile; ?>

    <div class="col-12">
      <?php the_posts_pagination(); ?>
    </div>

  <?php else : ?>
    <p><?php esc_html_e('No posts found.', 'property-rental'); ?></p>
  <?php endif; ?>
</section>

<?php get_footer(); ?>
