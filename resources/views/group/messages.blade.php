<div class="message-wrapper">
    <ul class="messages">
        @foreach ($messages as $message)
            <li class="message clearfix">
                {{-- if message from id is equal to auth id then it is sent by logged in user --}}
                <div class="{{ $message->from == Auth::id() ? 'sent' : 'received' }}">
                    {{-- <h4> <a href="/ShowMassage/{{ $message->id }}" style="color: black;"> {{ $group->name }} </a>
                    </h4> --}}
                    <p>{{ $message->name }}</p>
                    <p>{{ $message->message }}</p>

                    <p class="date">{{ date('d M y, h:i a', strtotime($message->created_at)) }}</p>
                </div>
            </li>
        @endforeach
    </ul>
</div>
<!-- this is for add new message -->
<div class="input-text mb-3">
    <input type="text" name="message" id='message' class="submit">
    <input type="hidden" name="id" id='id' class="submit" value='{{ $group->id }}'>
</div>

@if ($group->admin_id == auth()->user()->id)
    <div class="row">
        <div class="col-md-4">
            <p>
                <a class="btn btn-info" href="/group/edit/{{ $group->id }}" style="color:white;">Edit</a>
            </p>
        </div>
        <div class="col-md-4">
            <form action="/group/delete/{{ $group->id }}" method="POST">
                @csrf
                @method('Delete')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete
                    group</button>
            </form>
        </div>
        <div class="col-md-4">
            <p>
                <a class="btn btn-warning" href="/group/members_list/{{ $group->id }}" style="color:white;">Remove
                    users</a>
            </p>
        </div>
    </div>
@else
    <!-- this is for unFollow -->
    <form action="/unFollow/{{ $group->id }}" method="POST">
        @csrf
        @method('Delete')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Keluar Grub</button>
    </form>
@endif
