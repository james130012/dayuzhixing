<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>大宇之形 方寸之间</title>

    <meta property="og:title" content="大宇之形 方寸之间" />
    <meta property="og:description" content="见证、记录、储存人类点点滴的灵性。" />
    <meta property="og:type" content="website" />
    <?php
        // Construct the protocol (http or https)
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        // Get the host name
        $host = $_SERVER['HTTP_HOST'];
        // Construct the base URL for the current page (used for og:url and JS-SDK config)
        $current_page_url = $protocol . $host . $_SERVER['REQUEST_URI'];

        // --- Constructing the absolute URL for the image (used for og:image and JS-SDK imgUrl) ---
        $image_filename = '1.png'; // 您的图片文件名
        $script_directory = dirname($_SERVER['SCRIPT_NAME']);
        if ($script_directory === '/' || $script_directory === '\\') {
            $script_directory = '';
        }
        $image_url = $protocol . $host . $script_directory . '/' . $image_filename;

        // --- WeChat JS-SDK Signature Generation (Placeholder - Needs Server-Side Implementation) ---
        $appId = '在此处填入您的微信公众号AppID'; // 【重要】替换为您的 AppID
        $timestamp = time();
        $nonceStr = uniqid(); 
        $jssdk_config = [
            'appId'     => $appId,
            'timestamp' => $timestamp, 
            'nonceStr'  => $nonceStr,  
            'signature' => '服务器端生成的签名', // 【重要】替换为服务器端生成的实际签名
            'jsApiList' => [ 
                'updateAppMessageShareData',
                'updateTimelineShareData',
                'onMenuShareTimeline', 
                'onMenuShareAppMessage' 
            ]
        ];
    ?>
    <meta property="og:url" content="<?php echo htmlspecialchars($current_page_url); ?>" />
    <meta property="og:image" content="<?php echo htmlspecialchars($image_url); ?>" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="大宇之形 方寸之间">
    <meta name="twitter:description" content="见证、记录、储存人类点点滴的灵性。" />
    <meta name="twitter:image" content="<?php echo htmlspecialchars($image_url); ?>">

    <meta name="description" content="见证、记录、储存人类点点滴的灵性。" />

    <style>
        /* 全局样式和字体导入 */
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+SC:wght@300;400;500;700&display=swap');
        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css');

        :root {
            --star-bg: #000002; 
            --text-color: #e0e8f0;
            --header-color: #f0f8ff;
            --border-color: rgba(255, 255, 255, 0.1); 
            --tile-border-color: rgba(255, 255, 255, 0.2); 
        }

        body {
            font-family: 'Noto Sans SC', sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--star-bg);
            color: var(--text-color);
            line-height: 1.7;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
            box-sizing: border-box;
            overflow-x: hidden; 
        }

        #starfield {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1; 
            pointer-events: none; 
        }

        .container {
            background-color: transparent; 
            padding: 35px 45px;
            border-radius: 20px;
            box-shadow: none; 
            width: 95%;
            max-width: 1200px;
            text-align: center;
            margin-top: 20px;
            border: none; 
            position: relative; 
            z-index: 1;
        }

        header h1 {
            color: var(--header-color);
            font-size: 3.2em;
            margin-bottom: 10px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-shadow: 0 0 10px rgba(173, 216, 230, 0.8), 0 0 20px rgba(173, 216, 230, 0.6), 0 0 30px rgba(100,180,255,0.4);
        }
        header p {
            color: #b0c4de;
            font-size: 1.2em;
            margin-bottom: 40px;
        }

        #auto-navigation {
            margin-top: 25px;
            text-align: left;
        }

        #auto-navigation h2 {
            color: #d1d5db;
            font-size: 2em;
            margin-bottom: 30px;
            padding-bottom: 12px;
            border-bottom: 3px solid #5895f1;
            text-align: center;
        }

        #auto-navigation ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 25px;
        }

        #auto-navigation ul li {
            background-color: transparent; 
            border-radius: 15px;
            transition: transform 0.3s ease, box-shadow 0.3s ease; 
            overflow: visible;
            border: 1px solid var(--tile-border-color); 
            min-height: 140px;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        #auto-navigation ul li:hover {
            transform: translateY(-10px) scale(1.05);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.6), 0 0 25px rgba(135, 206, 250, 0.4); 
            background-color: transparent; 
        }

        #auto-navigation ul li a {
            text-decoration: none;
            color: #cbd5e1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            padding: 20px 15px 15px 15px;
            font-size: 1.0em;
            font-weight: 500;
            text-align: center;
            word-break: break-word;
            width: 100%;
            height: 100%;
            box-sizing: border-box;
        }

        .tile-icon-area {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 10px;
        }

        .link-icon {
            font-size: 2.5em;
            color: #93c5fd;
            margin-bottom: 5px;
            transition: color 0.3s ease, transform 0.3s ease;
        }
         #auto-navigation ul li a:hover .link-icon {
            color: #d0eaff;
            transform: scale(1.1);
        }

        .tile-date {
            font-size: 0.7em;
            font-weight: bold;
            color: #f0f8ff;
            background-color: rgba(60, 120, 180, 0.8); 
            padding: 3px 7px;
            border-radius: 5px;
            position: absolute;
            top: -10px;
            right: -8px;
            line-height: 1;
            box-shadow: 0 2px 4px rgba(0,0,0,0.4);
            border: 1px solid rgba(255,255,255,0.25);
            white-space: nowrap;
            z-index: 2;
        }

        .link-text {
            font-size: 0.95em;
            line-height: 1.3;
            max-height: 2.6em;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            margin-top: auto;
        }

        #auto-navigation ul li.no-files {
            grid-column: 1 / -1;
            text-align: center;
            padding: 25px;
            color: #9ca3af;
            background-color: rgba(55, 65, 81, 0.3); 
            border: 1px dashed var(--tile-border-color); 
            box-shadow: none;
            min-height: auto;
        }
        #auto-navigation ul li.no-files:hover {
            transform: none;
            box-shadow: none;
            background-color: rgba(55, 65, 81, 0.3);
        }

        footer {
            margin-top: 50px;
            padding: 25px;
            color: rgba(229, 231, 235, 0.6);
            font-size: 0.9em;
            width: 100%;
            text-align: center;
            z-index: 1;
        }

        @media (max-width: 992px) {
             #auto-navigation ul {
                grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            }
        }
        @media (max-width: 768px) {
            .container {
                padding: 25px 30px;
            }
            header h1 {
                font-size: 2.6em;
            }
            #auto-navigation h2 {
                font-size: 1.8em;
            }
            #auto-navigation ul {
                grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
                gap: 20px;
            }
             #auto-navigation ul li {
                min-height: 130px;
            }
            .link-icon {
                font-size: 2.2em;
            }
            .tile-date {
                font-size: 0.65em;
                padding: 2px 5px;
                top: -7px;
                right: -6px;
            }
        }

        @media (max-width: 480px) {
            header h1 {
                font-size: 2.1em;
            }
            #auto-navigation ul {
                grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
                gap: 15px;
            }
            #auto-navigation ul li {
                min-height: 120px;
                border-radius: 12px;
            }
             #auto-navigation ul li a {
                font-size: 0.85em;
                padding: 15px 10px 10px 10px;
            }
            .link-icon {
                font-size: 2em;
            }
             .tile-date {
                font-size: 0.6em;
                padding: 2px 4px;
                top: -6px;
                right: -5px;
            }
            .link-text {
                font-size: 0.9em;
            }
        }
    </style>
