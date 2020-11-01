<?php

namespace App\Http\Controllers;

use App\Mail\MailtrapResponseAdvert;
use App\Mail\shareAdvert;
use App\Models\Advert;
use App\Models\Category;
use App\Models\City;
use App\Models\favorite;
use App\Models\ResponseMail;
use App\Models\ShareAd;
use App\Models\Subcategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Inertia\Inertia;

class AdvertController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*public function index($city,$category,$id)
    {
        $citie = City::where('slug',$city)->first();
        $adverts = Advert::with('subCategory')
        ->with('city')
        ->where('id_subCategory',$id)
        ->where('id_city',$citie->id)
        ->get();

        $infoUserConnected = $this->userAddAdvertToFavorite();

        return Inertia::render('Advert',[
            "adverts" => $adverts,
            "categorySelected" => $category,
            'infoUserFavorite' => $infoUserConnected
        ]);
    }*/

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make ($request->all(),[
            "title" => "required",
            "description" => "required",
            "isActive" => "required",
            "isPublished" => "required",
            "city" => "required",
            "category" => "required",
            "subCategory" => "required",
            "imageUrl" => "required"
        ]);
        if (!$validator->fails()) {
            $advertCreation = new Advert();
            $advertCreation->title = $request->title;
            $advertCreation->slug = Str::slug($request->title);
            $advertCreation->content = $request->description;
            $advertCreation->is_active = $request->isActive;
            $advertCreation->publication_date = $request->isPublished;
            $advertCreation->update_date = $request->isPublished;
            $advertCreation->slug_city = $request->city;
            $advertCreation->slug_category = $request->category;
            $advertCreation->slug_subcategory = $request->subCategory;
            $advertCreation->picture = $request->imageUrl;
            $advertCreation->user_id_advert = auth()->user()->id;
            $advertCreation->save();
            $msg = "Création de l'annonce avec succès";
            $type = 1;
        }
        else{
            $msg = "Tous les champs sont obligatoire";
            $type=0;
        }
        $cities = City::all();
        $categories = Category::all();
        $subCategories = Subcategory::all();

        return Inertia::render('CreateAd',[
            "cities" => $cities,
            "categories" => $categories,
            "subCategories" => $subCategories,
            'msg' => $msg,
            'type' => $type
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
        //
    }

    public function advertCategory($city,$category){

        $getAdvertFromCategory = Advert::with("subCategory")
        ->with("city")
        ->with('category')
        ->whereDate('publication_date', '<=', Carbon::today()->toDateString())
        ->where('is_active','=',"1")
        ->where('slug_city',$city)
        ->where('slug_category',$category)
        ->paginate(5);

        $getCategory = Category::where('slug',$category)->first();
        $getCity = City::where('slug',$city)->first();
        $infoUserConnected = $this->userAddAdvertToFavorite();

        return Inertia::render('Advert',[
            'adverts' => $getAdvertFromCategory,
            'categorySelected' => $getCategory,
            'cityPosition' => $getCity,
            'changeDisplay' => true,
            'infoUserFavorite' => $infoUserConnected
        ]);
    }

    public function advertSubCategory($city,$category,$subcategory)
    {
        $getAdvertFromSubCategory = Advert::with("subCategory")
        ->with("city")
        ->with('category')
        ->whereDate('publication_date', '<=', Carbon::today()->toDateString())
        ->where('is_active','=',"1")
        ->where('slug_city',$city)
        ->where('slug_category',$category)
        ->where('slug_subcategory',$subcategory)
        ->paginate(5);

        $getCategory = Category::where('slug',$category)->first();
        $getSubCategory = Subcategory::where('slug',$subcategory)->first();
        $getCity = City::where('slug',$city)->first();

        $infoUserConnected = $this->userAddAdvertToFavorite();

        return Inertia::render('Advert',[
            'categorySelected' => $getCategory,
            'subCategorySelected' => $getSubCategory,
            'cityPosition' => $getCity,
            'changeDisplay' => false,
            'switchBetweenAd' => $getAdvertFromSubCategory,
            'infoUserFavorite' => $infoUserConnected
        ]);
    }

    public function searchAdverts(Request $request)
    {
        $params = $request->query('title');

        $getAdvertsFromSearch = Advert::orderBy('publication_date', 'DESC')
        ->with('category')->with('city')->with('subcategory')
        ->where('slug', 'like', '%' . Str::slug($params) . '%')
        ->whereDate('publication_date', '<=', Carbon::today()->toDateString())
        ->where('is_active','=',"1")
        ->get();

        $infoUserConnected = $this->userAddAdvertToFavorite();
        $paramDeSlug  = Str::ucfirst(str_replace('-', ' ', $params));
        return Inertia::render('Search',[
            'resultSearch' => $getAdvertsFromSearch,
            'titleResearch' => $paramDeSlug,
            'infoUserFavorite' => $infoUserConnected
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Advert  $advert
     * @return \Illuminate\Http\Response
     */
    public function show($city,$category,$subcategory,$slug)
    {
        $getAdvertToRead = Advert::with("subCategory")
        ->with("city")
        ->with('category')
        ->with('user')
        ->whereDate('publication_date', '<=', Carbon::today()->toDateString())
        ->where('is_active','=',"1")
        ->where('slug_city',$city)
        ->where('slug_subcategory',$subcategory)
        ->where('slug_category',$category)
        ->where('slug',$slug)
        ->firstOrFail();

        $checkConnexion = $this->getUserConnected();
        $infoUserConnected = $this->userAddAdvertToFavorite();

        return Inertia::render('AdvertSelected',[
            'advertSelected' => $getAdvertToRead,
            'checkUserConnected' => $checkConnexion,
            'infoUserFavorite' => $infoUserConnected
        ]);
    }

    public function getUserConnected(){
        return auth()->user();
    }

    public function userAddAdvertToFavorite()
    {
        $checkConnexion = $this->getUserConnected();
        if ($checkConnexion !== null)
        return User::with('advert_favorite')->where('id',$checkConnexion->id)->firstOrFail();
    }

    public function getOneAdvert($city,$category,$subcategory,$slug){
        return Advert::with("subCategory")
        ->with("city")
        ->with('category')
        ->with('user')
        ->whereDate('publication_date', '<=', Carbon::today()->toDateString())
        ->where('is_active','=',"1")
        ->where('slug_city',$city)
        ->where('slug_subcategory',$subcategory)
        ->where('slug_category',$category)
        ->where('slug',$slug)
        ->firstOrFail();
    }

    public function showResponseAdvert($city,$category,$subcategory,$slug)
    {
        $infoUserConnected = $this->userAddAdvertToFavorite();
        $getAdvertToRead = $this->getOneAdvert( $city,$category,$subcategory,$slug);
        return Inertia::render('ResponseAdvert',[
            'advertSelected' => $getAdvertToRead,
            'infoUserFavorite' => $infoUserConnected
        ]);
    }

    public function responseToAdvert(Request $request, ResponseMail $responseMail, $city,$category,$subcategory,$slug){
        $validator = Validator::make ($request->all(),[
            "firstName" => "required",
            "lastName" => "required",
            "mail" => "required",
            "subject" => "required",
            "message" => "required",
            "titleAd" => "required",
            "nameUser" => "required",
            "emailUserAd" => "required"
        ]);

        $getAdvertToRead = $this->getOneAdvert( $city,$category,$subcategory,$slug);
        $infoUserConnected = $this->userAddAdvertToFavorite();

        if (!$validator->fails()) {
            $responseMail->message = $request->message;
            $responseMail->subject = $request->subject;
            $responseMail->mail = $request->mail;
            $responseMail->lastName = $request->lastName;
            $responseMail->firstName = $request->firstName;
            $responseMail->titleAd = $request->titleAd;
            $responseMail->nameUser = $request->nameUser;

            Mail::to($request->emailUserAd)->send(new MailtrapResponseAdvert($responseMail));

            $msg="Message envoyé avec succès !";
            $type= 1;
        }
        else{
            $msg="Tous les champs sont obligatoire";
            $type= 0;
        }

        return Inertia::render('ResponseAdvert',[
            'messageReturn' => $msg,
            'type' => $type,
            'advertSelected' => $getAdvertToRead,
            'infoUserFavorite' => $infoUserConnected
        ]);
    }

    public function showShare($city,$category,$subcategory,$slug)
    {
        $infoUserConnected = $this->userAddAdvertToFavorite();
        $getAdvertToRead = $this->getOneAdvert( $city,$category,$subcategory,$slug);
        return Inertia::render('ShareAdvert',[
            'advertSelected' => $getAdvertToRead,
            'infoUserFavorite' => $infoUserConnected
        ]);
    }

    public function shareAdvert(Request $request, ShareAd $shareAd,$city,$category,$subcategory,$slug)
    {
        $validator = Validator::make ($request->all(),[
            "firstName" => "required",
            "lastName" => "required",
            "mail" => "required",
            "message" => "required",
            "linkUrl" =>"required"
        ]);

        $getAdvertToRead = $this->getOneAdvert( $city,$category,$subcategory,$slug);
        $infoUserConnected = $this->userAddAdvertToFavorite();
        if (!$validator->fails()) {
            $shareAd->lastName = $request->lastName;
            $shareAd->firstName = $request->firstName;
            $shareAd->message = $request->message;
            $shareAd->mail = $request->mail;
            $shareAd->linkUrl = $request->linkUrl;
            $shareAd->titleAd = $request->titleAd;

            Mail::to($request->mail)->send(new shareAdvert($shareAd));

            return Inertia::render('ShareAdvert',[
                'messageReturn' => "Partage de l'annonce avec succès",
                'type' => 1,
                'advertSelected' => $getAdvertToRead,
                'infoUserFavorite' => $infoUserConnected
            ]);
        }
        else{
            return Inertia::render('ShareAdvert',[
                'messageReturn' => "Tous les champs sont obligatoire",
                'type' => 0,
                'advertSelected' => $getAdvertToRead,
                'infoUserFavorite' => $infoUserConnected
            ]);
        }
    }

    public function addToFavorite(Request $request,$city,$category,$subcategory,$slug){
        $validator = Validator::make ($request->all(),[
            "user_id_connected" => "required",
            "advert_slug" => "required",
        ]);

        $getAdvertToRead = $this->getOneAdvert( $city,$category,$subcategory,$slug);


        if (!$validator->fails()) {
            $favoris = new favorite();
            $favoris->user_id_connected = $request->user_id_connected;
            $favoris->advert_slug = $request->advert_slug;
            $favoris->save();

            $userAddAdvertToFavorite = $this->userAddAdvertToFavorite();

            return Inertia::render('AdvertSelected',[
                'messageReturn' => "Ajout aux favoris avec succès !",
                'type' => 1,
                'advertSelected' => $getAdvertToRead,
                'infoUserFavorite' => $userAddAdvertToFavorite
            ]);
        }
        else{
            return Inertia::render('AdvertSelected',[
                'messageReturn' => "echec de l'ajout aux favoris",
                'type' => 0,
                'advertSelected' => $getAdvertToRead,
            ]);
        }
    }

    public function displayFavorite(){
        $user = $this->userAddAdvertToFavorite();
        $favorites = favorite::with('advert')->with('user')->where('user_id_connected', $user->id)->get();
        /*$arrayFavorites = [];
        foreach ($advertFavorite as $matchFavorites)
        {
            foreach ($favorite as $fav){
                if ($matchFavorites->slug == $fav->advert_slug)
                {
                    array_push($arrayFavorites,$matchFavorites);
                }
            }
        }*/
        return Inertia::render('Favorite',[
            "advertsFavorites" => $favorites
        ]);
    }

    public function deleteFavorite(Request $request){
        $validator = Validator::make ($request->all(),[
            "user_id_connected" => "required",
            "id" => "required"
        ]);

        if (!$validator->fails()) {

            favorite::with('advert')->with('user')
            ->where('user_id_connected', $request->user_id_connected)
            ->where('id',$request->id)
            ->delete();

            $favorites = favorite::with('advert')->with('user')->where('user_id_connected', $request->user_id_connected)->get();
            return Inertia::render('Favorite',[
                "advertsFavorites" => $favorites
            ]);
        }
    }

    public function advertUserAdmin(){
        return Advert::with("subCategory")
            ->with("city")
            ->with('category')
            ->with('user')
            ->where('user_id_advert',auth()->user()->id)
            ->get();
    }

    public function showMyAdvert(){
        $myAdvert = Advert::with("subCategory")
        ->with("city")
        ->with('category')
        ->with('user')
        ->where('user_id_advert',auth()->user()->id)
        ->get();

        return Inertia::render('AdminAdvert',[
            'myAdverts' => $myAdvert
        ]);
    }

    public function deleteMyAdvert(Request $request)
    {
        $validator = Validator::make ($request->all(),[
            "user_id_advert" => "required",
            "id" => "required"
        ]);

        if (!$validator->fails()) {

            Advert::where('user_id_advert', $request->user_id_advert)
            ->where('id',$request->id)
            ->delete();

            $myAdverts = $this->advertUserAdmin();
            return Inertia::render('AdminAdvert',[
                "myAdverts" => $myAdverts
            ]);
        }
    }

    public function postAdvert(){
        $cities = City::all();
        $categories = Category::all();
        $subCategories = Subcategory::all();
        return Inertia::render('CreateAd',[
            "cities" => $cities,
            "categories" => $categories,
            "subCategories" => $subCategories,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Advert  $advert
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $cities = City::all();
        $categories = Category::all();
        $subCategories = Subcategory::all();
        $editAdvert = Advert::with('category')->with('city')->with('subCategory')
        ->where('slug',$slug)
        ->firstOrFail();

        return Inertia::render('editAdvert',[
            "cities" => $cities,
            "categories" => $categories,
            "subCategories" => $subCategories,
            "editAdvert" => $editAdvert
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Advert  $advert
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Advert $advert,$slug)
    {
        $validator = Validator::make ($request->all(),[
            "title" => "required",
            "description" => "required",
            "isActive" => "required",
            "isPublished" => "required",
            "city" => "required",
            "category" => "required",
            "subCategory" => "required",
            "imageUrl" => "required"
        ]);

        if (!$validator->fails()) {
            Advert::with('category')->with('city')->with('subCategory')
                ->where('slug',$slug)
                ->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'content' => $request->description,
                'is_active' => $request->isActive,
                'update_date' => $request->isPublished,
                'slug_city' => $request->city,
                'slug_category' => $request->category,
                'slug_subcategory' => $request->subCategory,
                'picture' => $request->imageUrl
            ]);
            $newAdvert = Advert::with('category')->with('city')->with('subCategory')
            ->where('slug',$slug)
            ->firstOrFail();

            $msg = "Mise à jour de l'annonce avec succès";
            $type = 1;
        }
        else{
            $msg = "Tous les champs sont obligatoire";
            $type=0;
        }
        $cities = City::all();
        $categories = Category::all();
        $subCategories = Subcategory::all();

        return Inertia::render('editAdvert',[
            "cities" => $cities,
            "categories" => $categories,
            "subCategories" => $subCategories,
            "editAdvert" => $newAdvert,
            'msg' => $msg,
            'type' => $type
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Advert  $advert
     * @return \Illuminate\Http\Response
     */
    public function destroy(Advert $advert)
    {
        //
    }
}
