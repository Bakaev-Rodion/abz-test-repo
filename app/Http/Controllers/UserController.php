<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetUserForm;
use App\Http\Requests\RegistrationForm;
use App\Http\Requests\UsersForm;

use App\Http\Resources\UserResource;
use App\Http\Resources\ShowUsersResource;

use App\Models\RegistrationToken;
use App\Models\User;

use Carbon\Carbon;

use Illuminate\Database\QueryException;
use Illuminate\Http\Exceptions\HttpResponseException;
use function Tinify\fromFile;
use function Tinify\setKey;

class UserController extends Controller
{
    public function register(RegistrationForm $request){
        $this->checkUserToken($request->header('Token'));
        $this->addUser($request);
        return response()->json([
            'success'=>true,
            'user_id'=>User::where('email', $request->email)->value('id'), 'message' => 'New user successfully registered'
        ]);
    }

    public function getUser(GetUserForm $request){
        $user = User::find($request->id);
        if(!$user){
            $this->throwCustomException('User not found',404);
        }
        return response()->json([
            'success'=>true,
            'user'=> new UserResource($user)
        ]);
    }

    public function showUsers(UsersForm $request){

        $users = $this->getPaginatedUsers($request->count);
        $this->checkCurrentPage($users->currentPage(), $users->lastPage());

        return response()->json([
            'success'=>true,
            'page' => $users->currentPage(),
            'total_pages' => $users->lastPage(),
            'total_users' => $users->total(),
            'count' => $users->count(),
            'next_page_url' => $users->appends(['count'=>$request->count])->nextPageUrl(),
            'prev_page_url' => $users->appends(['count'=>$request->count])->previousPageUrl(),
            'users'=> ShowUsersResource::collection($users->items())
        ]);
    }

    public function checkCurrentPage($page,$totalPages){
        $page > $totalPages ? $this->throwCustomException('Page not found', 404) : null;
    }

    private function getPaginatedUsers($count){
        return User::paginate($count);
    }

    private function checkUserToken($token){
        if (!$this->getUserToken($token)) {
            $this->throwCustomException('Invalid or expired token.', 401);
        }
    }

    private function getUserToken($token){
        return RegistrationToken::where('token', $token)
            ->where('expires_at', '>', Carbon::now())
            ->where('used','==',0)
            ->first();
    }

    private function useToken($token){
        $this->getUserToken($token)->update(['used'=>1]);
    }

    private function addUser($userData){
        try {
            $photoPath = $this->savePhotoAndGetPath($userData->file('photo'));
            User::create(
                [
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'phone' => $userData['phone'],
                    'position_id' => $userData['position_id'],
                    'photo' => $photoPath,
                ]
            );
            $this->useToken($userData->header('Token'));

        }
       catch(QueryException $e){
            if ($e->errorInfo[1] === 1062) {
                $this->throwCustomException('User with this phone or email already exist', 409);
            }
        }
    }

    private function savePhotoAndGetPath($photo)
    {
        $path = $photo->store('images/users', 'public');
        $this->compressPhoto($path);
        return $path;
    }
    private function compressPhoto($path){
        setKey(config('app.photo_api_key'));
        $source = fromFile(storage_path('app/public/'.$path));
        $resized = $source->resize(array(
            "method" => "fit",
            "width" => 70,
            "height" => 70
        ));
        $resized->toFile(storage_path('app/public/'.$path));
    }
    private function throwCustomException($error, $status){
        throw new HttpResponseException(response()->json(['success'=>false, 'message'=>$error], $status));
    }

}
