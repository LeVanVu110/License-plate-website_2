<?php include "header.php"; ?>
<?php
$query = isset($_GET['plate']) ? htmlspecialchars($_GET['plate']) : "888.88";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discovery Matrix | <?php echo $query; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@1,300&family=Space+Mono:wght@400;700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --sapphire: #007FFF;
            --midnight: #000814;
            --ice-silver: #E2E8F0;
        }

        body {
            background-color: var(--midnight);
            color: white;
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }

        .space-mono {
            font-family: 'Space Mono', monospace;
        }

        .serif-italic {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
        }

        /* ----------------------------- section 1 -----------------------------  */
        /* Glassmorphism Card */
        .treasure-card {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.5s cubic-bezier(0.19, 1, 0.22, 1);
            opacity: 0;
            transform: translateY(30px);
        }

        /* Hover rực viền (Neon Border Draw) */
        .treasure-card:hover {
            border-color: var(--sapphire);
            box-shadow: 0 0 30px rgba(0, 127, 255, 0.2), inset 0 0 15px rgba(0, 127, 255, 0.1);
            transform: scale(1.02) translateY(-5px);
            z-index: 10;
        }

        /* Hiệu ứng mờ các thẻ xung quanh */
        .discovery-grid:hover .treasure-card:not(:hover) {
            opacity: 0.3;
            filter: blur(2px);
        }

        /* Radar Pulse Beam */
        #radar-beam {
            position: fixed;
            top: 0;
            left: 50%;
            width: 2px;
            height: 100vh;
            background: linear-gradient(to bottom, transparent, var(--sapphire), transparent);
            box-shadow: 0 0 50px 10px var(--sapphire);
            z-index: 100;
            pointer-events: none;
            visibility: hidden;
        }

        /* Plate Embossed Text */
        .plate-num {
            text-shadow: 1px 1px 0px rgba(255, 255, 255, 0.2), -1px -1px 0px rgba(0, 0, 0, 0.5);
            letter-spacing: -1px;
        }

        /* Custom Tabs for Mobile */
        @media (max-width: 768px) {
            .vault-container {
                display: none;
            }

            .vault-container.active-tab {
                display: block;
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
    <!-- ----------------------------- section 1 -----------------------------  -->
    <div id="radar-beam"></div>

    <header class="pt-20 pb-10 text-center px-6" style="background-color: #000814;">
        <p class="serif-italic text-blue-300/60 text-xl mb-2">Tìm thấy 39 kết quả cho di sản "<?php echo $query; ?>"</p>
        <div class="h-[1px] w-24 bg-blue-500/30 mx-auto"></div>
    </header>

    <div class="flex md:hidden justify-center gap-4 p-3 px-6" style="background-color: #000814;">
        <button onclick="switchTab('auto')" id="btn-auto" class="flex-1 py-4 bg-blue-600/20 border border-blue-500/50 rounded-xl text-[10px] tracking-[3px] font-bold uppercase active-tab-btn">Ô tô (24)</button>
        <button onclick="switchTab('moto')" id="btn-moto" class="flex-1 py-4 bg-white/5 border border-white/10 rounded-xl text-[10px] tracking-[3px] font-bold uppercase">Xe máy (15)</button>
    </div>

    <main class="max-w-[1600px] mx-auto px-6 md:px-12 grid grid-cols-1 md:grid-cols-2 gap-0 md:gap-20 relative " style="background-color: #000814;">

        <div class="absolute left-1/2 top-0 w-[1px] h-full bg-gradient-to-b from-transparent via-blue-500/20 to-transparent -translate-x-1/2 hidden md:block"></div>

        <section id="auto-vault" class="vault-container active-tab pb-20">
            <h3 class="text-[10px] tracking-[5px] text-white/30 uppercase mb-10 flex items-center gap-4 p-5">
                <i class="ri-steering-2-line "></i> Auto-Vault Allocation
            </h3>
            <div class="discovery-grid grid grid-cols-1 xl:grid-cols-2 gap-6">
                <?php for ($i = 0; $i < 6; $i++): ?>
                    <div class="treasure-card p-8 rounded-2xl relative group overflow-hidden">
                        <div class="absolute -right-4 -top-0 text-blue-500/5 text-6xl font-black space-mono opacity-0 group-hover:opacity-100 transition-opacity">VƯỢNG TÀI</div>
                        <div class="flex justify-between items-start mb-8">
                            <span class="bg-blue-500/10 text-blue-400 text-[9px] px-3 py-1 rounded-full tracking-widest uppercase font-bold">Tứ Quý</span>
                            <i class="ri-bookmark-line text-white/20"></i>
                        </div>
                        <h2 class="plate-num space-mono text-4xl font-bold text-white mb-8">30K-<?php echo $query; ?></h2>
                        <div class="flex justify-end">
                            <span class="text-white/80 space-mono text-lg italic">2.450.000.000 <small class="text-[10px] text-white/40">VND</small></span>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
        </section>

        <section id="moto-vault" class="vault-container pb-20">
            <h3 class="text-[10px] tracking-[5px] text-white/30 uppercase mb-10 flex items-center gap-4 p-5">
                <i class="ri-motorbike-line"></i> Moto-Vault Allocation
            </h3>
            <div class="discovery-grid grid grid-cols-1 xl:grid-cols-2 gap-6">
                <?php for ($i = 0; $i < 6; $i++): ?>
                    <div class="treasure-card p-8 rounded-2xl relative group overflow-hidden">
                        <div class="absolute -right-0 -top-0 text-cyan-500/5 text-6xl font-black space-mono opacity-0 group-hover:opacity-100 transition-opacity"
                        style="top: 15px; right: 25px;">ĐẠI CÁT</div>
                        <div class="flex justify-between items-start mb-8">
                            <span class="bg-cyan-500/10 text-cyan-400 text-[9px] px-3 py-1 rounded-full tracking-widest uppercase font-bold">Lộc Phát</span>
                            <i class="ri-bookmark-line text-white/20"></i>
                        </div>
                        <h2 class="plate-num space-mono text-3xl font-bold text-white mb-8 text-center">29-G1<br><?php echo $query; ?></h2>
                        <div class="flex justify-end">
                            <span class="text-white/80 space-mono text-lg italic">450.000.000 <small class="text-[10px] text-white/40">VND</small></span>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
        </section>
    </main>

    <!-- ----------------------------- section 2 -----------------------------  -->

    <!-- ----------------------------- section 3 -----------------------------  -->

    <!-- ----------------------------- section 4 -----------------------------  -->

    <!-- ----------------------------- section 5 -----------------------------  -->

    <!-- ----------------------------- section 6 -----------------------------  -->

    <?php include "footer.php"; ?>
</body>
<script>
    // ----------------------------- section 1 ----------------------------- //
    // 1. Hiệu ứng Radar Pulse & Staggered Entrance
    window.addEventListener('load', () => {
        const beam = document.getElementById('radar-beam');

        const tl = gsap.timeline();

        // Hiệu ứng tia sáng quét
        tl.set(beam, {
                visibility: 'visible'
            })
            .to(beam, {
                x: "-50vw",
                duration: 1,
                ease: "power2.inOut"
            })
            .to(beam, {
                x: "50vw",
                duration: 1.5,
                ease: "power2.inOut"
            }, "-=0.5")
            .to(beam, {
                opacity: 0,
                duration: 0.5
            });

        // Hiệu ứng hiện thẻ tuần tự
        gsap.to(".treasure-card", {
            opacity: 1,
            y: 0,
            duration: 1,
            stagger: 0.1,
            ease: "expo.out",
            delay: 0.5
        });
    });

    // 2. Mobile Tab Switching
    function switchTab(type) {
        const autoVault = document.getElementById('auto-vault');
        const motoVault = document.getElementById('moto-vault');
        const btnAuto = document.getElementById('btn-auto');
        const btnMoto = document.getElementById('btn-moto');

        if (type === 'auto') {
            autoVault.classList.add('active-tab');
            motoVault.classList.remove('active-tab');
            btnAuto.classList.add('bg-blue-600/20', 'border-blue-500/50');
            btnMoto.classList.remove('bg-blue-600/20', 'border-blue-500/50');
        } else {
            motoVault.classList.add('active-tab');
            autoVault.classList.remove('active-tab');
            btnMoto.classList.add('bg-blue-600/20', 'border-blue-500/50');
            btnAuto.classList.remove('bg-blue-600/20', 'border-blue-500/50');
        }

        // Re-run animation cho tab mới
        gsap.from(".active-tab .treasure-card", {
            opacity: 0,
            x: type === 'auto' ? -20 : 20,
            stagger: 0.05,
            duration: 0.5
        });
    }

    // ----------------------------- section 2 ----------------------------- //

    // ----------------------------- section 3 ----------------------------- //

    // ----------------------------- section 4 ----------------------------- //

    // ----------------------------- section 5 ----------------------------- //

    // ----------------------------- section 6 ----------------------------- //
</script>

</html>