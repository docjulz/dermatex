<?php
/**
 * Before / After compare block (server-rendered).
 *
 * @var array $attributes Block attributes.
 */

defined( 'ABSPATH' ) || exit;

$a        = wp_parse_args( $attributes, array() );
$has_imgs = ! empty( $a['beforeUrl'] ) && ! empty( $a['afterUrl'] );
$start    = max( 0, min( 100, (int) ( $a['start'] ?? 50 ) ) );
$uid      = wp_unique_id( 'dx-compare-' );

$wrapper = get_block_wrapper_attributes(
	array(
		'class'         => 'dx-compare' . ( $has_imgs ? '' : ' dx-compare--placeholder' ),
		'style'         => '--dx-pos:' . $start . '%',
		'data-dx-compare' => '',
	)
);

$img = static function ( $id, $url, $alt ) {
	if ( $id ) {
		$tag = wp_get_attachment_image( (int) $id, 'large', false, array( 'alt' => $alt, 'loading' => 'lazy', 'decoding' => 'async' ) );
		if ( $tag ) {
			return $tag;
		}
	}
	return sprintf( '<img src="%s" alt="%s" loading="lazy" decoding="async">', esc_url( $url ), esc_attr( $alt ) );
};
?>
<figure <?php echo $wrapper; // phpcs:ignore WordPress.Security.EscapeOutput ?>>
	<div class="dx-compare__stage">
		<div class="dx-compare__pane dx-compare__after">
			<?php if ( $has_imgs ) : ?>
				<?php echo $img( $a['afterId'] ?? 0, $a['afterUrl'], $a['afterAlt'] ); // phpcs:ignore ?>
			<?php else : ?>
				<p class="dx-compare__ph"><?php echo esc_html( $a['placeholderAfter'] ); ?></p>
			<?php endif; ?>
			<span class="dx-compare__label dx-compare__label--after"><?php echo esc_html( $a['afterLabel'] ); ?></span>
		</div>
		<div class="dx-compare__pane dx-compare__before">
			<?php if ( $has_imgs ) : ?>
				<?php echo $img( $a['beforeId'] ?? 0, $a['beforeUrl'], $a['beforeAlt'] ); // phpcs:ignore ?>
			<?php else : ?>
				<p class="dx-compare__ph"><?php echo esc_html( $a['placeholderBefore'] ); ?></p>
			<?php endif; ?>
			<span class="dx-compare__label dx-compare__label--before"><?php echo esc_html( $a['beforeLabel'] ); ?></span>
		</div>
		<span class="dx-compare__handle" aria-hidden="true">
			<svg viewBox="0 0 24 24"><path d="M8 7l-5 5 5 5M16 7l5 5-5 5M3 12h18"/></svg>
		</span>
		<label class="screen-reader-text" for="<?php echo esc_attr( $uid ); ?>"><?php esc_html_e( 'Compare before and after photos', 'dermatex' ); ?></label>
		<input id="<?php echo esc_attr( $uid ); ?>" class="dx-compare__range" type="range" min="0" max="100" step="1" value="<?php echo esc_attr( $start ); ?>">
	</div>
	<?php if ( ! empty( $a['caption'] ) ) : ?>
		<figcaption class="dx-compare__caption"><?php echo esc_html( $a['caption'] ); ?></figcaption>
	<?php endif; ?>
</figure>
