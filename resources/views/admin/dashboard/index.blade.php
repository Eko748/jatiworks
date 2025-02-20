@extends('admin.layouts.app')

@section('title')
    {{ $title }}
@endsection

@section('content')
    <main id="main-content" class="flex-grow-1 p-4 position-relative">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="p-4 neumorphic-card">
                    <h2 class="fs-5">Total Users</h2>
                    <p class="fs-4 fw-bold">120</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 neumorphic-card">
                    <h2 class="fs-5">Total Orders</h2>
                    <p class="fs-4 fw-bold">350</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 neumorphic-card">
                    <h2 class="fs-5">Revenue</h2>
                    <p class="fs-4 fw-bold">$25,000</p>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('js')
    <script>
        async function initPageLoad() {

        }
    </script>
@endsection
