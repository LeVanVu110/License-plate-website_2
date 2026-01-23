<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>he Vault Inventory Interface</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/Draggable.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Inter:wght@400;700&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --obsidian: #050505;
            --sapphire-glow: rgba(30, 64, 175, 0.4);
            --neon-cyan: #00f2ff;
            --electric-red: #ff003c;
        }

        body {
            background-color: #000814;
            color: white;
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }

        /* ----------------------------- section 1 -----------------------------  */
        .space-mono {
            font-family: 'Space Mono', monospace;
        }

        /* Hiệu ứng Sapphire Blur mặc định */
        .glass-vault {
            background: linear-gradient(135deg, rgba(5, 5, 5, 0.9) 0%, rgba(10, 25, 47, 0.8) 100%);
            border: 1px solid var(--sapphire-glow);
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        /* Laser Scan Effect */
        .laser-scan {
            position: absolute;
            top: -100%;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, transparent, var(--neon-cyan), transparent);
            box-shadow: 0 0 15px var(--neon-cyan);
            z-index: 20;
            opacity: 0;
        }

        .glass-vault:hover .laser-scan {
            animation: scan 2s infinite;
            opacity: 1;
        }

        @keyframes scan {
            0% {
                top: -10%;
            }

            100% {
                top: 110%;
            }
        }

        /* Status Breathing */
        .breathe-cyan {
            animation: breathe 2s infinite ease-in-out;
            box-shadow: 0 0 5px var(--neon-cyan);
        }

        @keyframes breathe {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.6;
                transform: scale(0.95);
            }
        }

        /* Perspective 3D */
        .vault-card-container {
            perspective: 1000px;
        }

        /* Responsive Grid Customization */
        .inventory-grid {
            display: grid;
            gap: 1.5rem;
            grid-template-columns: repeat(1, minmax(0, 1fr));
            /* Mobile */
        }

        @media (min-width: 768px) {
            .inventory-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        /* Tablet */
        @media (min-width: 1440px) {
            .inventory-grid {
                grid-template-columns: repeat(5, minmax(0, 1fr));
            }
        }

        /* Desktop Ultra-Wide */

        /* Floating Button Mobile */
        .fab-scan {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 60px;
            height: 60px;
            background: var(--neon-cyan);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: black;
            font-size: 1.5rem;
            box-shadow: 0 0 20px rgba(0, 242, 255, 0.5);
            z-index: 100;
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
    <!-- ----------------------------- section 1 -----------------------------  -->
    <div class="flex min-h-screen">
        <aside id="sidebar" class="hidden lg:flex w-64 bg-[#020c1b] border-r border-white/5 p-6 flex-col gap-6">
            <h2 class="text-xs font-bold text-white/30 tracking-[3px] uppercase">Security Level</h2>
            <nav class="flex flex-col gap-2">
                <div class="p-3 rounded-lg bg-white/5 border border-white/10 text-sm opacity-50 cursor-grab active:cursor-grabbing">
                    <i class="ri-drag-move-2-line mr-2"></i> Northern Vault
                </div>
                <div class="p-3 rounded-lg bg-white/5 border border-white/10 text-sm opacity-50">
                    <i class="ri-drag-move-2-line mr-2"></i> Central Vault
                </div>
                <div class="p-3 rounded-lg bg-white/5 border border-white/10 text-sm opacity-50">
                    <i class="ri-drag-move-2-line mr-2"></i> Southern Vault
                </div>
            </nav>
        </aside>

        <main class="flex-1 p-4 md:p-8 lg:p-12">

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10 bg-[#0a192f]/50 p-4 rounded-2xl border border-white/5">
                <div class="flex items-center gap-4 w-full md:w-auto">
                    <div class="relative w-full md:w-80">
                        <i class="ri-qr-scan-2-line absolute left-4 top-1/2 -translate-y-1/2 text-cyan-400"></i>
                        <input type="text" placeholder="Scan Barcode or Voice Command..." class="w-full bg-black/40 border border-white/10 rounded-xl py-3 pl-12 pr-4 text-sm focus:outline-none focus:border-cyan-400 transition-all">
                    </div>
                    <button class="bg-white/5 p-3 rounded-xl hover:bg-white/10 transition-all"><i class="ri-mic-line"></i></button>
                </div>
                <div class="flex gap-3 overflow-x-auto w-full md:w-auto pb-2 md:pb-0">
                    <button class="px-4 py-2 rounded-full bg-cyan-500/20 text-cyan-400 text-xs font-bold border border-cyan-500/30 whitespace-nowrap">KHO BẮC</button>
                    <button class="px-4 py-2 rounded-full bg-white/5 text-white/40 text-xs font-bold border border-white/10 whitespace-nowrap">KHO TRUNG</button>
                    <button class="px-4 py-2 rounded-full bg-white/5 text-white/40 text-xs font-bold border border-white/10 whitespace-nowrap">KHO NAM</button>
                </div>
            </div>

            <div class="inventory-grid" id="inventory-container">
                <div class="vault-card-container">
                    <div class="glass-vault rounded-3xl p-5 group cursor-pointer" onmousemove="handleTilt(event, this)" onmouseleave="resetTilt(this)">
                        <div class="laser-scan"></div>
                        <div class="flex justify-between items-start mb-6">
                            <span class="space-mono text-[10px] text-white/40 tracking-tighter">ASSET_ID: #888-88</span>
                            <span class="px-2 py-1 rounded text-[9px] font-bold uppercase breathe-cyan bg-cyan-500/20 text-cyan-400">In Vault</span>
                        </div>
                        <div class="relative py-8 flex justify-center items-center">
                            <div class="absolute inset-0 bg-cyan-500/5 blur-3xl rounded-full group-hover:bg-cyan-500/20 transition-all"></div>
                            <div class="relative z-10 transform group-hover:scale-110 transition-transform duration-500">
                                <h3 class="space-mono text-3xl md:text-2xl font-bold tracking-widest text-white/20 group-hover:text-white transition-all shadow-glow">888.88</h3>
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-white/5 flex justify-between items-center text-[10px]">
                            <div class="flex flex-col">
                                <span class="text-white/20 uppercase">Security Tier</span>
                                <span class="text-cyan-400 font-bold">ALPHA-9</span>
                            </div>
                            <div class="text-right">
                                <span class="text-white/20 uppercase">Last Sync</span>
                                <span class="text-white/60 block">23/01/2026</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="vault-card-container">
                    <div class="glass-vault rounded-3xl p-5 group cursor-pointer" onmousemove="handleTilt(event, this)" onmouseleave="resetTilt(this)">
                        <div class="laser-scan" style="background: var(--electric-red); box-shadow: 0 0 15px var(--electric-red);"></div>
                        <div class="flex justify-between items-start mb-6">
                            <span class="space-mono text-[10px] text-white/40">ASSET_ID: #555-55</span>
                            <span class="px-2 py-1 rounded text-[9px] font-bold uppercase bg-red-500/20 text-red-500 border border-red-500/30">Mismatch</span>
                        </div>
                        <div class="relative py-8 flex justify-center items-center">
                            <div class="absolute inset-0 bg-red-500/5 blur-3xl rounded-full"></div>
                            <h3 class="space-mono text-3xl md:text-2xl font-bold tracking-widest text-white/20 group-hover:text-white">555.55</h3>
                        </div>
                        <div class="mt-6 pt-4 border-t border-white/5 flex justify-between items-center text-[10px]">
                            <div class="flex flex-col"><span class="text-white/20 uppercase">Tier</span><span class="text-red-500 font-bold">OMEGA</span></div>
                            <div class="text-right"><span class="text-white/20 uppercase">Status</span><span class="text-white/60 block">Locked</span></div>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <div class="fab-scan lg:hidden">
        <i class="ri-qr-code-line"></i>
    </div>

    <!-- ----------------------------- section 2 -----------------------------  -->

    <!-- ----------------------------- section 3 -----------------------------  -->

    <!-- ----------------------------- section 4 -----------------------------  -->

    <!-- ----------------------------- section 5 -----------------------------  -->

    <!-- ----------------------------- section 6 -----------------------------  -->

</body>
<script>
    // ----------------------------- section 1 ----------------------------- //
    // Hiệu ứng Depth Perception (Tilt Shift)
    function handleTilt(e, card) {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        const centerX = rect.width / 2;
        const centerY = rect.height / 2;

        const rotateX = (y - centerY) / 10;
        const rotateY = (centerX - x) / 10;

        gsap.to(card, {
            rotateX: rotateX,
            rotateY: rotateY,
            duration: 0.5,
            ease: "power2.out",
            transformPerspective: 1000
        });
    }

    function resetTilt(card) {
        gsap.to(card, {
            rotateX: 0,
            rotateY: 0,
            duration: 0.8,
            ease: "elastic.out(1, 0.3)"
        });
    }

    // Tích hợp Swipe Actions cho Mobile
    let touchstartX = 0;
    let touchendX = 0;

    const cards = document.querySelectorAll('.glass-vault');
    cards.forEach(card => {
        card.addEventListener('touchstart', e => {
            touchstartX = e.changedTouches[0].screenX;
        });

        card.addEventListener('touchend', e => {
            touchendX = e.changedTouches[0].screenX;
            handleSwipe(card);
        });
    });

    function handleSwipe(card) {
        if (window.innerWidth < 1024) {
            if (touchendX < touchstartX - 100) { // Swipe Left
                gsap.to(card, {
                    x: -100,
                    opacity: 0,
                    duration: 0.3,
                    onComplete: () => {
                        alert("Báo cáo sự cố đã được gửi!");
                        gsap.set(card, {
                            x: 0,
                            opacity: 1
                        });
                    }
                });
            }
            if (touchendX > touchstartX + 100) { // Swipe Right
                card.style.borderColor = "#00f2ff";
                alert("Xác nhận kiểm kê thành công!");
            }
        }
    }

    // ----------------------------- section 2 ----------------------------- //

    // ----------------------------- section 3 ----------------------------- //

    // ----------------------------- section 4 ----------------------------- //

    // ----------------------------- section 5 ----------------------------- //

    // ----------------------------- section 6 ----------------------------- //
</script>

</html>