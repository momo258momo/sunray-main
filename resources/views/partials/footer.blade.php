<!-- Thêm Font Awesome vào head của layout nếu chưa có -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

<footer class="footer bg-dark text-light pt-5 pb-3" style="margin-top: 100px;">
    <div class="container">
        <div class="row">

            <!-- Thông tin công ty -->
            <div class="col-md-4 mb-4">
                <h5 class="mb-3">EYEON</h5>
                <p>21 Lê Thiện Trị, Hoà Hải, Ngũ Hành Sơn, Đà Nẵng 550000, Việt Nam</p>
                <p>Email: <a href="mailto:support@eyeon.vn" class="text-light">support@eyeon.vn</a></p>
                <p>Hotline: <a href="tel:+840123456789" class="text-light">+84 0123 456 789</a></p>
            </div>

            <!-- Liên kết nhanh -->
            <div class="col-md-4 mb-4">
                <h5 class="mb-3">Liên kết nhanh</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-light">Chính sách bảo mật</a></li>
                    <li><a href="#" class="text-light">Chính sách đổi trả</a></li>
                    <li><a href="#" class="text-light">Điều khoản sử dụng</a></li>
                    <li><a href="#" class="text-light">Hướng dẫn mua hàng</a></li>
                    <li><a href="#" class="text-light">FAQ</a></li>
                </ul>
            </div>

            <!-- Mạng xã hội -->
            <div class="col-md-4 mb-4">
                <h5 class="mb-3">Kết nối với chúng tôi</h5>
                <div class="d-flex gap-3">
                    <a href="https://facebook.com/eyeon.vn" class="text-light fs-5"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://instagram.com/eyeon.vn" class="text-light fs-5"><i class="fab fa-instagram"></i></a>
                    <a href="https://tiktok.com/@eyeon.vn" class="text-light fs-5"><i class="fab fa-tiktok"></i></a>
                    <a href="https://youtube.com/@eyeon.vn" class="text-light fs-5"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

        </div>

        <hr class="bg-secondary">

        <!-- Bản quyền -->
        <div class="text-center small">
            &copy; {{ date('Y') }} EYEON. All Rights Reserved.
        </div>
    </div>
</footer>
