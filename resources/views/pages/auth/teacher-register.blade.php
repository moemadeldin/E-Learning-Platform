<x-layouts.auth :title="'Register'">

    <x-form-wrapper title="Register">
        @if ($errors->any())
            <div class="text-red-500">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('teacher.register.post') }}" method="POST" class="space-y-6">
            @csrf

            <x-input label="Name" name="name" autocomplete="name" />
            <x-input label="First Name" name="first_name" autocomplete="first_name" />
            <x-input label="Last Name" name="last_name" autocomplete="last_name" />
            <x-input label="National ID" name="national_id" autocomplete="national_id" />
            <x-select label="Category ID" name="category_id"
                :options="\App\Models\Category::getCategoriesById()->pluck('name', 'id')" />
            <x-input label="Email address" name="email" type="email" autocomplete="email" />
            <x-input label="Job Title" name="title" autocomplete="title" />
            <x-input label="Password" name="password" type="password" autocomplete="current-password" />
            <x-input label="Password Confirmation" name="password_confirmation" type="password"
                autocomplete="current-password" />
            <x-submit-button label="Register" />
        </form>
        <x-link href="{{ route('login') }}" linkText="Login">
            Already have an account?
        </x-link>
    </x-form-wrapper>

</x-layouts.auth>