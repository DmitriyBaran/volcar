@extends('layouts.app')

@section('content')
    <div class="container">
        <review-form></review-form>
        <review-list :reviews="{{ $reviews }}"></review-list>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
@endpush
