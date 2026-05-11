<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class OrganizationSwitcherController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'organization_id' => ['required', 'string'],
        ]);

        $organizationId = $request->input('organization_id');

        $belongs = $request->user()
            ->organizations()
            ->where('organizations.id', $organizationId)
            ->exists();

        abort_unless($belongs, 403);

        $request->session()->put('current_organization_id', $organizationId);

        return redirect()->back();
    }
}
