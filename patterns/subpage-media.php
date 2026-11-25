<?php
/**
 * Title: Subpage: Media & stories
 * Slug: dermatex/subpage-media
 * Categories: dermatex-pages
 * Keywords: subpage, media, gallery, video, stories, before after
 * Description: Filterable photo gallery, YouTube video band and a featured story.
 * Block Types: core/post-content
 * Post Types: page
 * Viewport Width: 1440
 * Inserter: true
 */
?>
<!-- wp:group {"tagName":"section","className":"dx-subhero dx-subpage--media","layout":{"type":"constrained","wideSize":"1312px"}} -->
<section class="wp-block-group dx-subhero dx-subpage--media">
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
<p class="dx-eyebrow">Real lives / Personal stories</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Your story starts with you.</h1>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"dx-lede"} -->
<p class="dx-lede">Different experiences. Personal choices. Explore the stories behind a more confident everyday.</p>
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
<!-- wp:group {"tagName":"section","className":"dx-section is-style-band-canvas","layout":{"type":"constrained","wideSize":"1312px"}} -->
<section class="wp-block-group dx-section is-style-band-canvas">
<!-- wp:group {"align":"wide","className":"dx-stack","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide dx-stack">
<!-- wp:paragraph {"className":"dx-eyebrow"} -->
<p class="dx-eyebrow">The people behind the hair</p>
<!-- /wp:paragraph -->
<!-- wp:heading -->
<h2 class="wp-block-heading">A personal choice, in their own words.</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Take your time exploring. Every person’s starting point, routine and preferences are different. Your own consultation is a place to discuss what matters to you.</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"dx-note"} -->
<p class="dx-note">Layout previews use editorial imagery, not client results. Replace with approved photos, names and timelines before publishing.</p>
<!-- /wp:paragraph -->

</div>
<!-- /wp:group -->

</section>
<!-- /wp:group -->
<!-- wp:group {"tagName":"section","anchor":"gallery","className":"dx-section is-style-band-soft","layout":{"type":"constrained","wideSize":"1312px"}} -->
<section id="gallery" class="wp-block-group dx-section is-style-band-soft">
<!-- wp:group {"align":"wide","className":"dx-stack","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide dx-stack">
<!-- wp:paragraph {"className":"dx-gallery-status"} -->
<p class="dx-gallery-status">Photos shared with client permission.</p>
<!-- /wp:paragraph -->
<!-- wp:group {"className":"dx-gallery","layout":{"type":"default"}} -->
<div class="wp-block-group dx-gallery">
<!-- wp:group {"className":"dx-tile dx-cat-men dx-cat-hair-systems dx-tile--compare","layout":{"type":"default"}} -->
<div class="wp-block-group dx-tile dx-cat-men dx-cat-hair-systems dx-tile--compare">
<!-- wp:group {"className":"dx-tile__compare","layout":{"type":"default"}} -->
<div class="wp-block-group dx-tile__compare">
<!-- wp:dermatex/compare {"placeholderBefore":"Approved before photo pending","placeholderAfter":"Approved after photo pending","caption":""} /-->

</div>
<!-- /wp:group -->
<!-- wp:group {"className":"dx-tile__body","layout":{"type":"default"}} -->
<div class="wp-block-group dx-tile__body">
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Before &amp; after / hair systems</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>First name · Service · Timeline to confirm</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"dx-note"} -->
<p class="dx-note">Approved client photography pending</p>
<!-- /wp:paragraph -->

</div>
<!-- /wp:group -->

</div>
<!-- /wp:group -->
<!-- wp:group {"className":"dx-tile dx-cat-men dx-cat-hair-systems","layout":{"type":"default"}} -->
<div class="wp-block-group dx-tile dx-cat-men dx-cat-hair-systems">
<!-- wp:image {"sizeSlug":"large","linkDestination":"none","lightbox":{"enabled":true},"className":"dx-tile__img"} -->
<figure class="wp-block-image size-large dx-tile__img"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/img/sample-man-beach.jpg' ) ); ?>" alt="A man walking on a beach"/></figure>
<!-- /wp:image -->
<!-- wp:group {"className":"dx-tile__body","layout":{"type":"default"}} -->
<div class="wp-block-group dx-tile__body">
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Hair systems / everyday life</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>First name · Hair systems · Timeline to confirm</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"dx-note"} -->
<p class="dx-note">Editorial preview · not a client result</p>
<!-- /wp:paragraph -->

