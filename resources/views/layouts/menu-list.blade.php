{{-- Dashboard --}}
<li class="pc-item">
  <a href="{{ route('admin.dashboard') }}" class="pc-link">
    <span class="pc-micon"><i class="ph-duotone ph-gauge"></i></span>
    <span class="pc-mtext" data-i18n="Dashboard">Dashboard</span>
  </a>
</li>

{{-- Tours Dropdown --}}
<li class="pc-item pc-hasmenu">
  <a href="#!" class="pc-link">
    <span class="pc-micon"><i class="ph-duotone ph-map-pin"></i></span>
    <span class="pc-mtext">Tours</span>
    <span class="pc-arrow">
      <i class="ph-duotone ph-caret-right"></i>
    </span>
  </a>
  <ul class="pc-submenu">
    <li class="pc-item">
      <a href="{{ route('admin.tour-categories.index') }}" class="pc-link">
        Tour Categories
      </a>
    </li>
    <li class="pc-item">
      <a href="{{ route('admin.tours.index') }}" class="pc-link">
        Tours
      </a>
    </li>
    <li class="pc-item">
      <a href="{{ route('admin.locations.index') }}" class="pc-link">
        Locations
      </a>
    </li>
  </ul>
</li>

{{-- Activities Dropdown --}}
<li class="pc-item pc-hasmenu">
  <a href="#!" class="pc-link">
    <span class="pc-micon"><i class="ph-duotone ph-flag-banner"></i></span>
    <span class="pc-mtext">Activities</span>
    <span class="pc-arrow">
      <i class="ph-duotone ph-caret-right"></i>
    </span>
  </a>
  <ul class="pc-submenu">
    <li class="pc-item">
      <a href="{{ route('admin.activity-categories.index') }}" class="pc-link">
        Activity Categories
      </a>
    </li>
    <li class="pc-item">
      <a href="{{ route('admin.activities.index') }}" class="pc-link">
        Activities
      </a>
    </li>
  </ul>
</li>

{{-- Trekking Dropdown --}}
<li class="pc-item pc-hasmenu">
  <a href="#!" class="pc-link">
    <span class="pc-micon"><i class="ph-duotone ph-tree-evergreen"></i></span>
    <span class="pc-mtext">Trekking</span>
    <span class="pc-arrow">
      <i class="ph-duotone ph-caret-right"></i>
    </span>
  </a>
  <ul class="pc-submenu">
    <li class="pc-item">
      <a href="{{ route('admin.trekking-categories.index') }}" class="pc-link">
        Trekking Categories
      </a>
    </li>
    <li class="pc-item">
      <a href="{{ route('admin.trekking.index') }}" class="pc-link">
        Trekking
      </a>
    </li>
  </ul>
</li>

{{-- Blog Dropdown --}}
<li class="pc-item pc-hasmenu">
  <a href="#!" class="pc-link">
    <span class="pc-micon"><i class="ph-duotone ph-bookmarks"></i></span>
    <span class="pc-mtext">Blog</span>
    <span class="pc-arrow">
      <i class="ph-duotone ph-caret-right"></i>
    </span>
  </a>
  <ul class="pc-submenu">
    <li class="pc-item">
      <a href="{{ route('admin.blog-categories.index') }}" class="pc-link">
        Blog Categories
      </a>
    </li>
    <li class="pc-item">
      <a href="{{ route('admin.posts.index') }}" class="pc-link">
        Posts
      </a>
    </li>
    <li class="pc-item">
      <a href="{{ route('admin.tags.index') }}" class="pc-link">
        Tags
      </a>
    </li>
  </ul>
</li>


{{-- Special Offers --}}
<li class="pc-item">
  <a href="{{ route('admin.special-offers.index') }}" class="pc-link">
    <span class="pc-micon"><i class="ph-duotone ph-percent"></i></span>
    <span class="pc-mtext">Special Offers</span>
  </a>
</li>

{{-- Users --}}
<li class="pc-item">
  <a href="{{ route('admin.users.index') }}" class="pc-link">
    <span class="pc-micon"><i class="ph-duotone ph-users"></i></span>
    <span class="pc-mtext">Users</span>
  </a>
</li>
