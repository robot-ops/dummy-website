@include ('layouts.app')
@section('title', 'Welcome to ' . config('app.name', 'Demo Application'))
@section('content')
<div class="text-center">
    <h1 class="text-4xl font-bold mb-4">Welcome to {{ config('app.name', 'Demo Application') }}</h1>
    <p class="text-lg text-gray-600 dark:text-gray-400">This is the welcome page of your demo application.</p>
</div>
@endsection
