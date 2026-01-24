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
            background-color: var(--maunen);
            margin: 0;
            padding: 0;
        }

        :root {
            --maunen: #90cbff;
        }

        /* ----------------------------- section 1 -----------------------------  */
        button {
            -webkit-tap-highlight-color: transparent;
        }

        /* Hiệu ứng 3D lật thiết bị */
        .flip-device {
            transform: rotateY(180deg);
        }

        /* Kéo thả biến số */
        .tag-highlight {
            background: #4f46e5;
            color: white;
            padding: 0 4px;
            border-radius: 4px;
            box-shadow: 0 0 10px rgba(79, 70, 229, 0.4);
        }

        /* Hiệu ứng máy bay giấy */
        .airplane-fly {
            animation: flyOut 1.5s forwards;
        }

        @keyframes flyOut {
            0% {
                transform: translate(-50%, -50%) scale(1);
                opacity: 1;
            }

            30% {
                transform: translate(100px, -150px) rotate(-15deg) scale(1.2);
                opacity: 1;
            }

            100% {
                transform: translate(400px, -400px) rotate(-30deg) scale(0);
                opacity: 0;
            }
        }

        /* ----------------------------- section 2 -----------------------------  */
        /* Hiệu ứng trượt Toggle Emerald */
        .toggle-emerald:checked+div {
            background-color: #10b981;
            box-shadow: 0 0 15px rgba(16, 185, 129, 0.3);
        }

        /* Hiệu ứng lật Currency */
        .flipped {
            transform: rotateX(360deg);
        }

        /* Minimalist Grid Dividers */
        @media (min-width: 1280px) {
            .xl-grid-divide {
                grid-template-columns: repeat(3, 1fr);
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
        <section id="comm-engine" class="py-20 px-4 md:px-10 bg-[#90cbff] text-slate-900 overflow-hidden">
            <div class="max-w-7xl mx-auto">

                <div class="flex flex-col md:flex-row justify-between items-start mb-12 gap-6">
                    <div>
                        <h2 class="text-3xl font-black tracking-tighter uppercase flex items-center gap-3 text-slate-900">
                            <i class="ri-message-3-fill text-indigo-600"></i>
                            Communication Lab
                        </h2>
                        <p class="text-slate-500 font-mono text-[10px] mt-2 uppercase tracking-[3px]">Automated Trigger & Intelligence Messaging</p>
                    </div>

                    <div class="flex gap-8 bg-white p-4 rounded-2xl shadow-sm border border-slate-100">
                        <div class="text-center">
                            <p class="text-[8px] font-black text-slate-400 uppercase mb-1">Delivery Rate</p>
                            <div class="text-sm font-bold text-emerald-500">99.8%</div>
                        </div>
                        <div class="text-center border-l border-slate-100 pl-8">
                            <p class="text-[8px] font-black text-slate-400 uppercase mb-1">Open Rate</p>
                            <div class="text-sm font-bold text-indigo-600">84.2%</div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 xl:grid-cols-12 gap-10 items-start">

                    <div class="xl:col-span-7 space-y-6">

                        <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-200/60">
                            <div class="flex justify-between items-center mb-8">
                                <h3 class="text-xs font-black uppercase tracking-widest text-slate-400">Automation Scenarios</h3>
                                <div class="flex bg-slate-100 p-1 rounded-xl relative w-fit">
                                    <div id="lang-indicator" class="absolute top-1 left-1 bottom-1 w-[32px] bg-white shadow-sm rounded-lg transition-all duration-300 ease-out"></div>

                                    <button onclick="switchLang('vn', this)" class="relative z-10 px-3 py-1 text-[10px] font-bold transition-colors duration-300 text-slate-900">VN</button>
                                    <button onclick="switchLang('en', this)" class="relative z-10 px-3 py-1 text-[10px] font-bold transition-colors duration-300 text-slate-400">EN</button>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-4 hover:bg-slate-50 rounded-2xl transition-all border border-transparent hover:border-slate-100 group">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600">
                                            <i class="ri-trophy-line"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold">Auction Win Confirmation</p>
                                            <p class="text-[10px] text-slate-400 italic">Frequency Cap: 1/hr</p>
                                        </div>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" checked class="sr-only peer" onchange="toggleScenario(this, 'Auction Win')">
                                        <div class="w-10 h-5 bg-slate-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:bg-indigo-600 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all shadow-inner"></div>
                                    </label>
                                </div>

                                <div class="flex items-center justify-between p-4 hover:bg-slate-50 rounded-2xl transition-all border border-transparent hover:border-slate-100 group">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-full bg-orange-50 flex items-center justify-center text-orange-600 transition-all duration-300">
                                            <i class="ri-alarm-warning-line"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold">Outbid Alert</p>
                                            <p class="text-[10px] text-slate-400 italic">Immediate Trigger</p>
                                        </div>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" class="sr-only peer" onchange="toggleOutbid(this)">
                                        <div class="w-10 h-5 bg-slate-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:bg-orange-500 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all shadow-inner"></div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-200/60 relative">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-xs font-black uppercase tracking-widest text-slate-400">Content Editor</h3>
                                <div class="flex gap-2">
                                    <button onclick="switchDevice('sms')" class="p-2 text-indigo-600 bg-indigo-50 rounded-lg"><i class="ri-smartphone-line"></i></button>
                                    <button onclick="switchDevice('mail')" class="p-2 text-slate-400 hover:bg-slate-50 rounded-lg"><i class="ri-mail-line"></i></button>
                                </div>
                            </div>

                            <div class="flex flex-wrap gap-2 mb-4">
                                <div draggable="true" ondragstart="drag(event)" class="px-3 py-1.5 bg-indigo-600 text-white text-[10px] font-bold rounded-lg cursor-grab active:cursor-grabbing shadow-sm hover:shadow-indigo-200 transition-all">
                                    {{Customer_Name}}
                                </div>
                                <div draggable="true" ondragstart="drag(event)" class="px-3 py-1.5 bg-indigo-600 text-white text-[10px] font-bold rounded-lg cursor-grab shadow-sm">
                                    {{Plate_Number}}
                                </div>
                                <div draggable="true" ondragstart="drag(event)" class="px-3 py-1.5 bg-indigo-600 text-white text-[10px] font-bold rounded-lg cursor-grab shadow-sm">
                                    {{Closing_Price}}
                                </div>
                            </div>

                            <div class="relative">
                                <textarea id="editor-textarea" oninput="updatePreview(this.value)" class="w-full h-40 bg-slate-50 border border-slate-100 rounded-2xl p-6 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition-all font-medium" placeholder="Nhập nội dung thông báo..."></textarea>
                                <div id="syntax-alert" class="absolute bottom-4 right-4 text-[10px] font-bold text-rose-500 hidden items-center gap-1">
                                    <i class="ri-error-warning-fill"></i> Invalid Variable Syntax
                                </div>
                            </div>

                            <div class="mt-8 pt-6 border-t border-slate-50">
                                <div class="flex justify-between items-center mb-4">
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">AI Tone of Voice</span>
                                    <span class="text-[10px] font-bold text-indigo-600 uppercase" id="tone-label">Professional</span>
                                </div>
                                <input type="range" class="w-full accent-indigo-600 h-1 bg-slate-100 rounded-lg appearance-none cursor-pointer" oninput="document.getElementById('tone-label').innerText = this.value > 50 ? 'Friendly' : 'Professional'">
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <button id="save-draft-btn" onclick="saveDraftAnim()" class="flex-1 py-4 bg-white border border-slate-200 rounded-2xl text-[10px] font-black uppercase tracking-[2px] text-slate-500 hover:bg-slate-50 transition-all flex items-center justify-center gap-2 overflow-hidden relative">
                                <span class="save-text">Save Draft</span>
                                <i class="ri-loader-4-line animate-spin hidden"></i>
                                <i class="ri-check-line text-emerald-500 hidden"></i>
                            </button>
                            <button id="publish-btn" onclick="sendTestAnim()" class="flex-[2] py-4 bg-indigo-600 rounded-2xl text-[10px] font-black uppercase tracking-[2px] text-white shadow-xl shadow-indigo-200 hover:bg-indigo-700 transition-all relative overflow-hidden">
                                <span class="btn-text">Publish Changes</span>
                                <i class="ri-send-plane-fill absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 opacity-0 airplane-icon"></i>
                            </button>
                           
                        </div>
                         <button onclick="pushNotification()" class="mt-6 w-full py-4 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 active:scale-[0.98] transition-all shadow-lg shadow-indigo-200">
                                GỬI THÔNG BÁO NGAY <i class="ri-send-plane-fill ml-2"></i>
                            </button>
                    </div>

                    <div class="xl:col-span-5 flex flex-col items-center">
                        <div id="device-perspective" class="relative transition-all duration-700" style="perspective: 1500px;">

                            <div id="preview-card" class="w-[300px] h-[600px] bg-slate-900 rounded-[3rem] p-3 shadow-2xl border-[6px] border-slate-800 relative transition-all duration-700">
                                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-32 h-6 bg-slate-800 rounded-b-2xl z-20"></div>

                                <div class="w-full h-full bg-white rounded-[2.2rem] overflow-hidden relative">
                                    <div class="p-6 pt-12">
                                        <div class="flex items-center gap-3 mb-6">
                                            <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center text-white text-xs font-bold">V</div>
                                            <div>
                                                <p class="text-[10px] font-bold">V-Auction</p>
                                                <p class="text-[8px] text-slate-400">Just now</p>
                                            </div>
                                        </div>

                                        <div id="live-text" class="text-xs leading-relaxed text-slate-700 bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                            Chúc mừng <span class="text-indigo-600 font-bold">Hoàng Nguyễn</span>! Bạn đã thắng đấu giá biển số <span class="text-indigo-600 font-bold">30K-888.88</span>.
                                        </div>
                                    </div>

                                    <div class="absolute bottom-0 w-full p-4 bg-slate-50 border-t border-slate-100 xl:hidden">
                                        <div class="flex gap-2">
                                            <button class="flex-1 bg-white border border-slate-200 py-2 rounded text-[8px] font-bold">{{Name}}</button>
                                            <button class="flex-1 bg-white border border-slate-200 py-2 rounded text-[8px] font-bold">{{Plate}}</button>
                                            <button class="flex-1 bg-white border border-slate-200 py-2 rounded text-[8px] font-bold">{{Price}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <p class="mt-8 text-[10px] font-black text-slate-300 uppercase tracking-[4px]">Live Smart Preview</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ----------------------------- section 2 -----------------------------  -->
        <section id="fiscal-policy" class="py-20 px-4 md:px-10 bg-[#90cbff] text-slate-900 border-t border-slate-100">
            <div class="max-w-7xl mx-auto">

                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-16 gap-6">
                    <div>
                        <h2 class="text-3xl font-black tracking-tighter uppercase flex items-center gap-3">
                            <i class="ri-global-line text-emerald-600"></i>
                            Localization Matrix
                        </h2>
                        <p class="text-slate-400 font-mono text-[10px] mt-2 uppercase tracking-[3px]">Fiscal Policy & Regional Governance</p>
                    </div>

                    <div class="flex gap-4 bg-slate-50 p-2 rounded-2xl border border-slate-100">
                        <div class="px-4 py-2 bg-white rounded-xl shadow-sm">
                            <p class="text-[8px] font-black text-slate-400 uppercase">System (ICT)</p>
                            <p class="text-sm font-bold font-mono text-emerald-600">14:20:45</p>
                        </div>
                        <div class="px-4 py-2">
                            <p class="text-[8px] font-black text-slate-400 uppercase">Local Time</p>
                            <p class="text-sm font-bold font-mono text-slate-400">07:20:45</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-0 border border-slate-200 rounded-[2.5rem] overflow-hidden bg-slate-50/30">

                    <div class="p-10 border-b md:border-b-0 md:border-r border-slate-200 bg-white group transition-all duration-500">
                        <div class="flex justify-between items-start mb-10">
                            <h3 class="text-xs font-black uppercase tracking-widest text-slate-400">Currency & Rates</h3>
                            <div class="flex items-center gap-2 px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full">
                                <span class="text-[8px] font-bold">AUTO-SYNC</span>
                                <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 relative overflow-hidden cursor-pointer" onclick="flipCurrency()">
                                <div id="currency-display" class="transition-all duration-500">
                                    <p class="text-[10px] font-bold text-slate-400">1 USD Equivalent</p>
                                    <p class="text-2xl font-black text-slate-900 mt-1 font-mono">24,550 <span class="text-xs font-medium text-slate-400">VND</span></p>
                                </div>
                            </div>

                            <div class="flex items-center justify-between p-4 border border-dashed border-orange-200 rounded-2xl bg-orange-50/30">
                                <div>
                                    <p class="text-[10px] font-bold text-orange-600 uppercase">Volatility Guard</p>
                                    <p class="text-[8px] text-orange-400 font-medium">Alert if rate changes > 3%</p>
                                </div>
                                <input type="checkbox" checked class="accent-orange-500">
                            </div>
                            <button onclick="openRateModal()" class="w-full py-3 border border-slate-200 rounded-xl text-[10px] font-black uppercase tracking-widest text-slate-500 hover:bg-slate-50 transition-all">
                                Manual Rate Entry
                            </button>

                            <div id="rate-modal" class="fixed inset-0 z-[150] flex items-center justify-center hidden opacity-0 transition-all duration-300">
                                <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeRateModal()"></div>
                                <div class="relative w-[90%] max-w-md bg-white rounded-[2.5rem] p-8 shadow-2xl border border-slate-100">
                                    <div class="flex justify-between items-center mb-6">
                                        <h3 class="text-xs font-black uppercase tracking-widest text-slate-400">Manual Exchange Rate</h3>
                                        <button onclick="closeRateModal()" class="text-slate-400 hover:text-slate-900">
                                            <i class="ri-close-line text-2xl"></i>
                                        </button>
                                    </div>

                                    <div class="space-y-6">
                                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100">
                                            <label class="text-[10px] font-black text-slate-400 uppercase mb-2 block">New USD/VND Rate</label>
                                            <div class="flex items-end gap-3">
                                                <input type="number" id="manual-rate-input" placeholder="24550"
                                                    class="bg-transparent text-3xl font-black text-slate-900 w-full focus:outline-none border-b-2 border-slate-200 focus:border-emerald-500 pb-2 transition-all font-mono">
                                                <span class="text-xs font-bold text-slate-400 mb-3">VND</span>
                                            </div>
                                        </div>

                                        <div class="flex gap-3">
                                            <button onclick="closeRateModal()" class="flex-1 py-4 bg-slate-100 rounded-2xl text-[10px] font-black uppercase tracking-widest text-slate-500">Cancel</button>
                                            <button onclick="applyManualRate()" class="flex-[2] py-4 bg-emerald-600 rounded-2xl text-[10px] font-black uppercase tracking-widest text-white shadow-lg shadow-emerald-200">Confirm Change</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-10 border-b xl:border-b-0 xl:border-r border-slate-200 bg-white relative">
                        <h3 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-8">Tax & Regional Fees</h3>

                        <div class="flex gap-6 items-center mb-8">
                            <div class="w-24 h-32 bg-slate-100 rounded-xl relative flex items-center justify-center overflow-hidden border border-slate-200">
                                <i class="ri-map-pin-line text-slate-300 text-3xl"></i>
                                <div id="region-highlight" class="absolute inset-0 bg-emerald-500/10 opacity-0 transition-opacity"></div>
                            </div>

                            <div class="flex-1 space-y-3">
                                <select onchange="highlightRegion()" class="w-full bg-transparent border-b border-slate-200 py-2 text-xs font-bold focus:outline-none focus:border-emerald-500">
                                    <option>Khu vực I (Hà Nội, HCM)</option>
                                    <option>Khu vực II (Tỉnh lỵ)</option>
                                    <option>Khu vực III (Khác)</option>
                                </select>
                                <div class="flex justify-between">
                                    <span class="text-[10px] text-slate-400">Registration Fee</span>
                                    <span class="text-[10px] font-bold">20,000,000đ</span>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 bg-emerald-500 text-white rounded-[1.5rem] shadow-lg shadow-emerald-200">
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-[10px] font-black uppercase tracking-widest opacity-80">Next VAT Change</span>
                                <i class="ri-calendar-event-line"></i>
                            </div>
                            <p class="text-lg font-black font-mono">10% → 8%</p>
                            <p class="text-[8px] font-bold opacity-70 mt-1 uppercase">Effective: 01/02/2026 - 00:00</p>
                        </div>
                    </div>

                    <div class="p-10 bg-white md:col-span-2 xl:col-span-1">
                        <h3 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-8">Fiscal Intelligence</h3>

                        <div class="space-y-6">
                            <div class="p-6 bg-slate-900 rounded-[2rem] text-white">
                                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Tax Simulator</p>
                                <div class="space-y-4">
                                    <div class="relative">
                                        <input type="text" placeholder="Winning Price..." class="w-full bg-white/10 border border-white/10 rounded-xl px-4 py-3 text-sm font-mono focus:outline-none">
                                    </div>
                                    <div class="pt-4 border-t border-white/5 space-y-2">
                                        <div class="flex justify-between text-[10px]">
                                            <span class="text-slate-500">Net Revenue</span>
                                            <span class="font-bold text-emerald-400">92.0%</span>
                                        </div>
                                        <div class="flex justify-between text-[10px]">
                                            <span class="text-slate-500">Total Tax & Fees</span>
                                            <span class="font-bold">8.0%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-4 p-4 border border-slate-100 rounded-2xl hover:bg-slate-50 transition-all cursor-pointer">
                                <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                                    <i class="ri-calendar-check-line"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold">Holiday Scheduler</p>
                                    <p class="text-[9px] text-slate-400">Automatic auction postponement</p>
                                </div>
                                <i class="ri-arrow-right-s-line ml-auto text-slate-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="md:hidden mt-10 space-y-2">
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
    // 1. Live Preview & Syntax Checker
    function updatePreview(val) {
        const liveDisplay = document.getElementById('live-text');
        const alertBox = document.getElementById('syntax-alert');
        const publishBtn = document.getElementById('publish-btn');

        // Kiểm tra Syntax lỗi (Quên đóng ngoặc)
        const hasError = /\{\{[^}]*$/.test(val);

        if (hasError) {
            alertBox.classList.remove('hidden');
            alertBox.classList.add('flex');
            publishBtn.classList.add('opacity-50', 'pointer-events-none');
        } else {
            alertBox.classList.add('hidden');
            publishBtn.classList.remove('opacity-50', 'pointer-events-none');
        }

        // Highlight tags trong preview
        let highlightedText = val
            .replace(/\{\{Customer_Name\}\}/g, '<span class="text-indigo-600 font-bold">Hoàng Nguyễn</span>')
            .replace(/\{\{Plate_Number\}\}/g, '<span class="text-indigo-600 font-bold">30K-888.88</span>')
            .replace(/\{\{Closing_Price\}\}/g, '<span class="text-indigo-600 font-bold">2.5 tỷ VND</span>');

        liveDisplay.innerHTML = highlightedText || "Nhập nội dung để xem trước...";
    }

    // 2. Drag & Drop Tags
    function drag(ev) {
        ev.dataTransfer.setData("text", ev.target.innerText.trim());
    }

    // Cho phép thả vào textarea
    document.getElementById('editor-textarea').addEventListener('drop', function(ev) {
        ev.preventDefault();
        const tag = ev.dataTransfer.getData("text");
        this.value += tag;
        updatePreview(this.value);
    });

    // Biến lưu loại thiết bị đang chọn (Mặc định là Push)
    let currentType = 'Push';

    function switchDevice(device) {
        // Chuyển đổi tên để khớp với ENUM trong Database của bạn
        if (device === 'sms') currentType = 'SMS';
        else if (device === 'mail') currentType = 'Email';
        else currentType = 'Push';

        // UI Feedback: Đổi màu icon/button
        document.querySelectorAll('.flex.gap-2 button').forEach(btn => {
            btn.classList.remove('text-indigo-600', 'bg-indigo-50');
            btn.classList.add('text-slate-400');
        });
        event.currentTarget.classList.add('text-indigo-600', 'bg-indigo-50');
    }

    // 4. Send Test Animation
    function sendTestAnim() {
        const btn = document.getElementById('publish-btn');
        const text = btn.querySelector('.btn-text');
        const icon = btn.querySelector('.airplane-icon');

        text.style.opacity = '0';
        icon.classList.add('airplane-fly');
        icon.style.opacity = '1';

        if (window.navigator.vibrate) window.navigator.vibrate([30, 50, 30]);

        setTimeout(() => {
            alert("Notification Published & Live on Server.");
            text.style.opacity = '1';
            icon.classList.remove('airplane-fly');
            icon.style.opacity = '0';
        }, 1500);
    }

    function pushNotification() {
        const textarea = document.getElementById('editor-textarea');
        const content = textarea.value;

        if (!content.trim()) {
            alert("Vui lòng nhập nội dung thông báo!");
            return;
        }

        const formData = new FormData();
        formData.append('content', content);
        formData.append('type', currentType);

        // Hiệu ứng loading nút bấm
        const btn = event.currentTarget;
        const originalText = btn.innerHTML;
        btn.innerText = "Đang gửi...";
        btn.disabled = true;

        fetch('push_notification_action.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(data.message);
                    textarea.value = ''; // Xóa nội dung sau khi gửi
                } else {
                    alert("Lỗi: " + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert("Lỗi kết nối server!");
            })
            .finally(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
    }

    function hapticFeedback() {
        if (window.navigator.vibrate) window.navigator.vibrate(15);
    }

    function switchLang(lang, btn) {
        const indicator = document.getElementById('lang-indicator');
        const buttons = btn.parentElement.querySelectorAll('button');
        const textArea = document.getElementById('editor-textarea');

        // 1. Hiệu ứng trượt và đổi màu chữ
        indicator.style.left = btn.offsetLeft + 'px';
        indicator.style.width = btn.offsetWidth + 'px';

        buttons.forEach(b => b.classList.add('text-slate-400'));
        btn.classList.remove('text-slate-400');
        btn.classList.add('text-slate-900');

        // 2. Thay đổi nội dung mẫu trong Textarea & Preview tùy theo ngôn ngữ
        if (lang === 'en') {
            textArea.value = "Congratulations {{Customer_Name}}! You won the auction for plate {{Plate_Number}}.";
        } else {
            textArea.value = "Chúc mừng {{Customer_Name}}! Bạn đã thắng đấu giá biển số {{Plate_Number}}.";
        }

        // Cập nhật lại màn hình điện thoại
        updatePreview(textArea.value);

        // Haptic feedback nhẹ
        if (window.navigator.vibrate) window.navigator.vibrate(5);
    }

    function toggleScenario(checkbox, scenarioName) {
        // 1. Rung phản hồi (Haptic Feedback)
        if (window.navigator.vibrate) {
            window.navigator.vibrate(checkbox.checked ? [10, 30, 10] : 10);
        }

        // 2. Hiệu ứng làm mờ/sáng Icon của scenario đó
        const parentRow = checkbox.closest('.flex.items-center.justify-between');
        const iconBox = parentRow.querySelector('.rounded-full');

        if (checkbox.checked) {
            gsap.to(iconBox, {
                opacity: 1,
                scale: 1,
                duration: 0.3
            });
            console.log(`${scenarioName} Enabled`);
        } else {
            gsap.to(iconBox, {
                opacity: 0.4,
                scale: 0.9,
                duration: 0.3
            });
            console.log(`${scenarioName} Disabled`);
        }

        // 3. (Tùy chọn) Hiện một Toast thông báo nhỏ ở góc màn hình
        showToast(`${scenarioName} is now ${checkbox.checked ? 'ON' : 'OFF'}`);
    }

    // Hàm hỗ trợ hiện thông báo nhanh
    function showToast(msg) {
        let toast = document.createElement('div');
        toast.className = "fixed bottom-10 right-10 bg-slate-900 text-white text-[10px] px-4 py-2 rounded-lg z-[200] font-bold tracking-widest pointer-events-none opacity-0";
        toast.innerText = msg.toUpperCase();
        document.body.appendChild(toast);

        gsap.to(toast, {
            opacity: 1,
            y: -20,
            duration: 0.3
        });
        gsap.to(toast, {
            opacity: 0,
            y: -40,
            delay: 2,
            duration: 0.3,
            onComplete: () => toast.remove()
        });
    }

    function toggleOutbid(checkbox) {
        const parentRow = checkbox.closest('.flex.items-center.justify-between');
        const iconBox = parentRow.querySelector('.rounded-full');
        const liveText = document.getElementById('live-text');

        if (checkbox.checked) {
            // 1. Hiệu ứng bật
            gsap.to(iconBox, {
                backgroundColor: '#fff7ed',
                color: '#ea580c',
                opacity: 1,
                scale: 1,
                duration: 0.3
            });
            if (window.navigator.vibrate) window.navigator.vibrate([20, 50, 20]);

            // 2. Giả lập hiển thị lên điện thoại preview
            const originalText = liveText.innerHTML;
            gsap.to(liveText, {
                opacity: 0,
                x: -20,
                duration: 0.2,
                onComplete: () => {
                    liveText.innerHTML = `<span class="text-orange-600 font-bold"><i class="ri-error-warning-fill"></i> CẢNH BÁO:</span> Có người vừa trả giá cao hơn bạn cho biển số 30K-888.88!`;
                    gsap.to(liveText, {
                        opacity: 1,
                        x: 0,
                        duration: 0.3
                    });
                }
            });

            // Tự động quay lại text cũ sau 3 giây
            setTimeout(() => {
                gsap.to(liveText, {
                    opacity: 0,
                    duration: 0.5,
                    onComplete: () => {
                        liveText.innerHTML = originalText;
                        gsap.to(liveText, {
                            opacity: 1,
                            duration: 0.5
                        });
                    }
                });
            }, 3000);

        } else {
            // 3. Hiệu ứng tắt
            gsap.to(iconBox, {
                backgroundColor: '#f1f5f9',
                color: '#94a3b8',
                opacity: 0.5,
                scale: 0.9,
                duration: 0.3
            });
            if (window.navigator.vibrate) window.navigator.vibrate(10);
        }


    }

    function saveDraftAnim() {
        const btn = document.getElementById('save-draft-btn');
        const text = btn.querySelector('.save-text');
        const loader = btn.querySelector('.ri-loader-4-line');
        const check = btn.querySelector('.ri-check-line');

        // 1. Trạng thái bắt đầu lưu: Vô hiệu hóa nút và hiện loader
        btn.classList.add('pointer-events-none', 'bg-slate-50');
        text.innerText = "Saving...";
        loader.classList.remove('hidden');

        // Haptic feedback nhẹ khi bắt đầu
        if (window.navigator.vibrate) window.navigator.vibrate(10);
        // Thêm vào trong hàm saveDraftAnim() đoạn này để nút nhỏ lại rồi to ra khi click
        gsap.to(btn, {
            scale: 0.95,
            duration: 0.1,
            yoyo: true,
            repeat: 1
        });

        // 2. Giả lập thời gian phản hồi từ Server
        setTimeout(() => {
            // Ẩn loader, hiện icon Check
            loader.classList.add('hidden');
            check.classList.remove('hidden');
            text.innerText = "Draft Saved";
            text.classList.replace('text-slate-500', 'text-emerald-600');

            // Hiệu ứng hoàn thành mạnh hơn
            if (window.navigator.vibrate) window.navigator.vibrate([20, 10, 20]);

            // 3. Khôi phục trạng thái ban đầu sau 2 giây
            setTimeout(() => {
                gsap.to(btn, {
                    opacity: 1,
                    onComplete: () => {
                        text.innerText = "Save Draft";
                        text.classList.replace('text-emerald-600', 'text-slate-500');
                        check.classList.add('hidden');
                        btn.classList.remove('pointer-events-none', 'bg-slate-50');
                    }
                });
            }, 2000);

        }, 1200);
    }

    // ----------------------------- section 2 ----------------------------- //
    // 1. Currency Flip Animation
    function flipCurrency() {
        const display = document.getElementById('currency-display');
        display.classList.add('flipped');

        if (window.navigator.vibrate) window.navigator.vibrate(5);

        setTimeout(() => {
            display.classList.remove('flipped');
        }, 500);
    }

    // 2. Region Map Highlight
    function highlightRegion() {
        const highlight = document.getElementById('region-highlight');
        highlight.style.opacity = '1';

        // Haptic Feedback for critical fiscal changes
        if (window.navigator.vibrate) window.navigator.vibrate([20, 50, 20]);

        setTimeout(() => {
            highlight.style.opacity = '0.3';
        }, 1000);
    }

    // 3. Simulator Logic (Simplified)
    document.querySelector('input[placeholder="Winning Price..."]').addEventListener('input', function(e) {
        // Giả lập tính toán thời gian thực
        const val = e.target.value;
        if (val > 0) {
            if (window.navigator.vibrate) window.navigator.vibrate(2);
        }
    });
    // 4. Manual Rate Modal Logic
    function openRateModal() {
        const modal = document.getElementById('rate-modal');
        modal.classList.remove('hidden');
        gsap.to(modal, {
            opacity: 1,
            duration: 0.3
        });
        gsap.fromTo(modal.querySelector('.relative'), {
            scale: 0.8,
            y: 20
        }, {
            scale: 1,
            y: 0,
            duration: 0.4,
            ease: "back.out(1.5)"
        });

        // Lấy giá trị hiện tại (ví dụ 24,550) bỏ dấu phẩy để đưa vào input
        const currentRate = document.querySelector('#currency-display p.text-2xl').innerText.split(' ')[0].replace(/,/g, '');
        document.getElementById('manual-rate-input').value = currentRate;
    }

    function closeRateModal() {
        const modal = document.getElementById('rate-modal');
        gsap.to(modal, {
            opacity: 0,
            duration: 0.2,
            onComplete: () => modal.classList.add('hidden')
        });
    }

    function applyManualRate() {
        const newVal = document.getElementById('manual-rate-input').value;
        const displayElement = document.querySelector('#currency-display p.text-2xl');

        if (newVal && newVal > 0) {
            // Cập nhật số hiển thị kèm định dạng dấu phẩy
            displayElement.innerHTML = `${Number(newVal).toLocaleString()} <span class="text-xs font-medium text-slate-400">VND</span>`;

            // Hiệu ứng nháy xanh viền để xác nhận
            const container = displayElement.parentElement;
            gsap.fromTo(container, {
                backgroundColor: "#ecfdf5"
            }, {
                backgroundColor: "#f8fafc",
                duration: 1
            });

            if (window.navigator.vibrate) window.navigator.vibrate([30, 10, 30]);
            closeRateModal();
        } else {
            // Rung lắc input nếu nhập sai
            gsap.to('#manual-rate-input', {
                x: 10,
                repeat: 5,
                yoyo: true,
                duration: 0.05
            });
        }
    }

    // ----------------------------- section 3 ----------------------------- //

    // ----------------------------- section 4 ----------------------------- //

    // ----------------------------- section 5 ----------------------------- //

    // ----------------------------- section 6 ----------------------------- //
</script>

</html>