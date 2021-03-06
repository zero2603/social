<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User as UserModel;
use App\UserGroup;
use App\ProvinceGroup;
use Session;
use URL;
use Illuminate\Support\Facades\Hash;

class User extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize(config('auth.action.LIST_USERS'));
        $request = Request::capture();
        $filterData = isset($_GET['filter'])?$_GET['filter']:array();
        $currentUser = Auth::user();
        $users = UserModel::where(function ($query) use ($filterData, $currentUser) {

            foreach ($filterData AS $key => $value){
                if (isset($value) && $value){
//                    $query->where($key, $value);
                }
            }

            if ($currentUser->Group->key == config('auth.usergroup.agency')){
                $query->where('parent_id', '=', $currentUser->id);
            }

            if (isset($filterData['group_id']) && $filterData['group_id']){
                $query->where('group_id', $filterData['group_id']);
            }
            if (isset($filterData['gender']) && $filterData['gender']){
                $query->where('gender', $filterData['gender']);
            }
            if (isset($filterData['start']) && isset($filterData['end']) && $filterData['start'] && $filterData['end']){
                $query->where('created_at', '>=', $filterData['start']);
                $query->where('created_at', '<=', $filterData['end']);
            }

            if (isset($filterData['age_from']) && isset($filterData['age_to']) && $filterData['age_to'] && $filterData['age_from']){
//                $query->where('YEAR(CURDATE()) - YEAR(birthdate)', '>=', $filterData['age_from']);
            }


            })
            ->paginate(20);
        $dataURL = $request->query();
        unset($dataURL['page']);
        $users->withPath('admin?'.http_build_query($dataURL));
        $total = $users->total();

        $label = array();
        $label['title'] = __('admin.USER');
        if ($currentUser->Group->key == config('auth.usergroup.agency')){
            $label['title'] = __('admin.LIST_EMPLOYEE');
        }

        $userGroup = UserGroup::all();

        $provinceGroup = ProvinceGroup::getListProvince();


        return view('admin.user.list', [
            'label' => $label,
            'items' => $users,
            'total' => $total,
            'group' => $userGroup,
            'filter' => $filterData,
            'province' => $provinceGroup
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userGroup = UserGroup::all();
        $provinceGroup = ProvinceGroup::getListProvince();
    	return view('admin.user.create', [
            'group' => $userGroup,
            'province' => $provinceGroup
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
        $new_user = $request->get('data');

        $new_user['password'] = Hash::make($new_user['password']);


        $id = UserModel::create($new_user)->id;

        $request->validate([
            'avatar' => 'sometimes|mimes:jpeg,bmp,png|max:20000',
        ]);

        $filename = null;
        if($request->hasFile('avatar')) {
            $filename = (string) time().'.'.$request->avatar->getClientOriginalExtension();
            $request->avatar->storeAs('user'.$id.'/avatar', $filename);
        }

        $user = UserModel::find($id);
        $user['avatar'] = env('APP_URL').'/storage/app/public/user'.$id.'/avatar/'.$filename;
        $user->save();

        $favourite = $request->get('favourite');

        $plans = array();
        if (!empty($favourite)){
            foreach ($favourite AS $value){
                $plans[] = array(
                    'user_id' => $id,
                    'hobby_id' => $value
                );
            }
        }
        if (!empty($plans))DB::table('user_hobby_map')->insert( $plans );

        return redirect('/admin?view=User');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public static function show($id)
    {
        $user = UserModel::find($id);
        
        // store user id in session for use update avatar
        Session::put('current_user_id', $id);

        // show the view and pass the nerd to it
        return view('admin.user.detail', ['item' => $user]);
    }

    public static function block(Request $request){
        $current = Auth::user();
        $id =  $request->input('id');
        if ($id == $current->id){
            return redirect(url('admin?view=User'))->withErrors(__('admin.CANNOT_BLOCK_YOURSELF'));
        }
        $user = UserModel::find($id);
        if ($user->is_admin == 1 && $current->is_admin != 1){
            return redirect(url('admin?view=User'))->withErrors(__('admin.CANNOT_BLOCK_ADMINISTRATOR'));
        }

        if ($current->is_admin != 1){
            if ($user->parent_id != $current->id){
                return redirect(url('admin?view=User'))->withErrors(__('admin.CANNOT_BLOCK_THIS_USER'));
            }
        }

        $user->is_blocked = !$user->is_blocked;
        $result = $user->save();
        if ($result) {
            return redirect('admin?view=User')->with('success', [__('admin.SAVE_SUCCESS')]);
        }else{
            return redirect('admin?view=User')->withErrors(__('admin.SAVE_FAIL'));
        }

    }
    
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // console_log($id);
    	$user = UserModel::find($id);

        $provinceGroup = ProvinceGroup::getListProvince();

        return view('admin.user.detail', [
            'item' => $user,
            'province' => $provinceGroup
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id =  $request->input('id');
        $user = UserModel::find($id);
        $data = $request->get('data');

        foreach ($data as $key => $value) {
            $user->$key = $value;
        }

        $result = $user->save();
        if ($result)
        {
            $favourite = $request->get('favourite');

            $plans = array();
            $plans = array();
            if (!empty($favourite)){
                foreach ($favourite AS $value){
                    $plans[] = array(
                        'user_id' => $id,
                        'hobby_id' => $value
                    );
                }
            }

            DB::table('user_hobby_map')->insert( $plans );

            return redirect('admin?view=User&layout=edit&id='.$id)->with('success', [__('admin.SAVE_SUCCESS')]);
        }else{
            return redirect('admin?view=User&layout=edit&id='.$id)->withErrors(__('admin.SAVE_FAIL'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id =  $request->input('id');
        UserModel::destroy($id);
        // redirect to previous url after destroy
        Session::put('pre_url', URL::previous());
        console_log(Session::get('pre_url'));
        return redirect(Session::get('pre_url'));
    }

    public function resetUserPassword(Request $request) {
        $id = $request->input('id');
        $user = UserModel::find($id);

        $new_password = str_random(10);
        $user->password = Hash::make($new_password);
        // ở đây cần gửi mật khẩu mới qua mail cho người dùng
        $user->save();
        return redirect('admin?view=User');
    }

    public function updateUserAvatar(Request $request) {
        $id = $request->get('user_id');
        $selectedUser = UserModel::find($id);
        $file = $request->file();

        if ($file){
            foreach ($file AS $value){
                $file_name = time() . '_' . $value->getClientOriginalName();
                $file_path = 'storage/app/user'.$id.'/avatar/';
                $newFile = $value->move($file_path, $file_name);
                $url = $file_path . $file_name;
                $selectedUser->avatar = $url;
                $selectedUser->save();
            }
        }



        return redirect('admin?view=User&layout=edit&id='.$id);

        // $user = UserModel::find($id);

        // $request->validate([
        //     'avatar' => 'sometimes|mimes:jpeg,bmp,png|max:20000',
        // ]);

        // if($request->hasFile('avatar')) {
        //     $filename = (string) time().'.'.$request->avatar->getClientOriginalExtension();
        //     $request->avatar->storeAs('user'.$id.'/avatar', $filename);
        // }

        // $user->save();
        // return redirect('admin?view=User');
    }

    public function checkVip(){
        $id = 1;
        $data = \App\User::checkVip($id);
        echo "<pre>";
        print_r($data);
        die;
    }
}