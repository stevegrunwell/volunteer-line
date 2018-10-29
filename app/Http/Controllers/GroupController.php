<?php

namespace App\Http\Controllers;

use App\Group;
use App\PhoneNumber;
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
            'name' => 'required|max:255',
        ]);

        $user = $request->user();
        $group = new Group($request->all());
        $group->key = Group::generateKey();
        $group->created_by = $user->id;
        $user->groups()->save($group, [
            'can_manage' => true,
        ]);

        $phoneNumbers = $this->parsePhoneNumbersFromTextarea($request->input('phone_numbers'));
        foreach ($phoneNumbers as $number) {
            $group->phoneNumbers()->save(new PhoneNumber([
                'number' => $number,
            ]));
        }

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
            'name' => 'required|max:255',
        ]);

        $group->update($request->all());

        $phoneNumbers = $this->parsePhoneNumbersFromTextarea($request->input('phone_numbers'));
        $preserved = $group->phoneNumbers()->whereIn('number', $phoneNumbers)->get();

        // Remove anything that was present before but isn't anymore.
        if (! empty($preserved)) {
            $group->phoneNumbers()->sync($preserved->pluck('id')->toArray());
        }

        // Save any new phone numbers.
        foreach (array_diff($phoneNumbers, $preserved->pluck('number')->toArray()) as $number) {
            $group->phoneNumbers()->save(PhoneNumber::firstOrNew(['number' => $number]));
        }

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

    /**
     * Given a 'phone_numbers' textarea, parse out phone numbers and return them as an array.
     *
     * @param string $textarea The contents of the textarea.
     *
     * @return array An array of detected phone numbers
     */
    protected function parsePhoneNumbersFromTextarea(string $textarea): array
    {
        $lines = explode(PHP_EOL, $textarea);

        return array_values(array_filter(array_map('trim', $lines)));
    }
}
