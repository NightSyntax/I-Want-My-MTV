<?php
$mvDir = __DIR__ . '/mv';
$idnetsDir = __DIR__ . '/idnets';
$adsDir = __DIR__ . '/ads';

function getVideos($dir, $count = null, $shuffle = true) {
    if (!is_dir($dir)) return [];
    $files = array_values(array_filter(scandir($dir), function ($f) use ($dir) {
        return is_file($dir . '/' . $f) && preg_match('/\.(mp4|webm|ogg)$/i', $f);
    }));
    if (empty($files)) return [];
    if ($shuffle) shuffle($files);
    return ($count !== null) ? array_slice($files, 0, $count) : $files;
}

$colorSets = [];
if (file_exists('colors.txt')) {
    $content = file_get_contents('colors.txt');
    preg_match_all('/#\s*SET\d*\s*\{\s*M:(.*?)\s*TV:(.*?)\s*sides:(.*?)\s*\}/s', $content, $matches);
    foreach ($matches[0] as $i => $fullMatch) {
        $colorSets[] = [
            'm' => trim($matches[1][$i]),
            'tv' => trim($matches[2][$i]),
            'sides' => trim($matches[3][$i])
        ];
    }
}
if (empty($colorSets)) {
    $colorSets[] = ['m' => '#5f5b5a', 'tv' => '#a24e50', 'sides' => '#E5F9B0'];
}

$allMvVideos = getVideos($mvDir); 
$allIdnetsVideos = getVideos($idnetsDir); 
$adsVideos = getVideos($adsDir, 5); 

$playlist = [];
$mvCounter = 0;
$adsIndex = 0;

foreach ($allMvVideos as $v) {
    $playlist[] = ['src' => 'mv/' . $v, 'type' => 'mv'];
    $mvCounter++;
    if ($mvCounter % 3 === 0 && !empty($allIdnetsVideos)) {
        $playlist[] = ['src' => 'idnets/' . $allIdnetsVideos[array_rand($allIdnetsVideos)], 'type' => 'idnets'];
    }
    if ($mvCounter % 20 === 0 && isset($adsVideos[$adsIndex])) {
        $playlist[] = ['src' => 'ads/' . $adsVideos[$adsIndex], 'type' => 'ads'];
        $adsIndex++;
    }
}
?>
<!doctype html>
<html>
<head>
    <title>MTV</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <style>
@charset "UTF-8";
@import url('https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:wght@600&display=swap');

:root {
    --color-m-and-belt: #5f5b5a;
    --color-tv-and-artist: #a24e50;
    --color-sides: #E5F9B0;
    --color-txt-label: #d9d978;
}

html, body, div, span, p, img, video { margin: 0; padding: 0; border: 0; }
body { line-height: 1.1; background: #000; overflow: hidden; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; letter-spacing: 0.175em; }

#player { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 0; object-fit: contain; }

.global_container_ {
    width: 100%; max-width: 1440px; aspect-ratio: 4 / 3; margin: 0 auto;
    position: relative; overflow: hidden; font-size: 3.447vw; 
}
@media (min-width: 1440px) { .global_container_ { font-size: 49.64px; } }

.artist-container-main {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 24.82%; 
    display: flex;
    flex-direction: column;
    justify-content: flex-end; 
    z-index: 15;
}

.maxx { 
    font-family: 'Barlow Semi Condensed', sans-serif; 
    font-weight: 600; 
    color: var(--color-tv-and-artist); 
    font-size: 1.38em; 
    text-shadow: 0.05em 0.05em 0px #000000; 
    z-index: 10;
    position: relative; 
    width: 100%;
    white-space: normal; 
    line-height: 0.9;
    text-transform: uppercase;
    display: block;
    margin-bottom: 0.1em;
}

#vid-end {
    position: absolute;
    left: 11.66vw;
    top: 52vw; 
    opacity: 0;
    transition: opacity 0.8s ease;
    z-index: 20;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}
@media (min-width: 1440px) {
    #vid-end { left: 168px; top: 750px; }
}

#vid-end .maxx {
    width: 71.75vw; 
    max-width: 1033px;
}

