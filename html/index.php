好的！我来重新设计，让场景更震撼和谐，移除突兀的防护罩，让飞船更明显，并增加更多视觉效果：

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

    <!-- P5.js 库引入 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.7.0/p5.min.js"></script>
    
    <!-- Three.js 库引入 -->
    <script type="importmap">
    {
        "imports": {
            "three": "https://cdn.jsdelivr.net/npm/three@0.164.1/build/three.module.js",
            "three/addons/": "https://cdn.jsdelivr.net/npm/three@0.164.1/examples/jsm/"
        }
    }
    </script>
    <script type="module">
        import * as THREE from 'three';
        import { OrbitControls } from 'three/addons/controls/OrbitControls.js';
        import { GLTFLoader } from 'three/addons/loaders/GLTFLoader.js';

        let scene, camera, renderer, controls, helmet;
        let isHelmetLoaded = false;

        function initThreeJS() {
            // 创建场景
            scene = new THREE.Scene();
            scene.background = new THREE.Color(0x000000);

            // 创建相机
            camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
            camera.position.set(0, 0, 500);

            // 创建渲染器
            renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
            renderer.setSize(window.innerWidth, window.innerHeight);
            renderer.setPixelRatio(window.devicePixelRatio);
            renderer.shadowMap.enabled = true;
            document.getElementById('starfield').appendChild(renderer.domElement);

            // 添加轨道控制器
            controls = new OrbitControls(camera, renderer.domElement);
            controls.target.set(0, 0, 0);
            controls.enableDamping = true;
            controls.dampingFactor = 0.05;
            controls.update();

            // 添加光源
            const ambientLight = new THREE.AmbientLight(0x404040, 0.5);
            scene.add(ambientLight);
            
            const directionalLight = new THREE.DirectionalLight(0xffffff, 0.8);
            directionalLight.position.set(5, 5, 5);
            directionalLight.castShadow = true;
            scene.add(directionalLight);
            
            const pointLight = new THREE.PointLight(0xffffff, 0.5, 100);
            pointLight.position.set(-5, 5, 5);
            scene.add(pointLight);

            // 加载头盔模型
            const loader = new GLTFLoader();
            loader.load(
                'https://threejs.org/examples/models/gltf/DamagedHelmet/gLTF/DamagedHelmet.gltf',
                (gltf) => {
                    helmet = gltf.scene;
                    helmet.scale.set(50, 50, 50);
                    helmet.position.set(0, 0, 0);
                    helmet.rotation.y = Math.PI;
                    helmet.castShadow = true;
                    helmet.receiveShadow = true;
                    scene.add(helmet);
                    isHelmetLoaded = true;
                    console.log('Helmet loaded successfully');
                },
                (xhr) => {
                    console.log(`Loading ${xhr.loaded / xhr.total * 100}%`);
                },
                (error) => {
                    console.error('Error loading GLTF model:', error);
                }
            );

            // 开始动画循环
            animate();
        }

        function animate() {
            requestAnimationFrame(animate);
            
            if (isHelmetLoaded) {
                helmet.rotation.y += 0.005;
            }
            
            controls.update();
            renderer.render(scene, camera);
        }

        // 窗口大小调整
        window.addEventListener('resize', () => {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        });

        // 初始化Three.js
        initThreeJS();
    </script>

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

        /* 添加Three.js画布样式 */
        #starfield canvas {
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1;
        }
        
        #starfield canvas:last-child {
            z-index: 2;
        }
    </style>
