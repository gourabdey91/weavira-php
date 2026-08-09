<nav class="myaccount-nav-card" aria-label="Account pages">
  <ul>
    @foreach(wc_get_account_menu_items() as $endpoint => $label)
      <li class="myaccount-nav-item @if(wc_is_current_account_menu_item($endpoint)) is-active @endif">
        <a href="{{ wc_get_account_endpoint_url($endpoint) }}" @if(wc_is_current_account_menu_item($endpoint)) aria-current="page" @endif>
          {{ $label }}
        </a>
      </li>
    @endforeach
  </ul>
</nav>
