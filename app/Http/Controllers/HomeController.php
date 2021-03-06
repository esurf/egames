<?php

namespace App\Http\Controllers;

use Hash;
use App\User;
use App\games;
use App\team;
use App\newgame;
use App\newmatch;
use App\newtournament;
use App\account_setting;
use Illuminate\Http\Request;
use App\Post;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;

class HomeController extends Controller
{


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auth.login');
      //$topicname= sub_industries::find(1);

 // $gt=industries::find(1);
 //        $post = comments::find(1);
 //      $subitems = sub_industries::all(['ind_id','sub_ind_id', 'name']);
 //      $items = industries::all(['ind_id', 'name']);
 //      //$additional_info = topics::orderBy('id', 'desc')->take(5)->get();
 //       $additional_info = topics::orderBy('id', 'desc')->paginate(5);
 //        // $additional_info = sub_industries::
 //        //                   where('sub_in_id',$additional_info->sub_in_id)
 //        //                   ->get();
        // return view('welcome');
    }
    public function home()
    {

 //        $post = comments::find(1);
     $games = games::all(['game_id', 'name']);
      $console = newgame::all(['console_id', 'name']);
          $team = team::all(['team_id', 'name']);
 //      //$additional_info = topics::orderBy('id', 'desc')->take(5)->get();
 //       $additional_info = topics::orderBy('id', 'desc')->paginate(5);
 //        // $additional_info = sub_industries::
 //        //                   where('sub_in_id',$additional_info->sub_in_id)
 //        //                   ->get();
         return view('welcome',compact('games',$games,'console',$console,'team',$team));
    }
    public function show_deposit()

    {
          $games = games::all(['game_id', 'name']);
      $console = newgame::all(['console_id', 'name']);
          $team = team::all(['team_id', 'name']);
        return view('pages.deposit',compact('games',$games,'console',$console,'team',$team));

    }
public function show_transaction_history()
{
      $games = games::all(['game_id', 'name']);
      $console = newgame::all(['console_id', 'name']);
          $team = team::all(['team_id', 'name']);
    return view('pages.transaction_history',compact('games',$games,'console',$console,'team',$team));
}
public function show_change_password()
{
    return view('auth.passwords.change_password');
}
public function show_FAQ()
{
      $games = games::all(['game_id', 'name']);
      $console = newgame::all(['console_id', 'name']);
          $team = team::all(['team_id', 'name']);
  return view('pages.FAQ',compact('games',$games,'console',$console,'team',$team));
}
public function show_Games()
{
      $games = games::all(['game_id', 'name']);
      $console = newgame::all(['console_id', 'name']);
          $team = team::all(['team_id', 'name']);
   return view('pages.my_games',compact('games',$games,'console',$console,'team',$team));
}




 public function save_change_password(Request $request){
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }
        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }
        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);
        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();
        return redirect()->back()->with("success","Password changed successfully !");
    }

public function show_account_settings()
{
    $user_id=Auth::user()->id;
  $exist = DB::table('account_settings')->where(['user_id'=>$user_id])->get();
    return view('pages.account_settings',compact('exist',$exist));
}

public function show_create_tournaments()
{
  $games = games::all(['game_id', 'name']);
   $console = newgame::all(['console_id', 'name']);
       $team = team::all(['team_id', 'name']);
    return view('pages.create_tournaments',compact('games',$games,'console',$console,'team',$team));
}

