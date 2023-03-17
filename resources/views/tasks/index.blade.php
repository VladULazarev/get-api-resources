<x-app-layout>

  <x-slot name="header">
    <div class="row">

      <div class="col-md-3">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tasks') }}
        </h2>
      </div>

      <div class="col-md-3 position-relative">
        <!-- Select data for searching -->
        <select id="select-data" class="form-select form-control">
          <option value="">Select data for searching</option>
          <option value="name">Name</option>
          <option value="description">Description</option>
          <option value="priority">Priority</option>
          <option value="created_at">Created</option>
          <option value="updated_at">Updated</option>
        </select>
        <div id="select-data-tooltip" class="tooltip">Select data for searching!</div>
      </div>

      <div class="col-md-2 position-relative">
        <input type="text" id="search"
        name="search" class="form-control"
        autocomplete="off"
        maxlength="25"
        placeholder="Search...">
        <span></span>
      </div>

      <div class="col-md-2 text-center">
        <a href="{{ route('tasks.create') }}" class="d-block btn-form btn-green mt-1 mb-1">Create a task</a>
      </div>

    </div> <!-- end 'row' -->
  </x-slot>

  <div class="py-12">
    <div class="custom-width mx-auto sm:px-6 lg:px-8">

      <div class="content table-responsive">

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

    @include('inc.pager')

    <div class="text-end pe-3 mb-4">
      <a href="{{ route('tasks.index') }}" class="btn-default btn-form btn-white">Back to Tasks</a>
    </div>

    </div> <!-- end '.content'-->
  </div>
</div>

</x-app-layout>