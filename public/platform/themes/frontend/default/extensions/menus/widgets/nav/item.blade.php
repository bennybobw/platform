<li class="{{ in_array($item['id'], $active_path) ? 'active' : null }}">
@if (URL::valid($item['uri']))
	{{ HTML::link($item['uri'], $item['name'], array('target' => '')) }}
@else
	{{ HTML::link((($before_uri) ? $before_uri.'/' : null).$item['uri'], $item['name'], ($item['target'] == 0 ? array('target' => '_self') : array('target' => '_blank')), $item['secure']) }}
@endif

@if ($item['children'])
	<ul>
	@foreach ($item['children'] as $child)
		@render('menus::widgets.nav.item', array('item' => $child, 'active_path' => $active_path, 'before_uri' => $before_uri))
	@endforeach
	</ul>
@endif
</li>
