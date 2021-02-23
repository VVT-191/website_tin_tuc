<?php

namespace App\Http\Controllers;
use DB;
use File;
use Image;
use Illuminate\Http\Request;
use App\User;
use App\Model\UserLevel;
use App\Model\System;
use App\Model\Page;
use App\Model\Social;
use App\Model\Newsletter;
use App\Model\Contact;
use App\Model\NewsCategory;
use App\Model\News;
    
class BackController extends Controller
{
    public function __construct(){
        @session_start();
    }
    public function home(){
       return view('back.home.home');
    }

    public function staff_profile(){
        return view('back.staff.profile');

    }
    public function staff_profile_post(Request $request){
        if($request->fullname == ''|| $request->email == '' || $request->phone == ''){
            return redirect('/admin/staff/profile')->with(['flash_level'=>'danger','flash_message'=>'Vui lòng điền vào các ô có dấu *']);
        }
        $User = User::find($request->id);
        $User->fullname = $request->fullname;
        $User->address = $request->address;
        $User->email = $request->email;
        $User->phone = $request->phone;

        if(isset($request->password) && $request->password != ''){
            $User->password = bcrypt($request->password);
        }
        $Flag =$User->save();

        if($Flag == true ){
            return redirect('admin/staff/profile')->with([session()->flash('success', 'Cập nhập thành công')]);

        }
        else{
            return redirect('admin/staff/profile')->with(['flash_level'=> 'danger', 'flash_message' => 'Chỉnh sửa tài khoản không thành công']);
        }
        
    }

    public function staff_list(){
        $User = DB::table('users as a')
        ->join('users_level as b', 'a.level', '=', 'b.id')
        ->selectRaw('a.id, a.fullname, a.address, a.email, a.phone, b.name')->get();



        return view('back.staff.list', compact('User'));
    }
    public function staff_add(){
        $UserLevel = UserLevel::where('status',1)->get();
        return view('back.staff.add',compact('UserLevel'));
    }
    public function staff_add_post(Request $request){
        if($request->fullname == ''|| $request->email == '' || $request->phone == ''||$request->username == ''||$request->password ==''){
            return redirect('/admin/staff/add')->with([session()->flash('danger', 'Vui lòng điền ô có dấu *')]);
        }
        $User = new User;
        $User->level= $request->level;
        $User->status = 1;
        $User->username = $request->username;
        $User->password = bcrypt($request->password);
        $User->fullname = $request->fullname;
        $User->address = $request->address;
        $User->email = $request->email;
        $User->phone = $request->phone;
        $Flag = $User->save(); 
        if($Flag == true){
            return redirect('/admin/staff/list')->with([session()->flash('success', 'Thêm thành công')]);
        }
        else{
            return redirect('/admin/staff/list')->with(['flash_level'=>'danger','flash_message'=>'Lỗi thêm nhân viên']);
        }

    }
    public function staff_edit(Request $request, $id){
        $User = User::find($id);
        $UserLevel = UserLevel::where('status',1)->get();
        return view('back.staff.edit',compact('User','UserLevel'));
    }
    public function staff_edit_post(Request $request, $id){
        if($request->fullname == ''|| $request->email == '' || $request->phone == ''){
            return redirect('/admin/staff/edit/'.$id)->with([session()->flash('danger', 'Vui lòng điền ô có dấu *')]);
        }
        $User = User::find($id);
        $User->level= $request->level;
        $User->status = $request->status;
        
        if(isset($request->password) && $request->password != ''){
            $User->password = bcrypt($request->password);
        }
        $User->fullname = $request->fullname;
        $User->address = $request->address;
        $User->email = $request->email;
        $User->phone = $request->phone;
        $Flag = $User->save(); 
        if($Flag == true){
            return redirect('admin/staff/list')->with([session()->flash('success', 'Sửa thành công')]);
        }
        else{
            return redirect('admin/staff/edit/'.$id)->with(['flash_level'=>'danger','flash_message'=>'Lỗi chỉnh sửa nhân viên']);
        }
   }

