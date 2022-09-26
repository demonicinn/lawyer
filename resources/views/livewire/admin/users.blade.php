<div>
    <div class="form-group">
        <input type="search" wire:model="search" placeholder="Search">
    </div>
    <div class="table-responsive table-design">
        <table style="width:100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact Number</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->contact_number }}</td>
                    <td> <a href="{{route('admin.user.view',$user->id)}}">
                            <button type="button" class="btn btn-sm btn-info "><i class="fa fa-eye" aria-hidden="true"></i></button>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <div id="pagination-container" class="pagination-container-saved">{{$users->links()}}</div>
</div>