</div>
<!-- /wp:group -->

</div>
<!-- /wp:group -->
<!-- wp:group {"className":"dx-tile dx-cat-women","layout":{"type":"default"}} -->
<div class="wp-block-group dx-tile dx-cat-women">
<!-- wp:image {"sizeSlug":"large","linkDestination":"none","lightbox":{"enabled":true},"className":"dx-tile__img"} -->
<figure class="wp-block-image size-large dx-tile__img"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/img/sample-woman-garden.jpg' ) ); ?>" alt="A smiling woman outdoors"/></figure>
<!-- /wp:image -->
<!-- wp:group {"className":"dx-tile__body","layout":{"type":"default"}} -->
<div class="wp-block-group dx-tile__body">
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Women’s hair / a personal fit</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>First name · Women’s hair · Timeline to confirm</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"dx-note"} -->
<p class="dx-note">Editorial preview · not a client result</p>
<!-- /wp:paragraph -->

</div>
<!-- /wp:group -->

</div>
<!-- /wp:group -->
<!-- wp:group {"className":"dx-tile dx-cat-men dx-cat-smp","layout":{"type":"default"}} -->
<div class="wp-block-group dx-tile dx-cat-men dx-cat-smp">
<!-- wp:image {"sizeSlug":"large","linkDestination":"none","lightbox":{"enabled":true},"className":"dx-tile__img"} -->
<figure class="wp-block-image size-large dx-tile__img"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/img/sample-man-bench.jpg' ) ); ?>" alt="A man sitting on a bench by the coast"/></figure>
<!-- /wp:image -->
<!-- wp:group {"className":"dx-tile__body","layout":{"type":"default"}} -->
<div class="wp-block-group dx-tile__body">
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">SMP / explore the detail</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>First name · SMP · Timeline to confirm</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"dx-note"} -->
<p class="dx-note">Editorial preview · not a client result</p>
<!-- /wp:paragraph -->

</div>
<!-- /wp:group -->

</div>
<!-- /wp:group -->
<!-- wp:group {"className":"dx-tile dx-cat-men dx-cat-women","layout":{"type":"default"}} -->
<div class="wp-block-group dx-tile dx-cat-men dx-cat-women">
<!-- wp:image {"sizeSlug":"large","linkDestination":"none","lightbox":{"enabled":true},"className":"dx-tile__img"} -->
<figure class="wp-block-image size-large dx-tile__img"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/img/sample-studio-consult.jpg' ) ); ?>" alt="A specialist and a client talking at a table"/></figure>
<!-- /wp:image -->
<!-- wp:group {"className":"dx-tile__body","layout":{"type":"default"}} -->
<div class="wp-block-group dx-tile__body">
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">In the studio / first steps</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>First name · Consultation · Timeline to confirm</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"dx-note"} -->
<p class="dx-note">Editorial preview · not a client result</p>
<!-- /wp:paragraph -->

</div>
<!-- /wp:group -->

</div>
<!-- /wp:group -->
<!-- wp:group {"className":"dx-tile dx-cat-women dx-cat-extensions","layout":{"type":"default"}} -->
<div class="wp-block-group dx-tile dx-cat-women dx-cat-extensions">
<!-- wp:image {"sizeSlug":"large","linkDestination":"none","lightbox":{"enabled":true},"className":"dx-tile__img"} -->
<figure class="wp-block-image size-large dx-tile__img"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/img/sample-hair-swatches.jpg' ) ); ?>" alt="Hair color swatches beside a comb"/></figure>
<!-- /wp:image -->
<!-- wp:group {"className":"dx-tile__body","layout":{"type":"default"}} -->
<div class="wp-block-group dx-tile__body">
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Hair additions / your options</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>First name · Hair additions · Timeline to confirm</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"dx-note"} -->
<p class="dx-note">Editorial preview · not a client result</p>
<!-- /wp:paragraph -->

