<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UserActivityLogController extends Controller
{
    public function index()
    {
        // Fetch user activity logs from the Oracle database
        $logs = DB::connection('oracle')->table('user_activity_logs')->orderBy('created_at', 'desc')->get();

        // Pass logs to the view
        return view('pages.user_activity_logs', compact('logs'));
    }

    public function deleteSelected(Request $request)
    {
        $logIds = $request->input('ids'); // Get the selected log IDs

        if (!empty($logIds)) {
            // Ensure we are using the correct connection for Oracle
            DB::connection('oracle')->table('user_activity_logs')->whereIn('id', $logIds)->delete();

            return response()->json(['success' => true, 'message' => 'Selected logs deleted successfully.']);
        } else {
            return response()->json(['error' => 'No logs selected.'], 400);
        }
     }

}
