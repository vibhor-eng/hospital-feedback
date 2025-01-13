<?php

namespace App\Http\Controllers\hospital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Query;
use App\Models\PatientFeedback;
use Hash;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Services\TwilioService;
use Carbon\Carbon;
use DB;


class HospitalDashboardController extends Controller
{

    protected $twilioService;
    public function __construct(TwilioService $twilioService)
    {
        $this->twilioService = $twilioService;
    }

    public function dashboard(Request $request)
    {

        $months = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];
        $currentYear = Carbon::now()->year;

        $data = collect();

        foreach ($months as $index => $month) {
            $resolvedCount = PatientFeedback::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $index + 1) // index + 1 to match the correct month number
                ->where('is_reply', "yes") // Assuming 1 is resolved
                ->count();
            
            $unresolvedCount = PatientFeedback::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $index + 1)
                ->where('is_reply', "no") // Assuming 0 is unresolved
                ->count();
            
            $data->push([
                'month' => $month,
                'resolved' => $resolvedCount,
                'unresolved' => $unresolvedCount
            ]);
        }


        // $currentYear = Carbon::now()->year;

        // $data = PatientFeedback::selectRaw('DATE_FORMAT(created_at, "%b") as month, COUNT(*) as resolved')
        //     ->whereYear('created_at', $currentYear)
        //     ->where('is_reply','yes')
        //     ->groupBy('month')
        //     ->orderByRaw('MONTH(created_at) ASC')
        //     ->get();



        $months = [];
        $resolved = [];
        $unresolved = [];
        foreach($data as $key => $dt){
            if($dt['resolved'] != '0' || $dt['unresolved'] != '0'){
                array_push($months,$dt['month']);
            }
            // if($dt['resolved'] != '0'){
                array_push($resolved,$dt['resolved']);
            // }
            // if($dt['unresolved'] != '0'){
                array_push($unresolved,$dt['unresolved']);
            // }
        }

        foreach ($resolved as $index => $value) {

            if ($value === 0 && $unresolved[$index] === 0) {

                unset($resolved[$index]);
                unset($unresolved[$index]);

            }

        }


        $resolved = array_values($resolved);
        $unresolved = array_values($unresolved);


        // // if array has not same value then add 0 in that array who has less value
        // $lengthDifference = count($resolved) - count($unresolved);

        // if ($lengthDifference > 0) {
        //     $unresolved = array_merge($unresolved, array_fill(0, $lengthDifference, 0));
        // } elseif ($lengthDifference < 0) {
        //     // If $array2 is longer, add zeros to $array1
        //     $resolved = array_merge($resolved, array_fill(0, abs($lengthDifference), 0));
        // }
        // // end

        


        $total_patient_queries = PatientFeedback::select('id')->where(['is_deleted' => 0])->count();
        $total_resolved_queries = PatientFeedback::select('id')->where(['is_deleted' => 0,'is_reply' => 'yes'])->count();
        $total_active_queries = PatientFeedback::select('id')->where(['is_deleted' => 0,'is_reply' => 'no'])->count();
        return view('hospital.dashboard',compact('total_patient_queries','total_resolved_queries','months','resolved','unresolved','total_active_queries'));
    }

    public function resetPassword(Request $request){

        if($request->isMethod('post')){

            try{

                 $this->validate($request, [
                    'password' => 'required|min:6|max:8',
                    'email' => 'required|email',
                ]);

                $email_exist = Patient::select('id')->where(['email' => $request->email])->first();

                if($email_exist){

                    $password = Hash::make($request->password);

                    Patient::where(['email' => $request->email])->update(['password' => $password]);


                    return redirect('hospital/reset-password')->with('success', 'Password has been updated successfully.');
                }else{

                    return redirect()->back()->withErrors("Email does not exist in our db.");

                }



                }catch(\Exception $e){
                   
                    return redirect()->back()->withErrors($e->getMessage());

                }

        }   

        return view('hospital.reset-password');

    }


    ##patient list
    public function PatientList(Request $request){


        try{

            $patients_list = Patient::select('*')->where(['user_type' => 'user','is_deleted' => 0])->orderBy('id','desc')->get()->toArray();
            return view('hospital.patient.list',compact('patients_list'));
            
            
        }catch(\Exception $e){
           
            return redirect()->back()->withErrors($e->getMessage());

        }



    }

    // update patient details
    public function UpdatePatientList(Request $request,$id = ''){

        try{

            if($request->isMethod('post')){

                $update = Patient::where(['id' => $request->id])->update(['name' => $request->name,'email' => $request->name,'age' => $request->age,'mobile' => $request->mobile,'Gender' => $request->gender]);

            
                return redirect()->back()->with('success', 'Details has been updated successfully.');
                

            }

            $patient_details = Patient::select('*')->where(['id' => $id,'is_deleted' => 0])->first()->toArray();

            return view('hospital.patient.edit',compact('patient_details'));

        }catch(\Exception $e){
           
            return redirect()->back()->withErrors($e->getMessage());

        }

    }

    ##patient query list
    public function PatientQueryList(Request $request){

        try{

            // $query_list = PatientFeedback::select('*')->where(['is_deleted' => 0])->orderBy('id','desc')->get()->toArray();
            $query_list = DB::table('patient_feedbacks')
                            ->leftJoin('query_types','patient_feedbacks.query_type_id','=','query_types.id')
                            ->select('patient_feedbacks.id','patient_feedbacks.name','patient_feedbacks.age','patient_feedbacks.email','patient_feedbacks.mobile','patient_feedbacks.image','patient_feedbacks.is_reply','patient_feedbacks.message','patient_feedbacks.query_type_id')
                            ->where(['patient_feedbacks.is_deleted' => 0])
                            ->get()
                            ->toArray();

            
            
            $query_types = Query::select('*')->where(['is_deleted' => 0])->get()->toArray();
           
            return view('hospital.patient_query.list',compact('query_list','query_types'));
            
            
        }catch(\Exception $e){
           
            return redirect()->back()->withErrors($e->getMessage());

        }
        

    }


    public function reply(Request $request){

        try{



            $update = PatientFeedback::where(['id' => $request->id])->update(['message_reply_by_admin' => $request->message,'is_reply' => 'yes','query_type_id' => $request->query_type_id]);

            //send message to patient
            $response = $this->twilioService->sendSMS($request->mob, "Your query has been resolved.");


            return response()->json(['msg' => 'Message has been sent.','status' => true]);



        }catch(\Exception $e){

           
           
            return response()->json(['msg' => $e->getMessage(),'status' => false]);

        }

    }


    public function updateDept(Request $request){

        try{

            $update = PatientFeedback::where(['id' => $request->feedback_id])->update(['query_type_id' => $request->dept_id]);

            return response()->json(['msg' => 'Department has been sent.','status' => true]);

        }catch(\Exception $e){

            return response()->json(['msg' => $e->getMessage(),'status' => false]);

        }

    }

}