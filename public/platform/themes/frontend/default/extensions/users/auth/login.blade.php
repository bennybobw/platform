@layout('templates.blank')

<!-- Page Title -->
@section('title')
	Platform Login
@endsection

<!-- Queue Styles -->
{{ Theme::queue_asset('auth', 'users::css/auth-forms.less', 'style') }}

<!-- Styles -->
@section ('styles')
@endsection

<!-- Queue Scripts -->
{{ Theme::queue_asset('login', 'users::js/login.js', 'jquery') }}

<!-- Scripts -->
@section('scripts')
@endsection

<!-- Page Content -->
@section('content')

<div>
	@widget('platform.users::form.login')
</div>

@endsection