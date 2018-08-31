<body>
    <h1>{{ LaravelGmail::user() }}</h1>
    @if(LaravelGmail::check())
        <a href="{{ url('oauth/gmail/logout') }}">logout</a>
        <div class="row">
        	<div class="col-sm-12">
        		@php
        			$messages = LaravelGmail::message()->unread()->preload()->all();
        			foreach ( $messages as $message ) {
        			    echo $body = $message->getHtmlBody();
        			    echo $subject = $message->getSubject();
        			}
        		@endphp
        	</div>
        </div>
    @else
        <a href="{{ url('oauth/gmail') }}">login</a>
    @endif
</body>