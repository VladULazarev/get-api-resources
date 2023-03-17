<table class="table">

  <tr class="table-header">
    <th class="col-1 text-center">Id</th>
    <th class="col-2">Name</th>
    <th class="col-3">Description</th>
    <th class="col-1">Priority</th>
    <th class="col-1">Created</th>
    <th class="col-1">Updated</th>
    <th class="col-1 text-center">Show</th>
    <th class="col-1 text-center">Edit</th>
    <th class="col-1 text-center">Delete</th>
  </tr>

  <tr class="">
    <td class="col-1 text-center"></td>
    <td class="col-2"></td>
    <td class="col-3"></td>
    <td class="col-1"></td>
    <td class="col-1"></td>
    <td class="col-1"></td>
    <td class="col-1 text-center"></td>
    <td class="col-1 text-center"></td>
    <td class="col-1 text-center"></td>
  </tr>

  <!-- Show all records -->
  @foreach($tasks as $task)
    <tr class="record">
      <td class="col-1 text-center">{{ $task['id'] }}</td>
      <td class="col-2">{{ $task['attributes']['name'] }}</td>
      <td class="col-3">{{ $task['attributes']['description'] }}</td>
      <td class="col-1">{{ $task['attributes']['priority'] }}</td>
      <td class="col-1">{{ Str::limit($task['attributes']['created at'], 10, ' ') }}</td>
      <td class="col-1">{{ Str::limit($task['attributes']['updated at'], 10, ' ') }}</td>
      <td class="col-1 text-center btn-default btn-edit">
        <a class="d-block"
          href="{{ route('tasks.show', [ 'id' => $task['id'] ] ) }}">Show</a>
      </td>
      <td class="col-1 text-center btn-default btn-edit">
        <a class="d-block"
          href="{{ route('tasks.edit', [ 'id' => $task['id'] ] ) }}">Edit</a>
      </td>
      <td class="col-1 text-center btn-default btn-delete">
        <a class="h-100 d-block"
            href="{{ route('tasks.destroy', [ 'id' => $task['id'] ] ) }}">Delete</a>
      </td>
    </tr>

  @endforeach
</table>

<div class="text-end pe-3 mb-4">
  <a href="{{ route('tasks.index') }}" class="btn-default btn-form btn-white">Back to Tasks</a>
</div>


