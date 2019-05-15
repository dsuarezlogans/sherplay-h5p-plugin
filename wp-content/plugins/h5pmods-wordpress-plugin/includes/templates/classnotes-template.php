<?php /* Template Name: ClassnotesMenu */ ?>

<?php get_header(); ?>

<div id="primary" class="content-area classnote-container">
  <main id="main" class="site-main classnote-container__main" role="main">
    <?php $classnotes = new WP_Query( array( 'post_type' => 'classnote' ) ); ?>

    <?php if ( $classnotes->have_posts() ) : ?>
    <ul class="classnote-menu">
      <?php while ( $classnotes->have_posts() ) : $classnotes->the_post(); ?>
      <?php if(has_user_classnote(get_the_ID()) || current_user_can('administrator')) : ?>

        <li class="classnote-menu__item">
          <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </li>

      <?php endif; ?>
      
      <?php endwhile; ?>
    </ul>
    <?php endif; ?>
    
  </main><!-- .site-main -->
</div><!-- .content-area -->

<?php get_footer(); ?>