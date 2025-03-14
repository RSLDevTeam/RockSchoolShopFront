<section class="iFrameSection px-4">
    <section id="franscape-finder"><!-- THESE STYLES ENSURE THE FINDER FILLS THE HOST SITE SPACE -->

        <style>
            #franscape-finder,<br />
            #franscape-finder-iframe {<br />
                width: 100%;<br />
                height: 100%;<br />
                margin: 0;<br />
                padding: 0;<br />
                border: 0;<br />
                position: relative;<br />
            }<br />
        </style><!-- THIS IS THE ACTUAL IFRAME -->

        <iframe id="franscape-finder-iframe" title="Rockschool Lesson Finder" name="Lesson Finder" width="100%"></iframe>

        <!-- THIS SCRIPT ALLOWS PARAMETERS FROM THE URL TO BE PASSED TO THE FINDER -->

        <script>
            const iframeEl = document.getElementById('franscape-finder-iframe');
            iframeEl.src = 'https://finder.rockschool.franscape.io/' + window.location.search;
        </script>

    </section>
</section>