</head>
<body>
    <canvas id="starfield"></canvas>

    <div class="container">
        <header>
            <h1>学习与探索之旅</h1>
            <p>大宇之形，方寸之间</p>
        </header>

        <nav id="auto-navigation">
            <h2>一个灵性收集器</h2>
            <?php
                if (file_exists('navigation.php')) {
                    include 'navigation.php';
                } else {
                    echo "<ul><li class='no-files'>导航文件 (navigation.php) 未找到。请检查文件路径。</li></ul>";
                }
            ?>
        </nav>
    </div>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> ・ 所有权归skywalker</p>
    </footer>

    <script src="https://res.wx.qq.com/open/js/jweixin-1.6.0.js"></script>
    <script>
        // 从PHP传递过来的JSSDK配置 (实际应用中，signature应由后端动态生成并安全传递)
        const wxConfig = <?php echo json_encode($jssdk_config); ?>;
        
        wx.config({
            debug: false, 
            appId: wxConfig.appId, 
            timestamp: wxConfig.timestamp, 
            nonceStr: wxConfig.nonceStr, 
            signature: wxConfig.signature,
            jsApiList: wxConfig.jsApiList 
        });

        wx.ready(function () {
            const shareTitle = '大宇之形 方寸之间';
            const shareDesc = '见证、记录、储存人类点点滴的灵性。';
            const shareLink = '<?php echo htmlspecialchars($current_page_url); ?>'; 
            const shareImgUrl = '<?php echo htmlspecialchars($image_url); ?>'; 

            wx.updateAppMessageShareData({
                title: shareTitle,
                desc: shareDesc,
                link: shareLink,
                imgUrl: shareImgUrl,
                success: function () {
                    console.log('微信分享给朋友成功设置');
                },
                cancel: function () {
                    console.log('用户取消分享给朋友');
                }
            });

            wx.updateTimelineShareData({
                title: shareTitle, 
                link: shareLink,
                imgUrl: shareImgUrl,
                success: function () {
                    console.log('微信分享到朋友圈成功设置');
                },
                cancel: function () {
                    console.log('用户取消分享到朋友圈');
                }
            });

            wx.onMenuShareTimeline({
                title: shareTitle,
                link: shareLink,
                imgUrl: shareImgUrl,
                success: function () {
                    console.log('旧版微信分享到朋友圈成功');
                },
                cancel: function () {
                    console.log('用户取消旧版分享到朋友圈');
                }
            });

            wx.onMenuShareAppMessage({
                title: shareTitle,
                desc: shareDesc,
                link: shareLink,
                imgUrl: shareImgUrl,
                type: 'link', 
                dataUrl: '', 
                success: function () {
                    console.log('旧版微信分享给朋友成功');
                },
                cancel: function () {
                    console.log('用户取消旧版分享给朋友');
                }
            });
        });

        wx.error(function(res){
            console.error('微信JSSDK配置失败:', res);
        });

    </script>

    <script>
        // Starfield animation script
        const canvas = document.getElementById('starfield');
        const ctx = canvas.getContext('2d');

        let stars = [];
        const numStars = 150;
        const connectionDistance = 40; 
        const mouseInteractionRadius = 150; 
        let mouse = { x: null, y: null };

        let spaceships = []; 
        const numSpaceships = 3; 
        const spaceshipSize = 40; 
        const SVG_SPACESHIP_STRING = '<svg width="40" height="60" viewBox="0 0 40 60" xmlns="http://www.w3.org/2000/svg"><path d="M20,0 L10,25 L10,50 Q20,60 30,50 L30,25 Z" fill="#cccccc" stroke="#999999" stroke-width="1"/><path d="M20,0 L15,10 L25,10 Z" fill="#aaaaaa"/><path d="M10,40 L5,55 L10,50 Z" fill="#bbbbbb"/><path d="M30,40 L35,55 L30,50 Z" fill="#bbbbbb"/></svg>';
        const starToSpaceshipShieldFactor = 1.8; 
        const spaceshipToSpaceshipShieldFactor = 1.6; 

        function resizeCanvas() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }
        window.addEventListener('resize', resizeCanvas);
        resizeCanvas();

        class Vector {
            constructor(x, y) {
                this.x = x || 0;
                this.y = y || 0;
            }
            add(v) { this.x += v.x; this.y += v.y; return this; }
            subtract(v) { this.x -= v.x; this.y -= v.y; return this; }
            multiply(s) { this.x *= s; this.y *= s; return this; }
            divide(s) { if (s !== 0) { this.x /= s; this.y /= s; } return this; }
            magnitude() { return Math.sqrt(this.x * this.x + this.y * this.y); }
            normalize() { let m = this.magnitude(); if (m > 0) { this.divide(m); } return this; }
            limit(max) { if (this.magnitude() > max) { this.normalize(); this.multiply(max); } return this; }
            setMagnitude(len) { this.normalize(); this.multiply(len); return this; }
            dot(v) { return this.x * v.x + this.y * v.y; }
            clone() { return new Vector(this.x, this.y); }
        }

        function distance(x1, y1, x2, y2) {
            const dx = x1 - x2;
            const dy = y1 - y2;
            return Math.sqrt(dx * dx + dy * dy);
        }

        class Star {
            constructor() {
                this.pos = new Vector(Math.random() * canvas.width, Math.random() * canvas.height);
                this.baseRadius = Math.random() * 1.5 + 0.5;
                this.radius = this.baseRadius * (1.5 + Math.random() * 1.5); 
                this.color = `rgba(255, 255, 255, ${Math.random() * 0.4 + 0.3})`;
                this.mass = Math.PI * this.radius * this.radius; 
                if (this.mass === 0) this.mass = 0.001;
                // 修改：星星初始速度减半
                this.vel = new Vector((Math.random() - 0.5) * 0.4, (Math.random() - 0.5) * 0.4); 
                // 修改：星星最大速度减半
                this.maxSpeed = (0.6 + Math.random() * 0.4) / 2; 
                this.maxForce = 0.02 + Math.random() * 0.01; // Max force remains, affects acceleration not top speed directly
                this.wanderAngle = Math.random() * Math.PI * 2; 
            }

            draw() {
                ctx.beginPath();
                ctx.arc(this.pos.x, this.pos.y, this.radius, 0, Math.PI * 2, false);
                ctx.fillStyle = this.color;
                ctx.fill();
            }

            applyBoids(starsArray, currentSpaceships) { 
                let separation = this.separate(starsArray);
                let alignment = this.align(starsArray); 
                let cohesion = this.cohesion(starsArray); 
                let wander = this.wander();
                let mouseAvoid = this.avoidMouse();

                separation = separation.multiply(2.0);
                alignment = alignment.multiply(0.3); 
                cohesion = cohesion.multiply(0.2);
                wander = wander.multiply(0.8);
                mouseAvoid = mouseAvoid.multiply(2.0);

                this.applyForce(separation);
                this.applyForce(alignment);
                this.applyForce(cohesion);
                this.applyForce(wander);
                this.applyForce(mouseAvoid);
                
                this.interactWithSpaceshipShields(currentSpaceships);
            }

            update() {
                this.pos.add(this.vel); 
                if (this.pos.x + this.radius > canvas.width) {
                    this.pos.x = canvas.width - this.radius;
                    this.vel.x *= -0.8; 
                } else if (this.pos.x - this.radius < 0) {
                    this.pos.x = this.radius;
                    this.vel.x *= -0.8;
                }
                if (this.pos.y + this.radius > canvas.height) {
                    this.pos.y = canvas.height - this.radius;
                    this.vel.y *= -0.8;
                } else if (this.pos.y - this.radius < 0) {
                    this.pos.y = this.radius;
                    this.vel.y *= -0.8;
                }
                this.draw();
            }

            applyForce(force) {
                let acc = force.clone().divide(this.mass); 
                this.vel.add(acc);
                this.vel.limit(this.maxSpeed);
            }

            separate(others) {
                let desiredSeparation = this.radius * 2.0; 
                let steer = new Vector(0, 0);
                let count = 0;
                for (let other of others) {
                    if (other === this) continue;
                    let d = distance(this.pos.x, this.pos.y, other.pos.x, other.pos.y);
                    if (d > 0 && d < desiredSeparation && d < this.radius + other.radius + 5) {
                        let diff = this.pos.clone().subtract(other.pos);
                        diff.normalize();
                        diff.divide(d * 0.5); 
                        steer.add(diff);
                        count++;
                    }
                }
                if (count > 0) steer.divide(count); 
                if (steer.magnitude() > 0) {
                    steer.setMagnitude(this.maxSpeed);
                    steer.subtract(this.vel);
                    steer.limit(this.maxForce * 0.5); 
                }
                return steer;
            }

            align(others) { return new Vector(); } 
            cohesion(others) { return new Vector(); }

            wander() {
                let wanderRadius = 8;       
                let wanderDistance = 15;    
                let wanderChange = 0.2;     
                this.wanderAngle += (Math.random() * wanderChange) - (wanderChange * 0.5); 

                let circlePos = this.vel.clone();
                circlePos.normalize();
                circlePos.multiply(wanderDistance);
                circlePos.add(this.pos);

                let h = Math.atan2(this.vel.y, this.vel.x); 
                let wanderX = wanderRadius * Math.cos(this.wanderAngle + h);
                let wanderY = wanderRadius * Math.sin(this.wanderAngle + h);
                
                let target = circlePos.add(new Vector(wanderX, wanderY));
                return this.seek(target);
            }

            seek(target) {
                let desired = target.clone().subtract(this.pos); 
                desired.setMagnitude(this.maxSpeed);
                let steer = desired.subtract(this.vel); 
                steer.limit(this.maxForce);
                return steer;
            }

            avoidMouse() {
                if (mouse.x === null || mouse.y === null) return new Vector(0,0);
                let d = distance(this.pos.x, this.pos.y, mouse.x, mouse.y);
                if (d < mouseInteractionRadius) { 
                    let desired = this.pos.clone().subtract(new Vector(mouse.x, mouse.y)); 
                    desired.setMagnitude(this.maxSpeed);
                    let steer = desired.subtract(this.vel);
                    steer.limit(this.maxForce * 1.5); 
                    return steer;
                }
                return new Vector(0,0);
            }

            interactWithSpaceshipShields(currentSpaceships) {
                if (!currentSpaceships || currentSpaceships.length === 0) return;
                const shieldFactor = starToSpaceshipShieldFactor; 
                for (let ship of currentSpaceships) {
                    const actualShieldRadius = ship.size * shieldFactor; 
                    let distToShipCenter = distance(this.pos.x, this.pos.y, ship.pos.x, ship.pos.y);
                    if (distToShipCenter < actualShieldRadius + this.radius) {
                        let normal = this.pos.clone().subtract(ship.pos);
                        normal.normalize(); 
                        let dotProduct = this.vel.dot(normal);
                        this.vel.x -= 2 * dotProduct * normal.x;
                        this.vel.y -= 2 * dotProduct * normal.y;
                        let overlap = (actualShieldRadius + this.radius) - distToShipCenter;
                        if (overlap > 0) { 
                           this.pos.add(normal.clone().multiply(overlap + 0.1)); 
                        }
                    }
                }
            }
        }

        class Spaceship {
            constructor(x, y, size) { 
                this.pos = new Vector(x, y);
                this.vel = new Vector(Math.random() * 2 - 1, Math.random() * 2 - 1);
                // 修改：飞船初始速度减半
                this.vel.setMagnitude((Math.random() * 1 + 0.5) / 2); 
                this.size = size; 
                this.svgImage = new Image();
                this.svgLoaded = false;
                this.rotation = 0; 
                const svgDataUri = 'data:image/svg+xml;charset=utf-8,' + encodeURIComponent(SVG_SPACESHIP_STRING);
                this.svgImage.onload = () => { this.svgLoaded = true; };
                this.svgImage.src = svgDataUri;
                this.flameBaseLength = this.size * 0.8; 
                this.flameAnimationTimer = Math.random() * 100;
                this.flameColor1 = 'rgba(255, 220, 180, 0.7)';
                this.flameColor2 = 'rgba(255, 165, 0, 0.6)';
                this.flameColor3 = 'rgba(255, 69, 0, 0.4)';
            }

            update(canvasInstance) { 
                this.pos.add(this.vel); 
                if (this.pos.x > canvasInstance.width + this.size) this.pos.x = -this.size;
                if (this.pos.x < -this.size) this.pos.x = canvasInstance.width + this.size;
                if (this.pos.y > canvasInstance.height + this.size) this.pos.y = -this.size;
                if (this.pos.y < -this.size) this.pos.y = canvasInstance.height + this.size;
                this.rotation = Math.atan2(this.vel.y, this.vel.x) + Math.PI / 2; 
                this.flameAnimationTimer += 0.2;
            }

            draw(ctxInstance) { 
                const aspectRatio = 40 / 60; 
                const drawHeight = this.size; 
                const drawWidth = drawHeight * aspectRatio;
                if (this.svgLoaded) {
                    ctxInstance.save();
                    ctxInstance.translate(this.pos.x, this.pos.y);
                    ctxInstance.rotate(this.rotation);
                    ctxInstance.drawImage(this.svgImage, -drawWidth / 2, -drawHeight / 2, drawWidth, drawHeight);
                    ctxInstance.restore();
                }
                ctxInstance.save();
                ctxInstance.translate(this.pos.x, this.pos.y);
                ctxInstance.rotate(this.rotation); 
                let flameBaseYOffset = drawHeight * 0.5; 
                let currentFlameLength = this.flameBaseLength + Math.sin(this.flameAnimationTimer) * this.flameBaseLength * 0.2;
                let flickerWidthFactor = 0.3 + (Math.sin(this.flameAnimationTimer * 1.5) + 1) * 0.15;
                ctxInstance.fillStyle = this.flameColor3;
                ctxInstance.beginPath();
                ctxInstance.moveTo(0, flameBaseYOffset);
                let outerWidth = drawWidth * flickerWidthFactor * 0.8; 
                let outerLength = currentFlameLength * 0.9;
                ctxInstance.lineTo(-outerWidth / 2, flameBaseYOffset + outerLength);
                ctxInstance.lineTo(outerWidth / 2, flameBaseYOffset + outerLength);
                ctxInstance.closePath();
                ctxInstance.fill();
                ctxInstance.fillStyle = this.flameColor2;
                ctxInstance.beginPath();
                ctxInstance.moveTo(0, flameBaseYOffset);
                let midWidth = outerWidth * 0.75;
                let midLength = currentFlameLength;
                ctxInstance.lineTo(-midWidth / 2, flameBaseYOffset + midLength);
                ctxInstance.lineTo(midWidth / 2, flameBaseYOffset + midLength);
                ctxInstance.closePath();
                ctxInstance.fill();
                ctxInstance.fillStyle = this.flameColor1;
                ctxInstance.beginPath();
                ctxInstance.moveTo(0, flameBaseYOffset);
                let coreWidth = outerWidth * 0.5;
                let coreLength = currentFlameLength * 0.8;
                ctxInstance.lineTo(-coreWidth / 2, flameBaseYOffset + coreLength);
                ctxInstance.lineTo(coreWidth / 2, flameBaseYOffset + coreLength);
                ctxInstance.closePath();
                ctxInstance.fill();
                ctxInstance.restore();
            }
        }

        function resolveCollision(s1, s2) {
            const xVelDiff = s1.vel.x - s2.vel.x;
            const yVelDiff = s1.vel.y - s2.vel.y;
            const xDist = s2.pos.x - s1.pos.x;
            const yDist = s2.pos.y - s1.pos.y;
            if (xVelDiff * xDist + yVelDiff * yDist >= 0) {
                const angle = -Math.atan2(yDist, xDist);
                const m1 = s1.mass;
                const m2 = s2.mass;
                const u1 = rotate(s1.vel, angle); 
                const u2 = rotate(s2.vel, angle);
                const v1 = new Vector(u1.x * (m1 - m2) / (m1 + m2) + u2.x * 2 * m2 / (m1 + m2), u1.y);
                const v2 = new Vector(u2.x * (m2 - m1) / (m1 + m2) + u1.x * 2 * m1 / (m1 + m2), u2.y);
                const vFinal1 = rotate(v1, -angle); 
                const vFinal2 = rotate(v2, -angle);
                s1.vel.x = vFinal1.x; s1.vel.y = vFinal1.y;
                s2.vel.x = vFinal2.x; s2.vel.y = vFinal2.y;
                const overlap = (s1.radius + s2.radius) - distance(s1.pos.x, s1.pos.y, s2.pos.x, s2.pos.y);
                if (overlap > 0) {
                    const correctionNormal = s1.pos.clone().subtract(s2.pos).normalize();
                    const correction1 = correctionNormal.clone().multiply(overlap * (s2.mass / (s1.mass + s2.mass)));
                    const correction2 = correctionNormal.clone().multiply(-overlap * (s1.mass / (s1.mass + s2.mass)));
                    s1.pos.add(correction1); s2.pos.add(correction2);
                }
            }
        }
        
        function resolveSpaceshipShieldCollision(shipA, shipB, shieldFactor) {
            const shieldARadius = shipA.size * shieldFactor; 
            const shieldBRadius = shipB.size * shieldFactor; 
            const distBetweenShips = distance(shipA.pos.x, shipA.pos.y, shipB.pos.x, shipB.pos.y);
            if (distBetweenShips < shieldARadius + shieldBRadius && distBetweenShips > 0) { 
                let normalBtoA = shipA.pos.clone().subtract(shipB.pos);
                normalBtoA.normalize(); 
                const overlap = (shieldARadius + shieldBRadius) - distBetweenShips;
                shipA.pos.add(normalBtoA.clone().multiply(overlap / 2 + 0.05)); 
                shipB.pos.subtract(normalBtoA.clone().multiply(overlap / 2 + 0.05)); 
                let dotProductA = shipA.vel.dot(normalBtoA);
                shipA.vel.x -= 2 * dotProductA * normalBtoA.x;
                shipA.vel.y -= 2 * dotProductA * normalBtoA.y;
                let normalAtoB = normalBtoA.clone().multiply(-1);
                let dotProductB = shipB.vel.dot(normalAtoB);
                shipB.vel.x -= 2 * dotProductB * normalAtoB.x;
                shipB.vel.y -= 2 * dotProductB * normalAtoB.y;
            }
        }

        function rotate(velocity, angle) {
            return new Vector(
                velocity.x * Math.cos(angle) - velocity.y * Math.sin(angle),
                velocity.x * Math.sin(angle) + velocity.y * Math.cos(angle)
            );
        }

        window.addEventListener('mousemove', (event) => { mouse.x = event.clientX; mouse.y = event.clientY; });
        window.addEventListener('mouseout', () => { mouse.x = null; mouse.y = null; });

        function initStars() {
            stars = [];
            for (let i = 0; i < numStars; i++) { stars.push(new Star()); }
        }
        
        function initSpaceships() {
            spaceships = []; 
            for (let i = 0; i < numSpaceships; i++) {
                let x = Math.random() * canvas.width;
                let y = Math.random() * canvas.height;
                spaceships.push(new Spaceship(x, y, spaceshipSize)); 
            }
        }

        initStars();
        initSpaceships();

        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height); 
            stars.forEach(star => { star.applyBoids(stars, spaceships); });
            for (let i = 0; i < stars.length; i++) {
                for (let j = i + 1; j < stars.length; j++) {
                    const s1 = stars[i]; const s2 = stars[j];
                    const distVal = distance(s1.pos.x, s1.pos.y, s2.pos.x, s2.pos.y);
                    if (distVal < s1.radius + s2.radius) { resolveCollision(s1, s2); }
                }
            }
            if (connectionDistance > 0) {
                for (let i = 0; i < stars.length; i++) {
                    for (let j = i + 1; j < stars.length; j++) {
                        if (Math.random() < 0.02) { 
                            const d = distance(stars[i].pos.x, stars[i].pos.y, stars[j].pos.x, stars[j].pos.y);
                            if (d < connectionDistance) {
                                ctx.beginPath();
                                ctx.moveTo(stars[i].pos.x, stars[i].pos.y);
                                ctx.lineTo(stars[j].pos.x, stars[j].pos.y);
                                ctx.strokeStyle = `rgba(255, 255, 255, ${0.5 - (d / connectionDistance) * 0.4})`;
                                ctx.lineWidth = 0.3;
                                ctx.stroke();
                            }
                        }
                    }
                }
            }
            stars.forEach(star => { star.update(); });
            for (let i = 0; i < spaceships.length; i++) {
                for (let j = i + 1; j < spaceships.length; j++) { 
                    resolveSpaceshipShieldCollision(spaceships[i], spaceships[j], spaceshipToSpaceshipShieldFactor);
                }
            }
            spaceships.forEach(ship => { ship.update(canvas); ship.draw(ctx); });
            requestAnimationFrame(animate); 
        }
        
        window.onload = function () { animate(); }
        
        window.addEventListener('resize', () => {
            resizeCanvas(); initStars(); initSpaceships(); 
        });
    </script>
</body>
</html>
