<?php get_header(); ?>

<?php
  $term = get_queried_object();
?>
<header class="mb-4">
  <h1>
    <?php echo esc_html( $term->name ); ?>
    <small class="text-muted"><?php esc_html_e('Properties','property-rental'); ?></small>
  </h1>
  <?php if ( ! empty( $term->description ) ) : ?>
    <p><?php echo esc_html( $term->description ); ?></p>
  <?php endif; ?>
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
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
<?php else : ?>
  <p><?php esc_html_e('No properties in this category.', 'property-rental'); ?></p>
<?php endif; ?>

<?php get_footer(); ?>
