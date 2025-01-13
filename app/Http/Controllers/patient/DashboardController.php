<?php

namespace App\Http\Controllers\patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\PatientFeedback;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Services\TwilioService;
use Illuminate\Support\Facades\Crypt;

class DashboardController extends Controller
{

    protected $twilioService;
    public function __construct(TwilioService $twilioService)
    {
        $this->twilioService = $twilioService;
    }

    public function dashboard()
    {
     
        try{

            $patients_details_string = Auth::user()->patient_id."+++".Auth::user()->name."+++".Auth::user()->email."+++".Auth::user()->age."+++".Auth::user()->mobile;

            $patient_details = Crypt::encryptString($patients_details_string);

            $data = route('patient.feedback',['details' => $patient_details]);  // Data to encode in the QR code

            // Generate QR code as a string (base64 encoded PNG)
            $qrCode = QrCode::size(300)->generate($data);


            return view('patient.dashboard', compact('qrCode'));

        }catch(\Exception $e){

            return redirect()->back()->withErrors($e->getMessage());

        }
    }

    // <img src="{{ asset('storage/' . session('path')) }}" alt="Uploaded Image" width="300">
    //     <p>Image Name: {{ basename(session('path')) }}</p> 

    public function feedbackForm(Request $request){

        try{

            if($request->isMethod('post')){

                $request->validate([
                    'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);

                $imagePath = '';

                if ($request->hasFile('feedback_img')) {

                    $image = $request->file('feedback_img');

                    $imageName = $image->getClientOriginalName();

                    // Store the image and get the filename
                    $imagePath = $image->store('images', 'public'); // 'images' is the folder in storage/app/public


                }

                $feedback_data = [

                    'name' => $request->name,
                    'email' => $request->email,
                    'age' => $request->age,
                    'mobile' => $request->mobile,
                    'image' => $imagePath,
                    'patient_id' => $request->patient_id,
                    'message' => $request->message,

                ];



                $patient_feedback = PatientFeedback::create($feedback_data);

                //send message to patient
                $response = $this->twilioService->sendSMS($request->mobile, $request->message);

                //send message to admin
                $response = $this->twilioService->sendSMS("7338882496", $request->message);

                return redirect()->back()->with('success', 'Your feedback is valuable to us. We will get back to you.');


            }

            $patient_details = explode("+++",Crypt::decryptString($request->get('details')));

            $patient_id = isset($patient_details[0]) ? $patient_details[0] : '';
            $name = isset($patient_details[1]) ? $patient_details[1] : '';
            $email = isset($patient_details[2]) ? $patient_details[2] : '';
            $age = isset($patient_details[3]) ? $patient_details[3] : '';
            $mobile = isset($patient_details[4]) ? $patient_details[4] : '';
            

            return view('patient.feedback_form',compact('patient_id','name','email','age','mobile'));


        }catch(\Exception $e){

            return redirect()->back()->withErrors($e->getMessage());

        }


        

    }

}