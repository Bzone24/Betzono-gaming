<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Models\AdminNotification;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\Page;
use App\Models\Phase;
use App\Models\Subscriber;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use App\Models\HomeBanner;
use App\Models\Ticket;
use App\Models\Game;
use App\Models\CasinoGameList;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;


class SiteController extends Controller
{
    public function lotteryHome()
    {
        
        $reference = @$_GET['reference'];

        if ($reference) {
            session()->put('reference', $reference);
        }

        $pageTitle = 'Home';
        $sections = Page::where('tempname', activeTemplate())->where('slug', '/')->first();
        $seoContents = $sections->seo_content;
        $seoImage = @$seoContents->image ? getImage(getFilePath('seo') . '/' . @$seoContents->image, getFileSize('seo')) : null;
        return view('Template::home', compact('pageTitle', 'sections', 'seoContents', 'seoImage'));
    }
    public function home()
    {
        $reference = @$_GET['reference'];

        if ($reference) {
            session()->put('reference', $reference);
        }
        
        $providers = CasinoGameList::where('status', 1)->get(); // Fetch only active games
        
        $sliders = HomeBanner::orderBy('sort_order')->get();
        $categories = HomeBanner::categories();
       
        return view('frontend.newhome',compact('providers','sliders','categories'));
    }

    public function pages($slug)
    {
        $page = Page::where('tempname', activeTemplate())->where('slug', $slug)->firstOrFail();
        $pageTitle = $page->name;
        $sections = $page->secs;
        $seoContents = $page->seo_content;
        $seoImage = @$seoContents->image ? getImage(getFilePath('seo') . '/' . @$seoContents->image, getFileSize('seo')) : null;
      
        return view('Template::pages', compact('pageTitle', 'sections', 'seoContents', 'seoImage'));
    }

