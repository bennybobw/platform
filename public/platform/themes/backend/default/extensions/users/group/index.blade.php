@layout('templates.default')

<!-- Page Title -->
@section('title')
	{{ Lang::line('users::general.groups.title') }}
@endsection

<!-- Queue Styles -->
{{ Theme::queue_asset('table', 'css/vendor/platform/table.css', 'style') }}

<!-- Styles -->
@section ('styles')
@endsection

<!-- Queue Scripts -->
{{ Theme::queue_asset('table', 'js/vendor/platform/table.js', 'jquery') }}
{{ Theme::queue_asset('groups', 'users::js/groups.js', 'jquery') }}

<!-- Scripts -->
@section('scripts')
@endsection

<!-- Page Content -->
@section('content')
<section id="groups">

	<header class="row-fluid">
		<div class="span4">
			<h1>{{ Lang::line('users::general.groups.title') }}</h1>
			<p>{{ Lang::line('users::general.groups.description') }}</p>
		</div>
		<nav class="tertiary-navigation span8">
			@widget('platform.menus::menus.nav', 2, 1, 'nav nav-pills pull-right', ADMIN)
		</nav>
	</header>

	<hr>

	<div id="table">

		<div class="actions clearfix">
			<div id="table-filters" class="form-inline pull-left"></div>
			<div class="processing pull-left"></div>
			<div class="pull-right">
				<a class="btn btn-large btn-primary" href="{{ URL::to_admin('users/groups/create') }}">{{ Lang::line('button.create') }}</a>
			</div>
		</div>

		<div class="tabbable tabs-right">
			<ul id="table-pagination" class="nav nav-tabs"></ul>
			<div class="tab-content">
				<table id="users-table" class="table table-bordered table-striped">
					<thead>
						<tr>
							@foreach ($columns as $key => $col)
							<th data-table-key="{{ $key }}">{{ $col }}</th>
							@endforeach
							<th></th>
						</tr>
					<thead>
					<tbody></tbody>
				</table>
			</div>
		</div>

	</div>

</section>
@endsection
