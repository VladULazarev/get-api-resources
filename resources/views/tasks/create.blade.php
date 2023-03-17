<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create a task</h2>
  </x-slot>

  <div class="py-12">
    <div class="edit-width mx-auto sm:px-6 lg:px-8">

      <div class="row content mb-5">
        <div class="col-lg-8">
          <section class="relative break-words p-3 mt-3">
            <form method="POST" action="/tasks">
              @csrf

              <div class="form-row">
                <div class="col">
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name"
                      class="form-control @error('name') alert-border @enderror"
                      id="name" maxlength="255"
                      value="{{ old('name') }}"
                      placeholder="Name (max:255)"
                      autocomplete="off">
                      @error('name')
                        <span class="laravel-alert">{{ $errors->first('name') }}</span>
                      @enderror
                  </div>
                </div>
              </div>

              <div class="form-row">
                <div class="col">
                  <div class="form-group">
                    <label for="description">Description</label>
                    <textarea type="text" name="description"
                      class="form-control @error('description') alert-border @enderror"
                      id="description"
                      rows="5"
                      placeholder="Description"
                      autocomplete="off">{{ old('description') }}</textarea>
                      @error('description')
                        <span class="laravel-alert">{{ $errors->first('description') }}</span>
                      @enderror
                  </div>
                </div>
              </div>

              <div class="form-row">
                <div class="col">
                  <div class="form-group">
                    <label for="priority">Priority</label>
                    <input type="text" name="priority"
                      class="form-control @error('priority') alert-border @enderror"
                      id="priority" maxlength="255"
                      value="{{ old('priority') }}"
                      placeholder="Priority: low, middle, high"
                      autocomplete="off">
                      @error('priority')
                        <span class="laravel-alert">{{ $errors->first('priority') }}</span>
                      @enderror
                  </div>
                </div>
              </div>

              <div class="btn-container mt-4">
                <button type="submit" class="btn-default btn-form btn-green me-3">Create</button>
                <a href="{{ route('tasks.index') }}" class="btn-default btn-form btn-white">Back</a>
              </div>

            </form>

          </section>
        </div>
      </div> <!-- end 'content'-->
    </div>
  </div>
</x-app-layout>
