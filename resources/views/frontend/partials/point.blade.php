<a href="#" class="d-flex align-items-center text-reset">
    <i class="la la-refresh la-2x opacity-80"></i>
    <span class="flex-grow-1 ml-1">
        @if(Session::has('my_points'))
            <span class="badge badge-primary badge-inline badge-pill">{{ Session::get('my_points') }}</span>
        @else
            <span class="badge badge-primary badge-inline badge-pill">0</span>
        @endif
        <span class="nav-box-text d-none d-xl-block opacity-70">{{translate('Points')}}</span>
    </span>
</a>
