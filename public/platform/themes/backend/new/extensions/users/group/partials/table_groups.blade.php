@foreach ($rows as $row)
	<tr>
		<td class="span1">{{ $row['id'] }}</td>
		<td class="span9">{{ $row['name'] }}</td>
		<td class="span2">
			<div class="btn-group">
				<a class="btn btn-mini" href="{{ URL::to_secure(ADMIN.'/users/groups/edit/'.$row['id']) }}">{{ Lang::line('button.edit') }}</a>
				<a class="btn btn-mini btn-danger" href="{{ URL::to_secure(ADMIN.'/users/groups/delete/'.$row['id']) }}">{{ Lang::line('button.delete') }}</a>
			</div>
		</td>
	</tr>
@endforeach