   public function staff_delete(Request $request, $id){
    $User = User::find($id);
    $Flag =$User->delete();
    if($Flag == true){
        return redirect('admin/staff/list')->with([session()->flash('success', 'Sửa thành công')]);
    }
    else{
        return redirect('admin/staff/list')->with(['flash_level'=>'danger','flash_message'=>'Lỗi xóa nhân viên']);
    }
   }


   //system management
   public function system(){
       $name = System::where('Status',1)->where('Code','name')->first();
       $logo = System::where('Status',1)->where('Code','logo')->first();
       $email = System::where('Status',1)->where('Code','email')->first();
       $phone = System::where('Status',1)->where('Code','phone')->first();
       $address = System::where('Status',1)->where('Code','address')->first();
       $copyright = System::where('Status',1)->where('Code','copyright')->first();
       $favicon = System::where('Status',1)->where('Code','favicon')->first();
       $map = System::where('Status',1)->where('Code','map')->first();

      return view('back.system.system',compact('name','logo','email','favicon','address','copyright','phone','map'));
   }

   public function system_post(Request $request){
    if($request->name == ''|| $request->email == '' || $request->phone == ''){
        return redirect('/admin/sytem')->with(['flash_level'=>'danger','flash_message'=>'Vui lòng điền vào các ô có dấu *']);
    }

    System::where('Status',1)
    ->where('Code','name')
    ->update(['Description'=>$request->name]);

    System::where('Status',1)
    ->where('Code','email')
    ->update(['Description'=>$request->email]);

    System::where('Status',1)
    ->where('Code','phone')
    ->update(['Description'=>$request->phone]);

    System::where('Status',1)
    ->where('Code','address')
    ->update(['Description'=>$request->address]);

    System::where('Status',1)
    ->where('Code','copyright')
    ->update(['Description'=>$request->copyright]);
    System::where('Status',1)
    ->where('Code','map')
    ->update(['Description'=>$request->map]);

    if (!empty($request->file('logo'))){
        $logo = System::where('Status',1)->where('Code','logo')->first();
        $path = 'images/logo/'.$logo->Description;
        if(File::exists($path)){
            File::delete($path);
        }

        $name = $request->file('logo')->getClientOriginalName();
        $request->file('logo')->move('images/logo/',$name);

        $logo->Description = $name;
        $logo->save();
    }

    if (!empty($request->file('favicon'))){
        $favicon = System::where('Status',1)->where('Code','favicon')->first();
        $path ='images/favicon/'.$favicon->Description;
        if(File::exists($path)){
            File::delete($path);
        }

        $name = $request->file('favicon')->getClientOriginalName();
        $request->file('favicon')->move('images/favicon/',$name);

        $favicon->Description = $name;
        $favicon->save();
    }
    return redirect('admin/system')->with([session()->flash('success', 'Sửa thành công')]);

   }

