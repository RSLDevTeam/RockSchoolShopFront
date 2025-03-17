<section class="iFrameSection">
    <section id="franscape-finder" class="h-screen p-0 m-0 w-full"><!-- THESE STYLES ENSURE THE FINDER FILLS THE HOST SITE SPACE -->

        <iframe id="franscape-finder-iframe" title="Rockschool Lesson Finder" name="Lesson Finder" width="100%" height="100%"></iframe>

        <!-- THIS SCRIPT ALLOWS PARAMETERS FROM THE URL TO BE PASSED TO THE FINDER -->

        <script>
            const iframeEl = document.getElementById('franscape-finder-iframe');
            // Get the URL parameters
            const params = new URLSearchParams(window.location.search);
        
            // Get the 'place' parameter from the URL
            const place = params.get("place");
            iframeEl.src = 'https://finder.rockschool.franscape.io/' + window.location.search;
        </script>

    </section>
</section>