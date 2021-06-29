<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::user()->can('activity-log')) {
            return view('errors.403');
        }

        $panelAdmins = User::get();
        $logNames = Activity::select('log_name')->orderBy('log_name', 'ASC')->groupBy('log_name')->get();

        $sql = Activity::select('activity_log.*', 'users.name')->orderBy('created_at', 'DESC');
        $sql->join('users', 'users.id', '=', 'activity_log.causer_id');

        if ($request->account) {
            $sql->where('activity_log.causer_id', $request->account);
        }
        if ($request->event) {
            $sql->where('activity_log.log_name', $request->event);
        }
        if ($request->from) {
            $sql->whereDate('activity_log.created_at', '>=', $request->from);
        }
        if ($request->to) {
            $sql->whereDate('activity_log.created_at', '<=', $request->to);
        }
        if ($request->details) {
            $sql->where(function($q) use($request) {
                $q->where('activity_log.description', 'LIKE', $request->details.'%')
                    ->orWhere('activity_log.id', 'LIKE', $request->details.'%')
                    ->orWhere('activity_log.subject_id', 'LIKE', $request->details.'%')
                    ->orWhere('activity_log.ip', 'LIKE', $request->details.'%');
            });
        }

        $activities = $sql->paginate(50);
        $serial = (!empty($request->page))?((50*($request->page-1))+1):1;

        return view('admin.settings.activity', compact('serial', 'activities', 'logNames', 'panelAdmins'))->with('list', 1);
    }
}