   //page management--------------------
   public function page_list(){
    $Page = Page::get();



    return view('back.page.list', compact('Page'));
 

   }
   public function page_edit(Request $request, $id){
       $Page = Page::find($id);
       
    return view('back.page.edit', compact('Page'));
   }
   public function page_edit_post(Request $request, $id){
    if($request->Name == ''){
        return redirect('admin/page/edit/'.$id)->with([session()->flash('danger', 'Vui lòng điền vào phần dấu *')]);
            }
        $Page = Page::find($id);
        $Page->Name= $request->Name;
        $Page->Font = $request->Font;
        $Page->Alias = $request->Alias;
        $Page->Status = $request->Status;
        $Page->Sort = $request->Sort;
        $Page->MetaTitle = $request->MetaTitle;
            $Page->MetaDescription = $request->MetaDescription;
            $Page->MetaKeyword = $request->MetaKeyword;
           
            $Page->Description = $request->Description;
        // the images
        if($request->hasFile('Images')){
            $file = $request->file('Images');
            $random_digit =rand(00000000,99999999);
            $name = $random_digit.'-'.$file->getClientOriginalName();
            $duoi = strtolower($file->getClientOriginalExtension());

            if($duoi != 'png' && $duoi != 'jpg' && $duoi != 'ipeg' && $duoi != 'svg'){
                return back()->with([session()->flash('danger', 'Phần mở rộng ảnh không được hỗ trợ.')]);
            }
            // xoa anh dien dien cu
            if($Page->Images !=''){
                if(file_exists('images/page/'.$Page->Images)){
                    unlink('images/page/'.$Page->Images);
                }
            }
            // upload file ảnh
            $file->move('images/page/',$name);
            $img = Image::make('images/page/'.$name);
            $filePath = "images/page/".date('Ymd');
            if(!file_exists($filePath)){
                mkdir("images/page/".date('Ymd'),0777,true);
            }
            $img->fit(300,250);
            $img->save('images/page/'.date('Ymd').'/'.$name);
            if(file_exists('images/page/'.$name)){
                unlink('images/page/'.$name);
            }
            $Page->Images = date('Ymd').'/'.$name;
             

        }
       
       
    
    $Flag = $Page->save(); 
    if($Flag == true){
        return redirect('admin/page/edit/'.$id)->with([session()->flash('success', 'Sửa thành công')]);
    }
    else{
        return redirect('admin/page/edit/'.$id)->with(['flash_level'=>'danger','flash_message'=>'Lỗi chỉnh sửa trang']);
    }
   }

     //socical management-----------


     public function social_list(){
        $Social = Social::get();
       
        return view('back.social.list', compact('Social'));
     }
     public function social_edit(Request $request, $id){
        $Social = Social::find($id);
        
     return view('back.social.edit', compact('Social'));
    }

    public function social_edit_post(Request $request, $id){
        if($request->Name == ''|| $request->Font == ''){
            return redirect('/admin/social/edit/'.$id)->with(['flash_level'=>'danger','flash_message'=>'Vui lòng điền vào các ô có dấu *']);
        }
        $Social = Social::find($id);
        $Social->Name= $request->Name;
        $Social->Font = $request->Font;
    
        $Social->Status = $request->Status;
        $Social->Sort = $request->Sort;
       
        $Flag = $Social->save(); 
        if($Flag == true){
            return redirect('admin/social/list')->with([session()->flash('success', 'Sửa thành công')]);
        }
        else{
            return redirect('admin/social/edit/'.$id)->with(['flash_level'=>'danger','flash_message'=>'Lỗi chỉnh sửa']);
        }
       }

    
       public function newsletter_list(){
        $Newsletter = Newsletter::get();
    
    
    
        return view('back.newsletter.list', compact('Newsletter'));
     
    
       }
       

       public function newsletter_edit(Request $request, $id){
        $Newsletter = Newsletter::find($id);
        
     return view('back.newsletter.edit', compact('Newsletter'));
    }
    public function newsletter_edit_post(Request $request, $id){
     if($request->Email == ''){
         return redirect('/admin/newsletter/edit/'.$id)->with([session()->flash('danger', 'Vui lòng điền ô có dấu *')]);
     }
     $Newsletter = Newsletter::find($id);
     $Newsletter->Email= $request->Email;
     $Newsletter->IsViews = $request->IsViews;
 
  
    
     $Flag = $Newsletter->save(); 
     if($Flag == true){
         return redirect('admin/newsletter/list')->with([session()->flash('success', 'Sửa thành công')]);
     }
     else{
         return redirect('admin/newsletter/edit/'.$id)->with([session()->flash('danger', 'Lỗi chỉnh sửa')]);
     }
    }
    public function newsletter_delete(Request $request, $id){
        $Newsletter = Newsletter::find($id);
        $Flag = $Newsletter->delete(); 
     if($Flag == true){
         return redirect('admin/newsletter/list')->with([session()->flash('success', 'Xóa thành công')]);
     }
     else{
         return redirect('admin/newsletter/list/'.$id)->with([session()->flash('danger', 'Xóa không thành công')]);
     }
    
       
    }


    //contact ----------------------------------
    public function contact_list(){
        $Contact = Contact::get();
    
    
    
        return view('back.contact.list', compact('Contact'));
     
    
       }
       

