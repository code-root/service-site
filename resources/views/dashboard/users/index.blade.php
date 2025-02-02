@extends('dashboard.layouts.footer')
@extends('dashboard.layouts.navbar')
@section('body')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"> <span class="text-muted fw-light">Users </span> </h4>
        <div class="card">
            <div class="card-header">
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
                  @endif
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="card-header flex-column flex-md-row">
                        <div class="head-label text-center">
                            <h5 class="card-title mb-0">DataTable with Buttons</h5>
                        </div>
                        <div class="dt-action-buttons text-end pt-3 pt-md-0">
                            <div class="dt-buttons">
                                @can('create-users')
                                 <a class="btn btn-primary waves-effect waves-light" href="{{ route('users.create') }}"> Create New User</a>
                                  @endcan

                            </div>
                        </div>
                    </div>
                    <table id="example" class="dt-fixedheader table border-top dataTable dtr-column">
                        <thead>
                            <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th>Action</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- @can('read_users') --}}
                                                    @foreach ($data as $key => $user)
                                                        <tr>
                                                            <td>{{ ++$i }}</td>
                                                            <td>{{ $user->name }}</td>
                                                            <td>{{ $user->email }}</td>
                                                            <td>
                                                                @if (!empty($user->getRoleNames()))
                                                                    @foreach ($user->getRoleNames() as $v)
                                                                        <label
                                                                            class="badge badge-success">{{ $v }}</label>
                                                                    @endforeach
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <a class="btn btn-info"
                                                                    href="{{ route('users.show', $user->id) }}">Show</a>
                                                                <a class="btn btn-primary"
                                                                    href="{{ route('users.edit', $user->id) }}">Edit</a>
                                                                {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id], 'style' => 'display:inline']) !!}
                                                                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                                                {!! Form::close() !!}
                                                            </td>
                                                    @endforeach
                                                {{-- @endcan --}}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endsection
                @section('footer-script')
                    <script>

                    </script>
                @endsection
