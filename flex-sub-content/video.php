<section id="<?php echo get_sub_field('section_id'); ?>" class="video-module-section wrapper module-<?php echo $flex_index; ?>">

    <?php
    $platform = get_sub_field('platform'); // 'youtube' or 'vimeo'
    $video_id = get_sub_field('video_id');
    $placeholder_image = get_sub_field('placeholder_image');

    $src = '';
    if ($platform === 'youtube') {
        $src = "https://www.youtube.com/embed/{$video_id}?rel=0&autoplay=0&controls=0&showinfo=0&loop=1&modestbranding=1&enablejsapi=1";
    } elseif ($platform === 'vimeo') {
        $src = "https://player.vimeo.com/video/{$video_id}?autoplay=0&loop=1&title=0&byline=0&portrait=0";
    }
    ?>

    <script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery(document).on('click', '.play-video-link', function() {
            var iframe = jQuery(this).closest('.iframe-holder').find('iframe.video-iframe');
            var src = iframe.data('src');

            iframe.attr('src', src);
            jQuery(this).closest('.video-placeholder-holder').fadeOut(500);

            if (iframe.hasClass('youtube-video')) {
                setTimeout(function() {
                    iframe[0].contentWindow.postMessage(
                        JSON.stringify({ event: 'command', func: 'playVideo', args: '' }),
                        '*'
                    );
                }, 500);
            }

            if (iframe.hasClass('vimeo-video')) {
                // Vimeo requires different postMessage format
                setTimeout(function() {
                    iframe[0].contentWindow.postMessage(
                        JSON.stringify({ method: 'play' }),
                        '*'
                    );
                }, 500);
            }
        });
    });
    </script>

    <div class="video-element" data-aos="zoom-in">

        <div class="iframe-holder <?php if( get_sub_field('class') ) { the_sub_field('class'); } ?>">

            <div class="video-placeholder-holder">
                <div class="video-placeholder play-video-link">
                    <img class="lazy" data-src="<?php echo $placeholder_image['url' ]; ?>" />
                    <div class="play-icon fade-in">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" id="Play-Icon" height="169" width="169"><desc>Play Icon</desc><path fill="#ffffff" d="M9.575 16.25 16.25 12l-6.675 -4.25v8.5ZM12 22c-1.36665 0 -2.65835 -0.2625 -3.875 -0.7875 -1.21665 -0.525 -2.27915 -1.24165 -3.1875 -2.15 -0.908335 -0.90835 -1.625 -1.97085 -2.15 -3.1875C2.2625 14.65835 2 13.36665 2 12c0 -1.38335 0.2625 -2.68335 0.7875 -3.9 0.525 -1.21665 1.241665 -2.275 2.15 -3.175 0.90835 -0.9 1.97085 -1.6125 3.1875 -2.1375C9.34165 2.2625 10.63335 2 12 2c1.38335 0 2.68335 0.2625 3.9 0.7875 1.21665 0.525 2.275 1.2375 3.175 2.1375 0.9 0.9 1.6125 1.95835 2.1375 3.175C21.7375 9.31665 22 10.61665 22 12c0 1.36665 -0.2625 2.65835 -0.7875 3.875 -0.525 1.21665 -1.2375 2.27915 -2.1375 3.1875 -0.9 0.90835 -1.95835 1.625 -3.175 2.15C14.68335 21.7375 13.38335 22 12 22Zm0 -1.5c2.36665 0 4.375 -0.82915 6.025 -2.4875C19.675 16.35415 20.5 14.35 20.5 12c0 -2.36665 -0.825 -4.375 -2.475 -6.025C16.375 4.325 14.36665 3.5 12 3.5c-2.35 0 -4.35415 0.825 -6.0125 2.475C4.329165 7.625 3.5 9.63335 3.5 12c0 2.35 0.829165 4.35415 2.4875 6.0125C7.64585 19.67085 9.65 20.5 12 20.5Z" stroke-width="0.5"></path></svg>
                    </div>
                </div>
            </div>

            <div class="iframe-container">

                <?php if ($platform === 'youtube') : ?>

                    <iframe class="<?php echo $platform; ?>-video video-iframe" data-src="https://www.youtube.com/embed/<?php echo $video_id; ?>?rel=0&autoplay=0&controls=0&showinfo=0&loop=1&modestbranding=1&enablejsapi=1" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen loading="lazy"></iframe>

                <?php else : ?>

                    <iframe src="https://player.vimeo.com/video/933247798?h=23fdf83fad&amp;badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479" frameborder="0" allow="autoplay; fullscreen; picture-in-picture; clipboard-write; encrypted-media" style="position:absolute;top:0;left:0;width:100%;height:100%;" title="RSL_ABBEYROAD_LONGTRAILER"></iframe>

                    <script src="https://player.vimeo.com/api/player.js"></script>

                <?php endif; ?>

            </div>

        </div>

    </div>

</section>