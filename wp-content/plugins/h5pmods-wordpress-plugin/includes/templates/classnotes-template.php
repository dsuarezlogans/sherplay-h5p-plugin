<?php /* Template Name: ClassnotesMenu */ ?>

<?php get_header(); ?>

<div id="primary" class="content-area classnote-container">
  <main id="main" class="site-main classnote-container__main" role="main">
    <?php $classnotes = new WP_Query( array( 'post_type' => 'classnote' ) ); ?>

    <?php 
      $classnotesByTerms = array();
      $clasnotesList = '';
      $userHasNoClassnote = true;
      $user_id = get_current_user_id();
      
      if ( $classnotes->have_posts() ) {
        while( $classnotes->have_posts() ) {

          $classnotes->the_post();
          $classnoteID = get_the_ID();

          if(has_user_classnote($classnoteID, $user_id) || current_user_can('administrator')) {

            $userHasNoClassnote = false;
            $classnoteTerm = get_the_terms($classnoteID, 'classnote-category')[0]->name;
            $link = get_the_permalink();
            $title = get_the_title();
            $clasnote = '<li class="classnote-menu__item"><a href="'. $link . '">'. $title . '</a></li>';
            
            if(isset($classnotesByTerms[$classnoteTerm])) {
              $classnotesByTerms[$classnoteTerm] .= $clasnote;
            } else {
              $classnotesByTerms[$classnoteTerm] = $clasnote;
            }

          }    
        }
        
      }

      if(!$classnotesByTerms) {
        while ( have_posts() ) : the_post(); 
          the_content();
        endwhile;
      }

      foreach ( $classnotesByTerms as $term=>$notes ) {
        echo '<span class="notetype-title">' . $term . '</span>';
        echo $notes;
      }
      
    ?>

  </main><!-- .site-main -->
</div><!-- .content-area -->

<?php get_footer(); ?>