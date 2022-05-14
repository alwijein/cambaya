<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\GroupMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
}
