<?php
$backstage_franchise_id = absint($args['backstage_franchise_id'] ?? rsl_shopfront_get_backstage_franchise_id(get_the_ID()));
$calendar = is_array($args['calendar'] ?? null)
    ? $args['calendar']
    : rsl_shopfront_get_guestlist_calendar_data($backstage_franchise_id);

if (is_wp_error($calendar)) {
    if (defined('WP_DEBUG') && WP_DEBUG) {
        error_log('Guestlist provider calendar: ' . $calendar->get_error_message());
    }
    return;
}

$classes = $calendar['classes'] ?? [];
$lessons = $calendar['lessons'] ?? [];
$default_tab = !empty($classes) ? 'classes' : 'lessons';
$all_items = array_merge($classes, $lessons);
$days = [];
foreach ($all_items as $item) {
    if (!empty($item['date'])) {
        $timestamp = strtotime($item['date']);
        if ($timestamp) {
            $days[date('N', $timestamp)] = date('l', $timestamp);
        }
    }
}
ksort($days);

$render_cards = static function (array $items): void {
    foreach ($items as $item) {
        $timestamp = !empty($item['date']) ? strtotime($item['date']) : false;
        $day_name = $timestamp ? date('l', $timestamp) : '';
        $short_day = $timestamp ? date('D', $timestamp) : '';
        $date_label = $timestamp ? date('j M Y', $timestamp) : '';
        $start_timestamp = !empty($item['start_time']) ? strtotime($item['start_time']) : false;
        $end_timestamp = !empty($item['end_time']) ? strtotime($item['end_time']) : false;
        $time_label = $start_timestamp ? date('g:i a', $start_timestamp) : '';
        $duration = $start_timestamp && $end_timestamp ? max(0, (int) (($end_timestamp - $start_timestamp) / 60)) : '';
        $schedule = 'lesson' === $item['type']
            ? trim($date_label . ($time_label ? ' at ' . $time_label : ''))
            : trim($day_name . ($day_name ? 's' : '') . ($time_label ? ' at ' . $time_label : ''));
        ?>
        <article
            class="guestlist-calendar-card"
            data-calendar-card
            data-discipline="<?php echo esc_attr(strtolower($item['discipline'])); ?>"
            data-day="<?php echo esc_attr(strtolower($day_name)); ?>"
        >
            <div class="guestlist-calendar-card__top">
                <div class="guestlist-calendar-date" aria-label="<?php echo esc_attr($date_label); ?>">
                    <span><?php echo esc_html($timestamp ? strtoupper(date('d', $timestamp)) : '—'); ?></span>
                    <small><?php echo esc_html($timestamp ? strtoupper(date('M', $timestamp)) : ''); ?></small>
                </div>
                <?php if (!empty($item['discipline'])) : ?>
                    <span class="guestlist-calendar-discipline"><?php echo esc_html($item['discipline']); ?></span>
                <?php endif; ?>
            </div>

            <div class="guestlist-calendar-card__body">
                <h3><?php echo esc_html($item['name']); ?></h3>
                <?php if (!empty($item['description'])) : ?>
                    <p class="guestlist-calendar-description"><?php echo esc_html($item['description']); ?></p>
                <?php endif; ?>
                <?php if ($schedule || !empty($item['instructor'])) : ?>
                    <p class="guestlist-calendar-schedule">
                        <?php echo esc_html($schedule); ?>
                        <?php if (!empty($item['instructor'])) : ?>
                            <?php echo esc_html(sprintf(__(' with %s', 'rockschool'), $item['instructor'])); ?>
                        <?php endif; ?>
                    </p>
                <?php endif; ?>

                <div class="guestlist-calendar-meta">
                    <div><strong><?php echo esc_html(ucfirst($item['type'])); ?></strong><small><?php esc_html_e('type', 'rockschool'); ?></small></div>
                    <div><strong><?php echo esc_html($short_day ?: '—'); ?></strong><small><?php esc_html_e('day', 'rockschool'); ?></small></div>
                    <div><strong><?php echo esc_html($time_label ?: '—'); ?></strong><small><?php esc_html_e('time', 'rockschool'); ?></small></div>
                    <div><strong><?php echo esc_html('' !== $duration ? $duration : '—'); ?></strong><small><?php echo esc_html('' !== $duration ? _n('min', 'mins', $duration, 'rockschool') : __('mins', 'rockschool')); ?></small></div>
                </div>

                <p class="guestlist-calendar-detail">
                    <strong><?php echo esc_html('lesson' === $item['type'] ? __('Lesson', 'rockschool') : __('Class', 'rockschool')); ?></strong>
                    <?php echo esc_html('lesson' === $item['type'] ? sprintf(__('date %s', 'rockschool'), $date_label) : ($item['recurrence'] ?: $date_label)); ?>
                </p>
                <p class="guestlist-calendar-price">
                    <?php esc_html_e('Cost per lesson from', 'rockschool'); ?>
                    <strong><?php echo esc_html($item['price_formatted']); ?></strong>
                </p>
            </div>

            <a class="guestlist-calendar-cta" href="<?php echo esc_url($item['book_url']); ?>" target="_blank" rel="noopener noreferrer">
                <?php esc_html_e('Book now', 'rockschool'); ?>
            </a>
        </article>
        <?php
    }
};
?>

