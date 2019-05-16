<?php /* Template Name: ClassnotesMenu */ ?>

<?php get_header(); ?>

<div id="primary" class="content-area classnote-container">
  <main id="main" class="site-main classnote-container__main" role="main">
    <?php $classnotes = new WP_Query( array( 'post_type' => 'classnote' ) ); ?>
    <?php $notetypes = get_terms( array('taxonomy' => 'classnote-category') ) ?>

    <?php if ( $classnotes->have_posts() ) : ?>

      <?php foreach($notetypes as $notetype) { ?>

        <span class="notetype-title"><?php echo $notetype->name; ?></span>

        <ul class="classnote-menu">
          
          <?php while ( $classnotes->have_posts() ) : $classnotes->the_post(); ?>
            
            <?php if(has_user_classnote(get_the_ID()) || current_user_can('administrator')) : ?>
              
              <?php if($notetype->name == get_the_terms(get_the_ID(), 'classnote-category')[0]->name ) : ?>
              
                <li class="classnote-menu__item">
                  <a href="<?php the_permalink(); ?>"><?php the_title(); $notetype; ?></a>
                </li>

              <?php endif; ?>

            <?php endif; ?>
          
          <?php endwhile; ?>

        </ul><!-- .classnote-menu -->

      <?php } ?>

    <?php endif; ?>
    
  </main><!-- .site-main -->
</div><!-- .content-area -->

<?php get_footer(); ?>