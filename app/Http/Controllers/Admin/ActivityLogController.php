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
        if (!Auth::user()->can('see user list')) {
            return view('errors.403');
        }

        $panelAdmins = User::where('status', 'Active')->get();
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
                $q->where('activity_log.description', '<=', $request->details)
                    ->orWhere('activity_log.id', '<=', $request->details)
                    ->orWhere('activity_log.subject_id', '<=', $request->details)
                    ->orWhere('activity_log.ip', '<=', $request->details);
            });
        }

        $activities = $sql->paginate(50);
        return view('admin.settings.activity', compact('logNames',  'activities', 'panelAdmins'));
    }
}
