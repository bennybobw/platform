@layout('templates.default')

<!-- Page Title -->
@section('title')
	{{ Lang::line('menus::general.title') }}
@endsection

<!-- Queue Styles -->
{{ Theme::queue_asset('menus', 'menus::css/menus.less', 'style') }}

<!-- Styles -->
@section ('styles')
@endsection

<!-- Queue Scripts | e.g. Theme::queue_asset('name', 'path_to_js', 'dependency')-->

<!-- Scripts -->
@section('scripts')
@endsection

<!-- Page Content -->
@section('content')
<section id ="menus">

	<header class="row-fluid">
		<div class="span8">
			<h1>{{ Lang::line('menus::general.title') }}</h1>
			<p>{{ Lang::line('menus::general.description') }}</p>
		</div>
		<nav class="actions span4 pull-right">
			{{ HTML::link_to_secure(ADMIN.'/menus/create', Lang::line('button.create'), array('class' => 'btn btn-large btn-primary')) }}
		</nav>
	</header>

	<hr />

	<table class="table table-bordered">
		<thead>
			<tr>
				<th>{{ Lang::line('menus::table.name') }}</th>
				<th>{{ Lang::line('menus::table.slug') }}</th>
				<th>{{ Lang::line('menus::table.children_count') }}</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@forelse ($menus as $menu)
				<tr>
					<td>
						{{ $menu['name'] }}
					</td>
					<td>
						{{ $menu['slug'] }}
					</td>
					<td>
						{{ Lang::line('menus::table.children', array('count' => $menu[Platform\Menus\Menu::nesty_col('right')] / 2 - 1)) }}
					</td>
					<td class="span2">
						<div class="btn-group">
							{{ HTML::link_to_secure(ADMIN.'/menus/edit/'.$menu['slug'], 'Edit', array('class' => 'btn btn-mini')) }}

							@if ($menu['user_editable'])
								{{ HTML::link_to_secure(ADMIN.'/menus/delete/'.$menu['slug'], 'Delete', array('class' => 'btn btn-mini btn-danger', 'onclick' => 'return confirm(\'Are you sure you want to delete this menu? This cannot be undone.\');')) }}
							@endif
						</div>
					</td>
				</tr>
			@empty
				<tr colspan="2">
					<td>
						No menus yet.
					</td>
				</tr>
			@endforelse
		</tbody>
	</table>

</section>
@endsection
