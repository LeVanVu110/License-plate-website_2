<!DOCTYPE html>
<html lang="en">
<?php
session_start();

// Mảng các ID được phép vào vùng Admin
$admin_roles = [1, 2, 3, 4, 5];

if (!isset($_SESSION['role_id']) || !in_array($_SESSION['role_id'], $admin_roles)) {
    // Nếu không có quyền, đuổi về trang login hoặc báo lỗi
    header("Location: login.php?error=access_denied");
    exit();
}
?>
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

        @media (max-width: 768px) {
            #main-content {
                margin-left: 0 !important;
                /* Loại bỏ khoảng trống sidebar trên mobile */
                padding-bottom: 100px;
                /* Tránh bị nút Emergency che khuất */
            }
        }

        /* ----------------------------- section 1 -----------------------------  */
        /* Safety Shield Transition */
        .reveal-particles {
            animation: particles 0.5s forwards;
        }

        @keyframes particles {
            0% {
                filter: blur(8px);
                opacity: 1;
            }

            100% {
                filter: blur(0);
                opacity: 1;
            }
        }

        .service-tile {
            backdrop-filter: blur(10px);
        }

        /* Tùy chỉnh thanh cuộn cho Log Webhook */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(59, 130, 246, 0.5);
            border-radius: 10px;
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
        <section id="integration-gateway" class="py-20 px-4 md:px-10 bg-[#243669] text-white overflow-hidden relative">
            <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: radial-gradient(#1e293b 1px, transparent 1px); background-size: 30px 30px;"></div>

            <div class="max-w-7xl mx-auto relative z-10">
                <div class="flex flex-col xl:flex-row justify-between items-start xl:items-end mb-12 gap-8">
                    <div>
                        <h2 class="text-3xl font-black tracking-tighter uppercase flex items-center gap-3">
                            <i class="ri-node-tree text-blue-500"></i>
                            Infrastructure Node
                        </h2>
                        <p class="text-slate-500 font-mono text-[10px] mt-2 uppercase tracking-[3px]">Global Integration & API Gateway Management</p>
                    </div>

                    <div class="flex gap-6 items-center bg-slate-900/50 p-4 rounded-2xl border border-white/5">
                        <div class="hidden md:block">
                            <p class="text-[8px] font-black text-slate-500 uppercase mb-2">Global Traffic</p>
                            <div class="flex items-end gap-1 h-8">
                                <div class="w-1 bg-blue-500/40 h-1/2"></div>
                                <div class="w-1 bg-blue-500/60 h-3/4"></div>
                                <div class="w-1 bg-blue-500 h-full"></div>
                                <div class="w-1 bg-blue-500/80 h-2/3"></div>
                                <div class="w-1 bg-blue-500 h-1/2"></div>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-[8px] font-black text-slate-500 uppercase mb-1">System Uptime</p>
                            <p class="text-xl font-black text-emerald-500 font-mono">99.998%</p>
                        </div>
                    </div>
                </div>

                <div id="service-grid" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

                    <div class="service-tile group bg-slate-900/40 border border-slate-800 rounded-[2rem] p-8 hover:border-blue-500/40 transition-all duration-500 cursor-move">
                        <div class="flex justify-between items-start mb-8">
                            <div class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center relative">
                                <i class="ri-bank-line text-2xl text-blue-400"></i>
                                <div class="absolute -top-1 -right-1 w-3 h-3 bg-emerald-500 rounded-full animate-ping"></div>
                                <div class="absolute -top-1 -right-1 w-3 h-3 bg-emerald-500 rounded-full border-2 border-slate-900"></div>
                            </div>
                            <button onclick="reSync(this)" class="p-2 hover:bg-white/5 rounded-full transition-all refresh-btn">
                                <i class="ri-restart-line text-slate-500"></i>
                            </button>
                        </div>

                        <h3 class="font-bold text-sm mb-2">Vietcombank Gateway</h3>
                        <div class="flex justify-between items-center mb-6">
                            <span class="text-[10px] text-slate-500 font-mono">Latency: <span class="text-emerald-400">24ms</span></span>
                            <span class="text-[10px] bg-emerald-500/10 text-emerald-500 px-2 py-1 rounded-md font-bold uppercase">Online</span>
                        </div>

                        <div class="space-y-4">
                            <div class="bg-black/40 rounded-xl p-3 border border-white/5 flex justify-between items-center group/key">
                                <code class="text-[10px] text-slate-400 font-mono blur-sm transition-all duration-300 api-key">vcb_live_xxxx_8888</code>

                                <button onclick="revealKey(this)" class="text-slate-600 hover:text-white transition-colors">
                                    <i class="ri-eye-off-line"></i>
                                </button>
                            </div>
                            <div class="flex justify-between text-[9px] uppercase font-black tracking-widest text-slate-600">
                                <span>Rate Limit</span>
                                <span>5,000 req/min</span>
                            </div>
                        </div>
                    </div>

                    <div class="service-tile bg-slate-900/40 border border-slate-800 rounded-[2rem] p-8 hover:border-indigo-500/40 transition-all duration-500 cursor-move">
                        <div class="flex justify-between items-start mb-8">
                            <div class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center relative">
                                <i class="ri-user-unfollow-line text-2xl text-indigo-400"></i>
                                <div class="absolute -top-1 -right-1 w-3 h-3 bg-amber-500 rounded-full animate-pulse"></div>
                            </div>
                            <button onclick="reSync(this)" class="p-2 hover:bg-white/5 rounded-full transition-all refresh-btn">
                                <i class="ri-restart-line text-slate-500"></i>
                            </button>
                        </div>

                        <h3 class="font-bold text-sm mb-2">Global eKYC Hub</h3>
                        <div class="flex justify-between items-center mb-6">
                            <span class="text-[10px] text-slate-500 font-mono">Latency: <span class="text-amber-400">145ms</span></span>
                            <span class="text-[10px] bg-amber-500/10 text-amber-500 px-2 py-1 rounded-md font-bold uppercase">Degraded</span>
                        </div>

                        <div class="h-1 w-full bg-slate-800 rounded-full mb-6 overflow-hidden">
                            <div class="h-full bg-indigo-500 w-[84%]"></div>
                        </div>

                        <p class="text-[9px] text-slate-500 italic leading-relaxed">System is performing graceful degradation. Switching to backup OCR engine.</p>
                    </div>

                    <div class="service-tile bg-slate-900/40 border border-slate-800 rounded-[2rem] p-8 hover:border-purple-500/40 transition-all duration-500 cursor-move">
                        <div class="flex justify-between items-start mb-8">
                            <div class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center relative">
                                <i class="ri-shield-flash-line text-2xl text-purple-400"></i>
                                <div class="absolute -top-1 -right-1 w-3 h-3 bg-emerald-500 rounded-full"></div>
                            </div>
                            <button onclick="reSync(this)" class="p-2 hover:bg-white/5 rounded-full transition-all refresh-btn">
                                <i class="ri-restart-line text-slate-500"></i>
                            </button>
                        </div>

                        <h3 class="font-bold text-sm mb-2">Blockchain Proof Node</h3>
                        <div class="flex justify-between items-center mb-6">
                            <span class="text-[10px] text-slate-500 font-mono">Block Height: <span class="text-purple-400">#8,291,012</span></span>
                            <span class="text-[10px] bg-purple-500/10 text-purple-500 px-2 py-1 rounded-md font-bold uppercase">Synced</span>
                        </div>

                        <div class="grid grid-cols-4 gap-1">
                            <div class="h-4 bg-purple-500/20 rounded-sm animate-pulse"></div>
                            <div class="h-4 bg-purple-500/40 rounded-sm"></div>
                            <div class="h-4 bg-purple-500/60 rounded-sm"></div>
                            <div class="h-4 bg-purple-500 rounded-sm"></div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 bg-black/60 rounded-[2rem] border border-white/5 overflow-hidden">
                    <div class="flex items-center justify-between px-8 py-4 bg-white/5">
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Webhook Response Logger</span>
                        <div class="flex gap-2">
                            <div class="w-2 h-2 rounded-full bg-rose-500"></div>
                            <div class="w-2 h-2 rounded-full bg-amber-500"></div>
                            <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                        </div>
                    </div>
                    <div class="p-8 font-mono text-[11px] text-emerald-400/80 leading-relaxed max-h-60 overflow-y-auto">
                        <p><span class="text-purple-400">[19:42:01]</span> POST /webhooks/vcb-callback - 200 OK</p>
                        <p class="pl-4 text-slate-500">{</p>
                        <p class="pl-8 text-slate-300">"status": "success",</p>
                        <p class="pl-8 text-slate-300">"transaction_id": "TXN_992100445",</p>
                        <p class="pl-8 text-slate-300">"amount": 2500000000,</p>
                        <p class="pl-8 text-slate-300">"message": "Deposit confirmed by bank"</p>
                        <p class="pl-4 text-slate-500">}</p>
                        <p><span class="text-purple-400">[19:42:45]</span> GET /api/v1/kyc-status/USR_882 - <span class="text-amber-500">408 Request Timeout</span></p>
                    </div>
                </div>
            </div>

            <div class="xl:hidden fixed bottom-24 left-1/2 -translate-x-1/2 w-[90%] z-49">
                <button onclick="emergencySwitch()" class="w-full bg-rose-600 hover:bg-rose-700 py-4 rounded-2xl flex items-center justify-center gap-3 shadow-2xl shadow-rose-900/40 transition-all border border-rose-400/20">
                    <i class="ri-error-warning-fill animate-pulse"></i>
                    <span class="text-xs font-black uppercase tracking-widest text-white">Emergency Switch-over</span>
                </button>
            </div>
        </section>

        <!-- ----------------------------- section 2 -----------------------------  -->

        <!-- ----------------------------- section 3 -----------------------------  -->

        <!-- ----------------------------- section 4 -----------------------------  -->

        <!-- ----------------------------- section 5 -----------------------------  -->

        <!-- ----------------------------- section 6 -----------------------------  -->
    </main>
</body>
<script>
    // ----------------------------- section 1 ----------------------------- //
    // 1. Re-sync 3D Rotation
    function reSync(btn) {
        const icon = btn.querySelector('i');
        gsap.to(icon, {
            rotation: 360,
            duration: 1,
            ease: "expo.out",
            onComplete: () => {
                gsap.set(icon, {
                    rotation: 0
                });
                alert("Gateway re-synchronized successfully.");
            }
        });

        // Haptic Feedback
        if (window.navigator.vibrate) window.navigator.vibrate(20);
    }

    // 2. Reveal Secret Key (Safety Shield)
    function revealKey(btn) {
        // 1. Tìm thẻ <code> trong cùng một div cha
        const keyElement = btn.parentElement.querySelector('code');
        const icon = btn.querySelector('i');

        // 2. Kiểm tra xem đang ẩn hay hiện
        const isHidden = keyElement.classList.contains('blur-sm');

        if (isHidden) {
            // HIỆN: Bỏ blur, đổi màu chữ, đổi icon
            keyElement.classList.remove('blur-sm');
            keyElement.classList.add('text-cyan-400'); // Thêm màu cho nổi bật khi hiện
            icon.classList.replace('ri-eye-off-line', 'ri-eye-line');

            // (Tùy chọn) Tự động ẩn lại sau 5 giây để bảo mật
            setTimeout(() => {
                if (!keyElement.classList.contains('blur-sm')) {
                    revealKey(btn); // Gọi lại hàm để ẩn đi
                }
            }, 5000);

        } else {
            // ẨN: Thêm lại blur, đổi lại màu cũ, đổi icon
            keyElement.classList.add('blur-sm');
            keyElement.classList.remove('text-cyan-400');
            icon.classList.replace('ri-eye-line', 'ri-eye-off-line');
        }

        // Phản hồi rung nhẹ trên mobile (nếu có hỗ trợ)
        if (window.navigator.vibrate) window.navigator.vibrate(10);
    }

    // 3. Emergency Switch (Mobile Haptic)
    function emergencySwitch() {
        if (window.navigator.vibrate) {
            // Rung mạnh liên tục để cảnh báo
            window.navigator.vibrate([100, 50, 100, 50, 300]);
        }

        const confirmSwitch = confirm("CRITICAL ACTION: Switch all traffic to Backup Gateway (Techcombank Hub)?");
        if (confirmSwitch) {
            alert("Protocol Initiated: Traffic redirected to Secondary Node.");
        }
    }

    // 4. Drag & Drop Grid (Dùng SortableJS nếu có, đây là giả lập)
    // Sẽ cho phép Admin di chuyển các thẻ ưu tiên

    // ----------------------------- section 2 ----------------------------- //

    // ----------------------------- section 3 ----------------------------- //

    // ----------------------------- section 4 ----------------------------- //

    // ----------------------------- section 5 ----------------------------- //

    // ----------------------------- section 6 ----------------------------- //
</script>

</html>