<div class="right-sidebar-area" data-simplebar>
    
    
    <div class="recent-contact-box">
        <div class="title">
            <h3>Contact</h3>
        </div>
        
        @foreach ($connectedUsers as $connectedUser)
            <div class="contact-body" data-simplebar>
                <div class="contact-item mb-2" title="{{ $connectedUser->name }}">
                    @if($connectedUser->profile_pic)
                        <img src="{{ $connectedUser->profile_pic }}" alt="{{ $connectedUser->name }}">
                    @else
                        <img src="{{ asset('assets/images/user/user-default.png') }}" alt="{{ $connectedUser->name }}">
                    @endif
                   <span class="name"><a href="{{ route('user.profile', $connectedUser->id) }}">{{ $connectedUser->username }}</a></span>
                    <span class="status-online"></span>
                </div>
            </div>
        @endforeach
    </div>
</div>