<?php get_header(); ?>

<article id="property-<?php the_ID(); ?>" <?php post_class('mb-5'); ?>>

  <!-- Featured Image -->
  <?php if ( has_post_thumbnail() ) : ?>
    <div class="mb-4">
      <?php the_post_thumbnail('large',['class'=>'img-fluid w-100']); ?>
    </div>
  <?php endif; ?>

  <!-- Title -->
  <h1 class="mb-3"><?php the_title(); ?></h1>

  <?php
    $loc   = get_post_meta(get_the_ID(),'location',true);
    $rent  = get_post_meta(get_the_ID(),'rent_price',true);
    $beds  = get_post_meta(get_the_ID(),'bedroom',true);
    $baths = get_post_meta(get_the_ID(),'bathroom',true);
    $available_raw = get_post_meta(get_the_ID(),'available_from',true);

    // Parse ACF’s YYYYMMDD into a DateTime
    $available_formatted = '';
    if ( $available_raw ) {
        $dt = DateTime::createFromFormat('Ymd', $available_raw);
        if ( $dt ) {
        $available_formatted = $dt->format('F j, Y');
        }
    }
  ?>


  <ul class="list-unstyled d-flex flex-wrap gap-3 mb-4">
    <?php if($loc):   ?><li><strong>Location:</strong> <?php echo esc_html($loc); ?></li><?php endif; ?>
    <?php if($rent):  ?><li><strong>Rent:</strong> $<?php echo number_format_i18n($rent); ?></li><?php endif; ?>
    <?php if($beds!==''):  ?><li><strong>Bedrooms:</strong> <?php echo ($beds); ?></li><?php endif; ?>
    <?php if($baths!==''): ?><li><strong>Bathrooms:</strong> <?php echo ($baths); ?></li><?php endif; ?>
    <?php if(!empty($available_raw)): ?><li><strong>Available From:</strong> <?php echo esc_html( $available_formatted ); ?></li><?php endif; ?>
  </ul>

  <!-- Home Type -->
  <?php if(has_term('','home_type')): ?>
    <p><strong>Type:</strong> <?php the_terms(get_the_ID(),'home_type','',', '); ?></p>
  <?php endif; ?>

  <!-- Content -->
  <div class="mb-5">
    <?php the_content(); ?>
  </div>

</article>

<?php get_footer(); ?>
