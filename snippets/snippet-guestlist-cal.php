<?php // guestlist calendar per franchisee

echo '<!-- Guestlist Calendar Snippet Loaded -->';

$snippet_args = isset($args) && is_array($args) ? $args : [];
$franscape_id = $snippet_args['franscape_id'] ?? get_field('franscape_id');
$instance_id = !empty($snippet_args['instance_id']) ? sanitize_html_class($snippet_args['instance_id']) : 'guestlist-calendar-default';
$classes_panel_id = $instance_id . '-classes';
$lessons_panel_id = $instance_id . '-lessons';
$discipline_select_id = $instance_id . '-discipline-select';
$widget_selector = '#' . $instance_id;

$classes = [];
$lessons = [];

$guestlist_url = get_field('guestlist_url', 'option') ?: 'https://guestlist.rockschool.io';

if ($franscape_id) {
    $api_url = $guestlist_url . '/api/classes/?backstage_franchise_id=' . urlencode($franscape_id);

    $response = wp_remote_get($api_url, [
        'timeout' => 10,
    ]);

    if (is_array($response) && !is_wp_error($response)) {
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        if (!empty($data['data'])) {
            $classes = !empty($data['data']['classes']) && is_array($data['data']['classes']) ? $data['data']['classes'] : [];
            $lessons = !empty($data['data']['lessons']) && is_array($data['data']['lessons']) ? $data['data']['lessons'] : [];
        }
    }
}

if (!function_exists('guestlist_parse_date')) {
    function guestlist_parse_date($date_string) {
        if (empty($date_string)) {
            return null;
        }

        try {
            return new DateTime($date_string);
        } catch (Exception $e) {
            return null;
        }
    }
}

if (!function_exists('guestlist_format_time')) {
    function guestlist_format_time($time_string) {
        if (empty($time_string)) {
            return '';
        }

        $time = DateTime::createFromFormat('H:i', $time_string);
        if (!$time) {
            return $time_string;
        }

        return $time->format('H:i');
    }
}

if (!function_exists('guestlist_duration_minutes')) {
    function guestlist_duration_minutes($start_time, $end_time) {
        if (empty($start_time) || empty($end_time)) {
            return null;
        }

        $start = DateTime::createFromFormat('H:i', $start_time);
        $end = DateTime::createFromFormat('H:i', $end_time);

        if (!$start || !$end) {
            return null;
        }

        $diff = $start->diff($end);
        return ($diff->h * 60) + $diff->i;
    }
}

$class_items = [];
$lesson_items = [];

foreach ($classes as $class) {
    $class_items[] = [
        'type' => 'class',
        'id' => $class['id'] ?? null,
        'name' => $class['name'] ?? '',
        'description' => $class['description'] ?? '',
        'discipline' => $class['discipline_name'] ?? ($class['discipline']['name'] ?? ''),
        'date' => $class['start_date'] ?? '',
        'start_time' => $class['start_time'] ?? '',
        'end_time' => $class['end_time'] ?? '',
        'instructor' => $class['instructor']['name'] ?? '',
        'price' => $class['current_base_price'] ?? null,
        'recurrence' => $class['recurrence_description'] ?? '',
        'lessons_count' => $class['lessons_count'] ?? null,
        'remaining_lessons' => $class['remaining_lessons_count'] ?? null,
        'book_url' => !empty($class['id']) ? $guestlist_url . '/book?type=class&id=' . $class['id'] : '',
    ];
}

foreach ($lessons as $lesson) {
    $lesson_items[] = [
        'type' => 'lesson',
        'id' => $lesson['id'] ?? null,
        'name' => $lesson['topic'] ?? ($lesson['course_class']['name'] ?? ''),
        'description' => $lesson['course_class']['description'] ?? '',
        'discipline' => $lesson['discipline_name'] ?? ($lesson['discipline']['name'] ?? ($lesson['course_class']['discipline_name'] ?? ($lesson['course_class']['discipline']['name'] ?? ''))),
        'date' => $lesson['lesson_date'] ?? ($lesson['lesson_format_date'] ?? ''),
        'start_time' => $lesson['lesson_start_time'] ?? ($lesson['start_time'] ?? ''),
        'end_time' => $lesson['lesson_end_time'] ?? ($lesson['end_time'] ?? ''),
        'instructor' => $lesson['instructor']['name'] ?? '',
        'price' => $lesson['current_base_price'] ?? null,
        'recurrence' => $lesson['course_class']['recurrence_description'] ?? '',
        'lessons_count' => null,
        'remaining_lessons' => null,
        'book_url' => !empty($lesson['id']) ? $guestlist_url . '/book?type=lesson&id=' . $lesson['id'] : '',
    ];
}

