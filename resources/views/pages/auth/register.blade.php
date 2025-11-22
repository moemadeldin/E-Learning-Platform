<x-layouts.auth :title="'Register'">

    <x-form-wrapper title="Register">
        <x-flash-message />

        <form action="{{ route('register.post') }}" method="POST" class="space-y-6">
            @csrf
            <x-input label="Name" name="name" autocomplete="name" />
            <x-input label="Email address" name="email" type="email" autocomplete="email" />
            <x-input label="Password" name="password" type="password" autocomplete="current-password" />
            <x-input label="Password Confirmation" name="password_confirmation" type="password"
                autocomplete="current-password" />
            <x-submit-button label="Register" />
        </form>
        <x-link href="{{ route('login') }}" linkText="Login">
            Already have an account?
        </x-link>
        <x-link href="{{ route('teacher.register.get') }}" linkText="Register">
            Register as a teacher?
        </x-link>
    </x-form-wrapper>

</x-layouts.auth>