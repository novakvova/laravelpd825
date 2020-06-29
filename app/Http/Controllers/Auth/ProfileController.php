<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\User;

use Illuminate\Http\Request;

use Illuminate\Support\Str;

use Intervention\Image\ImageManagerStatic as Image;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=auth()->user();
        return view('auth.myprofile',  ['user' => $user]);
    }


    public function home()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function change(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'password'=>'required',
        ]);

        $base64_image= $request->get("base64Image");
        $img_url = Str::uuid().'.jpg';
        $path = public_path('images/105_').$img_url;
        my_image_resize(105,80, $path, $base64_image);
        $path = public_path('images/420_').$img_url;
        my_image_resize(420,320, $path, $base64_image);
        $path = public_path('images/840_').$img_url;
        my_image_resize(840,640, $path, $base64_image);
        $user = User::find(auth()->user()->getAuthIdentifier());
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = $request->get('password');
        $user->image = $request->get('base64Image');
        $user->save();
        return redirect('/home')->with('success', 'User is update');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
function my_image_resize($width, $height, $path, $data) //32x32
{
    list($type, $data) = explode(';', $data);
    list(, $data)      = explode(',', $data);
    $imgString = base64_decode($data);

    //Оригінал висота і ширина
    $image_resize=Image::make($data);
    $w= $image_resize->width();
    $h=$image_resize->height();
    $maxSize=0;
    //Обчислюємо максмильан знечення або ширина або висота
    if(($w>$h) and ($width>$height)) //204>247 and 32>32
        $maxSize=$width;
    else
        $maxSize=$height; //32
    //MaxSize=32
    $width=$maxSize; //32
    $height=$maxSize; //32
    $ration_orig=$w/$h; //204/247=0.82
    if(1>$ration_orig) //1>0.82 вірно
    {
        $width=ceil($height*$ration_orig); /*32*0.82=26.24 = 27 */     //34- all //10- records page  ceil(3.4)
    }
    else//Хибно
    {
        $height=ceil($width/$ration_orig);
    }
    //27x32

    //Створюємо новий файл
    $image=imagecreatefromstring($imgString);
    $tmp=imagecreatetruecolor($width,$height); //розмір нового зображення 27x32
    imagecopyresampled($tmp,$image,
        0,0,
        0,0,
        $width, $height,
        $w,$h
    );
    //Збереження зображення
    imagejpeg($tmp,$path,30);
    //imagepng($tmp,$path,5);
    //imagegif($tmp,$path);



    return $path;
//    //Очисчаємо память
    imagedestroy($image);
    imagedestroy($tmp);
}