#vid-end .text-end-title {
    display: block;
    font-weight: bold;
    color: #d9d978;
    text-shadow: 0.014em 0.115em 0.005em #000000, -0.014em 0.086em 0.005em #000000;
    margin-left: 0.2em;
    margin-bottom: 0.1em;
}

#vid-end .text-end-album {
    display: block;
    font-weight: bold;
    color: #d9d978;
    text-shadow: 0.014em 0.115em 0.005em #000000, -0.014em 0.086em 0.005em #000000;
    margin-left: 0.8em;
}

.header {
    height: 11.39%; width: 11.18%; position: absolute; right: 4.72%; top: 5.92%;     
    background: url(images/mtv_logo.png) no-repeat center; background-size: contain;
    opacity: 0; transition: opacity 0.8s ease;
}

.footer {
    height: 26.85%; width: 78.19%; left: 10.83%; position: absolute; top: 64.72%;    
    opacity: 0; transition: opacity 0.8s ease; filter: opacity(0.94);
}

.bar { height: 98.27%; width: 71.75%; left: 0; position: absolute; top: 0; }

.col { height: 73.44%; width: 100%; left: 0; position: absolute; top: 24.82%; background: var(--color-m-and-belt); }

.text, .text-2 {
    font-weight: bold; position: absolute; white-space: nowrap; color: #d9d978;
    text-shadow: 0.014em 0.115em 0.005em #000000, -0.014em 0.086em 0.005em #000000;
}
.text { left: 3.71%; top: 16.43%; }
.text-2 { left: 8.29%; top: 55.4%; text-align: center; }

.logo { height: 75.17%; width: 24.6%; left: 75.39%; position: absolute; top: 24.82%; }
.wrapper { height: 84.86%; width: 99.27%; position: absolute; right: 0; top: 0; }

.m-mask { 
    left: 0; top: 0; width: calc(82.54% + 1px); height: 100%; position: absolute; z-index: 2;
    background-color: var(--color-m-and-belt);
    -webkit-mask: url(images/m.png) no-repeat center / contain; mask: url(images/m.png) no-repeat center / contain;
}
.tv-mask { 
    left: calc(37.45% - 0.5px); top: 12.43%; width: calc(62.54% + 1px); height: 78%; position: absolute; z-index: 3;
    background-color: var(--color-tv-and-artist);
    -webkit-mask: url(images/tv.png) no-repeat center / contain; mask: url(images/tv.png) no-repeat center / contain;
}
.sides-mask { 
    left: calc(31.27% - 0.5px); top: 0; width: calc(57.45% + 1px); height: 100%; position: absolute; z-index: 1;
    background-color: var(--color-sides);
    -webkit-mask: url(images/sides.png) no-repeat center / contain; mask: url(images/sides.png) no-repeat center / contain;
}
.txt-mask { 
    left: 0; top: 90.36%; width: 87%; height: 10%; position: absolute;
    background-color: var(--color-txt-label);
    -webkit-mask: url(images/txt.png) no-repeat left center / contain; mask: url(images/txt.png) no-repeat left center / contain;
}
    </style>
