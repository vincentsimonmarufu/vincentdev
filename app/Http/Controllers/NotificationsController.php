<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class NotificationsController extends Controller
{
    public function index()
    {
        return view('notifications');
    }
    public function singleNotification($id)
    {
        $notificationId = $id;
            $userUnreadNotification = auth()->user()
                                        ->notifications
                                        ->where('id', $notificationId)
                                        ->first();
            if($userUnreadNotification) {
                $userUnreadNotification->markAsRead();
            }

           /* if($userUnreadNotification->data['type'] == "user"){
            $user_id = $userUnreadNotification->data['id'];
                $date1 = \Carbon\Carbon::now()->format('Y-m-d');
                $date2 = \Carbon\Carbon::now()->subDays(30)->format('Y-m-d');
                    return redirect()->action([MetricsController::class, 'index'], [$user_id,$date1,$date2])
                            ->with('success', 'New registered user information');
            }
       return redirect()->back()
    ->with('success', 'Notification set to read');*/
    return Redirect::to($userUnreadNotification->data['url'])  
    ->with('success', 'Notification set to read');

    }
    public function readall()
    {
        $user = Auth::user();
        $user->unreadNotifications()->update(['read_at' => now()]);
        return redirect()->route('notifications')
        ->with('success', 'All notifications set to read');
    }

    public function sms($sub){
       $username = 'johnmulugeta';
        $password = '$3%285yDNk!h';
        $messages = array(
        array('to'=>'+263775017342', 'body'=>$sub, 'from'=>'+263782793994'),
        array('to'=>'+263782793994', 'body'=>$sub, 'from'=>'+263782793994')
        );  
        $url ='https://api.bulksms.com/v1/messages?auto-unicode=true&longMessageMaxParts=30';
        
        $result = $this->send_message( json_encode($messages), $url, $username, $password );
        if ($result['http_status'] != 201) {
        return "Error sending: " . ($result['error'] ? $result['error'] : "HTTP status ".$result['http_status']."; Response was " .$result['server_response']);
        } else {
       return "Response " . $result['server_response'];
        // Use json_decode($result['server_response']) to work with the response further
        } 
    }
    

public function send_message ( $post_body, $url, $username, $password) {
  $ch = curl_init( );
  $headers = array(
  'Content-Type:application/json',
  'Authorization:Basic '. base64_encode("$username:$password")
  );
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt ( $ch, CURLOPT_URL, $url );
  curl_setopt ( $ch, CURLOPT_POST, 1 );
  curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
  curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post_body );
  // Allow cUrl functions 20 seconds to execute
  curl_setopt ( $ch, CURLOPT_TIMEOUT, 20 );
  // Wait 10 seconds while trying to connect
  curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 10 );
  $output = array();
  $output['server_response'] = curl_exec( $ch );
  $curl_info = curl_getinfo( $ch );
  $output['http_status'] = $curl_info[ 'http_code' ];
  $output['error'] = curl_error($ch);
  curl_close( $ch );
  return $output;
} 
}
