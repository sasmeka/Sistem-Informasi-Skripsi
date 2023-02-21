<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Google\Client as Google_Client;
use Google_Service_Oauth2;

use App\Models\Users;
use App\Models\UsersGroups;

class Redirect extends BaseController
{
    public function index()
    {
        $clientID = '632079100292-t1c8ut8h0cqn13n0qs2hhtm9a3egga8q.apps.googleusercontent.com';
        $clientSecret = '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';
        $redirectUri = base_url() . '/redirect'; //Harus sama dengan yang kita daftarkan

        $client = new Google_Client();
        $client->setClientId($clientID);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectUri);
        $client->addScope("email");
        $client->addScope("profile");

        if (isset($_GET['code'])) {
            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
            if (isset($token['access_token'])) {
                $client->setAccessToken($token['access_token']);
                $Oauth = new Google_Service_Oauth2($client);
                $userInfo = $Oauth->userinfo->get();
                $users = new Users();
                $data = $users->where('google_id', $userInfo->id)->find();
                if (!$data) {
                    if ($users->insert([
                        'google_id' => $userInfo->id,
                        'email' => $userInfo->email,
                        'name' => $userInfo->name,
                        'picture' => $userInfo->picture
                    ])) {
                        $data = $users->where('google_id', $userInfo->id)->find();
                        $userInfo->group = 1;
                        $userInfo->id = $data[0]['id'];
                        Session()->auth = $userInfo;
                        return redirect()->to('/');
                    }
                    return redirect()->back();
                }
                $groups = new UsersGroups();
                $group = $groups->where('user_id', $data[0]['id'])->find();
                $userInfo->group_id = $group[0]['group_id'];
                $userInfo->id = $data[0]['id'];
                Session()->auth = $userInfo;
                return redirect()->to('/');
            }
        }
        $auth = Session()->auth;
        if ($auth) {
            return redirect()->to('/');
        }
        echo "<a href='" . $client->createAuthUrl() . "'>Google Login</a>";
    }
}
