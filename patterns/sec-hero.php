<?php
/**
 * Title: Section: Subpage hero (banner image)
 * Slug: dermatex/sec-hero
 * Categories: dermatex-sections
 * Keywords: hero, banner, subpage
 * Inserter: true
 */
?>
<!-- wp:group {"tagName":"section","className":"dx-subhero dx-subpage--info","layout":{"type":"constrained","wideSize":"1312px"}} -->
<section class="wp-block-group dx-subhero dx-subpage--info">
<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"dx-subhero__bg"} -->
<figure class="wp-block-image size-full dx-subhero__bg"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/img/sample-studio-consult.jpg' ) ); ?>" alt=""/></figure>
<!-- /wp:image -->
<!-- wp:group {"align":"wide","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide">
<!-- wp:group {"className":"dx-subhero__text dx-stack","layout":{"type":"default"}} -->
<div class="wp-block-group dx-subhero__text dx-stack">
<!-- wp:paragraph {"className":"dx-crumbs"} -->
<p class="dx-crumbs">[dx_breadcrumb]</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"dx-eyebrow"} -->
<p class="dx-eyebrow">Eyebrow label</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Page title</h1>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"dx-lede"} -->
<p class="dx-lede">One or two sentences introducing the page.</p>
<!-- /wp:paragraph -->
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"className":"is-style-gold"} -->
<div class="wp-block-button is-style-gold"><a class="wp-block-button__link wp-element-button" href="/#contact">Book a Consultation</a></div>
<!-- /wp:button -->
<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="tel:+19493052661">Call (949) 305-2661</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->

</div>
<!-- /wp:group -->

</div>
<!-- /wp:group -->

</section>
<!-- /wp:group -->
