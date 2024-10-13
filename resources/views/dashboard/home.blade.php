@extends('dashboard.layouts.footer')

@extends('dashboard.layouts.navbar')
@section('title')
    {{ 'Home' }}
@endsection
@section('page-title')
    {{-- <li class="breadcrumb-item"><a href="#">Dashboard</a></li> --}}
    <li class="breadcrumb-item active">Dashboard</li>
@endsection
@section('body')
    <!-- Content wrapper -->
    <div class="content-wrapper">
      <div class="container-xxl flex-grow-1 container-p-y">
        <div class="container">
            <h2>قائمة المشتركين</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>البريد الإلكتروني</th>
                        <th>تاريخ الاشتراك</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subscribers as $index => $subscriber)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $subscriber->email }}</td>
                            <td>{{ $subscriber->created_at->format('Y-m-d H:i:s') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
     
                </div>
    
          @endsection
          @section('footer-script')
  
  
  
          @endsection

  