<?php

namespace App\Http\Controllers;

use App\Models\GitHubAuthentication;
use App\Models\GitHubPullRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\View;

class GitHubController extends Controller
{
    public function index()
    {
        $token = $this->getToken();
        return View::make('main')->with([
            'notAuthorize' => !$token
        ])->render();
    }

    public function getPullRequests(Request $request, $owner = '', $repo = '')
    {
        if (!$owner && !$repo) {

            $messages = [
                'owner.regex' => 'Owner name may only contain alphanumeric characters or single hyphens, and cannot begin or end with a hyphen.',
                'repo.regex' => 'Repository name may only contain alphanumeric characters or hyphens.'
            ];

            $this->validate($request, [
                'owner' => ['required', 'regex:/^\w[\w|\-]+\w$/'],
                'repo' => ['required', 'regex:/^\w|\-[\w|\-]+\w|\-$/']
            ], $messages);
        }

        $repository = [
            'owner' => $owner ? $owner : $request->get('owner'),
            'repo' => $repo ? $repo : $request->get('repo')
        ];

        $token = $this->getToken();
        $pullRequests = GitHubPullRequest::sendRequestGet('repos/' . $repository['owner'] . '/' . $repository['repo'] . '/pulls', [], $token);

        $closePermission = false;
        if (empty($pullRequests) || isset($pullRequests['message'])) {
            $message = isset($pullRequests['message']) ? $pullRequests['message'] : '';
            return View::make('error')->with([
                'message' => $message,
                'repository' => $repository,
                'notAuthorize' => !$token
            ])->render();
        } else if ($token) {
            $repos = GitHubPullRequest::sendRequestGet('user/repos', [], $token);
            foreach ($repos as $repo) {
                if ($repo['full_name'] === $repository['owner'] . '/' . $repository['repo']) {
                    $closePermission = true;
                    continue;
                }
            }
        }

        $data = [];
        foreach ($pullRequests as $key => $pullRequest) {
            $data[$key]['url'] = $pullRequest['html_url'];
            $data[$key]['title'] = $pullRequest['title'];
            $data[$key]['created_at'] = $pullRequest['created_at'];
            $data[$key]['number'] = $pullRequest['number'];
            $data[$key]['user'] = $pullRequest['user']['login'];
        }

        return View::make('repo')->with([
            'pullRequests' => $data,
            'repository' => $repository,
            'closePermission' => $closePermission,
            'notAuthorize' => !$token
        ])->render();
    }

    public function updatePullRequestStatus(Request $request, $owner, $repo, $pullRequestNumber) {
        $token = $this->getToken();

        $res = GitHubPullRequest::sendRequestPatch('repos/' . $owner . '/' . $repo . '/pulls/' . $pullRequestNumber,
            ['state' => 'closed'],
            $token);

        if (isset($res['message'])) {
            return View::make('error')->with([
                'message' => $res['message'],
                'notAuthorize' => !$token
            ])->render();
        }

        return $this->getPullRequests($request, $owner, $repo);
    }


    private function getToken ()
    {
        if (Cookie::get('token')) {
            return Cookie::get('token');
        } else {
            return '';
        }
    }

    public function setToken(Request $request)
    {
        if ($request->get('code')) {
            $token = GitHubAuthentication::getToken($request->get('code'));
        }

        return redirect()->route('main')->cookie(
            'token', $token, 480
        );
    }

    public function authenticate()
    {
        return redirect(GitHubAuthentication::getAuthorizeUrl());
    }

    public function logout()
    {
        $cookie = Cookie::forget('token');
        return redirect()->route('main')->withCookie($cookie);
    }

}
