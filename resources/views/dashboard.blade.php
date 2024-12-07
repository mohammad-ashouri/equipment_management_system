@extends('layouts.PanelMaster')

@section('content')
    <main class="flex-1 bg-cu-light py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">داشبورد</h1>
            <div class="bg-white rounded shadow p-6">
                <p>
                    به پنل {{ env('APP_PERSIAN_NAME') }} خوش آمدید.
                </p>
            </div>
        </div>
    </main>
@endsection

