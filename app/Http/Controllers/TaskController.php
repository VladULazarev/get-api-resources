<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource from the API.
     *
     * @return View|RedirectResponse
     */
    public function index(): View|RedirectResponse
    {
        $response = Http::acceptJson()
            ->withToken(session('TOKEN'))
            ->get('https://api-laravel.getyoursite.info/api/tasks');

        $data = $response->json();

        # If the resource WAS FOUND we do not get '$data['statusCode']',
        if (! isset($data['statusCode']) ) {

            return view('tasks.index', [
                'tasks' => $data['data'],
                'links' => $data['links'],
                'meta'  => $data['meta']
            ]);

         # If '403' - not authorized, or '404' - not found
         } elseif ( $data['statusCode'] == '403' || $data['statusCode'] == '404' ) {

             return to_route('api-message')->with([
                 'message' => 'You have no tasks.',
                 'link' => '/tasks/create',
                 'button-text' => 'Create a task'
             ]);
         }
    }

    /**
     * Display a listing of the resource from the API by page number.
     *
     * @see  public\build\assets\admin.js -- 3. Click 'pager' link
     * @return View
     */
    public function indexByPageNumber(): View
    {
        $response = Http::acceptJson()
            ->withToken(session('TOKEN'))
            ->get(request()->carrentPage);

        $data = $response->json();

        return view('tasks.index-by-page-number', [
            'tasks' => $data['data'],
            'links' => $data['links'],
            'meta'  => $data['meta']
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage of the API.
     *
     * @param  Request  $request
     * @return View
     */
    public function store(Request $request): View
    {
        $request->validate([
            'name' => 'bail|required|string|min:2|max:255',
            'description' => 'bail|required|string|min:2',
            'priority' => 'bail|required|string|min:3'
        ]);

        $response = Http::withToken(session('TOKEN'))
            ->post("https://api-laravel.getyoursite.info/api/tasks", [
                'name' => $request->name,
                'description' => $request->description,
                'priority' => $request->priority
        ]);

        $data = $response->json();

        return view('tasks.show', [ 'task' => $data['data'] ]);
    }

    /**
     * Display the specified resource of the API.
     *
     * @param  int  $id
     * @return View|RedirectResponse
     */
    public function show($id): View|RedirectResponse
    {
        $response = Http::acceptJson()
            ->withToken(session('TOKEN'))
            ->get("https://api-laravel.getyoursite.info/api/tasks/{$id}");

        $data = $response->json();

        return $this->checkStatusCode($data) ?: view('tasks.show', ['task' => $data['data']]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return View|RedirectResponse
     */
    public function edit($id): View|RedirectResponse
    {
        $response = Http::acceptJson()
            ->withToken(session('TOKEN'))
            ->get("https://api-laravel.getyoursite.info/api/tasks/{$id}");

        $data = $response->json();

        return $this->checkStatusCode($data) ?: view('tasks.edit', ['task' => $data['data']]);
    }

    /**
     * Update the specified resource in storage of the API.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return View
     */
    public function update(Request $request, $id): View
    {
        $request->validate([
            'name'        => 'bail|required|string|min:2|max:255',
            'description'  => 'bail|required|string|min:2',
            'priority'  => 'bail|required|string|min:3'
        ]);

        $response = Http::withToken(session('TOKEN'))
            ->patch("https://api-laravel.getyoursite.info/api/tasks/{$id}", [
                'name' => $request->name,
                'description' => $request->description,
                'priority' => $request->priority
        ]);

        $data = $response->json();

        return view('tasks.show', [ 'task' => $data['data'] ]);
    }

    /**
     * Remove the specified resource from storage of the API.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $response = Http::acceptJson()
            ->withToken(session('TOKEN'))
            ->delete("https://api-laravel.getyoursite.info/api/tasks/{$id}");

        return to_route('api-message')->with([
            'message' => $response->json()['message'],
            'link'    => '/tasks',
            'button-text' => 'Back to Tasks'
        ]);
    }

    /**
     * Display a listing of the resource from the API using 'params'.
     *
     * @return View|null
     * @see public\build\assets\admin.js -- 2. Type something in the 'Search...' field
     */
    public function indexBySelectedParams(): View|null
    {
        $columnName = request()->columnName;
        $data = request()->data;

        $response = Http::acceptJson()
            ->withToken(session('TOKEN'))
            ->get("https://api-laravel.getyoursite.info/api/tasks?filter={$columnName}:{$data}");

        $data = $response->json();

        # If resource was found we do not get '$data['statusCode']',
        if (! isset($data['statusCode']) ) {

            return view('tasks.index-by-selected-params', [
                'tasks' => $data['data']
            ]);

         # If '403' - not authorized, or '404' - not found
         } elseif ( $data['statusCode'] == '403' || $data['statusCode'] == '404' ) {
            return null;
         }
    }

    /**
     * Check the status code from the API.
     *
     * @param $data
     * @return RedirectResponse|void
     */
    public static function checkStatusCode($data)
    {
        # If resource was found we do not get '$data['statusCode']',
        # we have nothing to return, and just set 'TRUE'
        if (! isset($data['statusCode']) ) {

           return;

        # If '403' - not authorized, or '404' - not found
        } elseif ( $data['statusCode'] == '403' || $data['statusCode'] == '404' ) {

            return to_route('api-message')->with([
                'message' => $data['message'],
                'link'    => '/tasks',
                'button-text' => 'Back to Tasks'
            ]);
        }
    }

}
