<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Staffs;
use App\User;
use DB;

class AdminController extends Controller
{

    private $response_array = array();

    public function getAdminList($rows)
    {
        $user = User::with(['staffs'])
                ->withTrashed()
                ->where('role_id', 1)
                ->orderBy('active', 'desc')
                ->orderBy('user_id', 'desc')
                ->paginate($rows);
        $tableInfo = (object)[
            'user' => $user,
            'firstItem' => $user->firstItem(),
            'lastItem' => $user->lastItem(),
            'total' => $user->total(),
        ];
        return response()->json($tableInfo);
    }

    public function store(Request $request)
    {
        $photo = json_decode(json_encode($request->data['imageURI']), FALSE)->name;
        $photo_src = explode(',', json_decode(json_encode($request->data['imageURI']), FALSE)->src);

        // Start transaction!
        DB::beginTransaction();

        /**
         * User Transaction
         */
        try {
            $user = new User();
            $user->username = $request->data['username'];
            $user->password = $request->data['password'];
            $user->role_id = $request->data['role_id'];
            $user->save();
        } catch(\Exception $e) {
            DB::rollback();
            $response_array['icon'] = 'remove red';
            $response_array['header'] = 'Create Account';
            $response_array['body'] = 'Account creation failed!';
        }

        /**
         * Staff Transaction
         */
        try {
            $staff = new Staffs();
            $staff->user_id = $user->user_id;
            $staff->email_address = $request->data['email_address'];
            $staff->firstname = $request->data['firstname'];
            $staff->lastname = $request->data['lastname'];
            $staff->photo = $photo;
            $staff->save();
        } catch(\Exception $e) {
            DB::rollback();
            $response_array['icon'] = 'remove red';
            $response_array['header'] = 'Create Account';
            $response_array['body'] = 'Account creation failed!';
        }

        /**
         * Save profile photo to directory
         */
        try {
            if($photo != 'default.png') {
                $ifp = fopen(public_path() .'/images/profile_images/' . $photo, "wb");
                if($ifp) fwrite($ifp, base64_decode($photo_src[1]));
                fclose($ifp);
            }
        } catch(\Exception $e) {
            DB::rollback();
            $response_array['icon'] = 'remove red';
            $response_array['header'] = 'Create Account';
            $response_array['body'] = 'Account creation failed!';
        }

        $response_array['icon'] = 'check green';
        $response_array['header'] = 'Create Account';
        $response_array['body'] = 'Account succesfully created!';
        
        // Continue query execution
        DB::commit();

        return response()->json($response_array);
    }

    public function update(Request $request, $user_id)
    {
        $photo = json_decode(json_encode($request->data['imageURI']), FALSE)->name;
        $photo_src = explode(',', json_decode(json_encode($request->data['imageURI']), FALSE)->src);

        // Start transaction!
        DB::beginTransaction();

        // Staff instance
        $staff = Staffs::where('user_id', $user_id)->first();

        /**
         * Save profile photo to directory
         */
        try {
            if($photo != 'default.png' && $photo != $staff->photo) {
                $ifp = fopen(public_path() .'/images/profile_images/' . $photo, "wb");
                if($ifp) fwrite($ifp, base64_decode($photo_src[1]));
                fclose($ifp);
            }
        } catch(\Exception $e) {
            DB::rollback();
            $response_array['icon'] = 'remove red';
            $response_array['header'] = 'Update Account';
            $response_array['body'] = 'Account update failed!';
        }

        /**
         * Staff Transaction
         */
        try {
            $staff->email_address = $request->data['email_address'];
            $staff->firstname = $request->data['firstname'];
            $staff->lastname = $request->data['lastname'];
            if($photo != $staff->photo) $staff->photo = $photo;
            $staff->save();
        } catch(\Exception $e) {
            DB::rollback();
            $response_array['icon'] = 'remove red';
            $response_array['header'] = 'Update Account';
            $response_array['body'] = 'Account update failed!';
        }

        $response_array['icon'] = 'check green';
        $response_array['header'] = 'Update Account';
        $response_array['body'] = 'Account succesfully updated!';

        // Continue query execution
        DB::commit();

        return response()->json($response_array);
    }

    public function destroy($user_id)
    {
        $params = explode('-', $user_id);
        $user_id = $params[0];
        $command = $params[1];
        if($user_id == 27) {
            // Do not delete primary admin account
            $response_array['icon'] = 'remove red';
            $response_array['header'] = 'Delete Account';
            $response_array['body'] = 'This account cannot be deleted!';
        } else {
            try {
                $user = User::withTrashed()->find($user_id);
                if($command == 'delete'){
                    $user->active = 0;
                    $user->save();
                    User::destroy($user_id);
                    $response_array['icon'] = 'check green';
                    $response_array['header'] = 'Delete Account';
                    $response_array['body'] = 'Account succesfully deleted!';
                } else {
                    $user->restore();
                    $user->active = 1;
                    $user->save();
                    $response_array['icon'] = 'check green';
                    $response_array['header'] = 'Restore Account';
                    $response_array['body'] = 'Account succesfully restored!';
                }
            } catch(\Exception $e) {
                $response_array['icon'] = 'remove red';
                $response_array['header'] = 'Delete Account';
                $response_array['body'] = 'Account delete failed!';
            }
        }

        return response()->json($response_array);
    }

}