if (!function_exists('guestlist_sort_items_by_date')) {
    function guestlist_sort_items_by_date(&$items) {
        usort($items, function ($a, $b) {
            $date_a = guestlist_parse_date($a['date']);
            $date_b = guestlist_parse_date($b['date']);

            $timestamp_a = $date_a ? $date_a->getTimestamp() : 0;
            $timestamp_b = $date_b ? $date_b->getTimestamp() : 0;

            return $timestamp_a <=> $timestamp_b;
        });
    }
}

if (!function_exists('guestlist_unique_instructors')) {
    function guestlist_unique_instructors($items) {
        $unique_instructors = [];
        foreach ($items as $item) {
            if (!empty($item['instructor'])) {
                $unique_instructors[] = $item['instructor'];
            }
        }
        $unique_instructors = array_unique($unique_instructors);
        return count($unique_instructors) > 1;
    }
}

if (!function_exists('guestlist_render_items')) {
    function guestlist_render_items($items, $show_instructor_name, $tab_id, $empty_label, $load_more_label, $filter_empty_label) {
        if (empty($items)) {
            echo '<p class="text-sm text-gray-600">' . esc_html($empty_label) . '</p>';
            return;
        }

        $index = 0;
        ?>
        <div id="<?php echo esc_attr($tab_id); ?>" class="guestlist-tab-panel">
            <p class="guestlist-empty text-sm text-gray-600 text-center hidden"><?php echo esc_html($filter_empty_label); ?></p>
            <div class="md:col-span-2 gap-6 mt-3 mb-3 grid md:grid-cols-3">
                <?php foreach ($items as $item) :
                    $date = guestlist_parse_date($item['date']);
                    $day_name = $date ? $date->format('l') : '';
                    $date_day = $date ? $date->format('d') : '';
                    $date_month = $date ? $date->format('M') : '';
                    $duration_mins = guestlist_duration_minutes($item['start_time'], $item['end_time']);
                    $price_value = is_numeric($item['price']) ? (float) $item['price'] : null;
                    $price_formatted = $price_value !== null ? '£' . number_format($price_value, 2) : 'Call';
                    $hide_item = ($index >= 6) ? 'hidden guestlist-hidden' : '';
                ?>

                <div class="franscape-cal-item bg-rockschool-grey p-4 flex flex-col <?php echo $hide_item; ?>" data-aos="zoom-in" data-index="<?php echo esc_attr($index); ?>" data-discipline="<?php echo esc_attr($item['discipline']); ?>">
                    <div class="">

                        <div class="card-header flex justify-between items-center gap-4 mb-4">

                            <!-- Date Box -->
                            <div class="bg-rockschool-teal date-box text-white text-center w-14 h-14 flex flex-col justify-center items-center font-semibold mb-3">
                                <div class="text-sm leading-none"><?php echo esc_html(strtoupper($date_day)); ?></div>
                                <div class="text-xs leading-none"><?php echo esc_html(strtoupper($date_month)); ?></div>
                            </div>

                            <?php if (!empty($item['discipline'])) : ?>
                                <div class="discipline-card-label text-center w-14 h-14 flex flex-col justify-center items-center font-semibold mb-3">
                                    <div class="text-sm leading-none"><?php echo esc_html($item['discipline']); ?></div>
                                </div>
                            <?php endif; ?>

                        </div>

                        <!-- Title and Time -->
                        <div class="title-and-time">
                            <h6 class="text-lg font-semibold mb-1">
                                <?php echo esc_html($item['name']); ?>
                            </h6>
                            <?php if (!empty($item['description'])) : ?>
                                <p class="text-sm text-gray-600 mb-1">
                                    <?php echo esc_html($item['description']); ?>
                                </p>
                            <?php endif; ?>

                            <p class="text-sm text-gray-600 no-margin">
                                <?php if ($item['type'] === 'lesson' && $date) : ?>
                                    <?php if (!empty($item['start_time'])) : ?>
                                        <?php echo esc_html($date->format('j M Y') . ' at ' . guestlist_format_time($item['start_time'])); ?>
                                    <?php else : ?>
                                        <?php echo esc_html($date->format('j M Y')); ?>
                                    <?php endif; ?>
                                <?php else : ?>
                                    <?php if (!empty($day_name) && !empty($item['start_time'])) : ?>
                                        <?php echo esc_html($day_name . 's at ' . guestlist_format_time($item['start_time'])); ?>
                                    <?php elseif (!empty($day_name)) : ?>
                                        <?php echo esc_html($day_name); ?>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php if ($show_instructor_name && !empty($item['instructor'])) : ?>
                                    with <?php echo esc_html($item['instructor']); ?>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>

                    <!-- Info Row -->
                    <div class="grid grid-cols-4 gap-2 text-center text-sm mb-[1em] mt-[1em]">
                        <div class="event-card-meta-item">
                            <div class="font-semibold"><?php echo esc_html(ucfirst($item['type'])); ?></div>
                            <div class="text-xs">type</div>
                        </div>
                        <div class="event-card-meta-item">
                            <div class="font-semibold"><?php echo esc_html(substr($day_name, 0, 3)); ?></div>
                            <div class="text-xs">day</div>
                        </div>
                        <div class="event-card-meta-item">
                            <div class="font-semibold"><?php echo esc_html(guestlist_format_time($item['start_time'])); ?></div>
                            <div class="text-xs">time</div>
                        </div>
                        <div class="event-card-meta-item">
                            <div class="font-semibold"><?php echo esc_html($duration_mins); ?></div>
                            <div class="text-xs">min<?php echo !empty($duration_mins) && $duration_mins > 1 ? 's' : ''; ?></div>
                        </div>
                    </div>

                    <!-- Details -->
                    <?php if ($item['type'] === 'lesson') : ?>
                        <p class="text-sm text-gray-700 mb-1"><strong>Lesson</strong> date <?php echo esc_html($date ? $date->format('j M Y') : ''); ?></p>
                    <?php elseif (!empty($item['recurrence'])) : ?>
                        <p class="text-sm text-gray-700 mb-1"><strong>Class</strong> <?php echo esc_html($item['recurrence']); ?></p>
                    <?php else : ?>
                        <p class="text-sm text-gray-700 mb-1"><strong><?php echo esc_html(ucfirst($item['type'])); ?></strong> date <?php echo esc_html($date ? $date->format('j M Y') : ''); ?></p>
                    <?php endif; ?>

                    <!-- Pricing -->
                    <p class="text-sm mb-4">Cost per lesson from
                        <span class="text-lg font-bold block"><?php echo esc_html($price_formatted); ?></span>
                    </p>

                    <!-- CTA -->
                    <?php if (!empty($item['book_url'])) : ?>
                    <a href="<?php echo esc_url($item['book_url']); ?>" target="_blank" rel="noopener noreferrer" class="mt-auto block text-center text-rockschool-teal border border-[2px] bg-white border-rockschool-teal px-4 py-2 hover:bg-rockschool-teal hover:text-white uppercase w-fit small-text">
                        Book Now
                    </a>
                    <?php endif; ?>
                </div>

                <?php $index++; endforeach; ?>

                <?php if (count($items) > 6): ?>
                <div class="col-span-full text-center mt-6">
                    <button class="guestlist-load-more mt-auto inline-block text-rockschool-teal border border-[2px] border-rockschool-teal px-4 py-2 hover:bg-rockschool-teal hover:text-white uppercase w-fit small-text">
                        <?php echo esc_html($load_more_label); ?>
                    </button>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
}

if (!empty($class_items) || !empty($lesson_items)) {
    guestlist_sort_items_by_date($class_items);
    guestlist_sort_items_by_date($lesson_items);

    $show_class_instructor = guestlist_unique_instructors($class_items);
    $show_lesson_instructor = guestlist_unique_instructors($lesson_items);
    $has_classes = !empty($class_items);
    $has_lessons = !empty($lesson_items);

    $disciplines = [];
    foreach ($class_items as $item) {
        if (!empty($item['discipline'])) {
            $disciplines[] = $item['discipline'];
        }
    }
    foreach ($lesson_items as $item) {
        if (!empty($item['discipline'])) {
            $disciplines[] = $item['discipline'];
        }
    }
    $disciplines = array_values(array_unique($disciplines));
    sort($disciplines);
    ?>

    <div id="<?php echo esc_attr($instance_id); ?>" class="franscape-booking-widget max-w-[1300px] bg-white text-rock-gray-900 shadow-lg p-8 mx-auto gap-8 mb-[5em]" data-aos="zoom-in">
        <div class="flex justify-between">
            <h2>Upcoming classes &amp; lessons</h2>
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/cal-icon.svg" class="cal-icon" />
        </div>

        <div class="mt-6">
            <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                <div class="flex gap-3">
                    <?php if ($has_classes) : ?>
                        <button class="guestlist-tab-btn px-4 py-2 uppercase text-sm border border-rockschool-teal text-rockschool-teal bg-white" data-target="<?php echo esc_attr($classes_panel_id); ?>">
                            Regular classes
                        </button>
                    <?php endif; ?>
                    <?php if ($has_lessons) : ?>
                        <button class="guestlist-tab-btn px-4 py-2 uppercase text-sm border border-rockschool-teal text-rockschool-teal bg-white" data-target="<?php echo esc_attr($lessons_panel_id); ?>">
                            Individual lessons
                        </button>
                    <?php endif; ?>
                </div>
                <div class="flex items-center gap-2">
                    <label for="<?php echo esc_attr($discipline_select_id); ?>" class="text-sm text-gray-700">Discipline</label>
                    <select id="<?php echo esc_attr($discipline_select_id); ?>" class="guestlist-discipline-select text-sm border border-rockschool-teal px-3 py-2 bg-white">
                        <option value="">All disciplines</option>
                        <?php foreach ($disciplines as $discipline) : ?>
                            <option value="<?php echo esc_attr($discipline); ?>"><?php echo esc_html($discipline); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <?php
            if ($has_classes) {
                guestlist_render_items(
                    $class_items,
                    $show_class_instructor,
                    $classes_panel_id,
                    'No regular classes are currently available.',
                    'Load More Classes',
                    'No classes found.'
                );
            }

            if ($has_lessons) {
                guestlist_render_items(
                    $lesson_items,
                    $show_lesson_instructor,
                    $lessons_panel_id,
                    'No individual lessons are currently available.',
                    'Load More Lessons',
                    'No lessons found.'
                );
            }
            ?>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const widget = document.querySelector('<?php echo esc_js($widget_selector); ?>');
        if (!widget) {
            return;
        }

        const tabButtons = widget.querySelectorAll('.guestlist-tab-btn');
        const tabPanels = widget.querySelectorAll('.guestlist-tab-panel');
        const disciplineSelect = widget.querySelector('.guestlist-discipline-select');

        function applyFilter(panel) {
            const filterValue = disciplineSelect ? disciplineSelect.value.toLowerCase() : '';
            const items = Array.from(panel.querySelectorAll('.franscape-cal-item'));
            const emptyState = panel.querySelector('.guestlist-empty');

            items.forEach(item => {
                item.classList.add('hidden');
                item.classList.add('guestlist-hidden');
            });

            const matchingItems = items.filter(item => {
                const discipline = (item.dataset.discipline || '').toLowerCase();
                return !filterValue || discipline === filterValue;
            });

            matchingItems.slice(0, 6).forEach(item => {
                item.classList.remove('hidden');
                item.classList.remove('guestlist-hidden');
            });

            const loadMore = panel.querySelector('.guestlist-load-more');
            if (loadMore) {
                loadMore.style.display = matchingItems.length > 6 ? 'inline-block' : 'none';
            }

            if (emptyState) {
                emptyState.classList.toggle('hidden', matchingItems.length > 0);
            }
        }

        function activateTab(targetId) {
            tabPanels.forEach(panel => {
                panel.style.display = panel.id === targetId ? 'block' : 'none';
                if (panel.id === targetId) {
                    applyFilter(panel);
                }
            });

            tabButtons.forEach(btn => {
                const isActive = btn.dataset.target === targetId;
                btn.classList.toggle('bg-rockschool-teal', isActive);
                btn.classList.toggle('text-white', isActive);
                btn.classList.toggle('text-rockschool-teal', !isActive);
                btn.classList.toggle('bg-white', !isActive);
            });
        }

        if (tabButtons.length) {
            tabButtons.forEach(btn => {
                btn.addEventListener('click', function () {
                    activateTab(btn.dataset.target);
                });
            });
            activateTab(tabButtons[0].dataset.target);
        }

        if (disciplineSelect) {
            disciplineSelect.addEventListener('change', function () {
                tabPanels.forEach(panel => {
                    applyFilter(panel);
                });
            });
        }

        widget.querySelectorAll('.guestlist-load-more').forEach(btn => {
            btn.addEventListener('click', function () {
                const panel = btn.closest('.guestlist-tab-panel');
                if (!panel) {
                    return;
                }
                const filterValue = disciplineSelect ? disciplineSelect.value.toLowerCase() : '';
                const hiddenItems = Array.from(panel.querySelectorAll('.guestlist-hidden')).filter(item => {
                    const discipline = (item.dataset.discipline || '').toLowerCase();
                    return !filterValue || discipline === filterValue;
                });

                hiddenItems.slice(0, 6).forEach(el => {
                    el.classList.remove('hidden');
                    el.classList.remove('guestlist-hidden');
                });
                const remainingHidden = Array.from(panel.querySelectorAll('.guestlist-hidden')).filter(item => {
                    const discipline = (item.dataset.discipline || '').toLowerCase();
                    return !filterValue || discipline === filterValue;
                });
                if (remainingHidden.length === 0) {
                    btn.style.display = 'none';
                }
            });
        });
    });
    </script>

<?php } ?>
