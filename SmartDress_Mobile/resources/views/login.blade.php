@extends('layouts.mobile', ['title' => 'SmartDress - Connexion'])

@section('content')
<div class="min-h-[60vh] flex flex-col justify-center py-12 px-6" x-data="loginForm()">
    <div class="space-y-4 text-center mb-8">
        <div style="font-family: 'Cormorant Garamond', serif;" class="text-4xl tracking-tight select-none flex items-baseline justify-center">
            <span style="font-weight: 400; color: #5C4A35;">Smart</span>
            <span style="font-weight: 600; font-style: italic; color: #889063; margin-left: -0.02em;">Dress</span>
        </div>
        <p class="text-tan text-xs font-medium uppercase tracking-widest">Connexion Mobile</p>
    </div>

    <form @submit.prevent="submitLogin" class="space-y-6 bg-white rounded-[2.5rem] p-8 border border-tan/10 shadow-sm">
        <div class="space-y-4">
            <div class="space-y-1">
                <label class="px-2 text-[10px] font-bold text-tan uppercase tracking-widest">Adresse Email</label>
                <input type="email" x-model="email" required placeholder="user@smartdress.com"
                    class="w-full px-5 py-4 bg-cream/20 border border-tan/10 rounded-2xl focus:border-moss outline-none transition-all font-medium text-sm">
            </div>
            <div class="space-y-1">
                <label class="px-2 text-[10px] font-bold text-tan uppercase tracking-widest">Mot de passe</label>
                <input type="password" x-model="password" required placeholder="••••••••"
                    class="w-full px-5 py-4 bg-cream/20 border border-tan/10 rounded-2xl focus:border-moss outline-none transition-all font-medium text-sm">
            </div>
        </div>

        <div x-show="errorMessage" class="text-xs font-bold text-red-400 text-center uppercase" x-text="errorMessage"></div>

        <button type="submit" :disabled="loading"
            class="w-full py-5 bg-bark text-white rounded-full text-[10px] font-bold uppercase tracking-[0.2em] shadow-xl shadow-bark/20 hover:bg-moss transition-all flex items-center justify-center gap-2">
            <template x-if="loading">
                <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </template>
            Se Connecter
        </button>
    </form>
</div>

<script>
function loginForm() {
    return {
        email: 'user@smartdress.com', // Pre-filled for easy testing
        password: 'password',         // Pre-filled for easy testing
        loading: false,
        errorMessage: '',
        init() {
            if (localStorage.getItem('auth_token')) {
                window.location.href = '{{ route("dashboard") }}';
            }
        },
        async submitLogin() {
            this.loading = true;
            this.errorMessage = '';
            try {
                const res = await fetch(window.API_BASE + '/api/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        email: this.email,
                        password: this.password
                    })
                });
                const data = await res.json();
                if (!res.ok) {
                    throw new Error(data.message || 'Identifiants invalides');
                }
                localStorage.setItem('auth_token', data.token);
                localStorage.setItem('user_name', data.user.name);
                localStorage.setItem('user_email', data.user.email);
                
                // Redirect to dashboard
                window.location.href = '{{ route("dashboard") }}';
            } catch (err) {
                this.errorMessage = err.message;
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>
@endsection
