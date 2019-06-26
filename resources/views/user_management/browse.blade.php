@extends('layouts.app')
@section('stylesheets')
  <link href="{{ asset('css/dropzone.css')}}" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.0/build/css/alertify.min.css"/>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @can('view users', App\User::class)
            <div class="col-md-8">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th class="text-md-left" scope="col">#</th>
                            <th class="text-md-center" scope="col">User Name</th>
                            <th class="text-md-right" scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody id="usersTable">
                        @foreach ($users as $user)
                            <tr>
                                <td class="text-md-left">{{ $user->id }}</td>
                                <td class="text-md-center">{{ $user->name }}</td>
                                @can('delete users', App\User::class)
                                    <td class="text-md-right"><a class="deleteLink" href="javascript:void(0);">
                                         {{ __('Delete') }}
                                        </a>
                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endcan
    </div>
</div>
@endsection

@section('scripts')

    <script type="text/javascript">
        $(document).on('click', 'a.deleteLink', function() {
            var user = $(this).closest('tr').find('td:nth-child(1)').text();
            deleteUser(user)
        })

        function deleteUser(user){
        axios.delete(`users/${user}`)
        .then(function (response) {
            console.log(response);
            
            if (response.data.alert==='success') {
                alertify.success('Success !', 'success', 10, function(){  console.log('success'); });
                location.reload();
            } else {
                console.log(response.data.msg);
            }
        })
        .catch(function (error) {
            console.log(error);
        });
       }
    </script>


  @endsection
