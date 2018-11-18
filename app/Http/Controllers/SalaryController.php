<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Salary;
use Carbon\Carbon;

class SalaryController extends Controller
{
    private $jwtauth;

    public function __construct(JWTAuth $jwtauth)

    {
        $this->jwtauth = $jwtauth;
        $this->middleware('jwt.auth');
    }

    ////////////////////    Show All Salaries     ///////////////////////

    public function index()
    {
        $salaries = Salary::get();
        if (count($salaries)) {
            return response()->json($salaries);
        } else {
            return response()->json('No Salaries Found!');
        }
    }

    ////////////////////    Show Single Salary   ////////////////////

    public function show($id)
    {
        $salary = Salary::find($id);
        if ($salary) {
            return response()->json($salary);
        } else {
            return response()->json('Salary Does Not Found!');
        }
    }

    ////////////////////    Create New Salary     ////////////////////

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'salaries_total' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        } else {

            $lastDay = new Carbon('last day of this month');
            if ($lastDay->format('l') == "Friday") {
                $payDay = $lastDay->subDay(1)->format('d');
            } elseif ($lastDay->format('l') == "Saturday") {
                $payDay = $lastDay->subDay(2)->format('d');
            }

            $year = Carbon::now()->format('Y');
            $month = Carbon::now()->format('m');
            if (Carbon::createFromDate($year, $month, 15)->isThursday()) {
                $bonusDay = 15;
            } else {
                $bonusDay = Carbon::createFromDate($year, $month, 15)->next(4)->format('d');
            }

            $salaries_total = $request->salaries_total;
            $percentage = $request->percentage ? $request->percentage : 10;
            $bonus_total = ($percentage / 100) * $salaries_total;
            $payments_total = $salaries_total + $bonus_total;

            $salary = Salary::create([
                'month' => Carbon::now()->format('M'),
                'year' => Carbon::now()->format('Y'),
                'salaries_payment_day' => $payDay,
                'bonus_payment_day' => $bonusDay,
                'salaries_total' => $salaries_total,
                'percentage' => $percentage,
                'bonus_total' => $bonus_total,
                'payments_total' => $payments_total,
            ]);
            return response()->json($salary);
        }
    }

    ////////////////////    Create New Salary     ////////////////////

    public function update($id, Request $request)
    {
        $salary = Salary::find($id);
        if ($salary) {
            $validator = Validator::make($request->all(), [
//                'month' => 'required',
                'salaries_total' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->messages(), 200);
            } else {

                $lastDay = new Carbon('last day of this month');
                if ($lastDay->format('l') == "Friday") {
                    $payDay = $lastDay->subDay(1)->format('d');
                } elseif ($lastDay->format('l') == "Saturday") {
                    $payDay = $lastDay->subDay(2)->format('d');
                }

                $year = Carbon::now()->format('Y');
                $month = Carbon::now()->format('m');
                if (Carbon::createFromDate($year, $month, 15)->isThursday()) {
                    $bonusDay = 15;
                } else {
                    $bonusDay = Carbon::createFromDate($year, $month, 15)->next(4)->format('d');
                }

                $salaries_total = $request->salaries_total;
                $percentage = $request->percentage ? $request->percentage : 10;
                $bonus_total = ($percentage / 100) * $salaries_total;
                $payments_total = $salaries_total + $bonus_total;

                $salary->update([
                    'month' => Carbon::now()->format('M'),
                    'salaries_payment_day' => $payDay,
                    'bonus_payment_day' => $bonusDay,
                    'salaries_total' => $salaries_total,
                    'percentage' => $percentage,
                    'bonus_total' => $bonus_total,
                    'payments_total' => $payments_total,
                ]);
                return response()->json($salary);
            }
        } else {
            return response()->json('Salaries Not Found!');
        }
    }

    ////////////////////    Delete Existed Salary     ////////////////////

    public function delete($id)
    {
        $salary = Salary::find($id);
        if ($salary) {
            $salary->delete($id);
            $returnData = array(
                'success' => 'Salary Deleted Successfully!'
            );
            return response()->json($returnData, 200);
        } else {
            $returnData = array(
                'error' => 'Salary Not Found!'
            );
            return response()->json($returnData, 500);
        }
    }
}
