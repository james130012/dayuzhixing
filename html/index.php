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
        // 1. 获取 AppID 和 AppSecret (安全地存储在服务器端)
        $appId = '在此处填入您的微信公众号AppID'; // 【重要】替换为您的 AppID
        // $appSecret = '您的AppSecret'; // 【重要】这个不应该暴露在前端

        // 2. 获取 access_token (通常有效期为2小时，需要缓存)
        //    请求URL: https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=APPID&secret=APPSECRET
        //    $accessToken = get_access_token($appId, $appSecret); // 您需要实现这个函数

        // 3. 获取 jsapi_ticket (通常有效期为2小时，需要缓存，依赖于 access_token)
        //    请求URL: https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=ACCESS_TOKEN&type=jsapi
        //    $jsapiTicket = get_jsapi_ticket($accessToken); // 您需要实现这个函数

        // 4. 生成签名
        $timestamp = time();
        $nonceStr = uniqid(); // 随机字符串
        // $url = $current_page_url; // 参与签名的URL是当前页面的完整URL(不包含#及其后面部分)
        
        // 签名算法: sha1("jsapi_ticket=JSAPITICKET&noncestr=NONCESTR&timestamp=TIMESTAMP&url=URL")
        // $stringToSign = "jsapi_ticket={$jsapiTicket}&noncestr={$nonceStr}&timestamp={$timestamp}&url={$url}";
        // $signature = sha1($stringToSign);

        // 【重要】您需要在服务器端实现上述获取 ticket 和生成 signature 的逻辑
        // 下面是传递给前端JS的占位符，您需要用实际从后端获取的值替换它们
        $jssdk_config = [
            'appId'     => $appId,
            'timestamp' => $timestamp, // PHP 生成的时间戳
            'nonceStr'  => $nonceStr,  // PHP 生成的随机字符串
            'signature' => '服务器端生成的签名', // 【重要】替换为服务器端生成的实际签名
            'jsApiList' => [ // 需要使用的JS接口列表
                'updateAppMessageShareData',
                'updateTimelineShareData',
                'onMenuShareTimeline', // 兼容旧版
                'onMenuShareAppMessage' // 兼容旧版
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
            --star-bg: #000002; /* 更极致的深空背景色 */
            --tile-bg: rgba(20, 30, 60, 0.8);
            --tile-hover-bg: rgba(35, 50, 85, 0.95);
            --text-color: #e0e8f0;
            --header-color: #f0f8ff;
            --border-color: rgba(255, 255, 255, 0.1);
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
            overflow-x: hidden; /* 防止横向滚动条 */
        }

        /* Canvas 星空背景样式 */
        #starfield {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1; /* 置于最底层 */
            pointer-events: none; /* 确保不干扰页面交互 */
        }

        /* 页面容器 */
        .container {
            background-color: rgba(10, 15, 30, 0.75);
            padding: 35px 45px;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4), 0 0 10px rgba(100,100,255,0.1);
            width: 95%;
            max-width: 1200px;
            text-align: center;
            margin-top: 20px;
            border: 1px solid var(--border-color);
            position: relative; /* 确保内容在 Canvas 之上 */
            z-index: 1;
        }

        /* 头部标题 */
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

        /* 导航区域 */
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

        /* 导航列表 - 磁贴布局 */
        #auto-navigation ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 25px;
        }

        /* 导航列表项 - 磁贴样式 */
        #auto-navigation ul li {
            background-color: var(--tile-bg);
            border-radius: 15px;
            transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
            overflow: visible;
            border: 1px solid rgba(255, 255, 255, 0.08);
            min-height: 140px;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        #auto-navigation ul li:hover {
            transform: translateY(-10px) scale(1.05);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.6), 0 0 25px rgba(135, 206, 250, 0.4);
            background-color: var(--tile-hover-bg);
        }

        /* 导航链接 */
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

        /* 图标和日期区域 */
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


        /* 当列表为空时的提示 */
        #auto-navigation ul li.no-files {
            grid-column: 1 / -1;
            text-align: center;
            padding: 25px;
            color: #9ca3af;
            background-color: rgba(55, 65, 81, 0.5);
            border: 1px dashed var(--border-color);
            box-shadow: none;
            min-height: auto;
        }
        #auto-navigation ul li.no-files:hover {
            transform: none;
            box-shadow: none;
            background-color: rgba(55, 65, 81, 0.5);
        }


        /* 页脚 */
        footer {
            margin-top: 50px;
            padding: 25px;
            color: rgba(229, 231, 235, 0.6);
            font-size: 0.9em;
            width: 100%;
            text-align: center;
            z-index: 1;
        }

        /* 响应式调整 */
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
            debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。生产环境请设置为 false
            appId: wxConfig.appId, // 必填，公众号的唯一标识
            timestamp: wxConfig.timestamp, // 必填，生成签名的时间戳
            nonceStr: wxConfig.nonceStr, // 必填，生成签名的随机串
            signature: wxConfig.signature,// 必填，签名
            jsApiList: wxConfig.jsApiList // 必填，需要使用的JS接口列表
        });

        wx.ready(function () {
            // config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作。
            // 分享的标题、描述、链接和图片URL
            const shareTitle = '大宇之形 方寸之间';
            const shareDesc = '见证、记录、储存人类点点滴的灵性。';
            const shareLink = '<?php echo htmlspecialchars($current_page_url); ?>'; // 当前页面链接
            const shareImgUrl = '<?php echo htmlspecialchars($image_url); ?>'; // 分享图标的绝对路径

            // 自定义“分享给朋友”及“分享到QQ”按钮的分享内容（1.4.0）
            wx.updateAppMessageShareData({
                title: shareTitle,
                desc: shareDesc,
                link: shareLink,
                imgUrl: shareImgUrl,
                success: function () {
                    // 设置成功
                    console.log('微信分享给朋友成功设置');
                },
                cancel: function () {
                    // 用户取消分享
                    console.log('用户取消分享给朋友');
                }
            });

            // 自定义“分享到朋友圈”及“分享到QQ空间”按钮的分享内容（1.4.0）
            wx.updateTimelineShareData({
                title: shareTitle, // 分享到朋友圈的标题，通常只显示标题，描述会被忽略
                link: shareLink,
                imgUrl: shareImgUrl,
                success: function () {
                    // 设置成功
                    console.log('微信分享到朋友圈成功设置');
                },
                cancel: function () {
                    // 用户取消分享
                    console.log('用户取消分享到朋友圈');
                }
            });

            // --- 兼容旧版微信的分享接口 (如果 wx.updateAppMessageShareData 和 wx.updateTimelineShareData 不可用) ---
            // 获取“分享到朋友圈”按钮点击状态及自定义分享内容接口（即将废弃）
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

            // 获取“分享给朋友”按钮点击状态及自定义分享内容接口（即将废弃）
            wx.onMenuShareAppMessage({
                title: shareTitle,
                desc: shareDesc,
                link: shareLink,
                imgUrl: shareImgUrl,
                type: 'link', // 分享类型,music、video或link，不填默认为link
                dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                success: function () {
                    console.log('旧版微信分享给朋友成功');
                },
                cancel: function () {
                    console.log('用户取消旧版分享给朋友');
                }
            });
        });

        wx.error(function(res){
            // config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。
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

        // Spaceship specific variables
        let spaceships = [];
        const numSpaceships = 3;
        // const spaceshipEmoji = "🚀"; // No longer used for SVG spaceship
        const spaceshipSize = 40; // Base size for spaceships (height for SVG)
        const SVG_SPACESHIP_STRING = '<svg width="40" height="60" viewBox="0 0 40 60" xmlns="http://www.w3.org/2000/svg"><path d="M20,0 L10,25 L10,50 Q20,60 30,50 L30,25 Z" fill="#cccccc" stroke="#999999" stroke-width="1"/><path d="M20,0 L15,10 L25,10 Z" fill="#aaaaaa"/><path d="M10,40 L5,55 L10,50 Z" fill="#bbbbbb"/><path d="M30,40 L35,55 L30,50 Z" fill="#bbbbbb"/></svg>';


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
                this.vel = new Vector((Math.random() - 0.5) * 0.8, (Math.random() - 0.5) * 0.8);
                this.maxSpeed = 0.6 + Math.random() * 0.4;
                this.maxForce = 0.02 + Math.random() * 0.01;
                this.wanderAngle = Math.random() * Math.PI * 2;
            }

            draw() {
                ctx.beginPath();
                ctx.arc(this.pos.x, this.pos.y, this.radius, 0, Math.PI * 2, false);
                ctx.fillStyle = this.color;
                ctx.fill();
            }

            applyBoids(starsArray) {
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
        }

        class Spaceship {
            constructor(x, y, size) { // Removed emoji parameter
                this.pos = new Vector(x, y);
                this.vel = new Vector(Math.random() * 2 - 1, Math.random() * 2 - 1);
                this.vel.setMagnitude(Math.random() * 1 + 0.5);
                this.size = size; // Represents target height for SVG on canvas
                
                this.svgImage = new Image();
                this.svgLoaded = false;
                this.rotation = 0; // To store the ship's rotation angle

                // Preload the SVG
                const svgDataUri = 'data:image/svg+xml;charset=utf-8,' + encodeURIComponent(SVG_SPACESHIP_STRING);
                this.svgImage.onload = () => {
                    this.svgLoaded = true;
                };
                this.svgImage.src = svgDataUri;

                // Flame properties remain
                this.flameBaseLength = this.size * 0.8; // Flame length relative to ship size
                this.flameAnimationTimer = Math.random() * 100;
                this.flameColor1 = 'rgba(255, 220, 180, 0.7)';
                this.flameColor2 = 'rgba(255, 165, 0, 0.6)';
                this.flameColor3 = 'rgba(255, 69, 0, 0.4)';
            }

            update(canvas) {
                this.pos.add(this.vel);
                if (this.pos.x > canvas.width + this.size) this.pos.x = -this.size;
                if (this.pos.x < -this.size) this.pos.x = canvas.width + this.size;
                if (this.pos.y > canvas.height + this.size) this.pos.y = -this.size;
                if (this.pos.y < -this.size) this.pos.y = canvas.height + this.size;
                
                this.rotation = Math.atan2(this.vel.y, this.vel.x) + Math.PI / 2; // Update rotation based on velocity
                this.flameAnimationTimer += 0.2;
            }

            draw(ctx) {
                const aspectRatio = 40 / 60; // Intrinsic width / height of SVG
                const drawHeight = this.size; 
                const drawWidth = drawHeight * aspectRatio;

                // Draw SVG Spaceship
                if (this.svgLoaded) {
                    ctx.save();
                    ctx.translate(this.pos.x, this.pos.y);
                    ctx.rotate(this.rotation);
                    ctx.drawImage(this.svgImage, -drawWidth / 2, -drawHeight / 2, drawWidth, drawHeight);
                    ctx.restore();
                } else {
                    // Optional placeholder:
                    // ctx.fillStyle = 'grey';
                    // ctx.fillRect(this.pos.x - drawWidth / 2, this.pos.y - drawHeight / 2, drawWidth, drawHeight);
                }

                // Procedural Flame Drawing
                ctx.save();
                ctx.translate(this.pos.x, this.pos.y);
                ctx.rotate(this.rotation); // Use the same rotation for the flame

                // Adjust flameBaseYOffset to align with the bottom of the SVG
                // SVG's (0,0) is top-left. After centering and rotating, bottom center is at (0, drawHeight / 2)
                let flameBaseYOffset = drawHeight * 0.5; 

                let currentFlameLength = this.flameBaseLength + Math.sin(this.flameAnimationTimer) * this.flameBaseLength * 0.2;
                let flickerWidthFactor = 0.3 + (Math.sin(this.flameAnimationTimer * 1.5) + 1) * 0.15;

                ctx.fillStyle = this.flameColor3;
                ctx.beginPath();
                ctx.moveTo(0, flameBaseYOffset);
                let outerWidth = drawWidth * flickerWidthFactor * 0.8; // Make flame width relative to ship width
                let outerLength = currentFlameLength * 0.9;
                ctx.lineTo(-outerWidth / 2, flameBaseYOffset + outerLength);
                ctx.lineTo(outerWidth / 2, flameBaseYOffset + outerLength);
                ctx.closePath();
                ctx.fill();

                ctx.fillStyle = this.flameColor2;
                ctx.beginPath();
                ctx.moveTo(0, flameBaseYOffset);
                let midWidth = outerWidth * 0.75;
                let midLength = currentFlameLength;
                ctx.lineTo(-midWidth / 2, flameBaseYOffset + midLength);
                ctx.lineTo(midWidth / 2, flameBaseYOffset + midLength);
                ctx.closePath();
                ctx.fill();

                ctx.fillStyle = this.flameColor1;
                ctx.beginPath();
                ctx.moveTo(0, flameBaseYOffset);
                let coreWidth = outerWidth * 0.5;
                let coreLength = currentFlameLength * 0.8;
                ctx.lineTo(-coreWidth / 2, flameBaseYOffset + coreLength);
                ctx.lineTo(coreWidth / 2, flameBaseYOffset + coreLength);
                ctx.closePath();
                ctx.fill();

                ctx.restore();
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
                s1.vel.x = vFinal1.x;
                s1.vel.y = vFinal1.y;
                s2.vel.x = vFinal2.x;
                s2.vel.y = vFinal2.y;
                const overlap = (s1.radius + s2.radius) - distance(s1.pos.x, s1.pos.y, s2.pos.x, s2.pos.y);
                if (overlap > 0) {
                    const correctionNormal = s1.pos.clone().subtract(s2.pos).normalize();
                    const correction1 = correctionNormal.clone().multiply(overlap * (s2.mass / (s1.mass + s2.mass)));
                    const correction2 = correctionNormal.clone().multiply(-overlap * (s1.mass / (s1.mass + s2.mass)));
                    s1.pos.add(correction1);
                    s2.pos.add(correction2);
                }
            }
        }

        function rotate(velocity, angle) {
            return new Vector(
                velocity.x * Math.cos(angle) - velocity.y * Math.sin(angle),
                velocity.x * Math.sin(angle) + velocity.y * Math.cos(angle)
            );
        }

        window.addEventListener('mousemove', (event) => {
            mouse.x = event.clientX;
            mouse.y = event.clientY;
        });
        window.addEventListener('mouseout', () => {
            mouse.x = null;
            mouse.y = null;
        });

        function initStars() {
            stars = [];
            for (let i = 0; i < numStars; i++) {
                stars.push(new Star());
            }
        }
        
        function initSpaceships() {
            spaceships = [];
            for (let i = 0; i < numSpaceships; i++) {
                let x = Math.random() * canvas.width;
                let y = Math.random() * canvas.height;
                spaceships.push(new Spaceship(x, y, spaceshipSize)); // Updated constructor call
            }
        }

        initStars();
        initSpaceships();

        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            stars.forEach(star => {
                star.applyBoids(stars);
            });
            for (let i = 0; i < stars.length; i++) {
                for (let j = i + 1; j < stars.length; j++) {
                    const s1 = stars[i];
                    const s2 = stars[j];
                    const dist = distance(s1.pos.x, s1.pos.y, s2.pos.x, s2.pos.y);
                    if (dist < s1.radius + s2.radius) {
                        resolveCollision(s1, s2);
                    }
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
            stars.forEach(star => {
                star.update();
            });

            // Update and draw spaceships
            spaceships.forEach(ship => {
                ship.update(canvas); 
                ship.draw(ctx);
            });

            requestAnimationFrame(animate);
        }
        animate();

        window.addEventListener('resize', () => {
            resizeCanvas();
            initStars();
            initSpaceships(); 
        });
    </script>
</body>
</html>
