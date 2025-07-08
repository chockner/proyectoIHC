@extends('layouts.dashboard')
@section('content')
    {{ $cita->status }}
    {{ $cita->payment->amount }}
    editar
@endsection
@push('scripts')
    <script>
        /* en caso necesites scripts */
    </script>
@endpush
