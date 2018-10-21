<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Group::class);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view('group.create')->with([
            'group' => new Group,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|max:255'
        ]);

        $user = $request->user();
        $group = new Group($request->all());
        $group->created_by = $user->id;
        $user->groups()->save($group, [
            'can_manage' => true,
        ]);

        return redirect(route('home'))
            ->with('success', trans('group.create.success', ['name' => $group->name]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\View\View
     */
    public function show(Group $group): View
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Group  $group
     *
     * @return \Illuminate\View\View
     */
    public function edit(Group $group): View
    {
        return view('group.edit')->with([
            'group' => $group,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Group $group): RedirectResponse
    {
        $request->validate([
            'name' => 'required|max:255'
        ]);

        $group->update($request->all());

        return redirect(route('home'))
            ->with('success', trans('group.edit.success', ['name' => $group->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        //
    }
}
