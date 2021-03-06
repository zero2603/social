<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProductCategory AS ProductCategoryModel;
use Illuminate\Support\Facades\Auth;

use App\Agency;

class ProductCategory extends Controller
{

    protected $type = [1,2,3];

    public function index()
    {
        $filter = isset($_GET['filter'])?$_GET['filter']:array();
        $type = isset($_GET['type'])?$_GET['type']:null;
        $title = __('admin.product_category_'.$type);

        if (!$type || (!in_array($type, $this->type))){
            return redirect('admin?view=ProductCategory&type=1');
        }

        $currentUser = Auth::user();

        $data = array();
        $data['filter'] = $filter;
        $data['type'] = $type;

        $items = ProductCategoryModel::getItems($data);
        return view('admin.ProductCategory.list', [
            'currentUser' => $currentUser,
            'items' => $items,
            'title' => $title,
            'type' => $type,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $rule = [
        'name'=>'required|max:30',
    ];

    public function create()
    {
        $currentUser = Auth::user();

        $type = isset($_GET['type'])?$_GET['type']:null;
        if (!$type || (!in_array($type, $this->type))){
            return redirect('admin?view=ProductCategory&type=1');
        }
        return view('admin.ProductCategory.create', [
            'type' => $type,
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
        $data = request()->get('data');
        $file = $request->file('image');
        if ($file){
            $file_name = time() . '_' . $file->getClientOriginalName();
            $file_path = 'storage/app/product/category/'.$data['type'].'/';
            $file->move($file_path, $file_name);
            $data['image'] = $file_path . $file_name;
        }

        $currentUser = Auth::user();
        if ($currentUser->is_admin != 1){
            $data['user_id'] = $currentUser->id;
        }
        $result = ProductCategoryModel::create($data);
        $type = isset($_GET['type'])?$_GET['type']:null;
        $url = url('admin?view=ProductCategory&type='.$type);
        if (!$result)
            return redirect($url)->withErrors(__('admin.SAVE_FAIL'));
        return redirect($url)->with('success', [__('admin.SAVE_SUCCESS')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = ProductCategoryModel::find($id);
        return View::make('admin.ProductCategory.detail')->with('item', $item);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $type = isset($_GET['type'])?$_GET['type']:null;
        $item = ProductCategoryModel::find($id);
//        return View::make('admin.ProductCategory.detail')->with('item', $item);
        return view('admin.ProductCategory.detail', [
            'item' => $item,
            'type' => $type,
            'currentUser' => Auth::user()
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
        $id = $request->get('id');
        $data = $request->get('data');
        $item = ProductCategoryModel::find($id);
        unset($data['user_id']);
        $file = $request->file('image');
        if ($file){
            $file_name = time() . '_' . $file->getClientOriginalName();
            $file_path = 'storage/app/product/category/'.$data['type'].'/';
            $newFile = $file->move($file_path, $file_name);

            $data['image'] = $file_path . $file_name;
        }

        foreach ($data as $key => $value) {
            $item->$key = $value;
        }

        $url = 'admin?view=ProductCategory&type='.$data['type'];
        if ($item->id) {
            $result = $item->save();
            if (!$result)
                return redirect($url)->withErrors(__('admin.SAVE_FAIL'));
            return redirect($url)->with('success', [__('admin.SAVE_SUCCESS')]);

        }else{
            return redirect($url)->withErrors(__('admin.SAVE_FAIL'));
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
        $id = $request->input('id');
        UserGroupModel::destroy($id);
        return redirect('admin?view=ProductCategory');
    }
}
