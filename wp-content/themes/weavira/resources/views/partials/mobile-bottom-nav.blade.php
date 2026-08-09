{{-- Mobile bottom navigation — hidden on desktop via CSS. Shared partial so
     it can render both from the normal site footer (sections/footer.blade.php)
     and from full-bleed, no-footer pages like page-moments.blade.php that
     still want it available. --}}
<nav class="mobile-bottom-nav" aria-label="Mobile navigation">

    <a class="mobile-bottom-nav-item @if(is_front_page()) active @endif" href="{{ home_url('/') }}">
        <span class="mobile-bottom-nav-icon">
            <i data-lucide="home" aria-hidden="true"></i>
        </span>
        <span class="mobile-bottom-nav-label">Home</span>
    </a>

    <a class="mobile-bottom-nav-item @if(is_page('moments')) active @endif" href="{{ get_permalink(get_page_by_path('moments')) }}">
        <span class="mobile-bottom-nav-icon">
            <i data-lucide="clapperboard" aria-hidden="true"></i>
        </span>
        <span class="mobile-bottom-nav-label">Moments</span>
    </a>

    <a class="mobile-bottom-nav-item" href="#" aria-label="Search">
        <span class="mobile-bottom-nav-icon">
            <i data-lucide="search" aria-hidden="true"></i>
        </span>
        <span class="mobile-bottom-nav-label">Search</span>
    </a>

    <a class="mobile-bottom-nav-item" href="{{ $wishlistUrl }}">
        <span class="mobile-bottom-nav-icon">
            <i data-lucide="heart" aria-hidden="true"></i>
        </span>
        <span class="mobile-bottom-nav-label">Wishlist</span>
    </a>

    <a class="mobile-bottom-nav-item" href="{{ wc_get_page_permalink('myaccount') }}">
        <span class="mobile-bottom-nav-icon">
            <i data-lucide="user" aria-hidden="true"></i>
        </span>
        <span class="mobile-bottom-nav-label">Account</span>
    </a>

</nav>
