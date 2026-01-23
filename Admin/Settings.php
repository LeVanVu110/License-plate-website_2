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
        /* Focus Highlight Effect */
        .engine-focus-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.7);
            z-index: 5;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.4s;
        }

        .engine-input:focus {
            border-color: #00D1FF !important;
            box-shadow: 0 0 20px rgba(0, 209, 255, 0.2);
            z-index: 20;
            position: relative;
        }

        /* Range Slider Styling */
        input[type=range]::-webkit-slider-thumb {
            -webkit-appearance: none;
            height: 14px;
            width: 14px;
            border-radius: 50%;
            background: white;
            cursor: pointer;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
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
    <main class="transition-all duration-300 ml-0 lg:ml-[250px] min-h-screen overflow-x-hidden" id="main-content">
        <!-- ----------------------------- section 1 -----------------------------  -->
        <section id="master-engine" class="py-20 px-4 md:px-10 bg-[#020617] relative">
            <div class="max-w-7xl mx-auto">

                <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-4">
                    <div>
                        <h2 class="text-3xl font-black text-white tracking-tighter uppercase flex items-center gap-3">
                            <i class="ri-settings-5-fill text-blue-500"></i>
                            Master Engine Control
                        </h2>
                        <p class="text-slate-500 font-mono text-xs mt-2 uppercase tracking-[3px]">System Core Parameters Coordination</p>
                    </div>
                    <div class="flex items-center gap-3 bg-blue-500/5 border border-blue-500/20 px-4 py-2 rounded-xl">
                        <div class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></div>
                        <span class="text-[10px] text-blue-400 font-bold font-mono uppercase tracking-widest">v3.4 Engine Active</span>
                    </div>
                </div>

                <div id="engine-grid" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8 relative z-10 transition-all duration-500">

                    <div class="config-card group p-8 bg-slate-900/40 border border-slate-800 rounded-[2.5rem] hover:border-blue-500/30 transition-all">
                        <div class="flex items-center justify-between mb-8">
                            <div class="w-12 h-12 rounded-2xl bg-blue-500/10 flex items-center justify-center text-blue-400">
                                <i class="ri-auction-line text-2xl"></i>
                            </div>
                            <button class="text-slate-600 hover:text-blue-400 transition-colors" title="History Restore">
                                <i class="ri-history-line text-lg"></i>
                            </button>
                        </div>

                        <h3 class="text-white font-bold mb-6 flex items-center gap-2 uppercase text-sm tracking-widest">Bid Logic</h3>

                        <div class="space-y-6">
                            <div class="input-group">
                                <label class="text-[10px] text-slate-500 uppercase font-black block mb-2">Default Starting Price</label>
                                <div class="relative">
                                    <input type="text" value="1,000,000" class="engine-input w-full bg-black/40 border border-slate-700 rounded-xl px-4 py-3 text-white font-['Roboto_Mono'] focus:outline-none transition-all" onfocus="focusEngine(this)" onblur="blurEngine(this)">
                                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] text-slate-600 font-bold">VND</span>
                                </div>
                            </div>

                            <div class="input-group">
                                <label class="text-[10px] text-slate-500 uppercase font-black block mb-2">Min Bid Increment</label>
                                <div class="relative">
                                    <input type="text" value="50,000" class="engine-input w-full bg-black/40 border border-slate-700 rounded-xl px-4 py-3 text-white font-['Roboto_Mono'] focus:outline-none transition-all" onfocus="focusEngine(this)" onblur="blurEngine(this)">
                                    <div class="sync-spinner absolute right-12 top-1/2 -translate-y-1/2 hidden">
                                        <i class="ri-loader-4-line animate-spin text-blue-500"></i>
                                    </div>
                                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] text-slate-600 font-bold">VND</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="config-card p-8 bg-slate-900/40 border border-slate-800 rounded-[2.5rem] relative overflow-hidden">
                        <h3 class="text-white font-bold mb-8 flex items-center gap-2 uppercase text-sm tracking-widest">Time Control</h3>

                        <div class="flex justify-center mb-8 relative">
                            <div class="w-32 h-32 rounded-full border-4 border-slate-800 border-t-blue-500 animate-[spin_10s_linear_infinite] relative"></div>
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <span class="text-xl font-black text-white font-mono">+30s</span>
                                <span class="text-[8px] text-blue-400 font-bold uppercase">Sniper Extension</span>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="flex items-center justify-between p-4 bg-black/20 rounded-2xl border border-white/5">
                                <div>
                                    <p class="text-[10px] text-white font-bold uppercase">Sniper Protection</p>
                                    <p class="text-[8px] text-slate-500 font-mono mt-1">Auto-extend on last min bid</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" checked class="sr-only peer" onchange="playClick()">
                                    <div class="w-11 h-6 bg-slate-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600 shadow-inner"></div>
                                </label>
                            </div>

                            <div class="flex gap-4">
                                <button class="flex-1 py-3 bg-slate-800 rounded-xl text-white font-bold text-xs hover:bg-slate-700">-</button>
                                <div class="w-1/2 bg-black/40 border border-slate-700 rounded-xl flex items-center justify-center font-mono text-white text-sm">05:00</div>
                                <button class="flex-1 py-3 bg-slate-800 rounded-xl text-white font-bold text-xs hover:bg-slate-700">+</button>
                            </div>
                        </div>
                    </div>

                    <div class="config-card p-8 bg-slate-900/40 border border-slate-800 rounded-[2.5rem]">
                        <h3 class="text-white font-bold mb-10 flex items-center gap-2 uppercase text-sm tracking-widest text-orange-400">Financial Ratio</h3>

                        <div class="space-y-10">
                            <div>
                                <div class="flex justify-between mb-4">
                                    <span class="text-[10px] text-slate-500 uppercase font-black tracking-widest">Deposit Ratio</span>
                                    <span class="text-xs text-white font-mono font-bold" id="deposit-val">15%</span>
                                </div>
                                <input type="range" min="0" max="100" value="15" class="w-full accent-blue-500 h-1 bg-slate-800 rounded-lg appearance-none cursor-pointer" oninput="updateSlider(this, 'deposit-val')">
                            </div>

                            <div>
                                <div class="flex justify-between mb-4">
                                    <span class="text-[10px] text-slate-500 uppercase font-black tracking-widest">Platform Fee</span>
                                    <span class="text-xs text-white font-mono font-bold" id="fee-val">2.5%</span>
                                </div>
                                <input type="range" min="0" max="10" step="0.1" value="2.5" class="w-full accent-orange-500 h-1 bg-slate-800 rounded-lg appearance-none cursor-pointer" oninput="updateSlider(this, 'fee-val')">
                            </div>

                            <div class="p-4 bg-orange-500/5 border border-orange-500/20 rounded-2xl">
                                <p class="text-[9px] text-orange-400 leading-relaxed font-medium italic">
                                    <i class="ri-information-line"></i> Tỷ lệ ký quỹ cao có thể làm giảm số lượng người tham gia đấu giá.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-12 flex items-center gap-4 px-6 py-4 bg-black/60 border border-white/5 rounded-2xl overflow-hidden">
                    <div class="flex gap-1">
                        <div class="w-1 h-3 bg-blue-500 animate-pulse"></div>
                        <div class="w-1 h-3 bg-blue-500/40 animate-pulse delay-75"></div>
                        <div class="w-1 h-3 bg-blue-500/10 animate-pulse delay-150"></div>
                    </div>
                    <p class="text-[10px] text-slate-500 font-mono uppercase tracking-[2px]">
                        Engine Status: <span class="text-blue-400">Optimized</span> — Last Update: 2 hours ago by Admin_X
                    </p>
                </div>
            </div>

            <div class="fixed bottom-6 left-1/2 -translate-x-1/2 w-[90%] bg-slate-900/90 backdrop-blur-xl border border-white/10 rounded-2xl p-4 flex gap-4 xl:hidden z-50 shadow-2xl">
                <button class="flex-1 py-3 text-[10px] font-black uppercase tracking-widest text-slate-400">Discard All</button>
                <button onclick="showImpactReport()" class="flex-1 py-3 bg-blue-600 rounded-xl text-[10px] font-black uppercase tracking-widest text-white shadow-lg shadow-blue-500/20">Apply Changes</button>
            </div>

            <div id="impact-modal" class="fixed inset-0 z-[100] hidden items-center justify-center p-6 backdrop-blur-md bg-black/60">
                <div class="bg-slate-900 border border-white/10 rounded-[2.5rem] max-w-md w-full p-10 shadow-2xl">
                    <h4 class="text-xl font-black text-white mb-4 uppercase">Impact Report</h4>
                    <p class="text-slate-400 text-sm mb-8 leading-relaxed">Thay đổi này sẽ ảnh hưởng đến <span class="text-orange-500 font-bold">1,250</span> phiên đấu giá đang diễn ra. Thời gian kết thúc sẽ được tính toán lại.</p>

                    <div class="space-y-4 mb-10">
                        <div class="flex justify-between text-[10px] font-mono border-b border-white/5 pb-2">
                            <span class="text-slate-500">AFFECTED SESSIONS</span>
                            <span class="text-white">1,250</span>
                        </div>
                        <div class="flex justify-between text-[10px] font-mono border-b border-white/5 pb-2">
                            <span class="text-slate-500">ESTIMATED SYNC TIME</span>
                            <span class="text-white">450ms</span>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <button onclick="closeModal()" class="flex-1 py-4 text-[10px] font-black uppercase tracking-widest text-slate-500 hover:text-white transition-colors">Abort</button>
                        <button onclick="confirmApply()" class="flex-1 py-4 bg-blue-600 rounded-2xl text-[10px] font-black uppercase tracking-widest text-white">Confirm & Apply</button>
                    </div>
                </div>
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
    // 1. Focus Highlight & Dimming
    function focusEngine(el) {
        gsap.to("#engine-grid > div:not(.group)", {
            opacity: 0.2,
            scale: 0.95,
            duration: 0.4
        });
        gsap.to(el.closest('.config-card'), {
            opacity: 1,
            scale: 1.02,
            borderColor: '#00D1FF33',
            duration: 0.4
        });
    }

    function blurEngine(el) {
        gsap.to("#engine-grid > div", {
            opacity: 1,
            scale: 1,
            borderColor: '',
            duration: 0.4
        });
    }

    // 2. Slider Update & Haptic
    function updateSlider(el, targetId) {
        document.getElementById(targetId).innerText = el.value + (targetId.includes('fee') ? '%' : '%');

        // Haptic feedback giả lập khi qua mốc 10, 20, 50...
        if (el.value % 10 === 0 && window.navigator.vibrate) {
            window.navigator.vibrate(10);
        }
    }

    // 3. Mechanical Click Sound Simulation
    function playClick() {
        if (window.navigator.vibrate) window.navigator.vibrate(5);
        // Có thể chèn audio click thực tế ở đây
    }

    // 4. Modal Logic
    function showImpactReport() {
        const modal = document.getElementById('impact-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        gsap.from(modal.querySelector('div'), {
            scale: 0.8,
            opacity: 0,
            y: 20,
            duration: 0.5,
            ease: "expo.out"
        });
    }

    function closeModal() {
        const modal = document.getElementById('impact-modal');
        gsap.to(modal.querySelector('div'), {
            scale: 0.8,
            opacity: 0,
            duration: 0.3,
            onComplete: () => modal.classList.add('hidden')
        });
    }

    function confirmApply() {
        alert("Parameters Synced Successfully.");
        closeModal();
    }

    // ----------------------------- section 2 ----------------------------- //

    // ----------------------------- section 3 ----------------------------- //

    // ----------------------------- section 4 ----------------------------- //

    // ----------------------------- section 5 ----------------------------- //

    // ----------------------------- section 6 ----------------------------- //
</script>

</html>