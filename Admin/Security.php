<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/Draggable.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #000814;
            margin: 0;
            padding: 0;
        }

        /* ----------------------------- section 1 -----------------------------  */
        #defense-perimeter {
            transition: background-color 1s ease, box-shadow 1s ease;
        }

        .glass-widget {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        /* Critical Alarm Pulse */
        .emergency-pulse {
            animation: deep-pulse 2s infinite ease-in-out;
        }

        @keyframes deep-pulse {

            0%,
            100% {
                background-color: #000814;
            }

            50% {
                background-color: rgba(225, 29, 72, 0.05);
            }
        }

        /* ----------------------------- section 2 -----------------------------  */
         /* Custom Scrollbar for Logs */
            #threat-feed-stream::-webkit-scrollbar {
                width: 0px;
            }

            .log-entry {
                border-left: 2px solid transparent;
                transition: all 0.3s ease;
            }

            .log-critical {
                background: linear-gradient(90deg, rgba(244, 63, 94, 0.1) 0%, transparent 100%);
                border-left-color: #f43f5e;
                animation: glitch-flash 0.5s infinite steps(2);
            }

            @keyframes glitch-flash {
                0% {
                    opacity: 1;
                    transform: translateX(0);
                }

                50% {
                    opacity: 0.8;
                    transform: translateX(1px);
                    color: #fff;
                }

                100% {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

        /* ----------------------------- section 3 -----------------------------  */

        /* ----------------------------- section 4 -----------------------------  */

        /* ----------------------------- section 5 -----------------------------  */

        /* ----------------------------- section 6 -----------------------------  */
    </style>
</head>

<body>
    <!-- ----------------------------- sidebar -----------------------------  -->
    <?php include "Sidebar.php" ?>
    <main class="transition-all duration-300 ml-0 lg:ml-[250px] min-h-screen overflow-x-hidden" id="main-content">
        <!-- ----------------------------- section 1 -----------------------------  -->
        <header id="defense-perimeter" class="relative min-h-[600px] w-full overflow-hidden bg-[#000814] p-6 md:p-10 flex flex-col justify-center border-b border-white/5">
            <canvas id="matrix-rain" class="absolute inset-0 opacity-0 transition-opacity duration-1000 pointer-events-none"></canvas>

            <div class="relative z-10 max-w-7xl mx-auto w-full grid grid-cols-1 lg:grid-cols-4 gap-8 items-center">

                <div class="glass-widget order-2 lg:order-1 p-6 rounded-[2rem] border border-white/10 bg-white/[0.02] backdrop-blur-xl group hover:border-rose-500/50 transition-all duration-500">
                    <div class="flex items-center gap-3 mb-4">
                        <i class="ri-error-warning-fill text-rose-500 animate-pulse"></i>
                        <span class="text-[10px] text-white/40 uppercase font-black tracking-[2px]">Threat Intelligence</span>
                    </div>
                    <div class="mb-6">
                        <h4 class="text-[10px] text-rose-500/50 uppercase font-bold">Threat Level</h4>
                        <p class="text-3xl font-['JetBrains_Mono'] text-rose-500 uppercase tracking-tighter">Elevated</p>
                    </div>
                    <div class="h-20 w-full">
                        <canvas id="threat-waveform" class="w-full h-full"></canvas>
                    </div>
                </div>

                <div class="lg:col-span-2 order-1 lg:order-2 flex flex-col items-center justify-center relative">
                    <div id="radar-container" class="relative w-[300px] h-[300px] md:w-[450px] md:h-[450px] flex items-center justify-center">
                        <canvas id="radar-canvas" class="absolute inset-0 w-full h-full"></canvas>

                        <div class="relative z-20 text-center">
                            <span class="text-[10px] text-blue-400/50 uppercase font-black tracking-[4px]">System Health</span>
                            <div id="health-score" class="text-7xl md:text-8xl font-['JetBrains_Mono'] text-blue-400 font-bold">94</div>
                            <div class="mt-2 flex items-center justify-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-blue-400 animate-ping"></div>
                                <span class="text-[10px] text-blue-400 font-bold uppercase">Integrity Verified</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="glass-widget order-3 p-6 rounded-[2rem] border border-white/10 bg-white/[0.02] backdrop-blur-xl hover:border-blue-400/50 transition-all duration-500">
                    <div class="flex items-center gap-3 mb-6">
                        <i class="ri-shield-user-line text-blue-400"></i>
                        <span class="text-[10px] text-white/40 uppercase font-black tracking-[2px]">Active Guardians</span>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-2 rounded-full bg-blue-400 shadow-[0_0_8px_#60a5fa]"></div>
                                <span class="text-xs text-white/80 font-['JetBrains_Mono']">Admin_Vinh_X</span>
                            </div>
                            <span class="text-[9px] text-white/20 uppercase font-bold">Main Console</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-2 rounded-full bg-blue-400 shadow-[0_0_8px_#60a5fa]"></div>
                                <span class="text-xs text-white/80 font-['JetBrains_Mono']">Bot_Guardian_02</span>
                            </div>
                            <span class="text-[9px] text-white/20 uppercase font-bold">Node Tokyo</span>
                        </div>
                    </div>
                    <div class="mt-8 pt-6 border-t border-white/5">
                        <p class="text-[9px] text-white/30 uppercase font-bold mb-1">Active Sessions</p>
                        <p class="text-xl font-['JetBrains_Mono'] text-white">08 <span class="text-[10px] text-blue-400/50">/ 12</span></p>
                    </div>
                </div>
            </div>

            <div class="absolute bottom-6 left-10 right-10 flex flex-col md:flex-row justify-between items-center gap-4 opacity-40 hover:opacity-100 transition-opacity">
                <div class="flex items-center gap-6 text-[9px] font-['JetBrains_Mono'] text-white/60 uppercase tracking-widest">
                    <div class="flex items-center gap-2">
                        <i class="ri-shield-check-line text-blue-400"></i>
                        Last Malware Scan: <span class="text-white">2 Min Ago</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="ri-base-station-line text-blue-400"></i>
                        Blockchain Nodes: <span class="text-emerald-400">Synchronized</span>
                    </div>
                </div>
                <button onclick="toggleStaticMode()" class="px-4 py-1 border border-white/20 rounded-full text-[8px] text-white/40 hover:bg-white/10 transition-all font-black uppercase tracking-widest">
                    Static Mode: OFF
                </button>
            </div>
        </header>

        <!-- ----------------------------- section 2 -----------------------------  -->
        <section id="neural-firewall" class="py-10 px-4 md:px-10 mb-20">
            <div class="grid grid-cols-1 xl:grid-cols-10 gap-6 h-[700px]">

                <div class="xl:col-span-7 bg-black/40 border border-white/5 rounded-[2.5rem] relative overflow-hidden group">
                    <div class="absolute top-8 left-8 z-20">
                        <h3 class="text-xl font-bold text-white tracking-tighter flex items-center gap-3">
                            <span class="w-2 h-2 rounded-full bg-blue-500 animate-ping"></span>
                            Live Attack Surface
                        </h3>
                        <p class="text-[9px] text-white/30 uppercase tracking-[3px] mt-1 font-['JetBrains_Mono']">Neural Firewall v4.0 Active</p>
                    </div>

                    <div class="absolute top-8 right-8 z-20 flex gap-2">
                        <button onclick="activateGeoFence()" class="p-2 bg-white/5 border border-white/10 rounded-lg text-white/60 hover:text-blue-400 hover:border-blue-400/50 transition-all shadow-xl">
                            <i class="ri-pencil-ruler-2-line"></i>
                        </button>
                        <div class="flex bg-black/60 backdrop-blur-md rounded-lg border border-white/10 p-1">
                            <button id="btn-2d" onclick="switchMapView('2d')" class="px-3 py-1 text-[10px] text-white uppercase font-bold border-r border-white/5 bg-blue-500/20 transition-all">2D</button>
                            <button id="btn-3d" onclick="switchMapView('3d')" class="px-3 py-1 text-[10px] text-white/40 hover:text-white uppercase font-bold transition-all">3D</button>
                        </div>
                    </div>

                    <div id="world-map-container" class="w-full h-full cursor-crosshair flex items-center justify-center transition-all duration-1000" style="perspective: 1200px;">
                        <canvas id="map-canvas" class="transition-transform duration-1000 ease-out"></canvas>
                    </div>



                    <div id="map-reticle" class="pointer-events-none absolute border border-blue-500/30 rounded-full w-20 h-20 -translate-x-1/2 -translate-y-1/2 hidden flex items-center justify-center">
                        <div class="w-full h-[1px] bg-blue-500/20 absolute"></div>
                        <div class="h-full w-[1px] bg-blue-500/20 absolute"></div>
                    </div>
                </div>

                <div class="xl:col-span-3 flex flex-col gap-6 h-full">
                    <div class="h-1/3 bg-white/[0.02] border border-white/5 rounded-[2rem] p-6">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-[10px] text-white/40 uppercase font-black tracking-widest">Traffic Scrubbing</span>
                            <span class="text-[10px] text-rose-500 font-mono">-14.2 GB/s</span>
                        </div>
                        <div id="scrubbing-bars" class="flex items-end gap-1 h-24">
                        </div>
                    </div>

                    <div class="flex-1 bg-black/60 border border-white/5 rounded-[2rem] p-6 overflow-hidden flex flex-col">
                        <p class="text-[10px] text-white/40 uppercase font-black tracking-widest mb-4">Neural Log Stream</p>
                        <div id="threat-feed-stream" class="flex-1 font-['JetBrains_Mono'] text-[9px] space-y-2 overflow-y-auto pr-2 scrollbar-hide">
                        </div>

                        <div class="mt-4 pt-4 border-t border-white/5">
                            <div id="blacklist-status-card" class="flex items-center justify-between p-3 bg-blue-500/5 rounded-xl border border-blue-500/20 transition-all duration-500">
                                <div>
                                    <p id="blacklist-label" class="text-[10px] text-blue-400 font-bold uppercase">Auto-Blacklist: ACTIVE</p>
                                    <p id="blacklist-count" class="text-[8px] text-white/20">0 IP currently blocked</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" id="auto-blacklist-toggle" onchange="toggleAutoBlacklist(this)" class="sr-only peer">
                                    <div class="w-8 h-4 bg-white/10 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-3 after:w-3 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ----------------------------- section 3 -----------------------------  -->

        <!-- ----------------------------- section 4 -----------------------------  -->

        <!-- ----------------------------- section 5 -----------------------------  -->

        <!-- ----------------------------- section 6 -----------------------------  -->
    </main>
</body>
<script>
    // ----------------------------- section 1 ----------------------------- //
    document.addEventListener('DOMContentLoaded', () => {
        // 1. Radar Canvas Animation (The Eternal Scan)
        const canvas = document.getElementById('radar-canvas');
        const ctx = canvas.getContext('2d');
        let angle = 0;
        let isStatic = false;

        function resize() {
            canvas.width = canvas.parentElement.offsetWidth;
            canvas.height = canvas.parentElement.offsetHeight;
        }
        window.addEventListener('resize', resize);
        resize();

        function drawRadar() {
            if (isStatic) return;
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            const centerX = canvas.width / 2;
            const centerY = canvas.height / 2;
            const radius = Math.min(centerX, centerY) - 10;

            // Vẽ các vòng tròn đồng tâm
            ctx.strokeStyle = 'rgba(96, 165, 250, 0.1)';
            ctx.lineWidth = 1;
            for (let i = 1; i <= 3; i++) {
                ctx.beginPath();
                ctx.arc(centerX, centerY, (radius / 3) * i, 0, Math.PI * 2);
                ctx.stroke();
            }

            // Tia quét Radar (Fan shape)
            const gradient = ctx.createRadialGradient(centerX, centerY, 0, centerX, centerY, radius);
            gradient.addColorStop(0, 'rgba(96, 165, 250, 0)');
            gradient.addColorStop(1, 'rgba(96, 165, 250, 0.2)');

            ctx.save();
            ctx.translate(centerX, centerY);
            ctx.rotate(angle);
            ctx.beginPath();
            ctx.moveTo(0, 0);
            ctx.arc(0, 0, radius, -0.2, 0);
            ctx.lineTo(0, 0);
            ctx.fillStyle = gradient;
            ctx.fill();
            ctx.restore();

            angle += 0.02;
            requestAnimationFrame(drawRadar);
        }
        drawRadar();

        // 2. Parallax Effect (3D Depth)
        document.addEventListener('mousemove', (e) => {
            if (window.innerWidth < 1024) return;
            const moveX = (e.clientX - window.innerWidth / 2) / 50;
            const moveY = (e.clientY - window.innerHeight / 2) / 50;

            gsap.to('.glass-widget', {
                x: moveX,
                y: moveY,
                duration: 1,
                ease: "power2.out"
            });
            gsap.to('#radar-container', {
                x: -moveX * 0.5,
                y: -moveY * 0.5,
                duration: 1,
                ease: "power2.out"
            });
        });

        // 3. Data Rain (Matrix effect on Hover)
        const header = document.getElementById('defense-perimeter');
        const matrixCanvas = document.getElementById('matrix-rain');
        header.addEventListener('mouseenter', () => gsap.to(matrixCanvas, {
            opacity: 0.1,
            duration: 1
        }));
        header.addEventListener('mouseleave', () => gsap.to(matrixCanvas, {
            opacity: 0,
            duration: 1
        }));

        // 4. Audio Alert Simulation
        window.triggerSecurityAlert = function(level) {
            if (level === 'critical') {
                header.classList.add('emergency-pulse');
                // Sound logic: window.audioContext.beep()...
                if (window.navigator.vibrate) window.navigator.vibrate([200, 100, 200]);
            }
        }
    });

    function toggleStaticMode() {
        // Logic tắt hiệu ứng chuyển động để tiết kiệm tài nguyên
        alert("Static Mode Activated: Motion elements paused.");
    }

    // ----------------------------- section 2 ----------------------------- //
    // ----------------------------- SECTION 2: NEURAL FIREWALL ----------------------------- //
    let isAutoBlacklistEnabled = true;
    let blockedIPCount = 0;
    const blockedLocations = [];
    let currentView = '2d';

    document.addEventListener('DOMContentLoaded', () => {
        // --- Radar ---
        const radarCanvas = document.getElementById('radar-canvas');
        const rCtx = radarCanvas.getContext('2d');
        let angle = 0;

        function resizeRadar() {
            radarCanvas.width = radarCanvas.offsetWidth;
            radarCanvas.height = radarCanvas.offsetHeight;
        }
        window.addEventListener('resize', resizeRadar);
        resizeRadar();

        function drawRadar() {
            rCtx.clearRect(0, 0, radarCanvas.width, radarCanvas.height);
            const cx = radarCanvas.width / 2;
            const cy = radarCanvas.height / 2;
            const r = cx - 10;

            rCtx.strokeStyle = 'rgba(96, 165, 250, 0.1)';
            for (let i = 1; i <= 3; i++) {
                rCtx.beginPath();
                rCtx.arc(cx, cy, (r / 3) * i, 0, Math.PI * 2);
                rCtx.stroke();
            }

            rCtx.save();
            rCtx.translate(cx, cy);
            rCtx.rotate(angle);
            const grad = rCtx.createRadialGradient(0, 0, 0, 0, 0, r);
            grad.addColorStop(0, 'transparent');
            grad.addColorStop(1, 'rgba(96, 165, 250, 0.2)');
            rCtx.fillStyle = grad;
            rCtx.beginPath();
            rCtx.moveTo(0, 0);
            rCtx.arc(0, 0, r, -0.5, 0);
            rCtx.fill();
            rCtx.restore();
            angle += 0.02;
            requestAnimationFrame(drawRadar);
        }
        drawRadar();

        // --- Map & Logic ---
        const mapCanvas = document.getElementById('map-canvas');
        const mCtx = mapCanvas.getContext('2d');
        const scrubbingBars = document.getElementById('scrubbing-bars');

        function resizeMap() {
            mapCanvas.width = mapCanvas.offsetWidth;
            mapCanvas.height = mapCanvas.offsetHeight;
        }
        window.addEventListener('resize', resizeMap);
        resizeMap();

        // Khởi tạo cột scrubbing
        for (let i = 0; i < 20; i++) {
            const bar = document.createElement('div');
            bar.className = "flex-1 bg-blue-500/30 rounded-t-sm transition-all duration-500";
            bar.style.height = "50%";
            scrubbingBars.appendChild(bar);
        }

        setInterval(() => {
            scrubbingBars.querySelectorAll('div').forEach(b => b.style.height = Math.random() * 100 + "%");
            addLog(mCtx, mapCanvas);
        }, 2000);

        function render() {
            mCtx.fillStyle = 'rgba(0, 8, 20, 0.1)';
            mCtx.fillRect(0, 0, mapCanvas.width, mapCanvas.height);
            drawBlockedZones(mCtx);
            requestAnimationFrame(render);
        }
        render();

        // Reticle
        const reticle = document.getElementById('map-reticle');
        mapCanvas.addEventListener('mousemove', (e) => {
            reticle.style.left = e.offsetX + "px";
            reticle.style.top = e.offsetY + "px";
            reticle.style.display = "block";
        });
        mapCanvas.addEventListener('mouseleave', () => reticle.style.display = "none");
    });

    function addLog(ctx, canvas) {
        if (!isAutoBlacklistEnabled) return;
        const stream = document.getElementById('threat-feed-stream');
        const isCritical = Math.random() > 0.7; // Tăng tỷ lệ để dễ test
        const type = ["SQLi", "DDoS", "Brute Force"][Math.floor(Math.random() * 3)];
        const loc = "Global Node";
        const ip = `192.168.${Math.floor(Math.random()*255)}.xx`;

        // SỬA LỖI: Xác định status dựa trên isCritical và trạng thái checkbox
        const statusText = isCritical && isAutoBlacklistEnabled ? 'BLACKLISTED' : 'BLOCKED';

        const html = `
                <div class="p-2 text-[9px] border-b border-white/5 ${isCritical ? 'log-critical' : 'opacity-60'}">
                    <span class="text-blue-400">[${new Date().toLocaleTimeString()}]</span> ${type} - ${ip}
                    <br/><span class="uppercase opacity-50">${loc} -> ${statusText}</span>
                </div>`;

        stream.insertAdjacentHTML('afterbegin', html);
        if (stream.children.length > 15) stream.lastElementChild.remove();

        if (isCritical) {
            const rx = Math.random() * canvas.width;
            const ry = Math.random() * canvas.height;
            triggerAttack(ctx, canvas, rx, ry);
            if (isAutoBlacklistEnabled) processBlacklist(ip, rx, ry);
        }
    }

    function triggerAttack(ctx, canvas, x, y) {
        let p = 0;
        const tx = canvas.width / 2;
        const ty = canvas.height / 2;

        function anim() {
            p += 0.03;
            ctx.beginPath();
            ctx.strokeStyle = `rgba(244, 63, 94, ${1-p})`;
            ctx.setLineDash([5, 5]);
            ctx.moveTo(x, y);
            ctx.quadraticCurveTo((x + tx) / 2, Math.min(y, ty) - 100, tx, ty);
            ctx.stroke();
            if (p < 1) requestAnimationFrame(anim);
        }
        anim();
    }

    function processBlacklist(ip, x, y) {
        blockedIPCount++;
        document.getElementById('blacklist-count').innerText = `${blockedIPCount} IP currently blocked`;
        blockedLocations.push({
            x,
            y
        });
        if (blockedLocations.length > 20) blockedLocations.shift();
    }

    function drawBlockedZones(ctx) {
        if (!isAutoBlacklistEnabled) return;
        blockedLocations.forEach(z => {
            ctx.strokeStyle = '#f43f5e';
            ctx.setLineDash([]);
            ctx.beginPath();
            ctx.moveTo(z.x - 5, z.y - 5);
            ctx.lineTo(z.x + 5, z.y + 5);
            ctx.moveTo(z.x + 5, z.y - 5);
            ctx.lineTo(z.x - 5, z.y + 5);
            ctx.stroke();
        });
    }

    function toggleAutoBlacklist(cb) {
        isAutoBlacklistEnabled = cb.checked;
        const label = document.getElementById('blacklist-label');

        if (isAutoBlacklistEnabled) {
            label.innerText = "Auto-Blacklist: ACTIVE";
            label.className = "text-[10px] text-blue-400 font-bold";
        } else {
            label.innerText = "Auto-Blacklist: PAUSED";
            label.className = "text-[10px] text-rose-500 font-bold";
            // Tùy chọn: Xóa danh sách các điểm đã chặn trước đó khi tắt
            blockedLocations.length = 0;
        }
    }

    function switchMapView(view) {
        currentView = view;
        const canvas = document.getElementById('map-canvas');
        if (view === '3d') {
            gsap.to(canvas, {
                rotationX: 45,
                scale: 0.9,
                duration: 1
            });
            document.getElementById('btn-3d').classList.add('bg-blue-500/20');
            document.getElementById('btn-2d').classList.remove('bg-blue-500/20');
        } else {
            gsap.to(canvas, {
                rotationX: 0,
                scale: 1,
                duration: 1
            });
            document.getElementById('btn-2d').classList.add('bg-blue-500/20');
            document.getElementById('btn-3d').classList.remove('bg-blue-500/20');
        }
    }
    // ----------------------------- section 3 ----------------------------- //

    // ----------------------------- section 4 ----------------------------- //

    // ----------------------------- section 5 ----------------------------- //

    // ----------------------------- section 6 ----------------------------- //
</script>

</html>