</div>
<!-- /wp:group -->

</div>
<!-- /wp:group -->

</div>
<!-- /wp:group -->
<!-- wp:buttons {"className":"dx-load-more"} -->
<div class="wp-block-buttons dx-load-more">
<!-- wp:button {"className":"is-style-gold"} -->
<div class="wp-block-button is-style-gold"><a class="wp-block-button__link wp-element-button" href="#gallery">Load more stories</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->

</div>
<!-- /wp:group -->

</section>
<!-- /wp:group -->
<!-- wp:group {"tagName":"section","className":"dx-section is-style-band-navy dx-videos","layout":{"type":"constrained","wideSize":"1312px"}} -->
<section class="wp-block-group dx-section is-style-band-navy dx-videos">
<!-- wp:group {"align":"wide","className":"dx-stack","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide dx-stack">
<!-- wp:paragraph {"className":"dx-eyebrow"} -->
<p class="dx-eyebrow">Watch / Listen / Take your time</p>
<!-- /wp:paragraph -->
<!-- wp:heading -->
<h2 class="wp-block-heading">A closer look at a personal process.</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Meet the people behind the conversation. Choose a film, watch at your own pace or read the transcript.</p>
<!-- /wp:paragraph -->
<!-- wp:group {"className":"dx-video-main","layout":{"type":"default"}} -->
<div class="wp-block-group dx-video-main">
<!-- wp:paragraph {"className":"dx-ph dx-ph--video dx-ph--16x9"} -->
<p class="dx-ph dx-ph--video dx-ph--16x9"><strong>YouTube video · replace with an Embed block</strong>Your first private consultation · Duration [00:00] · Approved video pending</p>
<!-- /wp:paragraph -->

</div>
<!-- /wp:group -->
<!-- wp:paragraph -->
<p><a href="#transcript">Read the transcript ↗</a></p>
<!-- /wp:paragraph -->
<!-- wp:group {"className":"dx-grid dx-grid--3 dx-video-grid","layout":{"type":"default"}} -->
<div class="wp-block-group dx-grid dx-grid--3 dx-video-grid">
<!-- wp:paragraph {"className":"dx-ph dx-ph--video dx-ph--16x9"} -->
<p class="dx-ph dx-ph--video dx-ph--16x9"><strong>YouTube · [00:00]</strong>Spencer’s story · Video pending</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"dx-ph dx-ph--video dx-ph--16x9"} -->
<p class="dx-ph dx-ph--video dx-ph--16x9"><strong>YouTube · [00:00]</strong>Monique’s story · Video pending</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"dx-ph dx-ph--video dx-ph--16x9"} -->
<p class="dx-ph dx-ph--video dx-ph--16x9"><strong>YouTube · [00:00]</strong>How it works · Video pending</p>
<!-- /wp:paragraph -->

</div>
<!-- /wp:group -->

</div>
<!-- /wp:group -->

</section>
<!-- /wp:group -->
<!-- wp:group {"tagName":"section","className":"dx-section is-style-band-canvas","layout":{"type":"constrained","wideSize":"1312px"}} -->
<section class="wp-block-group dx-section is-style-band-canvas">
<!-- wp:group {"align":"wide","className":"dx-stack","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide dx-stack">
<!-- wp:group {"className":"dx-grid dx-grid--2 dx-split","layout":{"type":"default"}} -->
<div class="wp-block-group dx-grid dx-grid--2 dx-split">
<!-- wp:image {"sizeSlug":"large","linkDestination":"none","lightbox":{"enabled":true},"className":"dx-split__img"} -->
<figure class="wp-block-image size-large dx-split__img"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/img/sample-man-beach.jpg' ) ); ?>" alt="A man walking on a beach at sunset"/></figure>
<!-- /wp:image -->
<!-- wp:group {"className":"dx-stack","layout":{"type":"default"}} -->
<div class="wp-block-group dx-stack">
<!-- wp:paragraph {"className":"dx-eyebrow"} -->
<p class="dx-eyebrow">Spencer / A personal story</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"dx-story__quote"} -->
<p class="dx-story__quote">“I don’t wear one any more because I want to show off my hair.”</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"dx-attrib"} -->
<p class="dx-attrib">Spencer · Dermatex client</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph -->
<p>Male pattern baldness and a receding hairline affected Spencer’s confidence. His story begins with a private conversation.</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph -->
<p><a href="/#stories">Read full story →</a></p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"dx-note"} -->
<p class="dx-note">Quote reused from the homepage. Editorial photo shown for layout only.</p>
<!-- /wp:paragraph -->

