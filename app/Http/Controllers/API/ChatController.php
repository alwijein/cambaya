<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\GroupMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Pusher\Pusher;

class ChatController extends Controller
{
    public function getGrubChat()
    {
        $my_id = Auth::id();
        // select channels that User Subscribe
        $users = DB::select("select groups.id, groups.name
        from groups inner JOIN  group_participants ON groups.id = group_participants.group_id and group_participants.user_id = " . Auth::id() . "
        where group_participants.user_id = " . Auth::id() . "
        group by groups.id, groups.name");

        return ResponseFormatter::success(
            $users,
            'Data berhasil diambil'
        );
    }

    // get messages of user according find Group
    public function getMessage($id)
    {
        $my_id = Auth::id();
        // get all messages that User sent & got
        $messages = GroupMessage::where(['group_id' => $id])->where(['user_id' => $my_id])->get();
        foreach($messages as $value) {
            GroupMessage::where(['user_id' => $my_id])->update(['is_read' => 1]); // if User start to see messages is_read in Table update to 0
        }
        return ResponseFormatter::success(
            $messages,
            'Data berhasil diambil'
        );
    }

    // send new message to all Followers
    public function sendMessage(Request $request)
    {
        $this->validate($request, [
            'message' => 'required',
        ]);
        $to = $request->id; // this part get Group id
        $from = Auth::id();  // this part get  user id who watnts to send message
        $group = Group::find($request->id);  // find group according id
        $from = Auth::id();
        $name = Auth::user()->name;
        $group_members = $group->participants()->get();

         // send for all Followers
         foreach($group_members as $value) {
            $message = GroupMessage::create(
              $data = array(
               'group_id' => $request->id,
               'user_id' => $value->id,
               'message' => $request->message,
               'from' => $from,
               'name' => $name,
               'is_read' => 0,
               ));
               // Pusher send New message at real time
               $options = array(
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'encrypted' => true
                );
            $pusher = new Pusher(
                    env('PUSHER_APP_KEY'),
                    env('PUSHER_APP_SECRET'),
                    env('PUSHER_APP_ID'),
                    $options
                );
            $data = ['from' => $to, 'to' => $value->id];
            $notify = '' . $value->id .'';
            $pusher->trigger($notify, 'App\\Events\\Notify', $data);

            }


            return ResponseFormatter::success(
                $message,
                'Data berhasil diambil'
            );
    }

}