<section class="guestlist-provider-calendar" data-guestlist-calendar data-default-tab="<?php echo esc_attr($default_tab); ?>" data-aos="zoom-in">
    <header class="guestlist-provider-calendar__header">
        <div>
            <h2><?php esc_html_e('Upcoming classes & lessons', 'rockschool'); ?></h2>
        </div>
        <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/img/cal-icon.svg'); ?>" class="cal-icon" alt="" aria-hidden="true">
    </header>

    <div class="guestlist-calendar-toolbar">
        <div class="guestlist-calendar-filters">
            <label>
                <span><?php esc_html_e('Discipline', 'rockschool'); ?></span>
                <select data-calendar-discipline>
                    <option value=""><?php esc_html_e('All disciplines', 'rockschool'); ?></option>
                    <?php foreach ($calendar['disciplines'] as $discipline) : ?>
                        <option value="<?php echo esc_attr(strtolower($discipline)); ?>"><?php echo esc_html($discipline); ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label>
                <span><?php esc_html_e('Day', 'rockschool'); ?></span>
                <select data-calendar-day>
                    <option value=""><?php esc_html_e('All days', 'rockschool'); ?></option>
                    <?php foreach ($days as $day) : ?>
                        <option value="<?php echo esc_attr(strtolower($day)); ?>"><?php echo esc_html($day); ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>
        <?php if (!empty($lessons)) : ?>
            <div class="guestlist-calendar-tabs" role="tablist" aria-label="<?php esc_attr_e('Schedule type', 'rockschool'); ?>">
                <button type="button" data-calendar-tab="classes" role="tab"><?php esc_html_e('Regular classes', 'rockschool'); ?></button>
                <button type="button" data-calendar-tab="lessons" role="tab"><?php esc_html_e('Individual lessons', 'rockschool'); ?></button>
            </div>
        <?php endif; ?>
    </div>

    <?php foreach (['classes' => $classes, 'lessons' => $lessons] as $panel_name => $items) : ?>
        <div class="guestlist-calendar-panel" data-calendar-panel="<?php echo esc_attr($panel_name); ?>">
            <?php if (empty($items)) : ?>
                <p class="guestlist-calendar-empty"><?php echo esc_html('classes' === $panel_name ? __('No regular classes are currently available.', 'rockschool') : __('No individual lessons are currently available.', 'rockschool')); ?></p>
            <?php endif; ?>
            <p class="guestlist-calendar-empty" data-calendar-filter-empty hidden><?php echo esc_html('classes' === $panel_name ? __('No classes found.', 'rockschool') : __('No lessons found.', 'rockschool')); ?></p>
            <div class="guestlist-calendar-grid"><?php $render_cards($items); ?></div>
            <div class="guestlist-calendar-actions" data-calendar-actions hidden>
                <button type="button" data-calendar-more><?php echo esc_html('classes' === $panel_name ? __('Load More Classes', 'rockschool') : __('Load More Lessons', 'rockschool')); ?></button>
            </div>
        </div>
    <?php endforeach; ?>
</section>