public function store_match(Request $request)
{
    $l=$request->get('level');
if(!empty($l)){
  $this->validate($request, [

            'level' => 'required|string|max:60',
            'team' => 'required|numeric|min:0',
             'time' => 'required|string|max:60',
              'attack' =>'required|numeric|min:0',
        ]);
        $p=$request->get('price');
        if(!empty($p)){
        $this->validate($request, [

                  'challange' => 'required|string|max:60',
                  'console' => 'required|numeric|min:0',
                  'games' => 'required|numeric|min:0',
               'price' => 'required|string|max:60',
                          ]);

        $post = newmatch::create(array(
                  'user_id' => Auth::user()->id,
                 'match_id' => mt_rand(13, rand(100, 99999990)),
                  'challange' => $request->get('challange'),
                   'console' => $request->get('console'),
                    'games' => $request->get('games'),
                     'price' => $request->get('price'),
                      'level' => $request->get('level'),
                       'team' => $request->get('team'),
                        'time' => $request->get('time'),
                         'legacy_defending' => $request->get('attack')
                 // 'author' => Auth::user()->id
             ));

            //   $message ='New Match has been successfully added!';
            // return redirect()->back()->with('status2', $message);
        }else
        {
        $this->validate($request, [

                  'challange' => 'required|string|max:60',
                  'console' => 'required|numeric|min:0',
                  'games' => 'required|numeric|min:0',
               'custom-price' => 'required|string|max:60',
      ]);

        $post = newmatch::create(array(
                  'user_id' => Auth::user()->id,
                 'match_id' => mt_rand(13, rand(100, 99999990)),
                  'challange' => $request->get('challange'),
                   'console' => $request->get('console'),
                    'games' => $request->get('games'),
                     'price' => '$'.$request->get('custom-price'),
                      'level' => $request->get('level'),
                       'team' => $request->get('team'),
                        'time' => $request->get('time'),
                         'legacy_defending' => $request->get('attack')
                 // 'author' => Auth::user()->id
             ));


        }
        $message ='New Match has been successfully added!';
      return redirect()->back()->with('status2', $message);
}
else {
  $p=$request->get('price');
  if(!empty($p)){
  $this->validate($request, [

            'challange' => 'required|string|max:60',
            'console' => 'required|numeric|min:0',
            'games' => 'required|numeric|min:0',
         'price' => 'required|string|max:60',

        ]);

  $post = newmatch::create(array(
            'user_id' => Auth::user()->id,
           'match_id' => mt_rand(13, rand(100, 99999990)),
            'challange' => $request->get('challange'),
             'console' => $request->get('console'),
              'games' => $request->get('games'),
               'price' => $request->get('price'),
                'level' => 0,
                 'team' => 0,
                  'time' => 0,
                   'legacy_defending' => 0
           // 'author' => Auth::user()->id
       ));

      //   $message ='New Match has been successfully added!';
      // return redirect()->back()->with('status2', $message);
  }else
  {
  $this->validate($request, [

            'challange' => 'required|string|max:60',
            'console' => 'required|numeric|min:0',
            'games' => 'required|numeric|min:0',
         'custom-price' => 'required|string|max:60',

        ]);

  $post = newmatch::create(array(
            'user_id' => Auth::user()->id,
           'match_id' => mt_rand(13, rand(100, 99999990)),
            'challange' => $request->get('challange'),
             'console' => $request->get('console'),
              'games' => $request->get('games'),
               'price' => '$'.$request->get('custom-price'),
                'level' => 0,
                 'team' => 0,
                  'time' => 0,
                   'legacy_defending' => 0
           // 'author' => Auth::user()->id
       ));

      //   $message ='New Match has been successfully added!';
      // return redirect()->back()->with('status2', $message);
  }
  $message ='New Match has been successfully added!';
return redirect()->back()->with('status2', $message);
}



}


public function store_tourna(Request $request){
  $this->validate($request, [

            'no_players' => 'required|numeric|min:0',
            'martch_time' => 'required|string|max:60',
            'title' => 'required|string|max:60',

        ]);

 $post = newtournament::create(array(
            'user_id' => Auth::user()->id,
           'tournament_id' => mt_rand(13, rand(100, 99999990)),
            'no_players' => $request->get('no_players'),
             'martch_time' => $request->get('martch_time'),
             'title' => $request->get('title')
           // 'author' => Auth::user()->id
       ));


   $message ='New Match has been successfully added!';
return redirect()->back()->with('status2', $message);
}


    public function getUserByUsername($username)
    {
        return User::with('users')->wherename($username)->firstOrFail();
    }

public function store_settings(Request $request)
{
  $user_id=Auth::user()->id;
  $username=Auth::user()->username;
  $this->validate($request, [

           'city' => 'required|string|max:60',
          'state' => 'required|string|max:60',
           'zip' => 'required|string|max:60',
           'country' => 'required|string|max:60',
            'gender' => 'required|string|max:60',
            // 'psn_name' => 'required|string|max:60',
            // 'mobile_id' => 'required|string|max:60',
            // 'xbox_name' => 'required|string|max:60',
         

        ]);



$exist = DB::table('account_settings')->where(['user_id'=>$user_id])->get();
if(count($exist)  >0) {
 $task = account_setting::where('user_id', $user_id)->first()->update($request->all());

 // $input = $request->all();

 //    $task->fill($input)->save();
 $message ='Account Settings Has Been Successfully Updated!';
return redirect()->back()->with('status3', $message);

}
else  {
    // $data=array('username'=>$username,'password'=>$password);
    // DB::table('User')->insert($data);
   $post = account_setting::create(array(
            'user_id' => Auth::user()->id,
            'mobile_id' => $request->get('mobile_id') ?: '0',
             'psn_name' => $request->get('psn_name') ?: '0',
             'xbox_name' => $request->get('xbox_name') ?: '0',
             'zip' => $request->get('zip'),
             'gender' => $request->get('gender'),
             'country' => $request->get('country'),
             'state' => $request->get('state'),
             'city' => $request->get('city')
       ));
   $message ='New Match has been successfully added!';
return redirect()->back()->with('status3', $message);
}


  
}

public function load_topic($name,$id)
{

  $topicname= sub_industries::find(1);
    // echo $topicname->name;
      $post = comments::find(1);
  $subitems = sub_industries::all(['ind_id','sub_ind_id', 'name']);
  $items = industries::all(['ind_id', 'name']);
  $additional_info = topics::
                          // ->whereNull('address')
                          // ->orWhereNull('name')
                          // ->orWhereNull('number')
                          where('sub_in_id',$id)
                          ->get();

return view('pages.topic', compact('items',$items,'subitems',$subitems,'additional_info',$additional_info,'post',$post,'topicname',$topicname));
}