       public function contact_edit(Request $request, $id){
        $Contact = Contact::find($id);
        
     return view('back.contact.edit', compact('Contact'));
    }
    public function contact_edit_post(Request $request, $id){
     if($request->Email == ''||$request->Name == ''||$request->Phone == ''||$request->Message == ''){
         return redirect('/admin/contact/edit/'.$id)->with([session()->flash('danger', 'Vui lòng điền ô có dấu *')]);
     }
     $Contact = Contact::find($id);
     $Contact->Email= $request->Email;
     $Contact->Name= $request->Name;
     $Contact->Phone= $request->Phone;
     $Contact->IsViews = $request->IsViews;
     $Contact->Message= $request->Message;
 
  
    
     $Flag = $Contact->save(); 
     if($Flag == true){
         return redirect('admin/contact/list')->with([session()->flash('success', 'Sửa thành công')]);
     }
     else{
         return redirect('admin/contact/edit/'.$id)->with([session()->flash('danger', 'Lỗi chỉnh sửa')]);
     }
    }
    public function contact_delete(Request $request, $id){
        $Contact = Contact::find($id);
        $Flag = $Contact->delete(); 
     if($Flag == true){
         return redirect('admin/contact/list')->with([session()->flash('success', 'Xóa thành công')]);
     }
     else{
         return redirect('admin/contact/list/'.$id)->with([session()->flash('danger', 'Xóa không thành công')]);
     }
    
       
    }
 


    public function news_cat_list(){
        $NewsCategory = NewsCategory::where('Status',1)->get();
        return view('back.news_cat.list',compact('NewsCategory'));
    }

    
    public function news_cat_getedit($RowID){
        $NewsCategory = NewsCategory::find($RowID);
        return view('back.news_cat.edit',compact('NewsCategory'));
    }

    public function news_cat_edit(Request $request, $RowID){ 
        if($request->Name == ''){
            return redirect('/admin/news_cat/edit/'.$RowID)->with([session()->flash('danger', 'Vui lòng điền ô có dấu *')]);
        }


        $NewsCategory = NewsCategory::find($RowID);
        $NewsCategory->Status = $request->Status;
        $NewsCategory->Name = $request->Name;
        $NewsCategory->Alias = $request->Alias;
        $Flag = $NewsCategory->save();
        if($Flag == true){
            return redirect('admin/news_cat/edit/'.$RowID)->with([session()->flash('success', 'Chỉnh sửa thành công')]);
        }
        else{
            return redirect('admin/news_cat/edit/'.$RowID)->with([session()->flash('danger', 'Chỉnh sửa không thành công')]);
        }
       
        return view('back.news_cat.edit',compact('NewsCategory'));
    }
    public function news_list(){
        $News = DB::table('news as a')
        ->join('news_cat as b', 'a.RowIDCat','=','b.RowID')
        ->selectRaw('a.*, b.Name as CategoryName')
        ->orderBy('a.RowID','DESC')
        ->get();
        return view('back.news.list',compact('News'));
    }

