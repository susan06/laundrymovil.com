<?php

namespace App\Http\Controllers\Admin;

use Validator;
use Auth;
use Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepository;
use App\Repositories\Driver\DriverRepository;
use App\Support\User\UserStatus;

class DriverController extends Controller
{
    /**
     * @var UserRepository
     */
    private $users;

    /**
     * @var DriverRepository
     */
    private $drivers;

    /**
     * UserController constructor.
     * @param UserRepository $roles
     */
    public function __construct(UserRepository $users, DriverRepository $drivers)
    {
        $this->middleware('auth');
        $this->middleware('locale'); 
        $this->middleware('timezone'); 
        $this->users = $users;
        $this->drivers = $drivers;
    }

     /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data, $id = null)
    {
        $rules = [
            'name' => 'required|min:3',
            'lastname' => 'required|min:3',
            'phone_mobile' => 'required|numeric'
        ];

        if ($id) {
            $rules['email'] = 'required|email|unique:users,email,'.$id;
            $rules['status'] = 'required';
        } else {
            $rules['email'] = 'required|email|unique:users,email';
        }

        return Validator::make($data, $rules);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $drivers = $this->users->driver_paginate_search(10, $request->search, $request->status);
        $status = ['' => trans('app.all_status')] + UserStatus::lists();
        if ( $request->ajax() ) {
            if (count($drivers)) {
                return response()->json([
                    'success' => true,
                    'view' => view('users.drivers.list', compact('drivers','status'))->render(),
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => trans('app.no_records_found')
                ]);
            }
        }

        return view('users.drivers.index', compact('drivers', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $edit = false;

        return response()->json([
            'success' => true,
            'view' => view('users.drivers.create-edit', compact('edit'))->render()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validator($request->all());
        if ( $validator->passes() ) {
            $data = [
                'name' => $request->name,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'role_id' => 3,
                'phones' => '{"phone_mobile":"'.$request->phone_mobile.'","phone_home":"'.$request->phone_home.'"}',
                'birthday' => $request->birthday,
                'password' => 'secret',
                'status' => UserStatus::ACTIVE
            ];
            $user = $this->users->create($data);

            if ( $user ) {

                return response()->json([
                    'success' => true,
                    'message' => trans('app.driver_created_defaut_pass')
                ]);
            } else {
                
                return response()->json([
                    'success' => false,
                    'message' => trans('app.error_again')
                ]);
            }
        } else {

            $messages = $validator->errors()->getMessages();

            if ( $request->ajax() ) {

                return response()->json([
                    'success' => false,
                    'validator' => true,
                    'message' => $messages
                ]);
            } 

            return back()->withErrors($messages); 
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->users->find($id);
        $phones_array = json_decode($user->phones, true);
        $phones['phone_mobile'] = isset($phones_array['phone_mobile']) ?  $phones_array['phone_mobile'] : null;
        $phones['phone_home'] = isset($phones_array['phone_home']) ?  $phones_array['phone_home'] : null;
        $status = UserStatus::lists();
        return response()->json([
            'success' => true,
            'view' => view('users.drivers.show', compact('user', 'phones', 'status'))->render()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $edit = true;
        $status = UserStatus::lists();
        if ( $user = $this->users->find($id) ) {
            $phones_array = json_decode($user->phones, true);
            $phones['phone_mobile'] = isset($phones_array['phone_mobile']) ?  $phones_array['phone_mobile'] : null;
            $phones['phone_home'] = isset($phones_array['phone_home']) ?  $phones_array['phone_home'] : null;
            return response()->json([
                'success' => true,
                'view' => view('users.drivers.create-edit', compact('user','edit','status','phones'))->render()
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => trans('app.no_record_found')
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = $this->validator($request->all(), $id);
        if ( $validator->passes() ) {
            $data = [
                'name' => $request->name,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'phones' => '{"phone_mobile":"'.$request->phone_mobile.'","phone_home":"'.$request->phone_home.'"}',
                'birthday' => $request->birthday,
                'status' => $request->status
            ];

            $user = $this->users->update($id, $data);
            if ( $user ) {

                return response()->json([
                    'success' => true,
                    'message' => trans('app.driver_updated')
                ]);
            } else {
                
                return response()->json([
                    'success' => false,
                    'message' => trans('app.error_again')
                ]);
            }
        } else {

            $messages = $validator->errors()->getMessages();

            if ( $request->ajax() ) {

                return response()->json([
                    'success' => false,
                    'validator' => true,
                    'message' => $messages
                ]);
            } 

            return back()->withErrors($messages); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ( $this->users->delete($id) ) {
            return response()->json([
                'success' => true,
                'message' => trans('app.deleted_driver')
            ]);
        } else {
            return response()->json([
                'success'=> false,
                'message' => trans('app.error_again')
            ]);
        } 
    }

    /**
     * Edit comission and shedule form
     *
     * @return Response JSON
     */
    public function editComissionShedule($id)
    {
        $driver = $this->users->find($id);
        if(Settings::get('working_hours')) {
            $working_array = json_decode(Settings::get('working_hours'), true);
            $working_hours = array_column($working_array, 'interval', 'id');
        } else {
            $working_hours = array();
        }
        return response()->json([
            'success' => true,
            'view' => view('users.drivers.comission_shedule', compact('driver', 'working_hours', 'working_array'))->render()
        ]);
    }

     /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validatorComissionShedule(array $data)
    {
        $rules = [
            'comission' => 'required|numeric',
            'shedules' => 'required',
        ];

        return Validator::make($data, $rules);
    }
    /**
     * Store or update comission and shedule.
     *
     */
    public function updateComissionShedule($id, Request $request)
    {
        $validator = $this->validatorComissionShedule($request->all());
        if ( $validator->passes() ) {
            $data = [
                'user_id' => $id,
                'percentage' => $request->comission
            ];
            $user = $this->users->find($id);
            $comission = $this->drivers->create_update_comission($user, $data);
            $shedules = $request->shedules;
             if ( $shedules ) {
                $shedules_old = $user->driver_shedules;
                $shedule_id = $request->shedule_id;
                $delete_shedule = array();
                foreach( array_unique($shedules) as $key => $value ) {
                    if((int)$shedule_id[$key] == 0) {
                        $this->drivers->create_shedule([ 
                            'user_id' => $user->id,
                            'value' => $value
                            ]
                        );
                    } else {
                        if ($shedules_old) {
                            foreach ($shedules_old->toArray() as $she_old) {
                               if ( in_array($she_old['id'], $shedule_id)  ) {
                                   $this->drivers->update_shedule(
                                        (int)$shedule_id[$key],
                                        [ 'value' => $value ]
                                    );
                               } else {
                                    $this->drivers->delete_shedule($she_old['id']);
                               }
                            }
                        }
                    }      
                }
            }

            return response()->json([
                'success' => true,
                'message' => trans('app.comission_shedule_update')
            ]);
       
        } else {
            $messages = $validator->errors()->getMessages();

            return response()->json([
                'success' => false,
                'validator' => true,
                'message' => $messages
            ]);
        }  
    }

    /**
     * show list of activities by driver
     *
     * @return \Illuminate\Http\Response
     */
    public function showActivities($id, Request $request) 
    {
        $activities = $this->drivers->activities($id, $request->search);
        $user = $this->users->find($id);
        if ( $request->ajax() ) {
            if (count($activities) > 0) {
                return response()->json([
                    'success' => true,
                    'view' => view('users.drivers.list_activities', compact('activities'))->render(),
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => trans('app.no_records_found')
                ]);
            }
        }

        return view('users.drivers.index_activities', compact('activities', 'user'));
    }
}
