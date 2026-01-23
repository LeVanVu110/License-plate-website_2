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

        /* ----------------------------- section 3 -----------------------------  */

        /* ----------------------------- section 4 -----------------------------  */

        /* ----------------------------- section 5 -----------------------------  */

        /* ----------------------------- section 6 -----------------------------  */
    </style>
</head>

<body>
    <!-- ----------------------------- sidebar -----------------------------  -->
    <?php include "Sidebar.php" ?>
    <main class="transition-all duration-300 ml-[250px]" id="main-content">
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

    // ----------------------------- section 3 ----------------------------- //

    // ----------------------------- section 4 ----------------------------- //

    // ----------------------------- section 5 ----------------------------- //

    // ----------------------------- section 6 ----------------------------- //
</script>

</html>