    public function news_getadd(){
        $NewsCategory = NewsCategory::get();
        return view('back.news.add',compact('NewsCategory'));
    }
    public function news_add(Request $request){
        if($request->Name == ''|| $request->Description == ''){
            return redirect('/admin/news/add')->with([session()->flash('danger', 'Vui lòng điền ô có dấu *')]);
        }

        $News = new News;
        $News->RowIDCat= $request->RowIDCat;
        $News->Status = $request->Status;
        $News->Name = $request->Name;
        $News->Alias = $request->Alias;
        $News->Views = $request->Views;
        $News->MetaTitle = $request->MetaTitle;
        $News->MetaDescription = $request->MetaDescription;
        $News->MetaKeyword = $request->MetaKeyword;
        $News->SmallDescription = $request->SmallDescription;
        $News->Description = $request->Description;
        if($request->hasFile('Images')){
            $file = $request->file('Images');
            $random_digit =rand(00000000,99999999);
            $name = $random_digit.'-'.$file->getClientOriginalName();
            $duoi = strtolower($file->getClientOriginalExtension());

            if($duoi != 'png' && $duoi != 'jpg' && $duoi != 'ipeg' && $duoi != 'svg'){
                return back()->with([session()->flash('danger', 'Phần mở rộng ảnh không được hỗ trợ.')]);
            }
            $file->move('images/news/',$name);
            $img = Image::make('images/news/'.$name);
            $filePath = "images/news/".date('Ymd');
            if(!file_exists($filePath)){
                mkdir("images/news/".date('Ymd'),0777,true);
            }
            $img->fit(208,141);
            $img->save('images/news/'.date('Ymd').'/'.$name);
            if(file_exists('images/news/'.$name)){
                unlink('images/news/'.$name);
            }
            $News->Images = date('Ymd').'/'.$name;
             

        }

        $Flag = $News->save(); 
        if($Flag == true){
            return redirect('/admin/news/list')->with([session()->flash('success', 'Thêm thành công')]);
        }
        else{
            return redirect('/admin/news/add')->with([session()->flash('danger', 'Lỗi thêm.')]);
        }
    }
    public function news_delete(Request $request, $RowID){
        $News = News::find($RowID);
        $Flag = $News->delete(); 
     if($Flag == true){
         return redirect('admin/news/list')->with([session()->flash('success', 'Xóa thành công')]);
     }
     else{
         return redirect('admin/news/list/'.$RowID)->with([session()->flash('danger', 'Xóa không thành công')]);
     }
    
       
    }
    public function news_getedit(Request $request, $RowID){ 
        $NewsCategory = NewsCategory::get();
        $News = News::find($RowID);
        return view('back.news.edit ',compact('News','NewsCategory'));
    }

    public function news_edit(Request $request,$RowID){
        if($request->Name == ''|| $request->Description == ''){
            return redirect('/admin/news/edit/'.$RowID)->with([session()->flash('danger', 'Vui lòng điền ô có dấu *')]);
        }

        $News = News::find($RowID);
        $News->RowIDCat= $request->RowIDCat;
        $News->Status = $request->Status;
        $News->Name = $request->Name;
        $News->Alias = $request->Alias;
        $News->Views = $request->Views;
        $News->MetaTitle = $request->MetaTitle;
        $News->MetaDescription = $request->MetaDescription;
        $News->MetaKeyword = $request->MetaKeyword;
        $News->SmallDescription = $request->SmallDescription;
        $News->Description = $request->Description;
        
       

        if($request->hasFile('Images')){
            $file = $request->file('Images');
            $random_digit =rand(00000000,99999999);
            $name = $random_digit.'-'.$file->getClientOriginalName();
            $duoi = strtolower($file->getClientOriginalExtension());

            if($duoi != 'png' && $duoi != 'jpg' && $duoi != 'ipeg' && $duoi != 'svg'){
                return back()->with([session()->flash('danger', 'Phần mở rộng ảnh không được hỗ trợ.')]);
            }

            if($News->Images !=''){
                if(file_exists('images/news/'.$News->Images)){
                    unlink('images/news/'.$News->Images);
                }
            }
            $file->move('images/news',$name);
            $img = Image::make('images/news/'.$name);
            $filePath = "images/news/".date('Ymd');
            if(!file_exists($filePath)){
                mkdir("images/news/".date('Ymd'),0777,true);
            }
            $img->fit(208,141);
            $img->save('images/news/'.date('Ymd').'/'.$name);
            if(file_exists('images/news/'.$name)){
                unlink('images/news/'.$name);
            }
            $News->Images = date('Ymd').'/'.$name;
             

        }
        $Flag = $News->save(); 
        if($Flag == true){
            return redirect('/admin/news/list')->with([session()->flash('success', 'Chỉnh sửa thành công')]);
        }
        else{
            return redirect('/admin/news/edit/'.$RowID)->with([session()->flash('danger', 'Lỗi Chỉnh sửa.')]);
        }
    }

}
