<?php
namespace App\Classes;
use App\Models\Notification;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;

class FcmNotification {

   private $token;
   private $title;
   private $body;
   private $type;
   private $type_id;
   private $employee_id;

   public function __construct($token,$title,$body,$type,$type_id,$employee_id){        
        $this->token = $token;
        $this->title = $title;
        $this->body = $body;
        $this->type = $type;
        $this->type_id = $type_id;
        $this->employee_id = $employee_id;
    }

   public function sendNotification () {

        $firebase = (new Factory)->withServiceAccount(storage_path('app/firebase_credentials.json'));
 
        $messaging = $firebase->createMessaging();
 
        $deviceTokens = $this->token;

        $message = CloudMessage::fromArray([
            'notification' => [
                'title' => $this->title,
                'body' => $this->body
            ], // optional
            'data' => [
                'title' => $this->title,
                'body' => $this->body,
                'type' => $this->type,
                'type_id' => $this->type_id
            ], // optional
        ]);

        if (count($deviceTokens) == 0 || $deviceTokens[0] == null) {
            return false ;
        }
        
        $messaging->sendMulticast($message, $deviceTokens);

        $row = Notification::create([
            'title' => $this->title,
            'body' => $this->body,
            'type' => $this->type,
            'type_id' => $this->type_id,
            'employee_id' => $this->employee_id,
            // 'employee_id' => auth()->id(),
        ]);
        
        return true;
    
   }

}