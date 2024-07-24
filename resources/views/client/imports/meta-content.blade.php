<style>
    .meta-content {
        padding-bottom: 50px !important;
    }

    .meta-content > .container:first-child {
        max-height: 320px; /* Adjust based on the estimated height to display 10 lines */
        overflow: hidden;
    }

    .meta-content > .container.expanded {
        max-height: none;
    }

    .meta-content h1 {
        text-align: left !important;
        font-weight: 800 !important;
        font-size: 54px !important;
        color: #2C3444 !important;
        margin-bottom: 10px !important;
        line-height: 45px !important;
    }

    .meta-content h2 {
        text-align: left !important;
        font-style: normal !important;
        font-weight: 600 !important;
        font-size: 44px !important;
        color: #2C3444 !important;
        margin-bottom: 10px !important;
        line-height: 45px !important;
    }

    .meta-content p {
        font-weight: normal !important;
        font-size: 24px !important;
        line-height: 30px !important;
        color: #2C3444 !important;
        text-align: left !important;
        margin-bottom: 30px !important;
    }

    .meta-content .container:has(> a.read-more) {
        margin-top: 15px !important;
    }

    .meta-content a.read-more {
        cursor: pointer !important;
        text-decoration: none !important;
        color: #413f3f !important;
        font-size: 15px !important;
        position: relative !important;
    }

    .meta-content a.read-more:hover {
        color: #000000 !important;
    }
</style>
<section class="meta-content">
    <div class="container" id="contentDiv">
        {!! $content !!}
    </div>
    <div class="container">
        <a href="#" id="toggleButton" class="read-more animation-link-underline">Читать дальше</a>
    </div>
</section>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const contentDiv = document.getElementById('contentDiv');
        const toggleButton = document.getElementById('toggleButton');
        let isExpanded = false;
        let isTruncated = false;
        const maxLines = 10; // Maximum number of lines to show

        function checkIfTruncated() {
            const style = getComputedStyle(contentDiv);
            const lineHeight = parseFloat(style.lineHeight);
            const maxHeight = lineHeight * maxLines;

            // Check if the content height exceeds the max height
            isTruncated = contentDiv.scrollHeight > maxHeight;
            toggleButton.style.display = isTruncated ? 'block' : 'none';
            if (isTruncated) {
                contentDiv.style.maxHeight = isExpanded ? 'none' : `${maxHeight}px`;
            }
        }

        function toggleExpand() {
            isExpanded = !isExpanded;
            const style = getComputedStyle(contentDiv);
            const lineHeight = parseFloat(style.lineHeight);
            const maxHeight = lineHeight * maxLines;
            contentDiv.style.maxHeight = isExpanded ? 'none' : `${maxHeight}px`;
            toggleButton.textContent = isExpanded ? 'Скрыть' : 'Читать дальше';
        }

        toggleButton.addEventListener('click', (e) => {
            e.preventDefault();
            toggleExpand();
        });

        window.addEventListener('resize', checkIfTruncated); // Recheck on window resize

        checkIfTruncated(); // Initial check
    });

</script>