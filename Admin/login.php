<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-dark: #000814;
            --accent-cyan: #22d3ee;
        }

        body {
            background-color: var(--bg-dark);
            font-family: 'Inter', sans-serif;
        }

        /* ----------------------------- section 1 -----------------------------  */
        .perspective-2000 {
            perspective: 2000px;
        }

        .transform-style-3d {
            transform-style: preserve-3d;
        }

        .backface-hidden {
            backface-visibility: hidden;
        }

        .rotate-y-180 {
            transform: rotateY(180deg);
        }

        .space-mono {
            font-family: 'Space Mono', monospace;
        }

        /* Responsive Logic */
        @media (max-width: 1024px) {
            #portal-container {
                height: auto !important;
                max-width: 500px;
                min-height: 600px;
            }

            .backface-hidden {
                position: relative !important;
                backface-visibility: visible !important;
                transform: none !important;
                display: flex;
            }

            /* Mặc định hiện mặt Login, ẩn mặt Register */
            #auth-card .backface-hidden:last-child {
                display: none;
            }

            /* Chuyển đổi hiển thị khi active class is-register */
            #auth-card.is-register .backface-hidden:first-child {
                display: none;
            }

            #auth-card.is-register .backface-hidden:last-child {
                display: flex;
                transform: none !important;
            }

            .parallax-element {
                display: none;
            }
        }

        #auth-card {
            transition: transform 0.8s cubic-bezier(0.645, 0.045, 0.355, 1);
        }

        /* Hiệu ứng focus input */
        input:focus~label,
        input:valid~label {
            transform: translateY(-22px) scale(0.85);
            color: var(--accent-cyan);
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
    <section id="portal-section" class="relative min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8">

        <div id="portal-container" class="relative w-full max-w-5xl h-[650px] perspective-2000">
            <div id="auth-card" class="relative w-full h-full transform-style-3d">

                <div class="absolute inset-0 flex flex-col md:flex-row bg-[#050505]/90 backdrop-blur-3xl rounded-[30px] md:rounded-[40px] border border-white/10 overflow-hidden backface-hidden">
                    <div class="hidden md:flex w-1/2 relative bg-gradient-to-br from-blue-900/20 to-transparent items-center justify-center border-r border-white/5">
                        <div class="parallax-element absolute w-64 h-64 bg-cyan-500/20 rounded-full blur-[100px]"></div>
                        <div class="relative z-10 text-center p-8">
                            <h2 class="space-mono text-5xl lg:text-6xl text-white font-black mb-4">888.88</h2>
                            <p class="text-cyan-400 tracking-[5px] uppercase text-[10px]">The Legacy Awaits</p>
                        </div>
                    </div>

                    <div class="w-full md:w-1/2 p-8 sm:p-12 lg:p-16 flex flex-col justify-center">
                        <div class="mb-8">
                            <h3 class="text-2xl lg:text-3xl text-white font-light mb-2">Xin chào, <span class="text-cyan-400 italic">Quý khách</span></h3>
                            <p class="text-white/40 text-sm">Vui lòng đăng nhập để tiếp tục</p>
                        </div>

                        <form class="space-y-6 lg:space-y-8">
                            <div class="relative">
                                <input type="email" required class="w-full bg-transparent border-b border-white/10 py-3 text-white focus:outline-none focus:border-cyan-400 transition-all peer">
                                <label class="absolute left-0 top-3 text-white/30 pointer-events-none transition-all duration-300 origin-left">EMAIL ADDRESS</label>
                            </div>

                            <div class="relative">
                                <input type="password" required class="w-full bg-transparent border-b border-white/10 py-3 text-white focus:outline-none focus:border-cyan-400 transition-all peer">
                                <label class="absolute left-0 top-3 text-white/30 pointer-events-none transition-all duration-300 origin-left">PASSWORD</label>
                                <div class="biometric-scan absolute inset-0 bg-cyan-400/5 opacity-0 pointer-events-none"></div>
                            </div>

                            <a href="Dashboard.php" class="block w-full">
                                <button type="button" class="w-full py-4 bg-gradient-to-r from-blue-700 to-cyan-500 text-white rounded-xl font-bold tracking-widest hover:shadow-[0_0_30px_rgba(34,211,238,0.4)] transition-all">
                                    ĐĂNG NHẬP
                                </button>
                            </a>
                        </form>
                        <p class="mt-8 text-center text-white/20 text-xs">
                            Chưa có tài khoản? <button onclick="flipCard()" class="text-white hover:text-cyan-400 transition-colors">Đăng ký ngay</button>
                        </p>
                    </div>
                </div>

                <div class="absolute inset-0 flex flex-col md:flex-row-reverse bg-[#050505]/90 backdrop-blur-3xl rounded-[30px] md:rounded-[40px] border border-white/10 overflow-hidden backface-hidden rotate-y-180">
                    <div class="hidden md:flex w-1/2 relative bg-gradient-to-bl from-cyan-900/20 to-transparent items-center justify-center border-l border-white/5">
                        <div class="parallax-element absolute w-64 h-64 bg-blue-500/20 rounded-full blur-[100px]"></div>
                        <div class="relative z-10 text-center p-8">
                            <div class="w-24 h-24 lg:w-32 lg:h-32 mx-auto border-2 border-cyan-400/30 rounded-full flex items-center justify-center mb-6 animate-pulse">
                                <i class="ri-fingerprint-line text-5xl lg:text-6xl text-cyan-400"></i>
                            </div>
                            <p class="text-white tracking-[5px] uppercase text-[10px]">Identify Your Legacy</p>
                        </div>
                    </div>

                    <div class="w-full md:w-1/2 p-8 sm:p-12 lg:p-16 flex flex-col justify-center">
                        <div class="mb-8">
                            <h3 class="text-2xl lg:text-3xl text-white font-light mb-2">Kiến tạo <span class="text-blue-500 italic">Di sản</span></h3>
                            <p class="text-white/40 text-sm">Đăng ký tài khoản đấu giá định danh</p>
                        </div>
                        <form class="space-y-5 lg:space-y-6">
                            <div class="relative"><input type="text" required class="w-full bg-transparent border-b border-white/10 py-3 text-white focus:outline-none peer"><label class="absolute left-0 top-3 text-white/30 transition-all origin-left">FULL NAME</label></div>
                            <div class="relative"><input type="email" required class="w-full bg-transparent border-b border-white/10 py-3 text-white focus:outline-none peer"><label class="absolute left-0 top-3 text-white/30 transition-all origin-left">EMAIL</label></div>
                            <div class="relative"><input type="password" required class="w-full bg-transparent border-b border-white/10 py-3 text-white focus:outline-none peer"><label class="absolute left-0 top-3 text-white/30 transition-all origin-left">CREATE PASSWORD</label></div>
                            <button type="submit" class="w-full py-4 bg-white text-black rounded-xl font-bold tracking-widest hover:bg-cyan-400 transition-all">TIẾP TỤC</button>
                        </form>
                        <p class="mt-8 text-center text-white/20 text-xs">
                            Đã có tài khoản? <button onclick="flipCard()" class="text-white hover:text-cyan-400 transition-colors">Quay lại đăng nhập</button>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <style>

    </style>

    <!-- ----------------------------- section 2 -----------------------------  -->

    <!-- ----------------------------- section 3 -----------------------------  -->

    <!-- ----------------------------- section 4 -----------------------------  -->

    <!-- ----------------------------- section 5 -----------------------------  -->

    <!-- ----------------------------- section 6 -----------------------------  -->

</body>
<script>
    // ----------------------------- section 1 ----------------------------- //
    document.addEventListener("DOMContentLoaded", () => {
        const authCard = document.querySelector('#auth-card');
        const passwordInputs = document.querySelectorAll('input[type="password"]');

        // 1. Flip Transition (Xử lý Responsive)
        window.flipCard = () => {
            const isRegister = authCard.classList.toggle('is-register');

            if (window.innerWidth > 1024) {
                // Desktop: Xoay 3D
                gsap.to(authCard, {
                    rotateY: isRegister ? 180 : 0,
                    duration: 1,
                    ease: "power4.inOut"
                });
            } else {
                // Mobile: Hiệu ứng trượt và mờ dần (nhẹ nhàng hơn 3D)
                gsap.fromTo("#auth-card", {
                    opacity: 0,
                    y: 10
                }, {
                    opacity: 1,
                    y: 0,
                    duration: 0.6
                });
            }

            // Hiệu ứng "nhún" nhẹ cho container
            gsap.to("#portal-container", {
                scale: 0.98,
                duration: 0.2,
                yoyo: true,
                repeat: 1
            });
        };

        // 2. Biometric Glow Effect
        passwordInputs.forEach(input => {
            const scanEffect = input.parentElement.querySelector('.biometric-scan');
            input.addEventListener('focus', () => {
                gsap.to(scanEffect, {
                    opacity: 1,
                    scaleY: 1.2,
                    duration: 0.8,
                    repeat: -1,
                    yoyo: true
                });
            });
            input.addEventListener('blur', () => {
                gsap.to(scanEffect, {
                    opacity: 0,
                    duration: 0.3
                });
            });
        });

        // 3. Desktop Parallax (Tắt trên Mobile để tăng hiệu năng)
        if (window.innerWidth > 1024) {
            document.addEventListener('mousemove', (e) => {
                const xPos = (e.clientX / window.innerWidth - 0.5) * 30;
                const yPos = (e.clientY / window.innerHeight - 0.5) * 30;
                gsap.to(".parallax-element", {
                    x: xPos,
                    y: yPos,
                    duration: 1,
                    ease: "power2.out"
                });
            });
        }
    });

    // ----------------------------- section 2 ----------------------------- //

    // ----------------------------- section 3 ----------------------------- //

    // ----------------------------- section 4 ----------------------------- //

    // ----------------------------- section 5 ----------------------------- //

    // ----------------------------- section 6 ----------------------------- //
</script>

</html>