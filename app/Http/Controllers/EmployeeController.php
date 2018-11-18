<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Employee;
use App\Salary;
use Carbon\Carbon;

class EmployeeController extends Controller
{
    private $jwtauth;

    public function __construct(JWTAuth $jwtauth)

    {
        $this->jwtauth = $jwtauth;
        $this->middleware('jwt.auth');
    }

    ////////////////////    Show All Employees     ///////////////////////

    public function index()
    {
        $employees = Employee::get();
        if (count($employees)) {
            return response()->json($employees);
        } else {
            return response()->json('No Employees Found!');
        }
    }

    ////////////////////    Show Single Employee   ////////////////////

    public function show($id)
    {
        $employee = Employee::find($id);
        if ($employee) {
            return response()->json($employee);
        } else {
            return response()->json('Employee Does Not Found!');
        }
    }

    ////////////////////    Create New Employee     ////////////////////

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'salary' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        } else {
            $salary = $request->salary;
            $percentage = $request->percentage ? $request->percentage : 10;
            $bonus = ($percentage / 100) * $salary;
            $total = $salary + $bonus;

            $month = Carbon::now()->format('M');
            $year = Carbon::now()->format('Y');
            $employee = Employee::create([
                'name' => $request->name,
                'salary' => $salary,
                'percentage' => $percentage,
                'bonus' => $bonus,
                'total' => $total,
            ]);
            $monthly_salary = Salary::where('month', $month)->where('year', $year)->first();
            $monthly_salary->update([
                'salaries_total' => $monthly_salary->salaries_total + $employee->salary,
                'percentage' => $monthly_salary->percentage + $employee->percentage,
                'bonus_total' => $monthly_salary->bonus_total + $employee->bonus,
                'payments_total' => $monthly_salary->payments_total + $employee->total,
            ]);
            return response()->json($employee);
        }
    }

    ////////////////////    Create New Employee     ////////////////////

    public function update($id, Request $request)
    {
        $employee = Employee::find($id);
        $oldEmployee = Employee::find($id);
        if ($employee) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'salary' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->messages(), 200);
            } else {
                $salary = $request->salary;
                $percentage = $request->percentage ? $request->percentage : 10;
                $bonus = ($percentage / 100) * $salary;
                $total = $salary + $bonus;

                $month = Carbon::now()->format('M');
                $year = Carbon::now()->format('Y');

                $employee->update([
                    'name' => $request->name,
                    'salary' => $salary,
                    'percentage' => $percentage,
                    'bonus' => $bonus,
                    'total' => $total,
                ]);
                $monthly_salary = Salary::where('month', $month)->where('year', $year)->first();
                $monthly_salary->update([
                    'salaries_total' => $monthly_salary->salaries_total + $employee->salary - $oldEmployee->salary,
                    'percentage' => $monthly_salary->percentage + $employee->percentage - $oldEmployee->percentage,
                    'bonus_total' => $monthly_salary->bonus_total + $employee->bonus - $oldEmployee->bonus,
                    'payments_total' => $monthly_salary->payments_total + $employee->total - $oldEmployee->total,
                ]);

                return response()->json($employee);
            }
        } else {
            return response()->json('Employee Does Not Found!');
        }
    }

    ////////////////////    Delete Existed Employee     ////////////////////

    public function delete($id)
    {
        $employee = Employee::find($id);
        $month = Carbon::now()->format('M');
        $year = Carbon::now()->format('Y');
        $monthly_salary = Salary::where('month', $month)->where('year', $year)->first();
        if ($employee) {
            $monthly_salary->update([
                'salaries_total' => $monthly_salary->salaries_total - $employee->salary,
                'percentage' => $monthly_salary->percentage - $employee->percentage,
                'bonus_total' => $monthly_salary->bonus_total - $employee->bonus,
                'payments_total' => $monthly_salary->payments_total - $employee->total,
            ]);
            $employee->delete($id);
            $returnData = array(
                'success' => 'Employee Deleted Successfully!'
            );
            return response()->json($returnData, 200);
        } else {
            $returnData = array(
                'error' => 'Employee Not Found!'
            );
            return response()->json($returnData, 500);
        }
    }

}
