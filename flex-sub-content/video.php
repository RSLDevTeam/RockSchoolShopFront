<section class="video-module-section wrapper">

    <?php
    $placeholder_image = get_sub_field('placeholder_image'); ?>

    <script type="text/javascript">
        $ = jQuery;
        $(document).ready(function(){

            var s = $('.youtube-video').data('src');
            
            $(document).on('click', '.play-video-link', function() { 

            $('iframe.youtube-video').attr('src', s);

            $('.video-placeholder-holder').fadeOut(1500);

            setTimeout( function() {
                $('iframe.youtube-video')[0].contentWindow.postMessage('{"event":"command","func":"' + 'playVideo' + '","args":""}', '*');
            }, 1000);

            });

        });
    </script>

    <div class="video-element flex">

        <div class="iframe-holder <?php if( get_sub_field('class') ) { the_sub_field('class'); } ?>">

            <div class="video-placeholder-holder">
                <div class="video-placeholder play-video-link">
                    <img class="lazy" data-src="<?php echo $placeholder_image['url' ]; ?>" />
                    <div class="play-icon fade-in">
                        <i class="fa fa-youtube-play" aria-hidden="true"></i>
                    </div>
                </div>
            </div>

            <div class="iframe-container">

                <iframe class="youtube-video" data-src="https://www.youtube-nocookie.com/embed/<?php the_sub_field('video'); ?>?rel=0&amp;autoplay=0&amp;controls=0&amp;showinfo=0&amp;loop=1&amp;modestbranding=1&amp;enablejsapi=1" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen loading="lazy"></iframe>

            </div>

        </div>

    </div>

</section>