</div>
<!-- /wp:group -->

</div>
<!-- /wp:group -->

</div>
<!-- /wp:group -->

</section>
<!-- /wp:group -->
<!-- wp:group {"tagName":"section","className":"dx-section is-style-band-soft dx-contact","layout":{"type":"constrained","wideSize":"1312px"}} -->
<section class="wp-block-group dx-section is-style-band-soft dx-contact">
<!-- wp:group {"align":"wide","className":"dx-stack","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide dx-stack">
<!-- wp:group {"className":"dx-contact__head","layout":{"type":"default"}} -->
<div class="wp-block-group dx-contact__head">
<!-- wp:group {"className":"dx-stack","layout":{"type":"default"}} -->
<div class="wp-block-group dx-stack">
<!-- wp:paragraph {"className":"dx-eyebrow"} -->
<p class="dx-eyebrow">Let’s talk about you</p>
<!-- /wp:paragraph -->
<!-- wp:heading -->
<h2 class="wp-block-heading">See what’s possible for you</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>A free, private conversation. About one hour, in our Laguna Hills studio or by Zoom.</p>
<!-- /wp:paragraph -->

</div>
<!-- /wp:group -->
<!-- wp:buttons {"className":"dx-contact__buttons"} -->
<div class="wp-block-buttons dx-contact__buttons">
<!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="/#contact">Book a Consultation</a></div>
<!-- /wp:button -->
<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="tel:+19493052661">Call (949) 305-2661</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->

</div>
<!-- /wp:group -->
<!-- wp:group {"className":"dx-contact__info","layout":{"type":"default"}} -->
<div class="wp-block-group dx-contact__info">
<!-- wp:group {"className":"dx-stack","layout":{"type":"default"}} -->
<div class="wp-block-group dx-stack">
<!-- wp:paragraph {"className":"dx-eyebrow"} -->
<p class="dx-eyebrow">Call the studio</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph -->
<p><a href="tel:+19493052661">(949) 305-2661</a></p>
<!-- /wp:paragraph -->

</div>
<!-- /wp:group -->
<!-- wp:group {"className":"dx-stack","layout":{"type":"default"}} -->
<div class="wp-block-group dx-stack">
<!-- wp:paragraph {"className":"dx-eyebrow"} -->
<p class="dx-eyebrow">Visit Laguna Hills</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph -->
<p>23201 Mill Creek Dr #225<br>Laguna Hills, CA 92653</p>
<!-- /wp:paragraph -->

</div>
<!-- /wp:group -->
<!-- wp:group {"className":"dx-stack","layout":{"type":"default"}} -->
<div class="wp-block-group dx-stack">
<!-- wp:paragraph {"className":"dx-eyebrow"} -->
<p class="dx-eyebrow">Studio hours</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph -->
<p>Mon–Fri 9–6 · Sat 9–5<br>Sun closed</p>
<!-- /wp:paragraph -->

</div>
<!-- /wp:group -->

</div>
<!-- /wp:group -->
<!-- wp:paragraph {"className":"dx-contact__zoom"} -->
<p class="dx-contact__zoom"><a href="/#contact">Virtual Zoom consult ↗</a></p>
<!-- /wp:paragraph -->

</div>
<!-- /wp:group -->

</section>
<!-- /wp:group -->