    public function contact()
    {
        $pageTitle = "Contact Us";
        $user = auth()->user();
        $sections = Page::where('tempname', activeTemplate())->where('slug', 'contact')->first();
        $seoContents = $sections->seo_content;
        $seoImage = @$seoContents->image ? getImage(getFilePath('seo') . '/' . @$seoContents->image, getFileSize('seo')) : null;
     
        return view('Template::contact', compact('pageTitle', 'user', 'sections', 'seoContents', 'seoImage'));
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required|string|max:255',
            'message' => 'required',
        ]);

        $request->session()->regenerateToken();

        if (!verifyCaptcha()) {
            $notify[] = ['error','Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        $random = getNumber();

        $ticket = new SupportTicket();
        $ticket->user_id = auth()->id() ?? 0;
        $ticket->name = $request->name;
        $ticket->email = $request->email;
        $ticket->priority = Status::PRIORITY_MEDIUM;


        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = Status::TICKET_OPEN;
        $ticket->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = auth()->user() ? auth()->user()->id : 0;
        $adminNotification->title = 'A new contact message has been submitted';
        $adminNotification->click_url = urlPath('admin.ticket.view', $ticket->id);
        $adminNotification->save();

        $message = new SupportMessage();
        $message->support_ticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        $notify[] = ['success', 'Ticket created successfully!'];

        return to_route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function policyPages($slug)
    {
        $policy = Frontend::where('slug', $slug)->where('data_keys', 'policy_pages.element')->firstOrFail();
        $pageTitle = $policy->data_values->title;
        $seoContents = $policy->seo_content;
        $seoImage = @$seoContents->image ? frontendImage('policy_pages', $seoContents->image, getFileSize('seo'), true) : null;
        return view('Template::policy', compact('policy', 'pageTitle', 'seoContents', 'seoImage'));
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) {
            $lang = 'en';
        }
        session()->put('lang', $lang);
        return back();
    }


    public function blogs()
    {
        $blogs = Frontend::where('tempname', activeTemplateName())->where('data_keys', 'blog.element')->orderBy('id', 'desc')->paginate(16);
        $pageTitle = 'Blogs';
        $sections = Page::where('tempname', activeTemplate())->where('slug', 'blogs')->first();
        $seoContents = $sections->seo_content;
        $seoImage = @$seoContents->image ? getImage(getFilePath('seo') . '/' . @$seoContents->image, getFileSize('seo')) : null;
        return view('Template::blog', compact('blogs', 'pageTitle', 'seoContents', 'seoImage', 'sections'));
    }

    public function blogDetails($slug)
    {
        $blog = Frontend::where('slug', $slug)->where('data_keys', 'blog.element')->firstOrFail();
        $recentBlogs = Frontend::where('id', '!=', $slug)->where('data_keys', 'blog.element')->orderBy('id')->take(5)->get();

        $pageTitle = $blog->data_values->title;
        $seoContents = $blog->seo_content;
        $seoImage = @$seoContents->image ? frontendImage('blog', $seoContents->image, getFileSize('seo'), true) : null;

        return view('Template::blog_details', compact('blog', 'pageTitle', 'seoContents', 'seoImage', 'recentBlogs'));
    }

    public function cookieAccept()
    {
        Cookie::queue('gdpr_cookie', gs('site_name'), 43200);
    }

    public function cookiePolicy()
    {
        $cookieContent = Frontend::where('data_keys', 'cookie.data')->first();
        abort_if($cookieContent->data_values->status != Status::ENABLE, 404);
        $pageTitle = 'Cookie Policy';
        $cookie = Frontend::where('data_keys', 'cookie.data')->first();
        return view('Template::cookie', compact('pageTitle', 'cookie'));
    }

    public function placeholderImage($size = null)
    {
        $imgWidth = explode('x', $size)[0];
        $imgHeight = explode('x', $size)[1];
        $text = $imgWidth . '×' . $imgHeight;
        $fontFile = realpath('assets/font/solaimanLipi_bold.ttf');
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if ($imgHeight < 100 && $fontSize > 30) {
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 255, 255, 255);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }

    public function maintenance()
    {
        $pageTitle = 'Maintenance Mode';
        if (gs('maintenance_mode') == Status::DISABLE) {
            return to_route('home');
        }
        $maintenance = Frontend::where('data_keys', 'maintenance.data')->first();
        return view('Template::maintenance', compact('pageTitle', 'maintenance'));
    }

    public function subscribe(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email|max:255|unique:subscribers',
            ],
            [
                'email.unique' => 'You are already subscribed'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $subscriber = new Subscriber();
        $subscriber->email = $request->email;
        $subscriber->save();
        $notify[] = ['success', 'Subscribed Successfully'];

        return response()->json(['success' => 'Subscribed successfully']);
    }

    public function lottery()
    {
        $pageTitle = "All Lotteries";
        $phases = Phase::available()
            ->latest('draw_date')
            ->with('lottery')
            ->paginate(getPaginate());
        $sections  = Page::where('tempname', activeTemplate())->where('slug', 'lotteries')->first();

        $seoContents = $sections->seo_content;
        $seoImage = @$seoContents->image ? getImage(getFilePath('seo') . '/' . @$seoContents->image, getFileSize('seo')) : null;

        return view('Template::lottery', compact('pageTitle', 'phases', 'sections', 'seoContents', 'seoImage'));
    }

    public function lotteryDetails($id)
    {
        $phase     = Phase::available()->findOrFail($id);
        $pageTitle = " Details of" . ' ' . $phase->lottery->name;
        $tickets   = Ticket::where('user_id', auth()->id())->where('lottery_id', $phase->lottery_id)->with('phase')->orderByDesc('id')->paginate(getPaginate());
        $layout    = 'frontend';
        return view('Template::user.lottery.details', compact('pageTitle', 'phase', 'tickets', 'layout'));
    }

    public function funGame(){
        return view('frontend.game.fungame');
    }

    public function newfunGame(){
        try {
            $providers = CasinoGameList::where('status', 1)->get(); // Fetch only active games
            $liveGames = Game::where('type', 'live')->where('image_url', '!=', '')->take(12)->get();
            $virtualGames = Game::where('type', 'virtual')->where('image_url', '!=', '')->take(12)->get();
            $virtualGamesCount = Game::where('type', 'virtual')->count();
            $liveGamesCount = Game::where('type', 'live')->count();
            return view('livecasino.home', compact('providers', 'liveGames', 'virtualGames', 'virtualGamesCount', 'liveGamesCount'));
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
    
    public function liveCasino(Request $request)
    {

        $client = new Client();

        try {
            $headers = [
                'Content-Type' => 'application/json'
            ];
            $body = json_encode([
                'agentCode' => 'stakeye'
            ]);
    
            $response = $client->post('https://api.vkingplays.com/api/GameList', [
                'headers' => $headers,
                'body' => $body
            ]);
    
            $gameList = json_decode($response->getBody(), true);
            
        } catch (\Exception $e) {
            $gameList = [];
        }

        $flattenedData = [];
        $gameCategory=[];

        foreach ($gameList['gameList'] as $game) {
            $gameCategory[]=$game['gameName'];
            // foreach ($game['data'] as $item) {
            //     $flattenedData[] = $item;
            // }
        }

        $gameCategory = array_unique($gameCategory);

        $selectedCategory = $request->input('category', 'All');

        if ($selectedCategory !== 'All') {
            foreach ($gameList['gameList'] as $game) {
                if($game['gameName']==$selectedCategory){
                    foreach ($game['data'] as $item) {
                        $item['gameCode']=$game['gameCode'];
                        $flattenedData[] = $item;
                    }
                }
            }
            $page=100;
        }else{
            foreach ($gameList['gameList'] as $game) {
                    foreach ($game['data'] as $item) {
                        $item['gameCode']=$game['gameCode'];
                        $flattenedData[] = $item;
                    }
            }
            $page=10;
        }
        $games = $this->paginate($flattenedData, $page,''); // 50 games per page

        return view('livecasino.index', compact('games','gameCategory','selectedCategory'));
    }

    private function paginate($items, $perPage, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        $options = array_merge(['path' => url('/livecasino')], $options);

        return new LengthAwarePaginator(
            $items->forPage($page, $perPage),
            $items->count(),
            $perPage,
            $page,
            $options
        );
    }

    public function searchGame(Request $request)
    {
        $search = $request->input('query');
        
        $games = CasinoGameList::where('game_name', 'LIKE', "%{$search}%")->get();

        return response()->json($games);
    }

    public function loadMore(Request $request)
    {
        $gameType = $request->game_type;
        $offset = $request->offset;
        $provider = $request->input('provider'); // Add game_name condition

        $query = Game::query();

        if(!empty($gameType)){
            $query->where('type', $gameType);
        }

        if (!empty($provider)) {
            $query->where('game_name', 'like', "%{$provider}%");
        }
    
        $games = $query
        ->skip($offset)
        ->take(12)
        ->get();

        return response()->json($games);
    }

    public function getGames(Request $request)
    {
        $type = $request->input('type');

        $provider = $request->input('provider_id');

        $query = Game::query();
    
        if (!empty($type)) {
            $query->where('table_name', 'like', '%' . $type . '%');
        }
    
        if (!empty($provider)) {
            $query->orWhere('game_name', 'like', '%' . $provider . '%');
        }
    
        $games = $query->get();

        return response()->json($games,200);
    }

    public function providerList(Request $request,$name)
    {

        try {
            $query = Game::query();

            $query->where('game_name', 'like', '%' . $name . '%');

            $games = $query->take(12)->get();

            $providers = CasinoGameList::where('status', 1)->get(); // Fetch only active games

            return view('livecasino.provider-list', compact('games','name','providers'));

        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

}
