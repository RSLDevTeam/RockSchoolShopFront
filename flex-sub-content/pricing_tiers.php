<?php
$section_id = get_sub_field('section_id');
$use_global_pricing_module_settings = get_sub_field('use_global_pricing_module_settings');
$get_pricing_field = function ($field_name) use ($use_global_pricing_module_settings) {
    if ($use_global_pricing_module_settings) {
        return get_field('global_pricing_module_' . $field_name, 'option');
    }

    return get_sub_field($field_name);
};

$title = $get_pricing_field('title');
$intro = $get_pricing_field('intro');
$tiers = $get_pricing_field('tiers');
$enable_offer_block = $get_pricing_field('enable_offer_block');
$offer_block_title = $get_pricing_field('offer_block_title');
$offer_block_content = $get_pricing_field('offer_block_content');
$offer_block_price = $get_pricing_field('offer_block_price');
$offer_block_button_text = $get_pricing_field('offer_block_button_text');
$offer_block_button_link = $get_pricing_field('offer_block_button_link');
$offer_block_price_note = $get_pricing_field('offer_block_price_note');
?>

<section <?php if ($section_id) : ?>id="<?php echo esc_attr($section_id); ?>" <?php endif; ?>class="pricing_tiers module-<?php echo esc_attr($flex_index); ?>">
    <div class="container mx-auto px-4 py-[6em] lg:px-16">

        <?php if ($title || $intro) : ?>
            <div class="pricing-tiers-intro max-w-3xl mx-auto text-center mb-12">
                <?php if ($title) : ?>
                    <h2 class="text-4xl md:text-5xl font-bold mb-6"><?php echo esc_html($title); ?></h2>
                <?php endif; ?>

                <?php if ($intro) : ?>
                    <div class="text-edgray prose max-w-none"><?php echo wp_kses_post($intro); ?></div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($tiers) : ?>
            <div class="pricing-tiers-grid" style="--pricing-tier-count: <?php echo esc_attr(count($tiers)); ?>;">
                <?php foreach ($tiers as $tier_index => $tier) :
                    $tier_title = $tier['title'] ?? '';
                    $highlight_tier = !empty($tier['highlight_tier']);
                    $badge_text = $tier['badge_text'] ?? '';
                    $stars = max(1, min(3, (int) ($tier['stars'] ?? 1)));
                    $price = $tier['price'] ?? '';
                    $button_text = $tier['button_text'] ?? '';
                    $button_link = $tier['button_link'] ?? '';
                    $price_notes = $tier['price_notes'] ?? '';
                    $feature_groups = $tier['feature_list'] ?? [];
                    $scalable_pricing = !empty($tier['scalable_pricing']);
                    $volume_pricing = $tier['volume_pricing'] ?? [];
                    $pricing_points = [];

                    if ($volume_pricing) {
                        foreach ($volume_pricing as $volume_price) {
                            $seats = isset($volume_price['seats']) ? (int) $volume_price['seats'] : 0;
                            $volume_price_value = $volume_price['price'] ?? '';

                            if ($seats > 0 && $volume_price_value !== '') {
                                $pricing_points[] = [
                                    'seats' => $seats,
                                    'price' => $volume_price_value,
                                ];
                            }
                        }

                        usort($pricing_points, function ($a, $b) {
                            return $a['seats'] <=> $b['seats'];
                        });
                    }

                    $has_scalable_pricing = $scalable_pricing && !empty($pricing_points);
                    $initial_price = $has_scalable_pricing ? $pricing_points[0]['price'] : $price;
                    $initial_seats = $has_scalable_pricing ? $pricing_points[0]['seats'] : 0;
                    $max_seats = $has_scalable_pricing ? $pricing_points[count($pricing_points) - 1]['seats'] : 0;
                    $pricing_json = $has_scalable_pricing ? wp_json_encode($pricing_points) : '';
                    $tier_classes = 'pricing-tier';

                    if ($highlight_tier) {
                        $tier_classes .= ' highlighted pricing-tier--highlighted';
                    }
                    ?>
                    <article class="<?php echo esc_attr($tier_classes); ?>" <?php if ($has_scalable_pricing) : ?>data-volume-pricing="<?php echo esc_attr($pricing_json); ?>"<?php endif; ?>>
                        <?php if ($badge_text) : ?>
                            <div class="pricing-tier-badge">
                                <?php echo esc_html($badge_text); ?>
                            </div>
                        <?php endif; ?>

                        <div class="pricing-tier-header text-center mb-8">
                            <?php if ($tier_title) : ?>
                                <h3 class="text-2xl font-bold mb-4"><?php echo esc_html($tier_title); ?></h3>
                            <?php endif; ?>

                            <div class="pricing-tier-stars" aria-label="<?php echo esc_attr($stars . ' star tier'); ?>">
                                <?php for ($star_index = 0; $star_index < $stars; $star_index++) : ?><span aria-hidden="true">&#9733;</span><?php endfor; ?>
                            </div>

                            <?php if ($initial_price) : ?>
                                <div class="pricing-tier-price" data-price-display><?php echo esc_html($initial_price); ?></div>
                            <?php endif; ?>
                        </div>

                        <?php if ($feature_groups) : ?>
                            <div class="pricing-tier-features">
                                <?php foreach ($feature_groups as $feature_group) :
                                    $feature_title = $feature_group['title'] ?? '';
                                    $feature_items = $feature_group['list'] ?? [];
                                    ?>
                                    <div class="pricing-tier-feature-group">
                                        <?php if ($feature_title) : ?>
                                            <h4 class="font-semibold mb-3"><?php echo esc_html($feature_title); ?></h4>
                                        <?php endif; ?>

                                        <?php if ($feature_items) : ?>
                                            <ul>
                                                <?php foreach ($feature_items as $feature_item) :
                                                    $feature_text = $feature_item['text'] ?? '';

                                                    if (!$feature_text) {
                                                        continue;
                                                    }
                                                    ?>
                                                    <li>
                                                        <span class="pricing-tier-check" aria-hidden="true">&#10003;</span>
                                                        <span><?php echo esc_html($feature_text); ?></span>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($has_scalable_pricing || $initial_price || ($button_link && $button_text) || $price_notes) : ?>
                            <div class="pricing-tier-actions">
                                <?php if ($has_scalable_pricing) : ?>
                                    <div class="pricing-tier-volume">
                                        <div class="pricing-tier-volume-meta">
                                            <span>Seats</span>
                                            <span><span data-seat-display><?php echo esc_html($initial_seats); ?></span></span>
                                        </div>
                                        <input
                                            type="range"
                                            class="pricing-tier-seat-slider"
                                            min="<?php echo esc_attr($initial_seats); ?>"
                                            max="<?php echo esc_attr($max_seats); ?>"
                                            step="1"
                                            value="<?php echo esc_attr($initial_seats); ?>"
                                            aria-label="<?php echo esc_attr($tier_title ? $tier_title . ' seats' : 'Seats'); ?>"
                                            data-seat-slider
                                        />
                                    </div>
                                <?php endif; ?>

                                <?php if ($initial_price) : ?>
                                    <div class="pricing-tier-action-price" data-price-display><?php echo esc_html($initial_price); ?></div>
                                <?php endif; ?>

                                <?php if ($button_link && $button_text) : ?>
                                    <a href="<?php echo esc_url($button_link); ?>" class="pricing-tier-button"><button><?php echo esc_html($button_text); ?></button></a>
                                <?php endif; ?>

                                <?php if ($price_notes) : ?>
                                    <div class="pricing-tier-price-notes"><?php echo wp_kses_post($price_notes); ?></div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($enable_offer_block && ($offer_block_title || $offer_block_content || $offer_block_price || ($offer_block_button_text && $offer_block_button_link))) : ?>
            <div class="offer-block">
                <div class="offer-block-content">
                    <?php if ($offer_block_title) : ?>
                        <h3><?php echo esc_html($offer_block_title); ?></h3>
                    <?php endif; ?>

                    <?php if ($offer_block_content) : ?>
                        <div class="offer-block-text"><?php echo wp_kses_post($offer_block_content); ?></div>
                    <?php endif; ?>
                </div>

                <?php if ($offer_block_price || ($offer_block_button_text && $offer_block_button_link)) : ?>
                    <div class="offer-block-action">
                        <?php if ($offer_block_price) : ?>
                            <div class="offer-block-price pricing-tier-action-price"><?php echo esc_html($offer_block_price); ?></div>
                        <?php endif; ?>

                        <?php if ($offer_block_button_text && $offer_block_button_link) : ?>
                            <a href="<?php echo esc_url($offer_block_button_link); ?>" class="offer-block-button"><button><?php echo esc_html($offer_block_button_text); ?></button></a>
                        <?php endif; ?>

                        <?php if ($offer_block_price_note) : ?>
                            <div class="offer-block-price-notes pricing-tier-price-notes"><?php echo wp_kses_post($offer_block_price_note); ?></div>
                        <?php endif; ?>

                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.pricing-tier[data-volume-pricing]').forEach(function(tier) {
        var slider = tier.querySelector('[data-seat-slider]');
        var seatDisplay = tier.querySelector('[data-seat-display]');
        var priceDisplays = tier.querySelectorAll('[data-price-display]');
        var pricingPoints = [];

        try {
            pricingPoints = JSON.parse(tier.getAttribute('data-volume-pricing')) || [];
        } catch (error) {
            pricingPoints = [];
        }

        if (!slider || !seatDisplay || !priceDisplays.length || !pricingPoints.length) {
            return;
        }

        var updatePrice = function() {
            var selectedSeats = parseInt(slider.value, 10);
            var activePoint = pricingPoints[0];

            pricingPoints.forEach(function(point) {
                if (parseInt(point.seats, 10) <= selectedSeats) {
                    activePoint = point;
                }
            });

            seatDisplay.textContent = selectedSeats;
            priceDisplays.forEach(function(priceDisplay) {
                priceDisplay.textContent = activePoint.price;
            });
        };

        slider.addEventListener('input', updatePrice);
        updatePrice();
    });
});
</script>
