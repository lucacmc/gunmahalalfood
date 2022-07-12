<a href="{{route('earnng_point_for_user')}}" class="d-flex align-items-center text-reset">
    <i class="la la-refresh la-2x opacity-80"></i>
    <span class="flex-grow-1 ml-1">
       <span class="badge badge-primary badge-inline badge-pill">{{ \App\Models\ClubPoint::getUserPoint() }}</span>
        <span class="nav-box-text d-none d-xl-block opacity-70">{{translate('Points')}}</span>
    </span>
</a>
