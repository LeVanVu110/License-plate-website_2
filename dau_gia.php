<?php include "header.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* ----------------------------- section 1 -----------------------------  */
        @import url('https://fonts.cdnfonts.com/css/digital-7-mono');

        /* Arena Setup */
        .perspective-2000 {
            perspective: 2000px;
        }

        /* 3D Pedestal Construction */
        .cube-3d {
            width: 450px;
            /* Chiều rộng bệ */
            height: 180px;
            /* Chiều cao bệ */
            position: relative;
            transform-style: preserve-3d;
            transform: rotateX(-10deg) rotateY(-15deg);
            /* Góc nhìn 3D mặc định */
        }

        .cube-face {
            position: absolute;
            width: 450px;
            height: 180px;
            border: 1px solid rgba(0, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            backface-visibility: visible;
        }

        /* Định vị 6 mặt để tạo độ dày 40px */
        .cube-face.front {
            transform: rotateY(0deg) translateZ(20px);
            background: rgba(0, 26, 51, 0.4);
        }

        .cube-face.back {
            transform: rotateY(180deg) translateZ(20px);
            background: rgba(0, 10, 20, 0.8);
        }

        .cube-face.top {
            height: 40px;
            transform: rotateX(90deg) translateZ(20px);
            top: -20px;
            background: rgba(0, 255, 255, 0.1);
        }

        .cube-face.bottom {
            height: 40px;
            transform: rotateX(-90deg) translateZ(160px);
            top: -20px;
            background: rgba(0, 255, 255, 0.3);
            box-shadow: 0 0 100px rgba(0, 255, 255, 0.5);
        }

        .cube-face.left {
            width: 40px;
            transform: rotateY(-90deg) translateZ(20px);
            left: -20px;
            background: rgba(0, 255, 255, 0.1);
        }

        .cube-face.right {
            width: 40px;
            transform: rotateY(90deg) translateZ(430px);
            left: -20px;
            background: rgba(0, 255, 255, 0.1);
        }

        /* Plate Typography */
        .digital-font {
            font-family: 'Digital-7 Mono', sans-serif;
        }

        .plate-body {
            width: 420px;
            height: 150px;
        }

        /* Animations */
        @keyframes shake {

            0%,
            100% {
                transform: translate(0, 0);
            }

            25% {
                transform: translate(2px, 2px);
            }

            75% {
                transform: translate(-2px, -2px);
            }
        }

        .timer-shake {
            animation: shake 0.2s infinite;
            color: #FF0055 !important;
        }
        @media (min-width: 768px){
            .md\:text-8xl{
                font-size: 4rem !important;
            }
        }
        @media (max-width: 1024px) {
    .cube-3d {
        width: 300px; /* Thu nhỏ bệ thờ trên tablet/mobile */
        height: 120px;
    }
    .cube-face {
        width: 300px;
        height: 120px;
    }
    /* Điều chỉnh lại vị trí các mặt cho khớp kích thước mới */
    .cube-face.top, .cube-face.bottom { height: 40px; }
    .cube-face.left, .cube-face.right { width: 40px; }
    .cube-face.right { transform: rotateY(90deg) translateZ(280px); } /* 300 - 20 */
    
    .plate-body {
        width: 280px;
        height: 100px;
    }
    #plate-number {
        font-size: 2.5rem !important; /* Thu nhỏ số biển số */
    }
}
/* --- Tối ưu giao diện Mobile --- */
@media (max-width: 768px) {
    .pedestal-center {
        height: 300px; /* Giảm chiều cao khu vực trung tâm */
        order: 1; /* Đưa biển số lên đầu */
    }
    .left-side { order: 2; }
    .right-side { order: 3; }

    /* Ẩn bớt các hiệu ứng nặng nếu cần (Chế độ Lite) */
    #energy-particles {
        opacity: 0.3;
    }

    /* Đưa bảng giá và đồng hồ lên vị trí dễ nhìn */
    .glass-console {
        padding: 1rem !important;
    }
    
    #countdown-timer {
        font-size: 2.5rem !important;
    }

    /* Thanh trả giá nhanh dính dưới màn hình */
    
    
    #bid-now-btn {
        padding: 12px !important;
        flex: 2;
    }
    
    .bid-control .flex {
        flex: 1;
        flex-direction: column;
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
    <section id="grand-arena" class="relative min-h-screen bg-[#00050A] overflow-hidden flex items-center justify-center">

        <canvas id="energy-particles" class="absolute inset-0 z-0 opacity-60"></canvas>

        <div class="absolute inset-0 z-0">
            <div class="light-sweep absolute top-0 left-0 w-full h-full bg-gradient-to-r from-transparent via-cyan-500/10 to-transparent skew-x-12"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10 flex flex-col lg:flex-row items-center justify-between gap-12">

            <div class="portal-side left-side w-full lg:w-1/4 flex flex-col gap-6">
                <div class="glass-console p-6 rounded-2xl border-l-2 border-cyan-500 bg-[#001A33]/40 backdrop-blur-xl">
                    <p class="text-white/40 text-[10px] tracking-[4px] uppercase mb-1">Giá khởi điểm</p>
                    <p class="text-white text-xl font-mono">500.000.000đ</p>

                    <div class="my-6 h-[1px] bg-cyan-500/20 w-full"></div>

                    <p class="text-cyan-400 text-[10px] tracking-[4px] uppercase mb-1 font-bold">Giá hiện tại</p>
                    <h3 id="current-price" class="text-[#99FFFF] text-4xl font-bold font-sans drop-shadow-[0_0_15px_rgba(0,255,255,0.5)]">
                        850.000.000
                    </h3>
                </div>

                <div class="flex gap-4">
                    <div class="flex-1 glass-console p-4 rounded-xl bg-white/5 border border-white/10">
                        <p class="text-white/30 text-[8px] uppercase">Lượt trả</p>
                        <p class="text-white font-bold">128</p>
                    </div>
                    <div class="flex-1 glass-console p-4 rounded-xl bg-white/5 border border-white/10">
                        <p class="text-white/30 text-[8px] uppercase">Đang xem</p>
                        <p class="text-cyan-400 font-bold">1.2k</p>
                    </div>
                </div>
            </div>

            <div class="pedestal-center relative perspective-2000 w-full lg:w-2/4 h-[400px] flex items-center justify-center">
                <div id="crystal-cube" class="cube-3d">
                    <div class="cube-face front flex items-center justify-center">
                        <div class="legacy-plate-3d group">
                            <div class="plate-aura absolute inset-0 blur-2xl bg-cyan-500/20 group-hover:bg-cyan-500/40 transition-all"></div>
                            <div class="plate-body relative bg-[#F0F0F0] p-4 rounded-xl border-4 border-[#CCCCCC] shadow-2xl flex flex-col items-center">
                                <span class="text-black/30 font-bold self-start text-xl">VN</span>
                                <h2 id="plate-number" class="text-black text-6xl md:text-8xl font-black tracking-tighter py-4">
                                    30K-999.99
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="cube-face back bg-cyan-500/5 backdrop-blur-sm border border-cyan-500/20"></div>
                    <div class="cube-face top bg-cyan-500/10 backdrop-blur-sm border border-cyan-500/20"></div>
                    <div class="cube-face bottom bg-cyan-500/20 shadow-[0_0_100px_rgba(0,255,255,0.3)]"></div>
                </div>
            </div>

            <div class="portal-side right-side w-full lg:w-1/4 flex flex-col gap-6">
                <div class="glass-console p-6 rounded-2xl border-r-2 border-cyan-500 bg-[#001A33]/40 backdrop-blur-xl text-right">
                    <p class="text-cyan-400 text-[10px] tracking-[4px] uppercase mb-2 font-bold">Thời gian còn lại</p>
                    <div id="countdown-timer" class="digital-font text-5xl md:text-6xl text-cyan-400">
                        00:58
                    </div>
                </div>

                <div class="bid-control flex flex-col gap-4">
                    <button id="bid-now-btn" class="relative group overflow-hidden py-6 rounded-2xl bg-[#007FFF] shadow-[0_0_30px_rgba(0,127,255,0.4)] transition-all">
                        <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform"></div>
                        <span class="relative z-10 text-white font-bold uppercase tracking-[4px]">Trả giá ngay</span>
                    </button>

                    <div class="flex gap-2">
                        <button class="flex-1 py-3 rounded-lg bg-white/5 border border-white/10 text-white text-xs hover:bg-cyan-500/20 transition-all">+5M</button>
                        <button class="flex-1 py-3 rounded-lg bg-white/5 border border-white/10 text-white text-xs hover:bg-cyan-500/20 transition-all">+10M</button>
                        <button class="flex-1 py-3 rounded-lg bg-white/5 border border-white/10 text-white text-xs hover:bg-cyan-500/20 transition-all">Tùy chỉnh</button>
                    </div>
                </div>

                <div class="recent-bidders bg-white/5 rounded-xl p-4 overflow-hidden h-32">
                    <div class="marquee-vertical space-y-2">
                        <p class="text-[10px] text-white/40"><span class="text-cyan-400">Ẩn danh 432</span> vừa trả 860M</p>
                        <p class="text-[10px] text-white/40"><span class="text-cyan-400">Anh Hoàng - HN</span> vừa trả 850M</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ----------------------------- section 2 -----------------------------  -->

    <!-- ----------------------------- section 3 -----------------------------  -->

    <!-- ----------------------------- section 4 -----------------------------  -->

    <!-- ----------------------------- section 5 -----------------------------  -->

    <!-- ----------------------------- section 6 -----------------------------  -->

    <?php include "footer.php"; ?>
</body>
<script>
    // ----------------------------- section 1 ----------------------------- //
    document.addEventListener('DOMContentLoaded', () => {
    // 1. Reveal Animation
    const revealTl = gsap.timeline();
    revealTl.from("#crystal-cube", { 
        y: 300, 
        opacity: 0, 
        rotationX: 90, 
        duration: 2, 
        ease: "expo.out" 
    })
    .from("#plate-number", { 
        clipPath: "inset(0 100% 0 0)", 
        duration: 1.5 
    }, "-=1");

    // 2. Continuous Rotation
    gsap.to("#crystal-cube", {
        rotationY: "+=360",
        duration: 20,
        repeat: -1,
        ease: "none"
    });

    // 3. Energy Particles
    const canvas = document.getElementById('energy-particles');
    const ctx = canvas.getContext('2d');
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    let particles = [];
    class Particle {
        constructor() {
            this.x = Math.random() * canvas.width;
            this.y = Math.random() * canvas.height;
            this.size = Math.random() * 2;
            this.speedY = (Math.random() - 0.5) * 0.8;
        }
        update() {
            this.y += this.speedY;
            if (this.y > canvas.height) this.y = 0;
            if (this.y < 0) this.y = canvas.height;
        }
        draw() {
            ctx.fillStyle = '#00FFFF';
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
            ctx.fill();
        }
    }

    for (let i = 0; i < 80; i++) particles.push(new Particle());

    function animate() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        particles.forEach(p => { p.update(); p.draw(); });
        requestAnimationFrame(animate);
    }
    animate();

    // 4. Price Surge Logic
    document.getElementById('bid-now-btn').addEventListener('click', () => {
        const price = document.getElementById('current-price');
        
        // Hiệu ứng bùng nổ giá
        gsap.timeline()
            .to(price, { scale: 1.4, filter: "brightness(2)", duration: 0.1 })
            .set(price, { textContent: (parseInt(price.textContent.replace(/\./g, '')) + 5000000).toLocaleString('vi-VN') })
            .to(price, { scale: 1, filter: "brightness(1)", duration: 0.4, ease: "back.out" });

        if (navigator.vibrate) navigator.vibrate(50);
    });
});

    // ----------------------------- section 2 ----------------------------- //

    // ----------------------------- section 3 ----------------------------- //

    // ----------------------------- section 4 ----------------------------- //

    // ----------------------------- section 5 ----------------------------- //

    // ----------------------------- section 6 ----------------------------- //
</script>

</html>