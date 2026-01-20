<footer id="main-footer" class="relative bg-[#000D1A] text-gray-400 pt-16 pb-8 overflow-hidden border-t border-[#007FFF]/30">
    
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div id="blob-1" class="absolute w-80 h-80 bg-blue-600/10 rounded-full blur-[100px] -bottom-20 -left-20"></div>
        <div id="blob-2" class="absolute w-60 h-60 bg-cyan-500/10 rounded-full blur-[80px] top-20 right-0"></div>
    </div>

    <div class="container mx-auto px-6 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
            
            <div class="footer-col">
                <div class="mb-6">
                    <span class="text-2xl font-extrabold text-white tracking-tighter uppercase">Biển Số <span class="text-[#007FFF]">Đẹp</span></span>
                </div>
                <p class="text-sm leading-relaxed mb-6 italic">
                    "Đơn vị tiên phong định giá và cung ứng biển số định danh số 1 Việt Nam. Uy tín kết tinh từ giá trị thực."
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="social-icon text-xl hover:text-[#007FFF] transition-colors"><i class="ri-facebook-fill"></i></a>
                    <a href="#" class="social-icon text-xl hover:text-[#007FFF] transition-colors"><i class="ri-zalo-line"></i></a>
                    <a href="#" class="social-icon text-xl hover:text-[#007FFF] transition-colors"><i class="ri-tiktok-fill"></i></a>
                </div>
            </div>

            <div class="footer-col">
                <h4 class="text-white font-bold mb-6 flex justify-between items-center group cursor-pointer md:cursor-default" onclick="toggleFooterAcc(this)">
                    DỊCH VỤ <i class="ri-add-line md:hidden transition-transform"></i>
                </h4>
                <ul class="space-y-4 text-sm footer-content hidden md:block">
                    <li><a href="#" class="footer-link inline-block">Hướng dẫn đấu giá</a></li>
                    <li><a href="#" class="footer-link inline-block">Thủ tục thu hồi</a></li>
                    <li><a href="#" class="footer-link inline-block">Sang tên chính chủ</a></li>
                    <li><a href="#" class="footer-link inline-block">Định giá biển số</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4 class="text-white font-bold mb-6 flex justify-between items-center group cursor-pointer md:cursor-default" onclick="toggleFooterAcc(this)">
                    HỖ TRỢ KHÁCH HÀNG <i class="ri-add-line md:hidden transition-transform"></i>
                </h4>
                <ul class="space-y-4 text-sm footer-content hidden md:block">
                    <li><a href="#" class="footer-link inline-block">Chính sách bảo mật</a></li>
                    <li><a href="#" class="footer-link inline-block">Điều khoản giao dịch</a></li>
                    <li><a href="#" class="footer-link inline-block">Câu hỏi thường gặp</a></li>
                    <li><a href="#" class="footer-link inline-block">Khiếu nại dịch vụ</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4 class="text-white font-bold mb-6">LIÊN HỆ</h4>
                <ul class="space-y-4 text-sm">
                    <li class="flex items-start">
                        <i class="ri-map-pin-line mr-3 text-[#007FFF]"></i>
                        <span>HQ: Toà nhà Diamond, Số 1 Liễu Giai, Ba Đình, Hà Nội.</span>
                    </li>
                    <li class="flex items-center">
                        <i class="ri-phone-line mr-3 text-[#007FFF]"></i>
                        <span class="text-white font-bold">1900 8888</span>
                    </li>
                    <li class="pt-4">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/05/Seal_of_the_Ministry_of_Industry_and_Trade_%28Vietnam%29.svg/1200px-Seal_of_the_Ministry_of_Industry_and_Trade_%28Vietnam%29.svg.png" 
                             alt="BCT" 
                             class="h-12 grayscale hover:grayscale-0 transition-all duration-500 cursor-help opacity-70 hover:opacity-100">
                    </li>
                </ul>
            </div>
        </div>

        <hr class="border-gray-800 mb-8">

        <div class="flex flex-col md:flex-row justify-between items-center text-xs tracking-widest uppercase">
            <p id="copyright" class="relative overflow-hidden py-2">
                © 2026 BIEN SO DEP. ALL RIGHTS RESERVED.
                <span id="copyright-glow" class="absolute inset-0 bg-gradient-to-r from-transparent via-[#007FFF]/20 to-transparent -translate-x-full"></span>
            </p>
            <div class="flex space-x-6 mt-4 md:mt-0 opacity-50">
                <span>Designed by AI Partner</span>
                <span>v3.1.0</span>
            </div>
        </div>
    </div>
</footer>

<style>
    /* Hiệu ứng link chân trang */
    .footer-link {
        position: relative;
        transition: color 0.3s ease;
    }
    .footer-link::after {
        content: '';
        position: absolute;
        width: 0;
        height: 1px;
        bottom: -2px;
        left: 0;
        background-color: #007FFF;
        transition: width 0.3s ease;
    }
    .footer-link:hover {
        color: #fff;
    }
    .footer-link:hover::after {
        width: 100%;
    }
</style>

<script>
    // 1. Unfold Reveal (Hiệu ứng mở thảm)
    // gsap.from("#main-footer", {
    //     scrollTrigger: {
    //         trigger: "#main-footer",
    //         start: "top bottom",
    //         toggleActions: "play none none reverse"
    //     },
    //     y: 100,
    //     opacity: 0,
    //     duration: 1.5,
    //     ease: "power4.out"
    // });

    // 2. Floating Blobs (Nền trôi nổi)
    gsap.to("#blob-1", {
        x: 100, y: 50, duration: 10, repeat: -1, yoyo: true, ease: "sine.inOut"
    });
    gsap.to("#blob-2", {
        x: -80, y: -40, duration: 8, repeat: -1, yoyo: true, ease: "sine.inOut", delay: 1
    });

    // 3. Hover Link Magnetic (Nhích chữ sang phải)
    document.querySelectorAll('.footer-link').forEach(link => {
        link.addEventListener('mouseenter', () => {
            gsap.to(link, { x: 8, color: "#ffffff", duration: 0.3 });
        });
        link.addEventListener('mouseleave', () => {
            gsap.to(link, { x: 0, color: "#9ca3af", duration: 0.3 });
        });
    });

    // 4. Copyright Glow Effect
    gsap.to("#copyright-glow", {
        scrollTrigger: {
            trigger: "#copyright",
            start: "top bottom",
        },
        x: "200%",
        duration: 3,
        repeat: -1,
        repeatDelay: 2,
        ease: "power2.inOut"
    });

    // 5. Mobile Accordion Logic
    function toggleFooterAcc(el) {
        if (window.innerWidth >= 768) return;
        const content = el.nextElementSibling;
        const icon = el.querySelector('i');
        
        if (content.classList.contains('hidden')) {
            content.classList.remove('hidden');
            gsap.from(content, { height: 0, opacity: 0, duration: 0.5, ease: "power2.out" });
            gsap.to(icon, { rotate: 45, duration: 0.3 });
        } else {
            gsap.to(content, { height: 0, opacity: 0, duration: 0.3, onComplete: () => content.classList.add('hidden') });
            gsap.to(icon, { rotate: 0, duration: 0.3 });
        }
    }
</script>