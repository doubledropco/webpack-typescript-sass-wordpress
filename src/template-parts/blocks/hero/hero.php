<?php

/**
 * ACF Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */


$slides = get_field('slides');
$background_image = $is_preview ? '' : get_field('background_image');
$background_overlay = $is_preview ? '' : get_field('background_overlay');

if ($background_image) {
    $background_image_src = wp_get_attachment_image_src($background_image, 'fullscreen')[0];
}

$id = 'hero-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

$className = 'hero';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

?>
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <div class="hero__bg parallax" data-bg="<?php echo $background_image_src; ?>"></div>
    <?php if ($background_overlay): ?>
        <div class="hero__overlay"></div>
    <?php endif; ?>
    <div class="hero__carousel">
        <?php 
            if ($slides): foreach ($slides as $slide): 
                $headline = $slide['headline']; 
                $copy = $slide['copy']; 
                $cta = $slide['cta']; 
        ?>
            <div class="hero__carousel-cell">
                <div class="hero__slide">
                    <div class="hero__slide-content">
                        <div class="hero__slide-left">
                            <h2 class="sm-element sm-element--d1"><?php echo $headline; ?></h2>
                        </div>
                        <div class="hero__slide-right">
                            <div class="hero__copy sm-element sm-element--d2">
                                <?php if ($copy): ?>
                                    <?php echo $copy; ?>
                                <?php endif; ?>
                            </div>

                            <?php if ($cta): ?>
                                <div class="hero__cta-wrap sm-element sm-element--d3">
                                    <?php button($cta, 'btn-primary'); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; endif; ?>
    </div>
    
</div>
