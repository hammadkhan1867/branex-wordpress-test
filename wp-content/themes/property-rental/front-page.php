<?php
/**
 * Template Name: Property Search Front Page
 */

get_header();

// 1. Sanitize incoming filter values
$keyword   = isset($_GET['keyword'])   ? sanitize_text_field( wp_unslash($_GET['keyword']) )   : '';
$location  = isset($_GET['location'])  ? sanitize_text_field( wp_unslash($_GET['location']) )  : '';
$home_type = isset($_GET['home_type']) ? sanitize_text_field( wp_unslash($_GET['home_type']) ) : '';

// 2. Build query args
$query_args = [
  'post_type'      => 'property',
  'posts_per_page' => 9,
  'paged'          => get_query_var('paged', 1),
];

// Keyword search
if ( $keyword ) {
  $query_args['s'] = $keyword;
}

// Location filter (meta_query)
if ( $location ) {
  $query_args['meta_query'][] = [
    'key'     => 'location',
    'value'   => $location,
    'compare' => 'LIKE',
  ];
}

// Home Type filter (tax_query)
if ( $home_type ) {
  $query_args['tax_query'][] = [
    'taxonomy' => 'home_type',
    'field'    => 'slug',
    'terms'    => $home_type,
  ];
}

// 3. Execute query
$properties = new WP_Query( $query_args );
?>

<div class="search-filter mb-5">
  <form method="get" class="row g-3 align-items-end">
    <div class="col-md-4">
      <label for="keyword" class="form-label"><?php esc_html_e('Keyword','property-rental'); ?></label>
      <input
        type="text"
        id="keyword"
        name="keyword"
        class="form-control"
        placeholder="<?php esc_attr_e('Search by title…','property-rental'); ?>"
        value="<?php echo esc_attr( $keyword ); ?>"
      >
    </div>

    <div class="col-md-3">
      <label for="location" class="form-label"><?php esc_html_e('Location','property-rental'); ?></label>
      <?php
        // Gather unique locations
        $all_props = get_posts([
          'post_type'      => 'property',
          'posts_per_page' => -1,
          'fields'         => 'ids',
        ]);
        $locations = [];
        foreach ( $all_props as $pid ) {
          $loc = get_post_meta( $pid, 'location', true );
          if ( $loc ) {
            $locations[ $loc ] = $loc;
          }
        }
        ksort($locations);
      ?>
      <select id="location" name="location" class="form-select">
        <option value=""><?php esc_html_e('Any','property-rental'); ?></option>
        <?php foreach ( $locations as $loc_option ) : ?>
          <option value="<?php echo esc_attr($loc_option); ?>"
            <?php selected( $location, $loc_option ); ?>>
            <?php echo esc_html($loc_option); ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-3">
      <label for="home_type" class="form-label"><?php esc_html_e('Home Type','property-rental'); ?></label>
      <?php
        $types = get_terms([
          'taxonomy'   => 'home_type',
          'hide_empty' => true,
        ]);
      ?>
      <select id="home_type" name="home_type" class="form-select">
        <option value=""><?php esc_html_e('Any','property-rental'); ?></option>
        <?php foreach ( $types as $type ) : ?>
          <option value="<?php echo esc_attr($type->slug); ?>"
            <?php selected( $home_type, $type->slug ); ?>>
            <?php echo esc_html($type->name); ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-2">
      <button type="submit" class="btn btn-primary w-100">
        <?php esc_html_e('Filter','property-rental'); ?>
      </button>
    </div>
  </form>
</div>

<?php if ( $properties->have_posts() ) : ?>
  <div class="row">
    <?php while ( $properties->have_posts() ) : $properties->the_post(); ?>
      <div class="col-md-4 mb-4">
        <div class="card h-100">
          <?php if ( has_post_thumbnail() ) : ?>
            <a href="<?php the_permalink(); ?>">
              <?php the_post_thumbnail('medium', ['class'=>'card-img-top']); ?>
            </a>
          <?php endif; ?>

          <div class="card-body">
            <h5 class="card-title">
              <a href="<?php the_permalink();?>"><?php the_title(); ?></a>
            </h5>

            <?php
              $rent = get_post_meta(get_the_ID(),'rent_price',true);
              if ( $rent ) : ?>
                <p class="card-text">
                  <strong><?php esc_html_e('Rent:','property-rental'); ?></strong>
                  $<?php echo number_format_i18n($rent); ?>
                </p>
            <?php endif; ?>

            <?php
              $loc = get_post_meta(get_the_ID(),'location',true);
              if ( $loc ) : ?>
                <p class="card-text">
                  <strong><?php esc_html_e('Location:','property-rental'); ?></strong>
                  <?php echo esc_html($loc); ?>
                </p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>

  <nav class="mt-4">
    <?php
      echo paginate_links([
        'total'   => $properties->max_num_pages,
        'current' => max(1, get_query_var('paged')),
      ]);
    ?>
  </nav>

<?php else : ?>
  <p><?php esc_html_e('No matching properties found.','property-rental'); ?></p>
<?php endif;

// Reset postdata
wp_reset_postdata();

get_footer();
