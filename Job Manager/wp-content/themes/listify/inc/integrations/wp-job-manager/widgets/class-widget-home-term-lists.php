<?php
class Listify_Widget_Term_Lists extends Listify_Widget {

	public function __construct() {
		$this->widget_description = __( 'Display lists of listings associated with terms of a given taxonomy.', 'listify' );
		$this->widget_id          = 'listify_widget_taxonomy_term_lists';
		$this->widget_name        = __( 'Listify - Page: Category Lists', 'listify' );
		$this->widget_areas       = array( 'widget-area-home', 'widget-area-page' ); // valid widget areas
		$this->widget_notice      = __( 'Add this widget only in "Homepage" widget area.', 'listify' );

		$this->settings = array(
			'title'       => array(
				'type'  => 'text',
				'std'   => '',
				'label' => __( 'Title:', 'listify' ),
			),
			'description' => array(
				'type'  => 'text',
				'std'   => '',
				'label' => __( 'Description:', 'listify' ),
			),
			'terms'       => array(
				'label'   => __( 'Categories:', 'listify' ),
				'type'    => 'multiselect-term',
				'std'     => '',
				'options' => 'job_listing_category',
			),
			'limit'       => array(
				'type'  => 'number',
				'std'   => 5,
				'min'   => 1,
				'max'   => 30,
				'step'  => 1,
				'label' => __( 'Listings per category', 'listify' ),
			),
			'orderby'     => array(
				'label'   => __( 'Order By:', 'listify' ),
				'type'    => 'select',
				'std'     => 'date',
				'options' => array(
					'date'     => __( 'Date', 'listify' ),
					'featured' => __( 'Featured', 'listify' ),
					'title'    => __( 'Title', 'listify' ),
					'ID'       => __( 'ID', 'listify' ),
				),
			),
			'featured'    => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => __( 'Use only featured listings', 'listify' ),
			),
		);

		parent::__construct();
	}

	/**
	 * widget function.
	 *
	 * @see WP_Widget
	 * @access public
	 * @param array $args
	 * @param array $instance
	 * @return void
	 */
	function widget( $args, $instance ) {
		// Check widget areas context.
		if ( ! is_singular( 'page' ) ) {
			echo $this->widget_areas_notice(); // WPCS: XSS ok.

			return false;
		}

		$this->instance = $instance;

		extract( $args );

		$title       = apply_filters( 'widget_title', isset( $instance['title'] ) ? $instance['title'] : '', $instance, $this->id_base );
		$description = isset( $instance['description'] ) ? esc_attr( $instance['description'] ) : false;

		if ( $description && strpos( $after_title, '</div>' ) ) {
			$after_title = str_replace( '</div>', '', $after_title ) . '<p class="home-widget-description">' . $description . '</p></div>';
		}

		$limit    = isset( $instance['limit'] ) ? absint( $instance['limit'] ) : 3;
		$featured = isset( $instance['featured'] ) && 1 == $instance['featured'] ? true : null;
		$orderby  = isset( $instance['orderby'] ) ? $instance['orderby'] : 'date';

		$terms = isset( $instance['terms'] ) ? maybe_unserialize( $instance['terms'] ) : false;

		$args = apply_filters(
			'listify_widget_taxonomy_term_lists_get_terms',
			array(
				'include' => $terms,
			)
		);

		$terms = listify_get_terms( $args );

		if ( ! $terms ) {
			return;
		}

		$listings_by_term = $this->get_listings_by_term( $terms, $limit, $featured, $orderby );

		global $listify_job_manager;

		ob_start();

		echo $before_widget; // WPCS: XSS ok.

		if ( $title ) {
			echo $before_title . $title . $after_title; // WPCS: XSS ok.
		}
		?>

		<div class="listing-by-term-wrapper row" data-columns>

		<?php
		foreach ( $listings_by_term as $data ) :
			if ( ! $data['listings']->have_posts() ) {
				continue;}
			?>

			<div id="term-<?php echo esc_attr( $data['term']->term_id ); ?>" class="listings-by-term">
				<div class="listing-by-term-inner">
					<h2 class="listing-by-term-title"><a href="<?php echo esc_url( get_term_link( $data['term'], 'job_listing_category' ) ); ?>"><?php echo esc_attr( $data['term']->name ); ?></a></h2>

					<ul>
					<?php
					while ( $data['listings']->have_posts() ) :
						$data['listings']->the_post();
						?>

						<li>
							<a href="<?php the_permalink(); ?>" class="job_listing-clickbox"></a>

							<div class="listings-by-term-preview">
								<?php the_post_thumbnail(); ?>
							</div>

							<div class="listings-by-term-content">
								<?php the_title(); ?>
								<?php listify_the_listing_rating(); ?>
								<?php do_action( 'listify_listings_by_term_after' ); ?>
							</div>
						</li>

					<?php endwhile; ?>
					</ul>

					<div class="listings-by-term-more">
						<a href="<?php echo esc_url( get_term_link( $data['term'], 'job_listing_category' ) ); ?>"><?php esc_html_e( 'More', 'listify' ); ?></a>
					</div>
				</div>
			</div>

		<?php endforeach; ?>

		</div>

		<?php
		echo $after_widget; // WPCS: XSS ok.

		$content = ob_get_clean();

		echo apply_filters( $this->widget_id, $content ); // WPCS: XSS ok.
	}

	public function get_listings_by_term( $terms, $limit, $featured, $orderby ) {
		if ( empty( $terms ) ) {
			return array( -1 );
		}

		foreach ( $terms as $term ) {
			$objects = get_objects_in_term(
				$term->term_id,
				'job_listing_category',
				array(
					'orderby' => $orderby,
				)
			);

			if ( empty( $objects ) ) {
				$objects = array( -1 );
			}

			$_output[] = array(
				'term'     => $term,
				'listings' => get_job_listings(
					array(
						'posts_per_page' => $limit,
						'featured'       => $featured,
						'orderby'        => $orderby,
						'no_found_rows'  => true,
						'post__in'       => $objects,
					)
				),
			);
		}

		return $_output;
	}

}