</head>
<body>
    <div id="starfield"></div>

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
        <p>&copy; <?php echo date("Y"); ?> ・ 所有权归jamesband</p>
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
        // P5.js 3D星空动画 - 震撼和谐版
        let stars = [];
        let comets = [];
        let asteroids = [];
        let blackHoles = [];
        let nebulaClouds = [];
        let cosmicDust = [];
        let mechHelmet = {
            x: 0,
            y: 0,
            z: 0,
            rotation: 0,
            rotationSpeed: 0.005,
            scale: 150,
            energyLevel: 0,
            energyParticles: [],
            visorGlow: 0,
            details: {
                visor: { color: [0, 200, 255], alpha: 180 },
                energy: { color: [255, 100, 0], alpha: 150 },
                metal: { color: [180, 180, 200], alpha: 255 }
            }
        };
        let camera3D = {
            x: 0,
            y: 0,
            z: 500,
            rotationX: 0,
            rotationY: 0,
            autoRotate: true,
            speed: 0.002
        };
        
        const numStars = 500;
        const numComets = 8;
        const numAsteroids = 200;
        const numBlackHoles = 2;
        const numNebulaClouds = 12;
        const numCosmicDust = 800;
        const connectionDistance = 150;
        const spaceSize = 4000;
        
        let mousePos = { x: 0, y: 0 };
        
        // P5.js 主函数
        function setup() {
            let canvas = createCanvas(windowWidth, windowHeight, WEBGL);
            canvas.parent('starfield');
            
            // 初始化所有元素
            initStars3D();
            initComets3D();
            initAsteroids3D();
            initBlackHoles3D();
            initNebulaClouds3D();
            initCosmicDust3D();
            initMechHelmet3D();
        }
        
        function draw() {
            // 深邃的宇宙背景
            background(0, 0, 5);
            
            // 设置3D光照系统
            setupLighting3D();
            
            // 相机控制
            updateCamera3D();
            
            // 绘制星云背景
            drawNebulaClouds3D();
            
            // 绘制宇宙尘埃
            drawCosmicDust3D();
            
            // 更新和绘制星星
            updateStars3D();
            drawStars3D();
            
            // 绘制星星连接线
            drawConnections3D();
            
            // 更新和绘制彗星
            updateComets3D();
            drawComets3D();
            
            // 更新和绘制小行星
            updateAsteroids3D();
            drawAsteroids3D();
            
            // 更新和绘制黑洞
            updateBlackHoles3D();
            drawBlackHoles3D();

            // 更新和绘制机甲头盔
            updateMechHelmet3D();
            drawMechHelmet3D();
        }
        
        function setupLighting3D() {
            // 环境光
            ambientLight(15, 20, 35);
            
            // 主要点光源（模拟远程恒星）
            pointLight(80, 120, 200, 0, -500, 1000);
            pointLight(120, 80, 150, 500, 0, -500);
            pointLight(150, 100, 80, -800, 300, 200);
            
            // 方向光（模拟银河系光芒）
            directionalLight(30, 50, 80, -1, 0.5, -1);
        }
        
        function initStars3D() {
            stars = [];
            for (let i = 0; i < numStars; i++) {
                let starType = random(['main', 'giant', 'dwarf', 'pulsar', 'binary']);
                let star = {
                    x: random(-spaceSize, spaceSize),
                    y: random(-spaceSize, spaceSize),
                    z: random(-spaceSize, spaceSize),
                    vx: random(-0.2, 0.2),
                    vy: random(-0.2, 0.2),
                    vz: random(-0.2, 0.2),
                    type: starType,
                    size: getStarSize(starType),
                    color: getStarColor(starType),
                    brightness: random(0.6, 1.0),
                    pulsate: random(0.001, 0.005),
                    pulseOffset: random(TWO_PI),
                    maxSpeed: random(0.2, 0.8),
                    mass: random(1, 4),
                    twinkle: random(0.001, 0.003),
                    glow: random(0.5, 1.0),
                    trail: []
                };
                stars.push(star);
            }
        }
        
        function getStarSize(type) {
            switch(type) {
                case 'giant': return random(10, 18);
                case 'main': return random(4, 10);
                case 'dwarf': return random(2, 5);
                case 'pulsar': return random(3, 8);
                case 'binary': return random(3, 8);
                default: return random(3, 8);
            }
        }
        
        function getStarColor(type) {
            switch(type) {
                case 'giant': return [255, 150, 150];
                case 'main': return [255, 255, 220];
                case 'dwarf': return [220, 220, 255];
                case 'pulsar': return [150, 255, 255];
                case 'binary': return [255, 220, 150];
                default: return [255, 255, 255];
            }
        }
        
        function initComets3D() {
            comets = [];
            for (let i = 0; i < numComets; i++) {
                comets.push({
                    x: random(-spaceSize/2, spaceSize/2),
                    y: random(-spaceSize/2, spaceSize/2),
                    z: random(-spaceSize/2, spaceSize/2),
                    vx: random(-0.8, 0.8),
                    vy: random(-0.8, 0.8),
                    vz: random(-0.8, 0.8),
                    size: random(30, 60),
                    tailLength: random(100, 200),
                    color: [random(200, 255), random(200, 255), random(200, 255)],
                    particles: [],
                    rotation: random(TWO_PI),
                    rotationSpeed: random(0.01, 0.03)
                });
            }
        }

        function initAsteroids3D() {
            asteroids = [];
            for (let i = 0; i < numAsteroids; i++) {
                asteroids.push({
                    x: random(-spaceSize/2, spaceSize/2),
                    y: random(-spaceSize/2, spaceSize/2),
                    z: random(-spaceSize/2, spaceSize/2),
                    vx: random(-0.2, 0.2),
                    vy: random(-0.2, 0.2),
                    vz: random(-0.2, 0.2),
                    size: random(5, 15),
                    rotation: {
                        x: random(TWO_PI),
                        y: random(TWO_PI),
                        z: random(TWO_PI)
                    },
                    rotationSpeed: {
                        x: random(0.01, 0.03),
                        y: random(0.01, 0.03),
                        z: random(0.01, 0.03)
                    },
                    color: [random(100, 150), random(100, 150), random(100, 150)]
                });
            }
        }

        function initBlackHoles3D() {
            blackHoles = [];
            for (let i = 0; i < numBlackHoles; i++) {
                blackHoles.push({
                    x: random(-spaceSize/3, spaceSize/3),
                    y: random(-spaceSize/3, spaceSize/3),
                    z: random(-spaceSize/3, spaceSize/3),
                    size: random(100, 200),
                    accretionDisk: {
                        size: random(150, 300),
                        rotation: 0,
                        rotationSpeed: random(0.005, 0.01)
                    },
                    particles: []
                });
            }
        }
        
        function initNebulaClouds3D() {
            nebulaClouds = [];
            for (let i = 0; i < numNebulaClouds; i++) {
                nebulaClouds.push({
                    x: random(-spaceSize*2, spaceSize*2),
                    y: random(-spaceSize*2, spaceSize*2),
                    z: random(-spaceSize*2, spaceSize*2),
                    size: random(400, 1200),
                    density: random(0.1, 0.3),
                    color: [
                        random(100, 255),
                        random(50, 200),
                        random(150, 255)
                    ],
                    drift: {
                        x: random(-0.1, 0.1),
                        y: random(-0.1, 0.1),
                        z: random(-0.1, 0.1)
                    }
                });
            }
        }
        
        function initCosmicDust3D() {
            cosmicDust = [];
            for (let i = 0; i < numCosmicDust; i++) {
                cosmicDust.push({
                    x: random(-spaceSize*1.5, spaceSize*1.5),
                    y: random(-spaceSize*1.5, spaceSize*1.5),
                    z: random(-spaceSize*1.5, spaceSize*1.5),
                    vx: random(-0.1, 0.1),
                    vy: random(-0.1, 0.1),
                    vz: random(-0.1, 0.1),
                    size: random(0.5, 2),
                    opacity: random(0.1, 0.6)
                });
            }
        }
        
        function initMechHelmet3D() {
            mechHelmet.x = 0;
            mechHelmet.y = 0;
            mechHelmet.z = 0;
            mechHelmet.rotation = 0;
            mechHelmet.energyLevel = 0;
            mechHelmet.visorGlow = 0;
            mechHelmet.energyParticles = [];
        }
        
        function updateCamera3D() {
            if (camera3D.autoRotate) {
                camera3D.rotationY += camera3D.speed;
                camera3D.rotationX = sin(millis() * 0.0008) * 0.15;
                camera3D.z = 500 + sin(millis() * 0.0005) * 200;
            }
            
            // 鼠标交互相机
            if (mouseX > 0 && mouseX < width && mouseY > 0 && mouseY < height) {
                let targetRotY = map(mouseX, 0, width, -PI/3, PI/3);
                let targetRotX = map(mouseY, 0, height, -PI/4, PI/4);
                camera3D.rotationY = lerp(camera3D.rotationY, targetRotY, 0.02);
                camera3D.rotationX = lerp(camera3D.rotationX, targetRotX, 0.02);
                camera3D.autoRotate = false;
            } else {
                camera3D.autoRotate = true;
            }
            
            // 应用相机变换
            rotateX(camera3D.rotationX);
            rotateY(camera3D.rotationY);
            translate(camera3D.x, camera3D.y, camera3D.z);
        }
        
        function drawNebulaClouds3D() {
            for (let cloud of nebulaClouds) {
                cloud.x += cloud.drift.x;
                cloud.y += cloud.drift.y;
                cloud.z += cloud.drift.z;
                
                push();
                translate(cloud.x, cloud.y, cloud.z);
                
                fill(cloud.color[0], cloud.color[1], cloud.color[2], cloud.density * 30);
                noStroke();
                
                // 多层云效果
                for (let i = 0; i < 3; i++) {
                    let layerSize = cloud.size * (1 - i * 0.2);
                    let layerOpacity = cloud.density * (50 - i * 15);
                    fill(cloud.color[0], cloud.color[1], cloud.color[2], layerOpacity);
                    sphere(layerSize);
                }
                
                pop();
            }
        }
        
        function drawCosmicDust3D() {
            for (let dust of cosmicDust) {
                dust.x += dust.vx;
                dust.y += dust.vy;
                dust.z += dust.vz;
                
                // 边界检测
                if (dust.x > spaceSize*1.5) dust.x = -spaceSize*1.5;
                if (dust.x < -spaceSize*1.5) dust.x = spaceSize*1.5;
                if (dust.y > spaceSize*1.5) dust.y = -spaceSize*1.5;
                if (dust.y < -spaceSize*1.5) dust.y = spaceSize*1.5;
                if (dust.z > spaceSize*1.5) dust.z = -spaceSize*1.5;
                if (dust.z < -spaceSize*1.5) dust.z = spaceSize*1.5;
                
                push();
                translate(dust.x, dust.y, dust.z);
                fill(200, 200, 255, dust.opacity * 255);
                noStroke();
                sphere(dust.size);
                pop();
            }
        }
        
        function updateStars3D() {
            for (let star of stars) {
                // 更新位置
                star.x += star.vx;
                star.y += star.vy;
                star.z += star.vz;
                
                // 边界检测 - 平滑过渡
                if (star.x > spaceSize) star.x = -spaceSize;
                if (star.x < -spaceSize) star.x = spaceSize;
                if (star.y > spaceSize) star.y = -spaceSize;
                if (star.y < -spaceSize) star.y = spaceSize;
                if (star.z > spaceSize) star.z = -spaceSize;
                if (star.z < -spaceSize) star.z = spaceSize;
                
                // 更新尾迹
                star.trail.push({x: star.x, y: star.y, z: star.z});
                if (star.trail.length > 5) star.trail.shift();
                
                // 群体行为
                applyBoids3D(star);
                
                // 更新脉动和闪烁效果 - 更缓慢的变化
                star.brightness = 0.6 + 0.4 * sin(millis() * star.pulsate + star.pulseOffset);
                if (star.type === 'pulsar') {
                    star.brightness = 0.4 + 0.6 * sin(millis() * star.pulsate * 2 + star.pulseOffset);
                }
                
                // 双星系统特殊效果
                if (star.type === 'binary') {
                    star.brightness = 0.6 + 0.4 * sin(millis() * star.pulsate + star.pulseOffset);
                }
            }
        }
        
        function applyBoids3D(star) {
            let sep = separate3D(star);
            let align = align3D(star);
            let cohesion = cohesion3D(star);
            let wander = wander3D(star);
            
            // 应用力
            star.vx += sep.x * 1.2 + align.x * 0.3 + cohesion.x * 0.2 + wander.x * 0.5;
            star.vy += sep.y * 1.2 + align.y * 0.3 + cohesion.y * 0.2 + wander.y * 0.5;
            star.vz += sep.z * 1.2 + align.z * 0.3 + cohesion.z * 0.2 + wander.z * 0.5;
            
            // 限制速度
            let speed = sqrt(star.vx*star.vx + star.vy*star.vy + star.vz*star.vz);
            if (speed > star.maxSpeed) {
                star.vx = (star.vx / speed) * star.maxSpeed;
                star.vy = (star.vy / speed) * star.maxSpeed;
                star.vz = (star.vz / speed) * star.maxSpeed;
            }
        }
        
        function separate3D(star) {
            let desiredSeparation = 60;
            let steer = {x: 0, y: 0, z: 0};
            let count = 0;
            
            for (let other of stars) {
                if (other === star) continue;
                let d = dist3D(star, other);
                if (d > 0 && d < desiredSeparation) {
                    let diff = {
                        x: star.x - other.x,
                        y: star.y - other.y,
                        z: star.z - other.z
                    };
                    let len = sqrt(diff.x*diff.x + diff.y*diff.y + diff.z*diff.z);
                    if (len > 0) {
                        diff.x /= len;
                        diff.y /= len;
                        diff.z /= len;
                        diff.x /= d;
                        diff.y /= d;
                        diff.z /= d;
                        steer.x += diff.x;
                        steer.y += diff.y;
                        steer.z += diff.z;
                        count++;
                    }
                }
            }
            
            if (count > 0) {
                steer.x /= count;
                steer.y /= count;
                steer.z /= count;
            }
            return steer;
        }
        
        function align3D(star) {
            let neighborDist = 100;
            let sum = {x: 0, y: 0, z: 0};
            let count = 0;
            
            for (let other of stars) {
                if (other === star) continue;
                let d = dist3D(star, other);
                if (d > 0 && d < neighborDist) {
                    sum.x += other.vx;
                    sum.y += other.vy;
                    sum.z += other.vz;
                    count++;
                }
            }
            
            if (count > 0) {
                sum.x /= count;
                sum.y /= count;
                sum.z /= count;
                return {x: sum.x * 0.1, y: sum.y * 0.1, z: sum.z * 0.1};
            }
            return {x: 0, y: 0, z: 0};
        }
        
        function cohesion3D(star) {
            let neighborDist = 100;
            let sum = {x: 0, y: 0, z: 0};
            let count = 0;
            
            for (let other of stars) {
                if (other === star) continue;
                let d = dist3D(star, other);
                if (d > 0 && d < neighborDist) {
                    sum.x += other.x;
                    sum.y += other.y;
                    sum.z += other.z;
                    count++;
                }
            }
            
            if (count > 0) {
                sum.x /= count;
                sum.y /= count;
                sum.z /= count;
                return {
                    x: (sum.x - star.x) * 0.005,
                    y: (sum.y - star.y) * 0.005,
                    z: (sum.z - star.z) * 0.005
                };
            }
            return {x: 0, y: 0, z: 0};
        }
        
        function wander3D(star) {
            return {
                x: random(-0.01, 0.01),
                y: random(-0.01, 0.01),
                z: random(-0.01, 0.01)
            };
        }
        
        function updateComets3D() {
            for (let comet of comets) {
                // 更新位置
                comet.x += comet.vx;
                comet.y += comet.vy;
                comet.z += comet.vz;
                
                // 边界检测
                if (comet.x > spaceSize/2) comet.x = -spaceSize/2;
                if (comet.x < -spaceSize/2) comet.x = spaceSize/2;
                if (comet.y > spaceSize/2) comet.y = -spaceSize/2;
                if (comet.y < -spaceSize/2) comet.y = spaceSize/2;
                if (comet.z > spaceSize/2) comet.z = -spaceSize/2;
                if (comet.z < -spaceSize/2) comet.z = spaceSize/2;
                
                // 更新旋转
                comet.rotation += comet.rotationSpeed;
                
                // 添加尾迹粒子
                if (frameCount % 2 === 0) {
                    comet.particles.push({
                        x: comet.x,
                        y: comet.y,
                        z: comet.z,
                        life: 255,
                        size: random(2, 5)
                    });
                }
                
                // 更新粒子
                for (let i = comet.particles.length - 1; i >= 0; i--) {
                    let particle = comet.particles[i];
                    particle.life -= 5;
                    particle.size *= 0.95;
                    if (particle.life <= 0) {
                        comet.particles.splice(i, 1);
                    }
                }
            }
        }

        function updateAsteroids3D() {
            for (let asteroid of asteroids) {
                // 更新位置
                asteroid.x += asteroid.vx;
                asteroid.y += asteroid.vy;
                asteroid.z += asteroid.vz;
                
                // 边界检测
                if (asteroid.x > spaceSize/2) asteroid.x = -spaceSize/2;
                if (asteroid.x < -spaceSize/2) asteroid.x = spaceSize/2;
                if (asteroid.y > spaceSize/2) asteroid.y = -spaceSize/2;
                if (asteroid.y < -spaceSize/2) asteroid.y = spaceSize/2;
                if (asteroid.z > spaceSize/2) asteroid.z = -spaceSize/2;
                if (asteroid.z < -spaceSize/2) asteroid.z = spaceSize/2;
                
                // 更新旋转
                asteroid.rotation.x += asteroid.rotationSpeed.x;
                asteroid.rotation.y += asteroid.rotationSpeed.y;
                asteroid.rotation.z += asteroid.rotationSpeed.z;
            }
        }

        function updateBlackHoles3D() {
            for (let blackHole of blackHoles) {
                // 更新吸积盘旋转
                blackHole.accretionDisk.rotation += blackHole.accretionDisk.rotationSpeed;
                
                // 添加粒子
                if (frameCount % 2 === 0) {
                    let angle = random(TWO_PI);
                    let distance = random(blackHole.size, blackHole.accretionDisk.size);
                    blackHole.particles.push({
                        x: blackHole.x + cos(angle) * distance,
                        y: blackHole.y + sin(angle) * distance,
                        z: blackHole.z,
                        angle: angle,
                        distance: distance,
                        life: 255,
                        size: random(2, 4)
                    });
                }
                
                // 更新粒子
                for (let i = blackHole.particles.length - 1; i >= 0; i--) {
                    let particle = blackHole.particles[i];
                    particle.angle += 0.02;
                    particle.distance *= 0.99;
                    particle.life -= 2;
                    particle.size *= 0.98;
                    
                    particle.x = blackHole.x + cos(particle.angle) * particle.distance;
                    particle.y = blackHole.y + sin(particle.angle) * particle.distance;
                    
                    if (particle.life <= 0 || particle.distance < blackHole.size) {
                        blackHole.particles.splice(i, 1);
                    }
                }
            }
        }
        
        function drawStars3D() {
            for (let star of stars) {
                push();
                
                // 绘制尾迹
                if (star.trail.length > 1) {
                    noFill();
                    stroke(star.color[0], star.color[1], star.color[2], 30);
                    strokeWeight(0.5);
                    beginShape();
                    for (let pos of star.trail) {
                        vertex(pos.x, pos.y, pos.z);
                    }
                    endShape();
                }
                
                translate(star.x, star.y, star.z);
                
                // 星星主体
                fill(star.color[0], star.color[1], star.color[2], star.brightness * 255);
                noStroke();
                
                // 根据距离调整大小
                let distToCamera = sqrt(star.x*star.x + star.y*star.y + star.z*star.z);
                let scaleFactor = map(distToCamera, 0, spaceSize*2, 1.5, 0.3);
                scaleFactor = constrain(scaleFactor, 0.2, 2);
                
                // 发光效果 - 增强发光
                if (star.glow > 0) {
                    fill(star.color[0], star.color[1], star.color[2], star.brightness * star.glow * 150);
                    sphere(star.size * scaleFactor * 2.5);
                }
                
                sphere(star.size * scaleFactor);
                
                // 特殊星体效果
                if (star.type === 'giant') {
                    // 红巨星光环
                    fill(255, 150, 150, star.brightness * 40);
                    sphere(star.size * scaleFactor * 3.5);
                } else if (star.type === 'pulsar') {
                    // 脉冲星射线
                    stroke(150, 255, 255, star.brightness * 150);
                    strokeWeight(1);
                    line(0, -star.size*10, 0, 0, star.size*10, 0);
                    line(-star.size*10, 0, 0, star.size*10, 0, 0);
                } else if (star.type === 'binary') {
                    // 双星系统
                    push();
                    rotateY(millis() * 0.001);
                    translate(star.size * 2, 0, 0);
                    sphere(star.size * scaleFactor * 0.8);
                    pop();
                }
                
                pop();
            }
        }
        
        function drawConnections3D() {
            for (let i = 0; i < stars.length; i++) {
                if (random() > 0.03) continue; // 减少连接线密度
                
                for (let j = i + 1; j < stars.length; j++) {
                    let d = dist3D(stars[i], stars[j]);
                    if (d < connectionDistance) {
                        let alpha = map(d, 0, connectionDistance, 80, 0);
                        stroke(200, 220, 255, alpha);
                        strokeWeight(0.3);
                        line(stars[i].x, stars[i].y, stars[i].z,
                             stars[j].x, stars[j].y, stars[j].z);
                    }
                }
            }
        }
        
        function drawComets3D() {
            for (let comet of comets) {
                push();
                translate(comet.x, comet.y, comet.z);
                rotateY(comet.rotation);
                
                // 绘制彗星尾迹
                for (let particle of comet.particles) {
                    push();
                    translate(particle.x - comet.x, particle.y - comet.y, particle.z - comet.z);
                    fill(comet.color[0], comet.color[1], comet.color[2], particle.life);
                    noStroke();
                    sphere(particle.size);
                    pop();
                }
                
                // 绘制彗星核心
                fill(255, 255, 255, 200);
                noStroke();
                sphere(comet.size);
                
                // 绘制彗星光环
                push();
                noFill();
                stroke(comet.color[0], comet.color[1], comet.color[2], 100);
                strokeWeight(2);
                sphere(comet.size * 1.2);
                pop();
                
                pop();
            }
        }

        function drawAsteroids3D() {
            for (let asteroid of asteroids) {
                push();
                translate(asteroid.x, asteroid.y, asteroid.z);
                rotateX(asteroid.rotation.x);
                rotateY(asteroid.rotation.y);
                rotateZ(asteroid.rotation.z);
                
                // 绘制小行星
                fill(asteroid.color[0], asteroid.color[1], asteroid.color[2]);
                stroke(150, 150, 150, 50);
                strokeWeight(0.5);
                
                // 使用不规则形状
                beginShape();
                for (let i = 0; i < 8; i++) {
                    let angle = i * TWO_PI / 8;
                    let r = asteroid.size * (0.8 + random(0.4));
                    let x = cos(angle) * r;
                    let y = sin(angle) * r;
                    vertex(x, y, 0);
                }
                endShape(CLOSE);
                
                pop();
            }
        }

        function drawBlackHoles3D() {
            for (let blackHole of blackHoles) {
                push();
                translate(blackHole.x, blackHole.y, blackHole.z);
                
                // 绘制黑洞核心
                fill(0);
                noStroke();
                sphere(blackHole.size);
                
                // 绘制吸积盘
                push();
                rotateX(PI/2);
                rotateZ(blackHole.accretionDisk.rotation);
                noFill();
                stroke(255, 100, 100, 100);
                strokeWeight(2);
                ellipse(0, 0, blackHole.accretionDisk.size * 2);
                pop();
                
                // 绘制粒子
                for (let particle of blackHole.particles) {
                    push();
                    translate(particle.x - blackHole.x, particle.y - blackHole.y, particle.z - blackHole.z);
                    fill(255, 100, 100, particle.life);
                    noStroke();
                    sphere(particle.size);
                    pop();
                }
                
                // 绘制引力场效果
                push();
                noFill();
                stroke(100, 100, 255, 30);
                strokeWeight(1);
                sphere(blackHole.size * 1.5);
                pop();
                
                pop();
            }
        }
        
        function updateMechHelmet3D() {
            // 更新头盔旋转
            mechHelmet.rotation += mechHelmet.rotationSpeed;
            
            // 更新能量水平
            mechHelmet.energyLevel = 0.5 + 0.5 * sin(millis() * 0.001);
            mechHelmet.visorGlow = 0.7 + 0.3 * sin(millis() * 0.002);
            
            // 更新能量粒子
            if (frameCount % 2 === 0) {
                let angle = random(TWO_PI);
                let radius = mechHelmet.scale * 0.8;
                mechHelmet.energyParticles.push({
                    x: cos(angle) * radius,
                    y: sin(angle) * radius,
                    z: 0,
                    life: 255,
                    size: random(2, 4)
                });
            }
            
            // 更新粒子
            for (let i = mechHelmet.energyParticles.length - 1; i >= 0; i--) {
                let particle = mechHelmet.energyParticles[i];
                particle.life -= 5;
                particle.size *= 0.95;
                if (particle.life <= 0) {
                    mechHelmet.energyParticles.splice(i, 1);
                }
            }
        }

        function drawMechHelmet3D() {
            push();
            translate(mechHelmet.x, mechHelmet.y, mechHelmet.z);
            rotateY(mechHelmet.rotation);
            
            // 绘制能量光环
            push();
            noFill();
            stroke(mechHelmet.details.energy.color[0], 
                   mechHelmet.details.energy.color[1], 
                   mechHelmet.details.energy.color[2], 
                   mechHelmet.details.energy.alpha * mechHelmet.energyLevel);
            strokeWeight(2);
            sphere(mechHelmet.scale * 1.1);
            pop();
            
            // 绘制头盔主体
            push();
            // 头盔外壳
            fill(mechHelmet.details.metal.color[0], 
                 mechHelmet.details.metal.color[1], 
                 mechHelmet.details.metal.color[2], 
                 mechHelmet.details.metal.alpha);
            stroke(200, 200, 200, 100);
            strokeWeight(1);
            
            // 头盔主体形状
            push();
            scale(1, 1.2, 1.2);
            sphere(mechHelmet.scale);
            pop();
            
            // 头盔顶部
            push();
            translate(0, -mechHelmet.scale * 0.3, 0);
            scale(0.8, 0.4, 0.8);
            sphere(mechHelmet.scale);
            pop();
            
            // 头盔后部
            push();
            translate(0, 0, -mechHelmet.scale * 0.4);
            scale(1, 1.2, 0.6);
            sphere(mechHelmet.scale * 0.8);
            pop();
            
            // 面甲
            push();
            translate(0, 0, mechHelmet.scale * 0.5);
            scale(0.9, 0.7, 0.1);
            fill(mechHelmet.details.visor.color[0], 
                 mechHelmet.details.visor.color[1], 
                 mechHelmet.details.visor.color[2], 
                 mechHelmet.details.visor.alpha * mechHelmet.visorGlow);
            noStroke();
            sphere(mechHelmet.scale);
            pop();
            
            // 能量纹路
            push();
            noFill();
            stroke(mechHelmet.details.energy.color[0], 
                   mechHelmet.details.energy.color[1], 
                   mechHelmet.details.energy.color[2], 
                   mechHelmet.details.energy.alpha * mechHelmet.energyLevel);
            strokeWeight(2);
            
            // 顶部能量纹路
            for (let i = 0; i < 3; i++) {
                push();
                rotateY(i * PI / 3);
                beginShape();
                for (let angle = 0; angle < PI; angle += 0.1) {
                    let x = cos(angle) * mechHelmet.scale * 0.8;
                    let y = sin(angle) * mechHelmet.scale * 0.8;
                    vertex(x, y, 0);
                }
                endShape();
                pop();
            }
            
            // 侧面能量纹路
            for (let i = 0; i < 4; i++) {
                push();
                rotateY(i * PI / 2);
                beginShape();
                for (let angle = -PI/2; angle < PI/2; angle += 0.1) {
                    let x = cos(angle) * mechHelmet.scale * 0.9;
                    let z = sin(angle) * mechHelmet.scale * 0.9;
                    vertex(x, 0, z);
                }
                endShape();
                pop();
            }
            pop();
            
            // 绘制能量粒子
            for (let particle of mechHelmet.energyParticles) {
                push();
                translate(particle.x, particle.y, particle.z);
                fill(mechHelmet.details.energy.color[0], 
                     mechHelmet.details.energy.color[1], 
                     mechHelmet.details.energy.color[2], 
                     particle.life);
                noStroke();
                sphere(particle.size);
                pop();
            }
            
            pop();
            pop();
        }
        
        function dist3D(a, b) {
            return sqrt((a.x - b.x) * (a.x - b.x) + 
                       (a.y - b.y) * (a.y - b.y) + 
                       (a.z - b.z) * (a.z - b.z));
        }
        
        function windowResized() {
            resizeCanvas(windowWidth, windowHeight);
        }
        
        function mouseMoved() {
            mousePos.x = mouseX;
            mousePos.y = mouseY;
        }
        
        // 键盘控制相机
        function keyPressed() {
            switch(key) {
                case 'w':
                case 'W':
                    camera3D.z += 100;
                    break;
                case 's':
                case 'S':
                    camera3D.z -= 100;
                    break;
                case 'a':
                case 'A':
                    camera3D.x += 100;
                    break;
                case 'd':
                case 'D':
                    camera3D.x -= 100;
                    break;
                case 'q':
                case 'Q':
                    camera3D.y += 100;
                    break;
                case 'e':
                case 'E':
                    camera3D.y -= 100;
                    break;
                case 'r':
                case 'R':
                    // 重置相机
                    camera3D.x = 0;
                    camera3D.y = 0;
                    camera3D.z = 500;
                    camera3D.rotationX = 0;
                    camera3D.rotationY = 0;
                    camera3D.autoRotate = true;
                    break;
                case ' ':
                    // 空格键切换自动旋转
                    camera3D.autoRotate = !camera3D.autoRotate;
                    break;
            }
        }
    </script>
</body>
</html>