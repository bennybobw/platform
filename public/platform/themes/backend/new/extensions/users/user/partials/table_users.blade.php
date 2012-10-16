@foreach ($rows as $row)
	<tr>
		<td class="span1">{{ $row['id'] }}</td>
		<td class="span2">{{ $row['metadata']['first_name'] }}</td>
		<td class="span2">{{ $row['metadata']['last_name'] }}</td>
		<td class="span2">{{ $row['email'] }}</td>
		<td class="span1">{{ $row['groups'] }}</td>
		<td class="span1">{{ $row['status'] }}</td>
		<td class="span2">{{ date('g:ia - m.d.y', $row['created_at']) }}</td>
		<td class="span2">
			<div class="btn-group">
			<a class="btn btn-mini" href="{{ URL::to_secure(ADMIN.'/users/edit/'.$row['id']) }}">{{ Lang::line('button.edit') }}</a>
			<a class="btn btn-mini btn-danger" href="{{ URL::to_secure(ADMIN.'/users/delete/'.$row['id']) }}">{{ Lang::line('button.delete') }}</a>
			</div>
		</td>
	</tr>
@endforeach
