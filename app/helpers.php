<?php

use Illuminate\Support\Str;

use App\Models\RecordLog;
use App\Models\ActivityLog;

if (!function_exists('getKeywordTerms')) {
    /**
     * Get search terms for a given strings.
     */
    function getKeywordTerms($string)
    {
        return Str::of($string)->explode(' ');
    }
}

if (!function_exists('storeActivityLog')) {
    /**
     * Store user activity log.
     */
    function storeActivityLog($activity, $recordRoute = null)
    {
        ActivityLog::create([
            'activity' => $activity,
            'record_route' => $recordRoute,
            'user_id' => auth()->id(),
        ]);
    }
}

if (!function_exists('getRecordLog')) {
    /**
     * Get model record log.
     */
    function getRecordLog($modelName, $id)
    {
        return RecordLog::where('record_model_name', $modelName)
                ->where('record_id', $id)
                ->orderByRaw("CASE 
                    WHEN action = 'Delete' THEN 1
                    WHEN action = 'Update' THEN 2 
                    WHEN action = 'Create' THEN 3 
                    ELSE 4 
                END")
                ->orderBy('created_at', 'desc')
                ->paginate(10);
    }
}

if (!function_exists('storeRecordLog')) {
    /**
     * Store model record log.
     */
    function storeRecordLog($action, $recordModelName, $recordId, $data = null)
    {
        $description = '';

        switch ($action) {
            case 'Create':
                $description = __('Record is created.');
                break;
            case 'Update':
                $description = __('Record is updated.');
                break;
            case 'Delete':
                $description = __('Record is deleted.');
                break;
            default:
        }

        if ($data != null) {
            $data = '[' . collect(array_filter($data))->map(fn($value, $key) => "'$key' => '$value'")->implode(', ')  . ']';
        }

        $recordLog = RecordLog::create([
            'action' => $action,
            'description' => $description,
            'record_model_name' => $recordModelName,
            'record_id' => $recordId,
            'data' => $data,
            'user_id' => auth()->id()
        ]);

        return $recordLog;
    }
}