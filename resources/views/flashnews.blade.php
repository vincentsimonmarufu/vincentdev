<style>
    @keyframes ticker {
        0% {
            transform: translateX(100%);
        }

        100% {
            transform: translateX(-100%);
        }
    }

    .mynews {
        display: flex;
        justify-content: center;
        align-items: center;
        height: auto;
        /* Change to auto for responsive height */
        margin: 0;
    }

    #flash-news {
        position: relative;
        white-space: nowrap;
        overflow: hidden;
        animation: ticker 10s infinite linear;
        background: linear-gradient(to right, #4CAF50, #2196F3);
        padding: 10px;
        border-bottom: 2px solid #ccc;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        text-align: center;
    }

    .flash-news-item {
        display: block;
        /* Change to block for mobile responsiveness */
        padding-right: 20px;
    }

    .flash-news-item span,
    .flash-news-item a {
        color: #fff;
        text-decoration: none;
        cursor: pointer;
        transition: color 0.5s;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        display: block;
        /* Display as block for better mobile layout */
        margin-bottom: 10px;
        /* Add some spacing between items */
    }

    .flash-news-item a {
        color: #FFEB3B;
    }

    .flash-news-item a:hover {
        color: #fff;
    }

    .close-icon {
        position: absolute;
        top: 5px;
        right: 5px;
        color: #fff;
        cursor: pointer;
    }
</style>
<div class="mynews">
    <div id="flash-news" onmouseenter="pauseAnimation()" onmouseleave="resumeAnimation()">
        <!-- Add close icon -->
        <div class="flash-news-item">
            <span class="close-icon" onclick="closeFlashNews()"><i class="fas fa-times"></i></span>
            <span onclick="window.location.href='javascript:void(0);'">Abisiniya Travels & Tourism App launched</span>
            Download as Android app&nbsp;&nbsp;<a href="javascript:void(0);" onclick="window.location.href='https://play.google.com/store/apps/details?id=com.Abisiniya.Abisiniya'">Click Me!</a>
        </div>
    </div>
</div>
<script>
    function pauseAnimation() {
        var flashNews = document.getElementById('flash-news');
        flashNews.style.animationPlayState = 'paused';
    }

    function resumeAnimation() {
        var flashNews = document.getElementById('flash-news');
        flashNews.style.animationPlayState = 'running';
    }

    function closeFlashNews() {
        var flashNews = document.getElementById('flash-news');
        flashNews.style.display = 'none'; // Hide the flash news
    }
</script>
<!-- end flash news -->


<div class="entry-meta mb-0">
    <span class="entry-category"><a href="#" class="white">Abisiniya</a></span>
</div>
<h2 class="mb-1"><a href="#" class="white">Affordable Air Tickets, Holiday Home and Car Rental Services</a></h2>