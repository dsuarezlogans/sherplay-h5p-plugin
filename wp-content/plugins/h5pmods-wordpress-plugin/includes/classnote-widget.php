<?php 
class classnote_Widget extends WP_Widget {
  /**
  * To create the example widget all four methods will be 
  * nested inside this single instance of the WP_Widget class.
  **/

  public function __construct() {
    $widget_options = array( 
      'classname' => 'classnote_widget',
      'description' => 'Muestra los apuntes de curso seleccionado.',
    );
    parent::__construct( 'classnote_widget', 'Apuntes Widget', $widget_options );
  }

  public function widget( $args, $instance ) {
    global $post;
    $title = apply_filters( 'widget_title', $instance[ 'title' ] );
    $moreLink = $instance[ 'more-link' ];
    $classnotes = getClassnotesByTerm($post->ID);
    echo $args['before_widget'] . $args['before_title'] . $title . $args['after_title'] . $post->post_type; 
    
    if( $classnotes->have_posts() && $post->post_type == 'sfwd-courses') {

        while( $classnotes->have_posts() ) {
            $classnotes->the_post(); ?>
  
            <p><a href="<?php the_permalink(); ?>"> <?php echo get_the_title() ?> </a></p>
            
    <?php 
        } 
    } ?>

    <p><a href="<?php echo $moreLink ?>">Ver Mas</a></p>   
    
    <?php echo $args['after_widget'];
  }

  public function form( $instance ) {
    $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
    $moreLink = ! empty( $instance['more-link'] ) ? $instance['more-link'] : ''; ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
      <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'more-link' ); ?>">Ver Mas:</label>
      <input type="text" id="<?php echo $this->get_field_id( 'more-link' ); ?>" name="<?php echo $this->get_field_name( 'more-link' ); ?>" value="<?php echo esc_attr( $moreLink ); ?>" placeholder="https:// ..."/>
    </p><?php
  }

}

function getClassnotesByTerm($term) {

    $classnotes = new WP_Query( array(
      'post_type' => 'classnote',
      'tax_query' => array(
          array (
              'taxonomy' => 'classnote-category',
              'field' => 'slug',
              'terms' => $term,
          )
      ),
    ) );

    return $classnotes;
}

function classnote_register_widget() { 
    register_widget( 'classnote_Widget' );
}
  add_action( 'widgets_init', 'classnote_register_widget' );
?>