<?php
namespace App\Helpers;

use App\Models\Setting;
use App\Models\Employee;

use \Carbon\Carbon;

class Helper
{
    public static function settings()
    {
        $settings = Setting::find(1);
        return $settings;
    }
    public function emp_ids()
    {

        $emp = Employee::find(auth()->id());
        $ids = $this->getAllEmployeeIds($emp);

        return $ids;
    }

    public function getAllEmployeeIds($employee)
    {

        $ids = [$employee->id];

        $employee->load('children');

        foreach ($employee->children as $child) {
            $ids = array_merge($ids, $this->getAllEmployeeIds($child));
        }

        return $ids;
    }
    
}