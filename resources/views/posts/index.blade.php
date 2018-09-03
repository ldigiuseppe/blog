@extends('layouts.app')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-12">

            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif

            @forelse($posts as $post)
                <div class="card mt-2">
                    <div class="card-body">
                        <h5 class="card-title">{{ $post->title }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $post->created_at }} <b> by {{ $post->created_by }} </b></h6>
                        <p class="card-text">{!! $post->body !!}</p>
                        <!--a href="#" class="card-link float-left">Read more...</a-->
                        @if (Auth::check())
                            <div class="float-right">
                                <form action="{{ route('posts.destroy',$post->id) }}" method="POST">
                                    <a class="btn btn-primary btn-sm" href="{{ route('posts.edit',$post->id) }}">Edit</a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="justify-content-center">
                    <p>No posts yet</p>
                </div>
            @endforelse

            <div class="pt-2" >{{ $posts->links() }}</div>

        </div>

    </div>




@endsection