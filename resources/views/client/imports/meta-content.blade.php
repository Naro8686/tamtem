<style>
    .meta-content {
        padding-bottom: 50px !important;
    }

    .meta-content > .container:first-child {
        max-height: 250px; /* Adjust based on the estimated height to display 10 lines */
        overflow: hidden;
    }

    .meta-content > .container.expanded {
        max-height: none;
    }

    .meta-content h1 {
        text-align: left;
        font-weight: 800;
        font-size: 54px;
        color: #2C3444 !important;
        margin-bottom: 10px !important;
        line-height: 45px;
    }

    .meta-content h2 {
        text-align: left;
        font-style: normal;
        font-weight: 600;
        font-size: 44px;
        color: #2C3444 !important;
        margin-bottom: 10px !important;
        line-height: 45px;
    }

    .meta-content p {
        font-weight: normal;
        font-size: 24px;
        line-height: 30px;
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

    .meta-content.hide-title {
        position: absolute;
        left: -9999rem;
        top: -9999rem;
    }

    @media screen and (max-width: 768px) {
        .meta-content h1 {
            font-size: 35px !important;
            line-height: 40px !important;
        }

        .meta-content h2 {
            font-size: 22px !important;
            line-height: 25px !important;
        }

        .meta-content p {
            font-size: 14px !important;
            line-height: 20px !important;
        }
    }
</style>
<section class="meta-content hide-title">
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