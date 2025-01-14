<footer class="footer">
    <div class="container">
        <div class="our-providers">
            <img src="{{asset('images/noodlebox/gys-111-600x76.avif')}}" alt="">
        </div>
        <div class="footer-row">
            <div class="social-icons">
                <a href="mailto:info@thenoodlebox.ie" class="social-icon">
                    <i class="bi bi-envelope"></i>
                </a>
                <a href="https://www.facebook.com/noodlebox.dao" target="_blank" class="social-icon">
                    <i class="bi bi-facebook"></i>
                </a>
                <a href="https://www.instagram.com/noodlebox_drogheda/" target="_blank" class="social-icon">
                    <i class="bi bi-instagram"></i>
                </a>
                <a href="tel:0419845775" class="social-icon">
                    <i class="bi bi-telephone-fill"></i>
                </a>
                <a href="https://www.youtube.com/channel/UC5lWEK3xzjWtK0DPerbI_kw?view_as=subscriber" target="_blank"
                   class="social-icon">
                    <i class="bi bi-youtube"></i>
                </a>
            </div>
            <div class="copyright">
                {{settings('copyright')}}
            </div>
        </div>
    </div>
</footer>
<div class="tabbar-wrapper">
    <div class="tabbar">
        <a href="{{url('cart')}}" class="tabbar-item">
            <i class="bi bi-cart-fill tabbar-item__icon">
                <span class="badge cart-count">0</span>
            </i>
            <span>Cart</span>
        </a>
        <a class="tabbar-item" data-show-lottery="true">
            <i class="bi bi-bag-heart tabbar-item__icon"></i>
            <span>Lottery</span>
        </a>
        <a href="{{url('shop')}}" class="tabbar-item">
            <i class="bi bi-grid-fill tabbar-item__icon"></i>
            <span>Menus</span>
        </a>
        <a href="{{url('points-mall')}}" class="tabbar-item">
            <i class="bi bi-gift-fill tabbar-item__icon"></i>
            <span>Points Mall</span>
        </a>
        <a href="{{url('my-account')}}" class="tabbar-item">
            <i class="bi bi-person-fill tabbar-item__icon">
                @guest
                    <span class="badge">0</span>
                @else
                    <span class="badge">{{auth()->user()->points}}</span>
                @endguest
            </i>
            <span>Mine</span>
        </a>
    </div>
</div>