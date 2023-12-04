@extends('layouts.myapp')

@section('page_title', 'Test page')

@section('content')
<div class="container mt-5">
    <div>Message:</div>
    {{ $message }}
</div>
@endsection


@push('scripts')
<script>
    // alert('Hello');

</script>
@endpush
@push('head_styles')
<style>
</style>
@endpush