</head>
<body>
    <video id="player" autoplay playsinline></video>
    <div class="global_container_">
        
        <div id="vid-end">
            <div class="maxx" id="end-artist-name"></div>
            <span class="text-end-title" id="end-track-title">“”</span>
            <span class="text-end-album" id="end-album-name"></span>
        </div>

        <header class="header" id="mtv-logo"></header>
        <footer class="footer" id="info-bar">
            <div class="bar">
                <div class="artist-container-main">
                    <div class="maxx" id="artist-name"></div>
                </div>
                <div class="col">
                    <p class="text" id="track-title">“”</p>
                    <p class="text-2" id="album-name"></p>
                </div>
            </div>
            <div class="logo">
                <div class="wrapper">
                    <div class="sides-mask"></div>
                    <div class="tv-mask"></div>
                    <div class="m-mask"></div>
                </div>
                <div class="txt-mask"></div>
            </div>
        </footer>
    </div>

    <script>
        const playlist = <?php echo json_encode($playlist); ?>;
        const colorSets = <?php echo json_encode($colorSets); ?>;
        let index = 0;
        
        const player = document.getElementById('player');
        const bar = document.getElementById('info-bar');
        const endBar = document.getElementById('vid-end');
        const logo = document.getElementById('mtv-logo');
        
        const artistEl = document.getElementById('artist-name');
        const titleEl = document.getElementById('track-title');
        const albumEl = document.getElementById('album-name');
        
        const endArtistEl = document.getElementById('end-artist-name');
        const endTitleEl = document.getElementById('end-track-title');
        const endAlbumEl = document.getElementById('end-album-name');
        
        const root = document.documentElement;

        let showTimeout, hideTimeout, checkEndInterval;
        let endBarTriggered = false;

        function updateColors() {
            const set = colorSets[Math.floor(Math.random() * colorSets.length)];
            root.style.setProperty('--color-m-and-belt', set.m);
            root.style.setProperty('--color-tv-and-artist', set.tv);
            root.style.setProperty('--color-sides', set.sides);
        }

        function formatArtistName(fullName, element) {
            element.style.whiteSpace = 'nowrap';
            element.innerHTML = fullName;
            
            const maxWidth = element.offsetWidth;
            const scrollWidth = element.scrollWidth;

            if (scrollWidth <= maxWidth) {
                element.style.whiteSpace = 'normal';
                return fullName;
            }

            const words = fullName.split(' ');
            let line1 = "";
            let line2 = "";
            let overflowed = false;

            for (let i = 0; i < words.length; i++) {
                let testLine = line1 + (line1 === "" ? "" : " ") + words[i];
                element.innerHTML = testLine;

                if (element.scrollWidth > maxWidth && line1 !== "") {
                    line2 = words.slice(i).join(' ');
                    overflowed = true;
                    break;
                } else {
                    line1 = testLine;
                }
            }

            element.style.whiteSpace = 'normal';
            return overflowed ? (line1 + "<br>" + line2) : fullName;
        }

        function playNext() {
            endBar.style.transition = "none";
            endBar.style.opacity = "0";
            void endBar.offsetWidth; 
            endBar.style.transition = "opacity 0.8s ease";

            if (index >= playlist.length) { location.reload(); return; }
            
            clearTimeout(showTimeout);
            clearTimeout(hideTimeout);
            clearInterval(checkEndInterval);
            
            bar.style.opacity = "0";
            logo.style.opacity = "0";
            endBarTriggered = false;

            updateColors();

            const item = playlist[index];
            player.src = item.src;
            player.play().catch(e => console.log("Play error"));

            if (item.type === 'mv') {
                logo.style.opacity = "1";
                let fileName = item.src.split('/').pop().replace(/\.[^/.]+$/, '');
                let parts = fileName.split(' - ');
                
                let artist = (parts[0] || fileName).trim().toUpperCase();
                let title = (parts[1] || fileName).trim().toUpperCase();
                let album = (parts[2] || fileName).trim().toUpperCase();

                const finalArtistHTML = formatArtistName(artist, artistEl);
                artistEl.innerHTML = finalArtistHTML;
                
                const finalEndArtistHTML = formatArtistName(artist, endArtistEl);
                endArtistEl.innerHTML = finalEndArtistHTML;

                titleEl.innerText = `“${title}”`;
                albumEl.innerText = album;

                endTitleEl.innerText = `“${title}”`;
                endAlbumEl.innerText = album;

                showTimeout = setTimeout(() => { bar.style.opacity = "1"; }, 12000);
                hideTimeout = setTimeout(() => { bar.style.opacity = "0"; }, 27000);

                checkEndInterval = setInterval(() => {
                    if (!endBarTriggered && player.duration > 0) {
                        if (player.currentTime >= (player.duration - 10)) {
                            endBar.style.opacity = "1";
                            endBarTriggered = true;
                        }
                    }
                }, 500);
            } 
            index++;
        }

        player.onended = playNext;
        playNext();
        document.addEventListener('click', () => { player.muted = false; }, { once: true });
    </script>
</body>
</html>