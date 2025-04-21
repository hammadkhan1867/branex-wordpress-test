<?php get_header(); ?>

<header class="mb-4">
  <h1><?php post_type_archive_title(); ?></h1>
</header>

<?php if ( have_posts() ) : ?>
  <div class="row">
    <?php while ( have_posts() ) : the_post(); ?>
      <div class="col-md-4 mb-4">
        <div class="card h-100">
          <?php if ( has_post_thumbnail() ) : ?>
            <a href="<?php the_permalink(); ?>">
              <?php the_post_thumbnail('medium', ['class'=>'card-img-top']); ?>
            </a>
          <?php endif; ?>
          <div class="card-body">
            <h2 class="h5"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <?php the_excerpt(); ?>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>

  <div class="mt-4">
    <?php the_posts_pagination(); ?>
  </div>

<?php else : ?>
  <p><?php esc_html_e('No properties found.', 'property-rental'); ?></p>
<?php endif; ?>

<?php get_footer(); ?>
