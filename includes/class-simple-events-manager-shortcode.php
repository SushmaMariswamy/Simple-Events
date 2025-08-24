<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Simple_Events_Manager_Shortcode {
    public function __construct() {
        add_shortcode( 'events_list', array( $this, 'render_shortcode' ) );
    }

    public function render_shortcode( $atts ) {
        $atts = shortcode_atts( array(
            'count' => 10,
            'show_past' => 'false',
            'order' => 'ASC',
        ), $atts, 'events_list' );

        $meta_query = array();
        if ( $atts['show_past'] !== 'true' ) {
            $meta_query[] = array(
                'key' => '_sem_event_date',
                'value' => date( 'Y-m-d' ),
                'compare' => '>=',
                'type' => 'DATE'
            );
        }

        $query = new WP_Query( array(
            'post_type' => 'event',
            'posts_per_page' => intval( $atts['count'] ),
            'meta_key' => '_sem_event_date',
            'orderby' => 'meta_value',
            'order' => $atts['order'],
            'meta_query' => $meta_query
        ) );

        ob_start();
        if ( $query->have_posts() ) {
            echo '<div class="events-grid">';
            while ( $query->have_posts() ) {
                $query->the_post();
                $date = get_post_meta( get_the_ID(), '_sem_event_date', true );
                $location = get_post_meta( get_the_ID(), '_sem_event_location', true );
                $organizer = get_post_meta( get_the_ID(), '_sem_event_organizer', true );
                ?>
                <div class="event-card">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="event-image">
                            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?></a>
                        </div>
                    <?php endif; ?>
                    <div class="event-content">
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <?php if ( $date ) : ?><p><strong>Date:</strong> <?php echo esc_html( $date ); ?></p><?php endif; ?>
                        <?php if ( $location ) : ?><p><strong>Location:</strong> <?php echo esc_html( $location ); ?></p><?php endif; ?>
                        <?php if ( $organizer ) : ?><p><strong>Organizer:</strong> <?php echo esc_html( $organizer ); ?></p><?php endif; ?>
                        <a class="view-details" href="<?php the_permalink(); ?>">View Details</a>
                    </div>
                </div>
                <?php
            }
            echo '</div>';
            wp_reset_postdata();
        } else {
            echo '<p>No events found.</p>';
        }
        return ob_get_clean();
    }
}
new Simple_Events_Manager_Shortcode();
?>
