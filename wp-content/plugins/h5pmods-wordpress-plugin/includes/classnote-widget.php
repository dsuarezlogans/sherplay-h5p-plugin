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
    $moreLabel = $instance[ 'more-label' ];
    $moreLink = $instance[ 'more-link' ];
    $classnotes = getClassnotesByTerm();
    $user_id = get_current_user_id();
    $sfwd_content = ['sfwd-courses', 'sfwd-lessons', 'sfwd-topic', 'classnote'];
    
    if(in_array($post->post_type, $sfwd_content)) {

    echo $args['before_widget'] . $args['before_title'] . $title . $args['after_title']; 
    
    if( $classnotes->have_posts()) {
      
        while( $classnotes->have_posts() ) {
            $classnotes->the_post();
            $classnoteID = get_the_ID(); 
            
            if(has_user_classnote($classnoteID, $user_id)) { ?>
              
            <p class="classnote-menu--widget__item">
              <a class="classnote-menu--widget__link" href="<?php the_permalink(); ?>"> <?php echo get_the_title() ?> </a>
            </p>
            
    <?php 
            }
        } 
    } ?>

    <p class="classnote-more--widget">
      <a class="classnote-more--widget__link" href="<?php echo $moreLink ?>"><?php echo $moreLabel; ?></a>
    </p>   
    
    <?php echo $args['after_widget'];
    }
  }

  public function form( $instance ) {
    $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
    $moreLabel = ! empty( $instance['more-label'] ) ? $instance['more-label'] : '';
    $moreLink = ! empty( $instance['more-link'] ) ? $instance['more-link'] : ''; ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
      <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'more-label' ); ?>">Ver mas texto:</label>
      <input type="text" id="<?php echo $this->get_field_id( 'more-label' ); ?>" name="<?php echo $this->get_field_name( 'more-label' ); ?>" value="<?php echo esc_attr( $moreLabel ); ?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'more-link' ); ?>">Ver Mas link:</label>
      <input type="text" id="<?php echo $this->get_field_id( 'more-link' ); ?>" name="<?php echo $this->get_field_name( 'more-link' ); ?>" value="<?php echo esc_attr( $moreLink ); ?>" placeholder="https:// ..."/>
    </p><?php
  }

}

function getClassnotesByTerm() {

    $classnotes = new WP_Query( array(
      'post_type' => 'classnote',
      'posts_per_page' => '5',
      'orderby' => 'date',
      'order' => 'DESC'
    ) );

    return $classnotes;
}

function classnote_register_widget() { 
    register_widget( 'classnote_Widget' );
}
  add_action( 'widgets_init', 'classnote_register_widget' );
?>