public function load_comment($name,$id)
{

 // $like = Like::where('post_id','=', $id)->get();

       // $like = $user->likes()->where('post_id', $id)->get();
       $replycomment=Rating::find($id);
  $cpost = comments::find($id);
  $topicname = sub_industries::find(1);
  $post = comments::find(1);
   // $chirps = Chirp::find($id);
    $subitems = sub_industries::all(['ind_id','sub_ind_id', 'name']);
  $items = industries::all(['ind_id', 'name']);
  $additional_info = topics::where('location', '=', $name)->where('topic_id', '=', $id)->get();

  $comments = Rating::where('topic_id', '=',$id)->get();
  $like  = Rating::selectraw('ratings.id, likes.post_id, COUNT(likes.post_id) AS num')->where('likes.likes_count','1')->join('likes','ratings.id','=','likes.post_id')->groupby('ratings.id','likes.post_id')->get();
//  $like=[];
// $i=0;

// foreach ( $comment as $value) {
//   # code...
//   $like[$i] = Like::where('post_id','=',  $value->id)->first();
//   $i++;
// }


return view('pages.comment', compact('replycomment', $replycomment,'items',$items,'like',$like,'subitems',$subitems,'cpost',$cpost,'additional_info',$additional_info,'comments',$comments,'post',$post,'topicname',$topicname));
}

public function posts()

   {

       $posts = Post::all();

       return view('posts',compact('posts'));

   }



   public function show($id)

   {

       $post = Post::find($id);

       return view('postsShow',compact('post'));

   }



   public function postPost(Request $request)

   {

       //request()->validate(['rate' => 'required']);

       $post = topics::find($request->id);



       $rating = new \willvincent\Rateable\Rating;

       $rating->rating = $request->star;
       $rating->message = $request->message;
       $rating->user_id = auth()->user()->id;



       $post->ratings()->save($rating);



       return redirect()->route("posts");

   }

  public function postLikePost(Request $request)
    {


         $id = $request['postId'];
        $is_like = $request['isLike'] === 'true';
        $update = false;
        $post = Rating::find($id);
        if (!$post) {
            return null;
        }
        $user = \Auth::user();
        $like = $user->likes()->where('post_id', $id)->first();
        if ($like) {
            $already_like = $like->like;
            $update = true;
            if ($already_like == $is_like) {
                $like->delete();
                return null;
            }
        } else {
            $like = new Like();
        }
        $like->likes_count = $is_like;
        $like->user_id = $user->id;
        $like->post_id = $post->id;
        if ($update) {
            $like->update();
        } else {
            $like->save();
        }
        return null;
    }

public function updatepost($id){


  return view('pages.update');
}

public function updateprofile ()
{
  $r= Auth::user();
   $post = comments::find(1);
    return view('pages.profile',compact('post', $post,'r',$r));
}


  public function getUserImage($filename)
    {
        $file = Storage::disk('uploads')->get($filename);
        return new Response($file, 200);
    }

public function Update_profile(Request $request)
{

  $this->validate($request, [
               'name' => 'required|string|max:255',
            'username' => 'required|string|max:40',
            'phone' => 'required|string|max:20',
            'email' => 'required|string|email|max:255',
        ]);

       // $request->avatar->storeAs('avatars',$avatarName);


        $user = Auth::user();
 if(Input::file('image')){
       $avatarName = $user->id.''.$request['username'].'.'.request()->image->getClientOriginalExtension();
     }

        $old_name = $user->username;
        $user->name = $request['name'];
        $user->username = $request['username'];
        $user->phone = $request['phone'];
        $user->email = $request['email'];
     if(isset($avatarName)) {
      $user->avatar =    env('APP_URL').'/img/'.$avatarName;
    }

        $user->update();


        $file = $request->file('image');
     if(isset($avatarName)) {      $filename = $avatarName;
         $old_filename= $avatarName;
      //  $filename = $request['username'] . '-' . $user->id . '.jpg';
       // $old_filename = $old_name . '-' . $user->id . '.jpg';
        $update = false;
        if (Storage::disk('uploads')->has($old_filename)) {
            $old_file = Storage::disk('uploads')->get($old_filename);
            Storage::disk('uploads')->put($filename, $old_file);
            $update = true;
        }
        if ($file) {
            Storage::disk('uploads')->put($filename, File::get($file));
        }
        if ($update && $old_filename !== $filename) {
            Storage::delete($old_filename);
        }

         }
    $message ='Account has been successfully updated!';
  return redirect()->back()->with('status', $message);
}



    //   public function actOnChirp(Request $request, $id)
    // {
    //     $action = $request->get('action');
    //     switch ($action) {
    //         case 'Like':
    //             Chirp::where('id', $id)->increment('likes_count');
    //             break;
    //         case 'Unlike':
    //             Chirp::where('id', $id)->decrement('likes_count');
    //             break;
    //     }
    //     event(new ChirpAction($id, $action)); // fire the event
    //     return '';
    // }

}
