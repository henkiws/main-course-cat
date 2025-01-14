<?php

namespace App\Repositories;

use App\Repositories\CAT\CATStudentRepository;
use App\Repositories\CAT\CATUserRepository;
use App\Repositories\GroupRepository;
use App\Models\User;
use App\Models\UserGroup;
use DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Hash;
use App\Traits\FileUploadTrait;

class UserRepository
{
    use FileUploadTrait;

    public function __construct(CATStudentRepository $CATStudentRepository,
                                CATUserRepository $CATUserRepository,
                                GroupRepository $GroupRepository) {
        $this->CATStudentRepository = $CATStudentRepository;
        $this->CATUserRepository = $CATUserRepository;
        $this->GroupRepository = $GroupRepository;
    }
    
    public function getAll() {
        return User::with(['data_user_group.data_group'])->get();
    }

    public function getCount() {
        return User::count();
    }

    public function getDropdown($is_premium=0) {
        return User::whereNotIn('id',[1])->pluck('name','id');
    }

    public function getPaginate($paginate = 10, $search = []) {
        $query =  User::with(['data_user_group.data_group']);
        if( count($search) ) {
            foreach( $search as $key => $val ) {
                $query->where($key,'like','%'.$val.'%');
            }
        }

        return $query->paginate($paginate);
    }

    public function FetchById($id) {
        return User::with(['data_user_group.data_group'])->findOrFail($id);
    }

    public function getUserGroup() {
        return UserGroup::where('fk_user',auth()->user()->id)->pluck('fk_group')->toArray();
    }

    public function create($request) {
        DB::beginTransaction();
        try {
            $data   = [
                "name"      => $request->get('name'),
                'email'     => $request->get('email'),
                'email_verified_at'     => Carbon::now(),
                'password'  => Hash::make($request->get('password')),
                'remember_token' => Str::random(40)
            ];

            $User   = User::create($data);

            $User->assignRole($request->get('role'));

            UserGroup::create([
                "fk_user" => $User->id,
                "fk_group" => $request->get('fk_group')
            ]);

            $group = $this->GroupRepository->FetchById($request->get('fk_group'));

            if( $group->fk_cbt_group > 0 ) {
                if($request->get('role') == "admin") {
                    $data_array   = [
                        "username"      => $request->get('email'),
                        "password"      => $request->get('password'),
                        "nama"      => $request->get('name'),
                        "opsi1"      => '-',
                        "opsi2"      => '-',
                        "keterangan"      => '-',
                        "level"      => 'admin',
                    ];
                    $newReq = new \Illuminate\Http\Request($data_array);
                    $result_admin = $this->CATUserRepository->create($newReq);

                    if( $result_admin['status'] == "success" ) {

                        $User->update([
                            "fk_cbt_user" => $result_admin['data']->id
                        ]);
        
                        DB::commit();
                        return [
                            "status"    => "success",
                            "msg"       => "Data has been saved successfully!",
                            "data"      => []
                        ];
                    }else{
                        DB::rollback();
                        return [
                            "status"    => "error",
                            "msg"       => $result_admin['msg'],
                            "data"      => []
                        ];
                    }

                }else{ // student
                    $data_array   = [
                        "user_grup_id"      => $group->fk_cbt_group,
                        "user_name"      => $request->get('email'),
                        "user_password"      => $request->get('password'),
                        "user_email"      => $request->get('email'),
                        "user_regdate"      => Carbon::now(),
                        "user_ip"      => null,
                        "user_firstname"      => $request->get('name'),
                        "user_birthdate"      => null,
                        "user_birthplace"      => null,
                        "user_level"      => 1,
                        "user_detail"      => null,
                    ];
                    $newReq = new \Illuminate\Http\Request($data_array);
                    $result_student = $this->CATStudentRepository->create($newReq);

                    if( $result_student['status'] == "success" ) {

                        $User->update([
                            "fk_cbt_student" => $result_student['data']->user_id
                        ]);
        
                        DB::commit();
                        return [
                            "status"    => "success",
                            "msg"       => "Data has been saved successfully!",
                            "data"      => []
                        ];
                    }else{
                        DB::rollback();
                        return [
                            "status"    => "error",
                            "msg"       => $result_student['msg'],
                            "data"      => []
                        ];
                    }
                }
            }
            
            DB::commit();
            return [
                "status"    => "success",
                "msg"       => "Data has been saved successfully!",
                "data"      => []
            ];
        }catch (\Exception $e) {
            DB::rollback();
            return [
                "status"    => "error",
                "msg"       => $e->getMessage(),
                "data"      => []
            ];
        } 
    }

