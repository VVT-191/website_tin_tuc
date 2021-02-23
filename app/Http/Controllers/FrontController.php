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
    
class FrontController extends Controller
{
    public function __construct(){
        @session_start();

        $logo = System::select('Description')->where('Code','logo')->first();
        view()->share('logo',$logo);
        $favicon = System::select('Description')->where('Code','favicon')->first();
        view()->share('favicon',$favicon);

        $Social = Social::where('Status',1)->selectRaw('Name, Font, Alias')->orderBy('Sort','ASC')->get();
        view()->share('Social',$Social);

        $Page = Page::where('Status',1)->selectRaw('Name, Font, Alias')->orderBy('Sort','ASC')->get();
        view()->share('Page',$Page);

        $copyright = System::select('Description')->where('Code','copyright')->first();
        view()->share('copyright',$copyright);
    }
    public function home(){
        $PageInfo = Page::where('Status',1)
        ->selectRaw('Name,Images, Alias, MetaTitle, MetaDescription, MetaKeyword')->first();

        $News = DB::table('news as a')
        ->join('news_cat as b', 'a.RowIDCat','=','b.RowID')
        ->selectRaw('a.*, b.Name as CategoryName')
        ->where('a.RowIDCat',1)
        ->orderBy('a.RowID','DESC')
        ->limit(6)->get();


        $NewsSale = DB::table('news as a')
        ->join('news_cat as b', 'a.RowIDCat','=','b.RowID')
        ->selectRaw('a.*, b.Name as CategoryName')
        ->where('a.RowIDCat',2)
        ->orderBy('a.RowID','DESC')
        ->limit(4)->get();

        $NewsViews = DB::table('news as a')
        ->join('news_cat as b', 'a.RowIDCat','=','b.RowID')
        ->selectRaw('a.*, b.Name as CategoryName')
        ->orderBy('a.Views','DESC')
        ->limit(4)->get();
        return view('front.home.home',compact('PageInfo','News','NewsSale','NewsViews'));
    }
    


    public function search(Request $request){
        $PageInfo = Page::where('Status',0)->where('Alias','tim-kiem')
        ->selectRaw('Name, Alias, MetaTitle, MetaDescription, MetaKeyword, Description')->first();

        if(isset($request->keyword) && $request->keyword !=NULL){
            $searchList = News::where('Status',1)
            ->where('Name','like','%'.$request->keyword.'%')
            ->selectRaw('Name, Alias, Images,SmallDescription')
            ->paginate(6);

        }else{
            $searchList = NULL;
        }
        
        return view('front.search.search',compact('PageInfo','searchList'));


    }
        public function slugHtml(Request $request, $slug){
            $newsDetail = DB::table('news as a')
            ->join('news_cat as b','a.RowIDCat','=','b.RowID')
            ->where('a.Status',1)
            ->selectRaw('a.Alias,a.Name,a.Images,a.MetaTitle,a.MetaDescription,
            a.MetaKeyword,a.Description,a.created_at,a.Views,b.Name as NewsCatName,b.Alias as NewsCatAlias')
            ->orderBy('a.Views','DESC')
            ->first();
    
            return view('front.news.detail',compact('newsDetail')); 
        }
        public function slug($slug, Request $request){
            $newsCat = Page::where('Status',1)->where('Alias', $slug)->first();
           


            if(isset($newsCat) && $newsCat != NULL){
                if(isset($request->sapxep) && $request->sapxep =='luotxem'){
                    $listNews = DB::table('news as a')
                ->join('news_cat as b', 'a.RowIDCat','=','b.RowID')
                ->selectRaw('a.Alias, a.Images, a.Name, a.SmallDescription') 
                ->orderby('a.Views','DESC')
                ->paginate(12);
                    $sort = 'luotxem';

                }else{
                    $listNews = DB::table('news as a')
                ->join('news_cat as b', 'a.RowIDCat','=','b.RowID')
                ->selectRaw('a.Alias, a.Images, a.Name, a.SmallDescription') 
                ->orderby('a.RowID','DESC')
                ->paginate(12);
                $sort = 'timmoi';

                }
                
                return view('front.news.cat',compact('newsCat','listNews','sort')); 
            }
    
        }



    public function contact(){
        $PageInfo = Page::where('Status',1)->where('Alias','lien-he')
        ->selectRaw('Name, Alias, MetaTitle, MetaDescription, MetaKeyword, Description')->first();

        $Map = System::where('Status',1)
        ->where('Code','map')
        ->selectRaw('Description')->first();
        return view('front.contact.contact',compact('PageInfo','Map'));
     }
    

     public function contactSendEmail(Request $request){
         if($request->txtEmail != '' 
         && $request->txtName != ''
         && $request->txtPhone != '' 
         && $request->txtMessage != '' ){
            $Contact = new Contact;
            $Contact->Name = $request->txtName;
            $Contact->Phone = $request->txtPhone;
            $Contact->Email = $request->txtEmail;
            $Contact->Message = $request->txtMessage;
            $Flag = $Contact->save();

            if($Flag == true){
                echo 'finish';
            }else{
                echo 'error';
            }
         }
         else{
             echo 'error_empty';
         }

     }

     

     public function about(){
        $PageInfo = Page::where('Status',1)->where('Alias','ve-chung-toi')
        ->selectRaw('Name, Alias, MetaTitle, MetaDescription, MetaKeyword, Description')->first();

        return view('front.about.about',compact('PageInfo'));

     }

     public function subEmail(Request $request){
         if($request->txtEmailSub != ""){
             echo 'Email Oke';
         }
         $Newsletter = Newsletter::where('Email',$request->txtEmailSub)->get();
         if(isset($Newsletter) && count($Newsletter) >0)
            {echo 'error_exit_email';

         }else {
            $Newsletter = new Newsletter;
            $Newsletter->Email = $request->txtEmailSub;
           

            $Flag = $Newsletter->save();
            if($Flag == true){
                echo 'finish';
            }
            else{
                echo 'error';
            }
         }}

        } 

