<?php include "header.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* ----------------------------- section 1 -----------------------------  */
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Space+Mono&display=swap');

        #quantum-portal {
            perspective: 1000px;
        }

        #headline {
            font-family: 'Playfair Display', serif;
        }

        #plate-input {
            font-family: 'Space Mono', monospace;
            text-shadow: 0 0 10px rgba(34, 211, 238, 0.5);
        }

        /* Radar Animation */
        .radar-ring {
            transition: transform 0.1s ease-out;
        }

        /* Biometric Laser */
        #laser-line {
            top: 0;
        }

        /* Glow Effect for Rings */
        .ring-1 {
            box-shadow: inset 0 0 50px rgba(0, 255, 255, 0.05);
        }

        /* Utility Classes */
        .shake-screen {
            animation: quantum-shake 0.1s infinite;
        }

        @keyframes quantum-shake {
            0% {
                transform: translate(1px, 1px);
            }

            50% {
                transform: translate(-1px, -2px);
            }

            100% {
                transform: translate(1px, 1px);
            }
        }

        @media (max-width: 768px) {
            #headline {
                tracking: 0.5rem;
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
    <section id="quantum-portal" class="relative min-h-screen bg-[#000814] overflow-hidden flex items-center justify-center">

        <canvas id="starfield-canvas" class="absolute inset-0 z-0"></canvas>

        <div class="absolute left-6 top-1/2 -translate-y-1/2 hidden lg:flex flex-col gap-2 font-mono text-[10px] text-cyan-500/30 select-none" id="left-data-stream"></div>
        <div class="absolute right-6 top-1/2 -translate-y-1/2 hidden lg:flex flex-col gap-2 font-mono text-[10px] text-cyan-500/30 select-none" id="right-data-stream"></div>

        <div class="container mx-auto px-6 relative z-10 flex flex-col items-center">
            <div class="text-center mb-16 overflow-hidden">
                <h1 id="headline" class="text-4xl md:text-6xl font-serif uppercase text-[#E0F7FA] tracking-[1rem] opacity-0 translate-y-full">
                    AI Oracle: Giải mã di sản
                </h1>
            </div>

            <div id="scanner-hub" class="relative w-[320px] h-[320px] md:w-[500px] md:h-[500px] flex items-center justify-center">

                <div class="radar-ring ring-1 absolute inset-0 border border-cyan-500/20 rounded-full"></div>
                <div class="radar-ring ring-2 absolute inset-[15%] border border-cyan-500/40 rounded-full border-dashed"></div>
                <div class="radar-ring ring-3 absolute inset-[30%] border-2 border-cyan-400/10 rounded-full"></div>

                <div class="relative z-20 w-full px-8 text-center">
                    <div class="input-wrapper relative">
                        <input type="text" id="plate-input" maxlength="10" placeholder="NHẬP BIỂN SỐ..."
                            class="w-full bg-transparent border-b-2 border-cyan-500/30 py-4 text-center text-3xl md:text-5xl font-mono text-cyan-400 focus:outline-none placeholder:text-cyan-900 tracking-widest uppercase">

                        <div id="laser-line" class="absolute left-0 right-0 h-[2px] bg-cyan-400 shadow-[0_0_15px_#22d3ee] opacity-0 pointer-events-none"></div>
                    </div>

                    <button id="btn-valuation" class="mt-12 group relative px-12 py-4 overflow-hidden border border-cyan-500 rounded-full transition-all duration-500">
                        <span class="relative z-10 text-cyan-400 font-bold tracking-[0.3rem] group-hover:text-black transition-colors">ĐỊNH GIÁ</span>
                        <div class="absolute inset-0 bg-cyan-400 translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                    </button>
                </div>

                <div id="neural-center" class="absolute w-2 h-2 bg-cyan-400 rounded-full blur-sm opacity-0"></div>
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
        // 1. STARFIELD PARTICLES
        const canvas = document.getElementById('starfield-canvas');
        const ctx = canvas.getContext('2d');
        let particles = [];
        const particleCount = window.innerWidth < 768 ? 400 : 1000;
        let speedMult = 1;

        const resize = () => {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        };
        window.addEventListener('resize', resize);
        resize();

        class Particle {
            constructor() {
                this.reset();
            }
            reset() {
                this.x = (Math.random() - 0.5) * canvas.width * 2;
                this.y = (Math.random() - 0.5) * canvas.height * 2;
                this.z = Math.random() * canvas.width;
                this.prevZ = this.z;
            }
            update() {
                this.prevZ = this.z;
                this.z -= 4 * speedMult;
                if (this.z <= 0) this.reset();
            }
            draw() {
                const x = (this.x / this.z) * 100 + canvas.width / 2;
                const y = (this.y / this.z) * 100 + canvas.height / 2;
                const px = (this.x / this.prevZ) * 100 + canvas.width / 2;
                const py = (this.y / this.prevZ) * 100 + canvas.height / 2;

                ctx.strokeStyle = `rgba(34, 211, 238, ${1 - this.z / canvas.width})`;
                ctx.lineWidth = 1;
                ctx.beginPath();
                ctx.moveTo(px, py);
                ctx.lineTo(x, y);
                ctx.stroke();
            }
        }

        for (let i = 0; i < particleCount; i++) particles.push(new Particle());

        function loop() {
            ctx.fillStyle = 'rgba(0, 8, 20, 0.2)';
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            particles.forEach(p => {
                p.update();
                p.draw();
            });
            requestAnimationFrame(loop);
        }
        loop();

        // 2. ENTRANCE ANIMATION
        const tl = gsap.timeline();
        tl.to("#headline", {
                opacity: 1,
                y: 0,
                duration: 1.5,
                ease: "expo.out"
            })
            .from(".radar-ring", {
                scale: 0,
                opacity: 0,
                stagger: 0.2,
                duration: 2,
                ease: "elastic.out(1, 0.5)"
            }, "-=1");

        gsap.to(".ring-1", {
            rotation: 360,
            duration: 20,
            repeat: -1,
            ease: "none"
        });
        gsap.to(".ring-2", {
            rotation: -360,
            duration: 15,
            repeat: -1,
            ease: "none"
        });

        // 3. MOUSE FOLLOW (TILT) & GYRO
        window.addEventListener('mousemove', (e) => {
            const x = (e.clientX / window.innerWidth - 0.5) * 20;
            const y = (e.clientY / window.innerHeight - 0.5) * 20;
            gsap.to("#scanner-hub", {
                rotationY: x,
                rotationX: -y,
                duration: 1
            });
        });

        // 4. INPUT INTERACTION
        const input = document.getElementById('plate-input');
        const laser = document.getElementById('laser-line');

        input.addEventListener('focus', () => {
            gsap.to(laser, {
                opacity: 1,
                duration: 0.3
            });
            gsap.to(laser, {
                top: "100%",
                duration: 1.5,
                repeat: -1,
                yoyo: true,
                ease: "sine.inOut"
            });
        });

        input.addEventListener('input', () => {
            // Digital Ripple
            speedMult = 5;
            setTimeout(() => speedMult = 1, 200);
            if ("vibrate" in navigator) navigator.vibrate(10);
        });

        // 5. THE NEURAL CRUNCH (CLICK BUTTON)
        document.getElementById('btn-valuation').addEventListener('click', () => {
            const crunchTl = gsap.timeline();

            // Co hội tụ hạt và rung màn hình
            speedMult = 20;
            document.body.classList.add('shake-screen');

            crunchTl.to("#scanner-hub", {
                    scale: 0.8,
                    filter: "blur(10px)",
                    duration: 0.5
                })
                .to(".radar-ring", {
                    rotation: "+=1080",
                    duration: 1,
                    ease: "power4.in"
                }, 0)
                .to("#quantum-portal", {
                    backgroundColor: "#22d3ee",
                    duration: 0.1,
                    yoyo: true,
                    repeat: 1
                })
                .add(() => {
                    // Transition effect sang Section tiếp theo
                    console.log("Valuation complete. Jumping to results...");
                    document.body.classList.remove('shake-screen');
                    // Window.scrollTo(...)
                });
        });

        // DATA STREAM DECRYPTION (Rìa màn hình)
        const streams = [document.getElementById('left-data-stream'), document.getElementById('right-data-stream')];
        streams.forEach(s => {
            for (let i = 0; i < 20; i++) {
                const d = document.createElement('div');
                d.innerText = Math.random().toString(16).substr(2, 8).toUpperCase();
                s.appendChild(d);
            }
        });
    });

    // ----------------------------- section 2 ----------------------------- //

    // ----------------------------- section 3 ----------------------------- //

    // ----------------------------- section 4 ----------------------------- //

    // ----------------------------- section 5 ----------------------------- //

    // ----------------------------- section 6 ----------------------------- //
</script>

</html>