<?php // franscape calendar per franchisee

$franscape_id = get_field('franscape_id');

$classes = [];
if ($franscape_id) {
    $api_url = 'https://api.uk.prod.franscape.services/v1/public/classes?page=1&count=200&filter=' . urlencode(json_encode(['franchisee_ids' => [(int) $franscape_id]]));

    $response = wp_remote_get($api_url, [
        'headers' => [
            'Tenant' => 'rockschool',
        ],
        'timeout' => 10,
    ]);

    if (is_array($response) && !is_wp_error($response)) {
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        if (!empty($data['items'])) {
            $classes = $data['items'];
        }
    }
}

if (!empty($classes)) :

    $unique_instructors = [];

    foreach ($classes as $class) {
        if (!empty($class['instructor']['name'])) {
            $unique_instructors[] = $class['instructor']['name'];
        }
    }

    $unique_instructors = array_unique($unique_instructors);
    $show_instructor_name = count($unique_instructors) > 1;

    $index = 0;

?>

<div class="franscape-booking-widget max-w-[1300px] bg-white text-rock-gray-900 shadow-lg p-8 mx-auto gap-8 mb-[5em]" data-aos="zoom-in">
    <div class="flex justify-between">
        <h2>Upcoming classes</h2>
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/cal-icon.svg" class="cal-icon" />
    </div>

    <div id="franscape_cal" class="md:col-span-2 gap-6 mt-3 mb-3 grid md:grid-cols-3">

        <?php foreach ($classes as $class) :
            $schedule = $class['lessons']['schedule'];
            $nextDate = DateTime::createFromFormat('jS F Y', $schedule['date']);
            $hasSpaces = !empty($class['lessons']['space_available']);
            $duration_mins = $class['lessons']['duration_in_min'];
            $duration = intval($class['lessons']['duration_in_min'] / 60);
            $pricePence = $class['pia']['price'];
            $priceFormatted = $pricePence >= 0 ? '£' . number_format($pricePence / 100, 2) : 'Call';
            $hide_class = ($index >= 6) ? 'hidden franscape-hidden' : '';
        ?>

        <div class="franscape-cal-item bg-rockschool-grey p-4 flex flex-col <?php echo $hide_class; ?>" data-aos="zoom-in">
            <div class="">
                <!-- Date Box -->
                <div class="bg-rockschool-teal date-box text-white text-center w-14 h-14 flex flex-col justify-center items-center font-semibold mb-3">
                    <div class="text-sm leading-none"><?php echo strtoupper($nextDate->format('d')); ?></div>
                    <div class="text-xs leading-none"><?php echo strtoupper($nextDate->format('M')); ?></div>
                </div>

                <!-- Title and Time -->
                <div class="title-and-time">
                    <h6 class="text-lg font-semibold mb-1"><?php echo esc_html($class['name']); ?></h6>

                    <p class="text-sm text-gray-600 no-margin">
                        <?php echo esc_html($schedule['day_name'] . 's at ' . $schedule['time_12']); ?>
                        <?php if ($show_instructor_name && !empty($class['instructor']['name'])) : ?>
                            with <?php echo esc_html($class['instructor']['name']); ?>
                        <?php endif; ?>
                    </p>
                </div>
            </div>

            <!-- Info Row -->
            <div class="grid grid-cols-4 gap-2 text-center text-sm mb-[1em] mt-[1em]">
                <div>
                    <div class="<?php echo $hasSpaces ? 'text-emerald-600' : 'text-red-500'; ?> font-bold">
                        <?php echo $hasSpaces ? '✓' : '✕'; ?>
                    </div>
                    <div class="text-xs">spaces</div>
                </div>
                <div>
                    <div class="font-semibold"><?php echo esc_html(substr($schedule['day_name'], 0, 3)); ?></div>
                    <div class="text-xs">days</div>
                </div>
                <div>
                    <div class="font-semibold"><?php echo esc_html(date('g:i', strtotime($schedule['time_24']))); ?></div>
                    <div class="text-xs"><?php echo esc_html(strtolower(date('A', strtotime($schedule['time_24'])))); ?></div>
                </div>
                <div>
                    <div class="font-semibold"><?php echo $duration_mins; ?></div>
                    <div class="text-xs">min<?php echo $duration_mins > 1 ? 's' : ''; ?></div>
                </div>
            </div>

            <!-- Details -->
            <p class="text-sm text-gray-700 mb-1"><strong>Spaces Available</strong> from <?php echo esc_html($schedule['date']); ?></p>

            <!-- Pricing -->
            <p class="text-sm mb-4">Cost per lesson from  
                <span class="text-lg font-bold block"><?php echo $priceFormatted; ?></span>
            </p>

            <!-- CTA -->
            <a href="<?php echo esc_url($class['paths']['booking_url']); ?>" target="_blank" rel="noopener noreferrer" class="mt-auto block text-center text-rockschool-teal border border-[2px] bg-white border-rockschool-teal px-4 py-2 hover:bg-rockschool-teal hover:text-white uppercase w-fit small-text">
                Find Out More
            </a>
        </div>

        <?php $index++; endforeach; ?>

        <?php if (count($classes) > 6): ?>
        <div class="col-span-full text-center mt-6">
            <button id="showAllClassesBtn" class="mt-auto inline-block text-rockschool-teal border border-[2px] border-rockschool-teal px-4 py-2 hover:bg-rockschool-teal hover:text-white uppercase w-fit small-text">
                Load All Classes
            </button>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('showAllClassesBtn');
    if (btn) {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.franscape-hidden').forEach(el => {
                el.classList.remove('hidden');
            });
            btn.style.display = 'none';
        });
    }
});
</script>

<?php endif; ?>