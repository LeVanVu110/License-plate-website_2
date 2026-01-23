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
        <section id="comm-engine" class="py-20 px-4 md:px-10 bg-[#f8fafc] text-slate-900 overflow-hidden">
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
                                <div class="flex bg-slate-100 p-1 rounded-lg">
                                    <button class="px-3 py-1 text-[10px] font-bold bg-white shadow-sm rounded-md">VN</button>
                                    <button class="px-3 py-1 text-[10px] font-bold text-slate-400">EN</button>
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
                                        <input type="checkbox" checked class="sr-only peer" onchange="hapticFeedback()">
                                        <div class="w-10 h-5 bg-slate-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:bg-indigo-600 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all shadow-inner"></div>
                                    </label>
                                </div>

                                <div class="flex items-center justify-between p-4 hover:bg-slate-50 rounded-2xl transition-all border border-transparent hover:border-slate-100">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-full bg-orange-50 flex items-center justify-center text-orange-600">
                                            <i class="ri-alarm-warning-line"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold">Outbid Alert</p>
                                            <p class="text-[10px] text-slate-400 italic">Immediate Trigger</p>
                                        </div>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" class="sr-only peer">
                                        <div class="w-10 h-5 bg-slate-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:bg-indigo-600 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all shadow-inner"></div>
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
                            <button class="flex-1 py-4 bg-white border border-slate-200 rounded-2xl text-[10px] font-black uppercase tracking-[2px] text-slate-500 hover:bg-slate-50 transition-all">Save Draft</button>
                            <button id="publish-btn" onclick="sendTestAnim()" class="flex-[2] py-4 bg-indigo-600 rounded-2xl text-[10px] font-black uppercase tracking-[2px] text-white shadow-xl shadow-indigo-200 hover:bg-indigo-700 transition-all relative overflow-hidden">
                                <span class="btn-text">Publish Changes</span>
                                <i class="ri-send-plane-fill absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 opacity-0 airplane-icon"></i>
                            </button>
                        </div>
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

        <style>
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
        </style>

        <script>
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

            // 3. Device Switch (Flip 3D)
            function switchDevice(type) {
                const card = document.getElementById('preview-card');
                gsap.to(card, {
                    rotationY: "+=180",
                    duration: 0.8,
                    ease: "back.out(1.2)",
                    onComplete: () => {
                        // Thay đổi giao diện bên trong nếu là Email (giả lập)
                        const screen = card.querySelector('.bg-white');
                        if (type === 'mail') {
                            screen.classList.add('bg-slate-100');
                        } else {
                            screen.classList.remove('bg-slate-100');
                        }
                    }
                });
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

            function hapticFeedback() {
                if (window.navigator.vibrate) window.navigator.vibrate(15);
            }
        </script>

        <!-- ----------------------------- section 2 -----------------------------  -->

        <!-- ----------------------------- section 3 -----------------------------  -->

        <!-- ----------------------------- section 4 -----------------------------  -->

        <!-- ----------------------------- section 5 -----------------------------  -->

        <!-- ----------------------------- section 6 -----------------------------  -->
    </main>

</body>
<script>
    // ----------------------------- section 1 ----------------------------- //

    // ----------------------------- section 2 ----------------------------- //

    // ----------------------------- section 3 ----------------------------- //

    // ----------------------------- section 4 ----------------------------- //

    // ----------------------------- section 5 ----------------------------- //

    // ----------------------------- section 6 ----------------------------- //
</script>

</html>