    public function update($id, $request)
    {
        DB::beginTransaction();
        try {
            $data   = [
                "name"      => $request->get('name'),
                'email'     => $request->get('email')
            ];

            if( !empty($request->get('password')) ) {
                $data['password'] = Hash::make($request->get('password'));
            }

            if( $request->avatar ) {
                $avatar   = $request->avatar;
                $folder = 'avatars';
                $res    = $this->uploadFileOnly($avatar,$folder);
    
                $data['avatar']   = $res['path'];
            }

            $User   = User::find($id);
            $User->update($data);

            $User->assignRole($request->get('role'));

            UserGroup::updateOrCreate(
                [
                    "fk_user" => $User->id,
                ],
                [
                    "fk_group" => $request->get('fk_group')
                ]
            );

            $group = $this->GroupRepository->FetchById($request->get('fk_group'));

            if( $group->fk_cbt_group > 0 ) {
                if($request->get('role') == "admin") {
                    $data_array   = [
                        "username"      => $request->get('email'),
                        "password"      => $request->get('password'),
                        "nama"      => $request->get('name'),
                        "opsi1"      => '-',
                        "opsi2"      => '-',
                        "keterangan"      => '-',
                        "level"      => 'admin',
                    ];
                    if( $User->fk_cbt_user > 0 ) {
                        $newReq = new \Illuminate\Http\Request($data_array);
                        $result_admin = $this->CATUserRepository->update($User->fk_cbt_user,$newReq);
    
                        if( $result_admin['status'] == "success" ) {
    
                            $User->update([
                                "fk_cbt_user" => $result_admin['data']->id
                            ]);
            
                            DB::commit();
                            return [
                                "status"    => "success",
                                "msg"       => "Data has been saved successfully!",
                                "data"      => []
                            ];
                        }else{
                            DB::rollback();
                            return [
                                "status"    => "error",
                                "msg"       => $result_admin['msg'],
                                "data"      => []
                            ];
                        }
                    }else{
                        DB::rollback();
                            return [
                                "status"    => "error",
                                "msg"       => 'Not synced yet',
                                "data"      => []
                            ];
                    }

                }else{ // student
                    $data_array   = [
                        "user_grup_id"      => $group->fk_cbt_group,
                        "user_name"      => $request->get('email'),
                        "user_password"      => $request->get('password'),
                        "user_email"      => $request->get('email'),
                        "user_regdate"      => Carbon::now(),
                        "user_ip"      => null,
                        "user_firstname"      => $request->get('name'),
                        "user_birthdate"      => null,
                        "user_birthplace"      => null,
                        "user_level"      => 1,
                        "user_detail"      => null,
                    ];
                    $newReq = new \Illuminate\Http\Request($data_array);
                    $result_student = $this->CATStudentRepository->update($User->fk_cbt_student,$newReq);

                    if( $result_student['status'] == "success" ) {

                        $User->update([
                            "fk_cbt_student" => $result_student['data']->user_id
                        ]);
        
                        DB::commit();
                        return [
                            "status"    => "success",
                            "msg"       => "Data has been saved successfully!",
                            "data"      => []
                        ];
                    }else{
                        DB::rollback();
                        return [
                            "status"    => "error",
                            "msg"       => $result_student['msg'],
                            "data"      => []
                        ];
                    }
                }
            }

            DB::commit();
            return [
                "status"    => "success",
                "msg"       => "Data has been saved successfully!",
                "data"      => []
            ];
        }catch (\Exception $e) {
            DB::rollback();
            return [
                "status"    => "error",
                "msg"       => $e->getMessage(),
                "data"      => []
            ];
        } 
    }

    public function delete($id) {
        User::destroy($id);
        UserGroup::where('fk_user',$id)->delete();
        return [
            "status"    => "success",
            "msg"       => "Deleted Successfuly",
            "data"      => []
        ];
    }
    
}